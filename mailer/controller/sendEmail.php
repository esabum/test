<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/mailer/model/clsMailerQueue.php';

$lblTranport="Transportista";
$lblVehicle="Vehículo";
$lblYes="SÍ";
$lblNo="NO";
$lblPax="Pasajeros";
$lblDate="Fecha";
$lblTime="Hora";

$arrToEmails = array("esaco02@gmail.com");
$arrCcEmails = array("ernesto.saborio@latinconnect.com");

$pickupdate="09/01/2017";
$pickuptime="5:50";

$dropoffdate="09/01/2017";
$dropofftime="6:20";

$First = "Ernesto";//htmlentities($First, (int) $HTML_FLAG, "Windows-1252", true);
$Last = "Saborio"; //htmlentities($Last, (int) $HTML_FLAG, "Windows-1252", true);
$transport = "Trnsp./Transprosa S.A.";//htmlentities($Company, (int) $HTML_FLAG, "Windows-1252", true);
$pickup="Sleep Inn, Paseo de las Damas Hotel by Sleep Inn <br><b>$lblDate:</b>&nbsp;$pickupdate <br><b>$lblTime:</b>&nbsp;$pickuptime";
$dropoff="DE2235 @ 09:20, DE2235 @ 09.20 <br><b>$lblDate:</b>&nbsp;$dropoffdate<br><b>$lblTime:</b>&nbsp;$dropofftime";
$car="Nissan Urvan 2012 SJB 013119";
$question="¿Desea aceptar?";
$title="A continuación se detalla la solicitud del transporte para la fecha ";
$numPax="20";





#Subject and Body
//$mail->Subject = $subject;
$message = "<div marginwidth=\"0\" marginheight=\"0\" style=\"font:14px/20px 'Helvetica',Arial,sans-serif;margin:0;padding:75px 0 0 0;text-align:center;background-color:#eeeeee\">
    <center>
        <table border=\"0\" cellpadding=\"20\" cellspacing=\"0\" height=\"100%\" width=\"100%\"  style=\"background-color:#eeeeee\">
            <tbody>
                <tr>
                    <td align=\"center\" valign=\"top\">
                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:600px;border-radius:6px;background-color:none\">
                            <tbody>
                                <tr>
                                    <td align=\"center\" valign=\"top\">
                                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:600px\">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p style=\"font-size:22px;line-height:110%;margin-bottom:30px;margin-top:0;padding:0\">$transport<br><br>".$title."</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>                              
                                <tr>
                                    <td align=\"center\" valign=\"top\">
                                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:600px;border-radius:6px;background-color:#ffffff\" >
                                            <tbody>
                                                <tr>
                                                    <td align=\"left\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding:20px;font-weight: bold;border-bottom: 3px solid #bcb8b8;width:50%; \">
                                                        ".$lblVehicle.":
                                                    </td>
                                                    <td align=\"left\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding:20px; border-left: 1px solid #bcb8b8;border-bottom: 3px solid #bcb8b8;\">
                                                        ".$car."
                                                    </td>                                                      
                                                </tr>
                                                <tr>
                                                    <td align=\"left\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding:20px;font-weight: bold;border-bottom: 3px solid #bcb8b8;width:50%; \">
                                                        ".$lblPax.":
                                                    </td>
                                                    <td align=\"left\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding:20px; border-left: 1px solid #bcb8b8;border-bottom: 3px solid #bcb8b8;\">
                                                        ".$numPax."
                                                    </td>                                                      
                                                </tr>                                                
                                                <tr>
                                                    <td align=\"center\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding-top:10px;font-weight: bold; width:50%; \">
                                                        PICKUP
                                                    </td>
                                                    <td align=\"center\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding-top:10px; border-left: 1px solid #bcb8b8; font-weight: bold;\">
                                                        DROPOFF
                                                    </td>                                                      
                                                </tr>                                                  
                                                <tr>
                                                    <td align=\"left\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:10px;border-bottom: 3px solid #bcb8b8; width:50%; \">
                                                        ".$pickup."
                                                    </td>      
                                                    <td align=\"left\" valign=\"top\" style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:10px;border-bottom: 3px solid #bcb8b8; border-left: 1px solid #bcb8b8; \">
                                                        ".$dropoff."
                                                    </td>                                                  
                                                </tr>                                            
                                                <tr>
                                                    <td colspan='2' align='center' valign='top' style=\"line-height:150%;font-family:Helvetica;font-size:14px;color:#333333;padding:20px\">
                                                        <h2 style=\"font-size:22px;line-height:110%;margin-bottom:22px;margin-top:0;padding:0\">".$question."</h2>
                                                        <a href=\"http://www.aratours.com\" style=\"color:#ffffff!important;display:inline-block;font-weight:500;font-size:16px;line-height:42px;font-family:'Helvetica',Arial,sans-serif;width:auto;white-space:nowrap;height:42px;margin:12px 5px 12px 0;padding:0 22px;text-decoration:none;text-align:center;border:0;border-radius:3px;vertical-align:top;background-color:#FF9800!important; margin-right: 20px;\" target=\"_blank\">
                                                            ".$lblYes."
                                                        </a>
                                                        <a href=\"http://www.latinconnect.com\" style=\"color:#ffffff!important;display:inline-block;font-weight:500;font-size:16px;line-height:42px;font-family:'Helvetica',Arial,sans-serif;width:auto;white-space:nowrap;height:42px;margin:12px 5px 12px 0;padding:0 22px;text-decoration:none;text-align:center;border:0;border-radius:3px;vertical-align:top;background-color:#bcb8b8!important\" target=\"_blank\">
                                                            ".$lblNo."
                                                        </a>
                                                        <br>
                                                        <div>
                                                            <p style=\"padding:0 0 10px 0\">
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio mauris, egestas ut efficitur a, interdum eu velit. Aliquam eget ante ut nunc consectetur elementum vitae eget diam. Donec quis mi blandit ipsum mollis congue in eget ligula. 
                                                            </p>
                                                            <p style=\"padding:0 0 10px 0\">For questions about this list, please contact:
                                                                <br>
                                                                <a href=\"mailto:un-correo@dominio.com\" style=\"color:#336699\" target=\"_blank\">un-correo@dominio.com</a>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
</div>";

$objMailerQueue=new MailerQueue();
$objMailerQueue->set_Fromname("Transporte Ara Tours");
$objMailerQueue->set_Subject("Test");
$objMailerQueue->set_Body($message);
$objMailerQueue->set_Altbody($message);
$objMailerQueue->set_To($arrToEmails);
$objMailerQueue->set_Cc($arrCcEmails);
$objMailerQueue->set_Maileraccount(1);//type travel planner
$objMailerQueue->set_Replyto("ernesto@aratours.com", $First . " " . $Last);

try{
    $objMailerQueue->execute();
    $mailqueueId= $objMailerQueue->getMailId();
}catch(Exception $e){
    $flag = false;
}


function baseurl() {
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}


/*
require_once APPROOT . '/mailer/model/clsCrypt.php';
$objCrypt = new Crypt();
$passw = rawurlencode($objCrypt->encrypt("ctph1234"));

$file = fopen("archivo.txt", "w");

fwrite($file, $passw. PHP_EOL);


fclose($file);

echo "<h1>Hola mundo</h1>"." ". $passw;
 
 */