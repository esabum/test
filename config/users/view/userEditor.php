<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/view/pageheader.php';
//require_once APPROOT . '/config/labels/model/clsLabels.php';
require_once APPROOT . '/model/language/clsLangs.php';
require_once APPROOT . '/config/users/model/clsUsers.php';

$id = 0;
//Get Labels 
$objLabel = New Labels;
$lblUsers = $objLabel->get_Label('lblUsers', $SelLang);
$lblName = $objLabel->get_Label('lblName', $SelLang);
$lblFirstName = $objLabel->get_Label('lblFirstName', $SelLang);
$lblLastName = $objLabel->get_Label('lblLastName', $SelLang);
$lblEmail = $objLabel->get_Label('lblEmail', $SelLang);
$lblDefaultLanguage = $objLabel->get_Label('lblDefaultLanguage', $SelLang);
$lblEnabled = $objLabel->get_Label('lblEnabled', $SelLang);
$lblAdminRight = $objLabel->get_Label('lblAdminRight', $SelLang);
$lblBasicUserRight = $objLabel->get_Label('lblBasicUserRight', $SelLang);
$lblEditUserRight = $objLabel->get_Label('lblEditUserRight', $SelLang);
$lblSettingsRight = $objLabel->get_Label('lblSettingsRight', $SelLang);
$lblAccessRights = $objLabel->get_Label('lblAccessRights', $SelLang);
$lblSave = $objLabel->get_Label("lblSave", $SelLang);
$lblBasicAccess = $objLabel->get_Label("lblBasicAccess", $SelLang);
$lblSettingsAccess = $objLabel->get_Label("lblSettingsAccess", $SelLang);
$lblUserAccess = $objLabel->get_Label("lblUserAccess", $SelLang);
$lblAdministratorAccess = $objLabel->get_Label("lblAdministratorAccess", $SelLang);
$lblAddNewUser = $objLabel->get_Label('lblAddNewUser', $SelLang);
$lblSaveComplete = $objLabel->get_Label("lblSaveComplete", $SelLang);
$lblErrorSave = $objLabel->get_Label("lblErrorSave", $SelLang);
$lblInsertAnEmail = $objLabel->get_Label("lblInsertAnEmail", $SelLang);
$lblEmailNotAvailable = $objLabel->get_Label("lblEmailNotAvailable", $SelLang);
$lblAvailableEmail = $objLabel->get_Label("lblAvailableEmail", $SelLang);
$lblInvalidEmail = $objLabel->get_Label("lblInvalidEmail", $SelLang);
$lblSelectPermissions = $objLabel->get_Label("lblSelectPermissions", $SelLang);



$objLangs = New Languages;
$objLangs->execute();
$langsoption = '';
for ($i = 0; $i < $objLangs->get_Count(); $i++) {
    $langsoption .= "<option value =\"" . $objLangs->get_ID($i) . "\">" . $objLangs->get_Name($i) . "</option>";
}

$objUsers = New Users;
$objUsers->set_ID(-1);
$objUsers->execute();
$usersoption = "<option value =\"0\">" . $lblAddNewUser . "</option>";
for ($i = 0; $i < $objUsers->get_Count(); $i++) {
    $usersoption .= "<option value =\"" . $objUsers->get_ID($i) . "\">" . $objUsers->get_First($i) . " " . $objUsers->get_Last($i) . "</option>";
}

?>

