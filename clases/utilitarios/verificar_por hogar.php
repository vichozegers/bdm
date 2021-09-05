<?php

include_once("header.php");
include_once("clases/utilitarios/CAdminUtilitarios.php");
include_once("clases/utilitarios/CUtilitarios.php");

include_once("clases/Hogar/CAdminHogar.php");


if ($_GET['idhog']){

    $id_hogar=$_GET['idhog'];

        $utilitarios=CAdminUtilitarios::GetListaResidentescomunaNullxHogar( $id_hogar);
        $scSmarty->assign("utilitarios", $utilitarios);

        $hogar=CAdminHogar::GetHogarNombre($id_hogar);
        
        $scSmarty->assign("id_hogar", $id_hogar);
        $scSmarty->assign("hogar", $hogar);
}

?>

<head>
    <title>Fundación las Rosas</title>
    <link rel="shortcut icon" href="../../img/virgen.ico">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <meta http-equiv='content-type' content='text/html;charset=utf-8'/>

    <script language="javascript" type="text/javascript" src="../../js/ext-base.js"></script>
    <script language="javascript" type="text/javascript" src="../../js/ext-all.js"></script>
    <script language="javascript" type="text/javascript" src="../../js/panel.js"></script>
<!--
------------------------------------------------------------------------------------------------
      Inicio de Jquery con Jtps
------------------------------------------------------------------------------------------------
-->
<!-- Si presiono opcion para  utilizar la libreria JTPS-->

    <link rel="stylesheet" type="text/css" href="../../jTPS/jTPS.css"></link

    <script language="JavaScript" type="text/javascript" src="../../jTPS/jquery.js"></script>
    <script language="JavaScript" type="text/javascript" src="../../jTPS/jTPS.js"></script>

    <script language="JavaScript" >

        $(document).ready(function () {
            $('#demoTable').jTPS( {perPages:[10],
                scrollStep:1,scrollDelay:30,
                perPageText:'Cantidad por página ',
                perPageShowing: 'Mostrando'
            } );
            // bind mouseover for each tbody row and change cell (td) hover style
            $('#demoTable tbody tr:not(.stubCell)').bind('mouseover mouseout',
            function (e) {
                // hilight the row
                e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
            }
        );
        });

    </script>

    <style>
        body {
            font-family: Tahoma;
            font-size: 9pt;
        }
        #demoTable thead th {
            white-space: nowrap;
            overflow-x:hidden;
            padding: 3px;
        }
        #demoTable tbody td {
            padding: 3px;
        }
    </style>

<!--
------------------------------------------------------------------------------------------------
  Fin de Jquery con Jtps
------------------------------------------------------------------------------------------------
-->

    <link rel='stylesheet' href='../../css/estilo.css' type='text/css' />
    <link rel="stylesheet" type="text/css" href="../../css/acordeon.css" />
    <script type="text/javascript" src="../../js/ddaccordion.js"></script>
    <script type="text/javascript" src="../../js/ddaccordion_2.js"></script>

    <style type="text/css">
        .style1 {
            font-size:	 12px;
            font-weight:	 bold;
        }
        .style2{
            font-size:	12px;
        }
    </style>

 <?php
  // -------------------------------------------------------

 // -------------------------------------------------------

      $titulo = "ACTUALIZACION DE SOLICITUD";
      include_once("../../menuaccord2.php");
    ?>
</head>
<body onload="new Accordian('basic-accordian',3);">
    <div id="content">
        <div id="panel"></div>
        <div id="cont">
            <?php
                    $scSmarty->display("verUtilitariosXHogar.tpl");
               ?>
        </div>
    </div>
    <?
    include_once("../../menuparte2.php");
    ?>
</body>