<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/factura/model/clsGetConsecutivo.php';
require_once APPROOT . '/factura/model/clsFactura.php';

$objGetConsecutivo = new GetConsecutivo();
$consec = $objGetConsecutivo->getConsecutivo($factura['emisor_id'], "factura");

require_once APPROOT . '/config/certificados/model/clsEmisor.php';
$objEmisor = new Emisor();
$arrEmisorInfo = $objEmisor->getEmisorInfo($factura['emisor_id']);

require_once APPROOT . '/clientes/model/clsReceptor.php';

$objReceptor = new Receptor();
$arrreceptorInfo = $objReceptor->getReceptorInfo($factura['dwnCliente']);

//print_r($arrreceptorInfo);
$fecha = explode(" ", $factura['tbxFecha']);
$fechaActual = $fecha[0] . "T" . $fecha[1] . "-06:00";
$factura['fechaemision'] = $fechaActual;
$factura['fechaPDF'] = $fecha[0] . " " . $fecha[1] ;
//$factura['fechacreacion']=$fechaActual;

$params = array();
$params['w'] = "genXML";
$params['r'] = "gen_xml_fe";
$params['clave'] = $factura['clave'];
$params['consecutivo'] = /* $consecutivo; */ $factura['consecutivo'];
$params['fecha_emision'] = $fechaActual;
$params['emisor_nombre'] = $arrEmisorInfo[0]['emisor_nombre'];
$params['emisor_tipo_indetif'] = $arrEmisorInfo[0]['emisor_tipo_indetif'];
$params['emisor_num_identif'] = $arrEmisorInfo[0]['emisor_num_identif'];
$params['nombre_comercial'] = $arrEmisorInfo[0]['nombre_comercial'];
$params['emisor_provincia'] = $arrEmisorInfo[0]['emisor_provincia'];
$params['emisor_canton'] = $arrEmisorInfo[0]['emisor_canton'];
$params['emisor_distrito'] = $arrEmisorInfo[0]['emisor_distrito'];
$params['emisor_barrio'] = $arrEmisorInfo[0]['emisor_barrio'];
$params['emisor_otras_senas'] = $arrEmisorInfo[0]['emisor_otras_senas'];
$params['emisor_cod_pais_tel'] = $arrEmisorInfo[0]['emisor_cod_pais_tel'];
$params['emisor_tel'] = $arrEmisorInfo[0]['emisor_tel'];
$params['emisor_cod_pais_fax'] = $arrEmisorInfo[0]['emisor_cod_pais_fax'];
$params['emisor_fax'] = $arrEmisorInfo[0]['emisor_fax'];
$params['emisor_email'] = $arrEmisorInfo[0]['emisor_email'];
$params['receptor_nombre'] = $arrreceptorInfo[0]['receptor_nombre']; //receptor_nombre
$params['receptor_tipo_identif'] = $arrreceptorInfo[0]['receptor_tipo_identif'];
$params['receptor_num_identif'] = $arrreceptorInfo[0]['receptor_num_identif'];
$params['receptor_provincia'] = $arrreceptorInfo[0]['receptor_provincia'];
$params['receptor_canton'] = $arrreceptorInfo[0]['receptor_canton'];
$params['receptor_distrito'] = $arrreceptorInfo[0]['receptor_distrito'];
$params['receptor_barrio'] = $arrreceptorInfo[0]['receptor_barrio'];
$params['receptor_otras_senas'] = $arrreceptorInfo[0]['receptor_otras_senas'];
$params['receptor_cod_pais_tel'] = $arrreceptorInfo[0]['receptor_cod_pais_tel'];
$params['receptor_tel'] = $arrreceptorInfo[0]['receptor_tel'];
$params['receptor_cod_pais_fax'] = $arrreceptorInfo[0]['receptor_cod_pais_fax'];
$params['receptor_fax'] = $arrreceptorInfo[0]['receptor_fax'];
$params['receptor_email'] = $arrreceptorInfo[0]['receptor_email'];
$params['condicion_venta'] = $factura['condicion_venta'];
$params['plazo_credito'] = $factura['plazo_credito'];
$params['medio_pago'] = $factura['medio_pago'];
$params['cod_moneda'] = $factura['cod_moneda'];
$params['tipo_cambio'] = $factura['tipo_cambio'];
$params['total_serv_gravados'] = $factura['total_serv_gravados'];
$params['total_serv_exentos'] = $factura['total_serv_exentos'];
$params['total_merc_gravada'] = $factura['total_merc_gravada'];
$params['total_merc_exenta'] = $factura['total_merc_exenta'];
$params['total_gravados'] = $factura['total_gravados'];
$params['total_exentos'] = $factura['total_exentos'];
$params['total_ventas'] = $factura['total_ventas'];
$params['total_descuentos'] = $factura['total_descuentos'];
$params['total_ventas_neta'] = $factura['total_ventas_neta'];
$params['total_impuestos'] = $factura['total_impuestos'];
$params['total_comprobante'] = $factura['total_comprobante'];
$params['otros'] = $factura['otros'];
$params['detalles'] = $factura['detalles'];
//print_r($params);

