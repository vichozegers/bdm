<?php



class CAdminKatz {

    static public function GetTieneKatz($idam, $idco)
    {
        $conn=CDBSingleton::GetConn();
        $query="select * from ".'bds_12112012'.".katz WHERE idadulto_mayor='".$idam."' and control_idcontrol='".$idco."'";

        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {

            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs){
                $a=self::CrearKatz($rs);
                return $a;
            }
        }
        return false;
    }

    public static function GetKatzFichaTerapiaAm($idft) {
        $query="select * from ".'bds_12112012'.".katz where ficha_idficha=".$idft;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            if($exito->numrows()>0) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                return self::CrearKatz($rs);
            }else{
                $ktz= new CKatz();
                $ktz->SetTieneKatz(1); // se setea 1 para indicar q no hubo katz y muestre obs
                return $ktz;
            }
        }
    }

    public static function GetResultadoUltimoKatzAM($idam)
    {
        $conn=CDBSingleton::GetConn();
        $query="select resultado from ".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz WHERE idam=".$idam;
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return self::GetResultadoKatz($rs['resultado']);
        }
        return false;
    }


    public static function GetResultadoKatz($letra)
    {
        if($letra=='A')
            return 'Autovalente';
        else if($letra=='F' || $letra=='G')
            return 'No Valente';
        else
            return 'Semivalente';
    }

  //RETORNA EL TOTAL DE AM CON KATZ POR LETRA Y POR QUIENES ESTEN COMO RESIDENTES  
    public static function GetTotalKatzTipoLetra($letra){
        
      $conn=CDBSingleton::GetConn();
        $query="select count(idam) as cantidad from ".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz as bds,".Configuracion::$BDUMOVIL_VISTA.".bdu_residentes as bdu WHERE  bdu.categoria='residente' and bds.idam=bdu.persona_idpersona and bds.resultado='".$letra."'";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['cantidad']);
        }
        return false;
    }  
        
  
  //RETORNA EL TOTAL AM CON KATZ EN BDU_SALUD_AM POR LETRA QUE ESTEN COMO RESIDENTES 
    public static function GetTotalSaludTipoLetra($letra){
        
      $conn=CDBSingleton::GetConn();
        $query="SELECT count(bdu_salud.adulto_mayor_persona_idpersona)AS cantidad FROM ".Configuracion::$BDUMOVIL_VISTA.".bdu_salud_am as bdu_salud,".Configuracion::$BDUMOVIL_VISTA.".bdu_residentes as bdu_r WHERE bdu_r.categoria='residente' and bdu_salud.adulto_mayor_persona_idpersona=bdu_r.persona_idpersona AND bdu_salud.resultado_katz='".$letra."' and bdu_salud.adulto_mayor_persona_idpersona NOT IN (select bds_katz.idam from ".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz as bds_katz)";
       
        
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['cantidad']);
        }
        return false;
    } 
    
     public static function GetExtraIdSalud(){
        
      $conn=CDBSingleton::GetConn();
        $query="SELECT adulto_mayor_persona_idpersona as id FROM ".Configuracion::$BDUMOVIL_VISTA.".bdu_salud_am WHERE adulto_mayor_persona_idpersona NOT IN (select bds_katz.idam from ".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz as bds_katz)";
       
        $exito=$conn->query($query);
        
        if(CDBSingleton::RevisarExito($exito, $query))
        {
          $a=array();
           for($i=0; $i<$exito->numRows(); $i++)
            {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC,$i);
            if($rs)
                {
            
                $a[$i]= $rs['id'];
               }
                } 
               return $a;
             
        return "";
         } 
      }
    
      
      
     public static function GetTotalKatzXHogar($letra,$hogar){
        
      $conn=CDBSingleton::GetConn();
        $query="SELECT COUNT(bdu_h.nombre) AS cantidad FROM ".Configuracion::$BDUMOVIL_VISTA.".bdu_residentes AS bdu_r,".Configuracion::$BDUMOVIL_VISTA.".bdu_hogar AS bdu_h,".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz AS bds_katz where bdu_h.lugar_idlugar=bdu_r.hogar_lugar_idlugar  and bds_katz.idam=bdu_r.persona_idpersona and bdu_r.categoria='residente' and bdu_h.lugar_idlugar='".$hogar."' AND bds_katz.resultado='".$letra."'";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['cantidad']);
        }
        return false;
    } 
      
      
      
    public static function GetResultadoUltimoKatzSalud($idam)
    {
        $conn=CDBSingleton::GetConn();
        $query="select resultado_katz from ".Configuracion::$BDUMOVIL_VISTA.".bdu_salud_am WHERE adulto_mayor_persona_idpersona=".$idam;
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return self::GetResultadoKatz($rs['resultado_katz']);
        }
        return false;
    }
    
    public static function GetfechaUltimoKatzSalud($idam)
    {
        $conn=CDBSingleton::GetConn();
        $query="select fecha_realizacion from ".Configuracion::$BDUMOVIL_VISTA.".bdu_salud_am WHERE adulto_mayor_persona_idpersona=".$idam;
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['fecha_realizacion']);
        }
        return -1;
    }
    
   public static function GetfechaUltimoKatzAM($idam)
    {
        $conn=CDBSingleton::GetConn();
        $query="select fecha from ".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz WHERE idam=".$idam;
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['fecha']);
        }
        return false;
    }
    
    
    public static function GetKatzVistasBduMovil($idam){
       
        $fecha_ultimo_katz=CAdminKatz::GetfechaUltimoKatzAM($idam);
        $fecha_ultimo_am=CAdminKatz::GetfechaUltimoKatzSalud($idam);
                     
                     if ($fecha_ultimo_katz > $fecha_salud_am){
                         
                     return $katz= self::GetResultadoUltimoKatzAM($idam);    
                    
                     }
                     
                     elseif($fecha_salud_am > $fecha_ultimo_katz) {
                         
                        return $katz=self::GetResultadoUltimoKatzSalud($idam);
 
                     }
                     
                     else {
                         
                         return $katz='No Registra';
                     }
                     
    }



    public static function CrearKatz($rs) {
        $ktz= new CKatz();

        $ktz->SetId($rs['idkatz']);
        $ktz->SetKatzLavado($rs['lavado']);
        $ktz->SetKatzVestido($rs['vestido']);
        $ktz->SetKatzWc($rs['wc']);
        $ktz->SetKatzMovilidad($rs['movilidad']);
        $ktz->SetKatzContinencia($rs['continencia']);
        $ktz->SetKatzAlimentacion($rs['alimentacion']);
        $ktz->SetObservacion(utf8_encode($rs['observacion']));
        $ktz->SetResultado($rs['resultado']);
        $ktz->SetFuncionalidad(self::GetFuncionalidadKatz($rs['resultado']));
        $ktz->SetTieneKatz($rs['t_katz']);
//        $ktz->SetResponsable(CAdminEventos::GetResponsableControlNoProg($rs['idkatz'], 'katz'));
        $ktz->SetFechaReal($rs['fecha_real']);
        $ktz->SetIdAM($rs['idadulto_mayor']);
        $ktz->SetIdHogar($rs['idhogar']);
        return $ktz;
    }

     public static function CrearKatz2($rs) {
        $ktz= new CKatz();

        $ktz->SetId($rs['idkatz']);
        $ktz->SetKatzLavado($rs['lavado']);
        $ktz->SetKatzVestido($rs['vestido']);
        $ktz->SetKatzWc($rs['wc']);
        $ktz->SetKatzMovilidad($rs['movilidad']);
        $ktz->SetKatzContinencia($rs['continencia']);
        $ktz->SetKatzAlimentacion($rs['alimentacion']);
        $ktz->SetObservacion(utf8_encode($rs['observacion']));
        $ktz->SetResultado($rs['resultado']);
        $ktz->SetFuncionalidad(self::GetFuncionalidadKatz($rs['resultado']));
        $ktz->SetTieneKatz($rs['t_katz']);
//        $ktz->SetResponsable(CAdminEventos::GetResponsableControlNoProg($rs['idkatz'], 'katz'));
        $ktz->SetFechaReal($rs['fecha_real']);
        $ktz->SetAux('katz');
        $ktz->SetIdHogar($rs['idhogar']);
        return $ktz;
    }

    public static function GetKatz()
    {
        $query="select idevaluacion_medica,recomendacion ,alimentacion, continencia, movilidad, wc, vestido, lavado, proceso_postulacion_idproceso_postulacion from evaluacion_medica where 1 order by fecha_realizacion asc";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $a=array();
            for($i=0; $i<$exito->numrows(); $i++) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=new CEvaluacionMedica();
                $a[$i]->SetId($rs['idevaluacion_medica']);
                $a[$i]->SetKatzAlimentacion($rs['alimentacion2']);
                $a[$i]->SetKatzContinencia($rs['continencia']);
                $a[$i]->SetKatzMovilidad($rs['movilidad']);
                $a[$i]->SetKatzWc($rs['wc']);
                $a[$i]->SetKatzVestido($rs['vestido']);
                $a[$i]->SetKatzLavado($rs['lavado']);
                $a[$i]->SetProcesoPostulacion($rs['proceso_postulacion_idproceso_postulacion']);
                $a[$i]->SetRecomendacion($rs['recomendacion']);
            }
            return $a;
        }
    }


    static public function GetFuncionalidadKatz($letter)
    {
        if($letter == 'A')
        {
            $resultado = "Autovalente";
            return $resultado;
        }
        else if($letter =='F' || $letter=='G')
        {
            $resultado = "No Valente";
            return $resultado;
        }
        else
        {
            $resultado = "Semivalente";
            return $resultado;
        }

    }

     static public function GetKatz2($id)
    {
        $conn=CDBSingleton::GetConn();
        $query="select * from ".'bds_12112012'.".katz WHERE idkatz='".$id."'";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs){
                $a=self::CrearKatz($rs);
                return $a;
            }
        }
        return false;
    }


    public static function GetUltimoKatzAM($idam)
    {
        $conn=CDBSingleton::GetConn();
        $query="select idkatz from ".'bds_12112012'.".katz where idadulto_mayor=".$idam." order by idkatz DESC limit 1";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
            return $rs['idkatz'];
        }
        return NULL;
    }

    /***********************************************************************
     *                           INSERTS
     ************************************************************************/


       static public function IngresarKatz( &$_nRegistro )
        {
            $dbCon =& CDBSingleton::GetConn();

            
            $sQueryE = " INSERT INTO ".'bds_12112012'.".katz (".
                " control_idcontrol, " .
                " ficha_idficha, " .
                " alimentacion, " .
                " continencia, " .
                " movilidad, " .
                " wc, " .
                " vestido, " .
                " lavado, " .
                " resultado, " .
                " idadulto_mayor, " .
                " hogar, " .
                " t_katz, " .
                " observacion, " .
                " fecha_real, " .
                " idhogar " .    
                " ) VALUES ( " .
                "" . $_nRegistro->GetIdControl() . ", " .
                "" . $_nRegistro->GetIdFichaIngreso() . ", " .
                "'" . $_nRegistro->GetKatzAlimentacion() . "', " .
                "'" . $_nRegistro->GetKatzContinencia() . "', " .
                "'" . $_nRegistro->GetKatzMovilidad() . "', " .
                "'" . $_nRegistro->GetKatzWc() . "', " .
                "'" . $_nRegistro->GetKatzVestido() . "', " .
                "'" . $_nRegistro->GetKatzLavado() . "', " .
                "'" . $_nRegistro->GetResultado() . "', " .
                "'" . $_nRegistro->GetIdAM() . "', " .
                "'" . $_nRegistro->GetHogar() . "', " .
                "'" . $_nRegistro->GetTieneKatz() . "', " .
                "'" . utf8_decode($_nRegistro->GetObservacion()) . "', " .
                "'" . $_nRegistro->GetFechaReal() . "'," .
                "'" . $_nRegistro->GetIdHogar() . "')";

            $bExito2=$dbCon->query($sQueryE);
            if(CDBSingleton::RevisarExito($bExito2, $sQueryE))
            {
                $_nRegistro->SetId(CDBSingleton::GetUltimoId());

//                CAdminEventos::IngresarEventoControl($_nRegistro, 'katz');
                return CDBSingleton::GetUltimoId();

                }
             else
                return -1;
        }

     public static function ModificarKatz($ktz){

              $query="UPDATE ".'bds_12112012'.".katz SET ".
                "alimentacion= '".$ktz->GetKatzAlimentacion()."',".
                "continencia='".$ktz->GetKatzContinencia()."', ".
                "movilidad='".$ktz->GetKatzMovilidad()."', ".
                "wc='".$ktz->GetKatzWc()."', ".
                "vestido='".$ktz->GetKatzVestido()."', ".
                "lavado='".$ktz->GetKatzLavado()."', ".
                "resultado='".$ktz->GetResultado()."', ".
                "hogar='".$ktz->GetHogar()."', ".
                "t_katz='".$ktz->GetTieneKatz()."', ".
                "observacion='".utf8_decode($ktz->GetObservacion())."', ".
                "fecha_real='".$ktz->GetFechaReal()."', ".
                "idhogar='".$ktz->GetIdHogar()."' " .      
                "where idkatz=".$ktz->GetId();

            $con=CDBSingleton::GetConn();
            $exito=$con->query($query);

            if(CDBSingleton::RevisarExito($exito, $query))
                {
//                    CAdminEventos::IngresarEventoModificarControl($ktz, 'modificacion katz');
                    return CDBSingleton::GetUltimoId();

                    }
                else
                    return -1;
    }



    static public function IngresarKatzFichaTerapia( &$_nRegistro )
        {
            $dbCon =& CDBSingleton::GetConn();

            $sQueryE = " INSERT INTO ".'bds_12112012'.".katz (".
                " control_idcontrol, " .
                " ficha_idficha, " .
                " alimentacion, " .
                " continencia, " .
                " movilidad, " .
                " wc, " .
                " vestido, " .
                " lavado, " .
                " resultado, " .
                " idadulto_mayor, " .
                " hogar, " .
                " t_katz, " .
                " observacion, " .
                " fecha_real, " .
                " idhogar " .    
                " ) VALUES ( " .
                "" . $_nRegistro->GetIdControl() . ", " .
                "" . $_nRegistro->GetIdFichaIngreso() . ", " .
                "'" . $_nRegistro->GetKatzAlimentacion() . "', " .
                "'" . $_nRegistro->GetKatzContinencia() . "', " .
                "'" . $_nRegistro->GetKatzMovilidad() . "', " .
                "'" . $_nRegistro->GetKatzWc() . "', " .
                "'" . $_nRegistro->GetKatzVestido() . "', " .
                "'" . $_nRegistro->GetKatzLavado() . "', " .
                "'" . $_nRegistro->GetResultado() . "', " .
                "'" . $_nRegistro->GetIdAM() . "', " .
                "'" . $_nRegistro->GetHogar() . "', " .
                "'" . $_nRegistro->GetTieneKatz() . "', " .
                "'" . utf8_decode($_nRegistro->GetObservacion()) . "', " .
                "'" . $_nRegistro->GetFechaReal() . "', " .
                "'" . $_nRegistro->GetIdHogar() . "')";

            $bExito2=$dbCon->query($sQueryE);
            if(CDBSingleton::RevisarExito($bExito2, $sQueryE))
            {
                $_nRegistro->SetId(CDBSingleton::GetUltimoId());

//                CAdminEventos::IngresarEventoInstrumentoFI($_nRegistro, 'katz');
                return CDBSingleton::GetUltimoId();

                }
             else
                return -1;
        }

     public static function ModificarKatzFichaTerapia($ktz){

              $query="UPDATE ".'bds_12112012'.".katz SET ".
                "alimentacion= '".$ktz->GetKatzAlimentacion()."',".
                "continencia='".$ktz->GetKatzContinencia()."', ".
                "movilidad='".$ktz->GetKatzMovilidad()."', ".
                "wc='".$ktz->GetKatzWc()."', ".
                "vestido='".$ktz->GetKatzVestido()."', ".
                "lavado='".$ktz->GetKatzLavado()."', ".
                "resultado='".$ktz->GetResultado()."', ".
                "hogar='".$ktz->GetHogar()."', ".
                "t_katz='".$ktz->GetTieneKatz()."', ".
                "observacion='".$ktz->GetObservacion()."', ".
                "fecha_real='".$ktz->GetFechaReal()."', ".
                "idhogar='".$ktz->GetIdHogar()."' ".      
                "where ficha_idficha=".$ktz->GetIdFichaIngreso();

            $con=CDBSingleton::GetConn();
            $exito=$con->query($query);

            if(CDBSingleton::RevisarExito($exito, $query))
                    return CDBSingleton::GetUltimoId();
                else
                    return -1;
    }

    public static function GetKatzXIdam($idam)
    {
        $query='select * from '.'bds_12112012'.'.katz where idadulto_mayor='.$idam.' order by fecha_real';
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearKatz2($rs);
            }
        }
        return $a;
    }

    static public function GetKatzXIdControl($idco)
    {
        $conn=CDBSingleton::GetConn();
        $query="select * from ".'bds_12112012'.".katz WHERE control_idcontrol=".$idco;
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs){
                $a=self::CrearKatz($rs);
                return $a;
            }
        }
        return false;
    }
    
     public static function GetUltimosKatzxFechas($idam, $fechaini, $fechafin, $idhogar)
    {
        $dbCon = CDBSingleton::GetConn();
        
        $sQuery = "SELECT distinct k.idkatz FROM ".'bds_12112012'.".katz AS k 
                    LEFT JOIN ".'bds_12112012'.".ficha AS fi ON k.idadulto_mayor=fi.id_am  
                    LEFT JOIN ".'bds_12112012'.".control AS co ON k.idadulto_mayor=co.idadulto_mayor
                    WHERE
                    (                       
                      fi.fecha >='".$fechaini."' and fi.fecha<='".$fechafin."'
                      and fi.idhogar='".$idhogar."'
                      
                      and k.idadulto_mayor='".$idam."'
                    )
                    or
                    (
                      co.fecha_inicio >='".$fechaini."' and co.fecha_fin<='".$fechafin."'
                      and k.idhogar='".$idhogar."' 
                      
                      and k.idadulto_mayor='".$idam."'             
                    )

                    ORDER BY k.idkatz ASC";
  
        // echo $sQuery;
        // EN ESTE MOMENTO SE FILTRA EL ULTIMO Katz SIN IMPORTAR SI SE Realizo O NO
        // PARA REALIZAR ESTO EN AMBAS CONDICIONES COLOCAR "AND k.t_katz='0'"
  
        $bExito = $dbCon->query($sQuery);
  //      $a = '';
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {  
                if($bExito->numRows()>0)
                {
                 
                 for($i=0; $i<$bExito->numRows(); $i++)
                 {
                        $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                        $a[$i]=self::Getkatz2($rs['idkatz']);
                 }
                 return $a;
                }                
        }
    }
    
    
    // agregar GetUltimoIMCMedidoxFechas   pero hacerlo con katz
    
        
    public static function GetUltimoKatzMedidoxFechas($idam, $fechaini, $fechafin, $idhogar)
    {
        $dbCon = CDBSingleton::GetConn();
        
        $sQuery = "SELECT distinct k.idkatz FROM ".'bds_12112012'.".katz AS k 
                    LEFT JOIN ".'bds_12112012'.".ficha AS fi ON k.idadulto_mayor=fi.id_am  
                    LEFT JOIN ".'bds_12112012'.".control AS co ON k.idadulto_mayor=co.idadulto_mayor
                    WHERE
                    (                       
                      fi.fecha >='".$fechaini."' and fi.fecha<='".$fechafin."'
                      and fi.idhogar='".$idhogar."'
                      AND k.t_katz='0'
                      and k.idadulto_mayor='".$idam."'
                    )
                    or
                    (
                      co.fecha_inicio >='".$fechaini."' and co.fecha_fin<='".$fechafin."'
                      and k.idhogar='".$idhogar."' 
                      AND k.t_katz='0'
                      and k.idadulto_mayor='".$idam."'             
                    )

                    ORDER BY k.idkatz DESC limit 1";
  
        // EN ESTE MOMENTO SE FILTRA EL ULTIMO Katz SIN IMPORTAR SI SE Realizo O NO
        // PARA REALIZAR ESTO EN AMBAS CONDICIONES COLOCAR "AND k.t_katz='0'"
  
  
        $bExito = $dbCon->query($sQuery);
  //      $a = '';
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {                    
                
            $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs){
                $a=self::GetKatz2($rs['idkatz']);
                return $a;
            }
        }
        return false;
    }
    
     public static function GetCategoriasKatz() {

        $dbCon = CDBSingleton::GetConn();
        
        $sQuery = "select distinct(resultado)as resultado from ".'bds_12112012'.".katz where resultado!='' order by resultado asc";
       
        $bExito = $dbCon->query($sQuery);

        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {  
                if($bExito->numRows()>0)
                {
                 
                 for($i=0; $i<$bExito->numRows(); $i++)
                 {
                        $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                        $a[$i]=$rs['resultado'];
                 }
                 return $a;
                }                
        return false;
        }
    }
    
    
    
    public static function GetCantidadKatzxFechas($idam, $fechaini, $fechafin, $idhogar)
    {
        $dbCon = CDBSingleton::GetConn();
        
        $sQuery = "SELECT COUNT(distinct k.idkatz) AS contador FROM ".'bds_12112012'.".katz AS k 
                    LEFT JOIN ".'bds_12112012'.".ficha AS fi ON k.idadulto_mayor=fi.id_am  
                    LEFT JOIN ".'bds_12112012'.".control AS co ON k.idadulto_mayor=co.idadulto_mayor
                    WHERE
                    (                       
                      fi.fecha >='".$fechaini."' and fi.fecha<='".$fechafin."'
                      and fi.idhogar='".$idhogar."'
                      
                      and k.idadulto_mayor='".$idam."'
                    )
                    or
                    (
                      co.fecha_inicio >='".$fechaini."' and co.fecha_fin<='".$fechafin."'
                      and k.idhogar='".$idhogar."' 
                      
                      and k.idadulto_mayor='".$idam."'             
                    )
                    ";
  
        
        $bExito = $dbCon->query($sQuery);
        
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {            
            $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
            if($rs)
            {                    
              $a= $rs['contador'];
              return $a;
            }             
        }        
    }
    
    
    //METODO- OBTIENE AM SIN KATZ //CONSULTA DAVID//
    public static function GetTotalSinKatz(){
        
      $conn=CDBSingleton::GetConn();
        $query="SELECT count(persona_idpersona) as cantidad  FROM ".Configuracion::$BDUMOVIL_VISTA.".bdu_residentes WHERE `persona_idpersona` not in (select idam from ".Configuracion::$BDUMOVIL_VISTA. ".bds_ultimo_katz) and `persona_idpersona` not in (select adulto_mayor_persona_idpersona from ".Configuracion::$BDUMOVIL_VISTA.".bdu_salud_am) and categoria='residente'";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return ($rs['cantidad']);
        }
        return false;
    } 
    
    
    //METODO OBTIENE EL ULTIMO KATZ A LA FECHA ACTUAL TOMANDO FECHA ACTUAL Y COMPARANDO EL MAYOR DEL MENOR DE FECHA ACTUAL

    public static function GetUltimoKatzFechas()
    {
        $dbCon = CDBSingleton::GetConn();
        
        $sQuery = "SELECT idkatz from".'bds_12112012'.".katz where fecha_real='2011-04-20 10:18:38'";
  
        // EN ESTE MOMENTO SE FILTRA EL ULTIMO Katz SIN IMPORTAR SI SE Realizo O NO
        // PARA REALIZAR ESTO EN AMBAS CONDICIONES COLOCAR "AND k.t_katz='0'"
  
  
        $bExito = $dbCon->query($sQuery);
  //      $a = '';
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {                    
                
            $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs){
                $a=self::GetKatz2($rs['idkatz']);
                return $a;
            }
        }
        return false;
    }
    
    
    
    
   
    
  
}
?>