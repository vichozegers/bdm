<!--Autor: Vicente Zegers
Proyecto:BDU_MOVIL_VER2
Fundación las Rosas 
Fecha: 11.07.13
Modificacion-->
<?php
header('Content-Type: text/html; charset=UTF-8');
$i=1;
?> 
<html>    
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
        <!--Declaracion de Sitio WebApp --> 
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
        <!-- -->
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <!-- iDevice WebApp Pantalla Carga, Iconos, iPhone, iPad, iPod Iconos -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/splash/splash-icon.png"> 
        <!-- iPhone 3, 3Gs -->
        <link rel="apple-touch-startup-image" href="images/splash/splash-screen.png" 		media="screen and (max-device-width: 320px)" /> 
        <!-- iPhone 4 -->
        <link rel="apple-touch-startup-image" href="images/splash/splash-screen_402x.png" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" /> 
        <!-- iPhone 5 -->
        <link rel="apple-touch-startup-image" sizes="640x1096" href="images/splash/splash-screen_403x.png" />
        <!-- iPad landscape -->
        <link rel="apple-touch-startup-image" sizes="1024x748" href="images/splash/splash-screen-ipad-landscape" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : landscape)" />
        <!-- iPad Portrait -->
        <link rel="apple-touch-startup-image" sizes="768x1004" href="images/splash/splash-screen-ipad-portrait.png" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : portrait)" />
        <!-- iPad (Retina, portrait) -->
        <link rel="apple-touch-startup-image" sizes="1536x2008" href="images/splash/splash-screen-ipad-portrait-retina.png"   media="(device-width: 768px)	and (orientation: portrait)	and (-webkit-device-pixel-ratio: 2)"/>
        <!-- iPad (Retina, landscape) -->
        <link rel="apple-touch-startup-image" sizes="1496x2048" href="images/splash/splash-screen-ipad-landscape-retina.png"   media="(device-width: 768px)	and (orientation: landscape)	and (-webkit-device-pixel-ratio: 2)"/>

        <!-- Titulo WebApp -->
        <title>Fundación Las Rosas BDU Movil - Smartphone - Tablets </title>

        <!-- Hojas de Estilo -->
        <link href="../css/style.css"				rel="stylesheet" type="text/css">
        <link href="../css/framework-style.css" 	rel="stylesheet" type="text/css">
        <link href="../css/framework.css" 			rel="stylesheet" type="text/css">
        <link href="../css/framework-tablet.css"	rel="stylesheet" type="text/css" media="only screen and (min-width: 767px)"/>
        <link href="../css/bxslider.css"			rel="stylesheet" type="text/css">
        <link href="../css/swipebox.css"			rel="stylesheet" type="text/css">
        <link href="../css/icons.css"				rel="stylesheet" type="text/css">
        <link href="../css/retina.css" 				rel="stylesheet" type="text/css" media="only screen and (-webkit-min-device-pixel-ratio: 2)" />


        <!--Scripts Js -->
        <script src="../js/jquery.min.js"		type="text/javascript"></script>	
        <script src="../js/hammer.js"			type="text/javascript"></script>	
        <script src="../js/jquery-ui-min.js"  type="text/javascript"></script>
        <script src="../js/subscribe.js"		type="text/javascript"></script>

        <script src="../js/jquery.swipebox.js" type="text/javascript"></script>
        <script src="../js/bxslider.js"		type="text/javascript"></script>
        <script src="../js/colorbox.js"		type="text/javascript"></script>
        <script src="../js/retina.js"			type="text/javascript"></script>
        <script src="../js/custom.js"			type="text/javascript"></script>
        <script src="../js/framework.js"		type="text/javascript"></script>
        <script src="../js/validar.js"                  type="text/javascript"></script>
        <script src="../js/bloqueo.js" type="text/javascript"> 
        </script>
        <!-- Script Botón Subir -->
        <script type="text/javascript">
	$(document).ready(function() {
		$('#arriba').click(function(){ //Id boton ir arriba
			$('html, body').animate({scrollTop:0}, 1250);
			return false;
		});
	});
        </script> 
        <!--Fin Script Botón Subir -->
        <!--    Script de Carga-->
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
<!-- Script de carga-->
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

        <div class="page-content">
            <div class="tablet-wrapper">
                <div class="header">
                  <a href="#" class="deploy-navigation"></a>
                  <a href="../control/inicio.php"><img class="logo" src="../images/misc/logo_402x.png" width="72" alt="img"></a>
                </div>

                <div class="navigation">
