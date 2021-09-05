<?php
require_once("header.php");
require_once("clases/CAdminSesion.php"); 
include_once("clases/Residentes/CAdminResidentes.php");
include_once("clases/Social/CAdminPersonas.php");
include_once("clases/Hogar/CAdminHogar.php");

if(!isset($_SESSION["logged_in"])){
    header("Location: ../index.php");
}

//SUMA DE AM POR HOGARES
$residentes_hogarcristo=CAdminPersonas::GetResidentesXOrigen(2);
$egresados_hogarcristo=CAdminPersonas::GetResidentesEgresadosXOrigen(2);
$fallecidos_hogarcristo=CAdminPersonas::GetResidentesFallecidosXOrigen(2);
$restotales=CAdminResidentes::GetNumResidentes();
$totResComunidad= CAdminResidentes::GetNumResidentesComunidad();
$totResHogarCristo= CAdminResidentes::GetNumResidentesHogarCristo();


require_once ('../vistas/v_resumen_general.php');
?>




    
    
 