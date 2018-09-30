<?php

class TipoIdentificacion {

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
        $SQL = "SELECT 
                    codigo,
                    descripcion,
                    id
                  FROM
                    tipoidentificacion;";
        //echo $SQL;
        $result = mysqli_query($this->dbh, $SQL);

        $this->json = array();
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "codigo" => $row[0],
                "descripcion" => $this->html_entities($row[1]),
                "id" => $row[2]
            );
        }
        mysqli_free_result($result);
        return $this->json;
    }

    public function html_entities($data) {
        return htmlentities($data, (int) $this->flags, "Windows-1252", true);
    }

}
