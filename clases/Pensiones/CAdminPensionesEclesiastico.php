<?php
require_once("clases/Pensiones/CPensionEclesiastico.php");
//require_once("clases/Pensiones/CPensionTemporal.php");
require_once("clases/Comunes/CAdminComboboxEclesiastico.php");
//require_once("clases/Pensiones/CAdminMovimientosCtaCte.php");

class CAdminPensionesEclesiastico
{
    public static function IngresarPension(&$pension)
    {
        $query = "INSERT INTO ".Configuracion::$BD_eclesiastico.".pension (idam, tipo_pension_idtipo_pension, prevision_idprevision, tipo_prevision_idtipo_prevision, 
                 monto, numero_ss, estado_pension) 
                 VALUES (".$pension->GetIdAm().", ".$pension->GetIdTipoPension().", ".$pension->GetIdPrevision().", 
                 ".$pension->GetIdTipoPrevision().", '".$pension->GetMonto()."', '".$pension->GetNroSeguroSocial()."', 'pendiente')";
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return CDBSingleton::GetUltimoId();
        }
        return -1;
    }
    
    public static function ActualizarPension(&$pension)
    {
        $query = "UPDATE ".Configuracion::$BD_eclesiastico.".pension SET tipo_pension_idtipo_pension = ".$pension->GetIdTipoPension().", prevision_idprevision = ".$pension->GetIdPrevision().", 
                 tipo_prevision_idtipo_prevision = ".$pension->GetIdTipoPrevision().", monto = '".$pension->GetMonto()."', 
                 numero_ss = '".$pension->GetNroSeguroSocial()."' WHERE idpension = ".$pension->GetIdPension();
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return CDBSingleton::GetUltimoId();
        }
        return -1;
    }

    public static function CrearPension($row)
    {
        $pension = new CPensionEclesiastico();
        $pension->SetIdPension($row['idpension']);
        $pension->SetIdAm($row['idam']);
        $pension->SetIdTipoPension($row['tipo_pension_idtipo_pension']);
        $pension->SetIdPrevision($row['prevision_idprevision']);
        $pension->SetIdTipoPrevision($row['tipo_prevision_idtipo_prevision']);
        
        $pension->SetTipoPension($row['nombre_tipo_pension']);
        $pension->SetPrevision($row['nombre_prevision']);
        $pension->SetTipoPrevision($row['nombre_tipo_prevision']);
        
        $pension->SetMonto($row['monto']);
        $pension->SetNroSeguroSocial($row['numero_ss']);
        $pension->SetObservacion($row['observacion']);
        $pension->SetEstadoPension($row['estado_pension']);
        $pension->SetDiasRestantesCompromiso($row['dias']);
        $pension->SetEstadoCompromiso($row['estado_compromiso']);
        $pension->SetIdCompromiso($row['idcompromiso']);
        $pension->SetExtra($row['extra']);
        $pension->SetIdIpma($row['id_ipma']);
        
        return $pension;
    }    
    
    public static function GetPensiones($id_adulto)
    {
        $query = "SELECT pen.idam, pen.prevision_idprevision, pen.tipo_pension_idtipo_pension, pen.idpension, tpe.nombre AS nombre_tipo_pension, pre.nombre AS nombre_prevision, pen.tipo_prevision_idtipo_prevision, tpr.nombre AS nombre_tipo_prevision, pen.monto, 
                 pen.numero_ss, pen.estado_pension, pen.observacion, (IFNULL(DATEDIFF(c.fecha_termino, NOW()) + 1, 'nulo')) AS dias,
                 (IFNULL(c.estado_compromiso, 'nulo')) AS estado_compromiso, c.idcompromiso FROM ".Configuracion::$BD_eclesiastico.".pension pen 
                 JOIN ".Configuracion::$BD_eclesiastico.".prevision pre ON pen.prevision_idprevision = pre.idprevision
                 JOIN ".Configuracion::$BD_eclesiastico.".tipo_prevision tpr ON pen.tipo_prevision_idtipo_prevision = tpr.idtipo_prevision
                 JOIN ".Configuracion::$BD_eclesiastico.".tipo_pension tpe ON pen.tipo_pension_idtipo_pension = tpe.idtipo_pension
                 LEFT JOIN ".Configuracion::$BD_eclesiastico.".compromiso c ON pen.idpension = c.pension_idpension
                 WHERE pen.idam=".$id_adulto;
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        $a = array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numrows()>0)
            {
                for($i=0; $i<$exito->numRows(); $i++)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i] = self::CrearPension($rs);
                }
            }
        }
        return $a;
    }
    
    public static function GetPensionesIngresos($id_adulto)
    {
        $query = "SELECT DISTINCT pen.idpension, pre.nombre AS nombre_prevision, tpe.nombre AS nombre_tipo_pension, 
                 IFNULL((SELECT monto FROM ingreso_pension WHERE residente_transito_persona_idpersona = ".$id_adulto."
                 AND mes_pago = (SELECT MAX(mes_pago) FROM ingreso_pension 
                 WHERE residente_transito_persona_idpersona = ".$id_adulto." AND pension_idpension = pen.idpension 
                 AND anno_pago  = (SELECT MAX(anno_pago) FROM ingreso_pension WHERE residente_transito_persona_idpersona = ".$id_adulto." 
                 AND pension_idpension = pen.idpension) 
                 AND anno_pago = (SELECT MAX(anno_pago) FROM ingreso_pension WHERE residente_transito_persona_idpersona = ".$id_adulto." 
                 AND pension_idpension = pen.idpension) AND pension_idpension = pen.idpension) 
                 AND pension_idpension = pen.idpension ORDER BY mes_pago DESC, anno_pago DESC LIMIT 1), pen.monto) AS monto, 
                 c.idcompromiso, (SELECT monto FROM ingreso_pension WHERE mes_pago = ".date('m')." AND anno_pago = ".date('Y')." 
                 AND residente_transito_persona_idpersona = ".$id_adulto." AND pension_idpension = pen.idpension) AS extra, 
                 (SELECT id_ingreso_pension FROM ingreso_pension WHERE mes_pago = ".date('m')." AND anno_pago = ".date('Y')." 
                 AND residente_transito_persona_idpersona = ".$id_adulto." AND pension_idpension = pen.idpension) AS id_ipma 
                 FROM pension pen
                 JOIN prevision pre ON pen.prevision_idprevision = pre.idprevision
                 JOIN tipo_pension tpe ON pen.tipo_pension_idtipo_pension = tpe.idtipo_pension
                 JOIN compromiso c ON pen.idpension = c.pension_idpension
                 LEFT JOIN ingreso_pension ip ON pen.idpension = ip.pension_idpension
                 WHERE pen.idam = ".$id_adulto."
                 AND pen.estado_pension = 'confirmada'
                 AND c.estado_compromiso = 'vigente' 
                 GROUP BY 1";
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        $a = array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numrows()>0)
            {
                for($i=0; $i<$exito->numRows(); $i++)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i] = self::CrearPension($rs);
                }
            }
        }
        return $a;
    }
 
    public static function GetPensionesxIdpension($id_pen)
    {
        $query="SELECT * FROM pension
                WHERE idpension=".$id_pen;
      
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                $a=self::CrearPension($rs);
        }
        
        return $a;
    }
    
    public static function CambiarEstadoPension($id_pension, $estado, $obs = NULL)
    {
        $query = "UPDATE pension SET estado_pension = '".$estado."'";
        if ($obs != NULL)
        {    
            $query .= ", observacion = '".$obs."'";
        }
        $query .= " WHERE idpension = ".$id_pension;
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return $id_pension;
        }
        return -1;
    }
    
    public static function GetEstadoPension($id_pension)
    {
        $query = "SELECT estado_pension FROM pension WHERE idpension = ".$id_pension;
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC);
            if ($rs)
            {
                return ($rs['estado_pension']);
            }
        }
        return -1;
    }

    public static function EliminarPensiones($id_adulto)
    {
        $query="delete from ".Configuracion::$BD_BDU.".prevision where adulto_mayor_persona_idpersona=".$id_adulto;
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
        $query="update ".Configuracion::$BD_BDU.".prevision set adulto_mayor_persona_idpersona=".$id_ad_destino." where adulto_mayor_persona_idpersona=".$id_ad_origen;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 1;
        }
        return 0;
    }
    
    
    // Verifica temporales registrados
    public static function GetExisteTemporalPensiones($id_am, $idprevision, $mes_pago, $anno_pago)
    {
        $conn=CDBSingleton::GetConn();
        
            $query="SELECT count(*) AS cantidad FROM temporal_movimientos_cta_cte
                    WHERE persona_idpersona='".$id_am."'
                    AND prevision_idprevision='".$idprevision."'
                    AND mes_pago= '".$mes_pago."' and anno_pago='".$anno_pago."'";
        
           // echo $query;
           // echo "<br><br>";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['cantidad']);
        }
        return 'null';
    }    
    
    
    
    public static function GetSumaTotalMontoPension($mes_pago, $anno_pago, $idusuario){
          
          $query="select sum(monto) AS total_monto
                  from temporal_movimientos_cta_cte
                  where mes_pago =".$mes_pago."
                  and anno_pago =".$anno_pago."
                  and usuario_idusuario=".$idusuario."";
        
          $con=CDBSingleton::GetConn();
          $exito=$con->query($query);
          if (CDBSingleton::RevisarExito($exito, $query))
          {
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
              if ($rs)
                  return ($rs['total_monto']);
          }        
          return 'null';
    }
    
       
    public static function EliminarPensionTemporal($idpen, $idam, $mes_pago, $anno_pago, $iduser) {
        
      
        $query="delete from temporal_movimientos_cta_cte
                where prevision_idprevision='".$idpen."'
                and persona_idpersona='".$idam."'
                and mes_pago=".$mes_pago."
                and anno_pago=".$anno_pago."
                and usuario_idusuario=".$iduser."";
     
       
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 1;
        }
        return 0;
    }
              
     public static function GetObtenerMontoMovimientoTemporal($idpen, $idam, $mes_pago, $anno_pago, $iduser){
          
          $query="select monto from temporal_movimientos_cta_cte
                  where prevision_idprevision='".$idpen."'
                  and persona_idpersona='".$idam."'
                  and mes_pago =".$mes_pago."
                  and anno_pago =".$anno_pago."
                  and usuario_idusuario=".$iduser."";
        
          $con=CDBSingleton::GetConn();
          $exito=$con->query($query);
          if (CDBSingleton::RevisarExito($exito, $query))
          {
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
              if ($rs)
                  return ($rs['monto']);
          }        
          return 'null';
    }

 
    public static function GetObtenerIdTipoPension($idpen){
          
          $query="select tipo_pension_idtipo_pension from ".Configuracion::$BD_BDU.".prevision
                  where idprevision='".$idpen."'";
        
          $con=CDBSingleton::GetConn();
          $exito=$con->query($query);
          if (CDBSingleton::RevisarExito($exito, $query))
          {
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
              if ($rs)
                  return ($rs['tipo_pension_idtipo_pension']);
          }        
          return 'null';
    }
    
    public static function GetObtenerIdNombrePrevision($idpen){
          
          $query="select prevision_prevision_idprevision_prevision from ".Configuracion::$BD_BDU.".prevision
                  where idprevision='".$idpen."'";
        
          $con=CDBSingleton::GetConn();
          $exito=$con->query($query);
          if (CDBSingleton::RevisarExito($exito, $query))
          {
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
              if ($rs)
                  return ($rs['prevision_prevision_idprevision_prevision']);
          }        
          return 'null';
    }
    
    public static function GetObtenerNrSocial($idpen){
        
        $query="select numero_ss from ".Configuracion::$BD_BDU.".prevision
                where idprevision='".$idpen."'";
       
          $con=CDBSingleton::GetConn();
          $exito=$con->query($query);
          if (CDBSingleton::RevisarExito($exito, $query))
          {
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
              if ($rs)
                  return ($rs['numero_ss']);
          }        
          return 'null';
        
    }
    
    public static function CrearPensionTemporal($row)
    {
        $pentemp=new CPensionTemporal();
        $pentemp->SetIdPersona($row['persona_idpersona']);
        $pentemp->SetRutAM(CAdminPersonas::GetRutAm($row['persona_idpersona']));                    // Obtengo el Rut de AM
        $pentemp->SetNombreAM(CAdminPersonas::GetApellidoNombreAM($row['persona_idpersona']));      // Obtengo los apellidos y nombres del AM
        $pentemp->SetIdPrevision($row['prevision_idprevision']);
        $pentemp->SetNumeroSeguroSocial(self::GetObtenerNrSocial($row['prevision_idprevision']));   // Obtengo N° Social
        $pentemp->SetMonto($row['monto']);
        $pentemp->SetFechaIngreso($row['fecha_ingreso']);
        $pentemp->SetMesPago($row['mes_pago']);
        $pentemp->SetAnnoPago($row['anno_pago']);
        $pentemp->SetIdUsuario($row['usuario_idusuario']);
                
        $idnombrePrevision=self::GetObtenerIdNombrePrevision($row['prevision_idprevision']);            // obtengo Id Nombre Prevision 
        $pentemp->SetPrevision(CAdminCombobox::GetPrevisionesNombre($idnombrePrevision));             
        
        $idtipo=self::GetObtenerIdTipoPension($row['prevision_idprevision']);                           // obtengo Id Tipo Pension
        $pentemp->SetTipo(CAdminCombobox::GetTipoPensionNombre($idtipo));   
        
        return $pentemp;
     }

    
     public static function GetIngresarTemporalesRT($resulta, $iduser, $mes_pago, $anno_pago){
        $fechahora = date("Y-m-d H:i:s");
        
        $cantidad_seleccionado=count($resulta);
        
        $seleccion=array();
        $pension=array();
        
         for($i=0; $i<$cantidad_seleccionado; $i++){
            
            $seleccion[$i]=$resulta[$i];
            $pension=$seleccion[$i]->GetDetallePension();
            
               for($j=0; $j<count($pension); $j++){
               
                        $query="insert into temporal_movimientos_cta_cte 
                            (persona_idpersona, prevision_idprevision, monto, 
                            fecha_ingreso, mes_pago, anno_pago, usuario_idusuario) 
                            values ('".$seleccion[$i]->GetId()."', '".$pension[$j]->GetId()."', 
                                    '".$pension[$j]->GetMonto()."', '".$fechahora."', 
                                    '".$mes_pago."', '".$anno_pago."', '".$iduser."');";
                        
                        
                        $cantidad_reg[$j]= CAdminMovimientosCtaCte::GetExisteMovimientoCtaCte($seleccion[$i]->GetId(), $pension[$j]->GetId(), $mes_pago, $anno_pago);
   
                     if ($cantidad_reg[$j]==0){ // Verifico si el pago al AM fue realizado en Movimientos Cta Cte. (Si es 0 lo realiza).
                        
                        $cantidad_temp[$j]=self::GetExisteTemporalPensiones($seleccion[$i]->GetId(), $pension[$j]->GetId(), $mes_pago, $anno_pago);
                        
                            if ($cantidad_temp[$j]==0){ // Verifico si tiene el Am en Temporal Movimientos Cta Cte (Si es 0 lo realiza).
                                $con=CDBSingleton::GetConn();
                                $con->query($query);

                            }else if ($cantidad_temp[$j]==1){
                                // echo "<b>Se encuentra Registrado IdAm: </b>".$seleccion[$i]->GetId()."<br><br>";                            
                            }  
                     }else if ($cantidad_reg[$j]==1){ // Verifico si el pago al Am fue realizado (Si es 1 es que fue realizado
                       ?>
                              <script language="JavaScript"> 
                                  alert(" Se realizo el pago de: <? echo CAdminPersonas::GetNombreAdultoMayor($seleccion[$i]->GetId()); ?> mes: <? echo $mes_pago; ?> año: <? echo $anno_pago; ?>");
                              </script>
                       <?php    
                     }
               }// cierro for pensiones
                          
          }// cierro for cantidad seleccionado
   }
    
   
   
   public static function GetPensionTemporal($idpen, $idam, $mes_pago, $anno_pago, $iduser)
    {
        $query="select * from temporal_movimientos_cta_cte
                where persona_idpersona=".$idam."
                and mes_pago=".$mes_pago." and anno_pago=".$anno_pago."
                and prevision_idprevision=".$idpen."
                and usuario_idusuario=".$iduser."";
                
        //echo $query;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
       
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                $a=self::CrearPensionTemporal($rs);
        }
        
        return $a;
    }
    
        
    public static function GetTemporalMovimientosCtaCte($mes_pago, $anno_pago, $iduser)
    {
        $query="select * from temporal_movimientos_cta_cte
                where mes_pago=".$mes_pago." and anno_pago=".$anno_pago."
                and usuario_idusuario=".$iduser."";
                
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
       
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++){
               $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
               $a[$i]=self::CrearPensionTemporal($rs);
            }
        }
        
        return $a;
    }
    
 
    public static function ModificarPensionTemporal($idpen, $idam, $monto_temp, $mes_pago, $anno_pago, $iduser){
        
        $sql="update temporal_movimientos_cta_cte
                set monto=".$monto_temp."
                where persona_idpersona=".$idam."
                and mes_pago='".$mes_pago."'
                and anno_pago='".$anno_pago."'
                and prevision_idprevision=".$idpen."
                and usuario_idusuario=".$iduser;
               
        // echo $query;
        
        $con= CDBSingleton::GetConn();
        $exito= $con->query($sql);
        
        if (CDBSingleton::RevisarExito($exito, $sql))
                return CDBSingleton::GetUltimoId ();
        else
            return -1;
        
    }
    
    public static function GetCantidadPensiones($id_am, $estado = NULL)
    {
        $query = "SELECT COUNT(idpension) AS cantidad FROM pension 
                  WHERE idam = ".$id_am;
        
        if ($estado != NULL)
        {
            $query .= " AND estado_pension = 'confirmada'";
        }
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
          
        if (CDBSingleton::RevisarExito($exito, $query))
        {
            $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC);
            if ($rs)
            {    
                return ($rs['cantidad']);
            }    
        }        
        return 'null';
    }
    
    /*public static function GetCantidadPensionesConfirmadas($id_am)
    {
        $query = "SELECT COUNT(idpension) AS cantidad FROM pension 
                  WHERE idam = '".$id_am."' 
                  AND estado_pension = 'confirmada'";
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
          
        if (CDBSingleton::RevisarExito($exito, $query))
        {
            $rs = $exito->fetchrow(DB_FETCHMODE_ASSOC);
            if ($rs)
            {    
                return ($rs['cantidad']);
            }    
        }        
        return 'null';
    }*/
}
?>