<?php
require_once("clases/Consultas/CData.php");
require_once("clases/Hogar/CAdminHogar.php");
require_once("clases/Social/CAdminPersonas.php");
require_once("clases/Social/CAdminRelaciones.php");

//Clase Consultas, devuelve solo frecuencias Absolutas (cuantos son)

class CAdminConsultas {
/*******************************************************************************
 * consulta sexo: recibe arreglo con las consultas de los filtros anteriores
 * filtro: masculino, femenino
 * devuelve consultas pre echas
 *******************************************************************************/
    public static function ConsultaSexo($a) {
        if(count($a)>0) {
            $c=count($a);
            $array=array();
            for($i=0; $i<$c; $i++) {
                $data=clone $a[$i];
                $data->addDesde("femenino");
                $data->addWhere(" and sexo=0");
                $array[$i]=$data;
            }
            for($i=0; $i<$c; $i++) {
                $data=clone $a[$i];
                $data->addDesde("masculino");
                $data->addWhere(" and sexo=1");
                $array[$c+$i]=$data;
            }
            return $array;
        }
        else {
            $array=array();
            $array[0]=new CData();
            $array[0]->SetDesde("masculino");
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetWhere("where sexo=1");
            $array[1]=new CData();
            $array[1]->SetDesde("femenino");
            $array[1]->SetSelect("select count(a.persona_idpersona) as c");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetWhere("where sexo=0");
            return $array;
        }
    }
    /****************************************************************************************
     * consulta por edad: -$a = recibe arreglo con las consultas de los filtros anteriores
     *                    -$n = tamaño del intervalo de las edades
     * devuelve consultas pre echas
     ****************************************************************************************/
    public static function ConsultaEdad($a, $n) {
        if($n>0) {
            if(count($a)>0) {
                $array=array();
                for($i=0; $i<count($a); $i++) {
                    $y=date("Y");
                    $md=date("m-d");
                    $y-=120;
                    $y2=$y+$n;
                    for($j=0; $y<date("Y")-60; $j++, $y+=$n, $y2+=$n) {
                        $data=clone $a[$i];
                        $data->addDesde("".$y."-".$md.",".$y2."-".$md);
                        $data->addWhere(" and fecha_deseso is null and (fecha_nacimiento > '".$y."-".$md."' and fecha_nacimiento < '".$y2."-".$md."')");
                        $array[count($array)]=$data;
                    //echo count($array)."<br>";
                    }
                }
                return $array;
            }
            else {
                $y=date("Y");
                $md=date("m-d");
                $y-=120;
                $y2=$y+$n;
                $array=array();
                for($i=0; $y<date("Y")-60; $i++, $y+=$n, $y2+=$n) {
                    $array[$i]=new CData();
                    $array[$i]->SetDesde($y."-".$md.",".$y2."-".$md);
                    $array[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                    $array[$i]->SetFrom("from adulto_mayor as a");
                    $array[$i]->SetWhere("where fecha_deseso is null and (fecha_nacimiento > '".$y."-".$md."' and fecha_nacimiento < '".$y2."-".$md."')");
                }
                return $array;
            }
        }
        else {
            if(count($a)>0) {
                $array=array();
                for($i=0; $i<count($a); $i++) {
                    $y=date("Y");
                    $md=date("m-d");
                    $y-=120;
                    $y2=$y+10;
                    for($j=0; $y<date("Y")-60; $j++, $y+=10, $y2+=10) {
                        $data=clone $a[$i];
                        $data->addDesde("".$y."-".$md.",".$y2."-".$md);
                        $data->addWhere(" and fecha_deseso is null and (fecha_nacimiento > '".$y."-".$md."' and fecha_nacimiento < '".$y2."-".$md."')");
                        $array[count($array)]=$data;
                    //echo count($array)."<br>";
                    }
                }
                return $array;
            }
            else {
                $y=date("Y");
                $md=date("m-d");
                $y-=120;
                $y2=$y+10;
                $array=array();
                for($i=0; $y<date("Y")-60; $i++, $y+=10, $y2+=10) {
                    $array[$i]=new CData();
                    $array[$i]->SetDesde("".$y."-".$md.",".$y2."-".$md);
                    $array[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                    $array[$i]->SetFrom("from adulto_mayor as a");
                    $array[$i]->SetWhere("where fecha_deseso is null and (fecha_nacimiento > '".$y."-".$md."' and fecha_nacimiento < '".$y2."-".$md."')");
                }
                return $array;
            }
        }
    }
    /****************************************************************************************
     * consulta por edad: -$a   = recibe arreglo con las consultas de los filtros anteriores
     *                    -$cat = categoria de los AM (postulante, residente o ambos)
     * devuelve consultas pre echas
     ****************************************************************************************/
    public static function ConsultaCategoria($a, $cat) {
        if(count($a)>0) {
            if(strcmp($cat,"postulante")==0) {
                for($i=0;$i<count($a); $i++) {
                    $a[$i]->addDesde("postulante");
                    $a[$i]->addWhere(" and (categoria='postulante' and hogar_lugar_idlugar is null)");
                }
            }
            else if(strcmp($cat,"residente")==0) {
                    for($i=0;$i<count($a); $i++) {
                        $a[$i]->addDesde("residente");
                        $a[$i]->addWhere(" and categoria='residente'");
                    }
                }
                else {
                    for($i=0;$i<count($a); $i++) {
                        $a[$i]->addDesde("ambos");
                        $a[$i]->addWhere(" and (categoria='residente' or (categoria='postulante' and hogar_lugar_idlugar is null))");
                    }
                }
            return $a;
        }
        else {
            $array=array();
            if(strcmp($cat,"postulante")==0) {
                $array[0]=new CData();
                $array[0]->SetDesde("postulante");
                $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
                $array[0]->SetFrom("from adulto_mayor as a");
                $array[0]->SetWhere("where (categoria='postulante' and hogar_lugar_idlugar is null)");
            }
            else if(strcmp($cat,"residente")==0) {
                    $array[0]=new CData();
                    $array[0]->SetDesde("residente");
                    $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
                    $array[0]->SetFrom("from adulto_mayor as a");
                    $array[0]->SetWhere("where categoria='residente'");
                }
                else {
                    $array[0]=new CData();
                    $array[0]->SetDesde("ambos");
                    $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
                    $array[0]->SetFrom("from adulto_mayor as a");
                    $array[0]->SetWhere("where (categoria='residente' or (categoria='postulante' and hogar_lugar_idlugar is null))");
                }
            return $array;
        }
    }

    /***************************************************************************
     * 
     * 
     * 
     ***************************************************************************/

    public static function addHogar($array, $hogar) {
        if(count($array)>0 && strcmp($hogar,"")!=0) {
            $id=$hogar;
            if($id>0) {
                for($i=0; $i<count($array); $i++) {
                    $array[$i]->addWhere(" and (hogar_lugar_idlugar=".$id.")");
                }

            }
        }
        return $array;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

    public static function ConsultaECivil($array) {
        $rs=array();
        $aux=CAdminPersonas::GetEstadoCivilCB();
        if(count($array)>0) {
            for($i=0; $i<count($aux); $i++) {
                for($j=0; $j<count($array); $j++) {
                    $data=clone($array[$j]);
                    $data->addDesde($aux[$i]);
                    $data->addWhere(" and (estado_civil_idestado_civil=".CAdminPersonas::GetEstadoCivilId($aux[$i]).")");
                    $rs[count($rs)]=$data;
                }
            }
        }
        else {
            for($i=0; $i<count($aux); $i++) {
                $rs[$i]=new CData();
                $rs[$i]->SetDesde($aux[$i]);
                $rs[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                $rs[$i]->SetFrom("from adulto_mayor as a");
                $rs[$i]->SetWhere("where (estado_civil_idestado_civil=".CAdminPersonas::GetEstadoCivilId($aux[$i]).")");
            }
        }
        return $rs;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

    public static function ConsultaApoderado($a) {
        $array= array();
        if(count($a)>0) {
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con apoderado");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Apoderado')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("sin apoderado");
                $data->addWhere(" and (persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Apoderado')."))");
                $array[count($array)]=$data;
            }
        }else {
            $array[0]=new CData();
            $array[0]->SetDesde("con apoderado");
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetWhere("where (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Apoderado')."))");
            $array[1]=new CData();
            $array[1]->SetDesde("sin apoderado");
            $array[1]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetWhere("where (persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Apoderado')."))");
        }
        return $array;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

    public static function ConsultaHijos($a) {
        $array= array();
        if(count($a)>0) {
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con hijos");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hijo').") or persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas = ".CAdminRelaciones::GetRelacionId('Hijo')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("sin hijos");
                $data->addWhere(" and (persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hijo').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Hijo')."))");
                $array[count($array)]=$data;
            }
        }else {
            $array[0]=new CData();
            $array[0]->SetDesde("con hijos");
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetWhere("where (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hijo').") or persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas = ".CAdminRelaciones::GetRelacionId('Hijo')."))");
            $array[1]=new CData();
            $array[1]->SetDesde("sin apoderado");
            $array[1]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetWhere("where (persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hijo').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Hijo')."))");
        }
        return $array;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/


    public static function ConsultaTenenciaVivienda($array) {
        $rs=array();
        $aux=CAdminCombobox::GetTenenciaViviendaCB();
        if(count($array)>0) {
            for($i=0; $i<count($aux); $i++) {
                for($j=0; $j<count($array); $j++) {
                    $data=clone($array[$j]);
                    $data->addDesde($aux[$i]);
                    $data->addWhere(" and (persona_idpersona IN (select adulto_mayor_persona_idpersona from proceso_postulacion where idproceso_postulacion IN (select proceso_postulacion_idproceso_postulacion from evaluacion_social where tenencia_vivienda_idtenencia_vivienda=".CAdminCombobox::GetTenenciaViviendaId($aux[$i]).")))");
                    $rs[count($rs)]=$data;
                }
            }
        }
        else {
            for($i=0; $i<count($aux); $i++) {
                $rs[$i]=new CData();
                $rs[$i]->SetDesde($aux[$i]);
                $rs[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                $rs[$i]->SetFrom("from adulto_mayor as a");
                $rs[$i]->SetWhere("where (persona_idpersona IN (select adulto_mayor_persona_idpersona from proceso_postulacion where idproceso_postulacion IN (select proceso_postulacion_idproceso_postulacion from evaluacion_social where tenencia_vivienda_idtenencia_vivienda=".CAdminCombobox::GetTenenciaViviendaId($aux[$i]).")))");
            }
        }
        return $rs;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

    public static function ConsultaFamiliares($a) {
        $array= array();
        if(count($a)>0) {
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con nieto");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nieto')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con hermano");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hermano')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con sobrino");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Sobrino')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con conyuge");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cónyuge')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con cuñado");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cuñado')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con nuera");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nuera')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con yerno");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Yerno')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con otro");
                $data->addWhere(" and (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Otro')."))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("sin familiares");
                $data->addWhere(" and (persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Otro').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Yerno').") and
                persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nuera').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cuñado').") and
                persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cónyugue').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Sobrino').") and
                persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hermano').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nieto')."))");
                $array[count($array)]=$data;
            }
        }else {
            $array[0]=new CData();
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetDesde("con nieto");
            $array[0]->SetWhere(" where (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nieto')."))");

            $array[1]=new CData();
            $array[1]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetDesde("con hermano");
            $array[1]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hermano')."))");

            $array[2]=new CData();
            $array[2]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[2]->SetFrom("from adulto_mayor as a");
            $array[2]->SetDesde("con sobrino");
            $array[2]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Sobrino')."))");

            $array[3]=new CData();
            $array[3]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[3]->SetFrom("from adulto_mayor as a");
            $array[3]->SetDesde("con conyuge");
            $array[3]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cónyuge')."))");

            $array[4]=new CData();
            $array[4]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[4]->SetFrom("from adulto_mayor as a");
            $array[4]->SetDesde("con cuñado");
            $array[4]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cuñado')."))");

            $array[5]=new CData();
            $array[5]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[5]->SetFrom("from adulto_mayor as a");
            $array[5]->SetDesde("con nuera");
            $array[5]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nuera')."))");

            $array[6]=new CData();
            $array[6]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[6]->SetFrom("from adulto_mayor as a");
            $array[6]->SetDesde("con yerno");
            $array[6]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Yerno')."))");

            $array[7]=new CData();
            $array[7]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[7]->SetFrom("from adulto_mayor as a");
            $array[7]->SetDesde("con otro");
            $array[7]->SetWhere(" where (persona_idpersona  IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Otro')."))");

            $array[8]=new CData();
            $array[8]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[8]->SetFrom("from adulto_mayor as a");
            $array[8]->SetDesde("sin familiares");
            $array[8]->SetWhere(" where (persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Otro').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Yerno').") and
                persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nuera').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cuñado').") and
                persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Cónyugue').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Sobrino').") and
                persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Hermano').") and persona_idpersona NOT IN ( SELECT adulto_mayor_persona_idpersona FROM relaciones_personas WHERE tipo_relaciones_personas_idtipo_relaciones_personas =".CAdminRelaciones::GetRelacionId('Familiar - Nieto')."))");
        }
        return $array;
    }
    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

    public static function ConsultaIngresos($array, $rango) {
        $rs=array();
        if($rango<=0)
            $rango=100000;
        $aux=self::rango($rango);
        if(count($array)>0) {
            for($i=0; $i<count($aux); $i++) {
                for($j=0; $j<count($array); $j++) {
                    if($i==0) {
                        $data=clone($array[$j]);
                        $data->addDesde("Ingresos <= ".$aux[$i]);
                        $data->addWhere(" and (persona_idpersona in (select id from pensiones_descuentos where (pension - monto<=".$aux[$i].") or (monto is null and pension<=".$aux[$i].")))");
                        $rs[count($rs)]=$data;
                    }
                    elseif($i==count($aux)-1) {
                        $data=clone($array[$j]);
                        $data->addDesde("Ingresos > ".$aux[$i-1]);
                        $data->addWhere(" and (persona_idpersona in (select id from pensiones_descuentos where (pension - monto >".$aux[$i-1].") or (monto is null and pension >".$aux[$i-1].")))");
                        $rs[count($rs)]=$data;
                    }
                    else {
                        $data=clone($array[$j]);
                        $data->addDesde($aux[$i-1]."< Ingresos <=".$aux[$i]);
                        $data->addWhere(" and (persona_idpersona in (select id from pensiones_descuentos where (pension - monto >".$aux[$i-1]." and pension-monto<=".$aux[$i].") or (monto is null and pension >".$aux[$i-1]." and pension <= ".$aux[$i].")))");
                        $rs[count($rs)]=$data;
                    }
                }
            }
        }
        else {

            for($i=0; $i<count($aux); $i++) {
                if($i==0) {
                    $rs[$i]=new CData();
                    $rs[$i]->SetDesde("Ingresos <= ".$aux[$i]);
                    $rs[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                    $rs[$i]->SetFrom("from adulto_mayor as a");
                    $rs[$i]->SetWhere("where (persona_idpersona in (select id from pensiones_descuentos where (pension - monto<=".$aux[$i].") or (monto is null and pension<=".$aux[$i].")))");
                }
                elseif($i==count($aux)-1) {
                    $rs[$i]=new CData();
                    $rs[$i]->SetDesde("Ingresos > ".$aux[$i-1]);
                    $rs[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                    $rs[$i]->SetFrom("from adulto_mayor as a");
                    $rs[$i]->SetWhere("where (persona_idpersona in (select id from pensiones_descuentos where (pension - monto >".$aux[$i-1].") or (monto is null and pension >".$aux[$i-1].")))");
                }
                else {
                    $rs[$i]=new CData();
                    $rs[$i]->SetDesde($aux[$i-1]."< Ingresos <=".$aux[$i]);
                    $rs[$i]->SetSelect("select count(a.persona_idpersona) as c ");
                    $rs[$i]->SetFrom("from adulto_mayor as a");
                    $rs[$i]->SetWhere("where (persona_idpersona in (select id from pensiones_descuentos where (pension - monto >".$aux[$i-1]." and pension-monto<=".$aux[$i].") or (monto is null and pension >".$aux[$i-1]." and pension <= ".$aux[$i].")))");
                }
            }
        }
        return $rs;
    }

    /***************************************************************************
     *
     *
     *
     *
     ***************************************************************************/

    public static function ConsultaEstado($a) {
        $array= array();
        if(count($a)>0) {
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con Evaluacion Social");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM proceso_postulacion WHERE idproceso_postulacion in (SELECT proceso_postulacion_idproceso_postulacion FROM evaluacion_social)))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con Visita Domiciliaria");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM proceso_postulacion WHERE idproceso_postulacion NOT IN (SELECT proceso_postulacion_idproceso_postulacion FROM evaluacion_social WHERE visita_domiciliaria IS NULL OR visita_domiciliaria='')))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("con Evaluacion Medica");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM proceso_postulacion WHERE idproceso_postulacion in (SELECT proceso_postulacion_idproceso_postulacion FROM evaluacion_medica)))");
                $array[count($array)]=$data;
            }
        }else {

            $array[0]=new CData();
            $array[0]->SetDesde("con Evaluacion Social");
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetWhere(" where (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM proceso_postulacion WHERE idproceso_postulacion in (SELECT proceso_postulacion_idproceso_postulacion FROM evaluacion_social)))");

            $array[1]=new CData();
            $array[1]->SetDesde("con Visita Domiciliaria");
            $array[1]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetWhere(" where (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM proceso_postulacion WHERE idproceso_postulacion NOT IN (SELECT proceso_postulacion_idproceso_postulacion FROM evaluacion_social WHERE visita_domiciliaria IS NULL OR visita_domiciliaria='')))");

            $array[2]=new CData();
            $array[2]->SetDesde("con Evaluacion Medica");
            $array[2]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[2]->SetFrom("from adulto_mayor as a");
            $array[2]->SetWhere(" where (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM proceso_postulacion WHERE idproceso_postulacion in (SELECT proceso_postulacion_idproceso_postulacion FROM evaluacion_medica)))");
        }
        return $array;
    }

    /***************************************************************************
     *
     *falta seleccionar el ultimo
     *
     *
     ***************************************************************************/

    public static function ConsultaKatz($a) {
        $array= array();
        if(count($a)>0) {
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz A");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='A'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz B");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='B'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz C");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='C'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz D");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='D'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz E");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='E'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz F");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='F'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz G");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='G'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Katz H");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='H'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Sin Katz");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE katz='X'))");
                $array[count($array)]=$data;
            }
        }else {

            $array[0]=new CData();
            $array[0]->SetDesde("Katz A");
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='A'))");

            $array[1]=new CData();
            $array[1]->SetDesde("Katz B");
            $array[1]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='B'))");

            $array[2]=new CData();
            $array[2]->SetDesde("Katz C");
            $array[2]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[2]->SetFrom("from adulto_mayor as a");
            $array[2]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='C'))");

            $array[3]=new CData();
            $array[3]->SetDesde("Katz D");
            $array[3]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[3]->SetFrom("from adulto_mayor as a");
            $array[3]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='D'))");

            $array[4]=new CData();
            $array[4]->SetDesde("Katz E");
            $array[4]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[4]->SetFrom("from adulto_mayor as a");
            $array[4]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='E'))");

            $array[5]=new CData();
            $array[5]->SetDesde("Katz F");
            $array[5]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[5]->SetFrom("from adulto_mayor as a");
            $array[5]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='F'))");

            $array[6]=new CData();
            $array[6]->SetDesde("Katz G");
            $array[6]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[6]->SetFrom("from adulto_mayor as a");
            $array[6]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='G'))");

            $array[7]=new CData();
            $array[7]->SetDesde("Sin Katz");
            $array[7]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[7]->SetFrom("from adulto_mayor as a");
            $array[7]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where katz='X' or katz is null))");
        }
        return $array;
    }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/

     public static function ConsultaHogarRequerido($a)
     {
         $array= array();
        if(count($a)>0) {
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Estandar");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE psicoge='estandar'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("C. E. Geriatrico");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE psicoge='ce_geriatrico'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("C. E. Psicogeriatrico");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE psicoge='ce_psicogeriatrico'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("No Admitido");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE psicoge='no admitir'))");
                $array[count($array)]=$data;
            }
            for($i=0; $i<count($a); $i++) {
                $data=clone($a[$i]);
                $data->addDesde("Sin Evaluacion");
                $data->addWhere(" and (persona_idpersona IN ( SELECT adulto_mayor_persona_idpersona FROM consulta_salud WHERE psicoge is null))");
                $array[count($array)]=$data;
            }
        }
        else
        {
            $array[0]=new CData();
            $array[0]->SetDesde("Estandar");
            $array[0]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[0]->SetFrom("from adulto_mayor as a");
            $array[0]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where psicoge='estandar'))");

            $array[1]=new CData();
            $array[1]->SetDesde("C. E. Geriatrico");
            $array[1]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[1]->SetFrom("from adulto_mayor as a");
            $array[1]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where psicoge='ce_geriatrico'))");

            $array[2]=new CData();
            $array[2]->SetDesde("C. E. Psicogeriatrico");
            $array[2]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[2]->SetFrom("from adulto_mayor as a");
            $array[2]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where psicoge='ce_psicogeriatrico'))");

            $array[3]=new CData();
            $array[3]->SetDesde("No Admitido");
            $array[3]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[3]->SetFrom("from adulto_mayor as a");
            $array[3]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where psicoge='no admitir'))");

            $array[4]=new CData();
            $array[4]->SetDesde("Sin Evaluacion");
            $array[4]->SetSelect("select count(a.persona_idpersona) as c ");
            $array[4]->SetFrom("from adulto_mayor as a");
            $array[4]->SetWhere(" where (persona_idpersona IN (select adulto_mayor_persona_idpersona from consulta_salud where psicoge is null))");
        }
        return $array;
     }

    /***************************************************************************
     *
     *
     *
     ***************************************************************************/
    public static function GetResultados($array) {
        $rs=array();
        for($i=0; $i<count($array); $i++) {
            $a=$array[$i];
            $aux=$a->GetAux();
            if(strcmp($a->GetPrincipal(), "edad")==0) {
                $rs=self::ConsultaEdad($rs, $aux);
            }
            elseif(strcmp($a->GetPrincipal(), "categoria")==0) {
                $rs=self::ConsultaCategoria($rs, $aux[0]);
                if(count($aux)>1) {
                    $rs=self::addHogar($rs, $aux[1]);
                }
            }
            elseif(strcmp($a->GetPrincipal(), "sexo")==0) {
                $rs=self::ConsultaSexo($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "ecivil")==0) {
                $rs=self::ConsultaECivil($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "apoderado")==0) {
                $rs=self::ConsultaApoderado($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "hijos")==0) {
                $rs=self::ConsultaHijos($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "tenencia")==0) {
                $rs=self::ConsultaTenenciaVivienda($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "familia")==0) {
                $rs=self::ConsultaFamiliares($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "ingresos")==0) {
                $rs=self::ConsultaIngresos($rs, $aux);
            }
            elseif(strcmp($a->GetPrincipal(), "estado")==0) {
                $rs=self::ConsultaEstado($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "katz")==0) {
                $rs=self::ConsultaKatz($rs);
            }
            elseif(strcmp($a->GetPrincipal(), "hogar_requerido")==0) {
                $rs=self::ConsultaHogarRequerido($rs);
            }
        }
        $resultados=array();
        $con=CDBSingleton::GetConn();
        for($i=0; $i<count($rs); $i++) {
            $exito=$con->query($rs[$i]->GetQuery());
            if(CDBSingleton::RevisarExito($exito, $rs[$i]->GetQuery())) {
                $resul=$exito->fetchrow(DB_FETCHMODE_ASSOC);
                $rs[$i]->SetResultado($resul['c']);
            }
        }
        return $rs;
    }

    private static function rango($s) {
        $query="select min(pension) as min from pensiones_descuentos";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);
        if(!CDBSingleton::RevisarExito($exito, $query)) {
            return -1;
        }
        $rs1=$exito->fetchrow(DB_FETCHMODE_ASSOC);
        $query="select max(pension) as max from pensiones_descuentos";
        $exito=$con->query($query);
        if(!CDBSingleton::RevisarExito($exito, $query)) {
            return -2;
        }
        $rs2=$exito->fetchrow(DB_FETCHMODE_ASSOC);
        $aux=$rs1['min'];
        $a=Array();
        for($i=0; $aux<$rs2['max']; $i++) {
            $aux+=$s;
            $a[$i]=$aux;
        }
        return $a;
    }


    public static function GetDetallexSistemaSalud($idss) {
        $query="SELECT count(persona_idpersona)as cantidad FROM residentes
                    WHERE residentes.sistema_salud_idsistema_salud=".$idss."
                    and categoria='residente'";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query)) {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                {
                    $a[0] = self::GetNombreSistemaSalud($idss);
                    $a[1] = $rs['cantidad'];
                    return $a;
                }
            }
    }

    public static function GetDetallexSistemaSaludxFecha($idss, $fecha) {
        $query="SELECT count(adulto_mayor.persona_idpersona) as cantidad
                FROM adulto_mayor
                LEFT OUTER JOIN eventos
                ON eventos.adulto_mayor_persona_idpersona = adulto_mayor.persona_idpersona
                WHERE
                (
                    adulto_mayor.categoria = 'residente'
                    and eventos.ideventos is NULL
                )
                OR
                (
                    (eventos.tipo = 'ingreso' OR eventos.tipo = 'traslado')
and adulto_mayor.sistema_salud_idsistema_salud = ".$idss."
                    AND eventos.fecha_realizacion <= '".$fecha."'
                    AND (adulto_mayor.fecha_deseso >= '".$fecha."' or adulto_mayor.fecha_deseso is NULL)
                    AND (SELECT max(e5.fecha_realizacion) FROM eventos AS e5 WHERE e5.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona and (e5.tipo='traslado'  or e5.tipo='ingreso' or e5.tipo='egreso')) =eventos.fecha_realizacion
                )
                OR
                (
                    (eventos.tipo = 'egreso' OR eventos.tipo = 'traslado')
and adulto_mayor.sistema_salud_idsistema_salud = ".$idss."
                    AND eventos.fecha_realizacion >= '".$fecha."'
                    AND
                    (
                        (SELECT max(e2.fecha_realizacion) FROM eventos AS e2 WHERE e2.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona AND e2.fecha_realizacion <= eventos.fecha_realizacion AND e2.ideventos<>eventos.ideventos and (e2.tipo='traslado'  or e2.tipo='ingreso')) <='".$fecha."'
                        OR
                        (SELECT max(e4.fecha_realizacion) FROM eventos AS e4 WHERE e4.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona AND e4.fecha_realizacion <= eventos.fecha_realizacion AND e4.ideventos<>eventos.ideventos and (e4.tipo='traslado' or e4.tipo='ingreso')) <='".$fecha."'
                        OR
                        (SELECT max(e3.fecha_realizacion) FROM eventos AS e3 WHERE e3.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona AND e3.fecha_realizacion <= eventos.fecha_realizacion AND e3.ideventos<>eventos.ideventos AND (e3.tipo='ingreso' or e3.tipo='traslado')) is NULL
                    )
                    AND (adulto_mayor.fecha_deseso >= '".$fecha."' or adulto_mayor.fecha_deseso is NULL or adulto_mayor.fecha_deseso ='0000-00-00')
                )";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query)) {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                {
                    $a[0] = self::GetNombreSistemaSalud($idss);
                    $a[1] = $rs['cantidad'];
                    return $a;
                }
            }
    }

    public static function GetDetallexPrevision($idp) {
        $query="SELECT count(idprevision)as cantidad FROM prevision
                    INNER JOIN residentes WHERE
                    residentes.persona_idpersona = prevision.adulto_mayor_persona_idpersona and
                    prevision.prevision_prevision_idprevision_prevision=".$idp."
                    and residentes.categoria='residente'";
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query)) {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                {
                    $a[0] = self::GetNombrePrevision($idp);
                    $a[1] = $rs['cantidad'];
                    return $a;
                }
            }
    }

    public static function GetDetallexPensionxFecha($idp, $fecha) {

        $query="SELECT count(p.idpension) as cantidad
                FROM ".Configuracion::$BD_eclesiastico.".pension p INNER JOIN ".Configuracion::$BD_BDU.".adulto_mayor a on a.persona_idpersona= p.idam
                LEFT OUTER JOIN ".Configuracion::$BD_BDU.".eventos e
                ON e.adulto_mayor_persona_idpersona = a.persona_idpersona
                WHERE
                (
                    a.categoria = 'residente'
                    and e.ideventos is NULL
                )
                OR
                (
                    (e.tipo = 'ingreso' OR e.tipo = 'traslado') and
                    a.persona_idpersona = p.idam and
                    p.prevision_idprevision=".$idp."
                    AND e.fecha_realizacion <= '".$fecha."'
                    AND (a.fecha_deseso >= '".$fecha."' or a.fecha_deseso is NULL)
                    AND (SELECT max(e5.fecha_realizacion) FROM ".Configuracion::$BD_BDU.".eventos AS e5 WHERE e5.adulto_mayor_persona_idpersona = e.adulto_mayor_persona_idpersona and (e5.tipo='traslado'  or e5.tipo='ingreso' or e5.tipo='egreso')) =e.fecha_realizacion
                )
                OR
                (
                    (e.tipo = 'egreso' OR e.tipo = 'traslado') and
                    a.persona_idpersona = p.idam and
                    p.prevision_idprevision=".$idp."
                    AND e.fecha_realizacion >= '".$fecha."'
                    AND
                    (
                        (SELECT max(e2.fecha_realizacion) FROM ".Configuracion::$BD_BDU.".eventos AS e2 WHERE e2.adulto_mayor_persona_idpersona = e.adulto_mayor_persona_idpersona AND e2.fecha_realizacion <= e.fecha_realizacion AND e2.ideventos<>e.ideventos and (e2.tipo='traslado'  or e2.tipo='ingreso')) <='".$fecha."'
                        OR
                        (SELECT max(e4.fecha_realizacion) FROM ".Configuracion::$BD_BDU.".eventos AS e4 WHERE e4.adulto_mayor_persona_idpersona = e.adulto_mayor_persona_idpersona AND e4.fecha_realizacion <= e.fecha_realizacion AND e4.ideventos<>e.ideventos and (e4.tipo='traslado' or e4.tipo='ingreso')) <='".$fecha."'
                        OR
                        (SELECT max(e3.fecha_realizacion) FROM ".Configuracion::$BD_BDU.".eventos AS e3 WHERE e3.adulto_mayor_persona_idpersona = e.adulto_mayor_persona_idpersona AND e3.fecha_realizacion <= e.fecha_realizacion AND e3.ideventos<>e.ideventos AND (e3.tipo='ingreso' or e3.tipo='traslado')) is NULL
                    )
                    AND (a.fecha_deseso >= '".$fecha."' or a.fecha_deseso is NULL or a.fecha_deseso ='0000-00-00')
                )";

        //print_r($query);
        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query)) {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                {
                    $a[0] = CAdminComboboxEclesiastico::GetPrevisionNombre($idp);
                    $a[1] = $rs['cantidad'];
                    return $a;
                }
            }
    }


      public static function GetNumResidentesxFecha($fecha) {

        $query="SELECT count(distinct adulto_mayor.persona_idpersona) as cantidad
                FROM adulto_mayor
                LEFT OUTER JOIN eventos
                ON eventos.adulto_mayor_persona_idpersona = adulto_mayor.persona_idpersona
                WHERE
                (
                    (eventos.tipo = 'ingreso' OR eventos.tipo = 'traslado')

                    AND eventos.fecha_realizacion <= '".$fecha."'
                    AND (adulto_mayor.fecha_deseso >= '".$fecha."' or adulto_mayor.fecha_deseso is NULL)
                    AND (SELECT max(e5.fecha_realizacion) FROM eventos AS e5 WHERE e5.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona and (e5.tipo='traslado'  or e5.tipo='ingreso' or e5.tipo='egreso')) =eventos.fecha_realizacion
                )
                OR
                (
                    (eventos.tipo = 'egreso' OR eventos.tipo = 'traslado')

                    AND eventos.fecha_realizacion >= '".$fecha."'
                    AND
                    (
                        (SELECT max(e2.fecha_realizacion) FROM eventos AS e2 WHERE e2.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona AND e2.fecha_realizacion <= eventos.fecha_realizacion AND e2.ideventos<>eventos.ideventos and (e2.tipo='traslado'  or e2.tipo='ingreso')) <='".$fecha."'
                        OR
                        (SELECT max(e4.fecha_realizacion) FROM eventos AS e4 WHERE e4.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona AND e4.fecha_realizacion <= eventos.fecha_realizacion AND e4.ideventos<>eventos.ideventos and (e4.tipo='traslado' or e4.tipo='ingreso')) <='".$fecha."'
                        OR
                        (SELECT max(e3.fecha_realizacion) FROM eventos AS e3 WHERE e3.adulto_mayor_persona_idpersona = eventos.adulto_mayor_persona_idpersona AND e3.fecha_realizacion <= eventos.fecha_realizacion AND e3.ideventos<>eventos.ideventos AND (e3.tipo='ingreso' or e3.tipo='traslado')) is NULL
                    )
                    AND (adulto_mayor.fecha_deseso >= '".$fecha."' or adulto_mayor.fecha_deseso is NULL or adulto_mayor.fecha_deseso ='0000-00-00')
                )";


        $con=CDBSingleton::GetConn();
        $exito=$con->query($query);

        if(CDBSingleton::RevisarExito($exito, $query)) {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                {
                    return $rs['cantidad'];
                }
            }
    }

    static public function GetNombreSistemaSalud($idss)
    {
        $conn=CDBSingleton::GetConn();
        $query="select nombre from sistema_salud WHERE idsistema_salud='".utf8_decode($idss)."'";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return $rs['nombre'];

        }
        return 'null';
    }

    static public function GetNombrePrevision($idp)
    {
        $conn=CDBSingleton::GetConn();
        $query="select nombre from prevision_prevision WHERE idprevision_prevision='".utf8_decode($idp)."'";
        $exito=$conn->query($query);
        if(CDBSingleton::RevisarExito($exito, $query))
        {
            $rs=$exito->fetchrow(DB_FETCHMODE_ASSOC);
            if($rs)
                return $rs['nombre'];

        }
        return 'null';
    }


}
?>