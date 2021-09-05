<?php

include_once("clases/Comunes/CDBSingleton.php");
   
 class CAdminEclesiastico {

   public static function IngresarResidenteTransitoEclesiastico($id_ad) {
        
        
     $existe=self::GetExisteResidenteTransitoEclesiastico($id_ad);
        
     if ($existe==0){
        $query="insert into ".Configuracion::$BD_eclesiastico.".residente_transito 
                            (persona_idpersona, estado) 
                            values (".$id_ad.", 'pendiente')";
        $con=CDBSingleton::GetConn();
                
        $exito=$con->query($query);
        
        if(CDBSingleton::RevisarExito($exito, $query)) {
                return CDBSingleton::GetUltimoId();
        }
     }   
        return 'null';
   }
    
    
    public static function GetExisteResidenteTransitoEclesiastico($id_ad){
       
        $query="select count(*) as cantidad from ".Configuracion::$BD_eclesiastico.".residente_transito
                where persona_idpersona=".$id_ad." "; 
        
        $con= CDBSingleton::GetConn();
        
        $exito=$con->query($query);
        
        if(CDBSingleton::RevisarExito($exito, $query))
        {
               $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
               if ($rs)
                   return ($rs['cantidad']);
        }
        return 'null';
    }
    
    public static function IngresarPensionesEclesiastico($array, $id_adulto)
    {
        for($i = 0; $i < count($array); $i++)
        {
            $j = self::IngresarPensionEclesiastico($array[$i], $id_adulto);
            if($j < 0)
            {
                return -1;
            }
        }
        
        return 0;
    }
    
    public static function IngresarPensionEclesiastico(&$pension, $id_adulto)
    {
        /*
         * Se aclara que en el campo "tipo_prevision_idtipo_prevision" debiera ir el id del tipo de prevision.
         * En este momento se está guardando un dato en duro (1), el cual es el id de prueba en la tabla de eclesiastico
         */
        
        $query="INSERT INTO ".Configuracion::$BD_eclesiastico.".pension (idam, tipo_pension_idtipo_pension, 
               prevision_idprevision, tipo_prevision_idtipo_prevision, monto, numero_ss, estado_pension) VALUES 
               (".$id_adulto.", ".CAdminCombobox::GetTipoPensionId($pension->GetTipo()).", ".CAdminCombobox::GetPrevisionesId($pension->GetPrevision()).", 
               1, ".$pension->GetMonto().", '".$pension->GetNumeroSeguroSocial()."', 'pendiente')";
        
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return CDBSingleton::GetUltimoId();
        }
        else 
        {
            return -1;
        }       
    }
    
    public static function EliminarPensionesEclesiastico($id_adulto)
    {
        $query="DELETE FROM ".Configuracion::$BD_eclesiastico.".pension WHERE idam=".$id_adulto;
        $con = CDBSingleton::GetConn();
        $exito = $con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 1;
        }
        else
        {
            return 0;
        }        
    }
 } 
?>
