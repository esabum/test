<?php

class Label {

    protected $obj_bconn;
    protected $dbh;
    protected $lbl = array();
    protected $lblName = array();
    protected $lblDescription = array();
    protected $lbls = array();
    protected $json_lbls = array();
    protected $lang = '> 0';
    protected $count = 0;
    protected $filter = '';
    protected $htmlentities_flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {

        $SQL = "SELECT name, language_id, description ";
        $SQL .= "FROM labels ";
        $SQL .= "WHERE name like '%$this->filter%' ";
        $SQL .= "OR description like '%$this->filter%' ";
        $SQL .= "ORDER BY name, language_id;";

        $result = mysqli_query($this->dbh, $SQL);
        $x = 0;
        while ($row = mysqli_fetch_row($result)) {
            if (!isset($this->lbl[$x][0])) {
                $this->lbl[$x][0] = $row[0];
            }
            if ($this->lbl[$x][0] != $row[0]) {
                $x++;
                $this->lbl[$x][0] = $row[0];
            }
            $this->lbl[$x][$row[1]] = $row[2];
        }
        $this->count = (count($this->lbl));
        mysqli_free_result($result);
    }

    public function executeSpecificLbls() {
        $SQL = "Select
              labels.name,
              labels.description
            From
              labels
            Where
              labels.name In ('" . implode("','", $this->lbls) . "') And
              labels.language_id " . $this->lang .
                " Order By
              labels.name,
              labels.language_id;";

        //echo $SQL;
        $this->Clear_Results();

        $result = mysqli_query($this->dbh, $SQL);

        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $this->lblName[] = $row[0];
            $this->lblDescription[] = $row[1];

            $this->json_lbls[$this->lblName[$i]] = htmlentities($this->lblDescription[$i], (int) $this->htmlentities_flags, "Windows-1252", true);
            $i++;
        }
        mysqli_free_result($result);
    }

    public function get_Label($ROW, $langId) {
        if (is_numeric($ROW) && is_numeric($langId)) {
            if (isset($this->lbl[$ROW][$langId])) {
                return htmlentities($this->lbl[$ROW][$langId], (int) $this->htmlentities_flags, "Windows-1252", true);
            } else {
                return '';
            }
        }
    }

    public function get_Clabel($ROW, $langId) {
        if (is_numeric($ROW) && is_numeric($langId)) {
            if (isset($this->lbl[$ROW][$langId])) {
                return $this->lbl[$ROW][$langId];
            } else {
                return '';
            }
        }
    }

    # Properties for setting Filter Values

    public function set_Filter($text) {
        $this->filter = $text;
    }

    public function set_Lbls($arr) {
        if (is_array($arr)) {
            $this->lbls = $arr;
        } else {
            $this->lbls = array();
        }
    }

    public function set_Language($int) {
        if (is_numeric($int)) {
            $this->lang = "= $int";
        } else {
            $this->lang = "> 0";
        }
    }

    #Properties for getting individual results

    public function get_Count() {
        return $this->count;
    }
    public function get_LabelsArray() {
        return $this->json_lbls;
    }
    public function get_jsonLbls() {
        //Convert Special characters
        $list = get_html_translation_table(HTML_ENTITIES);
        unset($list['"']);
        unset($list['<']);
        unset($list['>']);
        unset($list['&']);
        $search = array_keys($list);
        $values = array_values($list);
        $outarr =  $this->json_lbls;
        return str_replace(array('<\/', '\/>'), array('</', '/>'), str_replace($values, $search, json_encode($outarr)));
    }

    function Clear_Results() {
        $this->lbl = array();
        $this->lbls = array();
        $this->json_lbls = array();
        $this->lblName = array();
        $this->lblDescription = array();
        $this->count = 0;
    }

}

?>