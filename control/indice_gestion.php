<?php
require_once("header.php");
require_once("clases/CAdminSesion.php");
include_once("clases/Residentes/CAdminResidentes.php");
include_once("clases/Social/CAdminPersonas.php");
include_once("clases/Hogar/CAdminHogar.php");
include_once("clases/utilitarios/CAdminUtilitarios.php");


if(!isset($_SESSION["logged_in"])){
    header("Location: ../index.php");
}

// ****************************************
// ************** Postulantes *************
// ****************************************
 
$lista_post_sin_evm=CAdminUtilitarios::GetPostulantesConSoloEvs();
 
// ****************************************
// ************* Solicitantes *************
// ****************************************

$totSolicitantes=CAdminPersonas::GetNumSolicitantes();
$lista_totSolicitantes=CAdminPersonas::GetListaSolicitantes();
$listaEspera=CAdminUtilitarios::GetPostulantesListaDeEspera();

$demanda=$totSolicitantes+count($lista_post_sin_evm)+count($listaEspera);
require_once ('../vistas/v_indice_gestion.php');
?>




    
    
 