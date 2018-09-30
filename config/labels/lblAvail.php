<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/config/labels/model/clsLabels.php';
foreach ($_POST as $key => $value) {
    $$key = trim(htmlentities($value));
}

//Get Labels
$objLabel = New Label;
$objLabel->set_Filter('');
$objLabel->execute();

for ($i = 0; $i < $objLabel->get_Count(); $i++) {
    if ($name == $objLabel->get_Label($i, 0) && $n == 1) {
        echo '0';
        exit();
    }
}
echo '1';
exit();


