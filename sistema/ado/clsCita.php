<?php
require_once 'conexion.php';

class clsCita
{
    function ListarCita()
    {
        $sql = 'SELECT * FROM cita';
        global $cnx;
        return $cnx->query($sql);
    }

    function ObtenerDatosCita($idcita)
    {
        $sql =
            'SELECT c.idcita,c.fecha,c.horario,p.dni,YEAR(CURDATE())-YEAR(p.fecha_nac) as edad,p.apellidos as apellidospaciente,p.nombre as nombrepaciente,p.telefono,t.idtipoatencion,t.nombre as motivo,c.precio_consulta,t.precio,c.estado FROM cita c INNER JOIN paciente p on p.dni= c.dni INNER JOIN tipo_atencion t ON t.idtipoatencion=c.motivo_consulta WHERE c.idcita=:idcita';
        global $cnx;
        $parametros = [':idcita' => $idcita];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerUltimaCita()
    {
        $sql = 'SELECT MAX(idcita) as idcita FROM cita';
        global $cnx;
        return $cnx->query($sql);
    }
    function ListarCitasFecha($fecha)
    {
        $sql =
            'SELECT c.idcita,c.fecha,c.horario,concat_ws(", ", p.apellidos, p.nombre) as paciente,t.nombre as motivo,t.precio,p.telefono,c.estado FROM cita c INNER JOIN paciente p on p.dni= c.dni INNER JOIN tipo_atencion t ON t.idtipoatencion=c.motivo_consulta WHERE c.fecha=:fecha ORDER BY c.horario';
        global $cnx;
        $parametros = [':fecha' => $fecha];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function AtencionesConfirmadasHoy($datos)
    {
        $sql =
            'SELECT c.idcita,p.dni,c.horario,concat_ws(", ", p.apellidos, p.nombre) as paciente,t.nombre as motivo,t.precio,p.telefono FROM cita c INNER JOIN paciente p on p.dni= c.dni INNER JOIN tipo_atencion t ON t.idtipoatencion=c.motivo_consulta WHERE c.fecha=:fecha AND (c.estado=:estado OR c.estado=:estado2) ORDER BY c.horario';
        global $cnx;
        $parametros = [
            ':fecha' => $datos['fecha'],
            ':estado' => $datos['estado'],
            ':estado2' => 'A CUENTA',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarCita($cita)
    {
        $sql =
            'INSERT INTO cita(dni, fecha, horario, motivo_consulta,precio_consulta, estado) VALUES (:dni, :fecha, :horario,:motivo_consulta,:precio_consulta,:estado)';

        $parametros = [
            ':dni' => $cita['dni'],
            ':fecha' => $cita['fecha'],
            ':horario' => $cita['horario'],
            ':motivo_consulta' => $cita['motivo_consulta'],
            ':precio_consulta' => $cita['precio_consulta'],
            ':estado' => $cita['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarCita($cita)
    {
        $sql =
            'UPDATE cita SET dni=:dni, fecha=:fecha, horario=:horario,motivo_consulta=:motivo_consulta,precio_consulta=:precio_consulta WHERE idcita=:idcita';

        $parametros = [
            ':idcita' => $cita['idcita'],
            ':dni' => $cita['dni'],
            ':fecha' => $cita['fecha'],
            ':horario' => $cita['horario'],
            ':motivo_consulta' => $cita['motivo_consulta'],
            ':precio_consulta' => $cita['precio_consulta'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarEstadoCita($cita, $estado)
    {
        $sql = 'UPDATE cita SET estado=:estado WHERE idcita=:idcita';

        $parametros = [
            ':idcita' => $cita,
            ':estado' => $estado,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function AnularCita($idcita)
    {
        $sql = 'UPDATE cita SET estado=:estado WHERE idcita=:idcita';

        $parametros = [
            ':idcita' => $idcita,
            ':estado' => 'ANULADO',
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarCitaExterna($CitaExternta)
    {
        $sql =
            'INSERT INTO trabajo_externo(paciente, idhospital, idtipoatencion, precio, fecha, hora, estado) VALUES (:paciente, :idhospital, :idtipoatencion, :precio, :fecha, :hora, :estado)';

        $parametros = [
            ':paciente'=>$CitaExternta['paciente'],
            ':idhospital' => $CitaExternta['idhospital'],
            ':idtipoatencion' => $CitaExternta['idtipoatencion'],
            ':precio' => $CitaExternta['precio'],
            ':fecha' => $CitaExternta['fecha'],
            ':hora' => $CitaExternta['hora'],
            ':estado' => $CitaExternta['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarCitasExternas($fecha1, $fecha2)
    {
        $sql =
            'SELECT te.paciente,te.idtrabajoexterno,te.fecha,te.hora,concat_ws(" ",te.fecha,te.hora) as fechacita,ce.nombre as establecimiento,t.nombre as motivo,te.precio,te.estado FROM trabajo_externo te INNER JOIN tipo_atencion t ON t.idtipoatencion=te.idtipoatencion INNER JOIN consultorios_externos ce ON ce.idhospital=te.idhospital WHERE te.fecha>=:fecha1 AND te.fecha<=:fecha2 ORDER BY fechacita';
        global $cnx;
        $parametros = [':fecha1' => $fecha1, ':fecha2' => $fecha2,];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function FiltrarCitasExternas($datos)
    {
        $sql =
            'SELECT te.paciente,te.idtrabajoexterno,te.fecha,te.hora,concat_ws(" ",te.fecha,te.hora) as fechacita,ce.nombre as establecimiento,t.nombre as motivo,te.precio,te.estado FROM trabajo_externo te INNER JOIN tipo_atencion t ON t.idtipoatencion=te.idtipoatencion INNER JOIN consultorios_externos ce ON ce.idhospital=te.idhospital WHERE  te.fecha>=:fecha1 AND te.fecha<=:fecha2 AND ce.idhospital=:establecimiento ORDER BY fechacita';
        global $cnx;
        $parametros = [
            ':fecha1' => $datos['fecha1'],
            ':fecha2' => $datos['fecha2'],
            ':establecimiento' => $datos['establecimiento'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function AnularCitaExterna($idcitaExterna)
    {
        $sql = 'DELETE FROM trabajo_externo WHERE idtrabajoexterno=:idtrabajoexterno';

        $parametros = [
            ':idtrabajoexterno' => $idcitaExterna,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarPendientes()
    {
        $sql =
            'SELECT c.idcita,c.fecha,c.horario,concat_ws(", ", p.apellidos, p.nombre) as paciente,t.nombre as motivo,t.precio,p.telefono,c.estado FROM cita c INNER JOIN paciente p on p.dni= c.dni INNER JOIN tipo_atencion t ON t.idtipoatencion=c.motivo_consulta WHERE (c.estado=:estado OR c.estado="POR PAGAR") AND c.fecha>=:fechapend ORDER BY c.fecha DESC';
        global $cnx;
        $parametros = [':estado' => 'A CUENTA', ':fechapend'=>date('2022-05-19')];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarPendientes($dni)
    {
        $sql = 'SELECT * FROM cita WHERE estado = "A CUENTA" and dni=:dni';

        $parametros = [
            ':dni' => $dni,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarCitasPorPaciente($dni)
    {
        $sql = 'SELECT c.idcita,c.horario,c.fecha,tp.nombre as motivo,c.estado FROM cita c INNER JOIN tipo_atencion tp ON tp.idtipoatencion=c.motivo_consulta WHERE c.dni=:dni ORDER BY c.fecha DESC LIMIT 10';

        $parametros = [
            ':dni' => $dni,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    //SELECT * FROM cita WHERE estado = 'A CUENTA' and dni='48193845'
}
