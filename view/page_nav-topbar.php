<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once APPROOT . '/config/menus/model/clsMenus.php';
$objMenu = new Menus;
$objMenu->set_TypeId(2);
$objMenu->set_UserId($UserId);
$objMenu->set_LanguageId($SelLang);
$objMenu->execute();
for ($par = 0; $par < $objMenu->get_Count(); $par++) {
?>
                                <li>
                                    <a href="<?= ($objMenu->get_URL($par)?$objMenu->get_URL($par):'#') ?>">
                                        <span class="<?= $objMenu->get_Icon($par) ?>" title="<?= $objMenu->get_Name($par) ?>" data-id="<?= $objMenu->get_ParentId($par) ?>"></span>
                                    </a>
                                </li>
<?php
}
?>
