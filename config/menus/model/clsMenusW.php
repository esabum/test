<?php

class MenusW {

    protected $obj_bconn;
    protected $dbh;
    protected $htmlentities_flags = 'ENT_SUBSTITUTE';
    //Attributes
    protected $type = 0; //Menu types-> 0: hidden, 1: side, 2: top
    protected $ids = array();
    protected $tree = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "UPDATE imenus
                    SET type = $this->type
               WHERE id in (" . implode(', ', $this->ids) . ");";
        mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));

        $USQL = array();
        for ($i = 0; $i < count($this->tree); $i++) {
            $USQL[] = "UPDATE imenus SET position = $i, parent = NULL WHERE id = {$this->tree[$i]['id']};";
            if (array_key_exists('children', $this->tree[$i])) { //If the menus have submenus...
                for ($j = 0; $j < count($this->tree[$i]['children']); $j++) {
                    $USQL[] = "UPDATE imenus SET position = $j, parent = {$this->tree[$i]['id']} WHERE id = {$this->tree[$i]['children'][$j]['id']}";
                }
            }
        }

        for ($k = 0; $k < count($USQL); $k++) {
            mysqli_query($this->dbh, $USQL[$k])or die(mysqli_error($this->dbh));
        }
    }

    //GET DATA
    public function set_TypeId($int) {
        if (is_numeric($int) && $int > 0) {
            $this->type = $int;
        } else {
            $this->type = 0;
        }
    }

    public function set_Ids($arr) {
        if (is_array($arr)) {
            $this->ids = $arr;
        } else {
            $this->ids = array();
        }
    }

    public function set_Tree($arr) {
        if (is_array($arr)) {
            $this->tree = $arr;
        } else {
            $this->tree = array();
        }
    }

}
