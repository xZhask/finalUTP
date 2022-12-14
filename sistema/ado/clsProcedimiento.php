<?php
require_once 'conexion.php';

class clsProcedimiento
{
    function ListarProcedimientos()
    {
        $sql = 'SELECT * FROM tipo_atencion';
        global $cnx;
        return $cnx->query($sql);
    }

    function ObtenerDatosProcedimiento($idProc)
    {
        $sql =
            'SELECT * FROM tipo_atencion WHERE idtipoatencion=:idtipoatencion';
        global $cnx;
        $parametros = [':idtipoatencion' => $idProc];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerProcedimientoNombre($filtro)
    {
        $sql = 'SELECT * FROM tipo_atencion WHERE nombre=:filtro';
        global $cnx;
        $parametros = [':filtro' => $filtro];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarProcedimiento($procedimiento)
    {
        $sql =
            'INSERT INTO tipo_atencion(nombre, precio) VALUES (:nombre, :precio)';

        $parametros = [
            ':nombre' => $procedimiento['nombre'],
            ':precio' => $procedimiento['precio'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarProcedimiento($procedimiento)
    {
        $sql =
            'UPDATE tipo_atencion SET nombre=:nombre, precio=:precio WHERE idtipoatencion=:idtipoatencion';

        $parametros = [
            ':idtipoatencion' => $procedimiento['idtipoatencion'],
            ':nombre' => $procedimiento['nombre'],
            ':precio' => $procedimiento['precio'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EliminarProcedimiento($idprocedimiento)
    {
        $sql = 'DELETE FROM tipo_atencion WHERE idtipoatencion=:idtipoatencion';

        $parametros = [
            ':idtipoatencion' => $idprocedimiento,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function FiltrarProcedimiento($filtro)
    {
        $sql = 'SELECT * FROM tipo_atencion WHERE nombre like :filtro';
        global $cnx;
        $parametros = [':filtro' => '%' . $filtro . '%'];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function VerificarRegistros($idProc)
    {
        $sql = 'SELECT * FROM atencion WHERE idtipoatencion=:idtipoatencion';
        global $cnx;
        $parametros = [':idtipoatencion' => $idProc];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