<!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-header">
                        <h2>
                            <i class="fas fa-wrench"></i>&nbsp;
                            <strong><?= $lblUsers ?></strong>
                        </h2>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-6 m-b-20">
                                    <label class="tam" for="Users"><?=$lblUsers?></label>
                                    <select title = "" tabindex="-1" id="UserId" class="form-control form-white" data-search="true" data-placeholder="" ><?=$usersoption?></select>
                                </div>
                            </div>
                            <div id="userform" class="row">
                            </div>    
                        </div>
                        <div class="col-md-6">
                            
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
    <script type="text/javascript">
        var validEmail;
        jQuery(document).ready(function (jQuery) {
            validEmail=false;
            change_user();
            emailValidation();
        });
        
        jQuery(document).on('change', '#UserId', function(){
            change_user();
        });
        
        function change_user() {
            jQuery.ajax({
                url: '/config/users/controller/getUsers.php',
                type: 'POST',
                data: {
                    id: jQuery('#UserId').val()
                },
                success: function (data) {
                    jQuery('#userform').html(data);
                    popover();
                }
            });
        }
        //document.getElementById("name").value; -- Extracts the numeric value of the selected option in the drop-down. 
        //document.getElementById("name").innerHTML; -- Extracts the option values from the drop-down.
        
        //Checks if the provided email is available, unavailable (already used by another user) or invalid (eg. blank space or not complying with email creation standards)
        function emailValidation() {
            jQuery(document).on("change", "#Email", function () {
                var email = jQuery("#Email").val();
                var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
                if (regex.test(email.trim())) {
                    jQuery("#mail_status").html('&nbsp;<i class="fas fa-sync fa-pulse"></i>&nbsp;Checking availability...');
                    jQuery.ajax({
                        type: "POST",
                        url: "/config/users/controller/userEmailAvail.php",
                        data: "email=" + email,
                        success: function (data) {
                            if (data == '0') {
                                validEmail=true;
                                jQuery("#mail_status").html('&nbsp;<font color="Green"><i class="fas fa-check-circle"></i> <?=$lblAvailableEmail?> </font>');                                
                            } else if (data == '1') {
                                validEmail=false;
                                jQuery("#mail_status").html('&nbsp;<font color="red"><i class="fas fa-times-circle"></i> <?=addslashes($lblEmailNotAvailable)?> </font>'); //addslashes is especilly added to escape single quotes in French notifications.
                            }
                        }
                    });
                } else {
                    validEmail=false;
                    jQuery("#mail_status").html('<font color="#cc0000"><i class="fas fa-times-circle"></i> <?=$lblInvalidEmail?></font>');
                    jQuery('#Email').css({'border-color': 'red'});
                    setTimeout(function () {
                        jQuery('#Email').css({'border-color': '#ECEDEE'});
                        jQuery("#mail_status").empty();
                    }, 5000);
                }
            });
        }
        
        function saveUser(){
            var Enable = jQuery('#Enabled:checked').val();
            if(Enable != 1 ){
                Enable = 0;
            }
            
            var checkAccessEle = jQuery("#accessCont input:checked");
            var dataAccess = [];
            checkAccessEle.each(function (i) {
                dataAccess.push(checkAccessEle[i].value);
            });
            
            //var email = jQuery('#Email').val();
            //It is mandatory to provide an email. If the user does not provide one, it will be notified to do so. 
            if(validEmail == false) {
                showNoty('danger', '<?= $lblInsertAnEmail ?>');
            } else {
                if(dataAccess.length > 0){
                    jQuery.ajax({
                        type: 'POST',
                        url: '/config/users/controller/sendUsers.php',
                        data:{
                           id: jQuery('#UserId').val(),                 
                           first: jQuery('#First').val(),
                           last: jQuery('#Last').val(),
                           email: jQuery('#Email').val(),
                           language_id: jQuery('#LangID').val(),
                           enabled: Enable,
                           access_bit: dataAccess
                        },
                        success: function(data){
                            if (data > 0){
                                if (jQuery('#UserId').val()==0){ //If user id = 0 (it only happens when a new user is about to be created), the drop-down must be updated immediately. 
                                    var option = jQuery('<option></option>').attr('selected', true).text(jQuery('#First').val()+ ' '+jQuery('#Last').val()).val(data);
                                    option.appendTo(jQuery('#UserId')); //appendTo adds the newly created user to the #UserId drop-down.
                                    jQuery('#UserId').trigger('change');
                                }
                                showNoty('success', '<?= $lblSaveComplete ?>');
                            } else { 
                                validEmail=false;
                                showNoty('danger', '<?= addslashes($lblErrorSave) ?>'); //addslashes is especially added to escape single quotes in French notifications.
                            }
                        }        
                    });                      
                }else{
                    showNoty('danger', '<?= $lblSelectPermissions ?>');
                }
            //var bit = dataAccess.value; 

            }
        }

        jQuery('#save').live('click', function (e) {
            saveUser();
        });
        
    </script>
<!-- END PAGE SPECIFIC SCRIPTS -->
</body>
</html>

    
