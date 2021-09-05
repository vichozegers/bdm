<?php
require_once("clases/Residentes/CEvento.php");
require_once("clases/Hogar/CAdminHogar.php");
require_once("clases/Social/Postulaciones/CAdminProcesoPostulacion.php");
require_once("clases/Pensiones/CAdminPensiones.php");
require_once("clases/Usuario/CAdminUsuarios.php");
require_once("clases/Residentes/CAdminResidentes.php");
require_once("clases/Eclesiastico/CAdminEclesiastico.php");

class CAdminEventos {

    public static function IngresarIngAdministrativo(&$evento, $id_ad, $af, $id_soli) 
    {
//        $query="insert into eventos(lugar_origen, tipo, lugar_destino, usuario_idusuario,
//        adulto_mayor_persona_idpersona, descripcion, fecha_realizacion, observaciones, aux, fecha_real) values (null, 'ingreso_adm',".
//            CAdminHogar::GetHogarId($evento->GetLugarDestino()).", ".$evento->GetResponsable().",".$id_ad.",'".
//            $evento->GetDescripcion()."','".$evento->GetFecha()."','".$evento->GetObservaciones()."','".$evento->GetAux()."','".date('Y-m-d H:i:s')."')";
        
        $query="insert into eventos(lugar_origen, tipo, lugar_destino, usuario_idusuario,
        adulto_mayor_persona_idpersona, descripcion, fecha_realizacion, observaciones, aux, fecha_real) values (null, 'ingreso_adm',".
            $evento->GetLugarDestino().", ".$evento->GetResponsable().",".$id_ad.",'".
            $evento->GetDescripcion()."','".$evento->GetFecha()."','".$evento->GetObservaciones()."','".$evento->GetAux()."','".date('Y-m-d H:i:s')."')";
        //actualizar adulto_mayor setear hogar y estado a postulante
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            $hogar=CAdminHogar::GetLugar($evento->GetLugarDestino());
            CAdminPersonas::IngresoAdministrativo($id_ad, $af, $evento->GetLugarDestino());
            CAdminProcesoPostulacion::finalizarProcesos($id_soli);
            $usr=CAdminUsuarios::GetUsuario2($evento->GetResponsable());
            self::SendMailIngAdministrativo(CAdminPersonas::GetAdultoMayor($id_ad), $hogar[0], $evento->GetFecha(), $usr);
            return 0;
        }
        return 1;
    }

    private static function SendMailIngAdministrativo(&$persona, &$hogar, $fecha, &$usr) {

        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido ingresado administrativamente el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre())."\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Ingreso Administrativo de Postulante";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail,$subject,$body,$header);
    }

    public static function IngresarTraslado(&$evento, $id_ad) {
        $query="insert into eventos(lugar_origen, tipo, lugar_destino, usuario_idusuario,
        adulto_mayor_persona_idpersona, descripcion, fecha_realizacion, observaciones, aux, fecha_real) values (".$evento->GetLugarOrigen(). ", 'traslado',".
        $evento->GetLugarDestino().", ".$evento->GetResponsable().",".$id_ad.",'".
            $evento->GetDescripcion()."','".$evento->GetFecha()."','".$evento->GetObservaciones()."','".$evento->GetAux()."','".date('Y-m-d H:i:s')."')";
        //        echo $query;

        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            $a=CAdminPersonas::IngresoTranslado($id_ad, $evento->GetLugarDestino());
            if($a==0) {
                $hogar=CAdminHogar::GetLugar($evento->GetLugarDestino());
                $hogar2=CAdminHogar::GetLugar($evento->GetLugarOrigen());
                $persona=CAdminPersonas::GetAdultoMayor($id_ad);
                $usr=CAdminUsuarios::GetUsuario2($evento->GetResponsable());
                self::SendMailTraslado($persona, $hogar[0], $hogar2[0], $evento->GetFecha(), $usr);
                self::SendMailTrasladoEclesiastico($persona, $hogar[0], $hogar2[0], $evento->GetFecha(), $usr);

                if ($persona->GetSistemaSalud()== 'Fonasa A'){
                   self::SendMailTrasladoFonasaA($persona, $hogar[0], $hogar2[0], $evento->GetFecha(), $usr);
                }

            }
            return 0;
        }
        return 1;
    } //actualizar adulto_mayor hogar

    private static function SendMailTraslado(&$persona, &$hogar, &$hogar2 ,$fecha, &$usr) {

        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido trasladado desde el hogar ".
            $hogar2->GetNumeroHogar().", ".utf8_decode($hogar2->GetNombre())." hacia el hogar ".$hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Traslado de Residente";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail,$subject,$body,$header);

        // Agregado por alejandro para apadrinaabuelo
        if(CAdminResidentes::ExisteAMApadrina($persona->GetNombre(),$persona->GetApellidoPaterno(),$persona->GetApellidoMaterno()) == 1)
        {
            mail(Configuracion::$mail_apadrina ,$subject,$body,$header);
            CAdminResidentes::TrasladoAMApadrina($persona->GetNombre(),$persona->GetApellidoPaterno(),$persona->GetApellidoMaterno(), $hogar->GetNumeroHogar());
        }
    }

    private static function SendMailTrasladoEclesiastico(&$persona, &$hogar, &$hogar2 ,$fecha, &$usr) {

        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido trasladado desde el hogar ".
            $hogar2->GetNumeroHogar().", ".utf8_decode($hogar2->GetNombre())." hacia el hogar ".$hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\nRealizado con fecha:".$fecha.
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";

        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Traslado de Residente / Eclesiastico";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail_ecle,$subject,$body,$header);

    }

    private static function SendMailTrasladoFonasaA(&$persona, &$hogar, &$hogar2 ,$fecha, &$usr) {

        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
            }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido trasladado desde el hogar ".
            $hogar2->GetNumeroHogar().", ".utf8_decode($hogar2->GetNombre())." hacia el hogar ".$hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";

        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Traslado de Residente / Redes Salud";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail_fonasaA,$subject,$body,$header);
    }

    // se agrego origen_inicial
    
    public static function IngresarIngFisico(&$evento, $id_ad, $origen_inicial) {
//        $query="insert into eventos(lugar_origen, tipo, lugar_destino, usuario_idusuario,
//        adulto_mayor_persona_idpersona, descripcion, fecha_realizacion, observaciones, aux, fecha_real) values (null".
//            ", 'ingreso', ".CAdminHogar::GetHogarId($evento->GetLugarDestino()).", ".$evento->GetResponsable().",".$id_ad.",'".$evento->GetDescripcion()."','".$evento->GetFecha()."','".$evento->GetObservaciones().
//            "','".$evento->GetAux()."','".date('Y-m-d H:i:s')."')";
        
        $query="insert into eventos(lugar_origen, tipo, lugar_destino, usuario_idusuario,
        adulto_mayor_persona_idpersona, descripcion, fecha_realizacion, observaciones, aux, fecha_real) values (null".
            ", 'ingreso', ".$evento->GetLugarDestino().", ".$evento->GetResponsable().",".$id_ad.",'".$evento->GetDescripcion()."','".$evento->GetFecha()."','".$evento->GetObservaciones().
            "','".$evento->GetAux()."','".date('Y-m-d H:i:s')."')";
        
        $con=CDBSingleton::GetConn();
        //echo $query;
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            $a=CAdminPersonas::IngresoFisico($id_ad, $evento->GetLugarDestino(), $origen_inicial);
            if($a==0) {
                $hogar=CAdminHogar::GetLugar($evento->GetLugarDestino());
                $persona=CAdminPersonas::GetAdultoMayor($id_ad);

                $usr=CAdminUsuarios::GetUsuario2($evento->GetResponsable());

        // ********************************************************************************************************* //        
        //  Se agrega metodo para realizar ingreso en Eclesiastico. Esta comentado hasta que se realice el cambio    //    
        
            CAdminEclesiastico::IngresarResidenteTransitoEclesiastico($id_ad);
                
        // ********************************************************************************************************* //        
                
                self::SendMailIngreso($persona, $hogar[0], $evento->GetFecha(), $usr);
                self::SendMailIngFisicoEclesiastico($persona, $hogar[0], $evento->GetFecha(), $usr);

                if ($persona->GetSistemaSalud()== 'Fonasa A'){
                   self::SendMailIngFisicoFonasaA($persona, $hogar[0], $evento->GetFecha(), $usr);
                }
            }
            return 0;
        }
        return 1;
    }   //actualizar adulto_mayor hogar y estado a residente

    private static function SendMailIngreso(&$persona, &$hogar, $fecha, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido ingresado como residente de la fundacion el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        $to=Configuracion::$mail_informatica;
        //        $to="darancibia@flrosas.cl, parancibia@flrosas.cl, bflores@flrosas.cl, cvaldivieso@flrosas.cl, jzuniga@flrosas.cl, mcadenas@flrosas.cl, mjsaez@flrosas.cl, pcontreras@flrosas.cl, ybarria@flrosas.cl, agomez@flrosas.cl";
        $subject="[BDU] Ingreso de Residente";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail,$subject,$body,$header);
    }

        public static function SendMailIngFisicoEclesiastico(&$persona, &$hogar, $fecha, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $pensiones=CAdminPensiones::GetPensiones(CAdminPersonas::GetIdAdultoMayor($persona->GetRut()));
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido ingresado como residente de la fundacion el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre())."\n\n";
        if(count($pensiones)>0) {
            $body.="El Adulto Mayor presenta las siguientes Pensiones:\n";
            for($i=0; $i<count($pensiones); $i++) {
                $body.="Pension: ".$pensiones[$i]->GetPrevision()."\t Tipo: ".$pensiones[$i]->GetTipo()."\t Monto: ".$pensiones[$i]->GetMonto()."\n";
            }
        }
        else
        {
            $body.="El Adulto Mayor no registra Pensiones\n";
        }
        $body.="\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Ingreso de Residente Eclesiastico";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail_ecle ,$subject,$body,$header);
    }

    private static function SendMailIngFisicoFonasaA(&$persona, &$hogar, $fecha, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa sido ingresado como residente de la fundacion el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Ingreso de Residente / Redes-Salud";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail_fonasaA,$subject,$body,$header);
    }
    
    public static function IngresarEgreso(&$evento, $id_ad) {
        $query="insert into eventos(lugar_origen, tipo, lugar_destino, usuario_idusuario,
        adulto_mayor_persona_idpersona, descripcion, fecha_realizacion, observaciones, aux, fecha_real) values (".CAdminHogar::GetHogarId($evento->GetLugarOrigen()). ", 'egreso',".
            "null , ".$evento->GetResponsable().",".$id_ad.",'".
            $evento->GetDescripcion()."','".$evento->GetFecha()."','".$evento->GetObservaciones()."','".$evento->GetAux()."','".date('Y-m-d H:i:s')."')";
        //echo $query;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            $usr=CAdminUsuarios::GetUsuario2($evento->GetResponsable());

            if(strcmp($evento->GetAux(), "fallecido")==0) {
                CAdminPersonas::IngresoEgreso($id_ad, $evento->GetFecha());
                self::SendMailFallecido(CAdminPersonas::GetAdultoMayor($id_ad), CAdminHogar::GetHogar(CAdminHogar::GetHogarId($evento->GetLugarOrigen())), $evento->GetFecha(), $usr);
                self::SendMailFallecidoEclesiastico(CAdminPersonas::GetAdultoMayor($id_ad), CAdminHogar::GetHogar(CAdminHogar::GetHogarId($evento->GetLugarOrigen())), $evento->GetFecha(), $usr);

                //----------------FALLECIMIENTO FONASA A -----------------------------------------------------

  //            echo "estoy pronto a entrar a preguntar..FONASA A - FALLECIMIENTO...";
                $persona=CAdminPersonas::GetAdultoMayor($id_ad);

  //            echo "estoy dentro en FONASA A - FALLECIMIENTO...-->>".$persona->GetSistemaSalud();

                if ($persona->GetSistemaSalud()== 'Fonasa A'){
                   self::SendMailFallecidoFonasaA($persona, CAdminHogar::GetHogar(CAdminHogar::GetHogarId($evento->GetLugarOrigen())), $evento->GetFecha(), $usr);
                }
                //--------------------------------------------------------------------------------------------

            }
            else {
                CAdminPersonas::IngresoEgreso($id_ad, "");
                self::SendMailEgreso(CAdminPersonas::GetAdultoMayor($id_ad), CAdminHogar::GetHogar(CAdminHogar::GetHogarId($evento->GetLugarOrigen())), $evento->GetFecha(), $evento->GetObservaciones(), $usr);
                self::SendMailEgresoEclesiastico(CAdminPersonas::GetAdultoMayor($id_ad), CAdminHogar::GetHogar(CAdminHogar::GetHogarId($evento->GetLugarOrigen())), $evento->GetFecha(), $evento->GetObservaciones(), $usr);

                //----------------EGRESO FONASA A ------------------------------------------------------------

                $persona=CAdminPersonas::GetAdultoMayor($id_ad);
                if ($persona->GetSistemaSalud()== 'Fonasa A'){
                   self::SendMailEgresoFonasaA($persona, CAdminHogar::GetHogar(CAdminHogar::GetHogarId($evento->GetLugarOrigen())), $evento->GetFecha(), $evento->GetObservaciones(), $usr);
                }

                //--------------------------------------------------------------------------------------------
                
            }

            return 0;
        }
        return 1;
    } //actualizar adulto_mayor hogar y estado a desistido

