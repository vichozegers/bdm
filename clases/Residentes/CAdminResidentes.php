<?php
require_once('DB.php');
require_once('clases/Comunes/CDBSingleton.php');
require_once('clases/Comunes/Configuracion.php');
require_once('clases/Comunes/CFuncionesBasicas.php');
require_once('clases/Localidades/CAdminLocalidades.php');
include_once('clases/Social/CPersona.php');
include_once('clases/Social/CAdminPersonas.php');
require_once('clases/Comunes/CAdminCombobox.php');
require_once('clases/Residentes/CAdminResidentes.php');
require_once('clases/Residentes/CPersonaIngFisico.php');
require_once('clases/Residentes/CAdminEventos.php');
require_once('clases/Hogar/CAdminHogar.php');


class CAdminResidentes {

    //*****************************************************************
    // Descripcion: Obtiene un array asociativo de id -> nombre_hogar
    //*****************************************************************
    static public function GetListaTodosResidentes()
    {
        $dbCon =& CDBSingleton::GetConn();

        $query = " SELECT * from residentes where locate('". mb_strtoupper($apellidoR,"UTF-8")."', apellido_paterno)>0 OR locate('".mb_strtolower($apellidoR,"UTF-8")."', apellido_paterno)>0";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
                $aResi = array();
                for($i=0; $i<$exito->numRows(); $i++)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearAdultoMayor($rs);
                    $aResi[$i]=$a[$i];
                }
                return $aResi;
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

    public static function GetResidentes($f, $v)
    {
        if(count($f)>0)
        {
            $query="";
            for($i=0; $i<count($f); $i++)
            {
                $query.=self::filtro($f[$i],$i,$v);
            }
          //  echo $query;
            $conn=CDBSingleton::GetConn();
            $exito=$conn->query($query);
            if(CDBSingleton::RevisarExito($exito, $query))
            {
                if($exito->numRows()>0)
                {
                    $aResidentes = array();
                    for($i=0; $i<$exito->numRows(); $i++)
                    {
                        $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                        $a[$i]=self::CrearAdultoMayor($rs);
                        $aResidentes[$i]=$a[$i];
                    }
                    return $aResidentes;
                }
            }
        }
    }

    //*****************************************************************
    //
    //*****************************************************************

    static public function GetPersonas($f, $v)
    {
        if(count($f)>0)
        {
            $query="";
            for($i=0; $i<count($f); $i++)
            {
                $query.=self::filtro($f, $v, $i);
            }
            echo $query;
            $conn=CDBSingleton::GetConn();
            $exito=$conn->query($query);
            $a=array();
            if(CDBSingleton::RevisarExito($exito, $query))
            {
                if($exito->numRows()>0)
                {
                    for($i=0; $i<$exito->numRows(); $i++)
                    {
                        $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                        $a[$i]=self::CrearAdultoMayor($rs);
                    }
                    return $a;
                }
            }
        }
    }
    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

