<?php
include_once("header.php");
include_once("clases/Hogar/CAdminHogar.php");
include_once("clases/Hogar/CHogar.php");
include_once("clases/Residentes/CAdminResidentes.php");
include_once("clases/Social/CAdminPersonas.php");

if(!isset($_SESSION["logged_in"])){
    header("Location: ../index.php");
}

     //VALOR HOGAR
if($_POST['hogar']>-1) //and $_POST['hogar']<60   
{
    $id=$_POST['hogar'];
    //NO SE UTILIZA RETORNO LOS MISMOS VALORES
   // $hogarX=CAdminHogar::GetIdLugarHogar($id);
    //$hogar=CAdminHogar::GetHogares('numero' ,$hogarX);
   $hogar=CAdminHogar::GetHogar($id);
   
 
   $capacidad_fem  =   $hogar->GetCapacidad_valentes_mujeres()+
                       $hogar->GetCapacidad_semivalentes_mujeres()+
                       $hogar->GetCapacidad_novalentes_mujeres();
   
  
   $capacidad_masc=    $hogar->GetCapacidad_valentes_hombre()+
                        $hogar->GetCapacidad_semivalentes_hombre()+
                        $hogar->GetCapacidad_novalentes_hombre();
  
   $capacidad= $capacidad_fem+$capacidad_masc;
   
   $emergencia = $capacidad -CAdminResidentes::GetNumResidentesXHogar($id);
   
   //HOGAR
  $registro=$_POST['hogar'];
     
 }
 
           //HOGAR
 elseif ($_POST['hogar']==-1) {
         $registro=-1;

}


elseif($_POST['hogar']>50)
    
