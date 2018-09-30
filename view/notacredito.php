<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/view/pageheader.php';

require_once APPROOT . '/factura/model/clsGetConsecutivo.php';
$objGetConsecutivo = new GetConsecutivo();
$consec = $objGetConsecutivo->getConsecutivo($UserId, "notacredito");

require_once APPROOT . '/config/certificados/model/clsEmisor.php';
$objEmisor = new Emisor();
$arrEmisorInfo = $objEmisor->getEmisorInfo($UserId);

require_once APPROOT . '/clientes/model/clsReceptor.php';
/*
$objReceptor = new Receptor();
$arrreceptorInfo = $objReceptor->getReceptorInfo($factura['dwnCliente']);
*/
//print_r($arrreceptorInfo);

$params = array();
$params['w'] = 'clave';
$params['r'] = 'clave';
$params['tipoCedula'] = $arrEmisorInfo[0]['tipocedula'];
$params['codigoPais'] = $arrEmisorInfo[0]['codigopais'];
$params['consecutivo'] = $consec + 1;
$params['situacion'] = "normal";
$params['codigoSeguridad'] = mt_rand(10000000, 99999999);
$params['tipoDocumento'] = "NC";
$params['cedula'] = $arrEmisorInfo[0]['cedula'];
//print_r($params);
$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_URL, APIURL);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_POST, true);
curl_setopt($ch3, CURLOPT_POSTFIELDS, $params);
$result3 = curl_exec($ch3);
curl_close($ch3);
$json3 = json_decode($result3, true);
$clave = $json3['resp']['clave'];
$consecutivo = $json3['resp']['consecutivo'];
/*
$factura["clave"] = $clave;
$factura["consecutivo"] = $consecutivo;
*/

//date_default_timezone_set("America/Costa_Rica");
$date = new DateTime("now", new DateTimeZone('America/Costa_Rica') );
$currentD = $date->format('Y-m-d H:i:s');
//Get Labels
//$lblName = $objLabel->get_Label("lblName", $SelLang);*/
?>
            <link href="/<?= APPBASE ?>assets/plugins/colorpicker/spectrum.css" rel="stylesheet" type="text/css" />
            <input type="hidden" id="UserId" value="<?=$UserId?>">
            <input type="hidden" id="claveNC" value="<?=$clave?>">
            <!-- BEGIN PAGE CONTENT -->
            <!--
            <div class="modal fade" id="modalImprime" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center">Seleccione una opción</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" id="btnSendEmail" class="btn btn-primary">Enviar correo</button> 
                            <button type="button" id="btnDescargarComprobante" class="btn btn-primary">Descargar</button> 
                            <button type="button" class="btn btn-default" id="btnCloseModalImp">Close</button>   
                        </div>
                        <div class="modal-footer">
                         
                        </div>
                    </div>
                </div>
            </div>            
-->
            <!-- Button trigger modal -->
            <div class="page-content p-20">
                    <div class="col-md-12 m-5">
                        <h2><b>Emisión de nota de crédito</b></h2>                            
                    </div>                        
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Comprobante de referencia:</label>
                            <select class="form-control input-sm datoFact" id="dwnCliente">
                                <?= "" ?>
                            </select>  
                        </div>          
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Fecha:</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxFecha" value="<?=$currentD?>" disabled="true">                              
                        </div>          
                    </div>   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Documento No. :</label>
                            <input type="text" class="form-control input-sm datoFact" id="tbxConsecutivo" value="<?= $consecutivo ?>" disabled="true">                              
                        </div>          
                    </div>                                             
                </div>
                
                <button id="btnSaveFactura" class="btn btn-primary">Generar factura</button>
            </div>
            <!-- END PAGE CONTENT -->
<?php
require_once APPROOT . '/view/pagefooter.php';
?>
        <!-- BEGIN PAGE SPECIFIC SCRIPTS -->        
        <script type="text/javascript" src="/<?=APPBASE?>assets/plugins/colorpicker/spectrum.min.js"></script>        
        <script src="/<?=APPBASE?>assets/plugins/bootstable/bootstable.js" type="text/javascript"></script>
        <!-- END PAGE SPECIFIC SCRIPTS -->
        <script src="/factura/assets/factura.js" type="text/javascript"></script>
    </body>
</html>

