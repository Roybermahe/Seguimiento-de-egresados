<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Data = array("Culminado","En curso","Abandonado","Aplazado");
    $i = $_POST['EstadoEstudio'];
    if(!isset($_POST['Cod'])){
        $cod = NULL;
    }
    else{
        $cod = $_POST['Cod'];
    }
    if($Data[$i]=="Culminado"){
        echo HvFormacion_Academica(new PEEstudios($cod,NULL,$_POST['NivelEstudio'],$_POST['AreaEstudio'],$Data[$i],$_POST['FechaInicio'],$_POST['FechaFin'],$_POST['TituloRecibido'],$_POST['Insituto'],$_POST['Ciudad']));   
    }else if($Data[$i]=="En curso" || $Data[$i]=="Abandonado" || $Data[$i]=="Aplazado"){
        echo HvFormacion_Academica(new PEEstudios($cod,NULL,$_POST['NivelEstudio'],$_POST['AreaEstudio'],$Data[$i],$_POST['FechaInicio'],NULL,$_POST['TituloRecibido'],$_POST['Insituto'],$_POST['Ciudad'])); 
    }
?>