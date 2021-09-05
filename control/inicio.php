
        <?php
         include_once("header.php");
         //VALIDACION DE SESION
         if(!isset($_SESSION["logged_in"])){
         header("Location: ../index.php");}
                                           
         
        require_once ('../vistas/v_inicio.php');        
        ?>
    