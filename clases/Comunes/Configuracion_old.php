<?php

/* ************************************************ */
/*  Configuracion - "Fundacion las Rosas"         * */
/*  Configuracion.php			          * */
/*  OBj: parametrizar Bd y Otros en Sistema BDU   * */
/* ************************************************ */

class Configuracion {

    /*  *************************************  */
    /*  * Configuracion de la Base de Datos *  */
    /*  *************************************  */
  
        public static $DB_USER = 'phpaccess';

        public static $DB_PASS = 'alivio2013';

        public static $DB_HOST = 'localhost';

        public static $DB_NAME = 'newdbflr_27102013';
        
        public static $BD_BDU  = 'newdbflr_27102013';

        
    /*  ****************************  */
    /*  *  Configuracion de Smarty *  */
    /*  ****************************  */

        public static $TEMPLATE_DIR = '/var/www/bdumovil2/smarty/templates/';

        public static $CONFIG_DIR   = '/var/www/bdumovil2/smarty/config/';

        public static $CACHE_DIR    = '/var/www/bdumovil2/smarty/cache/';

        public static $COMPILE_DIR  = '/var/www/bdumovil2/smarty/templates_c/';


    /*  ***************************************  */
    /*  * BD DE DATOS RELACIONADAS AL SISTEMA *  */
    /*  ***************************************  */

        public static $BD_apadrina = 'apadrina_2';
        
        public static $BD_eclesiastico = 'eclesiastico_29072013';
        
        public static $BD_BDU_SALUD = 'bds_08112013';
        
        public static $BD_BDUVIEW = 'bduview_27102013_29072013_08112013';
        
        public static $BDUMOVIL_VISTA = 'bduview_27102013_29072013_08112013';
        

    /*  **********************************************  */
    /*  * BD DE DATOS AUXILIAR A PREGUNTAR: APADRINA *  */
    /*  **********************************************  */
        
        public static $diferencia_dia="1000";
	public static $DIFERENCIA_DIA='1000';

    /*  **********************************  */
    /*  * Escala de Valores de Pensiones *  */
    /*  **********************************  */

        public static $Pension_basica   = 75000;
        public static $Pension_media    = 122450;
        public static $Pension_superior = 150000;


    /*  **************************************  */
    /*  * PARAMETROS MISCELANEOS DEL SISTEMA *  */
    /*  **************************************  */

        public static $TITULO_ICO        = '.:: FLR: Proyecto BduNew Ver3 ::.';

        public static $TITULO_APLICACION = 'Proyecto BduNew ver3';        
        
    /*  ***************************  */
    /*  * Fecha de la Versión BDU *  */
    /*  ***************************  */

        public static $fecha_version = "Ver 1.0 - 01/02/2013";

    /*  ***************************************************  */
    /*  * API para poder ver Doc. PDF embebidas en la web *  */
    /*  ***************************************************  */

        public static $link_docdig = 'http://intranet.flrosas.cl/bdu/control/digitalizacion/doc_dig';


    /*  *********************************************************************  */
    /*  * Variables de Email para los Deptos. a quien se envian Movimientos *  */
    /*  *********************************************************************  */

        public static $mail ="parancibia@flrosas.cl";
        public static $mail_ecle="parancibia@flrosas.cl";
        public static $mail_fonasaA="parancibia@flrosas.cl";
        public static $mail_bds="parancibia@flrosas.cl";
        public static $mail_apadrina="parancibia@flrosas.cl";
        public static $mail_enfermeria_1="parancibia@flrosas.cl";
        public static $mail_informatica="parancibia@flrosas.cl";
        public static $mail_adminbdu="adminbdu@fundlasrosas.cl";

        /*
        public static $mail ="acasanueva@flrosas.cl, parancibia@flrosas.cl, bflores@flrosas.cl, cvaldivieso@flrosas.cl, mcadenas@flrosas.cl, mjsaez@flrosas.cl, pcontreras@flrosas.cl, ybarria@flrosas.cl, bdusocial@flrosas.cl";
        public static $mail_ecle="ktoro@flrosas.cl, dalvarado@flrosas.cl, agaldames@flrosas.cl, pureta@flrosas.cl, jmunoz@flrosas.cl, jvaldes@flrosas.cl, parancibia@flrosas.cl";
        public static $mail_fonasaA="pbusquets@flrosas.cl, parancibia@flrosas.cl";
        public static $mail_apadrina = "jmontes@flrosas.cl";
        */
        
        public static $origenAM="Comunidad";
}
?>
