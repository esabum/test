<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/config/labels/model/clsLabel.php';
$objLabel = New Labels;
$lblEmailHeader = $objLabel->get_Label('lblEmailHeader', $SelLang);
$lblEmailBody = $objLabel->get_Label('lblEmailBody', $SelLang);
$lblUser = $objLabel->get_Label('lblUser', $SelLang);
$lblPassword = $objLabel->get_Label('lblPassword', $SelLang);
$lblWelcome = $objLabel->get_Label('lblWelcome', $SelLang);
$lblUserPasswordRecovery = $objLabel->get_Label('lblUserPasswordRecovery', $SelLang);

$lblSubjectNewUser = $objLabel->get_Label('lblSubjectNewUser', $SelLang);
$lblFromEmail = $objLabel->get_Label('lblFromEmail', $SelLang);

foreach ($_POST as $key => $val) {
    $$key = $val;
}
foreach ($_GET as $key => $val) {
    $$key = $val;
}

$accessbit = 0;
for ($i = 0; $i < count($access_bit); $i++) {
    $accessbit = $objBitCtrl->set_bit($accessbit, $access_bit[$i]);
}

$password = '';
if ($id == 0) {
//generation the new password
    $characters = 'BbCcDdFfGgHhJjKkLlMmNnPpQqRrSsTtUuVvWwXxYyZz123456789';

    for ($i = 0; $i < 10; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
}

require_once APPROOT . '/config/users/model/clsUsersW.php';
$objUsers = new UsersW;
$objUsers->set_Id($id);
$objUsers->set_Language_Id($language_id);
$objUsers->set_First($first);
$objUsers->set_Last($last);
$objUsers->set_Email($email);
$objUsers->set_Pass($password);
$objUsers->set_Enabled($enabled);
$objUsers->set_Access_Bit($accessbit);
$result = $objUsers->execute();
if ($id == 0 && is_numeric($result) && $result > 0) {
    require_once APPROOT . '/config/users/model/clsUsers.php';
    $objUser =  new Users;
    $objUser->set_ID($result);
    $objUser->execute();

    //First, last y el email son leídos directamente de la base de datos.
    $message = $lblEmailHeader . " " . $objUser->get_First(0) . " " . $objUser->get_Last(0) . ":\r\n";
    $message .= $lblEmailBody . "\r\n";
    $message .= $lblUser . ": " . $objUser->get_Email(0) . "\r\n";
    $message .= $lblPassword . ": " . trim($password) . "\r\n";

    require_once APPROOT . '/mailer/model/clsMailerQueue.php';
    
    $objMailerQueue=new MailerQueue();
    $objMailerQueue->set_Fromname($lblFromEmail);
    $objMailerQueue->set_Subject($lblSubjectNewUser);
    $objMailerQueue->set_Body($message);
    $objMailerQueue->set_Altbody($message);
    $objMailerQueue->set_To(array($objUser->get_Email(0)));
    //$objMailerQueue->set_Cc($arrCcEmails);
    $objMailerQueue->set_Maileraccount(1);//type travel planner
    //$objMailerQueue->set_Replyto("ernesto@aratours.com", $First . " " . $Last);      
}
echo $result;


