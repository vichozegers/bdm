<?php

/********************************
 * CUsuario.php
 *
 * Autor: Parancibia
 ********************************/

include_once("clases/Comunes/CDBSingleton.php");
require_once('clases/Usuario/CAdminUsuarios.php');

class CUsuario
{
	/**********************************
	 * Definicion de variables
	 **********************************/
	 private $idusuario;
	 private $nombre;
         private $apellido_paterno;
	 private $apellido_materno;
	 private $password_2;
	 private $estado;
	 private $rut;
	 private $direccion;
	 private $login;
         private $permiso;
	 private $cargo;	

	/**********************************
	 * Constructor
	 **********************************/
	public function   __construct() {}

	/**********************************
	 * Metodos Set
	 **********************************/

	public function SetIdUsuario($idusuario){
		$this->idusuario = $idusuario;
	}
	
	public function SetNombre($nombre){
		$this->nombre = $nombre;
	}

        public function SetApellidoPaterno($apellido_paterno){
		$this->apellido_paterno = $apellido_paterno;
	}

        public function SetApellidoMaterno($apellido_materno){
		$this->apellido_materno = $apellido_materno;
	}

	public function SetPassword($password_2){
		$this->password_2 = $password_2;
	}

	public function SetEstado($estado){
		$this->estado = $estado;
	}

	public function SetRut($rut){
		$this->rut = $rut;
	}
	
	public function SetDireccion($direccion){
		$this->direccion = $direccion;
	}
	
	public function Setlogin($login){
		$this->login = $login;
        }
        public function SetPermiso($permiso){
		$this->permiso = $permiso;
        }
	public function SetCargo($cargo){
		$this->cargo = $cargo;
	}
	/* ----------------------------------------------------------------------------*
	 * Metodos Get
	 *----------------------------------------------------------------------------*/
	
	public function GetIdUsuario(){
		return $this->idusuario;
	}
	
	public function GetNombre(){
		return $this->nombre;
	}
	
	public function GetApellidoPaterno(){
		return $this->apellido_paterno;
	}

	public function GetApellidoMaterno(){
		return $this->apellido_materno;
	}
	
	public function GetPassword(){
		return $this->password_2;
	}
	
	public function GetEstado(){
		return $this->estado;
	}
	
	public function GetRut(){
		return $this->rut;
	}
	
        public function GetDireccion(){
		return $this->direccion;
	}

        public function GetLogin(){
		return $this->login;
	}

        public function GetPermiso(){
		return $this->permiso;
	}
	public function GetCargo(){
		return $this->cargo;
	}
}

?>
