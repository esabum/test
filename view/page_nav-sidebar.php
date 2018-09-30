<?php
require_once APPROOT . '/config/menus/model/clsMenus.php';
$objMenu = new Menus;
$objMenu->set_TypeId(1);
$objMenu->set_UserId($UserId);
$objMenu->set_LanguageId($SelLang);
$objMenu->execute();
for ($par = 0; $par < $objMenu->get_Count(); $par++) {
?>
                        <li class="tm <?= ($objMenu->get_URL($par)? 'nav-active':'nav-parent') ?>">
                            <a href="/<?=APPBASE?><?= ($objMenu->get_URL($par)?$objMenu->get_URL($par):'#') ?>">
                                <i class="<?= $objMenu->get_Icon($par) ?>"></i>
                                <span><?= $objMenu->get_Name($par) ?></span>
<?php
    if ($objMenu->get_SubCount($par)){
?>
                                <span class="fas fa-chevron-right pull-right arrow"></span>
<?php
    }
?>
                            </a>
<?php
    if ($objMenu->get_SubCount($par)){
?>
                            <ul class="children collapse">
<?php
        for ($sub = 0; $sub < $objMenu->get_SubCount($par); $sub++) {
?>
                                <li>
                                    <a href="/<?=APPBASE?><?=$objMenu->get_SubURL($par, $sub)?>"><?=$objMenu->get_SubName($par, $sub)?></a>
                                </li>
<?php
        }
?>
                            </ul>
<?php
    }
?>
                        </li>
<?php
}
?>
