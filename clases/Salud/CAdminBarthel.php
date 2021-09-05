<?php
include_once("clases/Salud/CEvaluacionMedica.php");

class CAdminBarthel
{
    public static function IngresarBarthel(&$Barthel, $id_evm)
    {
        $query="insert into barthel(evaluacion_medica_idevaluacion_medica, comer, lavarse, vestirse, arreglar, deposiciones, miccion, retrete, trasladarse,deambular, escalones)
                                       values (".$id_evm.", ".
                                       $Barthel->GetBarthelComer().", ".
                                       $Barthel->GetBarthelLavarse().",".
                                       $Barthel->GetBarthelVestirse().", ".
                                       $Barthel->GetBarthelArreglar().", ".
                                       $Barthel->GetBarthelDeposiciones().",".
                                       $Barthel->GetBarthelMiccion().", ".
                                       $Barthel->GetBarthelRetrete().", ".
                                       $Barthel->GetBarthelTrasladarse().",".
                                       $Barthel->GetBarthelDeambular().", ".
                                       $Barthel->GetBarthelEscalones().")";
        
                    $con=CDBSingleton::GetConn();
                    $exito=$con->query($query);
                    if(CDBSingleton::RevisarExito($exito, $query))
                    {
                     return 0;
                    }
                    return 1;
    }

    
    public static function GetBarthel($id_evm, $dato)
    {
        $conn=CDBSingleton::GetConn();
        $query="select * from barthel where evaluacion_medica_idevaluacion_medica = ".$id_evm."";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                
                if($dato=='comer')
                    return $rs['comer'];
                if($dato=='lavarse')
                    return $rs['lavarse'];
                if($dato=='vestirse')
                    return $rs['vestirse'];
                if($dato=='arreglar')
                    return $rs['arreglar'];
                if($dato=='deposiciones')
                    return $rs['deposiciones'];
                if($dato=='miccion')
                    return $rs['miccion'];
                if($dato=='retrete')
                    return $rs['retrete'];
                if($dato=='trasladarse')
                    return $rs['trasladarse'];
                if($dato=='deambular')
                    return $rs['deambular'];
                if($dato=='escalones')
                    return $rs['escalones'];
        }
        return 'null';
    }
    

    public static function ActualizarBarthel(&$_barthel, $id_evm){

       if($_barthel->GetPuntajeBarthel() == '' || self::ExisteDetalleBarthel($_barthel) == 0){
    
        self::EliminarBarthel($_barthel);
           
       }else{
           if(self::ExisteBarthel($id_evm) == 1){

               $query="UPDATE barthel SET ".
                    "comer=".$_barthel->GetBarthelComer().", ".
                    "lavarse=".$_barthel->GetBarthelLavarse().", ".
                    "vestirse=".$_barthel->GetBarthelVestirse().", ".
                    "arreglar=".$_barthel->GetBarthelArreglar().", ".
                    "deposiciones=".$_barthel->GetBarthelDeposiciones().", ".
                    "miccion=".$_barthel->GetBarthelMiccion().", ".
                    "retrete=".$_barthel->GetBarthelRetrete().", ".
                    "trasladarse=".$_barthel->GetBarthelTrasladarse().", ".
                    "deambular=".$_barthel->GetBarthelDeambular().", ".
                    "escalones=".$_barthel->GetBarthelEscalones()." ".
                    "where evaluacion_medica_idevaluacion_medica=".$id_evm;

                $con=CDBSingleton::GetConn();
                $exito=$con->query($query);

                    if(CDBSingleton::RevisarExito($exito, $query))
                        return CDBSingleton::GetUltimoId();
                    else
                        return -1;
                    
           }else{
               
               self::IngresarBarthel($_barthel, $id_evm);
               
           }

        }

    }

    public static function EliminarBarthel(&$_barthel){

       $query="delete from barthel where evaluacion_medica_idevaluacion_medica=".$_barthel->GetId();

        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
                return CDBSingleton::GetUltimoId();
            else
                return -1;
    }
    
    public static function ExisteBarthel($id_evm) {
        $query1="select idbarthel from barthel where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=&CDBSingleton::GetConn();

        $exito1=$con->query($query1);
        if(CDBSingleton::RevisarExito($exito1, $query1) ) {
            if($exito1->numrows()>0) {
                return 1; //existe
            }
            return 0; // no existe
        }
    }

    public static function ExisteDetalleBarthel($_barthel) {
    
            if($_barthel->GetBarthelComer()=='' && $_barthel->GetBarthelLavarse()=='' && $_barthel->GetBarthelVestirse()==''
                    && $_barthel->GetBarthelArreglar()=='' && $_barthel->GetBarthelDeposiciones()==''
                    && $_barthel->GetBarthelMiccion()=='' && $_barthel->GetBarthelRetrete()=='' && $_barthel->GetBarthelTrasladarse()==''
                    && $_barthel->GetBarthelDeambular()=='' && $_barthel->GetBarthelEscalones()==''){
                    
                return 0; //no existe
            }
            return 1; //  existe
    }
    
    
}
?>