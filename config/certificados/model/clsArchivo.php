<?php

class Archivo {

    protected $obj_bconn;
    protected $dbh;
    protected $user_id = 0;
    protected $nombre = 0;
    protected $formato = "";
    protected $clave = "";
    protected $ruta = 0;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    protected $json = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        //INSERT INTO archivo(id, nombre, formato, ruta, iuser_id) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])

        $SQL = "INSERT INTO archivo(nombre, formato, ruta, iuser_id, clave) 
                VALUES ('$this->nombre','$this->formato','$this->ruta',$this->user_id ,'$this->clave')
                    ON DUPLICATE KEY UPDATE 
                 nombre ='$this->nombre', formato='$this->formato', ruta='$this->ruta', clave= $this->clave ;";

        //echo $SQL;

        $result = mysqli_query($this->dbh, $SQL);
        $ret = FALSE;
        if ($result) {
            $ret = TRUE;
        }
        return $ret;
    }
    
    public function getInfo() {

        $SQL = "SELECT nombre, formato , ruta, clave FROM archivo WHERE iuser_id = $this->user_id ;";

        //echo $SQL;

        $result = mysqli_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                'nombre' => $row[0],
                'formato' => $row[1],
                'ruta' => $row[2],
                'clave' => $row[3]
            );
        }

        return $this->json;
    }    

    public function set_User_Id($int) {
        if (is_numeric($int)) {
            $this->user_id = $int;
        } else {
            $this->user_id = 0;
        }
    }

    function set_Nombre($str) {
        if (is_string($str)) {
            $this->nombre = $this->cc($str);
        } else {
            $this->nombre = "";
        }
    }

    function set_Formato($str) {
        if (is_string($str)) {
            $this->formato = $this->cc($str);
        } else {
            $this->formato = "";
        }
    }
    
    function set_Clave($str) {
        if (is_string($str)) {
            $this->clave = $this->cc($str);
        } else {
            $this->clave = "";
        }
    }

    function set_Ruta($str) {
        if (is_string($str)) {
            $this->ruta = $this->cc($str);
        } else {
            $this->ruta = "";
        }
    }

    public function cc($data) {
        return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

}

?>