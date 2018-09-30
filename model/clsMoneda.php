<?php

class Moneda {
    protected $flags = "ENT_SUBSTITUTE";
    protected $obj_bconn;
    protected $dbh;
    protected $json = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT * FROM moneda WHERE 1;";

        $result = mysqli_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "id" => $row[0],
                "pais" => $this->html($row[1]),
                "nombre" => $this->html($row[2]),
                "codigo" => $this->html($row[3])
            );
        }
        mysqli_free_result($result);
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