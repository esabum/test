<?php

class clsUsertheme {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $userId = "";
    protected $newTheme = "";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "UPDATE iusers SET theme = '$this->newTheme' WHERE id = $this->userId ;";
        $result = mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function set_userId($str) {
        $this->userId = $str;
    }

    public function set_theme($str) {
        if ($str) {
            $this->newTheme = $str;
        } else {
            $str = "fixed-topbar color-default bg-clean fixed-sidebar theme-sdtl";
        }
    }

}
