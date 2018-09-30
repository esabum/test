<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/config/menus/model/clsMenusW.php';

foreach ($_POST as $key => $val) {
    $$key = $val;
}
foreach ($_GET as $key => $val) {
    $$key = $val;
}

$objMenusW = new MenusW;
$objMenusW->set_TypeId($type_id);
$objMenusW->set_Ids(flatten($json));
$objMenusW->set_Tree($json);
$objMenusW->execute();

function flatten(array $array) {
    $return = array();
    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; }); //array_walk_recursive applies a user function recursively to every memeber of an array.
    return $return;
}


?>