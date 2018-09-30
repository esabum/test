<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
//include_once APPROOT.'/autoconf.php';
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/view/pageheader.php';
require_once APPROOT . '/config/accesses/model/clsAccesses.php';
require_once APPROOT . '/config/menus/model/clsMenu.php';

/*
  //ACCESS TO Pages
  if (!$objBitCtrl->query_bit($Access, 16)){
  die();
  } */

//Get Labels
$objLabel = New Labels;
$lblYes = $objLabel->get_Label("lblYes", $SelLang);
$lblNo = $objLabel->get_Label("lblNo", $SelLang);
$lblNew = $objLabel->get_Label("lblNew", $SelLang);
$lblSaveComplete = $objLabel->get_Label("lblSaveComplete", $SelLang);
$lblSaved = $objLabel->get_Label("lblSaved", $SelLang);
$lblErrorSave = $objLabel->get_Label("lblErrorSave", $SelLang);
$lblDeleted = $objLabel->get_Label("lblDeleted", $SelLang);
$lblCanceled = $objLabel->get_Label("lblCanceled", $SelLang);
$lblCancel = $objLabel->get_Label("lblCancel", $SelLang);
$lblSaveConfirm = $objLabel->get_Label("lblSaveConfirm", $SelLang);
$lblDeleteConfirm = $objLabel->get_Label("lblDeleteConfirm", $SelLang);
$lblLabel = $objLabel->get_Label("lblLabel", $SelLang);
$lblIcon = $objLabel->get_Label("lblIcon", $SelLang);
$lblSideMenu = $objLabel->get_Label("lblSideMenu", $SelLang);
$lblTopMenu = $objLabel->get_Label("lblTopMenu", $SelLang);
$lblAccessRights = $objLabel->get_Label('lblAccessRights', $SelLang);
$lblInsertLabel = $objLabel->get_Label('lblInsertLabel', $SelLang);
$lblHiddenMenuElements = $objLabel->get_Label('lblHiddenMenuElements', $SelLang);
$lblVisit = $objLabel->get_Label('lblVisit', $SelLang);
$lblMenus = $objLabel->get_Label('lblMenus', $SelLang);
$lblMenuCreation = $objLabel->get_Label('lblMenuCreation', $SelLang);
$lblURL = $objLabel->get_Label('lblURL', $SelLang);
$lblEmpty = $objLabel->get_Label('lblEmpty', $SelLang);
$lblName = $objLabel->get_Label('lblName', $SelLang);

$objMenu = New Menu;
$objMenu->set_ID(-1);
$objMenu->set_LanguageId($SelLang);
$objMenu->execute();
$menuoptions = "<option value =\"0\">" .  $lblInsertLabel  . "</option>";
for ($i = 0; $i < $objMenu->get_Count(); $i++) {
    $menuoptions .= "<option value =\"" . $objMenu->get_ID($i) . "\">" . $objMenu->get_Name($i) . "</option>";
}

