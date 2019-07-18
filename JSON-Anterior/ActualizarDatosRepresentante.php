<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Representante = new RepresentanteEmpresa(NULL,$_POST['Nombres'],$_POST['Apellidos'],$_POST['TipoDocumento'],$_POST['NumeroDocumento'],$_POST['AnyoDeNacimiento'],$_POST['CargoRepresentante'],$_POST['Correo'],$_POST['Telefono'],NULL,NULL,NULL);
    echo ActualizarDatosDelRepresentante($Representante);
?>