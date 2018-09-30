<?php

class Factura {

    protected $obj_bconn;
    protected $dbh;
    protected $flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute($factura) {


        $SQL = "INSERT INTO documentoelectronico(
                tipodocumento,
                emisor_id,
                receptor_id,
                moneda,
                condicionesventa,
                mediodepago,
                situacioncomprobante,
                fechaemision,
                consecutivo,
                clavenumerica,
                tipocambio,
                detalleprodserv,
                plazocredito,
                totalgravado,
                totalexento,
                totalventa,
                totaldescuentos,
                totalventaneta,
                totalimpuesto,
                totalcomprobante,
                xmlEnviadoBase64,
                respuestaMHBase64,
                fechacreacion,
                confirmaciontributacion,
                confirmacionobligadotributario,
                acuserecibido
                ) VALUES (
                '01',
                " . $factura["emisor_id"] . ",
                " . $factura["dwnCliente"] . ",
                '" . $factura["cod_moneda"] . "',
                '" . $factura["condicion_venta"] . "',
                '" . $factura["medio_pago"] . "',
                '1',
                '" . $factura['fechaemision'] . "',
                '" . $factura["consecutivo"] . "',
                '" . $factura['clave'] . "',
                '" . $factura["tipo_cambio"] . "',
                '" . $factura["detalles"] . "',
                '" . $factura["plazo_credito"] . "',
                " . $factura["total_gravados"] . ",
                " . $factura["total_exentos"] . ",
                " . $factura["total_ventas"] . ",
                " . $factura["total_descuentos"] . ",
                " . $factura["total_ventas_neta"] . ",
                " . $factura["total_impuestos"] . ",
                " . $factura["total_comprobante"] . ",
                '" . $factura["xmlEnviadoBase64"] . "',
                '" . $factura["respuestaMHBase64"] . "',
                NOW(),
                0,
                0,
                1);";
        $result = mysqli_query($this->dbh, $SQL);
        if ($result) {
            $this->createPDF($factura);
            require_once APPROOT . '/factura/model/clsGetConsecutivo.php';
            $objGetConsecutivo = new GetConsecutivo();
            $consec = $objGetConsecutivo->updateConsecutivo($factura['emisor_id'], "factura");
        }
        //echo $SQL;

