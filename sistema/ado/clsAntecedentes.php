<?php
require_once 'conexion.php';

class clsAntecedentes
{
    /*
    function ObtenerDatosAntecedentes($idProc)
    {
        $sql =
            'SELECT * FROM tipo_atencion WHERE idtipoatencion=:idtipoatencion';
        global $cnx;
        $parametros = [':idtipoatencion' => $idProc];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }*/
    function obtenerAntecedentesGenerales($dni)
    {
        $sql = 'SELECT * FROM antecedentesgenerales WHERE dni=:dni';
        global $cnx;
        $parametros = [':dni' => $dni];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarAntecedentesGenerales($antecedentesGen)
    {
        $sql =
            'INSERT INTO antecedentesgenerales(dni, HTA, HIV, DM, HEPATITIS, ALERGIAS) VALUES (:dni,:HTA,:HIV,:DM,:HEPATITIS,:ALERGIAS)';

        $parametros = [
            ':dni' => $antecedentesGen['dni'],
            ':HTA' => $antecedentesGen['HTA'],
            ':HIV' => $antecedentesGen['HIV'],
            ':DM' => $antecedentesGen['DM'],
            ':HEPATITIS' => $antecedentesGen['HEPATITIS'],
            ':ALERGIAS' => $antecedentesGen['ALERGIAS'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarAntecedentesGenerales($antecedentesGen)
    {
        $sql =
            'UPDATE antecedentesgenerales SET HTA=:HTA, HIV=:HIV, DM=:DM, HEPATITIS=:HEPATITIS, ALERGIAS=:ALERGIAS WHERE dni=:dni';

        $parametros = [
            ':dni' => $antecedentesGen['dni'],
            ':HTA' => $antecedentesGen['HTA'],
            ':HIV' => $antecedentesGen['HIV'],
            ':DM' => $antecedentesGen['DM'],
            ':HEPATITIS' => $antecedentesGen['HEPATITIS'],
            ':ALERGIAS' => $antecedentesGen['ALERGIAS'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarAntecedentesAtencion($antecedentesAte)
    {
        $sql =
            'INSERT INTO antecedentesatencion(idatencion, cirugias, endoscopias, covid) VALUES (:idatencion,:cirugias,:endoscopias,:covid)';

        $parametros = [
            ':idatencion' => $antecedentesAte['idatencion'],
            ':cirugias' => $antecedentesAte['cirugias'],
            ':endoscopias' => $antecedentesAte['endoscopias'],
            ':covid' => $antecedentesAte['covid'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