<!--                    <a href="../control/inicio.php" class="home-icon active-navigation">Inicio</a>-->
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
                        <h5 class="uppercase">BUSCAR ADULTO MAYOR</h5>
                        <em>Información BDU</em>
                    </div>
                    <div class="decoration"></div>

                   
                    <div class="container no-bottom">
                        <h4 class="uppercase">BUSCAR ADULTO MAYOR EN SISTEMA BDU</h4>
                        <p>Seleccione una opción ingrese el RUT o Apellido Paterno y presione buscar,</p>

                        <div class="column-responsive no-bottom">
                            <div class="one-half-responsive">
                                <div class="toggle-container-v4"> 
                                    <div class="toggle-v4">
                                        <a href="#" class="show-toggle-v4">ESCONDER BUSCAR AP.PATERNO</a>
                                        <a href="#" class="hide-toggle-v4">DESPLEGAR BUSCAR AP.PATERNO</a>
                                        <div class="clear"></div>
                                        <div class="toggle-content-v4">
                                            <div class="toggle-decoration-v4"></div>
                                            <form  method="post" action="../control/buscar_am.php" class="contactForm" >
                                                <fieldset>
                                                    <div class="formFieldWrap">
                                                        <label class="contactNameField" for="contactNameField">Apellido Paterno:<span>(requerido)</span></label>
                                                        <input type="text" name="contactNameField" value="" class="contactField requiredField" id="contactNameField" />
                                                    </div>
                                                 <input type="hidden" name="val" value="1">  
                                                    <div class="formSubmitButtonErrorsWrap">
                                                        <input type="submit" class="buttonWrap button grey contactSubmitButton" id="contactSubmitButton" value="Buscar" data-formId="contactForm"/>
                                                </fieldset>
                                            </form>  
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="one-half-responsive">
                                <div class="toggle-container-v4"> 
                                    <div class="toggle-v4">
                                        <a href="#" class="show-toggle-v4">ESCONDER BUSCAR POR RUT</a>
                                        <a href="#" class="hide-toggle-v4">DESPLEGAR BUSCAR POR RUT</a>
                                        <div class="clear"></div>
                                        <div class="toggle-content-v4">
                                            <div class="toggle-decoration-v4"></div>
                                            <form  method="post" action="../control/buscar_am.php" class="contactForm" >
                                                <fieldset>
                                                    <div class="formFieldWrap">
                                                        <label class="contactEmailField" for="contactEmailField">Rut:<span>(requerido)</span></label>
                                                        <input type="text" name="contactEmailField" value="" class="contactField requiredField" id="contactEmailField"/>
                                                    </div>

                                                    <input type="hidden" name="val" value="2">
                                                    <div class="formSubmitButtonErrorsWrap">
                                                        <input type="submit" class="buttonWrap button grey contactSubmitButton" id="contactSubmitButton" value="Buscar" data-formId="contactForm"/>        
                                                </fieldset>
                                            </form> 
                                        </div> 
                                    </div> 
                                </div>
                            </div>      
                        </div>

                    <?php                
               //VALOR RETORNO       //RETORNA VALOR RUT
           if ($registros == 1 && $adultorut->GetRut()!='') {
                                ?>

                                <h4 class="uppercase">RESULTADO BUSQUEDA</h4>
                                <div class="decoration"></div> 


                                <div class="one-half-responsive">
                                    <div class="toggle-container-v2"> 
                                        <div class="toggle-v2">
                                            <a href="#" class="show-toggle-v2">ESCONDER FICHA ADULTO MAYOR</a>
                                            <a href="#" class="hide-toggle-v2">VER FICHA ADULTO MAYOR</a>
                                            <div class="clear"></div>
                                            <div class="toggle-content-v2">
                                                <div class="toggle-decoration-v2"></div>
                                                <div class="column">
                                                    <h4 class="uppercase">Adulto Mayor</h4>
                                                    <p class="no-bottom">

                                                        Nombres:  <?php echo $adultorut->GetNombre() ?>
                                                        <br>
                                                        Apellido Paterno: <?php echo $adultorut->GetApellidoPaterno() ?> 
                                                        <br>

                                                        Apellido Materno: <?php echo $adultorut->GetApellidoMaterno(); ?> 
                                                        <br>
                                                        Rut:  <?php echo $adultorut->GetRut() ?>  
                                                        <br>
                                                        Funcionalidad: <?php echo $katz ?>
                                                        <br>
                                                        Categoria: <?php echo $adultorut->GetCategoria() ?>
                                                        <br>
                                                        Hogar: <?php if ($hogar==''){                            
                                                                    echo "No registra";
                                                                 } else if ($hogar != '') {
                                                       echo $adultorut->GetHogar() . "- " . $hogar;
                                                                 }
                                                                  ?>    
                                                    </p> 
                                                </div>

                                            </div> 
                                        </div> 
                                    </div>
                                </div>      
        <?php
    } else if ($registros>'0'){ // MENSAJE NO EXISTEN REGISTROS
        echo "<div class=\"small-notification blue-notification\">
              <p>No existen Registros del Rut</p> </div>";
    }  
