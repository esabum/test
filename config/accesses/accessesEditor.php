<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/view/pageheader.php';
require_once APPROOT . '/config/labels/model/clsLabels.php';
require_once APPROOT . '/model/language/clsLangs.php';
require_once APPROOT . '/config/accesses/model/clsAccess.php';

$language_name=array();
$langsoption = '';
for($i=0;$i<$objLang->get_Count();$i++){
    $language_name[$objLang->get_ID($i)]=$objLang->get_Name($i);
    $langsoption .= "<option value =\"" . $objLang->get_ID($i) . "\">" . $objLang->get_Name($i) . "</option>";
}

//Get Labels
$objLabel = New Labels;
$lblYes = $objLabel->get_Label("lblYes", $SelLang);
$lblNo = $objLabel->get_Label("lblNo", $SelLang);
$lblEdit = $objLabel->get_Label("lblEdit", $SelLang);
$lblSave = $objLabel->get_Label("lblSave", $SelLang);
$lblDelete = $objLabel->get_Label("lblDelete", $SelLang);
$lblInvalidId = $objLabel->get_Label("lblInvalidId", $SelLang);
$lblIdExist = $objLabel->get_Label("lblIdExist", $SelLang);
$lblErrorSave = $objLabel->get_Label("lblErrorSave", $SelLang);
$lblName = $objLabel->get_Label("lblName", $SelLang);
$lblLabels = $objLabel->get_Label("lblLabels", $SelLang);
$lblNew = $objLabel->get_Label("lblNew", $SelLang);
$lblSaveComplete = $objLabel->get_Label("lblSaveComplete", $SelLang);
$lblSaved = $objLabel->get_Label("lblSaved", $SelLang);
$lblDeleted = $objLabel->get_Label("lblDeleted", $SelLang);
$lblCanceled = $objLabel->get_Label("lblCanceled", $SelLang);
$lblCancel = $objLabel->get_Label("lblCancel", $SelLang);
$lblSaveConfirm = $objLabel->get_Label("lblSaveConfirm", $SelLang);
$lblDeleteConfirm = $objLabel->get_Label("lblDeleteConfirm", $SelLang);
$lblAction = $objLabel->get_Label("lblAction", $SelLang);
$lblId = $objLabel->get_Label("lblId", $SelLang);
$lblLanguageId = $objLabel->get_Label("lblLanguageId", $SelLang);
$lblBankTransactionClasses = $objLabel->get_Label("lblBankTransactionClasses", $SelLang);
$lblInvalidName = $objLabel->get_Label("lblInvalidName", $SelLang);
$lblLangAndIdInUse = $objLabel->get_Label("lblLangAndIdInUse", $SelLang);
$lblDescription = $objLabel->get_Label("lblDescription", $SelLang);
$lblAccesses = $objLabel->get_Label("lblAccesses", $SelLang);
$lblImproperIdNumber = $objLabel->get_Label("lblImproperIdNumber", $SelLang);
 
$objAccess = New Access;
$objAccess->execute();
?>


<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-header">
                        <h2>
                            <i class="fas fa-tasks"></i>&nbsp;
                            <strong><?=$lblAccesses?></strong>
                        </h2>
                    </div>
                    <div class="panel-content pagination2 table-responsive">
                        <input id="table-edit_new" class="btn btn-default" type="button" value="<?=$lblNew?>">
                        <table class="table table-hover no-footer table-striped dataTable" role="grid"  id="table-editable" aria-describedby="table-editable_info">
                            <thead>
                                <tr>
                                    <th><?= $lblId ?></th>
                                    <th><?= $lblLanguageId ?></th>
                                    <th><?= $lblName ?></th>
                                    <th><?= $lblDescription ?></th>
                                    <th><?= $lblAction ?></th>
                                </tr>
                            </thead>
                            <tbody>
<?php