//inicio - mail Egreso
    private static function SendMailEgreso(&$persona, &$hogar, $fecha, $motivo, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa Egresado de la fundacion el dia ".$fecha." desde el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre())." por los siguinetes motivos: \n".$motivo.
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        //$to="darancibia@flrosas.cl, parancibia@flrosas.cl";
        $subject="[BDU] Egreso de Residente";
        $header="From: ".Configuracion::$mail_adminbdu;
        // echo $body;
        mail(Configuracion::$mail ,$subject,$body,$header);

        // Agregado por alejandro para apadrinaabuelo
        if(CAdminResidentes::ExisteAMApadrina($persona->GetNombre(),$persona->GetApellidoPaterno(),$persona->GetApellidoMaterno()) == 1){
                mail(Configuracion::$mail_apadrina ,$subject,$body,$header);
                CAdminResidentes::EgresoAMApadrina($persona->GetNombre(),$persona->GetApellidoPaterno(),$persona->GetApellidoMaterno(), 'egresado');
        }
    }
//fin - mail egreso normal


//inicio - mail Egreso Fonasa A
    private static function SendMailEgresoFonasaA(&$persona, &$hogar, $fecha, $motivo, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa Egresado de la fundacion el dia ".$fecha." desde el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre())." por los siguinetes motivos: \n".$motivo.
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        //$to="darancibia@flrosas.cl, parancibia@flrosas.cl";
        $subject="[BDU] Egreso de Residente / Redes-Salud";
        $header="From: ".Configuracion::$mail_adminbdu;
        // echo $body;
        mail(Configuracion::$mail_fonasaA,$subject,$body,$header);

    }
