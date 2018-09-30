<?php

class Menus {

    protected $obj_bconn;
    protected $dbh;
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    //get vars
    protected $count = 0;
    protected $parid = array();
    protected $parname = array();
    protected $paricon = array();
    protected $parurl = array();
    protected $subid = array();
    protected $subname = array();
    protected $subicon = array();
    protected $suburl = array();
    //set vars
    protected $userid = 0;
    protected $langid = 0;
    protected $type = 1;
    protected $showall = false;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    function execute() {
        $arrbit = array();
        $arracc = array();
	if (!$this->showall) {
	    $SQL = "Select conv(iaccess_bit,10,2) From iusers Where id = $this->userid;\n";
	    //Conv(N, from_base, to_base) converts numbers between different number bases. 
    	    //Returns a string representation of the number N, converted from base from_base to base to_base.
	    //In this case, we are passing "access_bit" from decimal (base 10) to binary (base 2).

            //echo "<div class='SQL' style='display: none;'>".$SQL."</div>";
            $result = mysqli_query($this->dbh, $SQL);
            while ($row = mysqli_fetch_row($result)) {
                $arrbit = str_split(strrev($row[0]));
            }
            mysqli_free_result($result);
        }else{
            $arrbit = str_split(strrev('1111111111111111')); //All access bits are enabled.
        }

        foreach ($arrbit as $key => $value) {
            if ($value == '1') {
                $arracc[] = pow(2, $key);
            }
        }
        $accesses = implode(", ", $arracc);
        if ($accesses) {
            $SQL = "SELECT DISTINCT imenus.id, coalesce(labels.description, imenus.label_name) As parname,  imenus.icon As paricon, TRIM(LEADING '/' FROM imenus.url) As parurl 
                    FROM  imenus
                        INNER JOIN  imenu_iaccesses
                            ON imenu_iaccesses.imenu_id = imenus.id
                    LEFT JOIN  labels
                        ON imenus.label_name = labels.name
                    WHERE imenus.parent Is Null
                        AND imenu_iaccesses.iaccess_bit In ($accesses)
                        AND (labels.language_id Is Null OR labels.language_id = $this->langid)
                        AND imenus.type = $this->type 
                    ORDER BY imenus.position;\n";

            //echo "<div class='SQL' style='display: none;'>".$SQL."</div>";
            $this->Clear_Results();
            $result = mysqli_query($this->dbh, $SQL);
            while ($row = mysqli_fetch_row($result)) {
                $this->parid[] = $row[0];
                $this->parname[] = $row[1];
                $this->paricon[] = $row[2];
                $this->parurl[] = $row[3];
            }
            $this->count = count($this->parid);
            mysqli_free_result($result);
            for ($i = 0; $i < $this->count; $i++) {
                $SQL = "SELECT DISTINCT imenus.id, coalesce(labels.description, imenus.label_name) As parname, imenus.icon As paricon, TRIM(LEADING '/' FROM imenus.url) As parurl 
                            FROM  imenus
                                INNER JOIN  imenu_iaccesses
                                    ON imenu_iaccesses.imenu_id = imenus.id
                            LEFT JOIN  labels
                                ON imenus.label_name = labels.name 
                            WHERE imenus.parent = {$this->parid[$i]}
                                AND imenu_iaccesses.iaccess_bit In ($accesses)
                                AND (labels.language_id Is Null OR labels.language_id = $this->langid)
                                AND imenus.type = $this->type 
                            ORDER BY imenus.position;\n";

                //echo "<div class='SQL' style='display: none;'>".$SQL."</div>";
                $result = mysqli_query($this->dbh, $SQL);
                while ($row = mysqli_fetch_row($result)) {
                    $this->subid[$i][] = $row[0];
                    $this->subname[$i][] = $row[1];
                    $this->subicon[$i][] = $row[2];
                    $this->suburl[$i][] = $row[3];
                }
                mysqli_free_result($result);
            }
        }
    }

    #Properties for getting individual results

    public function get_Count() {
        return $this->count;
    }

    public function get_SubCount($id) {
        if (array_key_exists($id, $this->subid)) {
            return count($this->subid[$id]);
        } else {
            return 0;
        }
    }

    public function get_ParentId($id) {
        if (is_numeric($id) && $id < $this->count) {
            return $this->parid[$id];
        }
    }

    public function get_Name($id) {
        if (is_numeric($id) && $id < $this->count) {
            return htmlentities($this->parname[$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    public function get_Icon($id) {
        if (is_numeric($id) && $id < $this->count) {
            return htmlentities($this->paricon[$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    public function get_URL($id) {
        if (is_numeric($id) && $id < $this->count) {
            return htmlentities($this->parurl[$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    public function get_SubId($parid, $id) {
        if (is_numeric($id) && is_numeric($parid) and $parid < $this->count) {
            return $this->subid[$parid][$id];
        }
    }

    public function get_SubName($parid, $id) {
        if (is_numeric($id) && is_numeric($parid) and $parid < $this->count) {
            return htmlentities($this->subname[$parid][$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    public function get_SubIcon($parid, $id) {
        if (is_numeric($id) && is_numeric($parid) and $parid < $this->count) {
            return htmlentities($this->subicon[$parid][$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    public function get_SubURL($parid, $id) {
        if (is_numeric($id) && is_numeric($parid) and $parid < $this->count) {
            return htmlentities($this->suburl[$parid][$id], (int) $this->htmlentities_flags, "Windows-1252", true);
        }
    }

    #Properties for setting individual filters

    public function set_TypeId($int) {
        if (is_numeric($int) && $int > -1 && $int < 3) {
            $this->type = $int;
        } else {
            $this->type = 1;
        }
    }

    public function set_UserId($int) {
        if (is_numeric($int) && $int > 0) {
            $this->userid = $int;
        } else {
            $this->userid = 0;
        }
    }

    public function set_LanguageId($int) {
        if (is_numeric($int) && $int > 0) {
            $this->langid = $int;
        } else {
            $this->langid = 1;
        }
    }

    public function set_ShowAll($bln) {
        if ($bln) {
            $this->showall = TRUE;
        } else {
            $this->showall = FALSE;
        }
    }

    private function Clear_Results() {
        $this->count = 0;
        $this->parid = array();
        $this->parname = array();
        $this->paricon = array();
        $this->parurl = array();
        $this->subname = array();
        $this->subicon = array();
        $this->suburl = array();
        $this->showall = FALSE;
    }

}
