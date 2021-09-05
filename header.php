<?php
//**Header general - "Fundacion las Rosas"	  **//
//											                      	//
// header.php					                  				//
// 19/11/2005 - Juan Ignacio Lopez            	//
// Descripci�n: Header general de scripts      	//
//**********************************************//

//**Estado*****************************************//
// 28/11/2005 - Sebastian Echeverria - Arreglos    //
// 19/11/2005 - Juan Ignacio Lopez - Arch original //
//*************************************************//

// Clases usadas en general por scripts
 
require_once('clases/Comunes/CDBSingleton.php');
require_once('clases/Comunes/CFuncionesBasicas.php');
require_once('clases/CAdminSesion.php');
//require_once('clases/Usuario/CAdminUsuarios.php');
 

// Conectamos a base de datos

//AGREGADO DAVID
header('Content-Type: text/html; charset=iso-8859-1');

CDBSingleton::Conectar();

CAdminSesion::IniciarSesion();


 
?>
