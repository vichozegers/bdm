<!--Autor: Vicente Zegers
Proyecto:BDU_MOVIL_VER1.5.4
Fundación las Rosas 
Fecha: 11.07.13-->
 
<?php
header('Content-Type: text/html; charset=UTF-8');
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="generator" content=
              "HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org" />
        <meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />
        <!--Declaracion de Sitio WebApp -->
        <meta name="viewport" content=
              "user-scalable=no, initial-scale=1.0, maximum-scale=1.0" /><!-- -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- iDevice WebApp Pantalla Carga, Iconos, iPhone, iPad, iPod Iconos -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href=
              "images/splash/splash-icon.png" /><!-- iPhone 3, 3Gs -->
        <link rel="apple-touch-startup-image" href="images/splash/splash-screen.png" media=
              "screen and (max-device-width: 320px)" /><!-- iPhone 4 -->
        <link rel="apple-touch-startup-image" href="images/splash/splash-screen_402x.png"
              media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" />
        <!-- iPhone 5 -->
        <link rel="apple-touch-startup-image" sizes="640x1096" href=
              "images/splash/splash-screen_403x.png" /><!-- iPad landscape -->
        <link rel="apple-touch-startup-image" sizes="1024x748" href=
              "images/splash/splash-screen-ipad-landscape" media=
              "screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : landscape)" />
        <!-- iPad Portrait -->
        <link rel="apple-touch-startup-image" sizes="768x1004" href=
              "images/splash/splash-screen-ipad-portrait.png" media=
              "screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : portrait)" />
        <!-- iPad (Retina, portrait) -->
        <link rel="apple-touch-startup-image" sizes="1536x2008" href=
              "images/splash/splash-screen-ipad-portrait-retina.png" media=
              "(device-width: 768px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" />
        <!-- iPad (Retina, landscape) -->
        <link rel="apple-touch-startup-image" sizes="1496x2048" href=
              "images/splash/splash-screen-ipad-landscape-retina.png" media=
              "(device-width: 768px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" />
        <!-- Titulo WebApp -->

        <title>Fundaci&oacute;n Las Rosas BDU Movil - Smartphone - Tablets</title>
        <!-- Hojas de Estilo -->
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../css/framework-style.css" rel="stylesheet" type="text/css" />
        <link href="../css/framework.css" rel="stylesheet" type="text/css" />
        <link href="../css/framework-tablet.css" rel="stylesheet" type="text/css" media=
              "only screen and (min-width: 767px)" />
        <link href="../css/bxslider.css" rel="stylesheet" type="text/css" />
        <link href="../css/swipebox.css" rel="stylesheet" type="text/css" />
        <link href="../css/icons.css" rel="stylesheet" type="text/css" />
        <link href="../css/retina.css" rel="stylesheet" type="text/css" media=
              "only screen and (-webkit-min-device-pixel-ratio: 2)" /><!--Scripts Js -->

        <script src="../js/jquery.min.js" type="text/javascript">
        </script>
        <script src="../js/hammer.js" type="text/javascript">
        </script>
        <script src="../js/jquery-ui-min.js" type="text/javascript">
        </script>
        <script src="../js/subscribe.js" type="text/javascript">
        </script>
        <script src="../js/jquery.swipebox.js" type="text/javascript">
        </script>
        <script src="../js/bxslider.js" type="text/javascript">
        </script>
        <script src="../js/colorbox.js" type="text/javascript">
        </script>
        <script src="../js/retina.js" type="text/javascript">
        </script>
        <script src="../js/custom.js" type="text/javascript">
        </script>
        <script src="../js/framework.js" type="text/javascript">
        </script>
        <script src="../js/bloqueo.js" type="text/javascript"> 
        </script>
          <script>
        $(document).ready(function() { 
      $('.other-icon').click(function() { 
        $.blockUI({ 
            
            message:$('.text'), //id de Carga
            css: { 
            
            border: 'none', 
            padding: '15px', 
            backgroundColor: 'transparent', //Color FLRosas
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .9, //Nivel de Opacidad 1 transparente / +9 Oscuro
            color: '#fff' 
        } }); 
 
        setTimeout($.unblockUI, 200000); //El Timer es superior al retorno de la BDS//
    }); 
}); 
        
</script>        
        
        
    </head>

    <body>
      <div id="preloader disabled">
        <div id="status"> <!--Gif de Carga-->
            <div class="text" style="display:none">
		 <img src="../images/status.gif" style="width:30px;height:30px;left:40%;top:30%;right:60%;"/>      
                 <p class="center-text uppercase">Cargando...</p>
            </div>
        </div>
    </div>
<!-- LOGO BDU MOVIL ES UTILIZADO PARA IR AL INICIO, SE COMENTO VINCULO INICIO DE MENU-->
        <div class="page-content">
            <div class="tablet-wrapper">
                <div class="header">
                     <a href="#" class="deploy-navigation"></a>
                    <a href="../control/inicio.php"><img class="logo" src="../images/misc/logo_402x.png" width="72" alt="img"></a>
                </div>

                <div class="navigation">
