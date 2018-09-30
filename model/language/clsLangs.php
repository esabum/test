<?php

class Languages {

    protected $obj_bconn;
    protected $dbh;
    protected $id = ">= 0";
    protected $SteEnabled = ">= 0";
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    protected $ID = array();
    protected $Name = array();
    protected $Shortname = array();
    protected $Enabled = array();
    protected $Image = array();
    protected $count = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }
    
    function execute() {
        $SQL = "SELECT id, name, short, flag , enabled ";
        $SQL .= "FROM languages ";
        $SQL .= "WHERE enabled $this->SteEnabled ";
        $SQL .= "AND id $this->id";
        //echo "<div style:'display: none;'>$SQL</div>";
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        while ($row = mysqli_fetch_row($result)) {
            $this->ID[] = $row[0];
            $this->Name[] = $row[1];
            $this->Shortname[] = $row[2];
            $this->Image[] = substr_replace($row[3], APPBASE, 1, 0);
            $this->Enabled[] = $row[4];
        }
        $this->count = count($this->ID);
        mysqli_free_result($result);
    }
    
    function languagesList() {
        $SQL = "SELECT id, name, short ";
        $SQL .= "FROM languages ";
        $SQL .= "WHERE enabled $this->SteEnabled ";
        //echo $SQL;
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $this->ID[] = $row[0];
            $this->Name[] = $row[1];
            $this->Shortname[] = $row[2];
            
            $this->obj[] = array(
                "id" => $this->ID[$i],
                "name" => htmlentities($this->Name[$i], (int) $this->htmlentities_flags, "Windows-1252", true),
                "shortname" => htmlentities($this->Shortname[$i], (int) $this->htmlentities_flags, "Windows-1252", true)
            );
            $i++;
        }
        //$this->count = count($this->ID);
        mysqli_free_result($result);
        
        return $this->obj;
    }

    #Properties for getting individual results

    public function get_Count() {
        return $this->count;
    }

    public function get_ID($id) {
        if ($id < $this->count) {
            return $this->ID[$id];
        }
    }

    public function get_IdByLanguage($language) {
        $id = array_search($language, $this->ID);
        if ($id === false) {
            return 1;
        } else {
            return $id;
        }
    }

    public function get_Name($id) {
        if ($id < $this->count) {
            return htmlentities($this->Name[$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    public function get_Came($id) {
        if ($id < $this->count) {
            return $this->Name[$id];
        }
    }

    public function get_Shortname($id) {
        if ($id < $this->count) {
            return $this->Shortname[$id];
        }
    }
    
    public function get_IdByShortname($short) {
        $index = array_search($short, $this->Shortname);
        if ($index == false) {
            return 1;
        } else {
            return $this->ID[$index];
        }
    }    

    public function get_Image($id) {
        if ($id < $this->count) {
            return $this->Image[$id];
        }
    }

    public function get_Enabled($id) {
        if ($id < $this->count) {
            return $this->Enabled[$id];
        }
    }

    public function get_Enabled_Text($id) {
        if ($id < $this->count) {
            if ($this->Enabled[$id] == 0) {
                return 'lblNo';
            } else {
                return 'lblYes';
            }
        }
    }

    # Properties for setting Filter Values

    public function set_ID($int) {
        if (is_numeric($int)) {
            $this->id = "= $int";
        } else {
            $this->id = ">= 0";
        }
    }

    public function set_LcEnabled($int) {
        if (is_numeric($int) && ($int == 0 || $int == 1)) {
            $this->SteEnabled = "= $int";
        } else {
            $this->SteEnabled = ">= 0";
        }
    }

    # Emptying the Results arrays

    private function Clear_Results() {
        $this->ID = array();
        $this->Name = array();
        $this->Shortname = array();
        $this->Image = array();
        $this->Enabled = array();
    }

}
