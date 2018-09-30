<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/view/pageheader.php';

require_once APPROOT . '/factura/model/clsGetConsecutivo.php';
$objGetConsecutivo = new GetConsecutivo();
$consec = $objGetConsecutivo->getConsecutivo($UserId, "factura");

require_once APPROOT . '/config/certificados/model/clsEmisor.php';
$objEmisor = new Emisor();
$arrEmisorInfo = $objEmisor->getEmisorInfo($UserId);

require_once APPROOT . '/clientes/model/clsReceptor.php';
/*
$objReceptor = new Receptor();
$arrreceptorInfo = $objReceptor->getReceptorInfo($factura['dwnCliente']);
*/
//print_r($arrreceptorInfo);

$params = array();
$params['w'] = 'clave';
$params['r'] = 'clave';
$params['tipoCedula'] = $arrEmisorInfo[0]['tipocedula'];
$params['codigoPais'] = $arrEmisorInfo[0]['codigopais'];
$params['consecutivo'] = $consec + 1;
$params['situacion'] = "normal";
$params['codigoSeguridad'] = mt_rand(10000000, 99999999);
$params['tipoDocumento'] = "FE";
$params['cedula'] = $arrEmisorInfo[0]['cedula'];
//print_r($params);
$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_URL, APIURL);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_POST, true);
curl_setopt($ch3, CURLOPT_POSTFIELDS, $params);
$result3 = curl_exec($ch3);
curl_close($ch3);
$json3 = json_decode($result3, true);
$clave = $json3['resp']['clave'];
$consecutivo = $json3['resp']['consecutivo'];
/*
$factura["clave"] = $clave;
$factura["consecutivo"] = $consecutivo;
*/

$objReceptor = new Receptor();
$objReceptor->execute($UserId);
$arrDataJson = $objReceptor->getDataJson();
$optRecept = "";
//print_r($arrProv);
foreach ($arrDataJson as $value) {
    $optRecept .= "<option value='" . $value["id"] . "'>" . $value["nombre"]." - " .$value["identificacion"]. "</option>";
}

require_once APPROOT . '/model/clsCondicionesVenta.php';
$objCondicionesVenta = new CondicionesVenta();
$objCondicionesVenta->execute();
$arrCondicionesVenta = $objCondicionesVenta->get_Json();
$optCondicionesVenta = "";
foreach ($arrCondicionesVenta as $value) {
    $optCondicionesVenta .= "<option value='" . $value["codigo"] . "'>" . $value["descripcion"] . "</option>";
}


require_once APPROOT . '/model/clsMedioPago.php';
$objMedioPago = new MedioPago();
$objMedioPago->execute();
$arrMedioPago = $objMedioPago->get_Json();
$optMedioPago = "";
foreach ($arrMedioPago as $value) {
    $optMedioPago .= "<option value='" . $value["codigo"] . "'>" . $value["descripcion"] . "</option>";
}


require_once APPROOT . '/model/clsUnidadMedida.php';
$objUnidadMedida = new UnidadMedida();
$objUnidadMedida->execute();
$arrUnidadMedida = $objUnidadMedida->get_Json();
$optUnidadMedida = "";
foreach ($arrUnidadMedida as $value) {
    $optUnidadMedida .= "<option value='" . $value["codigo"] . "'>" . $value["descripcion"] . "</option>";
}



