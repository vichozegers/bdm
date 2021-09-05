<!--Autor: Vicente Zegers
Proyecto:BDU_MOVIL_VER1.5.4
Fundación las Rosas 
Fecha: 11.07.13-->
<?php
header('Content-Type: text/html; charset=UTF-8');

?> 
<!DOCTYPE html><head>
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
<!--    Script de Carga-->
<script>
            $(document).ready(function() { 
            $('.other-icon').click(function() { 
            $.blockUI({ 
//          message:'<div id="status"/><p></p>',
            message:$('.text'), //id de Carga
            css: { 
            border: 'none', 
            padding: '20px', 
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

<!--    <div id="preloader disabled">
        <div id="status"> Gif de Carga
            <div class="text" style="display:none">
		 <img src="../images/status.gif" style="width:30px;height:30px;left:40%;top:30%;right:60%;"/>      
                 <p class="center-text uppercase">Cargando...</p>
            </div>
        </div>
    </div>-->

    <div class="page-content">
        <div class="tablet-wrapper">
            <div class="header">
                <a href="#" class="deploy-navigation"></a>
                    <a href="../control/inicio.php"><img class="logo" src="../images/misc/logo_402x.png" width="72" alt="img"></a>
            </div>

            <div class="navigation">
<!--            <a href="../control/inicio.php" class="home-icon active-navigation">Inicio</a>-->
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
<!--                <div class="bxslider-wrapper">
                    <div class="bxslider">
                        <div>
                            <img src="../images/home3.png" alt="img"/>   
                        </div>

                    </div>
                </div>-->
                <img class="responsive-image" src="../images/home3.png" alt="img">
                <div class="container no-bottom">
                    <h4 class="center-text uppercase">Bienvenidos</h4>
                    <p class="center-text">Los invito a utilizar esta aplicacion, la cual tiene como objetivo entregar información desde Sistema BDU.</p>   
                </div>

                <div class="decoration"></div>      
                <div class="decoration"></div>
                <p class="center-text copyright">Fundación Las Rosas - Depto. Informática</p>
            </div>
        </div>
    </div>

</body>
</html>
<!--ULTIMA MODIFICACION 9 AGOSTO 2013 -->



