<?php
require_once 'conexion.php';

class clsCaja
{
    function aperturarCaja($cajadiaria)
    {
        $sql =
            'INSERT INTO cajadiaria(idcajadiaria, fecha_apertura, fecha_cierre, monto_apertura, monto_cierre,estado) VALUES (NULL, :fecha_apertura, NULL,:monto_apertura,:monto_cierre,:estado)';

        $parametros = [
            ':fecha_apertura' => $cajadiaria['fecha_apertura'],
            ':monto_apertura' => $cajadiaria['monto_apertura'],
            ':monto_cierre' => $cajadiaria['monto_cierre'],
            ':estado' => 'ACTIVO',
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function insertaDetalleCaja($detallecaja)
    {
        $sql = "INSERT INTO movimientocaja(idtipopago,idcajadiaria,tipomovimientocaja,descripcion,monto,codigoreferencia,fecha,idusuario)
				VALUES (:idtipopago,:idcajadiaria,:tipomovimientocaja,:descripcion,:monto,:codigoreferencia,:fecha,:idusuario)";

        $parametros = [
            ':idtipopago' => $detallecaja['idtipopago'],
            ':idcajadiaria' => $detallecaja['idcajadiaria'],
            ':tipomovimientocaja' => $detallecaja['tipomovimientocaja'],
            ':descripcion' => $detallecaja['descripcion'],
            ':monto' => $detallecaja['monto'],
            ':codigoreferencia' => $detallecaja['codigoreferencia'],
            ':fecha' => $detallecaja['fecha'],
            ':idusuario' => $detallecaja['idusuario'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function cierreCaja($cajadiaria)
    {
        $sql = "UPDATE cajadiaria SET fecha_cierre = :fecha_cierre,monto_cierre=:monto_cierre, estado=:estado
				WHERE idcajadiaria=:idcajadiaria";

        $parametros = [
            ':idcajadiaria' => $cajadiaria['idcajadiaria'],
            ':fecha_cierre' => $cajadiaria['fecha_cierre'],
            ':monto_cierre' => $cajadiaria['monto_cierre'],
            ':estado' => 'FINALIZADO',
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function obtenerUltimaCajaAperturada()
    {
        $sql =
            'SELECT * FROM cajadiaria WHERE estado="ACTIVO" ORDER BY idcajadiaria DESC LIMIT 1';
        global $cnx;
        return $cnx->query($sql);
    }
    function listarGastos($idcajadiaria)
    {
        $sql =
            'SELECT mc.idmovimientocaja,mc.descripcion,mc.fecha,mc.monto,u.nick FROM movimientocaja mc INNER JOIN usuario u ON u.dni=mc.idusuario WHERE mc.idcajadiaria=:idcajadiaria and mc.tipomovimientocaja="GASTO"';
        global $cnx;
        $parametros = [':idcajadiaria' => $idcajadiaria];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function calculosCaja($idcajadiaria, $tipomovcaja)
    {
        $sql =
            'SELECT SUM(monto) as suma FROM movimientocaja WHERE idcajadiaria=:idcajadiaria and tipomovimientocaja=:tipomovimientocaja AND idtipopago= 1';
        global $cnx;
        $parametros = [
            ':idcajadiaria' => $idcajadiaria,
            ':tipomovimientocaja' => $tipomovcaja,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function calculosUtilidadTotal($idcajadiaria, $tipomovcaja)
    {
        $sql =
            'SELECT SUM(monto) as suma FROM movimientocaja WHERE idcajadiaria=:idcajadiaria and tipomovimientocaja=:tipomovimientocaja';
        global $cnx;
        $parametros = [
            ':idcajadiaria' => $idcajadiaria,
            ':tipomovimientocaja' => $tipomovcaja,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function calculosOtrosIngresos($fechainicio)
    {
        $sql = 'SELECT tp.tipopago,SUM(m.monto) as suma FROM tipo_pago tp INNER JOIN movimientocaja m ON m.idtipopago=tp.idtipopago
        WHERE m.fecha>=:fecha AND m.tipomovimientocaja="INGRESO" AND m.idtipopago<> 1 GROUP BY tp.tipopago';
        global $cnx;
        $parametros = [':fecha' => $fechainicio];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function Listar5Ultimasventas($idcajadiaria)
    {
        $sql =
            'SELECT mc.idmovimientocaja,mc.descripcion,mc.fecha,mc.monto,u.nick,tp.tipopago FROM movimientocaja mc INNER JOIN usuario u ON u.dni=mc.idusuario INNER JOIN tipo_pago tp ON tp.idtipopago=mc.idtipopago WHERE mc.idcajadiaria=:idcajadiaria and mc.tipomovimientocaja="INGRESO" ORDER by mc.fecha DESC';
        $parametros = [
            ':idcajadiaria' => $idcajadiaria,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function AnularIngreso($idmovimiento)
    {
        $sql = 'UPDATE movimientocaja SET tipomovimientocaja="A-INGRESO" WHERE idmovimientocaja=:idmovimiento';

        $parametros = [
            ':idmovimiento' => $idmovimiento,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarCajadiaria($datos)
    {
        $sql =
            'SELECT * FROM cajadiaria WHERE fecha_apertura>=:desde AND fecha_apertura<:hasta';
        $parametros = [
            ':desde' => $datos['fecha1'],
            ':hasta' => $datos['fecha2'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function DetalleCaja($idcaja)
    {
        $sql =
            'SELECT dc.tipomovimientocaja as tipomovcaja, SUM(m.total) as suma FROM detallecaja dc INNER JOIN movimiento m on m.idmovimiento=dc.idmovimiento WHERE dc.idcajadiaria=:idcaja GROUP BY dc.tipomovimientocaja';
        $parametros = [
            ':idcaja' => $idcaja,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerUltimoMovimientoCaja()
    {
        $sql =
            'SELECT MAX(idmovimientocaja) as idmovimientocaja FROM movimientocaja';
        global $cnx;
        return $cnx->query($sql);
    }
    function BuscarMovimientoXcita($idcita)
    {
        $sql =
            'SELECT * FROM movimientocaja WHERE codigoreferencia=:idcita';
        global $cnx;
        $parametros = [':idcita' => $idcita];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    //SELECT monto FROM movimientocaja WHERE codigoreferencia=54

    //SELECT dc.tipomovimientocaja, SUM(m.total) as suma FROM detallecaja dc INNER JOIN movimiento m on m.idmovimiento=dc.idmovimiento WHERE dc.idcajadiaria='3' GROUP BY dc.tipomovimientocaja
    /*SELECT SUM(m.total) FROM detallecaja dc INNER JOIN movimiento m on m.idmovimiento=dc.idmovimiento WHERE dc.idcajadiaria=24 and dc.tipomovimientocaja='GASTO' */
    /*
    SELECT m.descripcion,m.fecha,m.total,m.idusuario as sumagastos FROM detallecaja dc INNER JOIN movimiento m on m.idmovimiento=dc.idmovimiento WHERE dc.idcajadiaria=24 and dc.tipomovimientocaja="INGRESO"
    SELECT m.*, u.nick FROM movimiento m INNER JOIN usuario u ON u.idusuario=m.idusuario INNER JOIN detallecaja dc on dc.idmovimiento=m.idmovimiento INNER JOIN cajadiaria cd on cd.idcajadiaria=dc.idcajadiaria WHERE m.descripcion='VENTA' and m.idtipopago=1 and cd.idcajadiaria=24 ORDER by m.fecha DESC LIMIT 5
    
    DELETE FROM detallecaja WHERE idmovimiento=39

    SELECT * FROM cajadiaria WHERE fecha_apertura>='2021/04/23' AND fecha_apertura<'2021/04/23 23:59:59';
    
    */
}
