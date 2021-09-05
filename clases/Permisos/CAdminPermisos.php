<?php

//**********************************************//
// CAdminPermisos.php							//
// Autor: El Potro                              //
//**********************************************//
	
// Incluimos las clases requeridas
require_once('DB.php');
require_once('clases/Comunes/CDBSingleton.php');
require_once('clases/Permisos/CPermisos.php');
require_once('clases/Permisos/CAdminPermisos.php');


class CAdminPermisos
{
 	/********************************************

     *********************************************/

    public static function GetPermisos($idpermi)
    {
        $query="select * from permisos where idpermiso=".$idpermi;

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
              $a="";
              $accesos = array();
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);

    //        echo $rs['idpermiso'];
    //        echo "<br>";
    //        echo $rs['solicitud_crear'];

              $accesos=self::CrearPermisos($rs);
        //      echo $accesos['idpermiso'];
              return $accesos;
            }
        }
    }


 	/********************************************

     *********************************************/

	public static function CrearPermisos($row)
    {
        $permisos= new CPermisos();

		$permisos->SetIdPermiso($row['idpermiso']);
                $permisos->SetSolicitudCrear($row['solicitud_crear']);
		$permisos->SetSolicitudActualiza($row['solicitud_actualizar']);
		$permisos->SetSolicitudVer($row['solicitud_ver']);

                $permisos->SetEvaSocialCrear($row['evasocial_crear']);
		$permisos->SetEvaSocialActualiza($row['evasocial_actualizar']);
		$permisos->SetEvaSocialVer($row['evasocial_ver']);

                $permisos->SetEvaMedicaCrear($row['evamedica_crear']);
		$permisos->SetEvaMedicaActualiza($row['evamedica_actualizar']);
		$permisos->SetEvaMedicaVer($row['evamedica_ver']);

                $permisos->SetProcesoPostulacionCrear($row['propos_crear']);
		$permisos->SetProcesoPostulacionActualiza($row['propos_actualizar']);
		$permisos->SetProcesoPostulacionIngAdmIngreso($row['propos_ingresoadm']);
		$permisos->SetProcesoPostulacionIngAdmDesistir($row['propos_desistir']);

                $permisos->SetHorasMedicasVer($row['horas_medicas']);

                $permisos->SetDigitalizacionSubir($row['digitalizacion_subir']);
		$permisos->SetDigitalizacionBajar($row['digitalizacion_bajar']);
		$permisos->SetDigitalizacionImprimir($row['digitalizacion_imprimir']);
		$permisos->SetDigitalizacionVer($row['digitalizacion_ver']);
		$permisos->SetDigitalizacionPrivado($row['digitalizacion_privado']);

		$permisos->SetResidenteIngresoFisico($row['residente_ingresofisico']);
		$permisos->SetResidenteBusqueda($row['residente_busqueda']);
		$permisos->SetResidenteTraslado($row['residente_traslado']);
		$permisos->SetResidenteEgreso($row['residente_egreso']);

                $permisos->SetHogarCrear($row['hogares_crear']);
		$permisos->SetHogarActualiza($row['hogares_modificar']);
		$permisos->SetHogarVer($row['hogares_ver']);
		$permisos->SetHogarSuperNumeral($row['hogares_supernumeral']);

                $permisos->SetConsultaVer($row['consultas_ver']);
		$permisos->SetAdministracionRegistro($row['admin_registrar']);
		$permisos->SetAdministracionVer($row['admin_ver']);

        return $permisos;
	}


	//****************************************************************************
	// Descripcion: Inicia una sesion. Debe ser llamado al inicio de cada script.
	//****************************************************************************
	static public function IniciarSesion()
	{
		session_name("flr_session");
		session_start();	
	}

	//*****************************************************************
	// Descripcion: Logea un usuario al sistema
	// Argumentos:
	//  $_sLogin: el login
	//  $_sPassword: la contrase�a
	// Salida: true si no tuvo problemas, false si no logro completar
	//  la operacion.
	//*****************************************************************
	static public function Login( $_sLogin, $_sPassword )
	{

        //------------------------------------------------------------------------------------------------------
        // for ($i=0; $i<=70; $i++)
        // {
        //   echo "Estoy dentro de la funcion Login....>> ". $_sLogin ."--". $_sPassword ."<br>";
        // }
        //------------------------------------------------------------------------------------------------------
        
		// Revisamos si estaba logeado como otro, lo sacamos
		if ( isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] != $_sLogin))
			self::Logout();

        // Limpiamos entradas
		$_sLogin    = ereg_replace("[^a-z,A-Z,0-9]", "", $_sLogin);
		$_sPassword = ereg_replace("[^a-z,A-Z,0-9]", "", $_sPassword);		
		
		// Revisamos en base de datos si usuario es valido
		$sSelectQuery = " SELECT idusuario FROM usuario " .
						        " WHERE login = '". $_sLogin . "' " .
						        " AND password_2 = '" . $_sPassword . "' ".
		                        " AND estado = 'activo'";

        $Con=CDBSingleton::GetConn();
        $exito=$Con->query($sSelectQuery);

		// Revisamos exito y validamos
		if ( CDBSingleton::RevisarExito($exito, $sSelectQuery) )
		{
			if ( $aRow = $exito->fetchRow(DB_FETCHMODE_ASSOC) )
			{

//------------------------------------------------------------------------------------------------------
//                for ($i=0; $i<=70; $i++)
//                    {
//                      echo "Estoy dentro de exito :"." --->> ".$_sLogin."--->>".$_sPassword."....". $sSelectQuery ."---".$nIdUsuario ."<br>";
//                    }
//------------------------------------------------------------------------------------------------------

				// Lo marcamos como logeado
				$nIdUsuario = $aRow['idusuario'];
				$_SESSION['logged_in'] = $_sLogin;
				$_SESSION['id_usuario'] = $nIdUsuario;
 				return true;
			} 
		}
		
		// Si hubo algun problema, retornamos false;
		return false;
	}

	//*****************************************************************
	// Descripcion: Saca a un usuario del sistema
	// Salida: true si no tuvo problemas, false si no logro completar
	//  la operacion.
	//*****************************************************************	
	static public function Logout(  )
	{
		// Sacamos a usuario del sistema si estaba logeado
		if (isset($_SESSION['logged_in']) )
		{	
			unset($_SESSION['logged_in']);
			unset($_SESSION['id_usuario']);
			unset($_SESSION['permisos']);
		}
		else
			return false;
		
		return true;		
	}
	
	//*****************************************************************
	// Descripcion: Revisa acceso a pagina
	// Argumentos:
	//  $_sArea: un string que indica el area
	// Salida: true si tiene permiso, false si no tiene o no esta logeado
	//*****************************************************************	
	static public function TienePermiso( $_sArea )
	{
		// Revisamos si esta logeado
		if ( isset($_SESSION['logged_in']) )
		{
			// Recuperamos permisos
			$aPermisos = $_SESSION['permisos'];
			
			// Revisamos si tiene permiso para esta area
			if ( isset($aPermisos[$_sArea]) )
				return true;
			else
				return false;
		}
		else
			return false;					
	}
	
	//*****************************************************************
	// Descripcion: Recupera el nombre de la pers que esta logeada
	// Argumentos: nada
	// Salida: un string con el nombre del que esta logeado y false si no esta logeado
	//*****************************************************************	
	static public function NombreUsuario()
	{
		// Revisamos si esta logeado
		if ( isset($_SESSION['logged_in']) )
			return $_SESSION['id_usuario'];
		else
			return false;					
	}
	

}

?>