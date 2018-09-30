<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/config/menus/model/clsMenuW.php';

foreach ($_POST as $key => $val) {
    $$key = $val;
}
foreach ($_GET as $key => $val) {
    $$key = $val;
}

//Get Menu Details
$objMenu = new MenuW;
$objMenu->set_Id($id);
$objMenu->set_LabelName($label);
$objMenu->set_Icon($icon);
$objMenu->set_URL($url);
if (isset($accessBits)) {
    $objMenu->set_AccessRights($accessBits);
}
$result = $objMenu->execute();
echo $result;


?>