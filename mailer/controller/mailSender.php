<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/mailer/model/clsQueue.php';
require_once APPROOT . '/mailer/assets/PHPMailer/class.phpmailer.php';
require_once APPROOT . '/model/clsCrypt.php';
$objCrypt = new Crypt();


$flag = false;
do {

    $flag = false;
    $objQueue = new MailsQueue();
    $MailerQueue = $objQueue->get_MailerQueue();
    if (count($MailerQueue) && $MailerQueue[0]['count'] > 0) {
        //echo "<h1>hola mundo</h1>";

        $MailerAccount = $objQueue->get_MailerAccount($MailerQueue[0]['lastid']);

        $mail = new phpmailer();
        $mail->CharSet = 'UTF-8';
        $mail->Mailer = $MailerAccount[0]['mailer'];
        $mail->SMTPAuth = $MailerAccount[0]['smtpauth'];
        $mail->Timeout = 30; //Prevents time outs.
        $mail->Username = $MailerAccount[0]['username'];
        $mail->Host = $MailerAccount[0]['host'];
        $mail->Password = trim($objCrypt->decrypt(rawurldecode($MailerAccount[0]['password'])));
        $mail->SMTPSecure = $MailerAccount[0]['smtpsecure'];
        $mail->Port = $MailerAccount[0]['port'];
        //$mail->CharSet = 'UTF-8';
        $mail->Subject = html_entity_decode($MailerAccount[0]['subject']);
        $mail->isHTML(TRUE);
        
        $mail->Body = html_entity_decode($MailerAccount[0]['body']);
        $mail->AltBody = html_entity_decode($MailerAccount[0]['altbody']);
        $mail->setFrom($MailerAccount[0]['username']);
        $mail->FromName = $MailerAccount[0]['fromname'];

        $MailerAddresses = $objQueue->get_MailerAddresses($MailerQueue[0]['lastid']);
        /*
          echo "<pre>";
          print_r($mail);
          echo "</pre>";
         */

        foreach ($MailerAddresses as $value) {
            switch ($value['type']) {
                case 1: #reply to
                    $mail->addReplyTo($value['address'], html_entity_decode($value['name']));
                    break;
                case 2: #to
                    $mail->addAddress($value['address'], $value['name']);
                    break;
                case 3: # cc
                    $mail->addCC($value['address'], $value['name']);
                    break;
                case 4: # bcc
                    $mail->addBCC($value['address'], $value['name']);
                    break;
                default : break;
            }
        }

        //$mail->addAddress("ernesto@aratours.com");

        if ($mail->Send()) {
            $objQueue->updateMailQueue($MailerQueue[0]['lastid']);
            echo "<h1>Enviado correctamente...</h1>";
            if ($MailerQueue[0]['count'] > 1) {
                $flag = true;
            }
        }
        else{
            echo "<h1>Error...</h1>";
        }
    }
} while ($flag);


