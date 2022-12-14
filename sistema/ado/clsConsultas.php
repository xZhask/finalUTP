<?php
require_once 'conexion.php';

class clsConsultas
{
    function ListarTiposPago()
    {
        $sql = 'SELECT * FROM tipo_pago';
        global $cnx;
        return $cnx->query($sql);
    }
    function ReporteCantidades($filtro)
    {
        $sql =
            'SELECT mc.*,tp.tipopago,u.nick FROM movimientocaja mc INNER JOIN usuario u ON mc.idusuario=u.dni INNER JOIN tipo_pago tp ON tp.idtipopago=mc.idtipopago WHERE (mc.tipomovimientocaja=:tipomovimientocaja OR mc.tipomovimientocaja="A-":tipomovimientocaja) AND mc.fecha>=:fecha1 AND mc.fecha<=:fecha2';

        global $cnx;
        $parametros = [
            ':tipomovimientocaja' => $filtro['tipomovimientocaja'],
            ':fecha1' => $filtro['fecha1'],
            ':fecha2' => $filtro['fecha2'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function mostrarDatosKardex($datos)
    {
        $sql = 'SELECT ma.fecha,ma.descripcion,ma.cantidad,ma.tipomovimiento,u.nick FROM movimientoalmacen ma INNER JOIN usuario u ON ma.usuario=u.dni WHERE ma.idproducto=:idproducto AND ma.fecha>:fecha1 AND ma.fecha<=:fecha2
        ORDER by ma.fecha';

        global $cnx;
        $parametros = [
            ':idproducto' => $datos['idproducto'],
            ':fecha1' => $datos['fecha1'],
            ':fecha2' => $datos['fecha2'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function ObtenerCantidadesKardex($datos, $tipomov)
    {
        $sql = 'SELECT SUM(cantidad) as tipokardex FROM movimientocaja 
        WHERE idproducto=:idproducto and tipomovimiento=:tipomov and fecha < :fecha1';
        global $cnx;
        $parametros = [
            ':idproducto' => $datos['idproducto'],
            ':fecha1' => $datos['fecha1'],
            ':tipomov' => $tipomov,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
