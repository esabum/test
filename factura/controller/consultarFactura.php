<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';

require_once APPROOT . '/config/certificados/model/clsEmisor.php';
$objEmisor = new Emisor();
$arrEmisorInfo = $objEmisor->getEmisorInfo($emisor_id);

require_once APPROOT . '/config/certificados/model/clsCertificado.php';
$objCertificado = new Certificado();
$objCertificado->setGrant_type('password');
$objCertificado->set_User_Id($emisor_id);
$objCertificado->getCertiInfo();
$Token = $objCertificado->getToken();
$ambiente = $objCertificado->getAmbiente();

if ($Token) {
    $paramsxml = array();
    $paramsxml['w'] = 'consultar';
    $paramsxml['r'] = 'consultarCom';
    $paramsxml['token'] = $Token;
    $paramsxml['clave'] = $numero;
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
    print_r($jsonmh);
    if (array_key_exists("resp", $jsonmh)) {
        if (array_key_exists("ind-estado", $jsonmh["resp"])) {
            /*
            
            if($jsonmh["resp"]["ind-estado"]=="procesando"){
                echo $jsonmh["resp"]["ind-estado"];
            }elseif($jsonmh["resp"]["ind-estado"]=="aceptado"){
                echo $jsonmh["resp"]["ind-estado"];
            }else{
                $xml=$jsonmh["resp"]["respuesta-xml"];
                echo $xml;
            }
             
             */
            echo "<h3>".$jsonmh["resp"]["ind-estado"]."</h3>";
            
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }    

}
