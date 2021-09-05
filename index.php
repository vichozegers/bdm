<!--Autor: Vicente Zegers
Proyecto:BDU_MOVIL_VER2
Fundación las Rosas 
Fecha: 11.07.13-->
<?php

require_once("header.php");
require_once("class.online.php");
$bLogged = false;
$bError = false;
$sLogin = "";

// El usuario intenta ingresar:
if(isset($_POST["contactNameField"])&& isset($_POST["contactEmailField"]) )
{

	$bError = !CAdminSesion::Login($_POST["contactNameField"], $_POST["contactEmailField"]);
  	//$arr_rpta = array("estado" => "2", "url" => ""); //Retorna Estado 0 Campos Vacios Mensaje Azul
       
        CFuncionesBasicas::Redirigir("index.php?e=1"); //Retorna e=1, Mensaje Azul Visible
}

// El usuario desea terminar la sesion:
if(isset($_GET["logout"]))
{
	CAdminSesion::Logout();
	CFuncionesBasicas::Redirigir("index.php");
 
}

// El usuario ya esta ingresado
if(isset($_SESSION['logged_in']))
{
        $bLogged = true;
	$sLogin = $_SESSION['logged_in'];
        
        $enlinea= new Usuariosenlinea();
        $enlinea->recargar();
        
        CFuncionesBasicas::Redirigir("control/inicio.php"); //Redirecciona al Inicio BDUMovil
   
             
//$arr_rpta = array("estado" => "1", "url" => 'control/inicio.php'); //Retorna 1 si se ha logueado
        
}

//echo json_encode($arr_rpta); // arteglo json retornado

require_once ('vistas/v_login.php'); //Vista Login


?>
