<?php
include_once("clases/Salud/CEvaluacionMedica.php");

class CAdminMinimental
{
    public static function IngresarMinimental(&$Min, $id_evm)
    {
        $query="insert into minimental(evaluacion_medica_idevaluacion_medica, uno_mes, uno_dia_mes, uno_anno, uno_dia_semana, dos_objeto1,
            dos_objeto2, dos_objeto3, dos_repeticiones, tres_n1, tres_n2, tres_n3, tres_n4, tres_n5, 
            cuatro_accion1, cuatro_accion2, cuatro_accion3, cuatro_sinaccion, cinco_objeto1, cinco_objeto2, 
            cinco_objeto3, seis_dibujo) values (".$id_evm.", ".$Min->GetUnoMes().", '".$Min->GetUnoDia()."',
            '".$Min->GetUnoAnno()."', '".$Min->GetUnoDiaSemana()."', '".$Min->GetDosObjeto1()."',
            '".$Min->GetDosObjeto2()."', '".$Min->GetDosObjeto3()."', '".$Min->GetDosRepeticiones()."',
            '".$Min->GetTresN1()."', '".$Min->GetTresN2()."', '".$Min->GetTresN3()."', '".$Min->GetTresN4()."',
            '".$Min->GetTresN5()."', '".$Min->GetCuatroAccion1()."', '".$Min->GetCuatroAccion2()."',
            '".$Min->GetCuatroAccion3()."', NULL, '".$Min->GetCincoObjeto1()."',
            '".$Min->GetCincoObjeto2()."', '".$Min->GetCincoObjeto3()."', '".$Min->GetSeisDibujo()."')";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            return 0;
        }
        return 1;
    }
    
    public static function GetMinimental($id_evm, $dato)
    {
        $conn=CDBSingleton::GetConn();
        $query="select * from minimental where evaluacion_medica_idevaluacion_medica = ".$id_evm."";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                if($dato=='uno_mes')
                    return $rs['uno_mes'];
                if($dato=='uno_dia_mes')
                    return $rs['uno_dia_mes'];
                if($dato=='uno_anno')
                    return $rs['uno_anno'];
                if($dato=='uno_dia_semana')
                    return $rs['uno_dia_semana'];
                if($dato=='dos_objeto1')
                    return $rs['dos_objeto1'];
                if($dato=='dos_objeto2')
                    return $rs['dos_objeto2'];
                if($dato=='dos_objeto3')
                    return $rs['dos_objeto3'];
                if($dato=='dos_repeticiones')
                    return $rs['dos_repeticiones'];
                if($dato=='tres_n1')
                    return $rs['tres_n1'];
                if($dato=='tres_n2')
                    return $rs['tres_n2'];
                if($dato=='tres_n3')
                    return $rs['tres_n3'];
                if($dato=='tres_n4')
                    return $rs['tres_n4'];
                if($dato=='tres_n5')
                    return $rs['tres_n5'];
                if($dato=='cuatro_accion1')
                    return $rs['cuatro_accion1'];
                if($dato=='cuatro_accion2')
                    return $rs['cuatro_accion2'];
                if($dato=='cuatro_accion3')
                    return $rs['cuatro_accion3'];
                if($dato=='cinco_objeto1')
                    return $rs['cinco_objeto1'];
                if($dato=='cinco_objeto2')
                    return $rs['cinco_objeto2'];
                if($dato=='cinco_objeto3')
                    return $rs['cinco_objeto3'];
                if($dato=='seis_dibujo')
                    return $rs['seis_dibujo'];
        }
        return 'null';
    }

    public static function ActualizarMinimental(&$_min, $id_evm){

       if($_min->GetMinimental() == '' || self::ExisteDetalleMinimental($_min) == 0){
           self::EliminarMinimental($_min);
       }
       else{
           if(self::ExisteMinimental($id_evm) == 1){

               $query="UPDATE minimental SET ".
                    "uno_mes=".$_min->GetUnoMes().", ".
                    "uno_dia_mes=".$_min->GetUnoDia().", ".
                    "uno_anno=".$_min->GetUnoAnno().", ".
                    "uno_dia_semana=".$_min->GetUnoDiaSemana().", ".
                    "dos_objeto1=".$_min->GetDosObjeto1().", ".
                    "dos_objeto2=".$_min->GetDosObjeto2().", ".
                    "dos_objeto3=".$_min->GetDosObjeto3().", ".
                    "dos_repeticiones=".$_min->GetDosRepeticiones().", ".
                    "tres_n1=".$_min->GetTresN1().", ".
                    "tres_n2=".$_min->GetTresN2().", ".
                    "tres_n3=".$_min->GetTresN3().", ".
                    "tres_n4=".$_min->GetTresN4().", ".
                    "tres_n5=".$_min->GetTresN5().", ".
                    "cuatro_accion1=".$_min->GetCuatroAccion1().", ".
                    "cuatro_accion2=".$_min->GetCuatroAccion2().", ".
                    "cuatro_accion3=".$_min->GetCuatroAccion3().", ".
                    "cinco_objeto1=".$_min->GetCincoObjeto1().", ".
                    "cinco_objeto2=".$_min->GetCincoObjeto2().", ".
                    "cinco_objeto3=".$_min->GetCincoObjeto3().", ".
                    "seis_dibujo=".$_min->GetSeisDibujo()." ".
                    "where evaluacion_medica_idevaluacion_medica=".$id_evm;

                $con=CDBSingleton::GetConn();
                $exito=$con->query($query);

                    if(CDBSingleton::RevisarExito($exito, $query))
                        return CDBSingleton::GetUltimoId();
                    else
                        return -1;
           }
           else{
               self::IngresarMinimental($_min, $id_evm);
           }

       }

    }

    public static function EliminarMinimental(&$_min){

       $query="delete from minimental where evaluacion_medica_idevaluacion_medica=".$_min->GetId();

        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query))
                return CDBSingleton::GetUltimoId();
            else
                return -1;
    }

    public static function ExisteMinimental($id_evm) {
        $query1="select idminimental from minimental where evaluacion_medica_idevaluacion_medica=".$id_evm;
        $con=&CDBSingleton::GetConn();

        $exito1=$con->query($query1);
        if(CDBSingleton::RevisarExito($exito1, $query1) ) {
            if($exito1->numrows()>0) {
                return 1; //existe
            }
            return 0; // no existe
        }
    }

    public static function ExisteDetalleMinimental($_min) {
    
            if($_min->GetUnoMes()=='' && $_min->GetUnoDia()=='' && $_min->GetUnoAnno()==''
                    && $_min->GetUnoDiaSemana()=='' && $_min->GetDosObjeto1()==''
                    && $_min->GetDosObjeto2()=='' && $_min->GetDosObjeto3()=='' && $_min->GetTresN1()==''
                    && $_min->GetTresN2()=='' && $_min->GetTresN3()=='' && $_min->GetTresN4()==''
                    && $_min->GetTresN5()=='' && $_min->GetCuatroAccion1()=='' && $_min->GetCuatroAccion2()==''
                    && $_min->GetCuatroAccion3()=='' && $_min->GetCincoObjeto1()=='' && $_min->GetCincoObjeto2()==''
                    && $_min->GetCincoObjeto3()==''  && $_min->GetSeisDibujo()=='') {
                    
                return 0; //no existe
            }
            return 1; //  existe
    }

}
?>