//fin - mail egreso Fonasa A

//inicio - mail Egreso Eclesiastico
    private static function SendMailEgresoEclesiastico(&$persona, &$hogar, $fecha, $motivo, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa Egresado de la fundacion el dia ".$fecha." desde el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre())." por los siguinetes motivos: \n".$motivo.
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        //$to="darancibia@flrosas.cl, parancibia@flrosas.cl";
        $subject="[BDU] Egreso de Residente / Eclesiastico";
        $header="From: ".Configuracion::$mail_adminbdu;
        // echo $body;
        mail(Configuracion::$mail_ecle,$subject,$body,$header);

    }
//fin - mail egreso Eclesiastico


//inicio - mail fallecidos
    private static function SendMailFallecido(&$persona, &$hogar, $fecha, &$usr) {
        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa fallecido el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        //$to="darancibia@flrosas.cl, parancibia@flrosas.cl";
        $subject="[BDU] Deceso de Residente";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail ,$subject,$body,$header);
        // Agregado por alejandro para apadrinaabuelo
        if(CAdminResidentes::ExisteAMApadrina($persona->GetNombre(),$persona->GetApellidoPaterno(),$persona->GetApellidoMaterno()) == 1){
                mail(Configuracion::$mail_apadrina ,$subject,$body,$header);
                CAdminResidentes::EgresoAMApadrina($persona->GetNombre(),$persona->GetApellidoPaterno(),$persona->GetApellidoMaterno(), 'fallecido');
        }
    }
