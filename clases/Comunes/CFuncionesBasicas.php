<?php

//**General - "Fundacion las Rosas"*************//
//												//
// CFuncionesBasicas.php									//
// 12/11/2005 - Sebastian Echeverria					//
// Descripción: Clase encargada de contener las	//
// funciones basicas usadas por el sistema.		//
//**********************************************//

//**Estado**************************************//
// 12/11/2005 - Sebastian Echeverria - Arch Original	//
//**********************************************//

require_once('clases/Comunes/CDBSingleton.php');
	
class CFuncionesBasicas
{
	//*****************************************************************
	// Descripcion: Redirige a un URL dado.
	// Argumentos:
	//  $_sUrl: el URL.
	//*****************************************************************
	static public function Redirigir( $_sUrl )
	{
		$sPath = $_SERVER['HTTP_HOST'];
		$sDirName = dirname($_SERVER['PHP_SELF']);
		if ( $sDirName != "" )
			  $sPath .= $sDirName . "/";
		$sPath = str_replace("\\", '/', $sPath);
		$sPath = str_replace("//", '/', $sPath);
		$sFullUrl = "Location: http://" . $sPath . $_sUrl;
		header($sFullUrl);
	}
	
	//*****************************************************************
	// Descripcion: Transforma un bool a equivalente en int.
	// Argumentos:
	//  $_bBool: el bool.
	//*****************************************************************
	static public function BoolAInt($_bBool)
	{
		if ( $_bBool )
			return "1";
		else
			return "0";
	}
        
        //*****************************************************************
	// Descripción: Obtiene el maximo id del campo y de la tabla dada. 
	// Nota: El parámetro columna debe ser entero.
	//*****************************************************************
	
        static public function GetMax($columna, $tabla)
	{
	    $q_max = "SELECT MAX(".$columna.") AS id FROM ".$tabla;
            $con = CDBSingleton::GetConn();
	    $max = $con->query($q_max);
	    
	    if (CDBSingleton::RevisarExito($max, $q_max))
	    {
		if ( $row = $max->fetchRow(DB_FETCHMODE_ASSOC) )
		{
		    return $row['id'];
		}
	    }	    
	    return -1;	    
	}
        
        //*****************************************************************
	// Descripción: Obtiene el total de registros de la tabla dada. 
	// Nota: El parámetro debe ser el nombre de la tabla.
	//*****************************************************************
        
        static public function GetTotalRegistros($tabla)
	{
	    $q_tot = "SELECT COUNT(*) AS total FROM ".$tabla;
            $con = CDBSingleton::GetConn();
	    $tot = $con->query($q_tot);
	    
	    if (CDBSingleton::RevisarExito($tot, $q_tot))
	    {
		if ( $row = $tot->fetchRow(DB_FETCHMODE_ASSOC) )
		{
		    return $row['total'];
		}
	    }	    
	    return -1;	    
	}
}


?>