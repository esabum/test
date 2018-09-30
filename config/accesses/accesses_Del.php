<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/config/accesses/model/clsAccessesW.php';

foreach ($_POST as $key => $val) {
    $$key = trim(htmlentities($val));
}
foreach ($_GET as $key => $val) {
    $$key = trim(htmlentities($val));
}

$objAccesses = new AccessesW;
$objAccesses->set_Bit($id);
$objAccesses->set_Language_Id($language_id);

$result = $objAccesses->delete();

    if ($result) {
        echo "1";
    } else {
        echo "0";
    }

