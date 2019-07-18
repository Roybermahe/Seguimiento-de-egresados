<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Cod=NULL;
    if(isset($_POST['Cod'])){
        $Cod=$_POST['Cod'];
    }
    $Fin=NULL;
    if(!isset($_POST['TrabajoActual'])){
        $Fin=$_POST['Fin'];
    }
    echo HvExperiencia_Laboral(new PEExperienciasLaborales($Cod,NULL,$_POST['Empresa'],$_POST['Sector'],$_POST['SubSector'],$_POST['Inicio'],$Fin,$_POST['Cargo'],$_POST['CargoEquivalente'],$_POST['NivelCargo'],$_POST['AreaCargo'],$_POST['LogrosRespo'],$_POST['Telefono'],$_POST['Ciudad']));
?>