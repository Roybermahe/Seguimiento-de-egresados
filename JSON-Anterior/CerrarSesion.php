<?php
    session_start();
    $_SESSION['Usuario'];
    $_SESSION['Rol'];
    $_SESSION['CodUser'];
    
    if($_POST['c']=='close'){
        switch ($_SESSION['Rol']) {
            case 'Empleado':
            session_destroy();
            echo 'IniciarSesionAdmin.html';
                break;
            
            default:
            session_destroy();
            echo 'index.html';
               break;
        }  
    }
    
?>