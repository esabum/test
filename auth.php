<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

foreach ($_GET as $key => $value) {
    $$key = trim($value);
}
foreach ($_POST as $key => $value) {
    $$key = trim($value);
}

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);



//SET COOKIES FOR AUTO LOGIN
require_once APPROOT . '/model/userauth/Zebra_Session.php';
if ($username || $password) {
    require_once APPROOT . '/model/userauth/clsUserAuth.php';
    $objUser = new AuthUser;
    $uuid = '';
    $uuid = $objUser->authenticate($username, $password);
    if ($uuid) {
        //echo $uuid;
        //authenticated
        $session = new Zebra_Session('FE-Ernesto', 'C?SZ4xyb:hAu(A8y', 10800);
        $_SESSION['uuid'] = $uuid;
        $_SESSION['sellang'] = $objUser->get_DefLangID();
        $_SESSION['userid'] = $objUser->get_ID();
        $_SESSION['email'] = $objUser->get_Email();
        $_SESSION['password'] = $password;
        echo 1;
    }
}
