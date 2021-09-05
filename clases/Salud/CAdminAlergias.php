<?php
require_once("clases/Salud/CAlergia.php");
class CAdminAlergias
{
    public static function IngresarAlergia(&$Al, $id_evm)
    {
        $query="insert into alergias(tipo, nombre, evaluacion_medica_idevaluacion_medica) values ('".$Al->GetTipo()."', '".$Al->GetAlergia()."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetAlergias($id_evm, $tipo)
    {
        $query="select * from alergias where evaluacion_medica_idevaluacion_medica=".$id_evm." and tipo='".$tipo."'";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearAlergia($rs);
            }
        }
        return $a;
    }

    public static function CrearAlergia($row)
    {
        $c=new CAlergia();
        if(count($row)>0)
        {
            $c->SetTipo($row['tipo']);
            $c->SetAlergia($row['nombre']);
        }
        return $c;
    }

    public static function EliminarAlergia($id_evm)
    {
        $query="delete from alergias where evaluacion_medica_idevaluacion_medica=".$id_evm;
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