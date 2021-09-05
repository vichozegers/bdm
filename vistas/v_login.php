<!--Autor: Vicente Zegers
Proyecto:BDU_MOVIL_VER1
Fundación las Rosas 
Fecha: 11.07.13-->
<?php
header('Content-Type: text/html; charset=UTF-8');
?> 

<!DOCTYPE html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <link href="css/style.css"				rel="stylesheet" type="text/css">
    <link href="css/framework-style.css" 	rel="stylesheet" type="text/css">
    <link href="css/framework.css" 			rel="stylesheet" type="text/css">
    <link href="css/framework-tablet.css"	rel="stylesheet" type="text/css" media="only screen and (min-width: 767px)"/>
    <link href="css/bxslider.css"			rel="stylesheet" type="text/css">
    <link href="css/swipebox.css"			rel="stylesheet" type="text/css">
    <link href="css/icons.css"				rel="stylesheet" type="text/css">
    <link href="css/retina.css" 				rel="stylesheet" type="text/css" media="only screen and (-webkit-min-device-pixel-ratio: 2)" />


    <!--Scripts Js -->
    <script src="js/jquery.min.js"		type="text/javascript"></script>	
    <script src="js/hammer.js"			type="text/javascript"></script>	
    <script src="js/jquery-ui-min.js"  type="text/javascript"></script>
    <script src="js/subscribe.js"		type="text/javascript"></script>
    <script src="js/jquery.swipebox.js" type="text/javascript"></script>
    <script src="js/bxslider.js"		type="text/javascript"></script>
    <script src="js/colorbox.js"		type="text/javascript"></script>
    <script src="js/retina.js"			type="text/javascript"></script>
    <script src="js/custom.js"			type="text/javascript"></script>
    <script src="js/framework.js"		type="text/javascript"></script>
<!--<script src="js/login.js"                   type="text/javascript"></script>-->

</head>
<body>

<!--    <div id="preloader disabled">
        <div id="status">
            <p class="center-text">
			Cargando Contenido....
                <em>La carga depende de tu velocidad de Internet!</em>
            </p>
        </div>
    </div>-->


    <div class="page-content">
        <div class="tablet-wrapper">
            
            <div class="content">
                <div class="container">
                <div class="portfolio-item-full-width">
                        <img class="responsive-image" src="./images/login.png" alt="img">
                </div>               
            </div>

                 <div class="column-responsive">        
                <div class="one-half-responsive">
                    <div class="contact-form"> 
                     <form  id="contactForm" action="index.php" method="post">
                            <fieldset>
                                <div class="formFieldWrap">
                                    <label class="contactNameField" for="contactNameField">USUARIO</label>
                                    <input type="text" name="contactNameField" value="" class="contactField requiredField" id="contactNameField"/>
                                </div>
                                <div class="formFieldWrap">
                                    <label class="contactEmailField" for="contactEmailField">CONTRASEÑA</label>
                                    <input type="password" name="contactEmailField" value="" class="contactField requiredField requiredEmailField" id="contactEmailField"/>
                                </div>
                                
                                    <div class="formSubmitButtonErrorsWrap">
                                        <input type="submit" class="buttonWrap button grey contactSubmitButton" id="contactSubmitButton" value="Ingresar" />
                                        
                                    </div>
                            </fieldset>
                        </form>       
 
                </div>
                </div>
               </div>      
                    
                <div id="div_mensaje_azul" style="display: none"></div>
            <?php 
           
            if ( $_GET['e']=='1') {
                 echo "<div class=\"small-notification red-notification\">
                          <p>Usuario o Password Incorrecto</p> </div>";
                }?>
                
                <div class="decoration"></div>
                <p class="center-text copyright">Fundación Las Rosas - Depto. Informática</p>
            </div>
        </div>
    </div>

</body>
</html>




