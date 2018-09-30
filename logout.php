<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
define('APPURL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME']);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/model/userauth/Zebra_Session.php';
$session = new Zebra_Session('FE-Ernesto', 'C?SZ4xyb:hAu(A8y');
$session->stop();

header('Location: ' . APPURL . '/'.APPBASE.'login.php');
