<?php
session_start();
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
if($_POST['Tipo']!=1){
    echo ConsultarOfertas($_POST['Tipo']);
}else{
    echo ConsultarPublicacionOferta($_POST['Id']);
}  
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>