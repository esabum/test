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

?>
<div class="form">
    <div class="col-md-12">
        <div id="subirarchivo"></div> 
        <div class="form-group">
            <label for="">Clave :</label>
            <input type="text" class="form-control input-sm" id="tbxClaveCerti">                              
        </div>         
    </div>
    <div class="col-md-12">      
        <button type="button" id="btnSaveCert" class="btn btn-primary"><?=$lblSave?></button>
    </div>
</div>
<script>
loadUploader();
</script>


