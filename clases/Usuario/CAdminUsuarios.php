<?php
require_once("clases/Comunes/CDBSingleton.php");
require_once("clases/Usuario/CUsuario.php");


class CAdminUsuarios {

    public static function GetUsuarioXPerfilCB($perfil)
    {
        $query="SELECT nombre, apellido_paterno, apellido_materno, idusuario
                FROM usuario WHERE cargo ='".$perfil."'";

     // $query="SELECT nombre, apellido_paterno, apellido_materno, idusuario
     // FROM usuario WHERE cargo ='".$perfil."' and estado = '".activo."'";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $a=array();
            for($i=0; $i<$exito->numRows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
               if($rs)
               {
                   $a[$i][0]=$rs['nombre']." ".$rs['apellido_paterno']." ".$rs['apellido_materno'];
                   $a[$i][1]=$rs['idusuario'];
               }
            }
            return $a;
        }
        return "";
    }

    public static function GetUsuarioXPerfilActivosCB()
    {

        $query="SELECT adulto_mayor_persona_idpersona as id FROM ".Configuracion::$BDUMOVIL_VISTA.".bdu_salud_am WHERE adulto_mayor_persona_idpersona NOT IN (select bds_katz.idam from ".Configuracion::$BDUMOVIL_VISTA.".bds_ultimo_katz as bds_katz)";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $a=array();
            for($i=0; $i<$exito->numRows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
               if($rs)
               {
                   $a[$i]=$rs['id'];
               }
            }
            return $a;
        }
        return "";
    }
    
    

   	//*****************************************************************
	// Descripcion: Obtiene un array asociativo de id -> nombre_hogar
	//*****************************************************************
	static public function GetListaTodosUsuarios()
	{
		$dbCon =& CDBSingleton::GetConn();

		$query = "SELECT * FROM usuario";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUsuarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
//                    echo $rs[idusuario];
//                    echo $rs[nombre];
                    $a[$i]=self::CrearUsuario($rs);
//                    echo "este:".$aUsuarios[1];


                    $aUsuarios[$i]=$a[$i];
             }
			 return $aUsuarios;
            }
        }
    }


    public static function GetUsuario($lugarN)
    {
        $query="select * from usuario where idusuario=".$lugarN;

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
              $a="";
              $aHogares = array();
              $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
//              echo $rs[nombre];
              $a=self::GetHogar($rs['idlugar']);
//            echo $a[direccion];
              $ax=self::CrearHogar($a);
//            echo "este:".$aHogares[1];
              $aHogares[] = $ax;
              return $aHogares;
            }
        }
    }

  
	/********************************************

     *********************************************/


	public static function CrearUsuario($row)
    {

        $usuario= new CUsuario();

		$usuario->SetIdUsuario($row['idusuario']);
		$usuario->SetNombre($row['nombre']);
		$usuario->SetApellidoPaterno($row['apellido_paterno']);
		$usuario->SetApellidoMaterno($row['apellido_materno']);
		$usuario->SetPassword($row['password_2']);
		$usuario->SetEstado($row['estado']);
		$usuario->SetRut($row['rut']);
		$usuario->SetDireccion($row['direccion']);
		$usuario->SetLogin($row['login']);
                $usuario->SetPermiso($row['permisos_idpermiso']);

		return $usuario;
	}


	/********************************************

     *********************************************/

    public static function GetUsuario2($id_usuario)
    {
        $query="select * from usuario where idusuario=".$id_usuario;
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
               $rx=$exito->fetchrow(DB_FETCHMODE_ASSOC);
               $ax=self::CrearUsuario($rx);
               return $ax;
            }
        } return '';
    }

    public static function GetBuscaUsuario($filtro, $tipo)
    {
        if ($tipo=="numero"){
            
           $query="select * from usuario where idusuario=".$filtro;
            
        }else if($tipo=="ap_paterno"){
           $query="select * from usuario where apellido_paterno LIKE '%".$filtro."%'";
         
        }else if($tipo=="nombre"){
           $query="select * from usuario where nombre LIKE '%".$filtro."%'";
        }
              
       	$conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUsuarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearUsuario($rs);

                    $aUsuarios[$i]=$a[$i];
             }
			 return $aUsuarios;
            }
        }
    }
    
   /**********************************************************************
    *
    *
    *
    **********************************************************************/

public static function GetTodosUsuarios()
    {
        $query="SELECT nombre, apellido_paterno, apellido_materno, idusuario FROM usuario";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $a=array();
            for($i=0; $i<$exito->numRows(); $i++)
            {
               $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
               if($rs)
               {
                   $a[$i][0]=$rs['nombre']." ".$rs['apellido_paterno']." ".$rs['apellido_materno'];
                   $a[$i][1]=$rs['idusuario'];
               }
            }
            return $a;
        }
        return "";
    }


    //**************************************************************************************
    // INSERTs


    static public function IngresarUsuario( &$_nRegistro)
        {
        $dbCon =& CDBSingleton::GetConn();

            $sQueryE = " INSERT INTO usuario (".
                " nombre, " .
                " apellido_paterno, " .
                " apellido_materno, " .
                " password_2, " .
                " estado, " .
                " login, " .
                " permisos_idpermiso, " .
		" cargo ".
                " ) VALUES ( " .
                "'" . $_nRegistro->GetNombre() . "',".
                "'" . $_nRegistro->GetApellidoPaterno() . "', " .
                "'" . $_nRegistro->GetApellidoMaterno() . "', " .
                "'" . $_nRegistro->GetPassword() . "', " .
                "'" . $_nRegistro->GetEstado() . "', " .
                "'" . $_nRegistro->GetLogin() . "', " .
                "'" . $_nRegistro->GetPermiso() . "'," .
		"'" . $_nRegistro->GetCargo() . "');";
            $bExito2=$dbCon->query($sQueryE);
            if(CDBSingleton::RevisarExito($bExito2, $sQueryE))
                {
                    return CDBSingleton::GetUltimoId();
                }
             else
                return -1;
        }


        public static function ModificarUsuario($us)
        {
              $query="UPDATE usuario SET ".
                "nombre= '".$us->GetNombre()."',".
                "apellido_paterno='".$us->GetApellidoPaterno()."', ".
                "apellido_materno='".$us->GetApellidoMaterno()."', ".
                "password_2='".$us->GetPassword()."', ".
                "login='".$us->GetLogin()."', ".
                "estado='".$us->GetEstado()."', ".
                "permisos_idpermiso='".$us->GetPermiso()."', ".
		"cargo='".$us->GetCargo()."' ".
                "where idusuario=".$us->GetIdUsuario();
            $con=CDBSingleton::GetConn();
            $exito=$con->query($query);

            if(CDBSingleton::RevisarExito($exito, $query))
                    return CDBSingleton::GetUltimoId();
                else
                    return -1;
       }          
       
       
     static public function GetNombreCompletoUsuario($id)
    {
        $conn=CDBSingleton::GetConn();
        $query="select apellido_paterno, apellido_materno, nombre 
                from usuario WHERE idusuario='".$id."'";
             
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return $rs['apellido_paterno']." ".$rs['apellido_materno']." ".$rs['nombre'];
         }
        return NULL;
    }
}
?>
