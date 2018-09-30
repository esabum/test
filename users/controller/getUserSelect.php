<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


/*Load values from .ini*/
include_once 'dms/autoconf.php';
$ini_array = parse_ini_file(APPROOT . '/.' . TLSD . '.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('PARTNER', $ini_array["latinconnect"]["lc_partner"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/users/model/clsUserSelectList.php';

//Get Labels
require_once APPROOT . '/config/labels/model/clsLabel.php';
$objLabel = New Labels;
$lblUnassigned = $objLabel->get_Label("lblUnassigned", $SelLang);

$objUsers = new UserSelectList();
$objUsers->set_UserId($UserId);
if (isset($selectedids)) {
    $objUsers->set_SelectedUserIds($selectedids);
}
if (isset($groupids)) {
    $objUsers->set_GroupIds($groupids);
}
if (isset($adduserids)) {
    $objUsers->set_AddUserIds($adduserids);
}
$objUsers->execute();

$results = array();
for ($i = 0; $i < $objUsers->get_Count(); $i++) {
    if ($objUsers->get_Count() && isset($selectedids) && in_array($objUsers->get_ID($i), $selectedids)) {
        $results[] = array(
            'id' => $objUsers->get_ID($i),
            'text' => $objUsers->get_Name($i, 'HTML'),
            'avatar' => "<img data-name='" . $objUsers->get_Initials($i, 'HTML') . "' data-char-count='2' data-font-size='45' data-seed='2' class='profile img-sm img-circle m-r-10'/>",
            'selected' => true
        );
    } else {
        $results[] = array(
            'id' => $objUsers->get_ID($i),
            'text' => $objUsers->get_Name($i, 'HTML'),
            'avatar' => "<img data-name='" . $objUsers->get_Initials($i, 'HTML') . "' data-char-count='2' data-font-size='45' data-seed='2' class='profile img-sm img-circle m-r-10'/>"
        );
    }
}
if (!isset($selectedids)) {
    $results[] = array(
        'id' => "0",
        'text' => $lblUnassigned,
        'avatar' => "<img src='/assets/images/avatars/user_icon.png' class='img-sm img-circle m-r-10 bg-gainsboro'/>",
        'selected' => true
    );
} else {
    $results[] = array(
        'id' => "0",
        'text' => $lblUnassigned,
        'avatar' => "<img src='/assets/images/avatars/user_icon.png' class='img-sm img-circle m-r-10 bg-gainsboro'/>"
    );
}

$list = get_html_translation_table(HTML_ENTITIES);
unset($list['"']);
unset($list['<']);
unset($list['>']);
unset($list['&']);
$search = array_keys($list);
$values = array_values($list);
echo str_replace(array('<\/', '\/>'), array('</', '/>'), str_replace($values, $search, json_encode($results)));


