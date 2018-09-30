<?php

class UserByEmail {

    protected $obj_bconn;
    protected $dbh;
    protected $id = 0;
    protected $count = 0;
    protected $email="";
    protected $htmlentities_flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT id FROM iusers WHERE email= '$this->email'";
        $result = mysqli_query($this->dbh, $SQL);
        while ($row = mysqli_fetch_row($result)) {
            $this->count ++;
        }
    }

    public function set_Email($str) {
        if (is_string($str)) {
            $this->email = $str;
        } else {
            $this->email = "";
        }
    }
    
    public function get_Count(){
        return $this->count;
    }

}