<!--                <a href="../control/inicio.php" class="home-icon active-navigation">Inicio</a> -->
                   <a href="../control/buscar_am.php" class="about-icon">Buscar AM</a>
                    <a href="../control/hogares.php" class="jquery-icon">Buscar Hogar</a>
                    <a href="../control/ocupacion_hogar.php" class="jquery-icon">Ocupación Hogar</a>
                    <a href="../control/indice_gestion.php" class="type-icon">Indice Gestion</a>
                    <a href="../control/residentes_genero.php" class="gallery-icon">Resumen AM</a>
                    <a href="../control/resumen_general.php" class="user">Resumen General</a> 
                    <a href="../control/resumen_general_bdus.php" class="other-icon">Resumen BDS</a>
                    <a href="../index.php?logout=1" class="filter-icon">Salir</a>
                </div>
                <div class="content">
                    <div class="page-head">
                        <h5 class="uppercase">BUSCAR HOGAR</h5><em>Informaci&oacute;n BDU</em>
                    </div>
                    <div class="decoration"></div><!-- CODIGO PHP -QUERYS SQL-->

                    <div class="container no-bottom">
                        <h4 class="uppercase">BUSCAR HOGARES</h4>

                        <p>Seleccione un Hogar de la Lista y presione Buscar</p>

                        <div class="decoration"></div>

                        <div class="column-responsive no-bottom">
                            <div class="one-half-responsive">
                                <form method="post" action="../control/hogares.php" class="contactForm">
                                    <fieldset>
                                        <div class="formFieldWrap">
                                            <div class="styled-select">
                                                <select name="hogar">
                                                    <option value="-1">
                                                        SELECCIONAR
                                                    </option><?php
                                                for ($i=0;$i<count($hogares);$i++)
                                                {
                                                 ?>   
                                               <option value="<?php echo $hogares[$i][0] ?>" ><?php echo $hogares[$i][1] ?></option>   
                                                <?php    
                                                }
                                              ?>
<!--                                               <option value="////<?//echo $i+$i?>">
                                                   <?//echo $i+1?>-RESUMEN GENERAL HOGARES
                                               </option>        -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formSubmitButtonErrorsWrap">
                                            <input type="submit" class=
                                                   "buttonWrap button grey contactSubmitButton" id="contactSubmitButton"
                                                   value="Buscar" data-formid="contactForm" />
                                        </div>
                                    </fieldset>
                                </form>
                            </div><?php
                                                    if ($hogar!='' && $registro>-1) {

                                     if ($hogar!='') {
                                                         ?>
                                                  <div class="decoration"></div>
                                    <div class="notification-box blue-box">
                                        <h4>INFORMACI&Oacute;N HOGAR</h4><a href="#" class=
                                                                            "close-notification">x</a>
                      
                                        <div class="clear"></div>
                                         <?php $id=$hogar->GetIdHogar()?>
                                         <p>N&uacute;mero: <?php echo $hogar->GetNumeroHogar(); ?><br />
                                            Nombre: <?php echo $hogar->GetNombre() ?><br />
                                            Direcci&oacute;n: <?php echo $hogar->GetDireccion() ?><br />
                                            T&eacute;lefono: <?php echo $hogar->GetTelefono() ?><br />
                                            Fax: <?php echo $hogar->GetFax() ?><br />
                                            Cap. Estable:     <?php echo $hogar->GetCapacidad_estable() ?><br />
                                            Cap.Aumentada:    <?php echo $hogar->GetCapacidad_aumentada() ?><br />
                                            Cant. Residentes: <?php  echo $Cant_Residentes= CAdminResidentes::GetNumResidentesXHogar($id)?><br>
                                          
                                         </p><br>
                                        <div id="texto" style=""> INFORMACIÓN OCUPACIÓN HOGAR</div>
                                           <p>
                                            Cant. Residentes Fem: <?php  echo $res_fem= CAdminResidentes::GetNumResidentesXHogarFemenino($id)?><br>
                                            Cant. Residentes Masc:<?php echo $res_masc=CAdminResidentes::GetNumResidentesXHogarMasculino($id)?><br>    
                                            Vacantes : <?php  echo $hogar->GetCapacidad_estable()-$Cant_Residentes ?><br>    
                                            Vacantes Masc:<?php echo $vacantes_masc=$capacidad_masc-$res_masc?><br>  
                                            Vacantes Fem:<?php echo $vacantes_fem=$capacidad_fem-$res_fem;?><br>
                                            Emergencia:<?php if ($emergencia<=0) {
                                                              echo $emergencia; }
                                                            else { echo '0';  } ?></p>
                                              </div>                              
                                   <?php
                        } 
                        
                    }
                    
                    
                    else if ($registro==($i+$i)||$registro>($i+$i)){ ?>
                    
                  <?php  }else if ($registro==-1) { // MENSAJE ALERTA SELECCIONE HOGAR
                        echo "<div class=\"small-notification blue-notification\">
                          <p>Debe Seleccionar un Hogar</p> </div>";
                    }
?>
                            <div class="decoration"></div>
                            <p class="center-text copyright">Fundaci&oacute;n Las Rosas - Depto.
                                Inform&aacute;tica </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<!--ULTIMA MODIFICACION 9 AGOSTO 2013 -->