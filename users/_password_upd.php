<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

//require_once APPROOT . '/view/pageheader.php';


foreach ($_POST as $key => $val) {
    $$key = trim($val);
}
require_once APPROOT . '/model/userauth/SessMemHD.php';

$objAuth = new AuthUser;

require_once APPROOT . '/config/users/model/clsPassW.php';
$objPassW = new PassW;
$objPassW->set_userId($id);
$objPassW->set_newPass($pass_new);
$objPassW->set_oldPass($pass_old);

echo $objPassW->excute();


?>