    public static function GetPostulantesIngAdm($f , $v)
    {

        $query = "select * from ing_adm as R where ";
        if(strcmp($f, "nombre")==0)
        {
            $query.="(locate('".strtoupper($v)."', R.nombres)>0 or locate('".strtolower($v)."', R.nombres)>0 or locate('".ucwords($v)."', R.nombres)>0)";
        }
        else if(strcmp($f, "rut")==0)
        {
            $query.="rut='".$v."'";
        }
        else if(strcmp($f, "apellidop")==0)
        {
            $query.=" (locate('".strtoupper($v)."', R.apellido_paterno)>0 or locate('".strtolower($v)."', R.apellido_paterno)>0 or locate('".ucwords($v)."', R.apellido_paterno)>0)";
        }
        else
        {
            $query.="(locate('".strtoupper($v)."', R.apellido_materno)>0 or locate('".strtolower($v)."', R.apellido_materno)>0 or locate('".ucwords($v)."', R.apellido_materno)>0)";
        }
  //      echo $query;
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
                $aResidentes = array();
                for($i=0; $i<$exito->numRows(); $i++)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearAdultoMayor($rs);
                    $aResidentes[$i]=$a[$i];
                }
                return $aResidentes;
            }
        }
    }

    /***************************************************************************
     *
     *
     *
     *
     ***************************************************************************/

     private static function filtro($filtro, $i, $value) {
        switch($i) {
            case 0: return self::FiltroPrincipal($filtro, $value);break;
            case 1: return self::XCategoria($filtro, $value);break;
        }
    }

    private static function XCategoria($filtro, $value) {
        switch($filtro) {
            // agrego categoria residente hogar de cristo.
            // case "residente_hogar_cristo": return " and R.categoria='residente' and origen_inicial_idorigen_inicial=2"; break;
            case "residente": return " and R.categoria='residente'"; break;
            case "egresado": return " and R.categoria='egresado'"; break;
            case "fallecido": return " and R.categoria='fallecido'"; break;
            default: return "";
        }
    }

    private static function FiltroPrincipal($filtro, $value) {
        switch($filtro) {
            case "nombre":  return "select R.* from residentes as R where (locate('".strtoupper($value)."', R.nombres)>0 or locate('".strtolower($value)."', R.nombres)>0 or locate('".ucwords($value)."', R.nombres)>0)";break;
            case "rut": return "select R.* from residentes as R where (locate('".strtoupper($value)."', R.rut)>0 or locate('".strtolower($value)."', R.rut)>0 or locate('".ucwords($value)."', R.rut)>0)";break;
            case "apellidop": return "select R.* from residentes as R where (locate('".strtoupper($value)."', R.apellido_paterno)>0 or locate('".strtolower($value)."', R.apellido_paterno)>0 or locate('".ucwords($value)."', R.apellido_paterno)>0)";break;
            case "apellidom": return "select R.* from residentes as R where (locate('".strtoupper($value)."', R.apellido_materno)>0 or locate('".strtolower($value)."', R.apellido_materno)>0 or locate('".ucwords($value)."', R.apellido_materno)>0)";break;
            
            default: return "select R.* from residentes as R where 1";
        }
    }

    /***************************************************************************
     *
     *
     *
     *
     ***************************************************************************/
    public static function GetNumResidentes()
    {
       $query="select count(*) as num from residentes where categoria='residente'";
       // asi estaba
      //  $query="select count(*) as num from residentes where categoria='residente'
      //          and comuna_idcomuna is not null";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }


    /*** agregado **/

    public static function GetNumResidentesMetropolitana()
    {
        $query="select count(*) as num from residentes, comuna
                where residentes.categoria='residente'
                and residentes.comuna_idcomuna=comuna.idcomuna
                and comuna.region_idregion=7";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }

    /*** agregado**/
    public static function GetNumResidentesRegiones()
    {
        $query="select count(*) as num from residentes, comuna,region
                where residentes.categoria='residente'
                and residentes.comuna_idcomuna=comuna.idcomuna
                and comuna.region_idregion=region.idregion
                and comuna.region_idregion<>7";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }




    public static function GetNumResidentesNull()
    {
        $query="SELECT count( *  ) AS num
        FROM residentes
        WHERE residentes.categoria = 'residente'
        AND residentes.comuna_idcomuna IS NULL ";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }


    public static function GetNumResidentesNULLRegiones()
    {
        $query="SELECT count(residentes.hogar_lugar_idlugar)as num
                FROM residentes, hogar, comuna
                WHERE IsNull(residentes.comuna_idcomuna)
                and residentes.categoria='residente'
                and residentes.hogar_lugar_idlugar=hogar.lugar_idlugar
                and hogar.comuna_idcomuna=comuna.idcomuna
                and comuna.region_idregion<>7";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }


     public static function GetNumResidentesNULLMetropolitana()
    {
        $query="SELECT count(residentes.hogar_lugar_idlugar)as num
                FROM residentes, hogar, comuna
                WHERE IsNull(residentes.comuna_idcomuna)
                and residentes.categoria='residente'
                and residentes.hogar_lugar_idlugar=hogar.lugar_idlugar
                and hogar.comuna_idcomuna=comuna.idcomuna
                and comuna.region_idregion=7";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }


    public static function GetNumResidentesXHogar($id_hogar)
    {
        $query="select count(*) as num from residentes where categoria='residente' and hogar_lugar_idlugar=".$id_hogar;
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }

    public static function GetNumResidentesXHogarMasculino($id_hogar)
    {
        $query="select count(*) as num from residentes where categoria='residente' and sexo=1 and hogar_lugar_idlugar=".$id_hogar;
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }
    
    
    public static function GetNumResidentesXHogarFemenino($id_hogar)
    {
        $query="select count(*) as num from residentes where categoria='residente' and sexo=0 and hogar_lugar_idlugar=".$id_hogar;
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }
    
    
   static public function CrearAdultoMayor($Row) {
        $AM=new CPersona();
        $AM->SetId($Row['persona_idpersona']);
        $AM->SetRut($Row['rut']);
        $AM->SetNombre(utf8_encode(strtoupper($Row['nombres'])));
        // cuando buscamos por Ñ en algun tipo de buscador colocamos encode
        $AM->SetApellidoPaterno(utf8_encode(strtoupper($Row['apellido_paterno'])));
        $AM->SetApellidoMaterno(utf8_encode(strtoupper($Row['apellido_materno'])));
        $AM->SetSexo($Row['sexo']); //transformar a masculino femenino
        $AM->SetFechaNacimiento($Row['fecha_nacimiento']);
        $AM->SetDomicilio(utf8_encode($Row['direccion'])); //agregar comuna y region
        $AM->SetTelefono($Row['telefono']);
        $AM->SetEstadoCivil(CAdminPersonas::GetEstadoCivilNombre($Row['estado_civil_idestado_civil']));
        $AM->SetCategoria($Row['categoria']);
        $AM->SetFechaDeseso($Row['fecha_deseso']);
        $AM->SetComuna(CAdminLocalidades::GetComunaNombre($Row['comuna_idcomuna'])); //obtener nombre comuna
        $AM->SetRegion(CAdminLocalidades::GetRegionNombre($Row['comuna_idcomuna']));

        $AM->SetProfesion(CAdminCombobox::GetProfesionNombre($Row['profesion_idprofesion']));//obtener nombre profesion
        $AM->SetSistemaSalud(CAdminCombobox::GetSistemaSaludNombre($Row['sistema_salud_idsistema_salud']));//obtener nombre sistema de salud
        $AM->SetHogar($Row['hogar_lugar_idlugar']);//obtener hogar
        $AM->SetAux(CAdminHogar::GetNumeroHogar($Row['hogar_lugar_idlugar']));
        
        // Para saber tipo de origen por la incorporacion de adulto mayor desde hogar de cristo
        $AM->SetColorIdentificador(CAdminPersonas::GetColorOrigenInicial($Row['origen_inicial_idorigen_inicial'])); 
        $AM->SetOrigenInicial(CAdminPersonas::GetOrigenInicial($Row['origen_inicial_idorigen_inicial'])); 
       
        //$AM->SetUsuario($Row['usuario_idusuario']);//obtener usuario

        return $AM;
    }


     public static function ExisteAMApadrina($nombre, $apellido1, $apellido2) {
        $query1="select nombre from ".Configuracion::$BD_apadrina.".adultomayor_apadrina where nombre='".$nombre." ".$apellido1." ".$apellido2."'";
        $con=&CDBSingleton::GetConn();

        $exito1=$con->query($query1);
        if(CDBSingleton::RevisarExito($exito1, $query1) ) {
            if($exito1->numrows()>0) {
                return 1; //existe
            }
            return 0; // no existe
        }
    }

    public static function EgresoAMApadrina($nombre, $apellido1, $apellido2, $tipo) {

        $query1="update ".Configuracion::$BD_apadrina.".adultomayor_apadrina set nhogar= NULL, aux = '".$tipo."' where nombre='".$nombre." ".$apellido1." ".$apellido2."'";
        $con=&CDBSingleton::GetConn();

        $exito1=$con->query($query1);
        if(CDBSingleton::RevisarExito($exito1, $query1) )
                return CDBSingleton::GetUltimoId();
        else
               return -1;

    }

     public static function TrasladoAMApadrina($nombre, $apellido1, $apellido2, $hogar) {

        $query1="update ".Configuracion::$BD_apadrina.".adultomayor_apadrina set nhogar = '".$hogar."' where nombre='".$nombre." ".$apellido1." ".$apellido2."'";
        $con=&CDBSingleton::GetConn();

        $exito1=$con->query($query1);
        if(CDBSingleton::RevisarExito($exito1, $query1) )
                return CDBSingleton::GetUltimoId();
        else
               return -1;

    }


    public static function GetIdSistemasSalud()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select idsistema_salud from sistema_salud";
        $bExito = $dbCon->query($sQuery);
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            $a=array();
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=$rs['idsistema_salud'];
                }
            }
            return $a;
        }
        return "";
    }

    public static function GetIdPrevision()
    {
        $dbCon = CDBSingleton::GetConn();
        $sQuery = "select idprevision_prevision from prevision_prevision";
        $bExito = $dbCon->query($sQuery);
        if(CDBSingleton::RevisarExito($bExito, $sQuery))
        {
            $a=array();
            for($i=0; $i<$bExito->numrows();$i++)
            {
                $rs=$bExito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                if($rs)
                {
                    $a[$i]=$rs['idprevision_prevision'];
                }
            }
            return $a;
        }
        return "";
    }


    static public function GetDocumentoIngresoFisico($id_am,$categoria) {
        if(isset($id_am)) {
            
            if ($categoria=='residente'){ 
                $query="select * from adulto_mayor where persona_idpersona=".$id_am." 
                        and categoria='residente'";
            }else if ($categoria=='fallecido'){
                $query="select * from adulto_mayor where persona_idpersona=".$id_am."
                        and categoria='fallecido'";
            }else if ($categoria=='egresado'){
                $query="select * from adulto_mayor where persona_idpersona=".$id_am."
                        and categoria='egresado'";
            }
            
            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($query);
            if(CDBSingleton::RevisarExito($rs, $query)) {
                $aRow=$rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($aRow) {
                    
                    $id_apoderado=self::GetIdApoderadoProcesoPostulacion($aRow['persona_idpersona']);
                   
                    if ($id_apoderado!=null)
                       { 
                           return self::CrearAdultoMayorIngresoFisico($aRow, $id_apoderado);
                       }else{
                           $id_apoderado=""; // seteo a vacio cuando id_apoderado es = a null  
                           return self::CrearAdultoMayorIngresoFisico($aRow, $id_apoderado);
                       } 
                   
                } 
            }
            return new CPersonaIngFisico();
         }
          else
            return new CPersonaIngFisico();
     }
     
     
    static public function GetIdApoderadoProcesoPostulacion($id_am)
    {
        # Se quita el filtro de la consulta por el estado; solo necesitamos el último proceso de postulación.
        
        /* $query="SELECT personas_otras_persona_idpersona FROM `proceso_postulacion` 
                WHERE `adulto_mayor_persona_idpersona`=".$id_am." and
                estado='No Activo' order by fecha_proceso_postulacion desc LIMIT 1"; */
        
        $query="SELECT personas_otras_persona_idpersona FROM `proceso_postulacion` 
                WHERE `adulto_mayor_persona_idpersona`=".$id_am." 
                ORDER BY fecha_proceso_postulacion DESC LIMIT 1";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
            {
                if($exito->numrows()>0)
                {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                    return $rs['personas_otras_persona_idpersona'];
                }
            }
        
        return false;
    }
    
    
     static public function CrearAdultoMayorIngresoFisico($Row,$id_apoderado) {
       
        $AM_IF=new CPersonaIngFisico();
        $AM_IF->SetId($Row['persona_idpersona']);
        $AM_IF->SetRut($Row['rut']);
        $AM_IF->SetNombre(utf8_encode(strtoupper($Row['nombres'])));
        // cuando buscamos por Ñ en algun tipo de buscador colocamos encode
        $AM_IF->SetApellidoPaterno(utf8_encode(strtoupper($Row['apellido_paterno'])));
        $AM_IF->SetApellidoMaterno(utf8_encode(strtoupper($Row['apellido_materno'])));
        $AM_IF->SetDomicilio(utf8_encode($Row['direccion'])); //agregar comuna y region
        $AM_IF->SetCategoria($Row['categoria']);
        $AM_IF->SetFechaDeseso($Row['fecha_deseso']);
        $AM_IF->SetComuna(CAdminLocalidades::GetComunaNombre($Row['comuna_idcomuna'])); //obtener nombre comuna
        $AM_IF->SetRegion(CAdminLocalidades::GetRegionNombre($Row['comuna_idcomuna']));
        $AM_IF->SetHogar($Row['hogar_lugar_idlugar']);//obtener hogar
        $AM_IF->SetAux(CAdminHogar::GetNumeroHogar($Row['hogar_lugar_idlugar']));
        $AM_IF->SetHogarNombre(CAdminHogar::GetHogarNombre($Row['hogar_lugar_idlugar'])); 
        $AM_IF->SetHogarDireccion(CAdminHogar::GetHogarDireccion($Row['hogar_lugar_idlugar']));
        $AM_IF->SetFechaIngresoFisico(CAdminEventos::GetUltimaFichaIngreso($Row['persona_idpersona']));
            if ($id_apoderado!=""){
                $AM_IF->SetIdApoderado($id_apoderado);
            }
        
        return $AM_IF;
    }
    
    
    
    static public function GetObtengoMes($mes)
    {
       if ($mes=='01' or $mes=='1') return $mes='Enero';  
       if ($mes=='02' or $mes=='2') return $mes='Febrero';  
       if ($mes=='03' or $mes=='3') return $mes='Marzo';   
       if ($mes=='04' or $mes=='4') return $mes='Abril';  
       if ($mes=='05' or $mes=='5') return $mes='Mayo';  
       if ($mes=='06' or $mes=='6') return $mes='Junio';
       if ($mes=='07' or $mes=='7') return $mes='Julio';  
       if ($mes=='08' or $mes=='8') return $mes='Agosto';  
       if ($mes=='09' or $mes=='9') return $mes='Septiembre';  
       if ($mes=='10') return $mes='Octubre';  
       if ($mes=='11') return $mes='Noviembre'; 
       if ($mes=='12') return $mes='Diciembre';
    }
    
    // Se agrega Residentes femeninos con apoderado y sin apoderado
    
    public static function GetNumResConApoderadoMujer()
    {
        $query="select count(a.persona_idpersona) as cantidad
                from adulto_mayor as a
                where (persona_idpersona IN 
                      ( SELECT adulto_mayor_persona_idpersona 
                        FROM relaciones_personas 
                        WHERE tipo_relaciones_personas_idtipo_relaciones_personas=1))
                        and categoria='residente' and sexo=0";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if (CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['cantidad'];
        }       
    }
    
    public static function GetNumResSinApoderadoMujer()
    {
        $query="select count(a.persona_idpersona) as cantidad 
                from adulto_mayor as a
                where (persona_idpersona  
                NOT IN( SELECT adulto_mayor_persona_idpersona 
                        FROM relaciones_personas 
                        WHERE tipo_relaciones_personas_idtipo_relaciones_personas=1))
                and categoria='residente' and sexo=0";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if (CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['cantidad'];
        }       
    }
    
    //******************************************************************************************//
    // Se agrega Residentes masculinos con apoderado y sin apoderado
    
    public static function GetNumResConApoderadoHombre()
    {
        $query="select count(a.persona_idpersona) as cantidad
                from adulto_mayor as a 
                where (persona_idpersona IN 
                       ( SELECT adulto_mayor_persona_idpersona 
                         FROM relaciones_personas 
                         WHERE tipo_relaciones_personas_idtipo_relaciones_personas =1))
                         and categoria='residente' and sexo=1";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if (CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['cantidad'];
        }        
    }
    
    public static function GetNumResSinApoderadoHombre()
    {
        $query="select count(a.persona_idpersona) as cantidad 
                from adulto_mayor as a
                where (persona_idpersona  
                NOT IN( SELECT adulto_mayor_persona_idpersona 
                        FROM relaciones_personas 
                        WHERE tipo_relaciones_personas_idtipo_relaciones_personas=1))
                        and categoria='residente' and sexo=1";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if (CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['cantidad'];
        }        
    }
    
    
    public static function GetNumResidentesComunidad()
    {
        $query="SELECT count(persona_idpersona) AS num
                FROM residentes
                WHERE categoria = 'residente'
                AND (origen_inicial_idorigen_inicial is NULL or origen_inicial_idorigen_inicial=1)";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['num'];
        }
    }
    
    public static function GetNumResidentesHogarCristo()
    {
        $query="select count(persona_idpersona) as num 
                from residentes
                where categoria='residente'
                and origen_inicial_idorigen_inicial=2";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
           $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
           return $rs['num'];
        }      
    }
    
    
    static public function GetPersonasApell($apellido)
    {
     
            
            $query="select * from adulto_mayor where locate('". mb_strtoupper($apellido,"UTF-8")."', apellido_paterno)>0 OR locate('".mb_strtolower($apellido,"UTF-8")."', apellido_paterno)>0";
            
            $conn=CDBSingleton::GetConn();
            $exito=$conn->query($query);
            $a=array();
            if(CDBSingleton::RevisarExito($exito, $query))
            {
                if($exito->numRows()>0)
                {
                    for($i=0; $i<$exito->numRows(); $i++)
                    {
                        $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                        $a[$i]=self::CrearAdultoMayor($rs);
                    }
                    return $a;
                }
            }
        
    }
    
    
    
    
    
    
    
     
    
}
?>