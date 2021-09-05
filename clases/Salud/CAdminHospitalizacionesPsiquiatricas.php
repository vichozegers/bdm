<?php

class CAdminHospitalizacionesPsiquiatricas
{
    public static function IngresarHospitalizacionPsi(&$Hos, $id_evm)
    {
        $query="insert into hosp_psiquiatricas(anio, nombre, evaluacion_medica_idevaluacion_medica) values (".$Hos->GetAnio().", '".$Hos->GetHospitalizacion()."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetHospitalizacionesPsi($id_evm)
    {
        $query="select * from hosp_psiquiatricas where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearHospitalizacion($rs);
            }
        }
        return $a;
    }

    public static function CrearHospitalizacion($row)
    {
        $c=new CHospitalizacion();
        if(count($row)>0)
        {
            $c->SetAnio($row['anio']);
            $c->SetHospitalizacion($row['nombre']);
        }
        return $c;
    }

    public static function EliminarHospitalizaciones($id_evm)
    {
        $query="delete from hosp_psiquiatricas where evaluacion_medica_idevaluacion_medica=".$id_evm;
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