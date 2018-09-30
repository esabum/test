<?php
//getMenus.php manages the three lists in mnuEditor.php
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
require_once APPROOT . '/config/menus/model/clsMenus.php';

$objMenu = new Menus;
$objMenu->set_TypeId($mnutype);
$objMenu->set_ShowAll(TRUE);
$objMenu->set_LanguageId($SelLang);
$objMenu->execute();

if ($mnutype==1){
?>
                                        <ol class="dd-list">
<?php
    for ($par = 0; $par < $objMenu->get_Count(); $par++) {
?>
                                            <li class="dd-item dd3-item" data-id="<?= $objMenu->get_ParentId($par) ?>">
                                                <div class="dd-handle dd3-handle"></div>
                                                <div class="dd3-content"><i class="<?= $objMenu->get_Icon($par) ?>"></i><?= $objMenu->get_Name($par) ?></div>
<?php
        if ($objMenu->get_SubCount($par)){
?>
                                                <ol class="dd-list">
<?php
            for ($sub = 0; $sub < $objMenu->get_SubCount($par); $sub++) {
?>
                                                    <li class="dd-item dd3-item" data-id="<?=$objMenu->get_SubId($par, $sub)?>">
                                                        <div class="dd-handle dd3-handle"></div>
                                                        <div class="dd3-content"><i class="<?= $objMenu->get_SubIcon($par, $sub) ?>"></i><?=$objMenu->get_SubName($par, $sub)?></div>
                                                    </li>
<?php
            }
?>
                                                </ol>
<?php
        }
?>
                                            </li>
<?php
    }
?>
                                        </ol>
<?php
}else{
?>
                                        <ol class="dd-list">
<?php
    for ($par = 0; $par < $objMenu->get_Count(); $par++) {
?>
                                            <li class="dd-item dd3-item" data-id="<?= $objMenu->get_ParentId($par) ?>">
                                                <div class="dd-handle dd3-handle"></div>
                                                <div class="dd3-content"><i class="<?= $objMenu->get_Icon($par) ?>"></i><?= $objMenu->get_Name($par) ?></div>
                                            </li>
<?php
        if ($objMenu->get_SubCount($par)){
            for ($sub = 0; $sub < $objMenu->get_SubCount($par); $sub++) {
?>
                                            <li class="dd-item dd3-item" data-id="<?=$objMenu->get_SubId($par, $sub)?>">
                                                <div class="dd-handle dd3-handle"></div>
                                                <div class="dd3-content"><i class="<?= $objMenu->get_SubIcon($par, $sub) ?>"></i><?=$objMenu->get_SubName($par, $sub)?></div>
                                            </li>
<?php
            }
        }
    }
?>
                                        </ol>
<?php
}
