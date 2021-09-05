<?php
require_once("clases/Comunes/CLog.php");
require_once("clases/Comunes/CDBSingleton.php");

class CAdminLog
{
    public static function  Insertar(&$log)
    {
        $query="insert into log (usuario_idusuario, adulto_mayor_persona_idpersona, fecha_realizacion,
        evento, observaciones) values (".$log->GetUsuario().",".$log->GetAdultoMayor().", '".$log->GetFecha().
        "','".$log->GetEvento()."','".$log->GetObservaciones()."')";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
        
    }

    public static function GetXIdAdulto($id_ad)
    {
        $query="select * from log where adulto_mayor_persona_idpersona=".$id_ad." order by fecha_realizacion desc";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearLog($rs);
            }
        }
        return $a;
    }

    public static function GetXIdUsuario($id_usr)
    {

    }

    public static function GetXFecha($inicio, $termino)
    {

    }

    private static function CrearLog($row)
    {
        $log=new CLog();
        $log->SetUsuario($row["usuario_idusuario"]);
        $log->SetAdultoMayor($row["adulto_mayor_persona_idpersona"]);
        $log->SetFecha($row["fecha_realizacion"]);
        $log->SetEvento($row["evento"]);
        $log->SetObservaciones($row["observaciones"]);
        return $log;
    }

    public static function IngresarLog($id_ad, $id_usr, $evento)
    {
        $log=new CLog();
        $log->SetAdultoMayor($id_ad);
        $log->SetUsuario($id_usr);
        $log->SetEvento($evento);
        $log->SetFecha(date("Y-m-d H:i:s"));
    }
}
?>