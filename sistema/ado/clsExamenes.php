<?php
require_once 'conexion.php';

class clsExamenes
{
    /* function ListarPaciente()
    {
        $sql = 'SELECT * FROM paciente';
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
    } */
    function RegistrarExamen($examen)
    {
        $sql =
            'INSERT INTO examenes(dni,nombre, fecha,tipoexamen) VALUES (:dni,:nombre, :fecha,:tipoexamen)';

        $parametros = [
            ':dni' => $examen['dni'],
            ':nombre' => $examen['nombre'],
            ':fecha' => $examen['fecha'],
            ':tipoexamen' => $examen['tipoexamen'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarDetalleExamen($examen)
    {
        $sql =
            'INSERT INTO detalle_examenes(idexamen,archivo) VALUES (:idexamen,:archivo)';

        $parametros = [
            ':idexamen' => $examen['idexamen'],
            ':archivo' => $examen['archivo'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerUltimoExamen()
    {
        $sql = 'SELECT MAX(idexamen) as idexamen FROM examenes';
        global $cnx;
        return $cnx->query($sql);
    }
    function ListarOtrosExamenes($idpaciente)
    {
        $sql = 'SELECT * FROM examenes WHERE dni=:idpaciente ORDER BY fecha DESC';
        global $cnx;
        $parametros = [
            ':idpaciente' => $idpaciente,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerDatosOtroexamen($idexamen)
    {
        $sql = 'SELECT * FROM detalle_examenes WHERE idexamen=:idexamen';
        global $cnx;
        $parametros = [
            ':idexamen' => $idexamen,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    //---------- CAMBIOOOOS  ↓↓
    function EliminarDetalleExamen($idexamen)
    {
        $sql = 'DELETE FROM detalle_examenes WHERE idexamen=:idexamen';

        $parametros = [
            ':idexamen' => $idexamen
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EliminarExamen($idexamen)
    {
        $sql = 'DELETE FROM examenes WHERE idexamen=:idexamen';

        $parametros = [
            ':idexamen' => $idexamen
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
