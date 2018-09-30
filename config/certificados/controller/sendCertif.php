<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Load values from .ini */
define('APPROOT', $_SERVER['DOCUMENT_ROOT']);
$ini_array = parse_ini_file(APPROOT . '/.config.ini', true);
define('APPBASE', $ini_array["general"]["appbase"]);
define('APIURL', $ini_array["api"]["url"]);

require_once APPROOT . '/model/userauth/SessMemHD.php';
require_once APPROOT . '/config/certificados/model/clsArchivo.php';

$Directorio = "Recursos/";
if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['certificado']['tmp_name'])) {

        $carpeta = $Directorio;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $RutaArchivo = $carpeta. $_FILES['certificado']['name'];
        if (move_uploaded_file($_FILES['certificado']['tmp_name'], $RutaArchivo)) {
            $ObjRecurso = new Archivo();
            //$ObjRecurso->SetNombre(before("." . $Formato, $Ficheros[$index]));
            $ObjRecurso->set_Nombre($_FILES['certificado']['name']);
            $ObjRecurso->set_Formato($_FILES['certificado']['type']);
            $ObjRecurso->set_Ruta(APPROOT."/config/certificados/controller/".$RutaArchivo);
            $ObjRecurso->set_User_Id($UserH);
            $ObjRecurso->set_Clave($clave);
            echo $ObjRecurso->execute();
        }
        echo false;
    }
    echo false;
}
