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
require_once APPROOT . '/config/certificados/model/clsUbicacion.php';
require_once APPROOT . '/config/certificados/model/clsTipoIdentificacion.php';
require_once APPROOT . '/config/certificados/model/clsPaises.php';

if(!isset($emisor_id)){
    $emisor_id = 0;
}

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

$objUbicacion = new Ubicacion();
$arrProv = $objUbicacion->getProvicias();

$obtProvincias = "";
//print_r($arrProv);
foreach ($arrProv as $vale) {
    $obtProvincias .= "<option value='" . $vale["codigo"] . "'>" . $vale["descripcion"] . "</option>";
}

$objTipoIden = new TipoIdentificacion();
$arrTiposIde = $objTipoIden->execute();
$opsTiposIde = "";
foreach ($arrTiposIde as $value) {
    $opsTiposIde .= "<option value='" . $value["id"] . "'>" . $value["descripcion"] . "</option>";
}

$objPaises = new Paises();
$arrPaises = $objPaises->execute();
$opsPais = "";
foreach ($arrPaises as $vale) {
    $opsPais .= "<option value='" . $vale["codigonumerico"] . "'>" . $vale["descripcion"] . " - " . $vale["codigonumerico"] . "</option>";
}
?>
<input type="hidden" id="emisor_id" value="<?=$emisor_id?>">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" class="form-control" id="tbxNombre" placeholder="" value="<?= "" ?>">
        </div>          
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Nombre comercial</label>
            <input type="text" class="form-control" id="tbxNomComercial" placeholder="" value="<?= "" ?>">
        </div>          
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Sucursal</label>
            <input type="text" class="form-control" id="tbxSucursal" placeholder="" value="<?= "" ?>">
        </div>             
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Número Sucursal</label>
            <input type="text" class="form-control" id="tbxNumSucursal" placeholder="" value="<?= "" ?>">
        </div>         
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Número de caja</label>
            <input type="text" class="form-control" id="tbxNumCaja" placeholder="" value="<?= "" ?>">
        </div>         
    </div>    
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Identifiación tributaria</label>
            <input type="text" class="form-control" id="tbxIdenTributaria" placeholder="" value="<?= "" ?>">
        </div>          
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Tipo de indentificación</label>
            <select class="form-control" id="dwnTipoIden">
                <?= $opsTiposIde ?>
            </select>
        </div>
    </div>    
    <div class="col-md-6">
        <div class="form-group">
            <label for="tbxIdenExtranj">Identificación extranjero</label>
            <input type="text" class="form-control" id="tbxIdenExtranj" placeholder="" value="<?= "" ?>">
        </div>              
    </div>   
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Código de país</label>
            <select class="form-control" id="dwnPais">
                <?= $opsPais ?>
            </select>  
        </div>        
    </div>       
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Teléfono</label>
            <input type="text" class="form-control" id="tbxTelef" placeholder="" value="<?= "" ?>">
        </div>         
    </div>      
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Correo electrónico</label>
            <input type="text" class="form-control" id="txbEmail" placeholder="" value="<?= "" ?>">
        </div>          
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Fax</label>
            <input type="text" class="form-control" id="tbxFax" placeholder="" value="<?= "" ?>">
        </div>         
    </div>   
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Provincia</label>
            <select class="form-control" id="dwnProvinc">
                <option value="0">&nbsp;</option>
                <?= $obtProvincias ?>
            </select>            
        </div>         
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Canton</label>
            <select class="form-control" id="dwnCantones">
                <option value="">&nbsp;</option>
            </select>  
        </div>          
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Distrito</label>
            <select class="form-control" id="dwnDistritos">
                <option value="">&nbsp;</option>
            </select>  
        </div>          
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Barrio</label>
            <select class="form-control" id="dwnBarrios">
                <option value="">&nbsp;</option>
            </select>  
        </div>          
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Otras señas</label>
            <input type="text" class="form-control" id="tbxOtrasSenias" placeholder="" value="<?= "" ?>">
        </div>          
    </div> 
</div>
<div class="col-md-12">      
    <button type="button" id="btnSaveEmisor" class="btn btn-primary"><?= $lblSave ?></button>
</div>

