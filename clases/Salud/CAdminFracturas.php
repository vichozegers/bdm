<?
require_once("clases/Salud/CFracturas.php");

class CAdminFracturas
{
    public static function IngresarFractura(&$Fra, $id_evm)
    {
        $query="insert into fracturas(anio, nombre, evaluacion_medica_idevaluacion_medica) values (".$Fra->GetAnio().", '".$Fra->GetFractura()."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetFracturas($id_evm)
    {
        $query="select * from fracturas where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearFractura($rs);
            }
        }
        return $a;
    }

    public static function CrearFractura($row)
    {
        $c=new CFracturas();
        if(count($row)>0)
        {
            $c->SetAnio($row['anio']);
            $c->SetFractura($row['nombre']);
        }
        return $c;
    }

    public static function EliminarFracturas($id_evm)
    {
        $query="delete from fracturas where evaluacion_medica_idevaluacion_medica=".$id_evm;
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