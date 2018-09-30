<?php
$flag = 'ENT_SUBSTITUTE';
require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/model/language/clsLangs.php';
require_once APPROOT . '/config/labels/model/clsLabel.php';

$objLang = new Languages();
//$objLang->set_LcEnabled(1);
$objLang->execute();
$LangShort = $objLang->get_Shortname($objLang->get_IdByLanguage($SelLang));

$objLabel = New Labels;
$lblLogout = $objLabel->get_Label("lblLogout", $SelLang);
$lblLanguage = $objLabel->get_Label("lblLanguage", $SelLang);
$lblBodyChangePassword = $objLabel->get_Label("lblBodyChangePassword", $SelLang);
$lblClassifications = $objLabel->get_Label("lblClassifications", $SelLang);
$lblRegions = $objLabel->get_Label("lblRegions", $SelLang);
$lblLocations = $objLabel->get_Label("lblLocations", $SelLang);
$lblLocalities = $objLabel->get_Label("lblLocalities", $SelLang);
$lblNavigation = $objLabel->get_Label("lblNavigation", $SelLang);
$lblHi = $objLabel->get_Label("lblHi", $SelLang);
$lblMyProfile = $objLabel->get_Label("lblMyProfile", $SelLang);
$lblAccountSettings = $objLabel->get_Label("lblAccountSettings", $SelLang);
$lblAvailable = $objLabel->get_Label("lblAvailable", $SelLang);
?>
<!DOCTYPE html>
<html lang="<?= $objLang->get_Shortname($objLang->get_IdByLanguage($SelLang)); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="Test">

        <link rel="icon" type="image/png" href="/assets/images/icon.png">
        <title>Test</title>
        <link href="//fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet" type="text/css">

        <link href="/<?=APPBASE?>assets/css/style.css" rel="stylesheet"> <!-- MANDATORY -->
        <link href="/<?=APPBASE?>assets/css/theme.css" rel="stylesheet"> <!-- MANDATORY -->
        <link href="/<?=APPBASE?>assets/css/ui.css" rel="stylesheet"> <!-- MANDATORY -->
        <link href="/<?=APPBASE?>assets/css/custom.css" rel="stylesheet">
        <link href="/<?=APPBASE?>assets/plugins/datatables/dataTables.min.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <![endif]-->
    </head>
    <!-- BEGIN BODY -->
    <body class="<?=$UserTheme?>">
        <section>
            <!-- BEGIN SIDEBAR -->
            <div class="sidebar">
                <div class="logopanel">
                    <h1><a href="">&nbsp;</a></h1>
                </div>
                <div class="sidebar-inner">
                    <div class="menu-title">
                        <span><?=$lblNavigation?></span>
                        <div class="pull-right menu-settings">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" data-delay="300">
                                <i class="icon-settings"></i>
                            </a>

                        </div>
                    </div>
                    <ul class="nav nav-sidebar">
<?php
require_once APPROOT . '/view/page_nav-sidebar.php';
?>
                    </ul>
                    <div class="sidebar-footer clearfix">
                        <a class="pull-left footer-settings" href="/<?=APPBASE?>users/settings.php" data-rel="tooltip" data-placement="top" data-original-title="<?= $lblAccountSettings ?>">
                            <i class="icon-settings"></i>
                        </a>
                        <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top" data-original-title="Fullscreen">
                            <i class="icon-size-fullscreen"></i></a>
                        <a class="pull-left btn-effect" href="/<?=APPBASE?>logout.php?SelLang=<?= $SelLang ?>&E=1" data-modal="modal-1" data-rel="tooltip" data-placement="top" data-original-title="<?= $lblLogout ?>">
                            <i class="icon-power"></i></a>
                    </div>
                </div>
            </div>
            <!-- END SIDEBAR -->
            <div class="main-content">
                <!-- BEGIN TOPBAR -->
                <div class="topbar">
                    <div class="header-left">
                        <div class="topnav">
                            <a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
                            <ul class="nav nav-icons">
<?php
require_once APPROOT . '/view/page_nav-topbar.php';
?>
                            </ul>
                        </div>
                    </div>
                    <div class="header-right">
                        <ul class="header-menu nav navbar-nav">
                            <!-- BEGIN USER DROPDOWN -->
                            <li class="dropdown" id="user-header">
                                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <!--<img data-name="<?= substr($First, 0, 1). substr($Last, 0, 1)?>" data-char-count='2' data-font-size='45' data-seed='2' class="profile" alt="user image"/>-->
                                    <span class="username"><?= htmlentities($First, (int) $flag, "Windows-1252", true) ?> <?=  htmlentities($Last, (int) $flag, "Windows-1252", true) ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/<?=APPBASE?>users/settings.php"><i class="icon-user"></i><span><?= $lblAccountSettings ?></span></a>
                                    </li>
                                    <li>
                                        <a href="/<?=APPBASE?>logout.php?SelLang=<?= $SelLang ?>&E=1"><i class="icon-logout"></i><span><?= $lblLogout ?></span></a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER DROPDOWN -->
                        </ul>
                    </div>
                    <!-- header-right -->
                </div>
                <div class='mainContSpinner' style="display:none;"><div class='row'><div class='col-md-12'><div class='contSpinner'><h1><i class='fas fa-sync fa-pulse fa-1'></i></h1></div></div></div></div>

                <!-- END TOPBAR -->
