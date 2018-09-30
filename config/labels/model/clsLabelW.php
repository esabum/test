<?php

class LabelsWrite {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $htmlentities_flags = "ENT_QUOTES || ENT_XHTML ";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    private function update_name($id, $name) {
        $SQL = "UPDATE labels ";
        $SQL .= "SET name = '$name' ";
        $SQL .= "WHERE (name ='$id');";
        $result = mysqli_query($this->dbh, $SQL);
    }

    private function create_new($name, $languages) {
        $name = $this->_FREE($name);
        for ($j = 0; $j < count($languages); $j++) {
            $languages[$j] = $this->_FREE($languages[$j]);
            $SQL = "INSERT into labels ";
            $SQL .= "VALUES('$name', $j+1, '{$languages[$j]}');";
            $result = mysqli_query($this->dbh, $SQL);
        }
        return $result;
    }

    private function update_rec($name, $languageId, $text) {
        $SQL = "UPDATE labels ";
        $SQL .= "SET description = '$text' ";
        $SQL .= "WHERE (labels.name = '$name') ";
        $SQL .= "AND (labels.language_id = $languageId);";
        return $result = mysqli_query($this->dbh, $SQL);
    }

    private function language_exist($name, $languageId) {
        $SQL = "SELECT name ";
        $SQL .= "FROM labels ";
        $SQL .= "WHERE (name = '$name') ";
        $SQL .= "AND (language_id = $languageId);";
        $result = mysqli_query($this->dbh, $SQL);
        if ($row = mysqli_fetch_row($result)){
            return true;
        } else {    
            return false;
        }    
    }

    private function create_new_language($name, $languageId, $text) {
        $SQL = "INSERT into labels ";
        $SQL .= "VALUES('$name', $languageId, '{$languages[$j]}');";
        $result = mysqli_query($this->dbh, $SQL);
    }

    private function create_update_rec($id, $name, $languages) {
        $name = $this->_FREE($name);
        $this->update_name($id, $name);
        for ($j = 0; $j < count($languages); $j++) {
            $languages[$j] = $this->_FREE($languages[$j]);
            if ($this->language_exist($name, ($j + 1))){
                $result = $this->update_rec($name, ($j + 1), $languages[$j]);
            } else {
                $result = $this->create_new_language($name, ($j + 1), $languages[$j]);
            }    
        }
        return $result;
    }

    private function rec_Insert($name, $langId, $text) {
        if ($langId == 0) {
            $SQL = "INSERT into labels ";
            $SQL .= "(name, language_id, description) ";
            $SQL .= "values('$name',1, '');";
        } else {
            $SQL = "INSERT into labels ";
            $SQL .= "(name, language_id, description) ";
            $SQL .= "values('$name', $langId, '$text');";
        }
        $result = mysqli_query($this->dbh, $SQL);
        return $result;
    }

    public function set_Label($id, $name, $languages) {
        if ($id == ''){
            return $this->create_new($name, $languages);
        } else {
            return $this->create_update_rec($id, $name, $languages);
        }    
    }
    
    public function delete_Row($name) {
        $SQL = "DELETE FROM labels ";
        $SQL .= "WHERE (name = '$name');";

        $result = mysqli_query($this->dbh, $SQL);
        return $result;
    }

    private function _FREE($_VAR, $_UTF = true) {
        /* $v1 = array('&', '´', '`');
          $_VAR = str_replace ($v1, ' ', $_VAR); */
        //if($_UTF) $_VAR = utf8_decode($_VAR);
        $_VAR = html_entity_decode($_VAR, (int) $this->htmlentities_flags);
        $_VAR = str_replace('&quot;', '"', $_VAR);
        $_VAR = mysqli_real_escape_string($this->dbh,$_VAR); //Activado para poder guardar labels con apóstrofos
        $_VAR = mb_convert_encoding($_VAR, 'WINDOWS-1252', 'UTF-8');
        return $_VAR;
    }

}

?>