$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, APIURL);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_POST, true);
curl_setopt($ch1, CURLOPT_POSTFIELDS, $params);
$result = curl_exec($ch1);
curl_close($ch1);
$json1 = json_decode($result, true);

//print_r($json1);
$clavexml = $json1['resp']['clave'];
$xmlsinfirma = $json1['resp']['xml'];
if ($json1['resp'] != -1) {
//echo $xmlsinfirma;
//echo " \n-> ".$xmlsinfirma. " \n";


    require_once APPROOT . '/config/certificados/model/clsArchivo.php';
    $objArchivo = new Archivo();
    $objArchivo->set_User_Id($factura['emisor_id']);
    $arrArchivo = $objArchivo->getInfo();
    $nombre = "";
    $formato = "";
    $ruta = "";
    $clavearchivo = "";
    if (count($arrArchivo) > 0) {
        $nombre = $arrArchivo[0]["nombre"];
        $formato = $arrArchivo[0]["formato"];
        $ruta = $arrArchivo[0]["ruta"];
        $clavearchivo = $arrArchivo[0]["clave"];
    }

//print_r($arrArchivo);

    require_once APPROOT . '/model/Firmadohaciendacr.php';
    $fac = new Firmadocr();
// 01 FE
    $returnFile = $fac->firmar($ruta, $clavearchivo, $xmlsinfirma, "01");

    $factura['xmlEnviadoBase64'] = $returnFile;
//print_r($factura);

    require_once APPROOT . '/config/certificados/model/clsCertificado.php';
    $objCertificado = new Certificado();
    $objCertificado->setGrant_type('password');
    $objCertificado->set_User_Id($factura['emisor_id']);
    $objCertificado->getCertiInfo();
    $Token = $objCertificado->getToken();
    $ambiente = $objCertificado->getAmbiente();

    if ($Token && $returnFile) {
        $paramsxml = array();
        $paramsxml['w'] = 'send';
        $paramsxml['r'] = 'json';
        $paramsxml['token'] = $Token;
        $paramsxml['clave'] = $clavexml;
        $paramsxml['fecha'] = $fechaActual;
        $paramsxml['emi_tipoIdentificacion'] = $arrEmisorInfo[0]['emisor_tipo_indetif'];
        $paramsxml['emi_numeroIdentificacion'] = $arrEmisorInfo[0]['emisor_num_identif'];
        $paramsxml['recp_tipoIdentificacion'] = $arrreceptorInfo[0]['receptor_tipo_identif'];
        $paramsxml['recp_numeroIdentificacion'] = $arrreceptorInfo[0]['receptor_num_identif'];
        $paramsxml['comprobanteXml'] = $returnFile;
        $paramsxml['client_id'] = $ambiente;

        //print_r($paramsxml);

        $chMH = curl_init();
        curl_setopt($chMH, CURLOPT_URL, APIURL);
        curl_setopt($chMH, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chMH, CURLOPT_POST, true);
        curl_setopt($chMH, CURLOPT_POSTFIELDS, $paramsxml);
        $resultmh = curl_exec($chMH);
        curl_close($chMH);
        $jsonmh = json_decode($resultmh, true);
        //print_r($jsonmh);
        if ($jsonmh["resp"]["Status"] == "202") {
            $factura["respuestaMHBase64"] = "";
            $objFactura = new Factura();
            if($objFactura->execute($factura)){
                echo $clavexml;
            }else{
                echo "0";
            }
        } else {
            echo "0";
        }
    } else {
        echo "0";
    }
} else {
    echo "0";
}