<?php
    session_start();
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    if(isset($_POST['Tipo'])){
        if(isset($_POST['Id'])){
            $_SESSION['CodEgresado'] = $_POST['Id'];   
        }
        echo DatosHojaDeVida();
    }
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>