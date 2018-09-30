<?php

class GroupSelectList {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $count = 0;
    protected $flag = "ENT_SUBSTITUTE";
    protected $SELECTEDGROUPIDS = array(0);
    protected $USERID = 0;
    protected $GROUPIDS = array(0);
    protected $id = array();
    protected $name = array();
    protected $initials = array();
    protected $avatar = array();

    function __construct() {
        require_once APPROOT . "/model/dbconnector/clsMyDBConn.php";
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT DISTINCT iusergroups.id, iusergroups.name, iusergroups.short, NULL AS avatar 
    FROM iusergroups 
        LEFT JOIN (
            SELECT iuser_groups.iusergroup_id 
                FROM iuser_groups 
                WHERE iuser_groups.iuser_id = $this->USERID
        ) gmem
            ON iusergroups.id = gmem.iusergroup_id 
    ORDER BY
        iusergroups.id NOT IN (" . implode(', ', $this->SELECTEDGROUPIDS) . "),
        iusergroups.id NOT IN (" . implode(', ', $this->GROUPIDS) . "),
        isnull(gmem.iusergroup_id),
        iusergroups.name;\n";

        //echo "<div style='display: none;'>".$SQL."</div>";
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        while ($row = mysqli_fetch_row($result)) {
            $this->id[] = $row[0];
            $this->name[] = $row[1];
            $this->initials[] = $row[2];
            $this->avatar[] = $row[3];
        }
        mysqli_free_result($result);
        $this->count = count($this->id);
    }

    public function get_Count() {
        return $this->count;
    }

    public function get_Id($id) {
        if (is_numeric($id) && $id < $this->count) {
            return $this->id[$id];
        } else {
            return 0;
        }
    }

    public function get_Name($id, $FORMAT = "NORMAL") {
        if (is_numeric($id) && $id < $this->count) {
            switch ($FORMAT) {
                case "HTML" :
                    return htmlentities($this->name[$id], (int) $this->flag, "Windows-1252", true);
                case "INPUT" :
                    return htmlspecialchars_decode(htmlspecialchars(htmlentities($this->name[$id], (int) $this->flag, "Windows-1252", true)), ENT_NOQUOTES);
                default :
                    return $this->name[$id];
            }
        } else {
            return "";
        }
    }

    public function get_Initials($id, $FORMAT = "NORMAL") {
        if (is_numeric($id) && $id < $this->count) {
            switch ($FORMAT) {
                case "HTML" :
                    return htmlentities($this->initials[$id], (int) $this->flag, "Windows-1252", true);
                case "INPUT" :
                    return htmlspecialchars_decode(htmlspecialchars(htmlentities($this->initials[$id], (int) $this->flag, "Windows-1252", true)), ENT_NOQUOTES);
                default :
                    return $this->initials[$id];
            }
        } else {
            return "";
        }
    }

    public function get_Avatar($id, $FORMAT = "NORMAL") {
        if (is_numeric($id) && $id < $this->count) {
            switch ($FORMAT) {
                case "HTML" :
                    return htmlentities($this->avatar[$id], (int) $this->flag, "Windows-1252", true);
                case "INPUT" :
                    return htmlspecialchars_decode(htmlspecialchars(htmlentities($this->avatar[$id], (int) $this->flag, "Windows-1252", true)), ENT_NOQUOTES);
                default :
                    return $this->avatar[$id];
            }
        } else {
            return "";
        }
    }

    public function set_SelectedGroupIds($arr) {
        if (is_array($arr) && !empty($arr)) {
            $this->SELECTEDGROUPIDS = $arr;
        } else {
            $this->SELECTEDGROUPIDS = array(0);
        }
    }

    public function set_UserId($int) {
        if (is_numeric($int)) {
            $this->USERID = $int;
        } else {
            $this->USERID = 0;
        }
    }

    public function set_GroupIds($arr) {
        if (is_array($arr) && !empty($arr)) {
            $this->GROUPIDS = $arr;
        } else {
            $this->GROUPIDS = array(0);
        }
    }

    private function Clear_Results() {
        $this->id = array();
        $this->name = array();
        $this->initials = array();
        $this->avatar = array();
        $this->count = 0;
    }

}