?>
   <?php
                 if ($ap!='' && $registros_ap >'0') {
                                                         ?>
                                                  <div class="decoration"></div>
                                                  <h4 class="uppercase">RESULTADO BUSQUEDA</h4>
                                <div class="decoration"></div> 
                                    <?php foreach($adultos_apellido as $adulto_ap) { ?>
                                    <div class="one-half-responsive">
                                    <div class="toggle-container-v2"> 
                                        <div class="toggle-v2">
                                            <a href="#" class="show-toggle-v2">ESCONDER FICHA ADULTO MAYOR</a>
                                            <a href="#" class="hide-toggle-v2"><?php echo $adulto_ap->GetNombre()?> <?php echo $adulto_ap->GetApellidoPaterno()?></a>
                                            <div class="clear"></div>
                                            <div class="toggle-content-v2">
                                                <div class="toggle-decoration-v2"></div>
                                                <div class="column">
                                                    <h4 class="uppercase">Adulto Mayor</h4>
                                                    <p class="no-bottom">
                                                        <?php $i++ ?>
                                                        Nombres:  <?php echo $adulto_ap->GetNombre() ?>
                                                        <br>
                                                        Apellido Paterno: <?php echo $adulto_ap->GetApellidoPaterno() ?> 
                                                        <br>

                                                        Apellido Materno: <?php echo $adulto_ap->GetApellidoMaterno(); ?> 
                                                        <br>
                                                        Rut:  <?php echo $adulto_ap->GetRut() ?>  
                                                        <br>
                                                        Funcionalidad: <?php echo CAdminKatz::GetKatzVistasBduMovil($adulto_ap->Getid()) ?>
                                                        <br>
                                                        Categoria: <?php echo $adulto_ap->GetCategoria() ?>
                                                        <br> 
                                                        <?php $hogar_ap =CAdminHogar::GetHogarNombre($adulto_ap->GetHogar());?>
                                                        Hogar: <?php if ($hogar_ap==''){                            
                                                                    echo "No registra";
                                                                 } else if ($hogar_ap != '') {
                                                       echo $adulto_ap->GetHogar() . "- " . $hogar_ap;
                                                                 }
                                                                  ?>    
                                                    </p> 
                                                </div>

                                            </div> 
                                        </div> 
                                    </div>
                                </div>      
                                  
                                   <?php  } ?>
                                   
                                   <?php
                          
                    } else if ( $mensaje=='1' ) { // MENSAJE ALERTA AZUL BUSQUEDA
                        echo "<div class=\"small-notification blue-notification\">
                          <p>Ingrese su Busqueda por favor </p> </div>";
                    }
?> 
                    <div class="small-notification blue-notification" style="visibility:hidden;">
                          <p></p> </div>
                          
                    <div class="decoration"></div>
                    <?php if ($i>20){ //VALIDA SI ES SUPERIOR A 20 REG. APARECE BOTON IR ARRIBA
                       echo  "<a href=\"#\" id=\"arriba\">Ir arriba</a>";
                    } ?>
                    <p class="center-text copyright">Fundación Las Rosas - Depto. Informática</p>
                </div>                     
            </div>
        </div>
    </body>
</html>