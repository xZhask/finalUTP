<?php
require_once 'conexion.php';

class clsEstablecimiento
{
    function ListarEstablecimientos()
    {
        $sql = 'SELECT * FROM consultorios_externos';
        global $cnx;
        return $cnx->query($sql);
    }
    function RegistrarEstablecimiento($establecimiento)
    {
        $sql = 'INSERT INTO consultorios_externos(nombre) VALUES (:nombre)';

        $parametros = [
            ':nombre' => $establecimiento,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}

?>
