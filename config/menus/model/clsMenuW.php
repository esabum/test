<?php

class MenuW {

    protected $obj_bconn;
    protected $dbh;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    //Filters
    //Attributes
    protected $id = 0;
    protected $labelName = '';
    protected $icon = '';
    protected $URL = '';
    protected $accessBit = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        if ($this->id == 0) {
            //Insert Menus
            $SQL = "INSERT INTO imenus(label_name, icon, url) VALUES('$this->labelName', '$this->icon', '$this->URL');\n";
            mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
            $this->id = mysqli_insert_id($this->dbh);
        } else {
            //Update Menus
            $SQL = "UPDATE imenus
                        SET imenus.label_name = '$this->labelName',
                            imenus.icon = '$this->icon',
                            imenus.url = '$this->URL'
                        Where imenus.id = $this->id;\n";
            mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
        }

        //Update Accesses
        if (count($this->accessBit)) {
            $values = array();
            for ($i = 0; $i < count($this->accessBit); $i++) {
                $values[] = "($this->id,{$this->accessBit[$i]})";
            }
            $SQL = "REPLACE INTO imenu_iaccesses (imenu_id , iaccess_bit) VALUES " . implode(",\n", $values) . ";\n";
            mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));

            $SQL = "DELETE FROM imenu_iaccesses WHERE imenu_id = $this->id AND iaccess_bit NOT IN (" . implode(", ", $this->accessBit) . ");";
            mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
        } else {
            $SQL = "DELETE FROM imenu_iaccesses WHERE imenu_id = $this->id;";
            mysqli_query($this->dbh, $SQL)or die(mysqli_error($this->dbh));
        }
        return $this->id;
    }

    /*      public function delete() {
      $SQL = "DELETE FROM menus ";
      $SQL .= "WHERE (id = $this->id);";
      $result = mysqli_query($this->dbh, $SQL);
      return $result;
      }
     */

    public function set_Id($int) {
        if (is_numeric($int) && $int > 0) {
            $this->id = $int;
        } else {
            $this->id = 0;
        }
    }

    public function set_LabelName($str) {
        if ($str) {
            $this->labelName = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->labelName = '';
        }
    }

    public function set_Icon($str) {
        if ($str) {
            $this->icon = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->icon = '';
        }
    }

    public function set_URL($str) {
        if ($str) {
            $this->URL = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->URL = '';
        }
    }

    public function set_AccessRights($arr) {
        if (is_array($arr)) {
            $this->accessBit = $arr;
        } else {
            $this->accessBit = array();
        }
    }

}
