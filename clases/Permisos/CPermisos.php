<?php

//**********************************************//
// CPermisos.php    							//
// Autor: El Potro                              //
//**********************************************//

include_once("clases/Comunes/CDBSingleton.php");
require_once('clases/Permisos/CAdminPermisos.php');
require_once('clases/Permisos/CPermisos.php');


class CPermisos
{
	/**********************************
	 * Definicion de variables
	 **********************************/
	 private $idpermiso;

     private $soli_crear;
	 private $soli_act;
	 private $soli_ver;

	 private $evas_crear;
	 private $evas_act;
	 private $evas_ver;

	 private $evam_crear;
	 private $evam_act;
	 private $evam_ver;

	 private $propos_crear;
	 private $propos_act;
	 private $propos_ingadm_ing;
	 private $propos_ingadm_des;

	 private $hmed_ver;

 	 private $digi_subir;
 	 private $digi_bajar;
 	 private $digi_impr;
 	 private $digi_ver;
         private $digi_priv;

        private $resi_ingfis;
        private $resi_busq;
        private $resi_tras;
        private $resi_egre;

        private $hogar_crear;
        private $hogar_act;
        private $hogar_ver;
        private $hogar_super;
        private $consu_ver;

        private $admin_reg;
        private $admin_ver;

	
	/**********************************
	 * Constructor
	 **********************************/
	public function   __construct() {}

	/**********************************
	 * Metodos Set
	 **********************************/

	public function SetIdPermiso($idpermiso){
		$this->idpermiso = $idpermiso;
	}
	
	public function SetSolicitudCrear($soli_crear){
		$this->soli_crear = $soli_crear;
	}

        public function SetSolicitudActualiza($soli_act){
		$this->soli_act = $soli_act;
	}

        public function SetSolicitudVer($soli_ver){
		$this->soli_ver = $soli_ver;
	}

	public function SetEvaSocialCrear($evas_crear){
		$this->evas_crear = $evas_crear;
	}

	public function SetEvaSocialActualiza($evas_act){
		$this->evas_act = $evas_act;
	}

	public function SetEvaSocialVer($evas_ver){
		$this->evas_ver = $evas_ver;
	}

        public function SetEvaMedicaCrear($evam_crear){
		$this->evam_crear = $evam_crear;
	}

	public function SetEvaMedicaActualiza($evam_act){
		$this->evam_act = $evam_act;
	}

	public function SetEvaMedicaVer($evam_ver){
		$this->evam_ver = $evam_ver;
	}

        public function SetProcesoPostulacionCrear($propos_crear){
		$this->propos_crear = $propos_crear;
	}

        public function SetProcesoPostulacionActualiza($propos_act){
		$this->propos_act = $propos_act;
	}

        public function SetProcesoPostulacionIngAdmIngreso($propos_ingadm_ing){
		$this->propos_ingadm_ing = $propos_ingadm_ing;
	}

        public function SetProcesoPostulacionIngAdmDesistir($propos_ingadm_des){
		$this->propos_ingadm_des = $propos_ingadm_des;
	}

	public function SetHorasMedicasVer($hmed_ver){
		$this->hmed_ver = $hmed_ver;
	}

	public function SetDigitalizacionSubir($digi_subir){
		$this->digi_subir = $digi_subir;
	}

	public function SetDigitalizacionBajar($digi_bajar){
		$this->digi_bajar = $digi_bajar;
	}

	public function SetDigitalizacionImprimir($digi_impr){
		$this->digi_impr = $digi_impr;
	}

	public function SetDigitalizacionVer($digi_ver){
		$this->digi_ver = $digi_ver;
	}

	public function SetDigitalizacionPrivado($digi_priv){
		$this->digi_priv = $digi_priv;
	}


	public function SetResidenteIngresoFisico($resi_ingfis){
		$this->resi_ingfis = $resi_ingfis;
	}

	public function SetResidenteBusqueda($resi_busq){
		$this->resi_busq = $resi_busq;
	}

	public function SetResidenteTraslado($resi_tras){
		$this->resi_tras = $resi_tras;
	}

	public function SetResidenteEgreso($resi_egre){
		$this->resi_egre = $resi_egre;
	}

	public function SetHogarCrear($hogar_crear){
		$this->hogar_crear = $hogar_crear;
	}

