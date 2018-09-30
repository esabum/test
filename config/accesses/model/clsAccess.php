<?php

class Access {

    protected $obj_bconn;
    protected $dbh;
    protected $flag = "ENT_SUBSTITUTE";
    //Filters
    protected $language_id = "";
    //Attributes
    protected $bit = array();
    protected $name = array();
    protected $description = array();
    protected $count = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "Select 
                    bit, name, description, language_id
                From iaccesses
                Order By iaccesses.bit;\n";

        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        
        while ($row = mysqli_fetch_row($result)) {
            $this->bit[] = $row[0];
            $this->name[] = $row[1];
            $this->description[] = $row[2];
            $this->language_id[] = $row[3];
            
        }
        $this->count = (count($this->bit));
        mysqli_free_result($result);
    }

    # Properties for setting Filter Values

    public function set_LanguageId($int) {
        if (is_numeric($int) && $int > 0) {
            $this->language_id = $int;
        } else {
            $this->language_id = 1;
        }
    }

    public function get_Count() {
        return $this->count;
    }

    public function get_Bit($id) {
        if ($id < $this->count) {
            return $this->bit[$id];
        }
    }

    public function get_Name($id) {
        if ($id < $this->count) {
            return htmlentities($this->name[$id], (int) $this->flag, "Windows-1252", true);
        }
    }

    public function get_Description($id) {
        if ($id < $this->count) {
            return htmlentities($this->description[$id], (int) $this->flag, "Windows-1252", true);
        }
    }
    
    public function get_Language_Id($int) {
        if ($int < $this->count) {
            return $this->language_id[$int];
        }
    }

    private function Clear_Results() {
        $this->bit = array();
        $this->name = array();
        $this->description = array();
        $this->language_id = array();
        $this->count = 0;
    }

}

?>