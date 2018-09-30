<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
/* Load values from .ini */

foreach ($_GET as $key => $value) {
    $$key = $value;
}
foreach ($_POST as $key => $value) {
    $$key = $value;
}

define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/config/users/model/userByEmail.php';

$objUserByEmail = new UserByEmail();
$objUserByEmail->set_Email($email);
$objUserByEmail->execute();
if($objUserByEmail->get_Count() > 0){
    echo 1;
}else{
    echo 0;
}