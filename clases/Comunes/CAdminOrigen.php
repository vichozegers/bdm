<?php

class CAdminOrigen
{

    public static function GetOrigenCB()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select distinct origen from origen_inicial";
        $bExito = $dbCon->query($sQuery);
        $a=array();
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs);
                {
                    $a[$i]=utf8_encode($rs['origen']);
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetOrigenId($nombre)
    {
        $sSelectQuery="select idorigen_inicial from origen_inicial where origen='".utf8_decode($nombre)."'";
        
        $conn=CDBSingleton::GetConn();
        $rs=$conn->query($sSelectQuery);
        if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
        {
            $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
            if($row)
            {
                return $row['idorigen_inicial'];
            }
        }
        return "null";
    }

    public static function GetOrigenNombre($Id)
    {
/*        if($Id>0)
        {  */
            $sSelectQuery="select origen from origen_inicial where idorigen_inicial=".$Id;

            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($sSelectQuery);
            if(CDBSingleton::RevisarExito($rs, $sSelectQuery))
            {
                $row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($rs)
                {
                    return utf8_encode($row['origen']);
                }
            }
            return "null";
        // }
    }

}
?>