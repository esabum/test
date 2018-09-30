<?php

class AccessesW {
    
    protected $obj_bconn;
    protected $dbh;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    //Filters
    //Attributes
    protected $bit = '';
    protected $language_id = 0;
    protected $name = '';
    protected $description = '';
    
    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }
    
    public function execute() {
        $SQL = "INSERT INTO iaccesses(bit, language_id, name, description) VALUES('$this->bit', $this->language_id, '$this->name','$this->description') ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description);";
        //echo $SQL;
        $result = mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
        return $this->bit;
        // Get insert id
        /*$SQL = "SELECT last_insert_id();";
        $result = mysqli_query($this->dbh, $SQL);
        $row = mysqli_fetch_row($result);
        mysqli_free_result($result);
        return $row[0];*/   
    }
    
    public function delete() {
        $SQL = "DELETE FROM iaccesses ";
        $SQL .= "WHERE (bit = '$this->bit')"
                . "AND (language_id = $this->language_id);";
        $result = mysqli_query($this->dbh, $SQL);
        return $result;
    }

    public function set_Bit($char) {
        if ($char) {
            $this->bit = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($char), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->bit = '';
        }
    }
    
    public function set_Language_Id($int) {
        if (is_numeric($int)) {
            $this->language_id = $int;
        } else {
            $this->language_id = 1;
        }
    }
    
    public function set_Name($str) {
        if ($str) {
            $this->name = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->name = '';
        }
    }
    
    public function set_Description($str) {
        if ($str) {
            $this->description = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->description = '';
        }
    }
    
}