<?php
include_once("clases/Salud/CMedicamento.php");

class CAdminMedicamentos
{
    public static function IngresarMedicamentos(&$medicamento, $id_evm)
    {
        $query="insert into medicamentos(nombre, presentacion, dosis, evaluacion_medica_idevaluacion_medica) values ('".$medicamento->GetNombre() ."', '".$medicamento->GetPresentacion()."','".$medicamento->GetDosis()."',".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetMedicamentos($id_evm)
    {
        $query="select * from medicamentos where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearMedicamento($rs);
            }
        }
        return $a;
    }

    public static function EliminarMedicamentos($id_evm)
    {
        $query="delete from medicamentos where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    private static function CrearMedicamento($rs)
    {
        $med=new CMedicamento();
        $med->SetNombre($rs['nombre']);
        $med->SetPresentacion($rs['presentacion']);
        $med->SetDosis($rs['dosis']);
        return $med;
    }
}
?>