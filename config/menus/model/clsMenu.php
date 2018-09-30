<?php

class Menu {

    //Class that feeds the menu drop-down, in mnuEditor.php

    protected $obj_bconn;
    protected $dbh;
    protected $flag = "ENT_SUBSTITUTE";
    //Filters
    protected $id = ">= 0";
    protected $lang = 1;
    //Attributes
    protected $ID = array();
    protected $labelName = array();
    protected $icon = array();
    protected $URL = array();
    protected $Name = array();
    protected $accessBit = array();
    protected $count = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT imenus.id, imenus.label_name, imenus.icon, imenus.url, Coalesce(labels.description, imenus.label_name) As name, Group_Concat(imenu_iaccesses.iaccess_bit) As accesses 
	FROM imenus
		LEFT JOIN labels
			ON imenus.label_name = labels.name
		LEFT JOIN imenu_iaccesses
			ON imenu_iaccesses.imenu_id = imenus.id 
	WHERE imenus.id $this->id
		AND (labels.language_id = $this->lang
		OR labels.language_id Is Null) 
	GROUP BY imenus.id, imenus.label_name, imenus.icon, imenus.url, labels.description 
	ORDER BY Coalesce(labels.description, imenus.label_name);";

        //echo $SQL;
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result)) {
            $this->ID[] = $row[0];
            $this->labelName[] = $row[1];
            $this->icon[] = $row[2];
            $this->URL[] = $row[3];
            $this->Name[] = $row[4];
            $this->accessBit[] = explode(',', $row[5]);
        }
        $this->count = count($this->ID);
        mysqli_free_result($result);
    }

    public function get_Count() {
        return $this->count;
    }

    public function get_ID($id) {
        if ($id < $this->count) {
            return $this->ID[$id];
        }
    }

    public function get_Label_Name($id) {
        if ($id < $this->count) {
            return $this->labelName[$id];
        }
    }

    public function get_Icon($id, $FORMAT = "HTML") {
        if ($id < $this->count) {
            if ($FORMAT == 'HTML') {
                return htmlentities($this->icon[$id], (int) $this->flag, "Windows-1252", true);
            } else {
                return $this->icon[$id];
            }
        }
    }

    public function get_URL($id, $FORMAT = "HTML") {
        if ($id < $this->count) {
            if ($FORMAT == 'HTML') {
                return htmlentities($this->URL[$id], (int) $this->flag, "Windows-1252", true);
            } else {
                return $this->URL[$id];
            }
        }
    }

    public function get_Name($id, $FORMAT = "HTML") {
        if ($id < $this->count) {
            if ($FORMAT == 'HTML') {
                return htmlentities($this->Name[$id], (int) $this->flag, "Windows-1252", true);
            } else {
                return $this->Name[$id];
            }
        }
    }

    public function get_HasAccess($id, $bit) {
        if ($id < $this->count && is_numeric($bit)) {
            return in_array($bit, $this->accessBit[$id]);
        }
    }

    public function set_ID($int) {
        if (is_numeric($int) && $int > -1) {
            $this->id = "= $int";
        } else {
            $this->id = ">= 0";
        }
    }

    public function set_LanguageId($int) {
        if (is_numeric($int) && $int > -1) {
            $this->lang = $int;
        } else {
            $this->lang = 1;
        }
    }

    private function Clear_Results() {
        $this->ID = array();
        $this->labelName = array();
        $this->icon = array();
        $this->URL = array();
        $this->accessBit = array();
        $this->count = 0;
    }

}
