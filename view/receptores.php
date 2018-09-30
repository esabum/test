<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/view/pageheader.php';
$objLabel = New Labels;
$lblUsers = $objLabel->get_Label('lblUsers', $SelLang);
$lblName = $objLabel->get_Label('lblName', $SelLang);
$lblAddNewUser = $objLabel->get_Label('lblAddNewUser', $SelLang);

$lblCredentials = $objLabel->get_Label('lblCredentials', $SelLang);
$lblCertificate = $objLabel->get_Label('lblCertificate', $SelLang);

$lblForm = $objLabel->get_Label('lblForm', $SelLang);
$lblEmisor = $objLabel->get_Label('lblEmisor', $SelLang);
$lblSave = $objLabel->get_Label('lblSave', $SelLang);

//$lblName = $objLabel->get_Label("lblName", $SelLang);*/
?>
            <link href="/<?= APPBASE ?>assets/plugins/colorpicker/spectrum.css" rel="stylesheet" type="text/css" />
            <!-- BEGIN PAGE CONTENT -->
            <!-- Button trigger modal -->
            <input type="hidden" id="UserId" value="<?=$UserId?>">
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" id="btnNewReceptor" class="btn btn-primary">Agregar nuevo cliente</button>
                    </div>
                    <div class="col-md-12">
                        <table class="table" id="tblReceptores">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Identificación</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th></th>                             
                                </tr>
                            </thead>
                        </table>
                    </div>    
                    <div class="col-md-12" id="modalForm">
                        
                    </div>      
                                                       
                </div>
            </div>
            <!-- END PAGE CONTENT -->
<?php
require_once APPROOT . '/view/pagefooter.php';
?>
        <!-- BEGIN PAGE SPECIFIC SCRIPTS -->
        <script src="/<?= APPBASE ?>assets/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->        
        <script type="text/javascript" src="/<?=APPBASE?>assets/plugins/colorpicker/spectrum.min.js"></script>        

        <!-- END PAGE SPECIFIC SCRIPTS -->
        <script src="/clientes/assets/clientes.js" type="text/javascript"></script>
    </body>
</html>

