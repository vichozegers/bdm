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

//TOTAL DE RESIDENTES POR GENERO
$totResConApoderadoHombre= CAdminResidentes::GetNumResConApoderadoHombre();
$totResSinApoderadoHombre= CAdminResidentes::GetNumResSinApoderadoHombre();
$totalresidentesHombre = (int)$totResConApoderadoHombre + (int)$totResSinApoderadoHombre;

$totResConApoderadoMujer= CAdminResidentes::GetNumResConApoderadoMujer();
$totResSinApoderadoMujer= CAdminResidentes::GetNumResSinApoderadoMujer();
$totalresidentesMujer = (int) $totResConApoderadoMujer + (int) $totResSinApoderadoMujer;

require_once ('../vistas/v_residentes_genero.php');
?>




    
    
 