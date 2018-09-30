<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
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

$objUsers = New Users;
$objUsers->set_ID($id);
$objUsers->execute();

//Get Labels 
$objLabel = New Labels;
$lblUsers = $objLabel->get_Label('lblUsers', $SelLang);
$lblName = $objLabel->get_Label('lblName', $SelLang);
$lblFirstName = $objLabel->get_Label('lblFirstName', $SelLang);
$lblLastName = $objLabel->get_Label('lblLastName', $SelLang);
$lblEmail = $objLabel->get_Label('lblEmail', $SelLang);
$lblDefaultLanguage = $objLabel->get_Label('lblDefaultLanguage', $SelLang);
$lblEnabled = $objLabel->get_Label('lblEnabled', $SelLang);
$lblAccessRights = $objLabel->get_Label('lblAccessRights', $SelLang);
$lblSave = $objLabel->get_Label("lblSave", $SelLang);
$lblNew = $objLabel->get_Label('lblNew', $SelLang);

?>
    <!--GetUsers.php llena el formulario "userform" de userEditor.php -->    
        <div class="col-md-6 m-b-20">
            <input type="hidden" value="<?= $id ?>" name="id" id="id" />
            <label class="tam" for="First"><?=$lblFirstName?></label>
            <input id="First" class="form-control form-white" type="text" value="<?= $objUsers->get_First(0) ?>"  size="8" maxlength="200" name="First">

            <label class="tam" for="Last"><?=$lblLastName?></label>
            <input id="Last" class="form-control form-white" type="text" value="<?= $objUsers->get_Last(0) ?>" size="8" maxlength="200" name="Last">

            <label class="tam" for="Email"><?=$lblEmail?></label>
            <input id="Email" class="form-control form-white" type="text" value="<?= $objUsers->get_Email(0) ?>" size="8" maxlength="200" name="Email">
            <div id="mail_status"></div> <!--Div para mostrar un mensaje al usuario, indicando si el correo ingresado es válido o inválido. -->

            <label class="tam" for="DefaultLanguage"><?=$lblDefaultLanguage?></label>
            <select title = "" tabindex="-1" id="LangID" class="form-control form-white" data-search="true" data-placeholder="" >
<?php
                for ($i = 0; $i < $objLangs->get_Count(); $i++) {
                    if ($objUsers->get_Language_Id(0) == $objLangs->get_ID($i)) {
                        echo "<option value='" . $objLangs->get_ID($i) . "' selected='selected'>" . $objLangs->get_Name($i) . "</option>";
                    }else{
                        echo "<option value='" . $objLangs->get_ID($i) . "'>" . $objLangs->get_Name($i) . "</option>";
                    }
                }
?>
            </select>

            <hr>
            <p>
                <label class="description" for="Enabled">
                    <?=$lblEnabled?>
                    <input id="Enabled" class="form-control form-white tbl" <?php if ($objUsers->get_Enabled(0) == 1 || $id == 0){ echo "checked";} ?> type="checkbox" value="1" checked="" name="Enabled">
                </label>
            </p>

            <input id="save" class="btn btn-default" type="button" value="<?=$lblSave?>">

        </div>
        <div class="col-md-6 m-b-20">
            <h2>
                <b><?=$lblAccessRights?></b>
            </h2>
            <div id ="accessCont">
<?php
$objAccess = new Accesses;
$objAccess->set_LanguageId($SelLang);
$objAccess->execute();
$checked = NULL;
$disabled = NULL;
for ($i = 0; $i < $objAccess->get_Count(); $i++) {
    //check checkboxes allready assigned accesses
    if ($objBitCtrl->query_bit($objUsers->get_Accesses(0), $objAccess->get_Bit($i))) {
        $checked = ' checked';
    } else {
        $checked = NULL;
    }
    // disable checkboxes for unmodifiable accesses by current user
    if ($objBitCtrl->query_bit($Access, $objAccess->get_Bit($i)) || $objBitCtrl->query_bit($Access, 1)) {
        $disabled = NULL;
    } else {
        $disabled = ' disabled';
    }
?>
            <p>
                <label>
                    <input id="access<?=$objAccess->get_Bit($i)?>" type="checkbox" value="<?=$objAccess->get_Bit($i)?>" name="access[]"<?=$checked?><?=$disabled?>>
                    &nbsp;<?=$objAccess->get_Name($i)?>
                    <i data-original-title="<?=$objAccess->get_Name($i)?>" data-content="<?=$objAccess->get_Description($i)?>" data-placement="right" data-toggle="popover" data-container="body" rel="popover" class="icon-info"></i>
                </label>
            </p>
<?php
}
?>
            </div>
        </div>
   


