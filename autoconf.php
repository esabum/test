<?php

/* Move this file to include directory! */
get_AppRoot();

function get_AppRoot() {
    // Locate and define Application directory
    if (!defined('APPROOT')) {        
        $docrootarr = explode('/', $_SERVER['DOCUMENT_ROOT']);
        $curdirarr = explode('/', dirname($_SERVER["SCRIPT_FILENAME"]));
        $level = count($docrootarr);
        $appdir = implode('/', array_slice($curdirarr, 0, $level));
        while ((!file_exists($appdir . "/.config.ini")) && ($level < count($curdirarr))) {
            $level++;
            $appdir = implode('/', array_slice($curdirarr, 0, $level));
        }
        if (!file_exists($appdir . "/.config.ini")) {
            die('ini file not found!');
        }
        define('APPROOT', $appdir);
    }
}
