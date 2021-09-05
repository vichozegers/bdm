<?php

class CAdminControlEspecialidades
{

    public static function IngresarControlEspecialidades($especialidad, $id_evm)
    {
        $query="insert into control_especialidades(nombre, evaluacion_medica_idevaluacion_medica) values ('".
        $especialidad."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function EliminarControlesEspecialidades($id_evm)
    {
        $query="delete from control_especialidades where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetControlEspecialidades($id_evm)
    {
        $query="select nombre from control_especialidades where evaluacion_medica_idevaluacion_medica=".$id_evm;
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
}
?>