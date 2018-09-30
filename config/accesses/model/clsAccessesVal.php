<?php

class AccessesVal {

    protected $obj_bconn;
    protected $dbh;
    protected $count = 0;
    protected $new_id = '';
    protected $new_lang = '';
    protected $htmlentities_flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT bit, language_id, name, description
                    FROM iaccesses 
                    WHERE bit = '$this->new_id'
                        AND language_id = '$this->new_lang';";    

        $result = mysqli_query($this->dbh, $SQL);
        $count = mysqli_num_rows($result);
        mysqli_free_result($result);
        return !$count;
    }

    # Properties for setting Filter Values

    public function set_NewId($str) {
        if ($str) {
            $this->new_id = $str;
        } else {
            $this->new_id = '';
        }
    }
    
    public function set_NewLang($str) {
        if ($str) {
            $this->new_lang = $str;
        } else {
            $this->new_lang = '';
        }
    }
    
} 

