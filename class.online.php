<?php
require_once("header.php");
require_once("clases/CAdminSesion.php");
require_once("clases/Comunes/Configuracion.php");


class Usuariosenlinea
{
  var $e_rror;
  //Segundos para borrar de la base de datos a los usuarios inactivos
  var $segundos = 1200;  // 20 minutos
                  //180;
                  // al colocar 1 segundo borra al usuario cuando ya no esta en sesion.
                  //120;
                  //900
  var $ahora = 0;
 
    //CONSTRUCTOR
    function Usuariosenlinea() {
 
    $this->recargar();
 
    }
 
    function cuantos() {
 
    return $this->ahora;
 
    }
 
    function enlinea() {

        if($this->ahora == 1) {

    echo $this->ahora ." Usuario en linea";
        }
        else
        {
    echo $this->ahora ." Usuarios en linea";
        }
 
    }
 
        function ipreal(){
 
            if ($real_ip = getenv('HTTP_X_FORWARDED_FOR')){
 
                $explode_real_ip = explode(",", $real_ip);
                return trim($explode_real_ip[0]);
            }
            else
            {
            return getenv('REMOTE_ADDR');
            }
        }
 
        function error(){
 
        return $this->e_rror = mysql_error();
 
        }
 
        function recargar() {
 
            $tiempo_actual = time();
            $tiempo_final = $tiempo_actual - $this->segundos;
            $ip = $this->ipreal();
            $namepc=PHP_uname('n');
            $datetimeinicio=date("Y-m-d H:i:s");
            $datetimefin=date("Y-m-d H:i:s");
            $sessionid=session_id();
            $usuario=$_SESSION['logged_in'];
            $idusuario=$_SESSION['id_usuario'];

            $servidor = Configuracion::$DB_HOST;
            $usuarios = Configuracion::$DB_USER;
            $passw = Configuracion::$DB_PASS;
            $basededatos= Configuracion::$DB_NAME;

        @mysql_connect($servidor, $usuarios, $passw)
        or die('Error al Intentar Conectar con la base de datos '.$this->error().'');
 
        @mysql_select_db($basededatos)
        or die('Error Seleccionando la base de datos '.$this->error().'');
 
        $result = mysql_query("SELECT ip FROM usuarios_enlinea WHERE ip='$ip' and namepc='$namepc' and sessionid='$sessionid'")
        or die('Error de lectura en la base de datos '.$this->error().'');
 
        if(mysql_num_rows($result) == 0){
         
        mysql_query("INSERT INTO usuarios_enlinea VALUES ('$tiempo_actual','$ip','$_SERVER[REQUEST_URI]','$namepc','$datetimeinicio', '$usuario','$sessionid')")
        or die('Error al Insertar en la base de datos '.$this->error().'');

        mysql_query("INSERT INTO usuarios_historial VALUES ('$tiempo_actual','$ip','$_SERVER[REQUEST_URI]','$namepc','$datetimeinicio', '$datetimefin', '$usuario', '$idusuario','$sessionid')")
        or die('Error al Insertar en la base de datos '.$this->error().'');

        }
        else
 
        {        
        mysql_query("UPDATE usuarios_enlinea SET timestamp='$tiempo_actual' where ip='$ip' and namepc='$namepc' and sessionid='$sessionid'")
        or die('Error al Insertar en la base de datos '.$this->error().'');
        }

   // para actualizar el time salida toma el ultimo 
          $maximo = mysql_query("SELECT datetimeinicio FROM `usuarios_historial` WHERE sessionid='$sessionid' and ip='$ip'  and namepc='$namepc' and usuario_idusuario='$idusuario' order by datetimeinicio asc")
          or die('Error de lectura en la base de datos '.$this->error().'');

          // echo "SELECT datetimeinicio FROM `usuarios_historial` WHERE sessionid='$sessionid' and ip='$ip'  and namepc='$namepc' and usuario_idusuario='$idusuario' order by datetimeinicio asc";

             while($registro=mysql_fetch_array($maximo))
		{
				$data=$registro['datetimeinicio'];
		}

       if(mysql_num_rows($maximo)>0){

           mysql_query("UPDATE usuarios_historial SET timestamp='$tiempo_actual', datetimefin='$datetimefin' where datetimeinicio='$data' and ip='$ip' and namepc='$namepc' and usuario_idusuario='$idusuario' and sessionid='$sessionid'")
            or die('Error al Insertar en la base de datos '.$this->error().'');

          // echo "<br><br>UPDATE usuarios_historial SET timestamp='$tiempo_actual', datetimefin='$datetimefin' where datetimeinicio='$data' and ip='$ip' and namepc='$namepc' and usuario_idusuario='$idusuario' and sessionid='$sessionid'";

     }


   // fin time de salida

        mysql_query("DELETE FROM usuarios_enlinea WHERE timestamp < $tiempo_final")
        or die('Error al intentar borrar en la base de datos '.$this->error().'');
 
        $result = mysql_query("SELECT ip FROM usuarios_enlinea ")
        or die('Error de lectura en la base de datos '.$this->error().'');
 
        $this->ahora = mysql_num_rows($result);
 
        mysql_close();
 
        }
 
}
 
?> 
