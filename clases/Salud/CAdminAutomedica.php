<?php

class CAdminAutomedica
{
    public static function IngresarAutomedica($medicamento, $id_evm)
    {
        $query="insert into automedica(nombre, evaluacion_medica_idevaluacion_medica) values ('".$medicamento."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetAutomedica($id_evm)
    {
        $query="select nombre from automedica where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=$rs['nombre'];
            }
        }
        return $a;
    }

    public static function EliminarMedicamentos($id_evm)
    {
        $query="delete from automedica where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }
}
?>