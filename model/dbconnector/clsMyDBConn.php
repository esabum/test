<?php

class MyConn {

    protected $mysqli_host = "";
    protected $mysqli_user = "";
    protected $mysqli_pass = "";
    protected $mysqli_dbas = "";
    protected $mysqli_mbas = "";
    protected $mysqli_tbas = "";
    protected $mysqli_tdbas = "";
    private $mysqli;
    private $zmysqli;

    function __construct($param = '') {
        $this->load_ini();
        $this->mysqli = new mysqli($this->mysqli_host, $this->mysqli_user, $this->mysqli_pass, $this->mysqli_dbas);
        if ($this->mysqli->connect_error) {
            die('Connect Error: ' . $this->mysqli->connect_error);
        } else {
            $SQL = '';
            if (!$param) {
                $SQL = "USE $this->mysqli_dbas;";
            } elseif ($param == "media") {
                $SQL = "USE $this->mysqli_mbas;";
            } elseif ($param == "tags") {
                $SQL = "USE $this->mysqli_tbas;";
            } elseif ($param == "tripdesc") {
                $SQL = "USE $this->mysqli_tdbas;";
            } elseif ($param = 'none') {
                $SQL = "";
            }
            if ($SQL) {
                $result = mysqli_query($this->mysqli, $SQL);
            }
        }
    }

    function get_conn() {
        return $this->mysqli;
    }

    function get_zconn() {
        $this->zmysqli = mysqli_connect($this->mysqli_host, $this->mysqli_user, $this->mysqli_pass, $this->mysqli_dbas) or die('Could not connect to database!');
    }

    function __destruct() {
        $this->mysqli->close();
    }

    private function load_ini() {
  
        
        $ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
        $this->mysqli_host = $ini_array["mysql"]["mysqli_host"];
        $this->mysqli_user = $ini_array["mysql"]["mysqli_user"];
        $this->mysqli_pass = $ini_array["mysql"]["mysqli_pass"];
        $this->mysqli_dbas = $ini_array["mysql"]["mysqli_dbas"];

        require_once APPROOT . '/model/clsCrypt.php';
        $objCrypt = new Crypt();
        $this->mysqli_pass = trim($objCrypt->decrypt(rawurldecode($this->mysqli_pass)));
    }

}
