<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);

require_once APPROOT . '/view/pageheader.php';

$objLabel = New Labels;
$lblBodyChangePassword = $objLabel->get_Label("lblBodyChangePassword", $SelLang);
$lblPassword = $objLabel->get_Label("lblPassword", $SelLang);
$lblNewPassword = $objLabel->get_Label("lblNewPassword", $SelLang);
$lblConfirmPassword = $objLabel->get_Label("lblConfirmPassword", $SelLang);
$lblReqPassword = $objLabel->get_Label("lblReqPassword", $SelLang);
$lblReqConfirmPassword = $objLabel->get_Label("lblReqConfirmPassword", $SelLang);
$lblSave = $objLabel->get_Label("lblSave", $SelLang);
$lblCancel = $objLabel->get_Label("lblCancel", $SelLang);
$lblChangePasswordSuccess = $objLabel->get_Label("lblChangePasswordSuccess", $SelLang);
$lblAccountSettings = $objLabel->get_Label("lblAccountSettings", $SelLang);
$lblCanceled = $objLabel->get_Label("lblCanceled", $SelLang);
$lblSaveConfirm = $objLabel->get_Label("lblSaveConfirm", $SelLang);
$lblYes = $objLabel->get_Label("lblYes", $SelLang);
$lblNo = $objLabel->get_Label("lblNo", $SelLang);
$lblSaved = $objLabel->get_Label("lblSaveComplete", $SelLang);
$lblErrorSave = $objLabel->get_Label("lblErrorSave", $SelLang);
$lblWrongPassword = $objLabel->get_Label("lblWrongPassword", $SelLang);
$lblPassNotMatch = $objLabel->get_Label("lblPassNotMatch", $SelLang);
$lblFillBlankSpaces = $objLabel->get_Label("lblFillBlankSpaces", $SelLang);
$lblUser = $objLabel->get_Label("lblUser", $SelLang);
$lblCustomTheme = $objLabel->get_Label("lblCustomTheme", $SelLang);
$lblResetDefaultStyle = $objLabel->get_Label("lblResetDefaultStyle", $SelLang);
$lblLayoutOptions = $objLabel->get_Label("lblLayoutOptions", $SelLang);
$lblThemeStructure = $objLabel->get_Label("lblThemeStructure", $SelLang);
$lblLayoutColor = $objLabel->get_Label("lblLayoutColor", $SelLang);
$lblBackgroundColor = $objLabel->get_Label("lblBackgroundColor", $SelLang);
?>
<!-- BEGIN PAGE CONTENT -->
<link href="/<?= APPBASE ?>assets/css/layout.css" rel="stylesheet" type="text/css" />
<div class="page-content">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-header">
                    <h2 class="panel-title"><strong><i class="fas fa-user fa-1"></i> <?= $lblUser ?> &nbsp</strong>  <?= $lblAccountSettings ?></h2>
                </div>

                <div class="panel-body bg-white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form role="form" class="form-validation" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3><strong><?= $lblBodyChangePassword ?></strong></h3>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" for="password"><?= $lblPassword ?></label>
                                            <div class="append-icon">
                                                <input type="password" name="data" id="pass0" class="form-control" minlength="5"  maxlength="28" minlength="5" required="true" aria-required="true">
                                                <i class="icon-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" for="password2"><?= $lblNewPassword ?></label>
                                            <div class="append-icon">
                                                <input type="password" name="data2" id="pass1" class="form-control" minlength="5" maxlength="28" required="true" aria-required="true">
                                                <i class="icon-lock"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="password3"><?= $lblConfirmPassword ?></label>
                                            <div class="append-icon">
                                                <input type="password" name="data3" id="pass2" class="form-control" minlength="5" maxlength="28" required="true" aria-required="true">
                                                <i class="icon-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center  m-t-20">
                                    <button type="button" class="btn btn-embossed btn-primary ladda-button" data-style="expand-right"  data-layout="topRight" data-type="confirm" onclick="validate();"><?= $lblSave ?></button>
                                    <button type="button" class="cancel btn btn-embossed btn-default m-b-10 m-r-0" onclick="cancel();"><?= $lblCancel ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-header">
                    <h2 class="panel-title"><strong><i class="fas fa-cogs"></i> <?= $lblCustomTheme ?> &nbsp</strong></h2>
                </div>
                <div class="panel-body bg-white">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="mCustomScrollBox mCS-light">
                                <div class="builder-container">
                                    <button class="btn btn-sm btn-default" id="reset-style"><?= $lblResetDefaultStyle ?></button>
                                    <h4><b><?=$lblLayoutOptions?>:</b></h4>
                                    <div class="layout-option col-md-12 m-b-10">
                                        <span> Fixed Sidebar</span>
                                        <label class="switch pull-right">
                                            <input data-layout="sidebar" id="switch-sidebar" class="switch-input" type="checkbox"></input>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                    <div class="layout-option col-md-12 m-b-10">
                                        <span> Sidebar on Hover</span>
                                        <label class="switch pull-right">
                                            <input data-layout="sidebar-hover" id="switch-sidebar-hover" type="checkbox" class="switch-input">
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                    <div class="layout-option col-md-12 m-b-10">
                                        <span> Submenu on Hover</span>
                                        <label class="switch pull-right">
                                            <input data-layout="submenu-hover" id="switch-submenu-hover" type="checkbox" class="switch-input">
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                    <div class="layout-option col-md-12 m-b-10">
                                        <span>Fixed Topbar</span>
                                        <label class="switch pull-right">
                                            <input data-layout="topbar" id="switch-topbar" type="checkbox" class="switch-input">
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                    <div class="layout-option col-md-12 m-b-10">
                                        <span>Boxed Layout</span>
                                        <label class="switch pull-right">
                                            <input data-layout="boxed" id="switch-boxed" type="checkbox" class="switch-input">
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>

                                    <h4><b><?= $lblThemeStructure ?>:</b></h4>
                                    <div class="row row-sm" style="max-width: 240px;">
                                        <div class="col-xs-6">
                                            <div class="theme clearfix sdtl" data-theme="sdtl">
                                                <div class="header theme-left" style="background-color: rgb(32, 34, 38);"></div>
                                                <div class="header theme-right-light" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="theme-sidebar-dark" style="background-color: rgb(57, 62, 68);"></div>
                                                <div class="bg-light"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="theme clearfix sltd" data-theme="sltd">
                                                <div class="header theme-left" style="background-color: rgb(32, 34, 38);"></div>
                                                <div class="header theme-right-dark" style="background-color: rgb(57, 62, 68);"></div>
                                                <div class="theme-sidebar-light" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="bg-light"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="theme clearfix sdtd" data-theme="sdtd">
                                                <div class="header theme-left" style="background-color: rgb(32, 34, 38);"></div>
                                                <div class="header theme-right-dark" style="background-color: rgb(57, 62, 68);"></div>
                                                <div class="theme-sidebar-dark" style="background-color: rgb(57, 62, 68);"></div>
                                                <div class="bg-light"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="theme clearfix sltl" data-theme="sltl">
                                                <div class="header theme-left" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="header theme-right-light" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="theme-sidebar-light" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="bg-light"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <h4><b><?=$lblLayoutColor?>:</b></h4>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="theme-color  bg-dark" data-main="default" data-color="#2B2E33"></div>
                                            <div class="theme-color  background-primary" data-main="primary" data-color="#319DB5"></div>
                                            <div class="theme-color  bg-red" data-main="red" data-color="#C75757"></div>
                                            <div class="theme-color  bg-green" data-main="green" data-color="#1DA079"></div>
                                            <div class="theme-color  bg-orange" data-main="orange" data-color="#D28857"></div>
                                            <div class="theme-color  bg-purple" data-main="purple" data-color="#B179D7"></div>
                                            <div class="theme-color  bg-blue" data-main="blue" data-color="#4A89DC"></div>
                                        </div>
                                    </div>
                                    <h4><b><?= $lblBackgroundColor?>:</b></h4>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="bg-color bg-clean" data-bg="clean" data-color="#F8F8F8"></div>
                                            <div class="bg-color bg-lighter" data-bg="lighter" data-color="#EFEFEF"></div>
                                            <div class="bg-color bg-light-default" data-bg="light-default" data-color="#E9E9E9"></div>
                                            <div class="bg-color bg-light-blue" data-bg="light-blue" data-color="#E2EBEF"></div>
                                            <div class="bg-color bg-light-purple" data-bg="light-purple" data-color="#E9ECF5"></div>
                                            <div class="bg-color bg-light-dark" data-bg="light-dark" data-color="#DCE1E4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center  m-t-20">
                        <button type="button" class="btn btn-embossed btn-primary ladda-button" data-style="expand-right"  data-layout="topRight" data-type="confirm" id="saveTheme"><?= $lblSave ?></button>
                        <button type="button" class="cancel btn btn-embossed btn-default m-b-10 m-r-0" id="cancelCustom"><?= $lblCancel ?></button>
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
<script src="/<?= APPBASE ?>assets/plugins/icheck/icheck.min.js"></script>
<script src="/<?= APPBASE ?>assets/js/builder.js"></script>
<script type="text/javascript">

    jQuery(document).ready(function () {
        /*Conf theme*/
        customThemePref();
        /*Reset theme*/
        jQuery('#reset-style').on('click', function () {
            resetStyle();
        });
        /*Save user conf. theme*/
        jQuery('#saveTheme').click(function () {
            jQuery.ajax({
                type: 'post',
                url: '/<?= APPBASE ?>users/themeUser_upd.php',
                data: {
                    'id': ' <?= $UserId ?>',
                    'dataTheme': jQuery('body').attr('class')
                },
                success: function (data) {
                    if (data == 1) {
                        showNoty('success', '<?= $lblSaved ?>');
                    } else {
                        showNoty('danger', '<?= $lblErrorSave ?>');
                    }
                }

            });
        });
        /*Btn Cancel*/
        jQuery('#cancelCustom').click(function(){
            removeBoxedLayout();
            jQuery('.theme, .theme-color, .bg-color').removeClass('active');
            customThemePref();
            showNoty('danger','<?=$lblCanceled?>');
        });
    });
    
    /* Saved custom theme preferences */
    function customThemePref(){
        jQuery('body').attr('class', '<?=$UserTheme?>');
        var aConf = jQuery('body').attr('class').split(' ');
        jQuery('.theme, .theme-color, .bg-color').removeClass('active');
        jQuery(aConf).each(function (i) {
            //console.log(i);
            switch (aConf[i]) {
                case 'fixed-sidebar':
                    jQuery('#switch-sidebar').attr('checked', 'checked');
                    break;
                case 'fixed-topbar':
                    jQuery('#switch-topbar').attr('checked', 'checked');
                    break;
                case 'submenu-hover':
                    jQuery('#switch-submenu-hover').attr('checked', 'checked');
                    break;
                case 'sidebar-hover':
                    jQuery('#switch-sidebar-hover').attr('checked', 'checked');
                    break;
                case 'boxed':
                    jQuery('#switch-boxed').attr('checked', 'checked');
                    break;
                    // Layout Colors
                case 'color-default':
                    jQuery('.bg-dark').addClass('active');
                    break;
                case 'color-primary':
                    jQuery('.background-primary').addClass('active');
                    break;
                case 'color-red':
                    jQuery('.bg-red').addClass('active');
                    break;
                case 'color-green':
                    jQuery('.bg-green').addClass('active');
                    break;
                case 'color-orange':
                    jQuery('.bg-orange').addClass('active');
                    break;
                case 'color-purple':
                    jQuery('.bg-purple').addClass('active');
                    break;
                case 'color-blue':
                    jQuery('.bg-blue').addClass('active');
                    break;
                    //background color
                case 'bg-clean':
                    jQuery('.bg-clean').addClass('active');
                    break;
                case 'bg-lighter':
                    jQuery('.bg-lighter').addClass('active');
                    break;
                case 'bg-light-default':
                    jQuery('.bg-light-default').addClass('active');
                    break;
                case 'bg-light-blue':
                    jQuery('.bg-light-blue').addClass('active');
                    break;
                case 'bg-light-purple':
                    jQuery('.bg-light-purple').addClass('active');
                    break;
                case 'bg-light-dark':
                    jQuery('.bg-light-dark').addClass('active');
                    break;
                    //Theme structure
                case 'theme-sdtl':
                    jQuery('.sdtl').addClass('active');
                    break;
                case 'theme-sltd':
                    jQuery('.sltd').addClass('active');
                    break;
                case 'theme-sdtd':
                    jQuery('.sdtd').addClass('active');
                    break;
                case 'theme-sltl':
                    jQuery('.sltl').addClass('active');
                    break;
            }
        });
    }
    function showNoty(type, label) {//type = default, danger, success
        noty({
            text: '<div class="alert alert-' + type + '"><p><strong>' + label + '</p></div>',
            layout: 'topRight',
            theme: 'made',
            maxVisible: 10,
            animation: {open: 'animated bounceIn', close: 'animated bounceOut'},
            timeout: 3000
        });
    }
    function cancel() {
        jQuery('#pass1, #pass2, #pass0').val('').css({'border-color': '#ECEDEE'});
        showNoty('danger', '<?= $lblCanceled ?>');
    }
    function validate() {
        var pass = [jQuery('#pass0').val().trim(), jQuery('#pass1').val().trim(), jQuery('#pass2').val().trim()],
                flag = false, flag2 = false,
                cantInputs = jQuery('.form-validation input[type="password"]').size();

        for (i = 0; i < cantInputs; i++) {
            if (pass[i] == "") {
                jQuery('#pass' + i).css({'border-color': 'red'});
                showNoty('danger', '<?= $lblFillBlankSpaces ?>');
                setTimeout(function () {
                    jQuery('#pass1, #pass2, #pass0').css({'border-color': '#ECEDEE'});
                }, 3500);
                flag = true;
            }
        }
        if (!flag) {
            if (pass[1] !== pass[2]) {
                jQuery('#pass1, #pass2').css({'border-color': '#E7E01E'});
                setTimeout(function () {
                    jQuery('#pass1, #pass2').css({'border-color': '#ECEDEE'});
                }, 3500);
                showNoty('warning', '<?= $lblPassNotMatch ?>');
            } else {
                //console.log('Hacer llamada AJAX');
                jQuery.ajax({
                    type: "POST",
                    url: "/<?= APPBASE ?>users/_password_upd.php",
                    data: "pass_old=" + encodeURIComponent(pass[0]) + "&pass_new=" + encodeURIComponent(pass[1]) + "&id=" + <?= $UserId ?>,
                    success: function (data) {
                        data = parseInt(data);
                        if (data == 0) {
                            jQuery('#pass0').css({'border-color': 'red'});
                            setTimeout(function () {
                                jQuery('#pass0').css({'border-color': '#ECEDEE'});
                            }, 3500);
                            showNoty('danger', '<?= $lblWrongPassword ?>');
                        } else if (data == 1) {
                            showNoty('success', '<?= $lblSaved ?>');
                            setTimeout(function () {
                                location.reload();
                                ;
                            }, 2000);
                        } else if (data == 2) {
                            jQuery('#pass0, #pass1, #pass2').css({'border-color': 'red'});
                            setTimeout(function () {
                                jQuery('#pass0, #pass1, #pass2').css({'border-color': '#ECEDEE'});
                            }, 3500);
                            showNoty('warning', 'Same password');
                        } else {
                            showNoty('danger', 'Error');
                        }
                    }
                });
            }
        }
    }
</script>
<!-- END PAGE SPECIFIC SCRIPTS -->
</body>
</html>
