<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Emp = new Empresas(NULL,NULL,NULL,$_POST['RazonSocial'],$_POST['SectorDeEmpresa'],$_POST['Ciudad'],$_POST['TelefonoEP'],$_POST['DireccionEP']);
    echo ActualizarDatosDeEmpresa($Emp,$_POST['NumEmpleados'],$_POST['Fax'],$_POST['PaginaWeb']);
?>