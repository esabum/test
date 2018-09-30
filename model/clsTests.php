<?php

class Tests {

    protected $obj_bconn;
    protected $dbh;
    protected $id = 0;
    protected $count = 0;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function insert() {

        $provincias = $this->getArrayProvincias();
        $arrProv = array();
        foreach ($provincias as $key => $item) {
            $SQL="INSERT INTO provincias( name, pais_id) VALUES ('".$this->cc($item)."',1);\n";
            //echo "<p>$SQL</p>";
            $result = mysqli_query($this->dbh, $SQL);
            $idProv = mysqli_insert_id($this->dbh);
            $cantones = $this->getArrayCantonesPorProvincia($key);
            $arrCanto = array();
            foreach ($cantones as $key2 => $item2) {
                $SQL="INSERT INTO cantones( name, provincia_id) VALUES ('".$this->cc($item2)."',$idProv);\n";  
                //echo "<p>$SQL</p>";
                $result = mysqli_query($this->dbh, $SQL);
                $idCant = mysqli_insert_id($this->dbh);
                $distritos = $this->getArrayDisctritoPorCanton($key, $key2);
                $arrDist = array();
                foreach ($distritos as $key3 => $item3) {
                    $SQL="INSERT INTO distritos( name, canton_id) VALUES ('".$this->cc($item3)."',$idCant);\n";
                    //echo "<p>$SQL</p>";
                    $result = mysqli_query($this->dbh, $SQL);                   
                    $arrDist[] = $item3;
                }
                $arrCanto[] = array("canton" => $item2, "distritos" => $arrDist);
            }
            $arrProv[] = array("provincia" => $item, "cantones" => $arrCanto);
        }
    }

    public function execute($arr) {
       $SQL = "INSERT INTO codificacionubicacion(provincia_id, provincia, canton_id, canton, distrito_id, distrito, barrio_id, barrio) VALUES ";
       $values = array();
       $counts=0;
        foreach ($arr as $value) {
          $values[] = "\n(" . $value[0+$counts] . ", '" . $value[1+$counts] . "'," . $value[2+$counts] . ", '" . $value[3+$counts] . "'," . $value[4+$counts] . ", '" . $value[5+$counts] . "', " . $value[6+$counts] . " , '" . $value[7+$counts] . "')";
            $counts = $counts+8;
        }
        $SQL.= implode(",",$values).";";
        echo $SQL;
        
       // $result = mysqli_query($this->dbh, $SQL);

       // mysqli_free_result($result);
        
         
    }

    public function set_Id($int) {
        if (is_numeric($int)) {
            $this->id = $int;
        } else {
            $this->id = 0;
        }
    }

    public function get_Count() {
        return $this->count;
    }

    public function getArrayDisctritoPorCanton($idProvinca, $idCanton) {
        $arrayDisctritos = array();
        $url = "https://ubicaciones.paginasweb.cr/provincia/" . $idProvinca . "/canton/" . $idCanton . "/distritos.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        return $json;
    }

    public function getArrayCantonesPorProvincia($id) {
        $url = "https://ubicaciones.paginasweb.cr/provincia/" . $id . "/cantones.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        return $json;
    }

    public function getArrayProvincias() {
        $url = "https://ubicaciones.paginasweb.cr/provincias.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        return $json;
    }
    
    public function cc($data){
       return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

}

?>