<?php

class UsersW {

    protected $obj_bconn;
    protected $dbh;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    //Attributes
    protected $id = 0;
    protected $language_id = 0;
    protected $email = '';
    protected $pass = '';
    protected $first = '';
    protected $last = '';
    protected $enabled = FALSE;
    protected $access_bit = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        if ($this->id) {
            $SQL = "UPDATE iusers
                        SET first = '$this->first', 
                            last = '$this->last',
                            email = '$this->email',
                            language_id = $this->language_id,
                            enabled = $this->enabled,
                            iaccess_bit = $this->access_bit    
                        WHERE (id = $this->id);";
            $result = mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
            if ($result) {
                return $this->id;
            } else {
                return 0;
            }
        } else {
            //$idUser=$newser["resp"]["idUser"];
            //Insert
            $SQL = "INSERT INTO iusers(id, first, last, email, language_id, enabled, iaccess_bit, pass)
                    VALUES($this->id,'$this->first', '$this->last', '$this->email', $this->language_id, $this->enabled, $this->access_bit, '" . md5($this->pass) . "');";
            //echo $SQL;
            $result = mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
            $this->id = mysqli_insert_id($this->dbh);
            return $this->id;
        }
    }
/*
    public function insertApiUser() {
        $endpoint = "http://www.bigupmonkey.com/api_hacienda/www/api.php";
        $params = array('w' => 'users', 
                        'r' => 'users_register', 
                        'fullName' => $this->first." ".$this->last, 
                        'userName' => $this->email, 
                        'email' => $this->email, 
                        'about' => 'New', 
                        'country' => 'crc', 
                        'pwd' => $this->pass, 
                        'type' => '1'
                        );
        $url = $endpoint . '?' . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        return $json;
    }
*/
    public function delete() {
        $SQL = "DELETE FROM iusers ";
        $SQL .= "WHERE (id = $this->id);";
        $result = mysqli_query($this->dbh, $SQL);
        return $result;
    }

    public function set_Id($int) {
        if (is_numeric($int) && $int > 0) {
            $this->id = $int;
        } else {
            $this->id = 0;
        }
    }

    public function set_First($str) {
        if ($str) {
            $this->first = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->first = '';
        }
    }

    public function set_Last($str) {
        if ($str) {
            $this->last = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->last = '';
        }
    }

    public function set_Email($str) {
        if ($str) {
            $this->email = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->email = '';
        }
    }

    public function set_Pass($str) {
        if ($str) {
            $this->pass = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->pass = '';
        }
    }

    public function set_Language_Id($int) {
        if (is_numeric($int) && $int > 0) {
            $this->language_id = $int;
        } else {
            $this->language_id = 0;
        }
    }

    public function set_Enabled($bol) {
        if (($bol) && ($bol <> 'no')) {
            $this->enabled = 1;
        } else {
            $this->enabled = 0;
        }
    }

    public function set_Access_Bit($int) {
        if (is_numeric($int) && $int > 0) {
            $this->access_bit = $int;
        } else {
            $this->access_bit = 0;
        }
    }

}

?>
