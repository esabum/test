<?php

class Receptor {

    protected $obj_bconn;
    protected $dbh;
    protected $flags = "ENT_SUBSTITUTE";
    protected $json = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function insertUpdate($receptor) {
        $ret = FALSE;
        //INSERT INTO archivo(id, nombre, formato, ruta, iuser_id) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])
        if ($receptor["id"] == 0) {
            $SQL = "INSERT INTO receptores(
                    nombre,
                     razonsocial,
                     nombrecomercial,
                     identificacion,
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
                     identificacionextranjero
                     ) 
                    VALUES (
                    '" . $this->cc($receptor["nombre"]) . "',
                    '" . $this->cc($receptor["razonsocial"]) . "',
                    '" . $this->cc($receptor["nombrecomercial"]) . "',
                    '" . $this->cc($receptor["identificacion"]) . "',
                    " . $receptor["codigopais"] . ",
                    " . $receptor["telefono"] . ",
                    " . ($receptor["fax"] ? $receptor["fax"] : 'null') . ",
                    " . $receptor["provincia"] . ",
                    " . $receptor["canton"] . ",
                    " . $receptor["distrito"] . ",
                    " . $receptor["barrio"] . ",
                    '" . $this->cc($receptor["otrassenias"]) . "',
                    '" . $this->cc($receptor["correoelectronico"]) . "',
                    " . $receptor["tipoidentificacion_id"] . ",
                    '" . ($this->cc($receptor["identificacionextranjero"]) ? $this->cc($receptor["identificacionextranjero"]) : '') . "'
                    );";

            //echo $SQL;

            $result = mysqli_query($this->dbh, $SQL);
            $newid = mysqli_insert_id($this->dbh);

            $SQL = "INSERT INTO iuser_receptor(iuser_id, receptor_id) VALUES (" . $receptor["iuser_id"] . ", " . $newid . ")";
            $result = mysqli_query($this->dbh, $SQL);
            if ($result) {
                $ret = TRUE;
            }
        } else {
            $SQL = " UPDATE receptores SET
            nombre='" . $this->cc($receptor["nombre"]) . "',
            razonsocial='" . $this->cc($receptor["razonsocial"]) . "',
            numerosucursal=" . $receptor["numerosucursal"] . ",
            numerocaja=" . $receptor["numerocaja"] . ",
            nombrecomercial='" . $this->cc($receptor["nombrecomercial"]) . "',
            identificacion='" . $this->cc($receptor["identificacion"]) . "',
            codigopais=" . $receptor["codigopais"] . ",
            telefono=" . $receptor["telefono"] . ",
            fax=" . ($receptor["fax"] ? $receptor["fax"] : '') . ",
            provincia=" . $receptor["provincia"] . ",
            canton=" . $receptor["canton"] . ",
            distrito=" . $receptor["distrito"] . ",
            barrio=" . $receptor["barrio"] . ",
            otrassenias='" . $this->cc($receptor["otrassenias"]) . "',
            correoelectronico='" . $this->cc($receptor["correoelectronico"]) . "',
            tipoidentificacion_id=" . $receptor["tipoidentificacion_id"] . ",
            identificacionextranjero='" . ($this->cc($receptor["identificacionextranjero"]) ? $this->cc($receptor["identificacionextranjero"]) : '') . "'
            WHERE id=" . $receptor["id"] . ";";

            //echo $SQL;

            $result = mysqli_query($this->dbh, $SQL);

            if ($result) {
                $ret = TRUE;
            }
        }

        return $ret;
    }

    public function execute($userId) {
        $Id = (is_numeric($userId) && $userId > 0) ? $userId : 0;
        $SQL = "SELECT
                receptores.id,
                receptores.nombre,
                receptores.identificacion,
                receptores.telefono,
                receptores.correoelectronico
              FROM
                receptores
                INNER JOIN iuser_receptor ON iuser_receptor.receptor_id = receptores.id
              WHERE
                iuser_receptor.iuser_id = " . $Id;

        // echo $SQL;

        $result = mysqli_query($this->dbh, $SQL);
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "id" => $this->html($row[0]),
                "nombre" => $this->html($row[1]),
                "identificacion" => $this->html($row[2]),
                "telefono" => $this->html($row[3]),
                "correo" => $this->html($row[4]),
                "editBtn" => "<a target='_blank' class='btn btn-sm btn-primary pull-right m-l-10 m-b-10'  data-toggle='tooltip' data-placement='top' title='Editar' onclick='editReceptor(" . $row[0] . ")' ><i class='far fa-edit'></i></a>"
            );
        }
        mysqli_free_result($result);
        //return $this->get_JSON();
    }

    public function getReceptorInfo($receptorId) {
        $SQL = "SELECT
                receptores.nombre,
                tipoidentificacion.codigo,
                receptores.identificacion,
                receptores.provincia,
                receptores.canton,
                receptores.distrito,
                receptores.barrio,
                receptores.codigopais,
                receptores.telefono,
                receptores.fax,
                receptores.correoelectronico,
                receptores.otrassenias
              FROM
                receptores
                INNER JOIN tipoidentificacion ON tipoidentificacion.id = receptores.tipoidentificacion_id
              WHERE
                receptores.id = " . $receptorId;

         //echo $SQL;

        $result = mysqli_query($this->dbh, $SQL);
        $json = null;
        while ($row = mysqli_fetch_row($result)) {
            $json[] = array(
                "receptor_nombre" => html_entity_decode($this->html($row[0])),
                "receptor_tipo_identif" => $row[1],
                "receptor_num_identif" => $row[2],
                "receptor_provincia" => html_entity_decode($this->html($row[3])),
                "receptor_canton" => html_entity_decode($this->html($row[4])),
                "receptor_distrito" => html_entity_decode($this->html($row[5])),
                "receptor_barrio" => html_entity_decode($this->html($row[6])),
                "receptor_cod_pais_tel" => $row[7],
                "receptor_tel" => $row[8],
                "receptor_cod_pais_fax" => ($row[9]) ? $row[7] : "",
                "receptor_fax" => ($row[9]) ? $row[9] : "",
                "receptor_email" => html_entity_decode($this->html($row[10])),
                "receptor_otras_senas" => html_entity_decode($this->html($row[11]))
            );
        }
        mysqli_free_result($result);
        return $json;
    }

    public function getDataTable() {
        return $this->get_JSON();
    }

    public function getDataJson() {
        return $this->json;
    }

    public function get_JSON() {
        //Convert Special characters
        $list = get_html_translation_table(HTML_ENTITIES);
        unset($list['"']);
        unset($list['<']);
        unset($list['>']);
        unset($list['&']);
        $search = array_keys($list);
        $values = array_values($list);
        $outarr = array('data' => $this->json);
        return str_replace(array('<\/', '\/>'), array('</', '/>'), str_replace($values, $search, json_encode($outarr)));
    }

    public function cc($data) {
        return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

    public function html($data) {
        return htmlentities($data, (int) $this->flags, "Windows-1252", true);
    }

}

?>