<?php
include_once("header.php");
include_once("clases/Comunes/CAdminComboboxEclesiastico.php");

if(isset($_REQUEST['id_prevision']))
{
    $s = "";
    $tipo_previsiones = CAdminComboboxEclesiastico::GetTipoPrevisionxIdCB($_REQUEST['id_prevision']);
    foreach($tipo_previsiones as $tp)
    {
	$s .= "{ value:".json_encode($tp[1]).", name:".json_encode($tp[0])."},";
    }
    $cadena = substr ($s, 0, strlen($s) - 1);
    echo "[".$cadena."]";
}
?>