<?php
require_once 'conexion.php';

class clsPaciente
{
    function ListarPaciente()
    {
        $sql = 'SELECT * FROM paciente LIMIT 15';
        global $cnx;
        return $cnx->query($sql);
    }

    function ObtenerDatosPaciente($dni)
    {
        $sql = 'SELECT * FROM paciente WHERE dni=:dni';
        global $cnx;
        $parametros = [':dni' => $dni];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarPaciente($paciente)
    {
        $sql =
            'INSERT INTO paciente(dni, nombre, apellidos, telefono, fecha_nac) VALUES (:dni, :nombre, :apellidos,:telefono,:fecha_nac)';

        $parametros = [
            ':dni' => $paciente['dni'],
            ':nombre' => $paciente['nombre'],
            ':apellidos' => $paciente['apellidos'],
            ':telefono' => $paciente['telefono'],
            ':fecha_nac' => $paciente['fecha_nac'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarPaciente($paciente)
    {
        $sql =
            'UPDATE paciente SET nombre=:nombre, apellidos=:apellidos, telefono=:telefono, fecha_nac=:fecha_nac WHERE dni=:dni';

        $parametros = [
            ':dni' => $paciente['dni'],
            ':nombre' => $paciente['nombre'],
            ':apellidos' => $paciente['apellidos'],
            ':telefono' => $paciente['telefono'],
            ':fecha_nac' => $paciente['fecha_nac'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function FiltrarPaciente($filtro)
    {
        $sql =
            'SELECT * FROM paciente WHERE concat_ws(", ", apellidos, nombre) like :filtro';
        global $cnx;
        $parametros = [':filtro' => '%' . $filtro . '%'];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EliminarPaciente($idpaciente)
    {
        $sql = 'DELETE FROM paciente WHERE dni=:dni';

        $parametros = [
            ':dni' => $idpaciente,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    
}
