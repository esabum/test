<?php

class UserSelectList {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $count = 0;
    protected $flag = "ENT_SUBSTITUTE";
    protected $id = array();
    protected $name = array();
    protected $initials = array();
    protected $SELECTEDUSERIDS = array(0);
    protected $USERID = 0;
    protected $GROUPIDS = array(0);
    protected $ADDUSERIDS = array(0);

    function __construct() {
        require_once APPROOT . "/model/dbconnector/clsMyDBConn.php";
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        $SQL = "SELECT DISTINCT iusers.id,
        CONCAT_WS(' ',iusers.first,iusers.last) AS name,
        CONCAT(substr(iusers.first, 1, 1), substr(iusers.last, 1, 1)) AS initials 
    FROM iusers 
        LEFT JOIN (
            SELECT iuser_groups.iuser_id
                FROM iuser_groups 
                WHERE iuser_groups.iusergroup_id IN (" . implode(', ', $this->GROUPIDS) . ")
        ) gmem
            ON iusers.id = gmem.iuser_id
        LEFT JOIN (
            SELECT iuser_groups.iuser_id
                FROM iuser_groups 
                    INNER JOIN iuser_groups iuser_groups1
                        ON iuser_groups1.iusergroup_id = iuser_groups.iusergroup_id 
                WHERE iuser_groups1.iuser_id = $this->USERID
        ) gcom
            ON gcom.iuser_id = iusers.id 
    ORDER BY
        iusers.id NOT IN (" . implode(', ', $this->SELECTEDUSERIDS) . "),
        iusers.id != $this->USERID,
        isnull(gmem.iuser_id) AND iusers.id NOT IN (" . implode(', ', $this->ADDUSERIDS) . "),
        isnull(gcom.iuser_id),
        iusers.first,
        iusers.last;\n";

        //echo "<div style='display: none;'>".$SQL."</div>";
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        while ($row = mysqli_fetch_row($result)) {
            $this->id[] = $row[0];
            $this->name[] = $row[1];
            $this->initials[] = $row[2];
        }
        mysqli_free_result($result);
        $this->count = count($this->id);
    }

    public function get_Count() {
        return $this->count;
    }

    public function get_ID($id) {
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

    public function set_SelectedUserIds($arr) {
        if (is_array($arr) && !empty($arr)) {
            $this->SELECTEDUSERIDS = $arr;
        } else {
            $this->SELECTEDUSERIDS = array(0);
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

    public function set_AddUserIds($arr) {
        if (is_array($arr) && !empty($arr)) {
            $this->ADDUSERIDS = $arr;
        } else {
            $this->ADDUSERIDS = array(0);
        }
    }

    private function Clear_Results() {
        $this->id = array();
        $this->name = array();
        $this->initials = array();
        $this->count = 0;
    }

}
