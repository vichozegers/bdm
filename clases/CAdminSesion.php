<?php
//**General - "Fundacion las Rosas"*********//
//												//
// CAdminSesion.php							//
// 28/11/2005 - Sebastian Echeverria					//
// Descripci�n: Clase encargada controlar el
// acceso y los permisos de un usuario.				//
//**********************************************//
//**Estado**************************************//
// 01/12/2005 - Sebastian Echeverria - Arreglos (almacenar id usuario)	//
// 28/11/2005 - Sebastian Echeverria - Arch original					//
//**********************************************//
// Incluimos las clases requeridas
require_once('DB.php');
require_once('clases/Comunes/CDBSingleton.php');
class CAdminSesion
{
	//****************************************************************************
	// Descripcion: Inicia una sesion. Debe ser llamado al inicio de cada script.
	//****************************************************************************
	static public function IniciarSesion()
	{
		session_name("bdu_movil");
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
		$sSelectQuery = " SELECT idusuario, permisos_idpermiso FROM usuario " .
						        " WHERE login = '". $_sLogin . "' " .
						        " AND password_2 = '" . $_sPassword . "' ".
		                        " AND estado = 'activo'";

        $Con=CDBSingleton::GetConn();
        $exito=$Con->query($sSelectQuery);

		// Revisamos exito y validamos
		if ( CDBSingleton::RevisarExito($exito, $sSelectQuery) )
		{
                    $aRow = $exito->fetchRow(DB_FETCHMODE_ASSOC);
			if ( $aRow )
			{

//------------------------------------------------------------------------------------------------------
//                for ($i=0; $i<=70; $i++)
//                    {
//                      echo "Estoy dentro de exito :"." --->> ".$_sLogin."--->>".$_sPassword."....". $sSelectQuery ."---".$nIdUsuario ."<br>";
//                    }
//------------------------------------------------------------------------------------------------------

				// Lo marcamos como logeado
				$nIdUsuario = $aRow['idusuario'];
				$nIdPermiso = $aRow['permisos_idpermiso'];
                                 
              
                                
				$_SESSION['logged_in'] = $_sLogin;
				$_SESSION['id_usuario'] = $nIdUsuario;
				$_SESSION['id_permiso'] = $nIdPermiso;
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
	/*static public function Logout(  )
	{
		// Sacamos a usuario del sistema si estaba logeado
		if (isset($_SESSION['logged_in']) )
		{	
			unset($_SESSION['logged_in']);
			unset($_SESSION['id_usuario']);
			unset($_SESSION['id_permisos']);
		}
		else
			return false;
		
		return true;		
	}*/
        
        static public function Logout(  )
	{
		// Sacamos a usuario del sistema si estaba logeado
		if (isset($_SESSION['logged_in']) )
		{	
			unset($_SESSION['id_usuario']);
			//unset($_SESSION['permiso']);
                        unset($_SESSION['id_permisos']);
                        unset($_SESSION['estado']);
                        //destruyo session

                    $namepc=PHP_uname('n');
                    $sessionid=session_id();
                    $usuario=$_SESSION['logged_in'];

                    $servidor = Configuracion::$DB_HOST;
                    $usuarios = Configuracion::$DB_USER;
                    $passw = Configuracion::$DB_PASS;
                    $basededatos= Configuracion::$DB_NAME;

                    @mysql_connect($servidor, $usuarios, $passw)
                    or die('Error al Intentar Conectar con la base de datos ');

                    @mysql_select_db($basededatos)
                    or die('Error Seleccionando la base de datos ');

                    mysql_query("DELETE FROM usuarios_enlinea WHERE sessionid='$sessionid' and usuario='$usuario' and namepc='$namepc'");
                    mysql_close();

                    unset($_SESSION['logged_in']);
                    session_destroy();
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