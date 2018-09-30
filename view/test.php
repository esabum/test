<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

$zip = new ZipArchive;
$tmp_file = APPROOT.'/files/factura.zip';
    if ($zip->open($tmp_file,  ZipArchive::CREATE)) {
        $zip->addFile(APPROOT.'/files/50626091800040209047300100001010000000063134864286.pdf', '50626091800040209047300100001010000000063134864286.pdf');
        $zip->addFile(APPROOT.'/files/50626091800040209047300100001010000000064195959860.pdf', '50626091800040209047300100001010000000064195959860.pdf');
        $zip->close();
        echo 'Archive created!';
        /*
        header('Content-disposition: attachment; filename=files.zip');
        header('Content-type: application/zip');
        readfile($tmp_file);
         
         */
   } else {
       echo 'Failed!';
   }






require_once APPROOT . '/view/pageheader.php';






/* No changes above this point*/
/*
//ACCESS TO Pages
if (!$objBitCtrl->query_bit($Access, 16)){
    die();
}*/

//Get Labels
//$lblName = $objLabel->get_Label("lblName", $SelLang);*/
?>
            <link href="/<?= APPBASE ?>assets/plugins/colorpicker/spectrum.css" rel="stylesheet" type="text/css" />
            <!-- BEGIN PAGE CONTENT -->
            <!-- Button trigger modal -->
            <div class="page-content">
                <div>Hola mundo!</div>
            </div>
            <!-- END PAGE CONTENT -->
<?php
require_once APPROOT . '/view/pagefooter.php';
?>
        <!-- BEGIN PAGE SPECIFIC SCRIPTS -->
        <script type="text/javascript" src="/<?=APPBASE?>assets/plugins/colorpicker/spectrum.min.js"></script>        
        <script type="text/javascript">
            jQuery(document).on('click', 'button.btn', function(){
               jQuery('.modal-body').html('<label class="form-label">Basic Color Picker</label><input style="display: inline-block;" class="color-picker form-control" data-color="#18A689" type="text">'); 
            });
            colorPicker();
        </script>
        <!-- END PAGE SPECIFIC SCRIPTS -->
    </body>
</html>

