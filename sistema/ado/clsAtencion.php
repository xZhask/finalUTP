<?php
require_once 'conexion.php';

class clsAtencion
{
    function ListarAtenciones()
    {
        $sql = 'SELECT * FROM atencion';
        global $cnx;
        return $cnx->query($sql);
    }

    function ObtenerDatosAtencion($idatencion)
    {
        $sql =
            'SELECT a.idatencion,a.fechaatencion,a.idusuario,p.dni,concat_ws(", ", p.apellidos, p.nombre) as paciente,YEAR(CURDATE())-YEAR(p.fecha_nac) as edad,sv.*,a.motivoconsulta,a.antecedente,a.anamensis,a.exfisico,a.diagnostico,a.tratamiento,a.examen FROM atencion a INNER JOIN paciente p ON p.dni=a.idpaciente INNER JOIN signosvitales sv ON sv.idatencion=a.idatencion WHERE a.idatencion=:idatencion';
        global $cnx;
        $parametros = [':idatencion' => $idatencion];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerExamen($idatencion)
    {
        $sql =
            'SELECT a.idatencion,a.fechaatencion,a.idusuario,p.dni,concat_ws(", ", p.apellidos, p.nombre) as paciente,YEAR(CURDATE())-YEAR(p.fecha_nac) as edad,a.examen FROM atencion a INNER JOIN paciente p ON p.dni=a.idpaciente WHERE a.idatencion=:idatencion';
        global $cnx;
        $parametros = [':idatencion' => $idatencion];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarAtencionesFecha($fecha)
    {
        $sql =
            'SELECT a.idatencion,p.dni,a.fechaatencion,concat_ws(", ", p.apellidos, p.nombre) as paciente,ta.nombre as motivo FROM atencion a INNER JOIN paciente p ON p.dni=a.idpaciente INNER JOIN tipo_atencion ta ON ta.idtipoatencion=a.idtipoatencion WHERE a.estado=:estado AND a.fechaatencion>=:fecha1 AND a.fechaatencion<=:fecha2';
        global $cnx;
        $parametros = [
            ':estado' => 'FINALIZADO',
            ':fecha1' => $fecha . ' 00:00:00',
            ':fecha2' => $fecha . ' 23:59:59',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarAtencionPorCita($idcita)
    {
        $sql =
            'SELECT mc.idmovimientocaja, a.idatencion,a.estado FROM  movimientocaja mc INNER JOIN atencion a ON a.idmovimiento=mc.idmovimientocaja  WHERE mc.codigoreferencia= :idcita';
        global $cnx;
        $parametros = [':idcita' => $idcita];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarAtencionesPorPaciente($idpaciente)
    {
        $sql =
            'SELECT a.idatencion,a.fechaatencion,ta.nombre FROM atencion a INNER JOIN tipo_atencion ta ON ta.idtipoatencion=a.idtipoatencion WHERE a.idpaciente=:idpaciente AND a.estado=:estado ORDER BY a.fechaatencion DESC';
        global $cnx;
        $parametros = [
            ':estado' => 'FINALIZADO',
            ':idpaciente' => $idpaciente,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    //
    function RegistrarAtencion($atencion)
    {
        $sql =
            'INSERT INTO atencion(idpaciente, idtipoatencion, idmovimiento, idusuario, fechaatencion, motivoconsulta, antecedente, anamensis, exfisico, diagnostico, tratamiento,examen, estado) VALUES (:idpaciente, :idtipoatencion, :idmovimiento, :idusuario, :fechaatencion, :motivoconsulta, :antecedente, :anamensis, :exfisico, :diagnostico, :tratamiento,:examen, :estado)';

        $parametros = [
            ':idpaciente' => $atencion['idpaciente'],
            ':idtipoatencion' => $atencion['idtipoatencion'],
            ':idmovimiento' => $atencion['idmovimiento'],
            ':idusuario' => $atencion['idusuario'],
            ':fechaatencion' => $atencion['fechaatencion'],
            ':motivoconsulta' => $atencion['motivoconsulta'],
            ':antecedente' => $atencion['antecedente'],
            ':anamensis' => $atencion['anamensis'],
            ':exfisico' => $atencion['exfisico'],
            ':diagnostico' => $atencion['diagnostico'],
            ':tratamiento' => $atencion['tratamiento'],
            ':examen' => $atencion['examen'],
            ':estado' => $atencion['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarAtencion($atencion)
    {
        $sql =
            'UPDATE atencion SET idusuario=:idusuario, fechaatencion=:fechaatencion, motivoconsulta=:motivoconsulta, antecedente=:antecedente, anamensis=:anamensis, exfisico=:exfisico, diagnostico=:diagnostico, tratamiento=:tratamiento, estado=:estado WHERE idatencion=:idatencion';

        $parametros = [
            ':idatencion' => $atencion['idatencion'],
            ':idusuario' => $atencion['idusuario'],
            ':fechaatencion' => $atencion['fechaatencion'],
            ':motivoconsulta' => $atencion['motivoconsulta'],
            ':antecedente' => $atencion['antecedente'],
            ':anamensis' => $atencion['anamensis'],
            ':exfisico' => $atencion['exfisico'],
            ':diagnostico' => $atencion['diagnostico'],
            ':tratamiento' => $atencion['tratamiento'],
            //':examen' => $atencion['examen'],
            ':estado' => $atencion['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function editarAtencion($atencion)
    {
        $sql =
            'UPDATE atencion SET idusuario=:idusuario, motivoconsulta=:motivoconsulta, antecedente=:antecedente, anamensis=:anamensis, exfisico=:exfisico, diagnostico=:diagnostico, tratamiento=:tratamiento WHERE idatencion=:idatencion';

        $parametros = [
            ':idatencion' => $atencion['idatencion'],
            ':idusuario' => $atencion['idusuario'],
            ':motivoconsulta' => $atencion['motivoconsulta'],
            ':antecedente' => $atencion['antecedente'],
            ':anamensis' => $atencion['anamensis'],
            ':exfisico' => $atencion['exfisico'],
            ':diagnostico' => $atencion['diagnostico'],
            ':tratamiento' => $atencion['tratamiento'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarSignosVitales($SignosVitales)
    {
        $sql =
            'INSERT INTO signosvitales(idatencion, fr, peso, so2, temp, pa) VALUES (:idatencion, :fr, :peso, :so2, :temp, :pa)';

        $parametros = [
            ':idatencion' => $SignosVitales['idatencion'],
            ':fr' => $SignosVitales['fr'],
            ':peso' => $SignosVitales['peso'],
            ':so2' => $SignosVitales['so2'],
            ':temp' => $SignosVitales['temp'],
            ':pa' => $SignosVitales['pa'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarSignosVitales($SignosVitales)
    {
        $sql =
            'UPDATE signosvitales SET fr=:fr, peso=:peso, so2=:so2, temp=:temp, pa=:pa WHERE idatencion=:idatencion';

        $parametros = [
            ':idatencion' => $SignosVitales['idatencion'],
            ':fr' => $SignosVitales['fr'],
            ':peso' => $SignosVitales['peso'],
            ':so2' => $SignosVitales['so2'],
            ':temp' => $SignosVitales['temp'],
            ':pa' => $SignosVitales['pa'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ObtenerSignosVitales($idatencion)
    {
        $sql = 'SELECT * FROM signosvitales WHERE idatencion=:idatencion';
        global $cnx;
        $parametros = [':idatencion' => $idatencion];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarAtencion_Proc($atencion)
    {
        $sql =
            'UPDATE atencion SET idusuario=:idusuario, fechaatencion=:fechaatencion, examen=:examen, estado=:estado WHERE idatencion=:idatencion';

        $parametros = [
            ':idatencion' => $atencion['idatencion'],
            ':idusuario' => $atencion['idusuario'],
            ':fechaatencion' => $atencion['fechaatencion'],
            ':examen' => $atencion['examen'],
            ':estado' => $atencion['estado'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarTratamiento($idatencion, $detalle)
    {
        $sql = "INSERT INTO tratamiento(idtratamiento, idmedicina, idatencion, indicaciones) VALUES (NULL, :idmedicina, :idatencion, :indicaciones)";
        global $cnx;
        $pre = $cnx->prepare($sql);
        foreach ($detalle as $k => $v) {
            $parametros = [
                ':idmedicina' => $v['idmedicina'],
                ':idatencion' => $idatencion,
                ':indicaciones' => $v['indicaciones'],
            ];
            $pre->execute($parametros);
        }
    }
    function ObtenerTratamiento($idatencion)
    {
        $sql = 'SELECT t.*,m.nombre FROM tratamiento t INNER JOIN medicamento m ON m.idmedicina=t.idmedicina WHERE t.idatencion=:idatencion';
        global $cnx;
        $parametros = [':idatencion' => $idatencion];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarAtencionxMovimiento($idmovimiento)
    {
        $sql = 'SELECT * atencion WHERE idmovimiento=:idmovimiento';
        global $cnx;
        $parametros = [':idmovimiento' => $idmovimiento];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EliminarAtencion($idmovimiento)
    {
        $sql = 'DELETE FROM atencion WHERE idmovimiento=:idmovimiento';

        $parametros = [
            ':idmovimiento' => $idmovimiento,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
