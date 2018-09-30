<?php

class Certificado {

    protected $obj_bconn;
    protected $dbh;
    protected $user_id = 0;
    protected $count = 0;
    protected $grant_type = "";
    protected $client_id = 0;
    protected $username = 0;
    protected $password = 0;
    protected $json = array();
    protected $htmlentities_flags = "ENT_SUBSTITUTE";

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        /*
          $params = array();
          $params['w'] = 'token';
          $params['r'] = 'gettoken';
          $params['grant_type'] = $this->grant_type;
          $params['client_id'] = $this->client_id;
          $params['username'] = $this->username;
          $params['password'] = $this->password;

          //print_r($params);
          $ch3 = curl_init();
          curl_setopt($ch3, CURLOPT_URL, APIURL);
          curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch3, CURLOPT_POST, true);
          curl_setopt($ch3, CURLOPT_POSTFIELDS, $params);
          $result3 = curl_exec($ch3);
          curl_close($ch3);
          $json3 = json_decode($result3, true);
          //print_r($json3); // $json["resp"]["sessionKey"];
          if(array_key_exists($json["resp"]["sessionKey"], $json3)){


          }
         */

        $SQL = "INSERT INTO certificado(ambiente, usuario, password, iuser_id) 
                VALUES ('$this->client_id','$this->username','$this->password',$this->user_id )
                    ON DUPLICATE KEY UPDATE 
                 ambiente ='$this->client_id', usuario='$this->username', password='$this->password', iuser_id= $this->user_id ;";

        //echo $SQL;

        $result = mysqli_query($this->dbh, $SQL);
        $ret = FALSE;
        if ($result) {
            $ret = TRUE;
        }
        return $ret;
    }

    public function getToken() {
        $SQL = "SELECT ambiente,usuario,password FROM certificado WHERE iuser_id = $this->user_id ;";

        //echo $SQL;
        $ambiente = "";
        $usuario = "";
        $password = "";

        $result = mysqli_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $ambiente = $row[0];
            $usuario = $row[1];
            $password = $row[2];
        }

        $params = array();
        $params['w'] = 'token';
        $params['r'] = 'gettoken';
        $params['grant_type'] = $this->grant_type;
        $params['client_id'] = $ambiente;
        $params['username'] = $usuario;
        $params['password'] = $password;

        //print_r($params);
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, APIURL);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_POST, true);
        curl_setopt($ch3, CURLOPT_POSTFIELDS, $params);
        $result3 = curl_exec($ch3);
        curl_close($ch3);
        $json3 = json_decode($result3, true);
        //print_r($json3); // $json["resp"]["sessionKey"];
        if (array_key_exists("resp", $json3)) {
            if(is_array($json3["resp"])){
                //echo "hay respuesta";
                if (array_key_exists("access_token", $json3["resp"])) {
                    return $json3["resp"]["access_token"];
                }else{
                    echo "No se pudo obtener el token";
                }                    
            }else{
                echo "No se pudo obtener el token";
            }
        }else{
            echo "No se pudo obtener el token";
        }
        
    }

    public function getCertiInfo() {

        $SQL = "SELECT ambiente,usuario,password FROM certificado WHERE iuser_id = $this->user_id ;";

        //echo $SQL;

        $result = mysqli_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $this->client_id = $row[0];
            $this->json[] = array(
                'ambiente' => $row[0],
                'usuario' => $row[1],
                'password' => $row[2],
            );
        }

        return $this->json;
    }

    public function getAmbiente() {
        return $this->client_id;
    }

    public function set_User_Id($int) {
        if (is_numeric($int)) {
            $this->user_id = $int;
        } else {
            $this->user_id = 0;
        }
    }

    function setGrant_type($grant_type) {
        if (is_string($grant_type)) {
            $this->grant_type = $this->cc($grant_type);
        } else {
            $this->grant_type = "";
        }
    }

    function setClient_id($client_id) {
        if (is_string($client_id)) {
            $this->client_id = $this->cc($client_id);
        } else {
            $this->client_id = "";
        }
    }

    function setUsername($username) {
        if (is_string($username)) {
            $this->username = $this->cc($username);
        } else {
            $this->username = "";
        }
    }

    function setPassword($password) {
        if (is_string($password)) {
            $this->password = $this->cc($password);
        } else {
            $this->password = "";
        }
    }

    public function get_Count() {
        return $this->count;
    }

    public function cc($data) {
        return mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($data), 'WINDOWS-1252', 'UTF-8'));
    }

}

?>