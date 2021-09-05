<?php

class CAdminEnfermedades
{
    public static function GetEnfermedadesCB()
    {
        $query="select distinct nombre from enfermedades where estado='activo' order by nombre asc";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0;$i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=utf8_encode($rs['nombre']);
            }
        }
        return $a;
    }

    public static function IngresarEnfermedad($nombre)
    {
        if(strcmp($nombre, "")!=0)
        {
//            echo "!".$nombre."!";
        $query="insert into enfermedades(nombre) values('".utf8_decode($nombre)."')";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
        }
    }

    public static function GetEnfermedadId($nombre)
    {
        $sSelectQuery="select idenfermedades from enfermedades where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idenfermedades'];
            }
        }
        return "null";
    }

    public static function GetEnfermedadNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from enfermedades where idenfermedades=".$Id;
            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($sSelectQuery);
            if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
            {
                $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($row)
                {
                    return utf8_encode($row['nombre']);
                }
            }
            return "null";
        }
    }


    public static function IngresarEnfermedadesEvMedica($enfermedad, $id_evm)
    {
        if(strcmp($enfermedad, "")!=0)
        {
        $query="insert into enfermedades_evaluacion_medica(enfermedades_idenfermedades, evaluacion_medica_idevaluacion_medica) values (".
        self::GetEnfermedadId($enfermedad).", ".$id_evm.")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
        }
    }

    public static function EliminarEnfermedades($id_evm)
    {
        $query="delete from enfermedades_evaluacion_medica where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }

    public static function GetEnfermedadesEvMedica($id_evm)
    {
        $query="select enfermedades_idenfermedades from enfermedades_evaluacion_medica where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::GetEnfermedadNombre($rs['enfermedades_idenfermedades']);
            }
        }
        return $a;
    }
    
    public static function GetEnfermedadesEvMedicaPsiquiatrica($id_evm)
    {
        $query="select enfermedades_idenfermedades from enfermedades_evaluacion_medica enf_ev, enfermedades enf
                where enf.idenfermedades=enf_ev.enfermedades_idenfermedades and
                enf.tipo='psiquiatrica' and
                enf_ev.evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::GetEnfermedadNombre($rs['enfermedades_idenfermedades']);
            }
        }
        return $a;
    }
}
?>