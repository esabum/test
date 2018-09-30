<?php

class MailsQueue {

    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $flag = 'ENT_SUBSTITUTE';
    protected $mailerqueue = array();
    protected $mailerAddresses = array();
    protected $mailerAccount = array();

    function __construct() {
        require_once APPROOT . '/model/dbconnector/clsMyDBConn.php';
        $this->obj_bconn = new MyConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    public function get_MailerQueue() {
        //$this->Clear();
        $SQL = "Select
                  Count(mailerqueue.id) As Count_id,
                  Min(mailerqueue.id) As Min_id
                From
                  mailerqueue
                Where
                  mailerqueue.sent Is Null
                Group By
                  mailerqueue.sent\n";

        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $this->mailerqueue[] = array(
                "count" => $row[0],
                "lastid" => $row[1]
            );
        }
        //print_r($this->mailerqueue);
        //echo $SQL;
        mysqli_free_result($result);
        return $this->mailerqueue;
    }

    public function get_MailerAddresses($id) {
        //$this->Clear();
        $SQL = "Select
                  maileraddresses.id,
                  maileraddresses.maileraddresstype_id,
                  maileraddresses.address,
                  maileraddresses.name
                From
                  maileraddresses
                Where
                  maileraddresses.mailerqueue_id = " . $id . ";\n";

        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $this->mailerAddresses[] = array(
                "id" => $row[0],
                "type" => $row[1],
                "address" => htmlentities($row[2], (int) $this->flag, "Windows-1252", true),
                "name" => $row[3]
            );
        }
        //print_r($this->mailerqueue);
        //echo $SQL;
        mysqli_free_result($result);
        return $this->mailerAddresses;
    }

    public function get_MailerAccount($id) {
        //$this->Clear();
        $SQL = "Select
                  mailerqueue.fromname,
                  mailerqueue.subject,
                  mailerqueue.body,
                  mailerqueue.altbody,
                  maileraccounts.mailer,
                  maileraccounts.smtpauth,
                  maileraccounts.port,
                  maileraccounts.smtpsecure,
                  maileraccounts.username,
                  maileraccounts.password,
                  maileraccounts.host
                From
                  mailerqueue Inner Join
                  maileraccounts
                    On mailerqueue.maileraccount_id = maileraccounts.id
                Where
                  mailerqueue.id = " . $id . ";\n";

        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_row($result)) {
            $this->mailerAccount[] = array(
                "fromname" => htmlentities($row[0], (int) $this->flag, "Windows-1252", true),
                "subject" => htmlentities($row[1], (int) $this->flag, "Windows-1252", true),
                "body" => htmlentities($row[2], (int) $this->flag, "Windows-1252", true),
                "altbody" => htmlentities($row[3], (int) $this->flag, "Windows-1252", true),
                "mailer" => htmlentities($row[4], (int) $this->flag, "Windows-1252", true),
                "smtpauth" => htmlentities($row[5], (int) $this->flag, "Windows-1252", true),
                "port" => $row[6],
                "smtpsecure" => htmlentities($row[7], (int) $this->flag, "Windows-1252", true),
                "username" => htmlentities($row[8], (int) $this->flag, "Windows-1252", true),
                "password" => htmlentities($row[9], (int) $this->flag, "Windows-1252", true),
                "host" => htmlentities($row[10], (int) $this->flag, "Windows-1252", true)
            );
        }
        //print_r($this->mailerqueue);
        //echo $SQL;
        mysqli_free_result($result);
        return $this->mailerAccount;
    }

    public function updateMailQueue($id) {
        $SQL = "UPDATE mailerqueue SET sent=CURRENT_TIMESTAMP() WHERE id = " . $id . "\n";
        $result = MYSQLI_query($this->dbh, $SQL);
    }

    public function get_Json() {
        return $this->mailerqueue;
    }

}
