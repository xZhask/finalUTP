<?php
require_once 'conexion.php';

class clsPersonal
{
    function ListarCargo()
    {
        $sql = 'SELECT * FROM cargo';
        global $cnx;
        return $cnx->query($sql);
    }
    function RegistrarCargo($cargo)
    {
        $sql = 'INSERT INTO cargo(nombre) VALUES (:nombre)';
        $parametros = [
            ':nombre' => $cargo,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarPersonal()
    {
        $sql =
            'SELECT u.dni, concat_ws(", ", u.apellidos, u.nombre) as nombre, u.nick,c.idcargo, c.nombre as cargo,u.estado FROM usuario u INNER JOIN cargo c ON c.idcargo = u.idcargo';
        global $cnx;
        return $cnx->query($sql);
    }

    function ObtenerDatosPersonal($dni)
    {
        $sql =
            'SELECT u.dni, concat_ws(", ", u.apellidos, u.nombre) as nombre_completo,u.nombre as nombre,u.apellidos, u.nick,u.pass,c.idcargo, c.nombre as cargo,u.estado FROM usuario u INNER JOIN cargo c ON c.idcargo = u.idcargo WHERE u.dni=:dni';
        global $cnx;
        $parametros = [':dni' => $dni];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarPersonal($usuario)
    {
        $sql =
            'INSERT INTO usuario(dni, nombre, apellidos, nick, pass, idcargo,estado) VALUES (:dni,:nombre,:apellidos,:nick,:pass,:idcargo,:estado)';

        $parametros = [
            ':dni' => $usuario['dni'],
            ':nombre' => $usuario['nombre'],
            ':apellidos' => $usuario['apellidos'],
            ':nick' => $usuario['nick'],
            ':pass' => $usuario['pass'],
            ':idcargo' => $usuario['idcargo'],
            ':estado' => $usuario['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarPersonal($usuario)
    {
        $sql =
            'UPDATE usuario SET nombre=:nombre, apellidos=:apellidos, nick=:nick, idcargo=:idcargo, estado=:estado WHERE dni=:dni';

        $parametros = [
            ':dni' => $usuario['dni'],
            ':nombre' => $usuario['nombre'],
            ':apellidos' => $usuario['apellidos'],
            ':nick' => $usuario['nick'],
            ':idcargo' => $usuario['idcargo'],
            ':estado' => $usuario['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function CambiarPass($usuario)
    {
        $sql =
            'UPDATE usuario SET pass=:pass WHERE dni=:dni';

        $parametros = [
            ':dni' => $usuario['dni'],
            ':pass' => $usuario['pass'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function validarUsuario($usuario)
    {
        $sql =
            'SELECT * FROM usuario WHERE nick=:nick and pass=:pass and estado=:estado';
        global $cnx;
        $parametros = [
            ':nick' => $usuario['user'],
            ':pass' => $usuario['pass'],
            ':estado' => 'A',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
