<?php

class GetConsecutivo {

    protected $flags = "ENT_SUBSTITUTE";
    protected $obj_bconn;
    protected $dbh;
    protected $json = array();
    protected $consec = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function getConsecutivo($emisorId, $doctype) {
        $SQL = "SELECT
                    {$doctype}
                  FROM
                    consecutivos
                  WHERE
                    emisor_id = " . $emisorId . ";";

        $result = mysqli_query($this->dbh, $SQL);
        $consec = 0;
        while ($row = mysqli_fetch_row($result)) {
            $consec = $row[0];
        }
        mysqli_free_result($result);
        return $consec;
    }

    public function updateConsecutivo($emisorId, $doctype) {
        $SQL = "SELECT
                    {$doctype}
                  FROM
                    consecutivos
                  WHERE
                    emisor_id = " . $emisorId . ";";

        $result = mysqli_query($this->dbh, $SQL);
        $consec = 0;
        while ($row = mysqli_fetch_row($result)) {
            $consec = $row[0];
        }

        $SQL = "update consecutivos set {$doctype} = " . ($consec + 1) . " where emisor_id = " . $emisorId . ";";
        $result = mysqli_query($this->dbh, $SQL);
        $flag = ($result) ? true : false;
        //mysqli_free_result($result);
        return $flag;
    }

    public function get_Json() {
        return $this->json;
    }

    public function cc($data) {
        return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

    public function html($data) {
        return htmlentities($data, (int) $this->flags, "Windows-1252", true);
    }

}
