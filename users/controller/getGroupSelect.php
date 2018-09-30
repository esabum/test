<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/users/model/clsGroupSelectList.php';

//Get Labels
require_once APPROOT . '/config/labels/model/clsLabel.php';
$objLabel = New Labels;
$lblUnassigned = $objLabel->get_Label("lblUnassigned", $SelLang);

$objGroups = new GroupSelectList();
$objGroups->set_UserId($UserId);
if (isset($selectedids)) {
    $objGroups->set_SelectedGroupIds($selectedids);
}
if (isset($groupids)) {
    $objGroups->set_GroupIds($groupids);
}
$objGroups->execute();
$results = array();
for ($i = 0; $i < $objGroups->get_Count(); $i++) {
    if ($objGroups->get_Count() && isset($selectedids) && in_array($objGroups->get_ID($i), $selectedids)) {
        $results[] = array(
            'id' => $objGroups->get_ID($i),
            'text' => $objGroups->get_Name($i, 'HTML'),
            'avatar' => "<img data-name='" . $objGroups->get_Initials($i, 'HTML') . "' data-char-count='3' data-font-size='40' data-seed='1' class='profile img-sm img-circle m-r-10'/>",
            'selected' => true
        );
    } else {
        $results[] = array(
            'id' => $objGroups->get_ID($i),
            'text' => $objGroups->get_Name($i, 'HTML'),
            'avatar' => "<img data-name='" . $objGroups->get_Initials($i, 'HTML') . "' data-char-count='3' data-font-size='40' data-seed='1' class='profile img-sm img-circle m-r-10'/>"
        );
    }
}
if (!isset($selectedids)) {
    $results[] = array(
        'id' => "0",
        'text' => $lblUnassigned,
        'avatar' => "<img src='/assets/images/avatars/group_icon.png' class='img-sm img-circle m-r-10 bg-gainsboro'/>",
        'selected' => true
    );
} else {
    $results[] = array(
        'id' => "0",
        'text' => $lblUnassigned,
        'avatar' => "<img src='/assets/images/avatars/group_icon.png' class='img-sm img-circle m-r-10 bg-gainsboro'/>"
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


