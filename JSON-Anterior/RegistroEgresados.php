<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $egresado = New Egresados(NULL,NULL,$_POST['Nombre'],$_POST['SegundoNombre'],$_POST['Apellido'],$_POST['SegundoApellido'],$_POST['FechaNacimiento'],$_POST['Pais'],$_POST['Departamento'],$_POST['Ciudad'],$_POST['TelefonoResidencia'],$_POST['Correo'],$_POST['Celular'],$_POST['Programa'],$_POST['Cedula'],NULL,NULL);
    echo RegistrarEgresados($egresado,$_POST['FechaDeGrado']);
?>