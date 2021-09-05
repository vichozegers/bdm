<?php
require_once("clases/Comunes/CDBSingleton.php");
require_once("clases/Usuario/CUsuario.php");


class CAdminUsuarios {

    public static function GetUsuarioXPerfilCB($perfil)
    {
        $query="SELECT nombre, apellido_paterno, apellido_materno, idusuario
                FROM usuario WHERE idusuario IN (
                    SELECT usuario_idusuario FROM `usuario_perfil`
                    WHERE perfil_idperfil IN (
                        SELECT idperfil FROM perfil WHERE nombre_perfil ='".$perfil."'".
                    ")
                )";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $a[ $exito->numrows() ];
            for($i=0; $i<$exito->numRows(); $i++)
            {
               if($rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i))
               {
                   $a[$i][0]=$rs['nombre']." ".$rs['apellido_paterno']." ".$rs['apellido_materno'];
                   $a[$i][1]=$rs['idusuario'];
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
            $a[ $exito->numrows() ];
            for($i=0; $i<$exito->numRows(); $i++)
            {
               if($rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i))
               {
                   $a[$i][0]=$rs['nombre']." ".$rs['apellido_paterno']." ".$rs['apellido_materno'];
                   $a[$i][1]=$rs['idusuario'];
               }
            }
            return $a;
        }
        return "";
    }
}
?>