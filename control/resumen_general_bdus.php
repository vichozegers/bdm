<?php

include_once("clases/Comunes/CDBSingleton.php");
include_once("clases/CKatz.php");
include_once ("clases/CAdminKatz.php");
include_once("clases/utilitarios/CAdminUtilitarios.php");

$fecha_actual=date("Y-m-d H:i:s");


$aletras= array(A,B,C,D,E,F,G,H,'');
$katz=array();
//$salud_am=array();

//RECORRE ARREGLO DE LETRAS 
for ($i=0;$i< count($aletras);$i++){

$katz[]=CAdminKatz::GetTotalKatzTipoLetra($aletras[$i]);   

}
         
//CONSULTA SE REALIZA POR SEPARADO RETORNANDO - CANTIDAD POR LETRA.

$salud_amA=CAdminKatz::GetTotalSaludTipoLetra('A');    
$salud_amB=CAdminKatz::GetTotalSaludTipoLetra('B');    
$salud_amC=CAdminKatz::GetTotalSaludTipoLetra('C');
$salud_amD=CAdminKatz::GetTotalSaludTipoLetra('D');
$salud_amE=CAdminKatz::GetTotalSaludTipoLetra('E');
$salud_amF=CAdminKatz::GetTotalSaludTipoLetra('F');
$salud_amG=CAdminKatz::GetTotalSaludTipoLetra('G');
$salud_amH=CAdminKatz::GetTotalSaludTipoLetra('H');
//$salud_amH=CAdminKatz::GetTotalSaludTipoLetra('H');
//SUMA DE VALORES OBTENIDOS DE LA CONSULTA

$Autovalente= $katz[0]+$salud_amA;
$NoValente=$katz[5]+$katz[6]+$salud_amF+$salud_amG;
$SemiValente= $katz[1]+$katz[2]+$katz[3]+$katz[4]+$katz[7]+$salud_amB+$salud_amC+$salud_amD+$salud_amE+$salud_amH;
$SinInformacion=CAdminKatz::GetTotalSinKatz()+$katz[8];

$TotalGeneralSalud=$Autovalente+$NoValente+$SemiValente+$SinInformacion;
//$fecha_actual='52322';
$PorAutovalente=round((($Autovalente*100)/$TotalGeneralSalud), 2, PHP_ROUND_HALF_ODD);
$PorNoValente=round((($NoValente*100)/$TotalGeneralSalud), 2, PHP_ROUND_HALF_ODD);
$PorSemiValente=round((($SemiValente*100)/$TotalGeneralSalud), 2, PHP_ROUND_HALF_ODD);
$PorSinInformacion=round((($SinInformacion*100)/$TotalGeneralSalud), 2, PHP_ROUND_HALF_ODD);
$PorTotal=$PorAutovalente+$PorNoValente+$PorSemiValente+$PorSinInformacion;

//OBTENGO FECHA DE ULTIMO KATZ EN BASE A LA FECHA ACTUAL
$fecha_actual=  date("Y-m-d H:i:s");

$UltimaFechaKatz=CAdminKatz::GetfechaKatz($fecha_actual);

$UltimaFechaKatz=substr($UltimaFechaKatz, 0, 10);


require_once ('../vistas/v_resumen_general_bds.php');

?>