//fin -mail fallecidos

//inicio - mail fallecidos Fonasa A
    private static function SendMailFallecidoFonasaA(&$persona, &$hogar, $fecha, &$usr) {

        // echo " <*** estoy dentro de fallecimiento fonosa A ***> ";

        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa fallecido el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        //$to="darancibia@flrosas.cl, parancibia@flrosas.cl";
        $subject="[BDU] Deceso de Residente / Redes-Salud";
        $header="From: ".Configuracion::$mail_adminbdu;
        
        mail(Configuracion::$mail_fonasaA,$subject,$body,$header);
    }
//fin -mail fallecidos Fonasa A

    //inicio - mail fallecidos Eclesiastico
    private static function SendMailFallecidoEclesiastico(&$persona, &$hogar, $fecha, &$usr) {

        // echo " <*** estoy dentro de fallecimiento fonosa A ***> ";

        $body="Se Informa que:\n\nDon(a) ";
        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\nHa fallecido el dia ".$fecha." en el hogar ".
            $hogar->GetNumeroHogar().", ".utf8_decode($hogar->GetNombre()).
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";
        //$to="darancibia@flrosas.cl, parancibia@flrosas.cl";
        $subject="[BDU] Deceso de Residente / Eclesiastico";
        $header="From: ".Configuracion::$mail_adminbdu;
        
        mail(Configuracion::$mail_ecle,$subject,$body,$header);
    }
