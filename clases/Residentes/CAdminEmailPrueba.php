<?php

echo "Entre";

require_once("../Comunes/Configuracion.php");

        $body="Se Informa que:\n\nDon(a) ";
        $to=Configuracion::$mail_informatica;
        $subject="[BDU] Ingreso Administrativo de Postulante";
        $header="From: ".Configuracion::$mail_adminbdu;
        mail(Configuracion::$mail,$subject,$body,$header);

echo "Pase";
        
?>