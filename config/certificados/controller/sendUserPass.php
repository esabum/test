<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';
/*
require_once APPROOT . '/model/userauth/clsGetSessionKey.php';
$objSessionKey = new SessionKey();
$objSessionKey->set_UserId($UserId);
$objSessionKey->set_Password($password);
//echo $UserId;
$sessionKeyUser = $objSessionKey->execute();
*/
require_once APPROOT . '/config/certificados/model/clsCertificado.php';
$objCertificado = new Certificado();
$objCertificado->setGrant_type('password');
$objCertificado->setClient_id($ambiente);
$objCertificado->setUsername($usuarioH);
$objCertificado->setPassword($passwH);
$objCertificado->set_User_Id($UserH);
echo $objCertificado->execute();

