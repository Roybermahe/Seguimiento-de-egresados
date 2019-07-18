<?php

    ob_start();
    session_start();

        switch($_SESSION['Rol']){
            case 'Egresado': echo "xxxx.html";break;
            case 'Empleado': echo  '1' ;break;
            case 'Empresa': echo "xxxx.html";break;
            case 'Admin': echo '1' ;break;
                
            default : echo "IniciarSesionAdmin.html";    
                
        }

 ?>