?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-header">
                    <h2><i class="fas fa-wrench"></i> <strong><?= $lblMenus ?> </strong></h2>
                </div>
                <div class="panel-content">
                        <div class="col-md-12">
                            <label  for="MenuId"><?= $lblMenus ?>:</label>
                            <select title = "" tabindex="-1" id="MenuId" class="form-control form-white" data-search="true" data-placeholder="" ><?=$menuoptions?></select>
                        </div>
                    <div class="row">
                        <div id="form" class="col-md-12">

                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <!--Menu lists-->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 border-right">
                                    <h4><b><?=$lblHiddenMenuElements ?>:</b></h4>
                                    <div id='nonlist' class="dd" rel='0'>
                                    </div>
                                </div>

                                <div class="col-md-4 border-right">
                                    <h4><b><?= $lblSideMenu ?>:</b></h4>
                                    <div id='sidelist' class="dd nestable" rel='1'>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <h4><b><?= $lblTopMenu ?>:</b></h4>
                                    <div id='toplist' class="dd" rel='2'>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-12 m-t-20">
                            <div class="clear"></div>
                        </div>
                        <!--FIN Menu lists-->

                    </div>
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
    <script type="text/javascript" src="/<?= APPBASE ?>assets/plugins/jquery-ui/jquery.nestable.js"></script>        
    <script type="text/javascript">
        /*jQuery(document).on('click', 'button.btn', function () {
            jQuery('.modal-body').html('<label class="form-label">Basic Color Picker</label><input style="display: inline-block;" class="color-picker form-control" data-color="#18A689" type="text">');
        });
        colorPicker();*/
        
        //Nonlist contains menus which have type '0' in its properties.
        jQuery('#nonlist').nestable({
            maxDepth: 1, //No sublists ar allowed. All elements remain at the same level.
            callback: function(l,e){
                // l is the main container
                // e is the element that was moved
                save_lists(jQuery('#'+l.attr('id')).nestable('serialize'), l.attr('rel'));
            }
        });
        
        //Sidelist contains menus which have type '1' in its properties.
        jQuery('#sidelist').nestable({
            maxDepth: 2, //Supports sublists. Two-level menus are allowed: a menu with submenus below it.
            callback: function(l,e){
                // l is the main container
                // e is the element that was moved
                save_lists(jQuery('#'+l.attr('id')).nestable('serialize'), l.attr('rel'));
            }
        });
        
        //Toplist contains menus which have type '2' in its properties.
        jQuery('#toplist').nestable({
            maxDepth: 1, //No sublists ar allowed. All elements remain at the same level.
            callback: function(l,e){
                // l is the main container
                // e is the element that was moved
                save_lists(jQuery('#'+l.attr('id')).nestable('serialize'), l.attr('rel'));
            }
        });
        
        function save_lists(json, type) {
            jQuery.ajax({
                url: 'sendMenus.php',
                type: 'POST',
                data: {
                    json: json,
                    type_id: type
                }/*,
                success: function (data) {
                    jQuery('#form').html(data);
                    popover();
                }*/
            });
        }
        
        jQuery(document).on('change', '#MenuId', function(){
            change_menus();
        });
        
        jQuery(document).ready(function (jQuery) {
            change_menus();
            change_lists();
        });

        //Change_menus() loads menu data to the form regarding its name, icon, URL and access rights, or prepares a blank form for creating a new menu.
        function change_menus() {
            jQuery.ajax({
                url: 'getMenu.php',
                type: 'POST',
                data: {
                    id: jQuery('#MenuId').val()
                },
                success: function (data) {
                    jQuery('#form').html(data);
                    popover();
                }
            });
        }
        
        //Change_lists() updates the three lists in mnuEditor.php
        function change_lists() {
            jQuery.ajax({
                url: 'getMenus.php',
                type: 'POST',
                data: {
                    mnutype: 0
                },
                success: function (data) {
                    jQuery('#nonlist').html(data);
                    popover();
                }
            });
            jQuery.ajax({
                url: 'getMenus.php',
                type: 'POST',
                data: {
                    mnutype: 1
                },
                success: function (data) {
                    jQuery('#sidelist').html(data);
                    popover();
                }
            });
            jQuery.ajax({
                url: 'getMenus.php',
                type: 'POST',
                data: {
                    mnutype: 2
                },
                success: function (data) {
                    jQuery('#toplist').html(data);
                    popover();
                }
            });
        }
        
        function saveMenu(){
            var checkAccessEle = jQuery("#accessCont input:checked");
            var dataAccess = [];
            checkAccessEle.each(function (i) {
                dataAccess.push(checkAccessEle[i].value);
            }); //Only checked rights are pushed into the "dataAccess" array.

            var label = jQuery('#label').val();
            var icon = jQuery('#icon').val();
            var url = jQuery('#URL').val();
            var id = jQuery('input#id').val();
          
            //If the user does not provide a label, the menu creation process stops and a notification will show up asking for one. 
            if(label.length == 0) {
                showNoty('danger', '<?= $lblInsertLabel ?>');
            } else {
                jQuery.ajax({
                    type: 'POST',
                    url: '/<?= APPBASE ?>config/menus/sendMenu.php',
                    data:{
                       id: id, 
                       label: jQuery('#label').val(),
                       icon: jQuery('#icon').val(),
                       url: jQuery('#URL').val(),
                       accessBits: dataAccess
                    },
                    success: function(data){
                        if (data > 0){
                            if (jQuery('#MenuId').val()==0){ //If menu id= 0 (it only happens when a new menu is about to be created), the drop-down must be updated immediately. 
                                var option = jQuery('<option></option>').attr('selected', true).text(jQuery('#label').val()).val(data);
                                option.appendTo(jQuery('#MenuId')); //appendTo adds the newly created menu to the #MenuId drop-down.
                                jQuery('#MenuId').trigger('change');
                            }
                            showNoty('success', '<?= $lblSaveComplete ?>');
                        } else { 
                            showNoty('danger', '<?= addslashes($lblErrorSave) ?>'); //addslashes is used to escape single quotes in French notifications.
                        }
                        change_lists(); //Updates the three lists immediately. The new menu will be automatically placed in list 0 (hidden menu elements list).
                    } //end success       
                }); //end ajax
            }
        }
        
        //Button for saving a new or existing menu.
        jQuery('#new').live('click', function (e) {
            saveMenu();
        });
            
    </script>
    <!-- END PAGE SPECIFIC SCRIPTS -->
</body>
</html>
