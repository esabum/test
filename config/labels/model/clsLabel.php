<?php

class Labels {

    protected $obj_bconn;
    protected $dbh;
    protected $label;
    protected $flag = 'ENT_SUBSTITUTE';

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    Public function get_Label($name, $lang = 1, $FORMAT = "HTML") {
        $SQL = "SELECT description FROM  labels WHERE language_id = $lang AND name LIKE '$name'";
        $result = mysqli_query($this->dbh, $SQL);
        if ($row = mysqli_fetch_row($result)) {
            $value = $row[0];
        } else {
            $value = "$name N/A";
        }
        if ($FORMAT == "HTML") {
            $value = htmlentities($value, (int) $this->flag, "Windows-1252", true);
        }
        return $value;
        mysqli_free_result($result);
    }

    Public function get_CLabel($name, $lang = 1) {
        $SQL = "SELECT description FROM labels WHERE language_id = $lang AND name LIKE '$name'";
        $result = mysqli_query($this->dbh, $SQL);
        if ($row = mysqli_fetch_row($result)) {
            $value = $row[0];
        } else {
            $value = "$name N/A";
        }
        return $value;
        mysqli_free($result);
    }

    Public function get_CULabels($lang = 1, $FORMAT = "HTML") {
        $arr = array();
        $SQL = "SELECT name, description FROM labels WHERE name LIKE 'cu%' AND language_id = $lang ORDER BY labels.name;";
        $result = mysqli_query($this->dbh, $SQL);
        if ($FORMAT == "HTML") {
            while ($row = mysqli_fetch_row($result)) {
                $arr[substr(strtolower($row[0]), 2)] = htmlentities($row[1], (int) $this->flag, "Windows-1252", true);
            }
        } else {
            while ($row = mysqli_fetch_row($result)) {
                $arr[substr(strtolower($row[0]), 2)] = $row[1];
            }
        }
        return $arr;
    }

}

?>