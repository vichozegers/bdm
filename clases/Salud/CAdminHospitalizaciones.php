<?
require_once("clases/Salud/CHospitalizacion.php");

class CAdminHospitalizaciones
{
    public static function IngresarHospitalizacion(&$Hos, $id_evm)
    {
        $query="insert into hospitalizaciones(anio, nombre, evaluacion_medica_idevaluacion_medica) values (".$Hos->GetAnio().", '".$Hos->GetHospitalizacion()."', ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetHospitalizaciones($id_evm)
    {
        $query="select * from hospitalizaciones where evaluacion_medica_idevaluacion_medica=".$id_evm;
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
        $query="delete from hospitalizaciones where evaluacion_medica_idevaluacion_medica=".$id_evm;
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