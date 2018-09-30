<?php

class LanguagesW {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $htmlentities_flags = "ENT_XHTML";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    private function insertData($name, $short, $image, $enabled) {
        $name = $this->_FREE($name);
        $image = $this->_FREE($image);
        $SQL = "INSERT INTO languages(name,short,flag,enabled) ";
        $SQL .= "VALUES('$name','$short','$image',$enabled); ";
        $this->SQL = $SQL;
        $result = mysqli_query($this->dbh, $SQL);
        if ($result){
            return TRUE;
        } else {
            return FALSE;
        }    
    }

    private function updateData($id, $name, $short, $image, $enabled) {
        $name = $this->_FREE($name);
        $image = $this->_FREE($image);
        $SQL = "UPDATE  languages SET ";
        $SQL .= "`name` = '$name', short = '$short', flag = '$image', enabled = $enabled ";
        $SQL .= "WHERE id = $id;";
        $this->SQL = $SQL;
        $result = mysqli_query($this->dbh, $SQL);
        if ($result){
            return TRUE;
        } else {   
            return FALSE;
        }    
    }

    public function setData($id, $name, $short, $image, $enabled) {
        if ($id == 0){
            return $this->insertData($name, $short, $image, $enabled);
        } else {
            return $this->updateData($id, $name, $short, $image, $enabled);
        }    
    }

    private function _FREE($_VAR, $_UTF = true) {
        /* $v1 = array('&', '´', '`');
          $_VAR = str_replace ($v1, ' ', $_VAR);
          if($_UTF) $_VAR = utf8_decode($_VAR); */
        //$_VAR = mb_convert_encoding($_VAR, 'WINDOWS-1252' , 'UTF-8');
        $_VAR = html_entity_decode($_VAR, (int) $this->htmlentities_flags);
        //$_VAR = mysqli_real_escape_string($this->dbh,$_VAR);
        $_VAR = mb_convert_encoding($_VAR, 'WINDOWS-1252', 'UTF-8');
        return $_VAR;
    }

}

?>