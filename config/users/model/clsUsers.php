<?php

class Users {

    protected $obj_bconn;
    protected $dbh;
    protected $flag = "ENT_SUBSTITUTE";
    //Filters
    protected $language_id = "";
    protected $id = ">= 0";
    //Attributes
    protected $ID = array();
    protected $first = array();
    protected $last = array();
    protected $email = array();
    protected $enabled = array();
    protected $access = array();
    protected $count = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT 
                    id, first, last, email, language_id, enabled, iaccess_bit
		FROM
                    iusers
                WHERE id $this->id";
        //echo $SQL;
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result)) {
            $this->ID[] = $row[0];
            $this->first[] = $row[1];
            $this->last[] = $row[2];
            $this->email[] = $row[3];
            $this->language_id[] = $row[4];
            $this->enabled[] = $row[5];
            $this->access[] = $row[6];
        }

        $this->count = count($this->ID);
        mysqli_free_result($result);
    }

    //GET DATA
    public function get_Count() {
        return $this->count;
    }

    public function get_ID($id) {
        if ($id < $this->count) {
            return $this->ID[$id];
        }
    }

    public function get_First($id, $FORMAT = "HTML") {
        if ($id < $this->count) {
            if ($FORMAT == 'HTML') {
                return htmlentities($this->first[$id], (int) $this->flag, "Windows-1252", true);
            } else {
                return $this->first[$id];
            }
        }
    }

    public function get_Last($id, $FORMAT = "HTML") {
        if ($id < $this->count) {
            if ($FORMAT == 'HTML') {
                return htmlentities($this->last[$id], (int) $this->flag, "Windows-1252", true);
            } else {
                return $this->last[$id];
            }
        }
    }

    public function get_Email($id, $FORMAT = "HTML") {
        if ($id < $this->count) {
            if ($FORMAT == 'HTML') {
                return htmlentities($this->email[$id], (int) $this->flag, "Windows-1252", true);
            } else {
                return $this->email[$id];
            }
        }
    }

    public function get_Language_Id($id) {
        if ($id < $this->count) {
            return $this->language_id[$id];
        }
    }

    public function get_Enabled($id) {
        if ($id < $this->count) {
            return $this->enabled[$id];
        }
    }

    public function get_Accesses($id) {
        if ($id < $this->count) {
            return $this->access[$id];
        }
    }

    public function set_ID($int) {
        if (is_numeric($int) && $int > -1) {
            $this->id = "= $int";
        } else {
            $this->id = ">= 0";
        }
    }

    private function Clear_Results() {
        $this->ID = array();
        $this->first = array();
        $this->last = array();
        $this->email = array();
        $this->language_id = array();
        $this->enabled = array();
        $this->access = array();
        $this->count = 0;
    }

}
?>

