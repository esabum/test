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
require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/config/users/model/clsUsertheme.php';

$objTheme = new clsUsertheme;
$objTheme->set_userId($id);
$objTheme->set_theme($dataTheme);
echo $objTheme->execute($dataTheme, $id);




?>