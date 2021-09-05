<?php

class CAdminCombobox
{

    public static function GetNivelEscolaridadCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from nivel_educacional";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs);
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetNivelEscolaridadId($nombre)
    {
        $sSelectQuery="select idnivel_educacional from nivel_educacional where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idnivel_educacional'];
            }
        }
        return "null";
    }

    public static function GetNivelEscolaridadNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from nivel_educacional where idnivel_educacional=".$Id;
            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($sSelectQuery);
            if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
            {
                $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($rs)
                {
                    return utf8_encode($row['nombre']);
                }
            }
            return "null";
        }
    }

    public static function GetPrevisionesCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from ".Configuracion::$BD_BDUVIEW.".ecle_prevision";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            $a="";
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a=$a."<option value='".utf8_encode($rs['nombre'])."'>".utf8_encode($rs['nombre'])."</option>";
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetPrevisionesCB2()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from ".Configuracion::$BD_BDUVIEW.".ecle_prevision";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            $a="";
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetPrevisionesId($nombre)
    {
        $sSelectQuery="select idprevision from ".Configuracion::$BD_BDUVIEW.".ecle_prevision where nombre='".$nombre."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idprevision'];
            }
        }
        return "";
    }

    public static function GetPrevisionesNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from ".Configuracion::$BD_BDUVIEW.".ecle_prevision where idprevision=".$Id;
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


    public static function GetProfesionCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from profesion";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetProfesionId($nombre)
    {
        $sSelectQuery="select idprofesion from profesion where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        // echo $sSelectQuery;
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idprofesion'];
            }
        }
        return "null";
    }

    public static function GetProfesionNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from profesion where idprofesion=".$Id;
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
            return "";
        }
    }



    public static function GetTipoPensionCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from ".Configuracion::$BD_BDUVIEW.".ecle_tipo_pension";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            $a="";
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a=$a."<option value='".utf8_encode($rs['nombre'])."'>".utf8_encode($rs['nombre'])."</option>";
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetTipoPensionCB2()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from ".Configuracion::$BD_BDUVIEW.".ecle_tipo_pension";
        $bExito = $dbCon->query($sQuery);
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            $a="";
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetTipoPensionId($nombre)
    {
        $sSelectQuery="select idtipo_pension from ".Configuracion::$BD_BDUVIEW.".ecle_tipo_pension where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            error_log(serialize($row));
            if($row){
                return $row['idtipo_pension'];
            }
        }
        return "null";
    }

    public static function GetTipoPensionNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from ".Configuracion::$BD_BDUVIEW.".ecle_tipo_pension where idtipo_pension=".$Id;
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
            return "";
        }
    }


    public static function GetTenenciaViviendaCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from tenencia_vivienda";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetTenenciaViviendaId($nombre)
    {
        $sSelectQuery="select idtenencia_vivienda from tenencia_vivienda where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idtenencia_vivienda'];
            }
        }
        return "null";
    }

    public static function GetTenenciaViviendaNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from tenencia_vivienda where idtenencia_vivienda=".$Id;
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
            return "";
        }
    }


    public static function GetTipoViviendaCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from tipo_vivienda";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
        }
        return $a;
    }

    public static function GetTipoViviendaId($nombre)
    {
        $sSelectQuery="select idtipo_vivienda from tipo_vivienda where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idtipo_vivienda'];
            }
        }
        return "null";
    }

    public static function GetTipoViviendaNombre($Id)
    {
        if($Id)
        {
            $sSelectQuery="select nombre from tipo_vivienda where idtipo_vivienda=".$Id;
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
            return "";
        }
    }

    public static function GetSistemaSaludCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from sistema_salud";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetSistemaSaludId($nombre)
    {
        $sSelectQuery="select idsistema_salud from sistema_salud where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idsistema_salud'];
            }
        }
        return "null";
    }

    public static function GetSistemaSaludNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from sistema_salud where idsistema_salud=".$Id;
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
            return "";
        }
    }

/*************************************************************************/

    public static function GetCompaniaCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from compania";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
    }

/*************************************************************************/

    public static function GetCompaniaId($nombre)
    {
        $sSelectQuery="select idcompania from compania where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idcompania'];
            }
        }
        return "null";
    }

/*************************************************************************/

    public static function GetCompaniaNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from compania where idcompania=".$Id;
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
            return "";
        }
    }

    public static function GetAgitacionCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct nombre from agitacion_psicomotora";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=utf8_encode($rs['nombre']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetAgitacionId($nombre)
    {
        $sSelectQuery="select idagitacion_psicomotora from agitacion_psicomotora where nombre='".utf8_decode($nombre)."'";
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idagitacion_psicomotora'];
            }
        }
        return "null";
    }

    public static function GetAgitacionNombre($Id)
    {
        if($Id>0)
        {
            $sSelectQuery="select nombre from agitacion_psicomotora where idagitacion_psicomotora=".$Id;
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

}
?>