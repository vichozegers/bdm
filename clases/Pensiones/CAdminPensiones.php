<?php
require_once("clases/Pensiones/CPension.php");

class CAdminPensiones
{
    public static function IngresarPension(&$pension, $id_adulto)
    {
        $query="insert into pension(adulto_mayor_persona_idpersona, monto, numero_ss, prevision_idprevision,"
        ."tipo_pension_idtipo_pension) values (".$id_adulto.", ".$pension->GetMonto().", '".$pension->GetNumeroSeguroSocial()."', "
        .CAdminCombobox::GetPrevisionesId($pension->GetPrevision()).", ".CAdminCombobox::GetTipoPensionId($pension->GetTipo()).")";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
//        echo $query;
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return CDBSingleton::GetUltimoId();
        }
        return -1;
    }

    public static function CrearPension($row)
    {
        $pension=new CPension();
        $pension->SetId($row['idprevision']);
        $pension->SetMonto($row['monto']);
       // $pension->SetNumeroSeguroSocial($row['numeso_ss']);
        $pension->SetPrevision(CAdminCombobox::GetPrevisionesNombre($row['prevision_idprevision']));
        $pension->SetTipo(CAdminCombobox::GetTipoPensionNombre($row['tipo_pension_idtipo_pension']));
        return $pension;
    }

    public static function GetPensiones($id_adulto)
    {
        $query="select * from pension where adulto_mayor_persona_idpersona=".$id_adulto;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numrows()>0)
            {
                for($i=0; $i<$exito->numRows(); $i++)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPension($rs);
                }
            }
        }
        return $a;
    }

    public static function IngresarPensiones($array, $id_adulto)
    {
//        echo count($array)." ".$array[0]->GetTipo();
        for($i=0; $i<count($array); $i++)
        {
            $j=self::IngresarPension($array[$i], $id_adulto);
            if($j<0)
            {
                return -1;
            }
        }
        return 0;
    }

    public static function EliminarPensiones($id_adulto)
    {
        $query="delete from pension where adulto_mayor_persona_idpersona=".$id_adulto;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 1;
        }
        return 0;
    }

    public static function moverPensiones($id_ad_origen, $id_ad_destino)
    {
        $query="update pension set adulto_mayor_persona_idpersona=".$id_ad_destino." where adulto_mayor_persona_idpersona=".$id_ad_origen;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 1;
        }
        return 0;
    }
}
?>