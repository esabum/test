<?php

/*Load values from .ini*/
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);


require_once APPROOT . '/config/labels/model/clsLabel.php';

//Get Labels
$objLabel = New Labels;
$lblAuthError = $objLabel->get_Label("lblAuthError", 2);
$lblAraRoot = $objLabel->get_Label("lblAraRoot", 2);
$lblSignIn = $objLabel->get_Label("lblSignIn", 2);
$lblToYourAccount = $objLabel->get_Label("lblToYourAccount", 2);
$lblForgotPassword = $objLabel->get_Label("lblForgotPassword", 2);
$lblReset = $objLabel->get_Label("lblReset", 2);
$lblYourPassword = $objLabel->get_Label("lblYourPassword", 2);
$lblHaveAnAccount = $objLabel->get_Label("lblHaveAnAccount", 2);
$lblSendPasswordResetLink = $objLabel->get_Label("lblSendPasswordResetLink", 2);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Test</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="" name="description" />
        <meta content="themes-lab" name="author" />
        <link rel="shortcut icon" href="assets/images/icon.png">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/ui.css"/>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-loading/lada.min.css"/>
    </head>
    <body class="account2" data-page="login">
        <!-- BEGIN LOGIN BOX -->
        <div class="container" id="login-block">
            <!--
            <i class="user-img icons-faces-users-03" style="opacity: 0;"></i>
            
            <div class="account-info">
                <a href="dashboard.html" class="logo"></a>
                <h3>Modular &amp; Flexible Admin.</h3>
                <ul>
                    <li><i class="icon-magic-wand"></i> Fully customizable</li>
                    <li><i class="icon-layers"></i> Various sibebars look</li>
                    <li><i class="icon-arrow-right"></i> RTL direction support</li>
                    <li><i class="icon-drop"></i> Colors options</li>
                </ul>
            </div>
            -->
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="account-form">
                    <form class="form-signin" role="form">
                        <h3><strong><?=$lblSignIn?></strong> <?=$lblToYourAccount?></h3>
                        <div class="append-icon">
                            <input type="text" id="username" class="form-control form-white username" placeholder="Username" required>
                            <i class="icon-user"></i>
                        </div>
                        <div class="append-icon m-b-10">
                            <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
                            <i class="icon-lock"></i>
                            <label id="auth-error" class="error" for="password"></label>
                            <input type="hidden" id="lblAuthError" name="lblAuthError" value="<?=$lblAuthError?>"/>
                            <div id="login_status"></div>
                        </div>
                        <button type="submit" id="submit-form" class="btn btn-lg btn-dark btn-block" data-style="expand-left"><?=$lblSignIn?></button>
                        <!--<span class="forgot-password"><a id="password" href="#"><?=$lblForgotPassword?></a></span>-->
                        <div class="clearfix text-center">
                            <span class=""><a id="password" href="#"><?=$lblForgotPassword?></a></span>
                            <!--<p class="pull-right m-t-20 m-b-0">&nbsp;<a href="#">&nbsp;</a></p>-->
                        </div>                        
                    </form>
                    <form class="form-password" role="form">
                        <h3><strong><?=$lblReset?></strong> <?=$lblYourPassword?></h3>
                        <div class="append-icon m-b-10">
                            <input type="text" id="resetname" class="form-control form-white username" placeholder="Username" required>
                            <i class="icon-user"></i>
                        </div>
                        <button type="submit" id="submit-password" class="btn btn-lg btn-danger btn-block" data-style="expand-left"><?=$lblSendPasswordResetLink?></button>
                        <!--<span class="forgot-password"><a id="password" href="account-forgot-password.html"><?=$lblForgotPassword?></a></span>-->
                        <div class="clearfix text-center">
                            <span class=""><a id="login" href="#"><?=$lblHaveAnAccount?> <?=$lblSignIn?></a></span>
                            <!--<p class="pull-right m-t-20 m-b-0">&nbsp;<a href="#">&nbsp;</a></p>-->
                        </div>
                    </form>
                </div>
            </div>    
            <div class="col-sm-3"></div>                
        </div>
        <!-- END LOCKSCREEN BOX -->
        <p class="account-copyright">
            <span>Copyright © 2018 </span><span>Test</span>.<span>All rights reserved.</span>
        </p>
        <script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="assets/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="assets/plugins/gsap/main-gsap.min.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/plugins/backstretch/backstretch.min.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-loading/lada.min.js"></script>
        <script type="text/javascript" src="assets/js/pages/login-v2.js"></script>
        <script type="text/javascript">
            var APPBASE = '<?=APPBASE?>';
        </script>
    </body>
</html>