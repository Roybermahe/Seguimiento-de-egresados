<?php
    session_start();
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $obj = json_decode($_POST['data']);
    echo EPConsultarEgresado( $obj->Anyo, $obj->Programa);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
/*{"data":{"Anyo":Anyo,"Programa":Programa}}*/
?>