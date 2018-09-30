<?php

class Paises {

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
                    id,
                    codigo,
                    descripcion,
                    codigonumerico
                  FROM
                    paises;";
        //echo $SQL;
        $result = mysqli_query($this->dbh, $SQL);

        $this->json = array();
        while ($row = mysqli_fetch_row($result)) {
            $this->json[] = array(
                "id" => $row[0],
                "codigo" => $row[1],
                "descripcion" => $this->html_entities($row[2]),
                "codigonumerico" => $row[3]
            );
        }
        mysqli_free_result($result);
        return $this->json;
    }

    public function html_entities($data) {
        return htmlentities($data, (int) $this->flags, "Windows-1252", true);
    }

}
