<?php

class MyConnLC {

    protected $mysqli_host = "";
    protected $mysqli_user = "";
    protected $mysqli_pass = "";
    protected $mysqli_dbas = "";
    private $mysqli;

    function __construct() {
        $this->load_ini();
        $this->mysqli = new mysqli($this->mysqli_host, $this->mysqli_user, $this->mysqli_pass, $this->mysqli_dbas);
        if ($this->mysqli->connect_error) {
            die('Connect Error: ' . $this->mysqli->connect_error);
        }
    }

    function NO_DB() {
        unset($this->mysqli);
        $this->load_ini();
        $this->mysqli = new mysqli($this->mysqli_host, $this->mysqli_user, $this->mysqli_pass);
        if ($this->mysqli->connect_error) {
            die('Connect Error: ' . $this->mysqli->connect_error);
        }
    }

    function get_conn() {
        return $this->mysqli;
    }

    function __destruct() {
        $this->mysqli->close();
    }

    private function load_ini() {
        /*Load values from .ini*/
        define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
        $ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
        define('APPBASE', $ini_array["general"]["appbase"]);        
        $this->mysqli_host = $ini_array["mysql_lc"]["mysqli_host"];
        $this->mysqli_user = $ini_array["mysql_lc"]["mysqli_user"];
        $this->mysqli_pass = $ini_array["mysql_lc"]["mysqli_pass"];
        $this->mysqli_dbas = $ini_array["mysql_lc"]["mysqli_dbas"];

        require_once APPROOT . '/model/clsCrypt.php';
        $objCrypt = new Crypt();
        $this->mysqli_pass = trim($objCrypt->decrypt(rawurldecode($this->mysqli_pass)));
    }

}
