<?php

class AuthUser {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $Id = 0;
    protected $First = "";
    protected $Last = "";
    protected $DefLangID = 0;
    protected $Access = 0;
    protected $Email = "";
    protected $Theme = "";
    protected $auth = false;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    function authenticate($user, $pass) {

        $pass = md5($pass);
        $SQL = "Select
                    iusers.first,
                    iusers.last,
                    iusers.language_id,
                    iusers.iaccess_bit,
                    iusers.id,
                    iusers.email,
                    iusers.theme
                  From
                    iusers
                  Where
                    iusers.enabled = True And
                    iusers.email Like '{$user}' And
                    iusers.pass Like '{$pass}'
                  Group By
                    iusers.id";
                    //echo $SQL;
        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        if ($row = mysqli_fetch_row($result)) {
            $this->First = $row[0];
            $this->Last = $row[1];
            $this->DefLangID = $row[2];
            $this->Access = $row[3];
            $this->Id = $row[4];
            $this->Email = $row[5];
            $this->Theme = $row[6];
            $this->auth = true;
        }
        mysqli_free_result($result);

        if ($this->auth) {
            $uuid = '';
            $SQL = "SELECT uuid();\n";
            $result = mysqli_query($this->dbh, $SQL);
            if ($row = mysqli_fetch_row($result)) {
                $uuid = $row[0];
                mysqli_free_result($result);
            }
            if ($uuid) {
                $SQL = "UPDATE iusers
                            SET uuid = UNHEX(CONCAT(SUBSTR('$uuid', 15, 4), SUBSTR('$uuid', 10, 4), SUBSTR('$uuid',  1, 8), SUBSTR('$uuid', 20, 4), SUBSTR('$uuid', 25) ))
                            WHERE id = $this->Id;\n";
                $result = mysqli_query($this->dbh, $SQL);
                if ($result) {
                    return $uuid;
                }
            }
        }
    }

    function authorize($user_id, $uuid) {
        $SQL = "Select
                    iusers.first,
                    iusers.last,
                    iusers.language_id,
                    iusers.iaccess_bit,
                    iusers.id,
                    iusers.email,
                    iusers.theme
                  From
                    iusers
                  Where
                    iusers.id = {$user_id} And
                    iusers.uuid = UNHEX(CONCAT(SUBSTR('{$uuid}', 15, 4), SUBSTR('{$uuid}', 10, 4), SUBSTR('{$uuid}',  1, 8), SUBSTR('{$uuid}', 20, 4), SUBSTR('{$uuid}', 25)))
                  Group By
                    iusers.id";

        $this->Clear_Results();
        $result = mysqli_query($this->dbh, $SQL);
        if ($row = mysqli_fetch_row($result)) {
            $this->First = $row[0];
            $this->Last = $row[1];
            $this->DefLangID = $row[2];
            $this->Access = $row[3];
            $this->Id = $row[4];
            $this->Email = $row[5];
            $this->Theme = $row[6];
            $this->auth = true;
        }

        mysqli_free_result($result);
        return $this->auth;
    }

    // Properties for getting individual results
    public function get_ID() {
        return $this->Id;
    }

    public function get_FirstName() {
        return $this->First;
    }

    public function get_LastName() {
        return $this->Last;
    }

    public function get_DefLangID() {
        return $this->DefLangID;
    }

    public function get_Access() {
        return $this->Access;
    }

    public function get_Email() {
        return $this->Email;
    }

    public function get_Theme() {
        return $this->Theme;
    }

    // Emptying the Results arrays
    private function Clear_Results() {
        $this->Id = 0;
        $this->First = "";
        $this->Last = "";
        $this->DefLangID = 0;
        $this->Access = 0;
        $this->Email = "";
        $this->Theme = "";
        $this->auth = false;
    }

}
