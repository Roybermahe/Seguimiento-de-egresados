<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    if(($_SESSION['Rol']=='Egresado') || ($_SESSION['Rol']=='Empleado') || ($_SESSION['Rol']=='Empresa')  || ($_SESSION['Rol']=='Admin')){
    if(!isset($_SESSION['DirGrupo'])){$_SESSION['DirGrupo']=NULL;}
    if(!isset($_SESSION['DirParte'])){$_SESSION['DirParte']=NULL;}
    if(!isset($_SESSION['PreguntaParcial'])){$_SESSION['PreguntaParcial']=NULL;}
    if(!isset($_SESSION['PreguntaDir'])){$_SESSION['PreguntaDir']=NULL;}
    if(!isset($_SESSION['Parcial'])){$_SESSION['Parcial']=NULL;}
    if(!isset($_SESSION['FinParcial'])){$_SESSION['FinParcial']=TRUE;}
    if(!isset($_SESSION['FinGrupo'])){$_SESSION['FinGrupo']=FALSE;}
         if($_SESSION['PermisoDeRealizar']=='NO'){
             $Data = array();
             echo json_encode($Data,true);
         }else{
            $var=EnviarPregunta(); 
            if(!empty(json_decode($var,true))){
                echo $var;
             }else{
                FinalizarEncuesta();
                $_SESSION['PermisoDeRealizar']='NO';
                echo $var;
             } 
         }
    }
    header('Content-type: application/json');//tipo de contenido
    header('access-content-allow-origin: *');//acceso de cualquier origen
?>