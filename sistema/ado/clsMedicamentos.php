<?php
require_once 'conexion.php';

class clsMedicamentos
{
    function ListarProductos()
    {
        $sql = 'SELECT * FROM medicamento';
        global $cnx;
        return $cnx->query($sql);
    }
    function ListarMedicamento()
    {
        $sql = 'SELECT * FROM medicamento WHERE tipoinsumo="MEDICAM"';
        global $cnx;
        return $cnx->query($sql);
    }
    function ListarInsumos()
    {
        $sql = 'SELECT * FROM medicamento WHERE tipoinsumo="INSUMO"';
        global $cnx;
        return $cnx->query($sql);
    }
    function ObtenerMedicamentoNombre($filtro)
    {
        $sql = 'SELECT * FROM medicamento WHERE nombre=:filtro';
        global $cnx;
        $parametros = [':filtro' => $filtro];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function FiltrarMedicamento($filtro)
    {
        $sql = 'SELECT * FROM medicamento WHERE nombre LIKE :filtro';
        global $cnx;
        $parametros = [':filtro' => '%' . $filtro . '%'];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerDatosProducto($idprodcuto)
    {
        $sql = 'SELECT * FROM medicamento WHERE idmedicina=:idmedicina';
        global $cnx;
        $parametros = [':idmedicina' => $idprodcuto];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarMedicamento($producto)
    {
        $sql = 'INSERT INTO medicamento(nombre,stock,tipoinsumo) VALUES(:nombre,:stock,:tipoinsumo)';

        $parametros = [
            ':nombre' => $producto['nombre'],
            ':stock' => $producto['stock'],
            ':tipoinsumo' => $producto['tipoinsumo'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarMedicamento($producto)
    {
        $sql = 'UPDATE medicamento SET nombre=:nombre, tipoinsumo=:tipoinsumo WHERE idmedicina=:idmedicina';

        $parametros = [
            ':idmedicina' => $producto['idmedicina'],
            ':nombre' => $producto['nombre'],
            ':tipoinsumo' => $producto['tipoinsumo'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EliminarMedicamento($idmedicamento)
    {
        $sql = 'DELETE FROM medicamento WHERE idmedicina=:idmedicina';

        $parametros = [
            ':idmedicina' => $idmedicamento,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarMovimientoAlmacen($movimiento)
    {
        $sql = 'INSERT INTO movimientoalmacen(tipomovimiento, idproducto, cantidad, descripcion,fecha, usuario) VALUES (:tipomovimiento, :idproducto, :cantidad, :descripcion,:fecha, :usuario)';

        $parametros = [
            ':tipomovimiento' => $movimiento['tipomovimiento'],
            ':idproducto' => $movimiento['idproducto'],
            ':cantidad' => $movimiento['cantidad'],
            ':descripcion' => $movimiento['descripcion'],
            ':fecha' => $movimiento['fecha'],
            ':usuario' => $movimiento['usuario'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerUltimoProducto()
    {
        $sql = 'SELECT MAX(idmedicina) as idproducto FROM medicamento';
        global $cnx;
        return $cnx->query($sql);
    }
    function ActualizarStock($producto)
    {
        $sql = 'UPDATE medicamento SET stock=:stock WHERE idmedicina=:idmedicina';
        $parametros = [
            ':idmedicina' => $producto['idproducto'],
            ':stock' => $producto['stock'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
//