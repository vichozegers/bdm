<?php
include_once("clases/Comunes/CDBSingleton.php");

class CAdminTratamientoAgitacion
{
    public static function IngresarTratAgitaciones($trat, $id_evm)
    {
        $query="insert into tratamiento_agitacion(nombre, evaluacion_medica_idevaluacion_medica) values('".$trat."',".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetTratAgitaciones($id_evm)
    {
        $query="select * from tratamiento_agitacion where evaluacion_medica_idevaluacion_medica=".$id_evm;
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

    public static function EliminarTratAgitaciones($id_evm)
    {
        $query="delete from tratamiento_agitacion where evaluacion_medica_idevaluacion_medica=".$id_evm;
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