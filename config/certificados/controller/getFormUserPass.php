<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/model/userauth/clsBitCtrl.php';
require_once APPROOT . '/config/labels/model/clsLabel.php';
require_once APPROOT . '/config/users/model/clsUsers.php';
require_once APPROOT . '/config/accesses/model/clsAccesses.php';
require_once APPROOT . '/model/language/clsLangs.php';

$objBitCtrl = new BitControl;

$objLangs = new Languages;
$objLangs->execute();



//Get Labels 
$objLabel = New Labels;

$lblUser = $objLabel->get_Label('lblUser', $SelLang);
$lblPassword = $objLabel->get_Label('lblPassword', $SelLang);
$lblInfoHacienda = $objLabel->get_Label('lblInfoHacienda', $SelLang);
$lblAmbiente = $objLabel->get_Label('lblAmbiente', $SelLang);
$lblSave = $objLabel->get_Label('lblSave', $SelLang);
$lblTesting = $objLabel->get_Label('lblTesting', $SelLang);
$lblProduction = $objLabel->get_Label('lblProduction', $SelLang);

require_once APPROOT . '/config/certificados/model/clsCertificado.php';
$objCertificado = new Certificado();
$objCertificado->set_User_Id($UserH);
$arrCertiInfo = $objCertificado->getCertiInfo();
$user_ = "";
$pass_ = "";
$amb_ = "";
if (count($arrCertiInfo) > 0) {
    $user_ = $arrCertiInfo[0]["usuario"];
    $pass_ = $arrCertiInfo[0]["password"];
    $amb_ = $arrCertiInfo[0]["ambiente"];
}
//print_r($arrCertiInfo);
//echo $objCertificado->execute();
?>
<div class="form">
    <div class="col-md-12">
        <div class="form-group">
            <label for="tbxUser"><?= $lblUser ?></label>
            <input type="text" class="form-control" id="tbxUser" placeholder="Usuario dado por hacienda" value="<?=$user_?>">
        </div>
        <div class="form-group">
            <label for="tbxPass"><?= $lblPassword ?></label>
            <input type="text" class="form-control" id="tbxPass" placeholder="Password dado por hacienda" value="<?=$pass_?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="dwnAmbiente"><?= $lblAmbiente ?></label>                        
            <select class="form-control" id="dwnAmbiente">
                <option value="api-stag" <?=($amb_ == "api-stag")? "selected" : "" ?>><?= $lblTesting ?></option>
                <option value="api-prod" <?=($amb_ == "api-prod")? "selected" : "" ?>><?= $lblProduction ?></option>
            </select>
        </div>        
        <button type="button" id="btnSaveUserPass" class="btn btn-primary"><?= $lblSave ?></button>
    </div>
</div>


