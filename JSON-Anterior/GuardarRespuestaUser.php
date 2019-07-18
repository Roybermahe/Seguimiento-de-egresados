<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php'); 
    if(($_SESSION['Rol']=='Egresado') ||($_SESSION['Rol']=='Empleado') ||  ($_SESSION['Rol']=='Empresa')  || ($_SESSION['Rol']=='Admin')){
    $RespuestasEgresados = new RespuestasEgresados(NULL,$_SESSION['CodRespMomento'],$_POST['CP'],$_POST['CdP'],$_POST['Psis'],$_POST['Resp'],$_POST['Tipo']);
    echo GuardarRespuestasUser($RespuestasEgresados);
    }
?>