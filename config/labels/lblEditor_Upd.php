<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


foreach ($_POST as $key => $val) {
    $$key = trim($val);
}

//extract form inputs
function printArray($array) {
    foreach ($array as $key => $val) {
        echo "$key => $val <br/>";
        if (is_array($val)) { //If $value is an array, print it as well!
            printArray($val);
        }
    }
}

require_once APPROOT . '/config/labels/model/clsLabelW.php';

$objLabelW = new LabelsWrite;
$languages = array($en, $es, $fr, $de, $it);
$result = $objLabelW->set_Label($id, $name, $languages);
if ($result) {
    echo $result;
} else {
    echo "0";
}



?>
