<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/

define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
//include_once APPROOT.'/autoconf.php';
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/view/pageheader.php';
require_once APPROOT . '/config/labels/model/clsLabels.php';
//Get Languages
$obLangs = new Languages;
$obLangs->execute();
//Get Labels
$objLabels = New Label;
$objLabels->set_Filter('');
$objLabels->execute();

$objLabel = New Labels;
$lblYes = $objLabel->get_Label("lblYes", $SelLang);
$lblNo = $objLabel->get_Label("lblNo", $SelLang);
$lblEdit = $objLabel->get_Label("lblEdit", $SelLang);
$lblSave = $objLabel->get_Label("lblSave", $SelLang);
$lbldelete = $objLabel->get_Label("lbldelete", $SelLang);
$lblInvalidName = $objLabel->get_Label("lblInvalidName", $SelLang);
$lblNameExist = $objLabel->get_Label("lblNameExist", $SelLang);
$lblErrorSave = $objLabel->get_Label("lblErrorSave", $SelLang);
$lblName = $objLabel->get_Label("lblName", $SelLang);
$lblLabels = $objLabel->get_Label("lblLabels", $SelLang);
$lblNew = $objLabel->get_Label("lblNew", $SelLang);
$lblSaveComplete = $objLabel->get_Label("lblSaveComplete", $SelLang);
$lblSaved = $objLabel->get_Label("lblSaved", $SelLang);
$lblDeleted = $objLabel->get_Label("lblDeleted", $SelLang);
$lblCanceled = $objLabel->get_Label("lblCanceled", $SelLang);
$lblSaveConfirm = $objLabel->get_Label("lblSaveConfirm", $SelLang);
$lblDeleteConfirm = $objLabel->get_Label("lblDeleteConfirm", $SelLang);
?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-header">
                    <h2>
                        <i class="fas fa-wrench"></i>&nbsp;
                        <strong><?= $lblLabels ?></strong>
                    </h2>
                </div>
                <div class="panel-content pagination2 table-responsive">
                    <input type="button" value="<?= $lblNew ?>" class="btn btn-default" id="new" />
                    <table class="table table-hover no-footer table-striped dataTable" role="grid" id="lbltable">
                        <thead>
                            <tr>
                                <th><?= $lblName ?></th>
                                <?php
                                for ($i = 0; $i < $obLangs->get_Count(); $i++) {
                                    $lang = $obLangs->get_Name($i);
                                    echo "<th>$lang</th>";
                                }
                                ?>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $objLabels->get_Count(); $i++) {
                                $name = $objLabels->get_Label($i, 0);
                                $en = $objLabels->get_Label($i, 1);
                                $es = $objLabels->get_Label($i, 2);
                                $fr = $objLabels->get_Label($i, 3);
                                $du = $objLabels->get_Label($i, 4);
                                $it = $objLabels->get_Label($i, 5);
                                ?>
                                <tr id='<?= $name ?>'>
                                    <td id='<?= $name ?>'><?= $name ?></th>
                                    <td id='<?= $name ?>' ><?= $en ?></td>
                                    <td id='<?= $name ?>' ><?= $es ?></td>
                                    <td id='<?= $name ?>' ><?= $fr ?></td>
                                    <td id='<?= $name ?>'><?= $du ?></td>
                                    <td id='<?= $name ?>' ><?= $it ?></td>
                                    <td><button class="btn btn-sm btn-default edit"><?= $lblEdit ?></button></td>
                                    <td><button class="btn btn-sm btn-danger delete"><?= $lbldelete ?></button></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->
<?php
require_once APPROOT . '/view/pagefooter.php';
?>
<!-- BEGIN PAGE SPECIFIC SCRIPTS -->
<script src="/<?= APPBASE ?>assets/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
<script type="text/javascript">
    //Global variables
    var oTable = jQuery('#lbltable').dataTable({
        bAutoWidth: false,
        columnDefs: [{
                searchable: false,
                targets: [6, 7]
            }]
    });

    var newLine = 0;
    var ajax_result;
    var nEditing = null;

    //Restores the row to its previous settings, before editing. 
    function restoreRow(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = jQuery('>td', nRow);

        for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
            oTable.fnUpdate(aData[i], nRow, i, false);
        }
        //oTable.fnDraw();
    }

    //Inserts the textarea in the row to be edited
    function editRow(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = jQuery('td', nRow);
        jqTds[0].innerHTML = '<textarea style="width: 100%; border-width: 0px; padding: 0px;">' + aData[0] + '</textarea>';
        jqTds[1].innerHTML = '<textarea style="width: 100%; border-width: 0px; padding: 0px;">' + aData[1] + '</textarea>';
        jqTds[2].innerHTML = '<textarea style="width: 100%; border-width: 0px; padding: 0px;">' + aData[2] + '</textarea>';
        jqTds[3].innerHTML = '<textarea style="width: 100%; border-width: 0px; padding: 0px;">' + aData[3] + '</textarea>';
        jqTds[4].innerHTML = '<textarea style="width: 100%; border-width: 0px; padding: 0px;">' + aData[4] + '</textarea>';
        jqTds[5].innerHTML = '<textarea style="width: 100%; border-width: 0px; padding: 0px;">' + aData[5] + '</textarea>';
        jqTds[6].innerHTML = '<button class="btn btn-sm btn-success edit"><?= $lblSave ?></button>';
    }

    //Validates all the data before saving
    function save_validations(oTable, nRow) {
        var jqInputs = jQuery('textarea', nRow);
        var lblName = jQuery.trim(jqInputs[0].value);
        var error = "";
        var result = true;
        n = newLine;

        var lblNames = oTable.DataTable().columns().data()[0].map(function (tag) {
            return tag.toLowerCase();
        });

        /*second parameter of condition is used to determine if the user is trying to change the lblname,
         making the page validate the new lblname.*/
        if (lblName.length >= 3) { //checks if the inserted label name contains 3 o more characters
            if (nRow.id == '' || (jQuery.trim(jqInputs[0].value) != jQuery.trim(nRow.id))) {
                //validate_lblname(jqInputs[0].value, n);
                if (lblNames.indexOf(jqInputs[0].value.toLowerCase()) !== -1) {
                    showNoty('danger', '<?= $lblNameExist ?>');
                    result = false;
                }
            }
        } else {
            showNoty('danger', '<?= addslashes($lblInvalidName) ?>'); //addslashes is used to escape single quotes in French notifications.
            result = false;
        }
        if (result) {
            confirmNoty('warning', '<?= $lblSaveConfirm ?>', [
                {
                    button: 'btn-primary',
                    label: '<?= $lblYes ?>',
                    callfn: 'save_row();'
                }, {
                    button: 'btn-danger',
                    label: '<?= $lblNo ?>',
                    callfn: 'saveCancel();'
                }
            ]
                    );

        }
    }

    //This function is called in save_validations and determines if the new lblname already exists.
    function validate_lblname(lblname, nline) {
        var request = jQuery.ajax({
            type: "POST",
            url: "lblAvail.php", //file name
            data: "name=" + lblname + "&n=" + nline, //data
            async: false
        });

        request.done(function (msg) {
            ajax_result = (jQuery.trim(msg) == '0') ? false : true;
        });
    }

    //Saves the data and then updates the table
    function save_row() {
        var nRow = nEditing;
        var jqInputs = jQuery('textarea', nRow);
        jQuery.ajax({
            type: 'POST',
            url: "lblEditor_Upd.php",
            data: "id=" + nRow.id + "&name=" + encodeURIComponent(jqInputs[0].value) + "&en=" + encodeURIComponent(jqInputs[1].value) + "&es=" + encodeURIComponent(jqInputs[2].value) + "&fr=" + encodeURIComponent(jqInputs[3].value) + "&de=" + encodeURIComponent(jqInputs[4].value) + "&it=" + encodeURIComponent(jqInputs[5].value),
            success: function (server_response) {
                if (server_response) {
                    nRow.id = jqInputs[0].value;//updte the row with the new text in the name
                    oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                    oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                    oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                    oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                    oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
                    oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
                    oTable.fnUpdate('<button class="btn btn-sm btn-default edit"><?= $lblEdit ?></button>', nRow, 6, false);
                    if (newLine != 0) {
                        newLine = 0;
                        jQuery('#new').attr('disabled', false);
                        nEditing_new = null;
                    }
                    showNoty('success', '<?= $lblSaveComplete ?>');
                } else {
                    showNoty('danger', '<?= addslashes($lblErrorSave) ?>');
                }
            }//end success		
        });
        //document.getElementById('new').disabled = false;
        nEditing = null
        oTable.fnDraw();
    }

    function saveCancel() {
        var nRow = nEditing;
        showNoty('danger', '<?= $lblCanceled ?>');
        jQuery('#table-edit_new').attr('disabled', false);
        //debugger;
        if (jQuery.trim(nRow.id) != "") {
            restoreRow(oTable, nRow);
        } else {
            delete_row(oTable, nRow);
            jQuery('#table-edit_new').attr('disabled', false);
        }
    }

    function delete_row() {
        var nRow = nEditing;
        oTable.fnDeleteRow(nRow);
        if (nEditing_new == null) {
            jQuery.ajax({
                type: 'POST',
                url: "lblEditor_Del.php",
                data: "id=" + nRow.id,
                success: function () {
                    showNoty('success', '<?= $lblDeleted ?>');
                    /*
                     noty({
                     text: '<div class="alert alert-success"><p><strong><?= $lblDeleted ?></strong></p></div>',
                     layout: 'topRight', //or left, right, bottom-right...
                     theme: 'made',
                     maxVisible: 10,
                     animation: {
                     open: 'animated bounceIn',
                     close: 'animated bounceOut'
                     },
                     timeout: 3000
                     });*/
                }//end success		
            })//end ajax
        }
        if (newLine != 0) {
            newLine = 0;
            jQuery('#new').attr('disabled', false);
            nEditing_new = null;
        }
        nEditing = null;
    }

    jQuery(document).ready(function () {
        nEditing = null;
        nEditing_new = null;
        jQuery('#new').click(function (e) {
            e.preventDefault();

            var aiNew = oTable.fnAddData(['', '', '', '', '', '',
                '<button class="edit" href=""><?= $lblEdit ?></button>', '<button class="btn btn-sm btn-danger delete" href=""><?= $lbldelete ?></button>']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            //document.getElementById('new').disabled = true;
            if (nEditing != null && nEditing != nRow) {
                restoreRow(oTable, nEditing);
            }
            nEditing = nRow;
            nEditing_new = nRow;
            editRow(oTable, nRow);
            newLine = 1;
            jQuery('#new').attr('disabled', true);
        });

        jQuery(document).on('click', '#lbltable button.delete', function (e) {
            e.preventDefault();
            nEditing = jQuery(this).parents('tr')[0];
            //alert(nRow);
            confirmNoty('warning', '<?= $lblDeleteConfirm ?>', [
                {
                    button: 'btn-primary',
                    label: '<?= $lblYes ?>',
                    callfn: 'delete_row();'
                }, {
                    button: 'btn-danger',
                    label: '<?= $lblNo ?>',
                    callfn: 'showNoty("danger","<?= $lblCanceled ?>");'
                }
            ]
                    );
        });

        //Enables row edition
        jQuery(document).on('click', '#lbltable button.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = jQuery(this).parents('tr')[0];
            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                if (nEditing_new != null) {
                    delete_row(oTable, nEditing_new);
                    nEditing = nRow;
                    editRow(oTable, nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = nRow;
                    editRow(oTable, nRow);
                }
            } else {
                if (nEditing == nRow && this.innerHTML == "<?= $lblSave ?>") {
                    /* Editing this row and want to save it */
                    save_validations(oTable, nEditing);
                    //nEditing = nEditing =  null;
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            }
        });

        jQuery('#lbltable tbody').on('keydown', 'input,select,textarea', function (e) {
            if (e.keyCode == 27) {
                restoreRow(oTable, nEditing);
            }
        });
        jQuery('#lbltable_length').append("  ");
        jQuery('#lbltable_length').append(jQuery('#new'));

    });
</script>
<!-- END PAGE SPECIFIC SCRIPTS -->
</body>
</html>