for ($i = 0; $i < $objAccess->get_Count(); $i++) {
    $id = $objAccess->get_Bit($i);
    $language_id = $objAccess->get_Language_Id($i);
    $name = $objAccess->get_Name($i);
    $description = $objAccess->get_Description($i);

?>

                    <tr id='<?= $id ?><?= $language_id ?>'>
                        <td><?= $id ?></td>
                        <td><?= $language_name[$language_id] ?></td>  
                        <td><?= $name ?></td>
                        <td><?= $description ?></td>
                        <td>
                            <button class="edit btn btn-sm btn-default" href="javascript:;">
                                <?=$lblEdit?>
                            </button>
                            <button class="delete btn btn-sm btn-danger" href="javascript:;">
                                <?=$lblDelete?>
                            </button>
                        </td>
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
<script src="/<?=APPBASE?>assets/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
    <script type="text/javascript">
    
        var oTable = jQuery('#table-editable').dataTable({
            "searching": false,
            "aLengthMenu": [
                    [10, 15, 20, - 1],
                    [10, 15, 20, "All"] // change per page values here
            ],
            "sDom" : "<'row'<'col-md-6 filter-left'l><'col-md-6'T>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "oTableTools" : {
            "sSwfPath": "/<?= APPBASE ?>assets/plugins/datatables/swf/copy_csv_xls_pdf.swf",
                    "aButtons":[
                    {
                    "sExtends":"pdf",
                            "mColumns":[0, 1, 2, 3],
                            "sPdfOrientation":"landscape"
                    },
                    {
                    "sExtends":"print",
                            "mColumns":[0, 1, 2, 3],
                            "sPdfOrientation":"landscape"
                    }, {
                    "sExtends":"xls",
                            "mColumns":[0, 1, 2, 3],
                            "sPdfOrientation":"landscape"
                    }, {
                    "sExtends":"csv",
                            "mColumns":[0, 1, 2, 3],
                            "sPdfOrientation":"landscape"
                    }
                    ]
            } //end oTableTools
        });
        
        jQuery('#table-edit_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
        jQuery('#table -edit_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

        var newLine = 0;
        var seltbl;
        var selrow;
        var nEditing = null;
        var nEditing_new = null;
        
        function restoreRow(oTable, nRow){
            var aData = oTable.fnGetData(nRow);
            var jqTds = jQuery('>td', nRow);
            var i=0;
            for (property in aData){
                //console.log( property );
                oTable.fnUpdate(aData[property], nRow, i, false);
                i++;
            }
        }
        
        function isPowerOf2(i){
            if (i <= 0) {
                return 0;
            }
            return !(i & (i-1));
        }    
    
        //Validates all the data before saving
        function save_validations(oTable, nRow) {
            selrow = nRow;
            seltbl = oTable;
            var jqInputs = jQuery('input', nRow);
            var jqSelects = jQuery('select', nRow);
            var new_id = jQuery.trim(jqInputs[0].value);
            var new_lang = jQuery.trim(jqSelects[0].value);
            var name = jQuery.trim(jqInputs[1].value);
            var rowCharId = selrow.id.substr(0,1); // // Returns the id. Example: 256.

            //The indexOf() method returns the position of the first occurrence of a specified value in a string.
            //This method returns -1 if the value to search for never occurs.

            if(new_id.length == 0 || isNaN(new_id) || !(new_id.indexOf('.')=== -1)){ //Error if id's length is left in blank, or if the id inserted in the table is not a number, or if a period has been entered.
                showNoty('danger', '<?= $lblInvalidId ?>');
            }else if ((!isPowerOf2(new_id)) || (new_id >= 65536)){ //Only numbers of the form (2^n) can be used, but not greater than 32768.
                showNoty('danger', '<?=$lblImproperIdNumber?>');
            }else if(name.length == 0) { // Error if no name is added. It is mandatory to type an access name.
                showNoty('danger', '<?= addslashes($lblInvalidName) ?>'); //addslashes is used to escape single quotes in French notifications.
            }else{ //Proceeds to further validations    
                jQuery.ajax({
                    type: "POST",
                    url: "accessesAvail.php", //file name
                    data: {
                        new_id: new_id,
                        new_lang: new_lang
                    },
                    success: function (data) {
                        if(rowCharId != new_id && data == ''){ //Error if the access id and language inserted are already in use by another access.
                            showNoty('danger', '<?= addslashes($lblLangAndIdInUse) ?>'); //addslashes is used to escape single quotes in French notifications.
                        }else{
                            confirmNoty('warning', '<?= $lblSaveConfirm ?>',[
                                {
                                    button: 'btn-primary',
                                    label: '<?= $lblYes ?>',
                                    callfn: 'save_row(seltbl, selrow);'
                                },{
                                    button: 'btn-danger',
                                    label: '<?= $lblNo ?>',
                                    callfn: 'saveCancel(seltbl, selrow);'
                                }
                            ]);
                        }
                    }
                });
            }
        }
        
        function save_row(oTable, nRow) {
            var jqInputs = jQuery('input', nRow);
            var jqSelects = jQuery('select', nRow);
            var rowId = jQuery.trim(jqInputs[0].value);
            var lang = jQuery.trim(jqSelects[0].value);
            jQuery.ajax({
                type: 'POST',
                url: '/<?= APPBASE ?>config/accesses/sendAccesses.php',
                data: {
                    id: jqInputs[0].value,
                    lang_id: jqSelects[0].value,
                    name: jqInputs[1].value,
                    description: jqInputs[2].value
                },
                success: function (server_response) {
                    if (server_response) {                           
                        nRow.id = rowId.concat(lang);
                        oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                        oTable.fnUpdate(jqSelects[0].value, nRow, 1, false);
                        oTable.fnUpdate(jqInputs[1].value, nRow, 2, false);
                        oTable.fnUpdate(jqInputs[2].value, nRow, 3, false);
                        oTable.fnUpdate("<button class='edit btn btn-sm btn-default' href='javascript:;'><?=$lblEdit?></button> <button class='delete btn btn-sm btn-danger' href='javascript:;'><?=$lblDelete?></button>", nRow, 4, false);
                        if (newLine != 0) {
                            newLine = 0;
                            jQuery('#table-edit_new').attr('disabled', false);
                            nEditing_new = null;
                        }
                        jQuery('#table-edit_new').attr('disabled', false);
                        showNoty('success', '<?= $lblSaveComplete ?>');
                    } else {
                        showNoty('danger', '<?= addslashes($lblErrorSave) ?>'); //addslashes is used to escape single quotes in French notifications.
                        jQuery('#table-edit_new').attr('disabled', false);
                    }
                }//end success		
            }); //end ajax
            //document.getElementById('new').disabled = false;
            nEditing = null;
            oTable.fnDraw();
        }
        
        //To edit an existing row in the DataTable
        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = jQuery('>td', nRow);
            
            jqTds[jqTds.length-5].innerHTML = '<input type="text" class="form-control small" value="' + aData[0] + '">';
            jqTds[jqTds.length-4].innerHTML = '<td><select title = "" tabindex="-1" id="LangID" class="form-control form-white" data-search="true" data-placeholder="" ><?=$langsoption?></select> </td>';
            jqTds[jqTds.length-3].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
            jqTds[jqTds.length-2].innerHTML = '<input type="text" class="form-control small" style="width: 520px" value="' + aData[3] + '">';
            jqTds[jqTds.length-1].innerHTML = '<div class=""><button class="edit btn btn-sm btn-success" href=""><?=$lblSave?></button> <button class="cancel btn btn-sm btn-danger" href=""><?=$lblCancel?></button></div>';
            
            //This function enables the row to enter edit mode, keeping its prior selected option in its drop-down (the one that had been previously saved). 
                var jqSelects = jQuery('select', nRow);
                jQuery('#LangID').find('option').filter(function() {
                    return jQuery.trim( jQuery(this).text() ) === aData[1];
                }).attr('selected','');
        }

        //New row created for adding a new access to the DataTable, when the "new" button is clicked.
        function editNewRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = jQuery('>td', nRow);
            
            jqTds[jqTds.length-5].innerHTML = '<input type="text" class="form-control small" value="' + aData[0] + '">';
            jqTds[jqTds.length-4].innerHTML = '<td><select title = "" tabindex="-1" id="LangID" class="form-control form-white" data-search="true" data-placeholder="" ><?=$langsoption?></select> </td>';
            jqTds[jqTds.length-3].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
            jqTds[jqTds.length-2].innerHTML = '<input type="text" class="form-control small" style="width: 520px" value="' + aData[3] + '">';
            jqTds[jqTds.length-1].innerHTML = '<div class=""><button class="edit btn btn-sm btn-success" href=""><?=$lblSave?></button> <button class="cancel btn btn-sm btn-danger" href=""><?=$lblCancel?></button></div>';
        }
        
        //If changes are not going to be saved (new accesses or modifications to existing rows), the table is restored and the record is deleted.
        function saveCancel(oTable, nRow){
            showNoty('danger', '<?= $lblCanceled ?>');
            jQuery('#table-edit_new').attr('disabled', false);
            //debugger;
            if(jQuery.trim(nRow.id)!= ""){
                restoreRow(oTable, nRow);
            } else {
                delete_row(oTable, nRow);
                jQuery('#table-edit_new').attr('disabled', false);
            }
        }

        //Creates a new row in order to add a new access.
        jQuery('#table-edit_new').click(function (e) {
            e.preventDefault();
            var aiNew = oTable.fnAddData(['', '<select title = "" tabindex="-1" id="LangID" class="form-control form-white" data-search="true" data-placeholder="" ><?=$langsoption?></select>', '', '',
                    '<p class="text-left"><button class="edit btn btn-sm btn-success" href=""><?=$lblSave?></button> <button class="cancel btn btn-sm btn-danger" href=""><?=$lblCancel?></button></p>'
            ]);
            var nRow = oTable.fnGetNodes(aiNew[0]);
             //document.getElementById('new').disabled = true;
            if (nEditing != null && nEditing != nRow){
                restoreRow(oTable, nEditing);
            }    
            nEditing = nRow;
            nEditing_new = nRow;
            jQuery('#table-edit_new').attr('disabled', true);
            editNewRow(oTable, nRow);
            newLine = 1;
        });

        //Row id and language id are used to identify and delete the row to be deleted. 
        function delete_row(oTable, nRow){
            oTable.fnDeleteRow(nRow);
            var id = nRow.id.substr(0, nRow.id.length - 1);
            var lang = nRow.id.substr(-1);
            if (nEditing_new == null){
                jQuery.ajax({
                    type: 'POST',
                    url: "accesses_Del.php",
                    data: {
                        id: id,
                        language_id: lang 
                    },
                    success: function () {
                        noty({
                            text        : '<div class="alert alert-success"><p><strong><?= $lblDeleted ?></strong></p></div>',
                            layout      : 'topRight', //or left, right, bottom-right...
                            theme       : 'made',
                            maxVisible  : 10,
                            animation   : {
                                open  : 'animated bounceIn',
                                close : 'animated bounceOut'
                            },
                            timeout: 3000
                        });
                    }//end success		
                });//end ajax
            }    
            if (newLine != 0){
                newLine = 0;
                jQuery('#table-edit_new').attr('disabled', false);
                nEditing_new = null;
            }
            nEditing = null;
        }

        //This cancel button restores the row that was being modified, or deletes the one that was about to be saved. No changes are saved.
        jQuery('#table-editable .cancel').live('click', function (e) {
            e.preventDefault();
            if (jQuery(this).parents('tr')[0].id == "") {
                var nRow = jQuery(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
            jQuery('#table-edit_new').attr('disabled', false);
        });

        //Enables row edition
        jQuery('#table-editable .edit').live('click', function (e) {
            e.preventDefault();
            /* Get the row as a parent of the link that was clicked on */
            var nRow = jQuery(this).parents('tr')[0];
            if (nEditing !== null && nEditing != nRow) {
                if(nEditing_new != null){
                    delete_row(oTable, nEditing_new);
                    nEditing = nRow;
                    editRow(oTable, nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = nRow;
                    editRow(oTable, nRow);
                }
            } else if (nEditing == nRow && this.innerHTML == "<?=$lblSave?>") {
                 /* This row is being edited and should be saved */
                save_validations(oTable, nEditing);
                //nEditing = null;
            } else {
                 /* No row currently being edited */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });

        //Deletes an existing row
        jQuery('#table-editable .delete').live('click', function (e) {
            var newLine;
            var nEditing = null;
            nEditing_new = null;
            e.preventDefault();
            var nRow = jQuery(this).parents('tr')[0];
            var n = noty({
                text        : '<div class="alert alert-warning"><p><strong><?= $lblDeleteConfirm ?></strong></p></div>',
                layout      : 'center', //or left, right, bottom-right...
                theme       : 'made',
                maxVisible  : 10,
                animation   : {
                open  : 'animated bounceIn',
                        close : 'animated bounceOut'
                },
                buttons: [
                {
                    addClass: 'btn btn-primary', text: '<?= $lblYes ?>', onClick: function($noty) {
                        $noty.close();
                        //oTable.fnDeleteRow(nRow);
                        delete_row(oTable, nRow);
                    }
                },
                {
                    addClass: 'btn btn-danger', text: '<?= $lblNo ?>', onClick: function($noty) {
                        $noty.close();
                        showNoty('danger', '<?= $lblCanceled ?>');
                    }
                }
                ],
                animation   : {
                    open  : 'animated bounceIn',
                    close : 'animated bounceOut'
                },
            });
        });
    
    </script>



<!-- END PAGE SPECIFIC SCRIPTS -->
</body>
</html>

 


