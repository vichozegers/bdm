<?php
require_once('header.php');
require_once("clases/Comunes/CDBSingleton.php");
require_once('clases/utilitarios/CAdminUtilitarios.php');
require_once('clases/utilitarios/CUtilitarios.php');
require_once('clases/utilitarios/CUtilitariosIndicador.php');
require_once('clases/Localidades/CAdminLocalidades.php');


class CAdminUtilitarios
{

   static public function GetListaResidentescomunaNull()
   {
       $query = "SELECT COUNT( residentes.hogar_lugar_idlugar ) AS cantidad_sin_comuna, 
                 hogar.nombre as nombre,
                 hogar.numero_hogar as NUM_HOGAR,
                 hogar.lugar_idlugar as ID_HOGAR
                 FROM residentes, hogar
                 WHERE isNull( residentes.comuna_idcomuna )
                 AND residentes.categoria = 'residente'
                 AND hogar.activo=1
                 AND residentes.hogar_lugar_idlugar = hogar.lugar_idlugar
                 GROUP BY residentes.hogar_lugar_idlugar";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearUtilitarios($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }


    public static function CrearUtilitarios($row)
    {

        $utilitarios= new CUtilitarios();
        $utilitarios->SetCamponum1($row['cantidad_sin_comuna']);
        $utilitarios->SetCamponumid($row['ID_HOGAR']);
        $utilitarios->SetCamponum3($row['NUM_HOGAR']);
        $utilitarios->SetCampovar1($row['nombre']);

        return $utilitarios;
    }

///////////////////////////////////////////////////////////////////////////


    static public function GetListaCategoriaAdulto()
   {
        $query = "SELECT count( adulto_mayor.categoria) AS cantidad, categoria
                  FROM adulto_mayor
                  group by categoria";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearUtilitarios2($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }   

    /*  SELECT count( adulto_mayor.categoria) AS cantidad, categoria
        FROM adulto_mayor
        where categoria='solicitante' or categoria='postulante'
        group by categoria */


    public static function CrearUtilitarios2($row)
    {

        $utilitarios2= new CUtilitarios();
        $utilitarios2->SetCamponum1($row['cantidad']);
        $utilitarios2->SetCampovar1($row['categoria']);
        return $utilitarios2;
    }

///////////////////////////////////////////////////////////////////////////



    static public function GetListaResidentescomunaNullxHogar($id_hogar)
   {
        $query = "SELECT residentes.rut, residentes.nombres, residentes.apellido_paterno, residentes.apellido_materno
                  FROM residentes, hogar
                  WHERE ISNULL( residentes.comuna_idcomuna )
                  AND residentes.categoria = 'residente'
                  AND hogar.activo =1
                  AND residentes.hogar_lugar_idlugar = hogar.lugar_idlugar
                  AND hogar.lugar_idlugar = ".$id_hogar."
                  ORDER BY apellido_paterno";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearUtilitarios3($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }

    public static function CrearUtilitarios3($row)
    {

        $utilitarios3= new CUtilitarios();
        $utilitarios3->SetCampovar1($row['rut']);
        $utilitarios3->SetCampovar2(utf8_encode($row['nombres']));
        $utilitarios3->SetCampovar3(utf8_encode($row['apellido_paterno']));
        $utilitarios3->SetCampovar4(utf8_encode($row['apellido_materno']));

        return $utilitarios3;
    }


   static public function GetListaAdultoMayorxSexoxCategoria()
   {
        $query = "SELECT count(persona_idpersona)as cantidad, sexo, categoria, fecha_deseso FROM `adulto_mayor`
                  group by categoria, sexo, fecha_deseso";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {                                
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearUtilitarios4($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }

    public static function CrearUtilitarios4($row)
    {

        $utilitarios4= new CUtilitarios();
        $utilitarios4->SetCamponum1($row['cantidad']);
        $utilitarios4->SetCamponum2($row['sexo']);
        $utilitarios4->SetCampovar1($row['categoria']);
        $utilitarios4->SetCampovar2($row['fecha_deseso']);

        return $utilitarios4;
    }


 ////*************************************POSTULANTE****************************
/// Los postulantes segun el documento corresponden a los solicitantes

   
   static public function GetPostulanteEspontaneo($annos,$m)
   {
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='solicitante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        and derivacion_idderivacion=1
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
          }
    }


   static public function GetPostulantePersonal($annos,$m)
   {
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='solicitante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        and derivacion_idderivacion=2
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
          }
    }


 static public function GetPostulanteInstituciones($annos,$m)
   {
	$query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='solicitante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        and (derivacion_idderivacion=5  or derivacion_idderivacion=4  or derivacion_idderivacion=3)
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
         }
    }


   static public function GetPostulanteTotal($annos,$m)
   {    
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='solicitante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

    static public function GetPostulanteConApoderado($annos,$m)
    {   
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='solicitante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null and personas_otras_persona_idpersona is not null
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }
  
    static public function GetPostulanteSinApoderado($annos,$m)
    {   
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='solicitante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null and personas_otras_persona_idpersona is null
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetPostulantePromedioEdadMujeres($annos,$m)
    {  

        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where categoria='solicitante' and estado='activo'
        and sexo=0 and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetPostulantePromedioEdadHombres($annos,$m)
    {

        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where categoria='solicitante' and estado='activo'
        and sexo=1 and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetPostulantePromedioGeneralEdad($annos,$m)
    {  
        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where categoria='solicitante' and estado='activo'
        and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }



   public static function CrearPostulante($row)
    {

        $utilitarios6= new CUtilitariosIndicador();
        $utilitarios6->SetCamponum1($row['total']);
        $utilitarios6->SetCamponum2($row['mes']);
        $utilitarios6->SetCamponum3($row['derivacion_idderivacion']);
        $utilitarios6->SetCamponum4($row['sexo']);


        return $utilitarios6;
    }


////*************************************EVALUADOS*********************************************************
 // segun el documento corresponden a los postulantes
    
   static public function GetEvaluadosPersonal_($annos,$m)
   {
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        and derivacion_idderivacion=2 group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
          }
    }


    static public function GetEvaluadosPersonal($annos,$m)
   {
        /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE
        (((categoria='postulante' or categoria='desistido' or categoria='residente' or categoria='fallecido') and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01'))
        and derivacion_idderivacion=2)      
        ";
        */

        $query = "select count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_social
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                   and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   and derivacion_idderivacion=2 GROUP BY vista_proceso_solicitud_adulto.idproceso_postulacion is not NULL";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
                    return $aUtilitarios;

          }
    }
    
    static public function GetEvaluadosInstituciones_($annos,$m)
   {   
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        and (derivacion_idderivacion=3 or derivacion_idderivacion=4 or derivacion_idderivacion=5)
        group by  mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

    static public function GetEvaluadosInstituciones($annos,$m)
   {
        /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE (((categoria='postulante' or categoria='desistido' or categoria='residente' or categoria='fallecido') and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01'))
        and (derivacion_idderivacion=3 or derivacion_idderivacion=4 or derivacion_idderivacion=5))
        ";
*/
        $query = "select count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_social
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                   and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   and (derivacion_idderivacion=3 or derivacion_idderivacion=4 or derivacion_idderivacion=5)
                     GROUP BY vista_proceso_solicitud_adulto.idproceso_postulacion is not NULL";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }


   static public function GetEvaluadosEspontaneo_($annos,$m)
   {
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        and derivacion_idderivacion=1 group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
          }
    }

     static public function GetEvaluadosEspontaneo($annos,$m)
   {
         /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE (((categoria='postulante' or categoria='desistido' or categoria='residente' or categoria='fallecido') and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01'))
        and derivacion_idderivacion=1)
         ";
*/

         $query = "select count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_social
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                   and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   and derivacion_idderivacion=1
                     GROUP BY vista_proceso_solicitud_adulto.idproceso_postulacion is not NULL";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
          }
    }


    static public function GetEvaluadosTotal_($annos,$m)
   {

        
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null
        group by mes order by mes";
         

       

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

     static public function GetEvaluadosTotal($annos,$m)
   {/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE (categoria='postulante' or categoria='desistido' or categoria='residente' or categoria='fallecido') and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
         group by mes order by mes";
      */
         $query = "select count(DISTINCT vista.adulto_mayor_persona_idpersona) as total, 
         month(evaluacion_social.fecha_realizacion) as mes
         FROM vista_proceso_solicitud_adulto as vista INNER JOIN evaluacion_social ON
          vista.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
          where evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
          GROUP BY vista.idproceso_postulacion is not NULL";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }
 

     static public function GetEvaluadosTotalDetalle($annos,$m)
   {/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE (categoria='postulante' or categoria='desistido' or categoria='residente' or categoria='fallecido') and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
         group by mes order by mes";
    
         $query = "select count(DISTINCT vista.adulto_mayor_persona_idpersona) as total, 
         month(evaluacion_social.fecha_realizacion) as mes
 
     */
         $query = "select * FROM vista_proceso_solicitud_adulto as vista INNER JOIN evaluacion_social ON
          vista.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
          WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
          GROUP BY vista.idproceso_postulacion is not NULL";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }
 

    static public function GetEvaluadoPromedioEdadMujeres_($annos,$m)
    {
        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where categoria='postulante' and estado='activo'
        and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=0
        group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

     static public function GetEvaluadoPromedioEdadMujeres($annos,$m)
    {
         /*
        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where (categoria='postulante' or categoria='desistido' or categoria='fallecido' or categoria='residente')
        and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=0
        group by mes order by mes asc ";

        */

         $query="SELECT format(sum(vista_proceso_solicitud_adulto.edad)/count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona),1) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                where (categoria='postulante' or categoria='desistido' or categoria='fallecido' or categoria='residente')
                and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=0
                group by mes order by mes asc ";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetEvaluadoPromedioEdadHombres_($annos,$m)
    {
        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where categoria='postulante' and estado='activo'
        and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=1
        group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

     static public function GetEvaluadoPromedioEdadHombres($annos,$m)
    {
         /*
        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where (categoria='postulante'  or categoria='desistido' or categoria='fallecido' or categoria='residente')
        and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=1
        group by mes order by mes asc ";

*/
         $query="SELECT format(sum(vista_proceso_solicitud_adulto.edad)/count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona),1) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                where (categoria='postulante' or categoria='desistido' or categoria='fallecido' or categoria='residente')
                and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=1
                group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetEvaluadoPromedioGeneralEdad($annos,$m)
    {
        /*
        $query="SELECT format(sum(edad)/count(idproceso_postulacion),1) as total, month(fecha_proceso_postulacion) as mes
        FROM vista_proceso_solicitud_adulto
        where (categoria='postulante'  or categoria='desistido' or categoria='fallecido' or categoria='residente')
        and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes asc ";

*/

        $query="SELECT format(sum(vista_proceso_solicitud_adulto.edad)/count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona),1) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                where (categoria='postulante' or categoria='desistido' or categoria='fallecido' or categoria='residente')
                and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


  
   static public function GetEvaluadosSinIngresos($annos,$m)
   {    /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null and monto_total_ingresos=0
        group by mes order by mes";

*/
        $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.monto_total_ingresos = 0
                group by mes order by mes";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

   static public function GetEvaluadosPensionBasica($annos, $m)
   {
        $pensionBasica= Configuracion::$Pension_basica;

        /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and fecha_deseso is null and estado='activo' and monto_total_ingresos>0 and monto_total_ingresos<=$pensionBasica
        group by mes order by mes";

*/
        $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.monto_total_ingresos>0 and vista_proceso_solicitud_adulto.monto_total_ingresos<=$pensionBasica
                group by mes order by mes";



        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }


    static public function GetEvaluadosSuperiorPensionBasica($annos,$m)
   {
        $pensionBasica= Configuracion::$Pension_basica;
        $pensionMedia= Configuracion::$Pension_media;

        /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and fecha_deseso is null and estado='activo' and monto_total_ingresos>$pensionBasica and monto_total_ingresos<=$pensionMedia
        group by mes order by mes";
         * */


         $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.monto_total_ingresos > $pensionBasica
                and vista_proceso_solicitud_adulto.monto_total_ingresos<=$pensionMedia
                group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

  
    static public function GetEvaluadosIngresoHastaMaximo($annos,$m)
   {
        $pensionMedia= Configuracion::$Pension_media;
        $pensionSuperior = Configuracion::$Pension_superior;
/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and fecha_deseso is null and estado='activo' and monto_total_ingresos>$pensionMedia and monto_total_ingresos<=$pensionSuperior
        group by mes order by mes";
*/

        $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.monto_total_ingresos > $pensionMedia
                and vista_proceso_solicitud_adulto.monto_total_ingresos<=$pensionSuperior
                group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }


      static public function GetEvaluadosIngresoSuperiorMaximo($annos,$m)
   {
        $pensionSuperior = Configuracion::$Pension_superior;
/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and fecha_deseso is null and estado='activo' and monto_total_ingresos>$pensionSuperior
        group by mes order by mes";
*/

        $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.monto_total_ingresos > $pensionSuperior
                group by mes order by mes";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }


    static public function GetEvaluadosSinApoderado($annos,$m)
    {
        /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null and personas_otras_persona_idpersona is null
        group by mes order by mes";
*/
        $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.personas_otras_persona_idpersona is null
                group by mes order by mes";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetEvaluadosConApoderado($annos,$m)
    {
        /*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and estado='activo' and fecha_deseso is null and personas_otras_persona_idpersona is not null
        group by mes order by mes";
*/

        $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, month(evaluacion_social.fecha_realizacion) as mes
                FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                WHERE evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and vista_proceso_solicitud_adulto.personas_otras_persona_idpersona is not null
                group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


     static public function GetEvaluadosAutovalentes($annos, $m)
     {
/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`, consulta_salud
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
        and estado='activo' and fecha_deseso is null
        and (katz='A' or katz='B')
        group by mes order by mes";
*/

         $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)  as total, month(evaluacion_social.fecha_realizacion) as mes
                    FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                    vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                    INNER JOIN consulta_salud ON
                    consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                    WHERE  evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                    and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                    and (consulta_salud.katz='A' or consulta_salud.katz='B')
                    group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

   static public function GetEvaluadosSemivalentes($annos, $m)
     {
/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`, consulta_salud
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
        and estado='activo' and fecha_deseso is null
        and (katz='C' or katz='D')
        group by mes order by mes";
*/

       $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)  as total, month(evaluacion_social.fecha_realizacion) as mes
                    FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                    vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                    INNER JOIN consulta_salud ON
                    consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                    WHERE  evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                    and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                    and (consulta_salud.katz='C' or consulta_salud.katz='D')
                    group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

   static public function GetEvaluadosNovalentes($annos, $m)
     {
/*
        $query = "SELECT count(idproceso_postulacion) as total, month(fecha_proceso_postulacion) as mes
        FROM `vista_proceso_solicitud_adulto`, consulta_salud
        WHERE categoria='postulante' and fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
        and estado='activo' and fecha_deseso is null
        and (katz='E' or katz='F' or katz='G' or katz='H' or katz='X')
        group by mes order by mes";
*/

       $query = "SELECT count(DISTINCT vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)  as total, month(evaluacion_social.fecha_realizacion) as mes
                    FROM vista_proceso_solicitud_adulto INNER JOIN evaluacion_social ON
                    vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                    INNER JOIN consulta_salud ON
                    consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                    WHERE  evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                    and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                    and (consulta_salud.katz='E' or consulta_salud.katz='F' or consulta_salud.katz='G'  or consulta_salud.katz='H' or consulta_salud.katz='X')
                    group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluados($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }




     public static function CrearEvaluados($row)
    {

        $utilitarios= new CUtilitariosIndicador();
        $utilitarios->SetCamponum1($row['total']);
        $utilitarios->SetCamponum2($row['mes']);
        $utilitarios->SetCamponum3($row['derivacion_idderivacion']);
        $utilitarios->SetCamponum4($row['sexo']);


        return $utilitarios;
    }



///*****************************+Evaluacion Medica***********************************************///

     static public function GetEvaluacionMedicaTotal($annos,$m)
    {
         $query = "select count(idevaluacion_medica)as total, month(evaluacion_medica.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_medica
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_medica.proceso_postulacion_idproceso_postulacion
                   and evaluacion_medica.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluacionMedica($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


     static public function GetEvaluacionMedicaHombre($annos,$m)
    {

        $query = "select count(idevaluacion_medica)as total, month(evaluacion_medica.fecha_realizacion)as mes
                  from vista_proceso_solicitud_adulto, evaluacion_medica
                  where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_medica.proceso_postulacion_idproceso_postulacion
                  and evaluacion_medica.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                  and sexo=1
                  group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluacionMedica($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

     

     static public function GetEvaluacionMedicaMujer($annos,$m)
    {
        $query = "select count(idevaluacion_medica)as total, month(evaluacion_medica.fecha_realizacion)as mes
                  from vista_proceso_solicitud_adulto, evaluacion_medica
                  where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_medica.proceso_postulacion_idproceso_postulacion
                  and evaluacion_medica.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                  and sexo=0
                  group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluacionMedica($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }



     public static function CrearEvaluacionMedica($row)
    {

        $utilitariosE= new CUtilitariosIndicador();
        $utilitariosE->SetCamponum1($row['total']);
        $utilitariosE->SetCamponum2($row['mes']);

        return $utilitariosE;
    }




 ///****************Evaluacion Social***********************************************///

     static public function GetEvaluacionSocialTotal($annos,$m)
    {
        $query = "select count(idevaluacion_social)as total, month(evaluacion_social.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_social
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                   and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluacionSocial($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

     static public function GetEvaluacionSocialHombre($annos,$m)
    {

        $query = "select count(idevaluacion_social)as total, month(evaluacion_social.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_social
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                   and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   and sexo=1
                   group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluacionSocial($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetEvaluacionSocialMujer($annos,$m)
    {

        $query = "select count(idevaluacion_social)as total, month(evaluacion_social.fecha_realizacion)as mes from vista_proceso_solicitud_adulto, evaluacion_social
                   where vista_proceso_solicitud_adulto.idproceso_postulacion=evaluacion_social.proceso_postulacion_idproceso_postulacion
                   and evaluacion_social.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                   and sexo=0
                   group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearEvaluacionSocial($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }



     public static function CrearEvaluacionSocial($row)
    {

        $utilitarioSoc= new CUtilitariosIndicador();
        $utilitarioSoc->SetCamponum1($row['total']);
        $utilitarioSoc->SetCamponum2($row['mes']);

        return $utilitarioSoc;
    }


 ////**********************************************************************************************//





 ////*************************************INGRESADOS****************************
/// corresponden a los residentes
    
    static public function GetIngresoEspontaneo($annos,$m)
   {    
      
       //$query ="select count(DISTINCT(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)) as total, 
       
       $query ="select count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, 
                month(eventos.fecha_realizacion)as mes 
                from vista_proceso_solicitud_adulto, eventos
                where eventos.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                and vista_proceso_solicitud_adulto.estado='Finalizado'
                and tipo='ingreso'
                and eventos.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and derivacion_idderivacion=1 GROUP BY mes, vista_proceso_solicitud_adulto.idproceso_postulacion is not NULL";
        
        
        /* orig
	$query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
              and derivacion_idderivacion=1
        group by mes";
        */
    
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
            
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
         }
        	 return $aUtilitarios;
    }

   static public function GetIngresoInstituciones($annos,$m)
   {   
      //$query="select count(DISTINCT(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)) as total, 
      
        $query="select count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, 
                month(eventos.fecha_realizacion)as mes 
                from vista_proceso_solicitud_adulto, eventos
                where eventos.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                and tipo='ingreso'
                and vista_proceso_solicitud_adulto.estado='Finalizado'
                and eventos.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and (derivacion_idderivacion=5  or derivacion_idderivacion=4  or derivacion_idderivacion=3)
                GROUP BY mes, vista_proceso_solicitud_adulto.idproceso_postulacion is not NULL";
        
       /* orig
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`
        WHERE (evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01'))
        and (derivacion_idderivacion=5  or derivacion_idderivacion=4  or derivacion_idderivacion=3)
        group by mes";
       
        */
               
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

   static public function GetIngresoPersonal($annos,$m)
   {
        //$query="select count(DISTINCT(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)) as total, 
        
        $query="select count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, 
                month(eventos.fecha_realizacion)as mes 
                from vista_proceso_solicitud_adulto, eventos
                where eventos.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                and tipo='ingreso'
                and vista_proceso_solicitud_adulto.estado='Finalizado'
                and eventos.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and derivacion_idderivacion=2 GROUP BY mes, vista_proceso_solicitud_adulto.idproceso_postulacion is not NULL";
 
        /* orig
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`
        WHERE (evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
              and derivacion_idderivacion=2)
              group by mes";
        */
        
        
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

    
static public function GetIngresoConMasdeunProceso($annos,$m)
{    
    
$query="SELECT count(DISTINCT(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)) as total, 
        month(eventos.fecha_realizacion) as mes FROM vista_proceso_solicitud_adulto, eventos 
        where eventos.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona 
        and tipo='ingreso' and vista_proceso_solicitud_adulto.estado='Finalizado' 
        AND eventos.fecha_realizacion >= '$annos-$m-01'
        AND eventos.fecha_realizacion <= LAST_DAY('$annos-$m-01')
        GROUP BY vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona 
        HAVING COUNT(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) >1 
        ORDER BY count(DISTINCT(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona)) DESC";

/*   
    
$query="SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        WHERE tipo = 'ingreso'
        AND evento_fecha >= '$annos-$m-01'
        AND evento_fecha <= LAST_DAY('$annos-$m-01')
        GROUP BY adulto_evento
        HAVING COUNT( adulto_evento ) >1
        ORDER BY count( adulto_evento ) DESC";
   */

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
}    
    
    static public function GetIngresoTotal($annos,$m)
   {    
        $query="select count(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as total, 
                month(eventos.fecha_realizacion)as mes 
                from vista_proceso_solicitud_adulto, eventos
                where eventos.adulto_mayor_persona_idpersona=vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona
                and tipo='ingreso'
                and vista_proceso_solicitud_adulto.estado='Finalizado'
                and eventos.fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                GROUP BY mes";
        
        /*
        $query = "SELECT count(adulto_evento) as total, month(evento_fecha) as mes FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes";
        */
        
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }
    
     static public function GetIngresoTotalResidente($annos,$m)
   {    
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes";
         
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }
    
//****************************************************************************//
    
    static public function GetIngresoConApoderado($annos, $m)
    {  
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and personas_otras_persona_idpersona is not null
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

    static public function GetIngresoSinApoderado($annos,$m)
    {   
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and personas_otras_persona_idpersona is null
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
     }

   static public function GetIngresadoSinIngresosPropios($annos,$m)
   {    
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and monto_total_ingresos=0
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }


   static public function GetIngresoPensionBasica($annos,$m)
   {
        $pensionBasica= Configuracion::$Pension_basica;

        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and monto_total_ingresos>0 and monto_total_ingresos <= $pensionBasica
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }

   static public function GetIngresoSuperiorPensionBasica($annos,$m)
   {    
        $pensionBasica= Configuracion::$Pension_basica;
        $pensionMedia= Configuracion::$Pension_media;

        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and monto_total_ingresos>$pensionBasica and monto_total_ingresos <= $pensionMedia
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

     static public function GetIngresadoHastaMaximoIngreso($annos,$m)   
   {    
        $pensionMedia= Configuracion::$Pension_media;
        $pensionSuperior = Configuracion::$Pension_superior;

        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and monto_total_ingresos>$pensionMedia and monto_total_ingresos <= $pensionSuperior
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

   static public function GetIngresadoSuperiorMaximoIngreso($annos,$m)   // Maximo $150.000
   {

        $pensionSuperior = Configuracion::$Pension_superior;

        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and monto_total_ingresos > $pensionSuperior
        group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
    }

   

    static public function GetIngresoPromedioEdadMujer($annos,$m)
    {   
        $query="SELECT format(sum(edad)/count(adulto_evento),1) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        where evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=0
        group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetIngresoPromedioEdadHombre($annos,$m)
    {
        $query="SELECT format(sum(edad)/count(adulto_evento),1) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        where evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01') and sexo=1
        group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

    static public function GetIngresoPromedioEdadGeneral($annos,$m)
    {
        $query="SELECT format(sum(edad)/count(adulto_evento),1) as total, month(evento_fecha) as mes
        FROM vista_proceso_residente
        where estado='Finalizado'
        and evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        group by mes order by mes asc ";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
         }
     }


     static public function GetIngresoAutovalentes($annos, $m)
     {

        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`, consulta_salud
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_residente.adulto_mayor_persona_idpersona
        and (katz='A' or katz='B')
        group by mes order by mes";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

   static public function GetIngresoSemivalentes($annos, $m)
     {
        //categoria='residente'
        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`, consulta_salud
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_residente.adulto_mayor_persona_idpersona
        and (katz='C' or katz='D')
        group by mes order by mes";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }

   static public function GetIngresoNovalentes($annos, $m)
     {

        $query = "SELECT count(distinct(adulto_evento)) as total, month(evento_fecha) as mes
        FROM `vista_proceso_residente`, consulta_salud
        WHERE evento_fecha BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
        and consulta_salud.adulto_mayor_persona_idpersona=vista_proceso_residente.adulto_mayor_persona_idpersona
        and (katz='E' or katz='F' or katz='G' or katz='H' or katz='X')
        group by mes order by mes";


        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


  static public function GetIngresoPromedioTiempoEspera($annos,$m)
    {
        /*
             $query="SELECT format(avg(diferencia_dia),1) as total, month(fecha_proceso_postulacion) as mes
                FROM vista_tiempo_espera
                where fecha_proceso_postulacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                group by mes order by mes asc";
        */
             $query="SELECT format(avg(diferencia_dia),1) as total, month(fecha_realizacion) as mes
                FROM vista_tiempo_espera
                where fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearIngresado($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
         }
     }

  public static function CrearIngresado($row)
    {

        $utilitarios= new CUtilitariosIndicador();
        $utilitarios->SetCamponum1($row['total']);
        $utilitarios->SetCamponum2($row['mes']);
        $utilitarios->SetCamponum3($row['derivacion_idderivacion']);
        $utilitarios->SetCamponum4($row['sexo']);


        return $utilitarios;
    }


//********************Desistimientos *////////////////////////////////
    
    static public function GetDesistidoCantidadHombres($annos,$m)
    {   
        $query="SELECT count(idlog) as cantidad, month(fecha_realizacion) as mes FROM `log`, adulto_mayor
                where fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and log.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and sexo=1
                and evento='Desistir Adulto Mayor'
                group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearDesistido($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }


    static public function GetDesistidoCantidadMujeres($annos,$m)
    {
        $query="SELECT count(idlog) as cantidad, month(fecha_realizacion) as mes FROM `log`, adulto_mayor
                where fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and log.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and sexo=0
                and evento='Desistir Adulto Mayor'
                group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearDesistido($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }
 

   static public function GetDesistidoTotal($annos,$m)
    {   
        $query="SELECT count(idlog) as cantidad, month(fecha_realizacion) as mes FROM `log`, adulto_mayor
                where fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                and log.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and evento='Desistir Adulto Mayor'
                group by mes order by mes";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearDesistido($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
        }
     }
    
    public static function CrearDesistido($row)
   {

        $utilitarios6= new CUtilitariosIndicador();
        $utilitarios6->SetCamponum1($row['cantidad']);
        $utilitarios6->SetCamponum2($row['sexo']);
        $utilitarios6->SetCamponum3($row['mes']);

        return $utilitarios6;
    }

    
     
    public static function GetDiferenciaMes($mes_ini, $mes_fin, $anno_ini, $annos){
        
        $consulta="SELECT TIMESTAMPDIFF(MONTH,'$anno_ini-$mes_ini-01','$annos-$mes_fin-01') as diferencia_mes";  
        // echo $consulta."<br>";
        
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($consulta);
        
         if(CDBSingleton::RevisarExito($exito, $consulta))
            {
                 $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                 return $rs['diferencia_mes'];
            }
    }
    
    public static function GetDiferenciaAnno($mes_ini, $mes_fin, $anno_ini, $annos){
        
        $consulta="SELECT TIMESTAMPDIFF(YEAR,'$anno_ini-$mes_ini-01','$annos-$mes_ini-01') as diferencia_anno";  
       
        // echo $consulta."<br>";
        
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($consulta);
        
         if(CDBSingleton::RevisarExito($exito, $consulta))
            {
                 $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                 return $rs['diferencia_anno'];
            }
    }
    
   //***************************************************************************************************************************************// 
   /* Indicador Operativo y Movimientos Residentes */ 
    
   static public function GetMovimientoIngresosIndicador($annos,$m) // corresponde a indicador operativo y a Movimientos Residentes
   {
        $query="SELECT  count(distinct(adulto_mayor_persona_idpersona)) as cantidad, month(fecha_realizacion) as mes, year(fecha_realizacion) as anno FROM eventos, adulto_mayor
                where tipo='ingreso'
                and eventos.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and fecha_realizacion >='$annos-$m-01' and fecha_realizacion<=LAST_DAY('$annos-$m-01')
                group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $aUtilitarios[$i]=self::CrearMovimientos($rs);
                   
             }
			 return $aUtilitarios;
        }
    }
        
        
    static public function GetMovimientoIngresosHCristoIndicador($annos,$m) // corresponde a indicador operativo y a Movimientos Residentes
   {
        $query="SELECT  count(distinct(adulto_mayor_persona_idpersona)) as cantidad, month(fecha_realizacion) as mes, year(fecha_realizacion) as anno 
                FROM eventos, adulto_mayor 
                where tipo='ingreso' 
                and eventos.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and origen_inicial_idorigen_inicial=2
                and fecha_realizacion BETWEEN '$annos-$m-01' and LAST_DAY('$annos-$m-01')
                group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $aUtilitarios[$i]=self::CrearMovimientos($rs);
                    
             }
			 return $aUtilitarios;
        }
    }


    
    static public function GetMovimientoTrasladosIndicador($annos,$m)       // corresponde a indicador operativo y a Movimientos Residentes
   {
        $query="SELECT count(distinct(adulto_mayor_persona_idpersona)) as cantidad, month(fecha_realizacion) as mes, year(fecha_realizacion) as anno  FROM eventos, adulto_mayor 
                where tipo='traslado'
                and eventos.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and fecha_realizacion >='$annos-$m-01' and fecha_realizacion<=LAST_DAY('$annos-$m-01')
                group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $aUtilitarios[$i]=self::CrearMovimientos($rs);
                  
             }
			 return $aUtilitarios;
        }
    }

    
      static public function GetMovimientoEgresoFallecimientoIndicador($annos,$m)  // corresponde a indicador operativo y a Movimientos Residentes
   {
        $query="SELECT count(distinct(adulto_mayor_persona_idpersona)) as cantidad, month(fecha_realizacion) as mes, year(fecha_realizacion) as anno FROM eventos, adulto_mayor 
                where tipo='egreso'
                and eventos.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and fecha_realizacion >='$annos-$m-01' and fecha_realizacion<=LAST_DAY('$annos-$m-01')
                and aux='fallecido'
                group by mes order by mes asc";

        //echo $query;
        //echo "<br><br>";
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $aUtilitarios[$i]=self::CrearMovimientos($rs);
                    
             }
			 return $aUtilitarios;
        }
    }
    
    
   static public function GetMovimientoEgresoComunidadIndicador($annos,$m) // corresponde a indicador operativo y a Movimientos Residentes
   {
        $query="SELECT count(distinct(adulto_mayor_persona_idpersona)) as cantidad, month(fecha_realizacion) as mes, year(fecha_realizacion) as anno FROM eventos, adulto_mayor
                where tipo='egreso'
                and eventos.adulto_mayor_persona_idpersona=adulto_mayor.persona_idpersona
                and fecha_realizacion >='$annos-$m-01' and fecha_realizacion<=LAST_DAY('$annos-$m-01')
                and aux='egreso'
                group by mes order by mes asc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $aUtilitarios[$i]=self::CrearMovimientos($rs);
                    
             }
			 return $aUtilitarios;
        }
    }
            
   public static function CrearMovimientos($row)
   {
        $utilitarios= new CUtilitariosIndicador();
        $utilitarios->SetCamponum1($row['cantidad']);
        $utilitarios->SetCamponum2($row['mes']);
        $utilitarios->SetCamponum3($row['anno']);
        return $utilitarios;
    }

//********************************************************************************

    
    
////*******************Consulta Listado de Postulantes
   static public function GetListadoPostulantes($fecha)
   {   
            $parte = explode("-", $fecha);
            $anno=$parte[0]; 
            $mesR=$parte[1]; 
            
            // Para considerar tres meses de desistimiento
           
            if ($mesR == 1){
                $mes=$mesR;
            }else if ($mesR == 2){    
                $mes=$mesR;
            }else if ($mesR == 3){    
                $mes=$mesR;
            }else{
                $mes=$mesR-3;
            }
             
            
                  $query = "SELECT distinct(rut) as rut, max(idproceso_postulacion),max(idlog),
                                    apellido_paterno,apellido_materno,nombres,max(log.fecha_realizacion) as fecha_realizacion,categoria,rut,comuna_idcomuna,
                  (to_days('$fecha')- to_days(max(log.fecha_realizacion))) as diferencia_dia, log.adulto_mayor_persona_idpersona             
                  FROM vista_proceso_solicitud_adulto
             
                  LEFT OUTER JOIN log
                  on vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                
                  where(
                      (
                            (`categoria`='postulante' 
                               and (log.evento='Ingreso de Ev. Social' 
                               or log.evento='Ingreso de Solicitud' 
                               or log.evento='Actualizacion de Ev. Social' 
                               or log.evento='Ingreso de Ev. Medica') 
                               and log.fecha_realizacion<='$fecha')
                      )
                      OR
                      (
                        (`categoria`='egresado' and (log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Social') and
                         log.fecha_realizacion<='$fecha' or               
                         log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha') 
                    
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                            )
                      )
                      OR
                      (
                           (`categoria`='fallecido' and (log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Social') and
                           log.fecha_realizacion<='$fecha' or                
                           log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha') 
                    
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                            )
                      )
                      OR 
                      (
                         (`categoria`='desistido' and (log.evento='Ingreso de Ev. Social' or log.evento='Desistir Adulto Mayor') and 
                           log.fecha_realizacion<='$fecha' or                
                           log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha' 
                    
                          )
                          AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                            )
                      )
                      OR 
                      (
                         `categoria`='residente' and ((log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Medica') and
                          log.fecha_realizacion<='$fecha' or              
                          log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha') 
                          
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                             )
                       ) 
            
                    )
                   group by rut, categoria order by categoria asc, max(log.fecha_realizacion) desc";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            if($exito->numRows()>0)
            {
             $aUtilitarios = array();
             for($i=0; $i<$exito->numRows(); $i++)
             {
                    $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                    $a[$i]=self::CrearListadoPostulante($rs);
                    $aUtilitarios[$i]=$a[$i];
             }
			 return $aUtilitarios;
            }
        }
    }

    static public function GetPostulantes($_nIdPersona, $fecha) {
        if(isset($_nIdPersona)) {
           
            $parte = explode("-", $fecha);
            $anno=$parte[0]; 
            $mesR=$parte[1]; 
       
            if ($mesR == 1){
                $mes=$mesR;
            }else if ($mesR == 2){    
                $mes=$mesR;
            }else if ($mesR == 3){    
                $mes=$mesR;
            }else{
                $mes=$mesR-3;
            }
            
        //consultando por fecha de proceso de postulacion  con tabla proceso postulacion contenida en la vista
      
            $sSelectQuery = "SELECT distinct(rut) as rut, max(idproceso_postulacion),max(idlog),
                             apellido_paterno,apellido_materno,nombres,max(log.fecha_realizacion) as fecha_realizacion,categoria,rut,comuna_idcomuna,
                             (to_days('$fecha')- to_days(max(log.fecha_realizacion))) as diferencia_dia, log.adulto_mayor_persona_idpersona, telefono          
                              
                             FROM vista_proceso_solicitud_adulto
                        LEFT OUTER JOIN log
                        on vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                 
                  where(
                      (
                            (`categoria`='postulante' 
                               and (log.evento='Ingreso de Ev. Social' 
                               or log.evento='Ingreso de Solicitud' 
                               or log.evento='Actualizacion de Ev. Social' 
                               or log.evento='Ingreso de Ev. Medica') 
                               and log.fecha_realizacion<='$fecha'
                               and log.adulto_mayor_persona_idpersona=".$_nIdPersona."
                            )
                      )
                      OR
                      (
                        (`categoria`='egresado' and (log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Social') and
                         log.fecha_realizacion<='$fecha' or               
                         log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha'
                         and log.adulto_mayor_persona_idpersona=".$_nIdPersona."
                         ) 
                    
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                             and eventos.adulto_mayor_persona_idpersona=".$_nIdPersona."
                            )
                      )
                      OR
                      (
                           (`categoria`='fallecido' and (log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Social') and
                           log.fecha_realizacion<='$fecha' or                
                           log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha'
                           and log.adulto_mayor_persona_idpersona=".$_nIdPersona."
                           ) 
                    
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                             and eventos.adulto_mayor_persona_idpersona=".$_nIdPersona."
                             )
                      )
                      OR 
                      (
                         (`categoria`='desistido' and (log.evento='Ingreso de Ev. Social' or log.evento='Desistir Adulto Mayor') and 
                           log.fecha_realizacion<='$fecha' or                
                           log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha'
                           and log.adulto_mayor_persona_idpersona=".$_nIdPersona."
                    
                          )
                          AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                             and eventos.adulto_mayor_persona_idpersona=".$_nIdPersona."
                            )
                      )
                      OR 
                      (
                         `categoria`='residente' and ((log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Medica') and
                          log.fecha_realizacion<='$fecha' or              
                          log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha'
                          and log.adulto_mayor_persona_idpersona=".$_nIdPersona."
                            
                         ) 
                          
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                             and eventos.adulto_mayor_persona_idpersona=".$_nIdPersona."
                             )
                       ) 
            
                    )
                   group by rut, categoria order by categoria asc, max(log.fecha_realizacion) desc";

            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($sSelectQuery);
            
            if(CDBSingleton::RevisarExito($rs, $sSelectQuery)) {
                $aRow=$rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($aRow) {
                    return self::CrearListadoPostulante($aRow);
                }
            }
  
        }
        else
            return new CUtilitarios();
    }    
    
    
    // hay que arreglar segun la consulta definitiva.
    public static function GetIdListadoPostulantes($fecha)
    {
            $parte = explode("-", $fecha);
            $anno=$parte[0]; 
            $mesR=$parte[1]; 
       
        //consultando por fecha de proceso de postulacion  con tabla proceso postulacion contenida en la vista
            
            if ($mesR == 1){
                $mes=$mesR;
            }else if ($mesR == 2){    
                $mes=$mesR;
            }else if ($mesR == 3){    
                $mes=$mesR;
            }else{
                $mes=$mesR-3;
            }
             
        $query = "select distinct(vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona) as idpersona, categoria            
                  FROM vista_proceso_solicitud_adulto
             
                  LEFT OUTER JOIN log
                  on vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                
                  where(
                      (
                            (`categoria`='postulante' 
                               and (log.evento='Ingreso de Ev. Social' 
                               or log.evento='Ingreso de Solicitud' 
                               or log.evento='Actualizacion de Ev. Social' 
                               or log.evento='Ingreso de Ev. Medica') 
                               and log.fecha_realizacion<='$fecha')
                      )
                      OR
                      (
                        (`categoria`='egresado' and (log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Social') and
                         log.fecha_realizacion<='$fecha' or               
                         log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha') 
                    
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                            )
                      )
                      OR
                      (
                           (`categoria`='fallecido' and (log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Social') and
                           log.fecha_realizacion<='$fecha' or                
                           log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha') 
                    
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                            )
                      )
                      OR 
                      (
                         (`categoria`='desistido' and (log.evento='Ingreso de Ev. Social' or log.evento='Desistir Adulto Mayor') and 
                           log.fecha_realizacion<='$fecha' or                
                           log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha' 
                    
                          )
                          AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                            )
                      )
                      OR 
                      (
                         `categoria`='residente' and ((log.evento='Ingreso de Ev. Social' or log.evento='Actualizacion de Ev. Medica') and
                          log.fecha_realizacion<='$fecha' or              
                          log.fecha_realizacion BETWEEN '$anno-$mes-01' and '$fecha') 
                          
                         AND (
                             select distinct(adulto_mayor_persona_idpersona) from eventos 
                             where eventos.tipo='ingreso' and eventos.fecha_realizacion>='$fecha'
                             and eventos.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                             )
                       ) 
            
                    )
                   group by idpersona";

        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        
        $a=array();
    
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=$rs['idpersona'];
            }
        }
             return array($a, $exito->numrows());
    }
 
   public static function GetListadoPostulantes2($fecha){
        $query="select persona_idpersona as id from adulto_mayor";
        $con=  CDBSingleton::GetConn();
        $rs=$con->query($query);
        if(CDBSingleton::RevisarExito($rs, $query)){
            $a=array();
            for($i=0; $i<$rs->numrows(); $i++){
                $r=$rs->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=$r["id"];
            }
            $count_postulantes=0;
            $con->query("set @a=0");
            $aUtilitarios = array();
            for($i=0; $i<count($a); $i++){
                $rs=$con->query("call espostulante(".$a[$i].", '$fecha', @a)");
                $rs=$con->query("select @a as espostulante");
                $r=$rs->fetchRow(DB_FETCHMODE_ASSOC, 0);
                if($r['espostulante']==1){
                    // sacar datos del postulate segun listado anterior
                    $query="SELECT distinct(rut) as rut, max(idproceso_postulacion) as idproceso_postulacion,max(idlog),vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona as adulto_mayor_persona_idpersona,apellido_paterno,apellido_materno,nombres, max(log.fecha_realizacion) as fecha_realizacion,categoria,rut,comuna_idcomuna,telefono,(to_days('$fecha')- to_days(max(log.fecha_realizacion))) as diferencia_dia             
                  FROM vista_proceso_solicitud_adulto LEFT OUTER JOIN log on vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona=log.adulto_mayor_persona_idpersona
                  where vista_proceso_solicitud_adulto.adulto_mayor_persona_idpersona=".$a[$i]." group by rut";
                    
                   $rs=$con->query($query);
                   if(CDBSingleton::RevisarExito($rs, $query)){
                       $r=$rs->fetchrow(DB_FETCHMODE_ASSOC, 0);
                       $aUtilitarios[$count_postulantes]=self::CrearListadoPostulante($r);
                       $count_postulantes++;
                   }                 
                    //
                }
            }
            error_log("[postulantes]".$count_postulantes);
        }
        return $aUtilitarios;
   }
    
   public static function CrearListadoPostulante($row)
   {
        $utilitarios= new CUtilitarios();
        $utilitarios->SetCamponum1($row['idproceso_postulacion']);
        $utilitarios->SetCamponum2($row['adulto_mayor_persona_idpersona']);
        $utilitarios->SetCamponum3($row['diferencia_dia']);
        
        $utilitarios->SetCampovar1($row['rut']);
        //Para mostrar datos mal ingresado desde bd colocamos decode
        $utilitarios->SetCampovar2(utf8_encode($row['apellido_paterno']));
        $utilitarios->SetCampovar3(utf8_encode($row['apellido_materno']));
        $utilitarios->SetCampovar4(utf8_encode($row['nombres']));
        $utilitarios->SetCampovar5($row['fecha_realizacion']);
   //     $utilitarios->SetCampovar6($row['estado']);
        $utilitarios->SetCampovar6($row['categoria']);
   
        $utilitarios->SetCampovar7(CAdminLocalidades::GetComunaNombre($row['comuna_idcomuna']));
        
        $utilitarios->SetCampovar8($row['telefono']);
        
        return $utilitarios;
    }   
    
    
    // Postulantes femeninos y masculinos con Evaluacion medica y solo se despliega las
    // enfermedades psiquiatricas.
    
    
    static public function GetPostulantesFemMasConEvMedica($fecha, $sexo)
    {
      if ($sexo=='2'){
         // sexo== 2 corresponde a ambos postulantes, femeninos y masculinos. 
          
         $query="SELECT a.persona_idpersona, a.rut, a.apellido_paterno, a.apellido_materno, a.nombres, a.sexo,
                a.fecha_nacimiento, a.direccion, a.telefono, 
                a.comuna_idcomuna, p.estado, 
                a.categoria,p.fecha_proceso_postulacion,
                p.adulto_mayor_persona_idpersona,p.estado, ev.idevaluacion_medica
                FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev
                WHERE a.categoria = 'postulante'
                AND p.adulto_mayor_persona_idpersona = a.persona_idpersona
                AND p.estado = 'Activo'
                AND p.fecha_proceso_postulacion<='$fecha'
                AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion
                GROUP BY a.rut 
                ORDER BY `a`.`apellido_paterno` ASC, a.comuna_idcomuna ASC";
      }else{
            
        $query="SELECT a.persona_idpersona, a.rut, a.apellido_paterno, a.apellido_materno, a.nombres, a.sexo,
                a.fecha_nacimiento, a.direccion, a.telefono, 
                a.comuna_idcomuna, p.estado, 
                a.categoria,p.fecha_proceso_postulacion,
                p.adulto_mayor_persona_idpersona,p.estado, ev.idevaluacion_medica
                FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev, comuna com, region reg
                WHERE a.categoria = 'postulante'
                AND p.adulto_mayor_persona_idpersona = a.persona_idpersona
                AND a.sexo ='$sexo'
                AND p.estado = 'Activo'
                AND p.fecha_proceso_postulacion<='$fecha'
                AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion
                GROUP BY a.rut 
                ORDER BY `a`.`apellido_paterno` ASC, a.comuna_idcomuna ASC";
      }
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulanteConEv($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }
    
    //Postulantes Femeninos y Masculinos 
    
     static public function GetPostulantesConEvMedica($fecha)
    {
        $query="SELECT a.persona_idpersona, max(p.fecha_proceso_postulacion) as fecha_proceso_postulacion, a.rut, a.apellido_paterno, a.apellido_materno, a.nombres, a.sexo,
                a.fecha_nacimiento, a.direccion, a.telefono, 
                a.comuna_idcomuna, a.categoria, p.estado,
                a.categoria,
                p.adulto_mayor_persona_idpersona,p.estado, ev.idevaluacion_medica
                FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev
                WHERE a.categoria = 'postulante'
                AND p.adulto_mayor_persona_idpersona = a.persona_idpersona
                AND p.estado = 'Activo'
                AND p.fecha_proceso_postulacion<='$fecha' 
                AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion
                GROUP BY a.rut 
                ORDER BY `a`.`apellido_paterno` ASC , a.comuna_idcomuna ASC";

        // echo $query;
   
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulanteConEv($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }
    
    
    public static function GetIdListadoPostulantesEVM($fecha)
    {
        $query = "SELECT a.persona_idpersona
                  FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev
                WHERE a.categoria = 'postulante'
                AND p.adulto_mayor_persona_idpersona = a.persona_idpersona
                AND p.estado = 'Activo'
                AND p.fecha_proceso_postulacion<='$fecha'
                AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion
                GROUP BY a.rut 
                ORDER BY `a`.`apellido_paterno` ASC, a.comuna_idcomuna ASC";
        
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        
        $a=array();
    
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=$rs['persona_idpersona'];
            }
        }
             return array($a, $exito->numrows());
    }
    
    
    
     static public function GetPostulantesEVM($_nIdPersona, $fecha) { 
        if(isset($_nIdPersona)) {
           
            $query="SELECT a.persona_idpersona, a.rut, a.apellido_paterno, a.apellido_materno, a.nombres, a.sexo,
                a.fecha_nacimiento, a.direccion, a.telefono, 
                a.comuna_idcomuna,
                a.categoria, max(p.fecha_proceso_postulacion)as fecha_proceso_postulacion, p.estado,
                p.adulto_mayor_persona_idpersona,p.estado, ev.idevaluacion_medica
                FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev, comuna com, region reg
                WHERE a.categoria = 'postulante'
                AND p.adulto_mayor_persona_idpersona = a.persona_idpersona
                AND p.estado = 'Activo'
                AND p.fecha_proceso_postulacion<='$fecha' 
                AND a.persona_idpersona='$_nIdPersona'
                AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion
               
                GROUP BY a.rut 
                ORDER BY `a`.`apellido_paterno` ASC , a.comuna_idcomuna ASC";
            
   // echo $query;
 
            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($query);
            
            if(CDBSingleton::RevisarExito($rs, $query)) {
                $aRow=$rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($aRow) { 
                    return self::CrearPostulanteConEv($aRow);
                } 
            } 
   
        } 
        else
            return new CUtilitarios();
    }    
    
    public static function CrearPostulanteConEv($row)
    {
        $utilitarios= new CUtilitarios();
        $utilitarios->SetCampovar1($row['persona_idpersona']);
        $utilitarios->SetCampovar2($row['rut']);
        $utilitarios->SetCampovar3(utf8_encode($row['apellido_paterno'])); 
        $utilitarios->SetCampovar4(utf8_encode($row['apellido_materno'])); 
        $utilitarios->SetCampovar5(utf8_encode($row['nombres'])); 
        $utilitarios->SetCampovar6($row['sexo']);
        $utilitarios->SetCampovar7(self::calculaEdad($row['fecha_nacimiento']));
        $utilitarios->SetCampovar8($row['direccion']);
        $utilitarios->SetCampovar9($row['telefono']);
        $utilitarios->SetCampovar10(CAdminLocalidades::GetComunaNombre($row['comuna_idcomuna']));
        $utilitarios->SetCampovar11(CAdminLocalidades::GetRegionNombre($row['comuna_idcomuna']));
        $utilitarios->SetCampovar12($row['categoria']);
        $utilitarios->SetCampovar13($row['fecha_proceso_postulacion']);
        $utilitarios->SetCampovar14($row['estado']);
        $utilitarios->SetCampovar15($row['idevaluacion_medica']);
               
        return $utilitarios;
    }

 // ************************************************************************   

    static public function GetPostulantesFemMasSinEvMedica($sexo)
    {
      if ($sexo=='2'){
         // sexo== 2 corresponde a ambos postulantes, femeninos y masculinos. 
          
         $query="SELECT persona_idpersona, rut, apellido_paterno, apellido_materno, 
                   nombres, fecha_nacimiento, direccion, telefono, categoria, comuna_idcomuna  FROM  adulto_mayor
                 WHERE 
                 categoria='postulante'
                 and 
                    NOT EXISTS 
                    (SELECT * FROM  `vista_postulantes_con_evm` 
                     WHERE adulto_mayor.`persona_idpersona` = vista_postulantes_con_evm.`persona_idpersona`)
                  order by apellido_paterno asc ";
      }else{
            
          $query="SELECT persona_idpersona, rut, apellido_paterno, apellido_materno, 
                   nombres, fecha_nacimiento, direccion, telefono, categoria, comuna_idcomuna  FROM  adulto_mayor
                  WHERE 
                  categoria='postulante' 
                  and sexo ='$sexo'
                  and 
                     NOT EXISTS 
                     (SELECT * FROM  `vista_postulantes_con_evm` 
                      WHERE adulto_mayor.`persona_idpersona` = vista_postulantes_con_evm.`persona_idpersona`) 
                     order by apellido_paterno asc";
      }
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulanteSinEv($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }
   
    
     public static function GetIdListadoPostulantesSinEVM()
    {  
         $query="SELECT persona_idpersona FROM  adulto_mayor
                 WHERE 
                 categoria='postulante'
                 and 
                    NOT EXISTS 
                    (SELECT * FROM  `vista_postulantes_con_evm` 
                     WHERE adulto_mayor.`persona_idpersona` = vista_postulantes_con_evm.`persona_idpersona`)
                  order by apellido_paterno asc";
        
        $conn=CDBSingleton::GetConn();
        $exito=$conn->query($query);
        
        $a=array();
    
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            for($i=0; $i<$exito->numrows(); $i++)
            {
                $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                $a[$i]=$rs['persona_idpersona'];
            }
        }
             return array($a, $exito->numrows());
    }
    
    static public function GetPostulantesSinEVM($_nIdPersona) { 
        if(isset($_nIdPersona)) {
           
           $query="SELECT persona_idpersona, rut, apellido_paterno, apellido_materno, 
                   nombres, fecha_nacimiento, direccion, telefono, categoria, comuna_idcomuna 
                   FROM  adulto_mayor
                   WHERE 
                   categoria='postulante' and persona_idpersona='$_nIdPersona'
                 and 
                    NOT EXISTS 
                    (SELECT * FROM  `vista_postulantes_con_evm` 
                     WHERE adulto_mayor.`persona_idpersona` = vista_postulantes_con_evm.`persona_idpersona`)
                  order by apellido_paterno asc";
 
            $conn=CDBSingleton::GetConn();
            $rs=$conn->query($query);
            
            if(CDBSingleton::RevisarExito($rs, $query)) {
                $aRow=$rs->fetchRow(DB_FETCHMODE_ASSOC);
                if($aRow) { 
                    return self::CrearPostulanteSinEv($aRow);
                } 
            } 
   
        } 
        else
            return new CUtilitarios();
    }    
        
    
    static public function calculaEdad($fechanacimiento)
    {
          list($ano,$mes,$dia) = explode("-",$fechanacimiento);
              $ano_diferencia  = date("Y") - $ano;
              $mes_diferencia = date("m") - $mes;
              $dia_diferencia   = date("d") - $dia;
                    if ($dia_diferencia < 0 || $mes_diferencia < 0)
                         $ano_diferencia--;
          return $ano_diferencia;
    }
   
     
    static public function GetFechaProcesoPostulacionPostulante($idamPostulante) {
        $query="SELECT max( idproceso_postulacion ) AS maximo_proceso, max( `fecha_proceso_postulacion` ) AS fecha_proceso_postulacion,
                adulto_mayor_persona_idpersona
                FROM proceso_postulacion
                WHERE adulto_mayor_persona_idpersona ='".$idamPostulante."'
                GROUP BY adulto_mayor_persona_idpersona";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(CDBSingleton::RevisarExito($exito, $query)) {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            return $rs['fecha_proceso_postulacion'];
        }
     }
    
     public static function CrearPostulanteSinEv($row)
    {
        $utilitarios= new CUtilitarios();
        $utilitarios->SetCampovar1($row['persona_idpersona']);
        $utilitarios->SetCampovar2($row['rut']);
        $utilitarios->SetCampovar3(utf8_encode($row['apellido_paterno'])); 
        $utilitarios->SetCampovar4(utf8_encode($row['apellido_materno'])); 
        $utilitarios->SetCampovar5(utf8_encode($row['nombres'])); 
        $utilitarios->SetCampovar6($row['sexo']);
        $utilitarios->SetCampovar7(self::calculaEdad($row['fecha_nacimiento']));
        $utilitarios->SetCampovar8($row['direccion']);
        $utilitarios->SetCampovar9($row['telefono']);
        $utilitarios->SetCampovar10(CAdminLocalidades::GetComunaNombre($row['comuna_idcomuna']));
        $utilitarios->SetCampovar11(CAdminLocalidades::GetRegionNombre($row['comuna_idcomuna']));
        $utilitarios->SetCampovar12($row['categoria']);
        $utilitarios->SetCampovar13(self::GetFechaProcesoPostulacionPostulante($row['persona_idpersona']));
        return $utilitarios;
    } 

    static public function GetPostulantesListaDeEspera()
    {
        $query="SELECT 
                       a.persona_idpersona, 
                       max(p.fecha_proceso_postulacion) as fecha_proceso_postulacion,
                       a.rut, 
                       a.apellido_paterno, 
                       a.apellido_materno, 
                       a.nombres, 
                       a.sexo, 
                       a.fecha_nacimiento, 
                       a.direccion, 
                       a.telefono, 
                       a.comuna_idcomuna, 
                       a.categoria, 
                       p.estado, 
                       ev.idevaluacion_medica, 
                       es.idevaluacion_social, 
                       es.`proceso_postulacion_idproceso_postulacion` 
                       
                       FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev, evaluacion_social es 
                       
                       WHERE a.categoria = 'postulante' 
                       AND p.adulto_mayor_persona_idpersona = a.persona_idpersona 
                       AND p.estado = 'Activo' 
                       AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion 
                       AND es.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion 
                       AND ev.proceso_postulacion_idproceso_postulacion = es.proceso_postulacion_idproceso_postulacion 
                       GROUP BY a.rut 
                       ORDER BY `a`.`apellido_paterno` ASC , a.comuna_idcomuna ASC";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulantesListaEspera($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }
    
    public static function CrearPostulantesListaEspera($row)
    {
        $utilitarios= new CUtilitarios();
        $utilitarios->SetCampovar1($row['persona_idpersona']);
        $utilitarios->SetCampovar13($row['fecha_proceso_postulacion']);
        $utilitarios->SetCampovar2($row['rut']);
        $utilitarios->SetCampovar3(utf8_encode($row['apellido_paterno'])); 
        $utilitarios->SetCampovar4(utf8_encode($row['apellido_materno'])); 
        $utilitarios->SetCampovar5(utf8_encode($row['nombres'])); 
        $utilitarios->SetCampovar6($row['sexo']);
        $utilitarios->SetCampovar7(self::calculaEdad($row['fecha_nacimiento']));
        $utilitarios->SetCampovar8($row['direccion']);
        $utilitarios->SetCampovar9($row['telefono']);
        $utilitarios->SetCampovar10(CAdminLocalidades::GetComunaNombre($row['comuna_idcomuna']));
        $utilitarios->SetCampovar11(CAdminLocalidades::GetRegionNombre($row['comuna_idcomuna']));
        $utilitarios->SetCampovar12($row['categoria']);
        $utilitarios->SetCampovar14($row['estado']);
        $utilitarios->SetCampovar15($row['idevaluacion_medica']);
        $utilitarios->SetCampovar16($row['idevaluacion_social']);
        $utilitarios->SetCampovar17($row['proceso_postulacion_idproceso_postulacion']);
               
        return $utilitarios;
    }
    
/*
    ** ESTE METODO SACA LA LISTA DE ESPERA... SIN QUERER **
    
    static public function GetPostulantesEvmTotal()
    {
        $query="SELECT 
                       a.persona_idpersona, 
                       max(p.fecha_proceso_postulacion) as fecha_proceso_postulacion,
                       a.rut, 
                       a.apellido_paterno, 
                       a.apellido_materno, 
                       a.nombres, 
                       a.sexo, 
                       a.fecha_nacimiento, 
                       a.direccion, 
                       a.telefono, 
                       a.comuna_idcomuna, 
                       a.categoria, 
                       p.estado, 
                       ev.idevaluacion_medica
                       
                       FROM adulto_mayor a, proceso_postulacion p, evaluacion_medica ev, evaluacion_social es 
                       
                       WHERE a.categoria = 'postulante' 
                       AND p.adulto_mayor_persona_idpersona = a.persona_idpersona 
                       AND p.estado = 'Activo' 
                       AND ev.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion 
                       
                       
                       GROUP BY a.rut 
                       ORDER BY `a`.`apellido_paterno` ASC , a.comuna_idcomuna ASC";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulantesListaEspera($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }


    ** ESTE METODO SACA LA LISTA DE ESPERA... SIN QUERER , ademas de las postulantes con la eva social **
     
    static public function GetPostulantesEvsTotal()
    {
        $query="SELECT 
                       a.persona_idpersona, 
                       max(p.fecha_proceso_postulacion) as fecha_proceso_postulacion,
                       a.rut, 
                       a.apellido_paterno, 
                       a.apellido_materno, 
                       a.nombres, 
                       a.sexo, 
                       a.fecha_nacimiento, 
                       a.direccion, 
                       a.telefono, 
                       a.comuna_idcomuna, 
                       a.categoria, 
                       p.estado, 
                       es.idevaluacion_social, 
                       es.`proceso_postulacion_idproceso_postulacion` 
                       
                       FROM adulto_mayor a, proceso_postulacion p, evaluacion_social es 
                       
                       WHERE a.categoria = 'postulante' 
                       AND p.adulto_mayor_persona_idpersona = a.persona_idpersona 
                       AND p.estado = 'Activo' 
                       AND es.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion 
                       GROUP BY a.rut 
                       ORDER BY `a`.`apellido_paterno` ASC , a.comuna_idcomuna ASC";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulantesListaEspera($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }

  */  
    
/* 
 * -------------------------------------------------------------
 * SELECCIONA TODOS LOS POSTULANTES QUE NO TIENEN EVA.MEDICAS
 * -------------------------------------------------------------
 */    
    
    static public function GetPostulantesConSoloEvs()
    {
        $query="SELECT 
                       a.persona_idpersona, 
                       max(p.fecha_proceso_postulacion) as fecha_proceso_postulacion,
                       a.rut, 
                       a.apellido_paterno, 
                       a.apellido_materno, 
                       a.nombres, 
                       a.sexo, 
                       a.fecha_nacimiento, 
                       a.direccion, 
                       a.telefono, 
                       a.comuna_idcomuna, 
                       a.categoria, 
                       p.estado, 
                       
                       es.idevaluacion_social, 
                       es.`proceso_postulacion_idproceso_postulacion` 
                       
                       FROM adulto_mayor a, proceso_postulacion p, evaluacion_social es 
                       
                       WHERE a.categoria = 'postulante' 
                       AND p.adulto_mayor_persona_idpersona = a.persona_idpersona 
                       AND p.estado = 'Activo' 
                       AND es.proceso_postulacion_idproceso_postulacion = p.idproceso_postulacion 
                       
                       AND
                        NOT EXISTS 
                            (SELECT * FROM  `vista_postulantes_con_evm` 
                             WHERE a.`persona_idpersona` = vista_postulantes_con_evm.`persona_idpersona`)

                       GROUP BY a.rut 
                       ORDER BY `a`.`apellido_paterno` ASC , a.comuna_idcomuna ASC";
        
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        
         if (CDBSingleton::RevisarExito($exito, $query))
         {
               if ($exito->numRows()>0)
               {
                   $aUtilitarios = array();
                   for($i=0; $i<$exito->numRows();$i++)
                   {
                       $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC, $i);
                       $a[$i]=self::CrearPostulantesListaEspera($rs);
                       $aUtilitarios[$i]=$a[$i];
                   }
                   return $aUtilitarios;
               }       
         }      
    }
    
    
    
}
?>