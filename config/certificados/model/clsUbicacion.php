<?php

class Ubicacion {

    protected $flags = "ENT_SUBSTITUTE";
    protected $obj_bconn;
    protected $dbh;
    protected $json = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function getProvicias() {
        $SQL = "SELECT distinct
                    codificacionubicacion.provincia_id,
                    codificacionubicacion.provincia
                  FROM
                    codificacionubicacion;";
        //echo $SQL;


        $result = mysqli_query($this->dbh, $SQL);
        $this->json = array();
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "codigo" => $row[0],
                "descripcion" => $this->html_entities($row[1])
            );
        }
        mysqli_free_result($result);
        //print_r($this->json);
        return $this->json;
    }

    public function getCantones($prov) {
        $SQL = "SELECT DISTINCT
                    codificacionubicacion.canton_id,
                    codificacionubicacion.canton
                  FROM
                    codificacionubicacion
                  WHERE
                    codificacionubicacion.provincia_id =" . $prov . ";";
        //echo $SQL;


        $result = mysqli_query($this->dbh, $SQL);

        $this->json = array();
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "codigo" => $row[0],
                "descripcion" => $this->html_entities($row[1])
            );
        }
        mysqli_free_result($result);
        return $this->json;
    }

    public function getDistritos($prov, $cant) {
        $SQL = "SELECT DISTINCT
                    codificacionubicacion.distrito_id,
                    codificacionubicacion.distrito
                  FROM
                    codificacionubicacion
                  WHERE
                    codificacionubicacion.provincia_id = " . $prov . " AND
                    codificacionubicacion.canton_id = " . $cant . ";";
        //echo $SQL;


        $result = mysqli_query($this->dbh, $SQL);

        $this->json = array();
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "codigo" => $row[0],
                "descripcion" => $this->html_entities($row[1])
            );
        }
        mysqli_free_result($result);
        return $this->json;
    }

    public function getBarrios($prov, $cant, $dist) {
        $SQL = "SELECT DISTINCT
                    codificacionubicacion.barrio_id,
                    codificacionubicacion.barrio
                  FROM
                    codificacionubicacion
                  WHERE
                    codificacionubicacion.provincia_id = " . $prov . " AND
                    codificacionubicacion.canton_id = " . $cant . " AND
                    codificacionubicacion.distrito_id = " . $dist . ";";
        //echo $SQL;


        $result = mysqli_query($this->dbh, $SQL);

        $this->json = array();
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "codigo" => $row[0],
                "descripcion" => $this->html_entities($row[1])
            );
        }
        mysqli_free_result($result);
        return $this->json;
    }

    public function get_Json() {
        return $this->json;
    }

    public function html_entities($data) {
        return htmlentities($data, (int) $this->flags, "Windows-1252", true);
    }

}
