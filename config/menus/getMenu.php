<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


foreach ($_GET as $key => $value) {
    $$key = $value;
}
foreach ($_POST as $key => $value) {
    $$key = $value;
}

require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/config/labels/model/clsLabel.php';
require_once APPROOT . '/config/menus/model/clsMenu.php';
require_once APPROOT . '/config/accesses/model/clsAccesses.php';

//Get Labels
$objLabel = New Labels;
$lblYes = $objLabel->get_Label("lblYes", $SelLang);
$lblNo = $objLabel->get_Label("lblNo", $SelLang);
$lblNew = $objLabel->get_Label("lblNew", $SelLang);
$lblSaveComplete = $objLabel->get_Label("lblSaveComplete", $SelLang);
$lblSaved = $objLabel->get_Label("lblSaved", $SelLang);
$lblErrorSave = $objLabel->get_Label("lblErrorSave", $SelLang);
$lblDeleted = $objLabel->get_Label("lblDeleted", $SelLang);
$lblCanceled = $objLabel->get_Label("lblCanceled", $SelLang);
$lblCancel = $objLabel->get_Label("lblCancel", $SelLang);
$lblSaveConfirm = $objLabel->get_Label("lblSaveConfirm", $SelLang);
$lblDeleteConfirm = $objLabel->get_Label("lblDeleteConfirm", $SelLang);
$lblLabel = $objLabel->get_Label("lblLabel", $SelLang);
$lblIcon = $objLabel->get_Label("lblIcon", $SelLang);
$lblSideMenu = $objLabel->get_Label("lblSideMenu", $SelLang);
$lblTopMenu = $objLabel->get_Label("lblTopMenu", $SelLang);
$lblAccessRights = $objLabel->get_Label('lblAccessRights', $SelLang);
$lblInsertLabel = $objLabel->get_Label('lblInsertLabel', $SelLang);
$lblHiddenMenuElements = $objLabel->get_Label('lblHiddenMenuElements', $SelLang);
$lblVisit = $objLabel->get_Label('lblVisit', $SelLang);
$lblMenus = $objLabel->get_Label('lblMenus', $SelLang);
$lblMenuCreation = $objLabel->get_Label('lblMenuCreation', $SelLang);
$lblURL = $objLabel->get_Label('lblURL', $SelLang);
$lblEmpty = $objLabel->get_Label('lblEmpty', $SelLang);
$lblName = $objLabel->get_Label('lblName', $SelLang);
$lblSave = $objLabel->get_Label('lblSave', $SelLang);

$objMenu = New Menu;
$objMenu->set_ID($id);
$objMenu->set_LanguageId($SelLang);
$objMenu->execute();
?>
                            <h4><b><?= $lblMenuCreation ?></b></h4>
                            <div class="col-md-7 form-group">
                                <label class="control-label col-sm-12 p-l-0">
                                    <?= $lblName ?>:
                                    <input id="id" type="hidden" value="<?=$id?>">
                                    <input id="label" type="text" class="form-control form-white" value="<?=$objMenu->get_Label_Name(0)?>">
                                </label>
                                <label class="control-label col-sm-12 p-l-0">
                                    <?= $lblIcon ?>:<br>
                                    <div class="col-sm-12 p-l-0 p-r-0">
                                        <input id="icon" type="text" name="name" class="form-control form-white" value="<?=$objMenu->get_Icon(0)?>">
                                        <!--<i style="left: 0px !important;" class="fas fa-question-circle c-blue" rel="popover" data-container="body" data-toggle="popover" data-placement="top" data-content="http://fontawesome.io/icons/" data-original-title="<?=$lblVisit?>:"></i>-->
                                    </div>
                                </label>
                                <label class="control-label col-sm-12 p-l-0">
                                    <?= $lblURL ?>:
                                    <input id="URL" type="text" class="form-control form-white" value="<?=$objMenu->get_URL(0)?>">
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="col-md-12">
                                    <p><b><?= $lblAccessRights ?>:</b></p>
                                    <div id ="accessCont">
<?php
$objAccess = new Accesses;
$objAccess->set_LanguageId($SelLang);
$objAccess->execute();
$checked = NULL;
$disabled = NULL;
for ($i = 0; $i < $objAccess->get_Count(); $i++) {
    //Disable checkboxes for unmodifiable accesses by current user
    if ($objBitCtrl->query_bit($Access, $objAccess->get_Bit($i)) || $objBitCtrl->query_bit($Access, 1)) {
        $disabled = NULL;
    } else {
        $disabled = ' disabled';
    }
    if ($objMenu->get_HasAccess(0, $objAccess->get_Bit($i))) {
        $checked = ' checked';
    }else{
        $checked = NULL;
    }
?>
                                            <p>
                                                <label>
                                                    <input id="access<?= $objAccess->get_Bit($i) ?>" type="checkbox" value="<?= $objAccess->get_Bit($i) ?>" name="access[]"<?= $checked ?><?= $disabled ?>>
                                                    &nbsp;<?= $objAccess->get_Name($i) ?>
                                                    <i data-original-title="<?= $objAccess->get_Name($i) ?>" data-content="<?= $objAccess->get_Description($i) ?>" data-placement="right" data-toggle="popover" data-container="body" rel="popover" class="icon-info"></i>
                                                </label>
                                            </p>
<?php
}
?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button id="new" class="btn btn-default"><?=$lblSave?></button>
                            </div>
 