<?php
include_once("clases/Salud/CCirujias.php");

class CAdminCirujias
{
    public static function IngresarCirujia(&$Cir, $id_evm)
    {
        $query="insert into cirujias(anio, nombre, evaluacion_medica_idevaluacion_medica) values (".$Cir->GetAnio().", '".$Cir->GetCirujia()."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetCirujias($id_evm)
    {
        $query="select * from cirujias where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearCirujia($rs);
            }
        }
        return $a;
    }

    public static function CrearCirujia($row)
    {
        $c=new CCirujias();
        if(count($row)>0)
        {
            $c->SetAnio($row['anio']);
            $c->SetCirujia($row['nombre']);
        }
        return $c;
    }

    public static function EliminarCirujias($id_evm)
    {
        $query="delete from cirujias where evaluacion_medica_idevaluacion_medica=".$id_evm;
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