        $ret = FALSE;
        if ($result) {
            $ret = TRUE;
        }
        return $ret;
    }

    public function createPDF($factura) {

        $SQL = "SELECT
          documentoelectronico.moneda,
          condicionesventa.decripcion,
          mediodepago.descripcion,
          emisorinfo.nombre,
          emisorinfo.nombrecomercial,
          emisorinfo.identificaciontributaria,
          emisorinfo.codigopais,
          emisorinfo.telefono,
          emisorinfo.correoelectronico,
          emisorinfo.provincia,
          emisorinfo.canton,
          emisorinfo.distrito,
          emisorinfo.barrio,
          emisorinfo.otrassenias,
          receptorinfo.nombre AS nombreRecep,
          receptorinfo.identificacion,
          receptorinfo.razonsocial,
          receptorinfo.nombrecomercial AS nombrecomercialRecep,
          receptorinfo.codigopais AS codigopaisRecep,
          receptorinfo.telefono AS telefonoRecep,
          receptorinfo.correoelectronico AS correoelectronicoRecep,
          receptorinfo.provincia AS provinciaRecep,
          receptorinfo.canton AS cantonRecep,
          receptorinfo.distrito AS distritoRecep,
          receptorinfo.barrio AS barrioRecep,
          receptorinfo.otrassenias AS otrasseniasRecep
        FROM
          documentoelectronico
          INNER JOIN (SELECT
              receptores.id,
              receptores.nombre,
              receptores.identificacion,
              receptores.razonsocial,
              receptores.nombrecomercial,
              receptores.codigopais,
              receptores.telefono,
              receptores.correoelectronico,
              codificacionubicacion.provincia,
              codificacionubicacion.canton,
              codificacionubicacion.distrito,
              codificacionubicacion.barrio,
              receptores.otrassenias
            FROM
              receptores
              INNER JOIN codificacionubicacion ON receptores.provincia = codificacionubicacion.provincia_id AND
                receptores.canton = codificacionubicacion.canton_id AND receptores.distrito = codificacionubicacion.distrito_id
                AND receptores.barrio = codificacionubicacion.barrio_id) AS receptorinfo ON documentoelectronico.receptor_id =
            receptorinfo.id
          INNER JOIN (SELECT
              emisor.id,
              emisor.nombre,
              emisor.nombrecomercial,
              emisor.identificaciontributaria,
              emisor.codigopais,
              emisor.telefono,
              emisor.correoelectronico,
              codificacionubicacion.provincia,
              codificacionubicacion.canton,
              codificacionubicacion.distrito,
              codificacionubicacion.barrio,
              emisor.otrassenias
            FROM
              emisor
              INNER JOIN codificacionubicacion ON emisor.provincia = codificacionubicacion.provincia_id AND emisor.canton =
                codificacionubicacion.canton_id AND emisor.distrito = codificacionubicacion.distrito_id AND emisor.barrio =
                codificacionubicacion.barrio_id) AS emisorinfo ON emisorinfo.id = documentoelectronico.emisor_id
          INNER JOIN condicionesventa ON documentoelectronico.condicionesventa = condicionesventa.codigo
          INNER JOIN mediodepago ON documentoelectronico.mediodepago = mediodepago.codigo
        WHERE
          documentoelectronico.clavenumerica ='" . $factura['clave'] . "';";

        $result = mysqli_query($this->dbh, $SQL);

        $comprobanteInfo = $result->fetch_row();


        $detProdServ = json_decode($factura["detalles"]);

        //print_r($factura["detalles"]);

        $rowsDetails = '';
        $countRows = count($detProdServ);
        for ($i = 0; $i < count($detProdServ); $i++) {
            $row1 = $detProdServ[$i]->{'cantidad'};
            $row2 = $detProdServ[$i]->{'unidadMedida'};
            $row3 = $detProdServ[$i]->{'precioUnitario'};
            $row4 = $detProdServ[$i]->{'detalle'};
            $row5 = $detProdServ[$i]->{'montoTotal'};
            $rowsDetails .= '<tr align="center">
                                <td width="10%">' . $row1 . '</td>
                                <td width="10%">' . $row2 . '</td>
                                <td width="10%">' . $countRows . '</td>  
                                <td width="14%">' . $row3 . '</td>
                                <td width="40%">' . $row4 . '</td>
                                <td width="16%">' . $row5 . '</td>
                            </tr> ';
        }

        $moneda = $comprobanteInfo[0];
        $condiPago = html_entity_decode($this->html($comprobanteInfo[1]));
        $metodoPago = html_entity_decode($this->html($comprobanteInfo[2]));
        $nombreEmi = html_entity_decode($this->html($comprobanteInfo[3]));
        $nombrecomercialEmi = html_entity_decode($this->html($comprobanteInfo[4]));
        $identificaciontributariaEmi = $comprobanteInfo[5];
        $codigopaisEmi = $comprobanteInfo[6];
        $telefonoEmi = $comprobanteInfo[7];
        $correoelectronicoEmi = $comprobanteInfo[8];
        $provinciaEmi = html_entity_decode($this->html($comprobanteInfo[9]));
        $cantonEmi = html_entity_decode($this->html($comprobanteInfo[10]));
        $distritoEmi = html_entity_decode($this->html($comprobanteInfo[11]));
        $barrioEmi = html_entity_decode($this->html($comprobanteInfo[12]));
        $otrasseniasEmi = html_entity_decode($this->html($comprobanteInfo[13]));
        $nombreRecep = html_entity_decode($this->html($comprobanteInfo[14]));
        $identificacionRecep = $comprobanteInfo[15];
        $razonsocialRecep = html_entity_decode($this->html($comprobanteInfo[16]));
        $nombrecomercialRecep = html_entity_decode($this->html($comprobanteInfo[17]));
        $codigopaisRecep = $comprobanteInfo[18];
        $telefonoRecep = $comprobanteInfo[19];
        $correoelectronicoRecep = $comprobanteInfo[20];
        $provinciaRecep = html_entity_decode($this->html($comprobanteInfo[21]));
        $cantonRecep = html_entity_decode($this->html($comprobanteInfo[22]));
        $distritoRecep = html_entity_decode($this->html($comprobanteInfo[23]));
        $barrioRecep = html_entity_decode($this->html($comprobanteInfo[24]));
        $otrasseniasRecep = html_entity_decode($this->html($comprobanteInfo[25]));


        //print_r($comprobanteInfo);

        require_once(APPROOT . '/assets/plugins/tcpdf/tcpdf.php');
        $date_ = strtotime($factura['fechaemision']);
        $html = '<h2 align="center">Factura Electrónica</h2>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td  width="40%">
                        <p><b>' . $nombreEmi . '</b></p>
                        <p><b>ID: </b>' . $identificaciontributariaEmi . '</p>
                        <p><b>Email: </b>' . $correoelectronicoEmi . '</p>  
                        <p><b>Tel: </b>' . $codigopaisEmi . ' ' . $telefonoEmi . '</p>                       
                    </td>
                    <td  width="40%">
                        <p>' . $provinciaEmi . ', ' . $cantonEmi . '</p>
                        <p>' . $distritoEmi . ', ' . $barrioEmi . '</p>
                        <p>' . $otrasseniasEmi . '</p>
                    </td>  
                    <td  width="20%">
                        
                    </td>                      
                </tr>
                <tr>
                    <td colspan="3" align="center"> 
                        <p></p>
                        <p align="center"  style="font-size: small;">Versión 1.0</p>
                        <p align="center"  style="font-size: small;">Autorizada mediante resolución Nº DGT-R-48-2016 del 7 de octubre de 2016</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <p></p>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>					
                    <td align="left" width="40%">
                        <p><b><span style="font-size: large;">Detalles del cliente</span></b></p>
                        <p>' . $nombreRecep . '</p>
                        <p><b>ID: </b>' . $identificacionRecep . '</p>                            
                        <p>' . $provinciaRecep . ', ' . $cantonRecep . '</p>
                        <p>' . $distritoRecep . ', ' . $barrioRecep . '</p>
                        <p>' . $otrasseniasRecep . '</p>
                        <p><b>Email: </b>' . $correoelectronicoRecep . '</p>
                        <p><b>Tel: </b>' . $codigopaisRecep . ' ' . $telefonoRecep . '</p>    
                        
                    </td>
                    <td align="left" width="59%">
                        <p><b><span style="font-size: large;">Detalles de pago</span></b></p>
                        <p><b>No. comprobante: </b>' . $factura["consecutivo"] . '</p>
                        <p><b>Clave: </b>' . $factura['clave'] . '</p>
                        <p><b>Fecha y hora de emisión: </b>' . $factura['fechaPDF'] . '</p>
                        <p><b>Medio de pago: </b>' . $metodoPago . '</p>
                        <p><b>Condición de pago: </b>' . $condiPago . ' ' . (($factura['condicion_venta'] == '02') ? $factura['plazo_credito'] : '') . '</p>
                        <p><b>Moneda: </b>' . $moneda . '</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p></p>
        <table border="1" cellspacing="0" cellpadding="0">
            <thead>						
                <tr align="center">
                    <th width="10%"><b>Cantidad</b></th>
                    <th width="10%"><b>Unid. Medida</b></th>	
                    <th width="10%"><b>Código</b></th>   
                    <th width="14%"><b>Precio Unitario</b></th> 
                    <th width="40%"><b>Descripción</b></th>
                    <th width="16%"><b>Total línea</b></th>
                </tr>
            </thead>
            <tbody>
                ' . $rowsDetails . '
            </tbody>								
        </table>      
        <p></p>
        <table cellspacing="0" cellpadding="0">
            <tbody>
                <tr>					
                    <td  colspan="4"></td>                  
                    <td align="left"><b>Subtotal</b></td>    
                    <td align="right">' . $factura["total_comprobante"] . '</td>                      
                </tr>            
                <tr>					
                    <td  colspan="4"></td>                  
                    <td align="left"><b>Ventas netas</b></td>    
                    <td align="right">' . $factura["total_comprobante"] . '</td>                      
                </tr>
                <tr>					
                    <td  colspan="4"></td>                  
                    <td align="left"><b>Descuento</b></td>    
                    <td align="right">- 0.00000</td>                      
                </tr>
                <tr>					
                    <td  colspan="4"></td>                  
                    <td align="left"><b>Impuesto</b></td>    
                    <td align="right">+ 0.00000</td>                      
                </tr>
                <tr>                    
                    <td  colspan="4"></td>     
                    <td  colspan="2">&nbsp;<hr></td> 
                </tr>
                <tr>					
                    <td  colspan="4"></td>                  
                    <td align="left"><b>Total</b></td>    
                    <td align="right">' . $factura["total_comprobante"] . '</td>                      
                </tr>                
            </tbody>
        </table>';
//echo $html;
        //$lines = 6;
// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetFont('times', '', 10);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();
        $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'
                    => 0)));
        $pdf->setHtmlVSpace($tagvs);
        $pdf->SetCellPadding(0);

// output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

// set style for barcode
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

// QRCODE,L : QR-CODE Low error correction

        $pdf->write2DBarcode($factura['clave'], 'QRCODE,L', 165, 140 + ($countRows * 5), 40, 40, $style, 'N');


// -----------------------------------------------------------------------------
        $pdf->lastPage();

// ---------------------------------------------------------
//Close and output PDF document
        //require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $pdf->Output(APPROOT . '/files/' . $factura['clave'] . '.pdf', 'F');
    }

    public function getEmisorInfo($userId) {
        $SQL = ";";

        $result = mysqli_query($this->dbh, $SQL);
        $json = null;
        while ($row = mysqli_fetch_row($result)) {
            $json[] = array(
                '' => ""
            );
        }

        return $json;
    }

    public function cc($data) {
        return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

    public function html($data) {
        return htmlentities($data, (int) $this->flags, "Windows-1252", true);
    }

}
