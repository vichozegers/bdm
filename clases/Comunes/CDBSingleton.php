<?php

//**DB Singleton - "Fundacion las Rosas"**		//
//												//
// CDBSingleton.php								//
// 10/11/2005 - Sebastian Echeverria			//
// Descripci�n: Clase encargada de encapsular	//
// la conexion a la base de datos.				//
//**********************************************//

//**Estado**************************************//
// 12/11/2005 - Sebastian Echeverria - Arreglo de bugs	//
// 10/11/2005 - Sebastian Echeverria - Arch. original	//
//**********************************************//

// Este include es para obtener la configuracion
require_once('clases/Comunes/Configuracion.php');
// Este include es para usar PEAR DB
require_once('DB.php');

class CDBSingleton
{
	static private $m_dbCon;

	//*****************************************************************
	// Descripcion: Retorna la conexion. La idea es que sea 
	// llamado como funcion estatica, de la forma 
	// CDBSingleton::GetConn
	//*****************************************************************
	static public function GetConn()
	{
		return self::$m_dbCon;
	}

	//*****************************************************************
	// Descripcion: Conecta a la base de datos. La idea es que sea 
	// llamado como funcion estatica, de la forma 
	// CDBSingleton::Conectar
	//*****************************************************************
	static public function Conectar()
	{
		// Datos para la conexion
		$m_sDBUser = Configuracion::$DB_USER;
		$m_sDBPass = Configuracion::$DB_PASS;
		//$m_sDBUser = 'administrador';
		//$m_sDBPass = 'hola.123';

		$m_sDBHost = Configuracion::$DB_HOST;
		$m_sDBName = Configuracion::$DB_NAME;

		// Data Source Name: String de conexion universal
		$m_sDSN = "mysql://$m_sDBUser:$m_sDBPass@$m_sDBHost/$m_sDBName";
		// Conectamos
		$dbConnection = DB::connect($m_sDSN);

		// Revisamos si es error o una conexion
		if ( PEAR::isError($dbConnection) ) 
				die( $dbConnection->getMessage()); // alterado por david

		self::$m_dbCon = $dbConnection;
	}

	//*****************************************************************
	// Descripcion: Revisa si se tuvo exito en una operacion. Debe ser 
	// llamado como funcion estatica, de la forma 
	// CDBSingleton::RevisarExito
	//*****************************************************************
	static public function RevisarExito($bSuccess, $sql)
	{
		// Revisamos exito
		if ( PEAR::isError($bSuccess) )
			throw new Exception( "<p>\n".$bSuccess->getMessage()."<br>".$sql );  //getDebugInfo() alterado por david aca2
			//return false;
		else
			return true;
	}
	
	//*****************************************************************
	// Descripcion: Obtiene el ultimo id insertado 
	// Salida: el id
	//*****************************************************************
	static public function GetUltimoId()
	{
	    // Hacemos query de ultim od
	    $sSelQuery = " SELECT LAST_INSERT_ID() AS id ";
	    $resResult = self::$m_dbCon->query($sSelQuery);
	    
	    // Revisamos y retornamos
	    if ( self::RevisarExito($resResult, $sSelQuery) )
	    {
		if ( $aRow = $resResult->fetchRow(DB_FETCHMODE_ASSOC) )
		{
		    return $aRow['id'];
		}
	    }	    
	    return -1;	    
	}
}
?>
