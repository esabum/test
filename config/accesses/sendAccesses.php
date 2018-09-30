<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/config/accesses/model/clsAccessesW.php';
    
foreach ($_POST as $key => $val) {
    $$key = trim(($val));
}

foreach ($_GET as $key => $val) {
    $$key = trim(($val));
}

//Get Details
$objAccessW = new AccessesW;
$objAccessW->set_Bit($id); //Bit is the id of accesses
$objAccessW->set_Language_Id($lang_id);
$objAccessW->set_Name($name);
$objAccessW->set_Description($description);

$result = $objAccessW->execute();

if ($result) { 
    echo "1";
} else {
    echo "0";
}

  