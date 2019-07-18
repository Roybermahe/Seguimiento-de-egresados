<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    if($_POST['Pass'] == $_POST['PassConfirmacion']){
        
        $Emp = new Empleado(NULL,NULL,$_POST['Nombre'],$_POST['SegundoNombre'],$_POST['Apellido'],$_POST['SegundoApellido'],$_POST['Cedula']);
        $NombreUsuario= $_POST['Usuario'];
        $Pass= $_POST['Pass'];
        
        echo GuardarEmpleado($Emp,$NombreUsuario,$Pass);
        
    }else{
        echo 'Contraseña invalida';
    }
?>