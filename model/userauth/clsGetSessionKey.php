<?php

class SessionKey {

    protected $obj_bconn;
    protected $dbh;
    protected $id = 0;
    protected $count = 0;
    protected $user = "";
    protected $userid = 0;
    protected $pass = "";
    protected $email = "";
    protected $sessionKey = "";
    protected $htmlentities_flags = "ENT_SUBSTITUTE";
    protected $apiurl = "";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();

        $ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
        $this->apiurl = $ini_array["api"]["url"];
        /*
          require_once APPROOT . '/model/clsCrypt.php';
          $objCrypt = new Crypt();
          $this->mysqli_pass = trim($objCrypt->decrypt(rawurldecode($this->mysqli_pass)));

         */
    }

    public function execute() {
        $SQL = "SELECT
                    users.userName,
                    users.pwd
                  FROM
                    users
                    INNER JOIN iusers ON users.idUser = iusers.idUser
                  WHERE
                    iusers.id = $this->userid ;";

        //echo $SQL;
        $result = mysqli_query($this->dbh, $SQL);

        require_once APPROOT . '/model/clsCrypt.php';
        $objCrypt = new Crypt();
        //$this->mysqli_pass = trim($objCrypt->decrypt(rawurldecode($this->mysqli_pass)));            

        while ($row = mysqli_fetch_row($result)) {
            $this->user = $row[0];
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, APIURL . "?w=users&r=users_log_me_in&userName=" . $this->user . "&pwd=" . $this->pass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);            
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        $sessionKeyUser = $json["resp"]; 
        //echo "xx".$sessionKey ; 
        return $sessionKeyUser;
    }

    public function set_UserId($int) {
        $this->userid = $int;
    }

    public function set_User($str) {
        if (is_string($str)) {
            $this->user = $str;
        } else {
            $this->user = "";
        }
    }

    public function set_Password($str) {
        if (is_string($str)) {
            $this->pass = $str;
        } else {
            $this->pass = "";
        }
    }

    public function get_Count() {
        return $this->count;
    }

}
