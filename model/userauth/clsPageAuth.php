<?php

class PageAuth {

    protected $userid = 0;
    protected $url1 = '';
    protected $url2 = '';

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        if ($this->url1) {
            $SQL = "SELECT imenus.url, iusers.iaccess_bit & imenu_iaccesses.iaccess_bit 
                    FROM imenus
                        INNER JOIN imenu_iaccesses
                                ON imenu_iaccesses.imenu_id = imenus.id, iusers 
                    WHERE (imenus.url = '$this->url1'
                        OR imenus.url = '$this->url2')
                        AND iusers.id = $this->userid
                        AND iusers.iaccess_bit & imenu_iaccesses.iaccess_bit > 0;";

            $result = mysqli_query($this->dbh, $SQL);
            if (mysqli_num_rows($result)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    // roperties for getting individual results
    public function set_UserId($int) {
        if (is_numeric($int)) {
            $this->userid = $int;
        } else {
            $this->userid = 0;
        }
    }

    public function set_URL($str) {
        if ($str) {
            rtrim($str, '/');
            $this->url1 = str_replace(APPBASE, '', $str);
            $this->url2 = str_replace(APPBASE, '/', $str);
        } else {
            $this->url1 = '';
            $this->url2 = '';
        }
    }

}
