<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/clientes/model/clsReceptor.php';

$objReceptor = new Receptor();
if ($objReceptor->insertUpdate($receptor)) {
    echo 1;
} else {
    echo 0;
}
//print_r($emisor);

