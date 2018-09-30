<?php

class MailerQueue {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $flag = 'ENT_SUBSTITUTE';
    protected $subject = '';
    protected $body = '';
    protected $altbody = '';
    protected $fromname = '';
    protected $to = array();
    protected $cc = array();
    protected $bcc = array();
    protected $replytoEmail = array();
    protected $replytoName = array();
    protected $maileraccount = 0;
    protected $mailId = 0;

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function execute() {
        //$this->Clear();
        $SQL = "INSERT INTO mailerqueue(fromname, subject, body, altbody, maileraccount_id) 
                                VALUES ('$this->fromname','$this->subject','$this->body','$this->altbody',$this->maileraccount);\n";
        /*
          print_r($this->to);
          print_r($this->cc);
          print_r($this->bcc);
          print_r($this->replytoEmail);
          print_r($this->replytoName);
          echo "<div style='display:none'>" . $SQL . "</div>";

         */
        //echo "<div >" . $SQL . "</div>";

        $result = MYSQLI_query($this->dbh, $SQL);
        if (!$result) {
            throw new Exception('Error to insert');
        }

        $this->mailId = mysqli_insert_id($this->dbh);

        if (count($this->to) > 0) {
            foreach ($this->to as $value) {
                $SQL = "INSERT INTO maileraddresses(mailerqueue_id, maileraddresstype_id, address) 
                VALUES (" . $this->mailId . ",2,'" . $value . "');\n";
                $result = MYSQLI_query($this->dbh, $SQL);
                if (!$result) {
                    throw new Exception('Error to insert');
                }
            }
        }
        if (count($this->cc) > 0) {
            foreach ($this->cc as $value) {
                $SQL = "INSERT INTO maileraddresses(mailerqueue_id, maileraddresstype_id, address) 
                VALUES (" . $this->mailId . ",3,'" . $value . "');\n";
                $result = MYSQLI_query($this->dbh, $SQL);
                if (!$result) {
                    throw new Exception('Error to insert');
                }
            }
        }
        if (count($this->bcc) > 0) {
            foreach ($this->bcc as $value) {
                $SQL = "INSERT INTO maileraddresses(mailerqueue_id, maileraddresstype_id, address) 
                VALUES (" . $this->mailId . ",4,'" . $value . "');\n";
                $result = MYSQLI_query($this->dbh, $SQL);
                if (!$result) {
                    throw new Exception('Error to insert');
                }
            }
        }
        if (count($this->replytoEmail) > 0) {
            for ($i = 0; $i < count($this->replytoEmail); $i++) {
                $name = '';
                $email = $this->replytoEmail[$i];
                if (count($this->replytoName) > 0) {
                    $name = $this->replytoName[$i];
                }
                $SQL = "INSERT INTO maileraddresses(mailerqueue_id, maileraddresstype_id, address, name) 
                VALUES (" . $this->mailId . ",1,'" . $email . "','" . $name . "');\n";
                $result = MYSQLI_query($this->dbh, $SQL);
                if (!$result) {
                    throw new Exception('Error to insert');
                }
            }
        }
    }

    function set_Subject($str) {
        if (is_string($str)) {
            $this->subject = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim(html_entity_decode($str)), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->subject = '';
        }
    }

    function set_Body($str) {
        if (is_string($str)) {
            $this->body = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->body = '';
        }
    }

    function set_Altbody($str) {
        if (is_string($str)) {
            $this->altbody = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->altbody = '';
        }
    }

    function set_Fromname($str) {
        if (is_string($str)) {
            $this->fromname = mysqli_real_escape_string($this->dbh, mb_convert_encoding(trim($str), 'WINDOWS-1252', 'UTF-8'));
        } else {
            $this->fromname = '';
        }
    }

    function set_Maileraccount($int) {
        if (is_numeric($int)) {
            $this->maileraccount = $int;
        } else {
            $this->maileraccount = 0;
        }
    }

    function set_To($to) {
        if (is_array($to)) {
            $this->to = $to;
        } else {
            $this->to = array();
        }
    }
    function set_ToEmail($to) {
        if (is_string($to)) {
            $this->to[] = $to;
        }
    }    

    function set_Cc($cc) {
        if (is_array($cc)) {
            $this->cc = $cc;
        } else {
            $this->cc = array();
        }
    }
    function set_CcEmail($cc) {
        if (is_string($cc)) {
            $this->cc[] = $cc;
        } 
    }    

    function set_Bcc($bcc) {
        if (is_array($bcc)) {
            $this->bcc = $bcc;
        } else {
            $this->bcc = array();
        }
    }
    function set_BccEmail($bcc) {
        if (is_string($bcc)) {
            $this->bcc[] = $bcc;
        }
    }    

    function set_Replysto($arrEmails, $arrNames = '') {
        if (is_array($arrEmails)) {
            $this->replytoEmail = $arrEmails;
            $this->replytoName = $arrNames;
        } else {
            $this->replytoEmail = array();
            $this->replytoName = array();
        }
    }

    function set_Replyto($email, $name = '') {
        if (is_string($email)) {
            $this->replytoEmail[] = $email;
            $this->replytoName[] = $name;
        }
    }

    function setType($maileraccount) {
        if (is_numeric($maileraccount) && $maileraccount > 0) {
            $this->maileraccount = $maileraccount;
        } else {
            $this->maileraccount = 0;
        }
    }
    
    function getMailId() {
        return $this->mailId;
    }    

}
