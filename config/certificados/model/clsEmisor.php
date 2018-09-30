<?php

class Emisor {

    protected $obj_bconn;
    protected $dbh;
    protected $user_id = 0;
    protected $nombre = 0;
    protected $formato = "";
    protected $ruta = 0;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute($emisor) {
        //INSERT INTO archivo(id, nombre, formato, ruta, iuser_id) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])
        $result = false;
        if ($emisor["nombre"] == 0) {
            $SQL = "INSERT INTO emisor(
                nombre,
                 sucursal,
                 numerosucursal,
                 numerocaja,
                 nombrecomercial,
                 identificaciontributaria,
                 codigopais,
                 telefono,
                 fax,
                 provincia,
                 canton,
                 distrito,
                 barrio,
                 otrassenias,
                 correoelectronico,
                 tipoidentificacion_id,
                 identificacionextranjero,
                 iuser_id
                 ) 
                VALUES (
                '" . $this->cc($emisor["nombre"]) . "',
                '" . $this->cc($emisor["sucursal"]) . "',
                " . $emisor["numerosucursal"] . ",
                " . $emisor["numerocaja"] . ",
                '" . $this->cc($emisor["nombrecomercial"]) . "',
                '" . $this->cc($emisor["identificaciontributaria"]) . "',
                " . $emisor["codigopais"] . ",
                " . $emisor["telefono"] . ",
                " . ($emisor["fax"] ? $emisor["fax"] : 'null') . ",
                " . $emisor["provincia"] . ",
                " . $emisor["canton"] . ",
                " . $emisor["distrito"] . ",
                " . $emisor["barrio"] . ",
                '" . $this->cc($emisor["otrassenias"]) . "',
                '" . $this->cc($emisor["correoelectronico"]) . "',
                " . $emisor["tipoidentificacion_id"] . ",
                '" . ($this->cc($emisor["identificacionextranjero"]) ? $this->cc($emisor["identificacionextranjero"]) : '') . "',
                " . $emisor["iuser_id"] . "
                );";

            //echo $SQL;

            $result = mysqli_query($this->dbh, $SQL);
            $id = mysqli_insert_id($this->dbh);
            $SQL = "INSERT INTO consecutivos( factura, notadebito, notacredito, tiquete, emisor_id) VALUES (0,0,0,0,$id)";
            $result = mysqli_query($this->dbh, $SQL);
        } else {
            $SQL = "UPDATE emisor SET
                nombre='" . $this->cc($emisor["nombre"]) . "',
                sucursal='" . $this->cc($emisor["sucursal"]) . "',
                numerosucursal=" . $emisor["numerosucursal"] . ",
                numerocaja=" . $emisor["numerocaja"] . ",
                nombrecomercial='" . $this->cc($emisor["nombrecomercial"]) . "',
                identificaciontributaria='" . $this->cc($emisor["identificaciontributaria"]) . "',
                codigopais=" . $emisor["codigopais"] . ",
                telefono=" . $emisor["telefono"] . ",
                fax=" . ($emisor["fax"] ? $emisor["fax"] : 'null') . ",
                provincia=" . $emisor["provincia"] . ",
                canton=" . $emisor["canton"] . ",
                distrito=" . $emisor["distrito"] . ",
                barrio=" . $emisor["barrio"] . ",
                otrassenias='" . $this->cc($emisor["otrassenias"]) . "',
                correoelectronico='" . $this->cc($emisor["correoelectronico"]) . "',
                tipoidentificacion_id=" . $emisor["tipoidentificacion_id"] . ",
                identificacionextranjero='" . ($this->cc($emisor["identificacionextranjero"]) ? $this->cc($emisor["identificacionextranjero"]) : '') . "'
                WHERE  iuser_id =" . $emisor["iuser_id"] . " ;";

            //echo $SQL;

            $result = mysqli_query($this->dbh, $SQL);
        }

        $ret = FALSE;
        if ($result) {
            $ret = TRUE;
        }
        return $ret;
    }

    public function getEmisorInfo($userId) {
        $SQL = "SELECT
                emisor.nombre,
                tipoidentificacion.codigo AS tipocedula,
                emisor.identificaciontributaria,
                emisor.nombrecomercial,
                emisor.provincia,
                emisor.canton,
                emisor.distrito,
                emisor.barrio,
                emisor.otrassenias,
                emisor.codigopais,
                emisor.telefono,
                emisor.fax,
                emisor.correoelectronico
              FROM
                emisor
                INNER JOIN tipoidentificacion ON tipoidentificacion.id = emisor.tipoidentificacion_id
              WHERE
                emisor.iuser_id =" . $userId . ";";

        $result = mysqli_query($this->dbh, $SQL);
        $json = null;
        while ($row = mysqli_fetch_row($result)) {
            $json[] = array(
                'tipocedula' => ($row[1] == "02") ? "fisico" : "fisico",
                'cedula' => $row[2],
                'codigopais' => $row[9],
                'emisor_nombre' => $this->html($row[0]),
                'emisor_tipo_indetif' => $row[1],
                'emisor_num_identif' => $row[2],
                'nombre_comercial' => $this->html($row[3]),
                'emisor_provincia' => $this->html($row[4]),
                'emisor_canton' => $this->html($row[5]),
                'emisor_distrito' => $this->html($row[6]),
                'emisor_barrio' => $this->html($row[7]),
                'emisor_otras_senas' => $this->html($row[8]),
                'emisor_cod_pais_tel' => $row[9],
                'emisor_tel' => $row[10],
                'emisor_cod_pais_fax' => ($row[11]) ? $row[9] : "",
                'emisor_fax' => ($row[11]) ? $row[11] : "",
                'emisor_email' => $row[12],
            );
        }

        return $json;
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
            $this->nombre = ""



            ;
        }
    }

    function set_Formato($str) {
        if (is_string($str)) {
            $this->formato = $this->cc($str);
        } else {
            $this->formato = ""



            ;
        }
    }

    function set_Ruta($str) {
        if (is_string($str)) {
            $this->ruta = $this->cc($str);
        } else {
            $this->ruta = ""



            ;
        }
    }

    public function cc($data) {
        return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

    public function html($str) {
        return htmlentities($str, (int) $this->htmlentities_flags, "Windows-1252", true);
    }

}

?>