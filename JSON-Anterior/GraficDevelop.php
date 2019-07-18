<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $PreguntaData = json_decode(ConsultarPreguntaUnica(new Pregunta($_POST['p'],NULL,NULL,NULL,NULL,NULL)),true); 
    $Fechas = json_decode(ConsultarMIN_MAX(),true);
    if(!isset($_POST['MIN']) || empty($_POST["MIN"])){$b=date("Y-m-d",strtotime($Fechas[0]{'mindate'}));}else{$b=date("Y-m-d",strtotime($_POST['MIN']));}
    if(!isset($_POST['MAX']) || empty($_POST["MAX"])){$c=date("Y-m-d",strtotime($Fechas[0]{'maxdate'}));}else{$c=date("Y-m-d",strtotime($_POST['MAX']));}
    echo GraficCreation(new GraficaPregunta($PreguntaData[0]{"CodTipo"},$b,$c,$PreguntaData[0]{"CodPregunta"}));
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>