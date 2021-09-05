<?php
require_once("clases/Pensiones/CDescuento.php");

class CAdminDescuentos
{
    public static function GetDescuentoId($nombre)
    {
        $query="select iddescuento from descuentos where nombre='".chop($nombre)."'";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
            {
                return $rs["iddescuento"];
            }
            else
            return -1;
        }
        return -1;
    }

    /***************************************************************************
     *
     *
     *
     *
     *
     ***************************************************************************/

    public static function GetDescuentoNombre($iddescuento)
    {
        $query="select nombre from descuentos where iddescuento=".$iddescuento;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
            {
                return $rs['nombre'];
            }
        }
        return "";
    }

    /***************************************************************************
     * devuelve los motivos de ingreso para ser llenados
     * del segundo combobox en adelante
     *
     *
     *
     ***************************************************************************/


    public static function GetDescuentos($raiz)
    {
        $query="select nombre from descuentos where descuentos_iddescuento=".self::GetDescuentoId($raiz);
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query)){
            for($i=0; $i<$exito->numrows();$i++){
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs){
                    $a[$i]=$rs['nombre'];
                }
            }
        }
        return $a;
    }

    /***************************************************************************
     *
     * devuelve los motivos iniciales para rellenar los datos
     * iniciales para rellenar el primer conbobox de motivos
     *
     ***************************************************************************/

    public static function GetDescuentosIniciales()
    {
        $query="select nombre from descuentos where descuentos_iddescuento=".self::GetDescuentoId('raiz');
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows();$i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=$rs['nombre'];
                }
            }
            
        }
        return $a;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/
    public static function IngresarDescuentos($row, $id_adulto)
    {
        for($i=0; $i<count($row); $i++)
        {
            $j=self::IngresarDescuento($row[$i], $id_adulto);
            if($j<0)
            {
                return 1;
            }
        }
        return 0;
    }

     /**************************************************************************
      *
      *
      *
      **************************************************************************/

    public static function IngresarDescuento(&$descuento, $id_adulto)
    {
        if(self::GetDescuentoId($descuento->GetTipo())>0)
        {
            $query="insert into adulto_mayor_descuentos(adulto_mayor_persona_idpersona, descuentos_iddescuento, monto_descuento) values ("
            .$id_adulto.", ".self::GetDescuentoId($descuento->GetTipo()).", ".$descuento->GetMonto().")";
            $con=CDBSingleton::GetConn();
            $exito=$con->query($query);
            if(CDBSingleton::RevisarExito($exito, $query))
            {
                return CDBSingleton::GetUltimoId();
            }
            return -1;
        }
    }

     /**************************************************************************
      *
      *
      *
      **************************************************************************/

    public static function GetDescuentosAM($id_adulto)
    {
        $query="select * from adulto_mayor_descuentos where adulto_mayor_persona_idpersona=".$id_adulto;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearDescuento($rs);
            }
        }
        return $a;
    }

     /**************************************************************************
      *
      *
      *
      **************************************************************************/

    public static function CrearDescuento($row)
    {
        $des=new CDescuento();
        $des->SetMonto($row['monto_descuento']);
        $des->SetTipo(self::GetDescuentoNombre($row['descuentos_iddescuento']));
        $des->SetId($row['idadulto_mayor_descuentos']);
        return $des;
    }

    /***************************************************************************
     *
     *
     *
     *
     ***************************************************************************/

    public static function EliminarDescuentos($id_adulto)
    {
        $query="delete from adulto_mayor_descuentos where adulto_mayor_persona_idpersona=".$id_adulto;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 1;
        }
        return 0;
    }

    /***************************************************************************
     *
     *
     *
     *
     ***************************************************************************/

    public static function moverDescuentos($id_ad_origen, $id_ad_destino)
    {
        $query="update adulto_mayor_descuentos set adulto_mayor_persona_idpersona=".$id_ad_destino." where adulto_mayor_persona_idpersona=".$id_ad_origen;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $desc=self::GetDescuentosAM($id_ad_destino);
            for($i=0;$i<count($desc); $i++)
            {
                if($desc[$i]->GetId()>0)
                {
                    for($j=0; $j<count($desc); $j++)
                    {
                        if(strcmp($desc[$i]->GetTipo(), $desc[$j]->GetTipo())==0 && $desc[$i]->GetMonto()==$desc[$j]->GetMonto() && $j!=$i && $desc[$j]->GetId()>0)
                        {
                            if($i>$j)
                            {
                                self::eliminarDescuento($desc[$i]->GetId());
                                $desc[$i]->SetId(0);
                            }
                            else
                            {
                                self::eliminarDescuento($desc[$j]->GetId());
                                $desc[$j]->SetId(0);
                            }
                        }
                    }
                }
            }
            return 1;
        }
        return 0;
    }

    private static function eliminarDescuento($id_des)
    {
        $query="delete from adulto_mayor_descuentos where idadulto_mayor_descuentos=".$id_ad_origen;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
    }
}
?>