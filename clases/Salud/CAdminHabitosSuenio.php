<?php

class CAdminHabitosSuenio
{
    public static function GetHSuenioCB()
    {
        $query="select distinct nombre from habitos_sueno order by nombre asc";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0;$i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=utf8_encode($rs['nombre']);
            }
        }
        return $a;
    }

    public static function GetHSuenioId($nombre)
    {
        $sSelectQuery="select idhabitos_sueno from habitos_sueno where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idhabitos_sueno'];
            }
        }
        return "null";
    }

    public static function GetHSuenioNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from habitos_sueno where idhabitos_sueno=".$Id;
            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($sSelectQuery);
            if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
            {
                $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($row)
                {
                    return utf8_encode($row['nombre']);
                }
            }
            return "null";
        }
    }

    public static function IngresarHSuenioEvMedica($h_sueno, $id_evm)
    {
        if(strcmp($h_sueno, "")!=0)
        {
        $query="insert into evaluacion_medica_habitos_sueno(habitos_sueno_idhabitos_sueno, evaluacion_medica_idevaluacion_medica) values (".
        self::GetHSuenioId($h_sueno).", ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
        }
    }

    public static function EliminarHSuenio($id_evm)
    {
        $query="delete from evaluacion_medica_habitos_sueno where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetHSuenioEvMedica($id_evm)
    {
        $query="select habitos_sueno_idhabitos_sueno from evaluacion_medica_habitos_sueno where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::GetHSuenioNombre($rs['habitos_sueno_idhabitos_sueno']);
            }
        }
        return $a;
    }
}
?>