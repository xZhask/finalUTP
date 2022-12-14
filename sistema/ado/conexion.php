<?php
try {
    $manejador = 'mysql';
    $servidor = 'localhost';
    /* $usuario = 'gastrome_ronycumpa';
    $pass = 'p;E^@8=1QTG#';
    $db = 'gastrome_gastromedikdb'; */
    $usuario = 'root';
    $pass = 'mysql';
    $db = 'dbmagusa';
    $cadena = "$manejador:host=$servidor;dbname=$db";
    $cnx = new PDO($cadena, $usuario, $pass, [
        PDO::ATTR_PERSISTENT => 'true',
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
    ]);
    date_default_timezone_set('America/Lima');
} catch (Exception $ex) {
    echo 'Error de acceso, informelo a la brevedad.';
    exit();
}