{
    
  $registro=200;
    
    
   $ing_adm=CAdminPersonas::GetNumIngAdm();
$post=CAdminPersonas::GetNumPostulantes();
$hogares=CAdminHogar::GetListaTodosHogares();

// Residentes
$subtresidentes=CAdminResidentes::GetNumResidentes();
$totalResMetropolitana=CAdminResidentes::GetNumResidentesmetropolitana();
$totalResRegion=CAdminResidentes::GetNumResidentesRegiones();

// hogares
$totalHogarmetropolitana=CAdminHogar::GetNumHogarMetropolitana();
$totalHogarRegion=CAdminHogar::GetNumHogarRegiones();


//nulos
$totalResidentesNull=CAdminResidentes::GetNumResidentesNull();

$totalResNullMetropolitana=CAdminResidentes::GetNumResidentesNULLMetropolitana();

$totalResNullRegion=CAdminResidentes::GetNumResidentesNULLRegiones();
//

$res=array();
$res_masc=array(); // residentes masculinos
$res_fem=array(); // residentes femeninos

$capacidad=array();
$vacantes=array();
$emergencia=array();
$emergenciaregion=array();
$emergencia_metropolitana=array();
$vacantes_masc=array();
$vacantes_fem=array();
$capacidad_masc=array();
$capacidad_fem=array();

$xtot_capacidad_reg    = 0;
$xtot_capacidad_metro  = 0;
$xtot_sobrecupo_reg    = 0;
$xtot_sobrecupo_metro  = 0;
$xtot_residentes_reg   = 0;
$xtot_residentes_metro = 0;
$xtot_vacantes_reg     = 0;
$xtot_vacantes_metro   = 0;

$totalVacantesRegiones      = 0;
$totalVacantesMetropolitana = 0;


for($i=0; $i<count($hogares); $i++) {

    $hogaresx=CAdminHogar::GetLugar($hogares[$i]->GetIdHogar());
    
    // $xidlugar=CAdminHogar::GetNumeroIdLugar($hogaresx[0]->GetNumeroHogar());
    $xidlugar=$hogaresx[0]->GetIdHogar();
     
    // $xcantxhogar = CAdminResidentes::GetNumResidentesXHogar($xidlugar);
    $xcantxhogar = CAdminResidentes::GetNumResidentesXHogar($xidlugar);
             
    $xregion= CAdminLocalidades::GetRegionNombre($hogaresx[0]->GetComuna_idcomuna());


    $res[$i]=CAdminResidentes::GetNumResidentesXHogar($hogares[$i]->GetIdHogar());
    $res_masc[$i]=CAdminResidentes::GetNumResidentesXHogarMasculino($hogares[$i]->GetIdHogar());
    $res_fem[$i]=CAdminResidentes::GetNumResidentesXHogarFemenino($hogares[$i]->GetIdHogar());
    
    $capacidad[$i]=$hogaresx[0]->GetCapacidad_valentes_hombre()+$hogaresx[0]->GetCapacidad_valentes_mujeres()+
              $hogaresx[0]->GetCapacidad_semivalentes_hombre()+$hogaresx[0]->GetCapacidad_semivalentes_mujeres()+
              $hogaresx[0]->GetCapacidad_novalentes_hombre()+$hogaresx[0]->GetCapacidad_novalentes_mujeres();

    
    $capacidad_masc[$i]=$hogaresx[0]->GetCapacidad_valentes_hombre()+
                        $hogaresx[0]->GetCapacidad_semivalentes_hombre()+
                        $hogaresx[0]->GetCapacidad_novalentes_hombre();

    $capacidad_fem[$i]=$hogaresx[0]->GetCapacidad_valentes_mujeres()+
                       $hogaresx[0]->GetCapacidad_semivalentes_mujeres()+
                       $hogaresx[0]->GetCapacidad_novalentes_mujeres();

    
    $subtcapacidad=$subtcapacidad+$capacidad[$i]; //obtengo subtotal capacidad hogar

    //obtengo emergencia
    //Es la diferencia de residentes por hogar y capacidad por hogar

    // Se tienen que generar 3 arreglos diferentes.

    $emergencia[$i]=$capacidad[$i]-$res[$i];     //contiene todos los hogares que tienen diferencia.

    $emergenciaregion[$i]=$capacidad[$i]-$res[$i];
    $emergencia_metropolitana[$i]=$capacidad[$i]-$res[$i];


     // solamente se toman los valores negativos, ya que corresponden a la emergencia.

     if ($emergenciaregion[$i]<0){

             //Para ver lo que tiene.
             //echo $emergenciaregion[$i]."hogar-region".($hogares[$i]->GetIdHogar())."<br>";

             // El método GetNumHogarSobreCupo me devuelve el ID, tantos resultado sean,
             // se guardan en el arreglo emergenciaRegion que contiene la emergencia.

             $emergenciaregion[$i]=CAdminHogar::GetNumHogarSobreCupo($hogares[$i]->GetIdHogar());

             if ($emergenciaregion[$i]==7){
                 $subtemergenciaMetropolitana=$subtemergenciaMetropolitana+$emergencia[$i];;
                 //despues se suman los resultados si region es 7
             }
      }

     if ($emergencia_metropolitana[$i]<0){

             $emergencia_metropolitana[$i]=CAdminHogar::GetNumHogarSobreCupo($hogares[$i]->GetIdHogar());

             if ($emergencia_metropolitana[$i]<>7){
                 $subtemergenciaRegion=$subtemergenciaRegion+$emergencia[$i];;
             }
     }


     if ($emergencia[$i]<0){
         // Corresponde al total de emergencia
         $subtemergencia=$subtemergencia+$emergencia[$i];
     }

    $vacantes[$i]=$capacidad[$i]-$res[$i];

    $subtvacantes=$subtvacantes+$vacantes[$i]; // obtengo subtotal de vacantes
    
    $subtmasculino=$subtmasculino+$res_masc[$i]; // obtengo subtotal de masculino
    $subtfemenino=$subtfemenino+$res_fem[$i]; // obtengo subtotal de masculino

    $vacantes_masc[$i]=$capacidad_masc[$i]-$res_masc[$i];
    $vacantes_fem[$i]=$capacidad_fem[$i]-$res_fem[$i]; 

    $subt_vacantes_masc=$subt_vacantes_masc + $vacantes_masc[$i];
    $subt_vacantes_fem=$subt_vacantes_fem + $vacantes_fem[$i];

    
    if ($xregion=='Metropolitana'){

        $xtot_capacidad_metro  = $xtot_capacidad_metro + $capacidad[$i];
        
        $xtot_sobrecupo_metro  = $xtot_sobrecupo_metro + $subtemergencia;
        
        $xtot_residentes_metro = $xtot_residentes_metro + $xcantxhogar;
        
        $ubicacion[$i]='R.M.';
        
        $totalVacantesMetropolitana = $totalVacantesMetropolitana + $vacantes[$i];
        
    }else{
        
        $xtot_capacidad_reg    = $xtot_capacidad_reg + $capacidad[$i];

        $xtot_sobrecupo_reg    = $xtot_sobrecupo_reg + $subtemergencia;
        
        $xtot_residentes_reg   = $xtot_residentes_reg + $xcantxhogar;
        
        $ubicacion[$i]='Región';
        
        $totalVacantesRegiones = $totalVacantesRegiones + $vacantes[$i];
        
    }
    
}


$porc_rm= round(($xtot_residentes_metro*100)/$totalHogarmetropolitana, 2);
$porc_reg=round(($xtot_residentes_reg*100)/$totalHogarRegion, 2);
$porc_tot=round((($xtot_residentes_metro+$xtot_residentes_reg)*100)/($totalHogarRegion+$totalHogarmetropolitana), 2);
    
    
    
    
//  echo $subtcapacidad.'<br>';
//  echo ($subtemergencia*-1).'<br>';
//  echo $subtmasculino.'<br>';
//  echo $subtfemenino.'<br>';
//  echo $subtresidentes.'<br>';
//  echo $subt_vacantes_masc.'<br>';
//  echo $subt_vacantes_fem.'<br>';
//  echo $subtvacantes.'</br>';
//  
//  
//  echo 'H. Región Metropolitana'.'<br>';
//  
//  
//  echo $xtot_capacidad_metro.'<br>';
//  echo ($subtemergenciaMetropolitana*-1).'<br>';
//  echo $xtot_residentes_metro.'<br>';
//  echo $totalVacantesMetropolitana.'<br>';
//  echo $porc_rm.'<br>';
//    
//    
//   echo 'H. Regiones'.'<br>';
//  
//  
//  echo $xtot_capacidad_reg.'<br>';
//  echo ($subtemergenciaRegion*-1).'<br>';
//  echo $xtot_residentes_reg.'<br>';
//  echo $totalVacantesRegiones.'<br>';
//  echo $porc_reg.'<br>';
//     
//    
   
 
    
}




 $hogares=CAdminHogar::GetHogaresCB();
 
 require_once ('../vistas/v_hogares.php');
  
?>