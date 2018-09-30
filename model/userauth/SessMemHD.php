<?php
foreach ($_GET as $key => $value) {
    $$key = $value;
}
foreach ($_POST as $key => $value) {
    $$key = $value;
}

require_once APPROOT . '/model/userauth/clsUserAuth.php';
require_once APPROOT . '/model/userauth/Zebra_Session.php';
require_once APPROOT . '/model/userauth/clsBitCtrl.php';
require_once APPROOT . '/model/userauth/clsPageAuth.php';

$objUser = new AuthUser;
$objBitCtrl = new BitControl;
$objPageAuth = new PageAuth;

$session = new Zebra_Session('FE-Ernesto', 'C?SZ4xyb:hAu(A8y', 10800);
if (empty($_SESSION)) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . APPBASE . 'logout.php');
?>
    <script language="javascript">
        top.location.href = "http://<?= $_SERVER['HTTP_HOST'] ?>/<?= APPBASE ?>logout.php";
    </script>
<?php
    die();
}
$UserId = $_SESSION['userid'];
$User = $_SESSION['email'];
$uuid = $_SESSION['uuid'];
$SelLang = $_SESSION['sellang'];
$password = $_SESSION['password'] ;

if (!$objUser->authorize($UserId, $uuid)) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . APPBASE . 'logout.php');
?>
    <script language="javascript">
        top.location.href = "http://<?= $_SERVER['HTTP_HOST'] ?>/<?= APPBASE ?>logout.php";
    </script>
<?php
}
$objPageAuth->set_UserId($UserId);
$objPageAuth->set_URL($_SERVER['SCRIPT_NAME']);
if (!$objPageAuth->execute()) {
    if ($_SERVER['SCRIPT_NAME'] <> "/" . APPBASE . "index.php") {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . APPBASE . 'index.php');
?>
        <script language="javascript">
            top.location.href = "http://<?= $_SERVER['HTTP_HOST'] ?>/<?= APPBASE ?>index.php";
        </script>
<?php
    } else {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . APPBASE . 'logout.php');
?>
        <script language="javascript">
            top.location.href = "http://<?= $_SERVER['HTTP_HOST'] ?>/<?= APPBASE ?>logout.php";
        </script>
<?php
    }
}

$Access = $objUser->get_Access();
$First = $objUser->get_FirstName();
$Last = $objUser->get_LastName();
$UserTheme = $objUser->get_Theme();

if (isset($language)) {
    $SelLang = $language;
}

if (empty($SelLang)) {
    $SelLang = 1;
}
$_SESSION['sellang'] = $SelLang;
session_write_close();
?>