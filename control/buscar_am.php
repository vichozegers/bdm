<?php

require_once("header.php");
require_once("clases/Personas/CAdminPersonas.php");
require_once ("clases/Hogar/CAdminHogar.php");
require_once ("clases/Residentes/CAdminResidentes.php");
require_once("clases/utilitarios/CAdminUtilitarios.php");
include_once("clases/CKatz.php");
include_once ("clases/CAdminKatz.php");
include_once ("../class.online.php");

//$usuarios = new Usuariosenlinea();
//echo $usuarios->enlinea();

 if(!isset($_SESSION["logged_in"])){
    header("Location: ../index.php");
}
                //contactNameField //APELLIDO            //contactEmailField // RUT
            //APELLIDO//                                                     //RUT//                      //CAMPO OCULTO//
if (($_POST['contactNameField'] =='' && $_POST['val']=='1') OR ($_POST['contactEmailField']=='' && $_POST['val']=='2')) {

    $mensaje='1';

    
    
}                   //contactNameField //APELLIDO            //contactEmailField // RUT

                         //APELLIDO//                             //RUT//     
elseif((isset($_POST['contactNameField'])!='') or ( ($_POST['contactEmailField'])!='')){

               //contactEmailField // RUT
    if (isset($_POST['contactEmailField'])!='') {
                                                                  //contactEmailField // RUT
                     $adultorut=CAdminPersonas::GetAdultoMayorRut($_POST['contactEmailField']);
                   
                     $hogar =CAdminHogar::GetHogarNombre($adultorut->GetHogar());
                     $katz= CAdminKatz::GetKatzVistasBduMovil($adultorut->Getid());
                     
                     $registros= '1';
                     
                         }
                                   
               //contactNameField //APELLIDO         
  elseif (isset($_POST['contactNameField'])!=''){
      
      
                                                          //contactNameField //APELLIDO 
      $adultos_apellido=CAdminResidentes::GetPersonasApell($_POST['contactNameField']);
      $ap=$_POST['contactNameField'];
      $registros_ap='1';
      }
                
}   
   
 require_once ('../vistas/v_buscar_am.php');

 ?>