//fin -mail fallecidos Eclesiastico

// ---------------------------------------------------------------------------------------------------------------------
// ------------------ Aviso de Nueva Enfermedad a ingresar BD de Enfermedades ------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

    public static function SendMailAvisoNuevaEnfermedad($id_ad, $obs_enf) {

        $usr=CAdminUsuarios::GetUsuario2($_SESSION['id_usuario']);

        $persona=CAdminPersonas::GetAdultoMayor($id_ad);

        $body="Se Informa que:\n\n";
        $body.="Se ha ingresado un nuevo diagnostico al Adulto Mayor: ,";

        $s=split(" ", utf8_decode($persona->GetNombre()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoPaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i])." ";
        }
        $s=split(" ", utf8_decode($persona->GetApellidoMaterno()));
        for($i=0; $i<count($s); $i++) {
            $body.=ucfirst($s[$i]);
        }

          $body.=", RUT:".$persona->GetRut1()."-".$persona->GetRut2().".\n  ";


          $body.="El cual no se encuentra en el listado oficial de diagnosticos que maneja el Sistema Salud.\n
              Es por esto que se solicita a Ud, como administrador del Area Medica, incorporar dichos datos para que estan disponibles y asi,\n
              de ahora en adelante, puedan ser diagnosticados por los profesionales respectivos de manera correcta. El o los nuevos\n
              diagnosticos solicitados por el profesional son:\n\n "."Diagnostico Nuevo:\n\n ".$obs_enf.
            "\n\nEvento realizado por: ".utf8_decode($usr->GetNombre())." ".utf8_decode($usr->GetApellidoPaterno())." ".utf8_decode($usr->GetApellidoMaterno())."\tLogin: ".$usr->GetLogin()."\n\nAtte.\nAdministrador Sistema BDU";

        $to=Configuracion::$mail_informatica;
        $subject="[BDU]-[BDS] Alerta Nuevo Diagnóstico Requerido a Postulante ";
        $header="From: ".Configuracion::$mail_adminbdu;

        mail(Configuracion::$mail_bds,$subject,$body,$header);

    }

// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------


    public static function GetUltimoIngAdministrativo($id_ad) {
        $query="select * from eventos where tipo='ingreso_adm' order by ideventos desc";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            if($exito->numrows()>0) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                return self::CrearEventos($rs);
            }
        }
        return new CEvento();
    }

    public static function CrearEventos($row) {
        $evento=new CEvento();
        $evento->SetId($row['ideventos']);
        $evento->SetAux($row['aux']);
        $evento->SetDescripcion($row['descripcion']);
        $evento->SetFecha($row['fecha_realizacion']);
        $evento->SetIdAdulto($row['adulto_mayor_persona_idpersona']);
        $evento->SetLugarDestino(CAdminHogar::GetHogarNombre($row['lugar_destino']));
        $evento->SetLugarOrigen(CAdminHogar::GetHogarNombre($row['lugar_origen']));
        $evento->SetObservaciones($row['observaciones']);
        $evento->SetResponsable($row['usuario_idusuario']);
        $evento->SetTipo($row['tipo']);
        return $evento;
    }

    public static function GetHistorialEventos($id_res) {
        $query="select * from eventos where adulto_mayor_persona_idpersona=".$id_res;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query)) {
            for($i=0; $i<$exito->numrows(); $i++) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearEventos($rs);
            }
        }
        return $a;
    }

    public static function CrearEventosVisual($row) {
        $evento=new CEvento();
        $evento->SetId($row['ideventos']);
        $evento->SetAux($row['aux']);
        $evento->SetDescripcion($row['descripcion']);
        $evento->SetFecha($row['fecha_realizacion']);
        $evento->SetFechaReal($row['fecha_real']);
        $evento->SetIdAdulto($row['adulto_mayor_persona_idpersona']);
        $evento->SetLugarDestino(CAdminHogar::GetNumeroHogar($row['lugar_destino']));
        $evento->SetLugarOrigen(CAdminHogar::GetNumeroHogar($row['lugar_origen']));
        $evento->SetObservaciones($row['observaciones']);
        $evento->SetResponsable($row['usuario_idusuario']);
        $evento->SetTipo($row['tipo']);
        return $evento;
    }

    public static function GetHistorialEventosVisual($id_res) {
        $query="select * from eventos where adulto_mayor_persona_idpersona=".$id_res;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query)) {
            for($i=0; $i<$exito->numrows(); $i++) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearEventosVisual($rs);
            }
        }
        return $a;
    }
    
    
/*
 *
 *
 */
    public static function moverEventos($id_ad_origen, $id_ad_destino) {
        $query="update eventos set adulto_mayor_persona_idpersona=".$id_ad_destino." where adulto_mayor_persona_idpersona=".$id_ad_origen;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            return 1;
        }
        return 0;
    }

    /*********************************************************************/

    public static function GetEventos1($fecha_inicio)
    {
        $query="select * from eventos where fecha_realizacion>='".$fecha_inicio."' or (fecha_real>='".$fecha_inicio."' and fecha_real is not null)";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query)) {
            for($i=0; $i<$exito->numrows(); $i++) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearEventos($rs);
            }
        }
        return $a;
    }

    public static function GetEventos2($fecha_inicio, $fecha_termino)
    {
        $query="select * from eventos where (fecha_realizacion>='".$fecha_inicio."' and fecha_realizacion<='".$fecha_termino."') or (fecha_real>='".$fecha_inicio."' and fecha_real>='".$fecha_termino."')" ;
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        $a=array();
        if(CDBSingleton::RevisarExito($exito, $query)) {
            for($i=0; $i<$exito->numrows(); $i++) {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=self::CrearEventos($rs);
            }
        }
        return $a;
    }
    
    
    static public function GetUltimaFichaIngreso($id_am)
    {
        $query="select fecha_realizacion from eventos, adulto_mayor
                where tipo='ingreso' and adulto_mayor_persona_idpersona=".$id_am."
                and eventos.lugar_destino=adulto_mayor.hogar_lugar_idlugar
                order by fecha_realizacion desc LIMIT 1";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
            {
                if($exito->numrows()>0)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                    return $rs['fecha_realizacion'];
                }
            }
        
        return false;
    }
    
}
?>