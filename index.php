<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/view/pageheader.php';
?>
<link href="/<?= APPBASE ?>assets/plugins/colorpicker/spectrum.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE CONTENT -->
<!-- Button trigger modal -->
<div class="page-content">

</div>
<!-- END PAGE CONTENT --> 
<?php
require_once APPROOT . '/view/pagefooter.php';
?>
<!-- BEGIN PAGE SPECIFIC SCRIPTS -->
<script type="text/javascript" src="/<?= APPBASE ?>assets/plugins/colorpicker/spectrum.min.js"></script>
<script src="/<?= APPBASE ?>assets/js/clipboard.js" type="text/javascript"></script> <!-- Copy to Clipboard Script -->        
<script type="text/javascript">
    /*jQuery(document).on('click', 'button.btn', function(){
     jQuery('.modal-body').html('<label class="form-label">Basic Color Picker</label><input style="display: inline-block;" class="color-picker form-control" data-color="#18A689" type="text">'); 
     });
     colorPicker();*/
</script>
<!-- END PAGE SPECIFIC SCRIPTS -->
</body>
</html>