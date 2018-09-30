<?php

class PassW {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $htmlentities_flags = "ENT_XHTML";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    protected $userId = "";
    protected $newPass = "";
    protected $oldPass = "";

    public function excute() {
        $SQL = "UPDATE iusers set pass = '" . md5($this->newPass) . "' WHERE id = $this->userId && pass = '" . md5($this->oldPass) . "';";
	//echo $SQL;
        $result = mysqli_query($this->dbh, $SQL);
        if ($result) {
            return mysqli_affected_rows($this->dbh);
        }
    }

    public function set_userId($str) {
        $this->userId = $str;
    }

    public function set_newPass($str) {
        $this->newPass = $str;
    }

    public function set_oldPass($str) {
        $this->oldPass = $str;
    }

}

?>