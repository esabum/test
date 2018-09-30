<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/config/labels/model/clsLabel.php';
require_once APPROOT . '/config/certificados/model/clsUbicacion.php';


//Get Labels 
$objLabel = New Labels;

$lblUser = $objLabel->get_Label('lblUser', $SelLang);
$lblPassword = $objLabel->get_Label('lblPassword', $SelLang);
$lblInfoHacienda = $objLabel->get_Label('lblInfoHacienda', $SelLang);
$lblAmbiente = $objLabel->get_Label('lblAmbiente', $SelLang);
$lblSave = $objLabel->get_Label('lblSave', $SelLang);
$lblTesting = $objLabel->get_Label('lblTesting', $SelLang);
$lblProduction = $objLabel->get_Label('lblProduction', $SelLang);



$objUbicacion = new Ubicacion();
$arrProv = $objUbicacion->getProvicias();

foreach ($arrProv as $vale) {
?>
    <option value="<?= $arrProv["codigo"] ?>"><?= $arrProv["descripcion"] ?></option>
<?php
}
?>