require_once APPROOT . '/model/clsMoneda.php';
$objMoneda = new Moneda();
$objMoneda->execute();
$arrMoneda = $objMoneda->get_Json();
$optMoneda = "";
foreach ($arrMoneda as $value) {
    $optMoneda .= "<option value='" . $value["codigo"] . "' " . (($value["codigo"]=='CRC')? "selected" : "") .">" . $value["pais"] . " - " . $value["codigo"] . "</option>";
}
/* No changes above this point*/
/*
//ACCESS TO Pages
if (!$objBitCtrl->query_bit($Access, 16)){
    die();
}*/
//date_default_timezone_set("America/Costa_Rica");
$date = new DateTime("now", new DateTimeZone('America/Costa_Rica') );
$currentD = $date->format('Y-m-d H:i:s');
//Get Labels
//$lblName = $objLabel->get_Label("lblName", $SelLang);*/
?>
            <link href="/<?= APPBASE ?>assets/plugins/colorpicker/spectrum.css" rel="stylesheet" type="text/css" />
            <input type="hidden" id="UserId" value="<?=$UserId?>">
            <input type="hidden" id="claveFA" value="<?=$clave?>">
            <!-- BEGIN PAGE CONTENT -->
            
            <div class="modal fade" id="modalImprime" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center">Seleccione una opción</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" id="btnSendEmail" class="btn btn-primary">Enviar correo</button> 
                            <button type="button" id="btnDescargarComprobante" class="btn btn-primary">Descargar</button> 
                            <button type="button" class="btn btn-default" id="btnCloseModalImp">Close</button>   
                        </div>
                        <div class="modal-footer">
                         
                        </div>
                    </div>
                </div>
            </div>            

            <!-- Button trigger modal -->
            <div class="page-content p-20">
                <div class="row">
                    <div class="col-md-12 m-5">
                        <h2><b>Emisión de factura</b></h2>                            
                    </div>                        
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Cliente:</label>
                            <select class="form-control input-sm datoFact" id="dwnCliente">
                                <?= $optRecept ?>
                            </select>  
                        </div>          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Fecha:</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxFecha" value="<?=$currentD?>" disabled="true">                              
                        </div>          
                    </div>   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Documento No. :</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxConsecutivo" value="<?= $consecutivo ?>" disabled="true">                              
                        </div>          
                    </div>                         
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Condición de venta:</label>
                            <select class="form-control input-sm datoFact" id="dwnCondiVenta">
                                <?= $optCondicionesVenta ?>
                            </select> 
                        </div>          
                    </div>                      
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Plazo crédito:</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxPlazo" placeholder="" value="" disabled="true" maxlength="10">
                        </div>          
                    </div>                      
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Medio de pago:</label>
                            <select class="form-control input-sm datoFact" id="dwnMedioPago">
                                <?= $optMedioPago ?>
                            </select> 
                        </div>          
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Moneda:</label>
                            <select class="form-control input-sm datoFact" id="dwnMoneda" >
                                <?= $optMoneda ?>
                            </select> 
                        </div>          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tipo de cambio:</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxTipoCambio" placeholder="" value="<?= "1.00000" ?>" disabled="true" onblur="ValidaFormatoNumero(this,18,5)" onkeyup="return SoloNumerosPunto(this,18,5)" onkeypress="return validaPunto(this,event,18,5)">
                        </div>          
                    </div>                       
                </div>      
                <div class="row">
                    <div class="col-md-12">
                        <h3><b>Detalle del producto o servicio</b></h3>
                        <div id="divDetalleProducto">
                            <table class="table-bordered" id="tblDetalleProd" width="100%">
                                <thead>
                                  <tr >
                                    <th width="5%" style="text-align: center;">Cantidad</th>
                                    <th width="15%" style="text-align: center;">Unidad de medida</th>
                                    <th width="15%" style="text-align: center;">Detalle línea</th>
                                    <th width="10%" style="text-align: center;">Precio unitario</th>
                                    <th width="10%" style="text-align: center;">Descuento</th>
                                    <th width="15%" style="text-align: center;">Naturaleza descuento</th>
                                    <th width="8%" style="text-align: center;">Subtotal</th>
                                    <th width="8%" style="text-align: center;">Total</th>
                                    <th width="8%" style="text-align: center;">Total línea</th> 
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <table style="display: none">
                                <tbody>
                                  <tr id="filaEditable">
                                      <td width="5%" style="text-align: center;" class="colUnit"></td>
                                    <td width="15%" style="text-align: center;">                                    
                                        <select class="form-control input-sm datoFact" id="dwnunidadMedida">
                                        <?= $optUnidadMedida ?>
                                        </select> </td>
                                    <td width="15%" style="text-align: center;"></td>
                                    <td width="10%" style="text-align: center;" class="colPrecUnit"></td>
                                    <td width="10%" style="text-align: center;" class="colDescuento"></td>
                                    <td width="15%" style="text-align: center;" class="colNatDescuento"></td>
                                    <td width="8%" style="text-align: center;"  class="colSubTotal"></td>
                                    <td width="8%" style="text-align: center;"  class="colTotal"></td> 
                                    <td width="8%" style="text-align: center;"  class="colTotalLinea"></td> 
                                    <td width="4%" style="text-align: center;">
                                        <div class="btn-group pull-right">
                                        <button id="bEdit" type="button" class="btn btn-sm btn-default" onclick="rowEdit(this);"> 
                                        <span class="glyphicon glyphicon-pencil" > </span>
                                        </button>
                                        <button id="bElim" type="button" class="btn btn-sm btn-default" onclick="rowElim(this);"> 
                                        <span class="glyphicon glyphicon-trash" > </span>
                                        </button>
                                        <button id="bAcep" type="button" class="btn btn-sm btn-default" style="display:none;" onclick="rowAcep(this);">  
                                        <span class="glyphicon glyphicon-ok" > </span>
                                        </button>
                                        <button id="bCanc" type="button" class="btn btn-sm btn-default" style="display:none;" onclick="rowCancel(this);">  
                                        <span class="glyphicon glyphicon-remove" > </span>
                                        </button>
                                        </div>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>      
                        </div> 
                    </div>
                </div>      
                <div class="row m-t-20">                   
                    <div class="col-md-12 m-5">
                        <h3><b>Totales</b></h3>                           
                    </div>   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total servicios exentos:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_serv_exentos" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div>                     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total de servivios gravados:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_serv_gravados" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div>   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total mercadería exenta:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_merc_exenta" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total mercadería gravada:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_merc_gravada" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div>                           
                </div>      
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total_exentos:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_exentos" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div>                     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total gravados:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_gravados" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total ventas:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_ventas" placeholder="" value="<?= "0.00000" ?>"  disabled="true">
                        </div>          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total descuentos:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_descuentos" placeholder="" value="<?= "0.00000" ?>" disabled="true">
                        </div>          
                    </div>                          
                </div>           
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total ventas netas:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_ventas_neta" placeholder="" value="<?= "0.00000" ?>" disabled="true">
                        </div>          
                    </div>                     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total impuestos:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_impuestos" placeholder="" value="<?= "0.00000" ?>" disabled="true">
                        </div>          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total comprobante:</label>
                            <input type="text" class="form-control input-sm datoFact totales" id="tbxtotal_comprobante" placeholder="" value="<?= "0.00000" ?>" disabled="true">
                        </div>          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Comentarios:</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxotros" placeholder="" value="<?= "Muchas gracias" ?>" >
                        </div>          
                    </div>                        
                </div>  
                <div class="row">
 
                </div>              
                <button id="btnSaveFactura" class="btn btn-primary">Generar factura</button>
            </div>
            <!-- END PAGE CONTENT -->
<?php
require_once APPROOT . '/view/pagefooter.php';
?>
        <!-- BEGIN PAGE SPECIFIC SCRIPTS -->        
        <script type="text/javascript" src="/<?=APPBASE?>assets/plugins/colorpicker/spectrum.min.js"></script>        
        <script src="/<?=APPBASE?>assets/plugins/bootstable/bootstable.js" type="text/javascript"></script>
        <!-- END PAGE SPECIFIC SCRIPTS -->
        <script src="/factura/assets/factura.js" type="text/javascript"></script>
    </body>
</html>