	public function SetHogarActualiza($hogar_act){
		$this->hogar_act = $hogar_act;
	}

	public function SetHogarVer($hogar_ver){
		$this->hogar_ver = $hogar_ver;
	}

	public function SetHogarSuperNumeral($hogar_super){
		$this->hogar_super = $hogar_super;
	}

	public function SetConsultaVer($consu_ver){
		$this->consu_ver = $consu_ver;
	}


	public function SetAdministracionRegistro($admin_reg){
		$this->admin_reg = $admin_reg;
	}


	public function SetAdministracionVer($consu_ver){
		$this->admin_ver = $consu_ver;
	}

	/* ----------------------------------------------------------------------------*
	 * Metodos Get
	 *----------------------------------------------------------------------------*/
	
	public function GetIdPermiso(){
		return $this->idpermiso;
	}
	
	public function GetSolicitudCrear(){
		return $this->soli_crear;
	}

        public function GetSolicitudActualiza(){
		return $this->soli_act;
	}

        public function GetSolicitudVer(){
		return $this->soli_ver;
	}

	public function GetEvaSocialCrear(){
		return $this->evas_crear;
	}

	public function GetEvaSocialActualiza(){
		return $this->evas_act;
	}

	public function GetEvaSocialVer(){
		return $this->evas_ver;
	}

        public function GetEvaMedicaCrear(){
		return $this->evam_crear;
	}

	public function GetEvaMedicaActualiza(){
		return $this->evam_act;
	}

	public function GetEvaMedicaVer(){
		return $this->evam_ver;
	}

        public function GetProcesoPostulacionCrear(){
		return $this->propos_crear;
	}

        public function GetProcesoPostulacionActualiza(){
		return $this->propos_act;
	}

        public function GetProcesoPostulacionIngAdmIngreso(){
		return $this->propos_ingadm_ing;
	}

        public function GetProcesoPostulacionIngAdmDesistir(){
		return $this->propos_ingadm_des;
	}

	public function GetHorasMedicasVer(){
		return $this->hmed_ver;
	}

	public function GetDigitalizacionSubir(){
		return $this->digi_subir;
	}

	public function GetDigitalizacionBajar(){
		return $this->digi_bajar;
	}

	public function GetDigitalizacionImprimir(){
		return $this->digi_impr;
	}

	public function GetDigitalizacionVer(){
		return $this->digi_ver;
	}

	public function GetDigitalizacionPrivado(){
		return $this->digi_priv;
	}

	public function GetResidenteIngresoFisico(){
		return $this->resi_ingfis;
	}

	public function GetResidenteBusqueda(){
		return $this->resi_busq;
	}

	public function GetResidenteTraslado(){
		return $this->resi_tras;
	}

	public function GetResidenteEgreso(){
		return $this->resi_egre;
	}

	public function GetHogarCrear(){
		return $this->hogar_crear;
	}

	public function GetHogarActualiza(){
		return $this->hogar_act;
	}

	public function GetHogarVer(){
		return $this->hogar_ver;
	}

	public function GetHogarSuperNumeral(){
		return $this->hogar_super;
	}

	public function GetConsultaVer(){
		return $this->consu_ver;
	}

	public function GetAdministracionRegistro(){
		return $this->admin_reg;
	}

	public function GetAdministracionVer(){
		return $this->admin_ver;
	}
        public function GetPermisosEVS(){
            $str="";
            ($this->evas_crear==1) ? $str.='1' : $str.='0';
            ($this->evas_act==1) ? $str.='1' : $str.='0';
            ($this->evas_ver==1) ? $str.='1' : $str.='0';
            return bindec($str);
        }
        public function GetPermisosEVM(){
            $str="";
            ($this->evam_crear==1) ? $str.='1' : $str.='0';
            ($this->evam_act==1) ? $str.='1' : $str.='0';
            ($this->evam_ver==1) ? $str.='1' : $str.='0';
            return bindec($str);
        }
        public function GetPermisosDig(){
            $str='';
            ($this->digi_bajar==1) ? $str.='1' : $str.='0';
            ($this->digi_impr==1) ? $str.='1' : $str.='0';
            ($this->digi_priv==1) ? $str.='1' : $str.='0';
            ($this->digi_subir==1) ? $str.='1' : $str.='0';
            ($this->digi_ver==1) ? $str.='1' : $str.='0';
            return bindec($str);
        }
        
}
?>