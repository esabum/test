<?php

class Crypt {

    private $clear = '';
    private $obscure = '';
    private $shadow = '';
    private $vector = '';

    function __construct() {
        $this->vector = '4b5424fe0a5d63bd12921c8b2e65d0d1';
        $this->shadow = 'c2c58f73ec5d268261fbbc023b3ec0c9';
    }

    public function encrypt($str = '') {
        $this->obscure = '';
        if ($str) {
            $this->clear = $str;
        }
        if ($this->clear) {
            $this->obscure = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->shadow, $this->clear, MCRYPT_MODE_CBC, $this->vector);
            return $this->obscure;
        }
    }

    public function decrypt($str = '') {
        $this->clear = '';
        if ($str) {
            $this->obscure = $str;
        }
        if ($this->obscure) {
            $this->clear = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->shadow, $this->obscure, MCRYPT_MODE_CBC, $this->vector);
            return $this->clear;
        }
    }

    public function get_Decrypted() {
        return $this->clear;
    }

    public function get_Encrypted() {
        return $this->obscure;
    }

    public function set_Decrypted($str) {
        if ($str) {
            $this->clear = $str;
        } else {
            $this->clear = '';
        }
    }

    public function set_Encrypted($str) {
        if ($str) {
            $this->obscure = $str;
        } else {
            $this->obscure = '';
        }
    }

}

?>