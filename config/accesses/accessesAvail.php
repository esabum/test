<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/config/accesses/model/clsAccessesVal.php';
foreach ($_POST as $key => $value) {
    $$key = trim(htmlentities($value));
}

//Get Details
$objAccessesVal = New AccessesVal();
$objAccessesVal->set_NewId($new_id);
$objAccessesVal->set_NewLang($new_lang);
echo $objAccessesVal->execute();

