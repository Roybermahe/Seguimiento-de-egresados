<?php
    include('ConexionSesions.php');
    
    ob_start();
    session_start();

    $User = mysqli_real_escape_string($Conexion,$_POST['Usuario']);
    $Password = mysqli_real_escape_string($Conexion,$_POST['Contrasena']);
    
    $Consulta = sprintf("SELECT u.PassUsuario,r.NombreRol,u.CodUsuario FROM usuarios u INNER JOIN roles r on u.Rol=r.CodRol and UPPER(NombreUsuario)=UPPER('".$User."')");
    $fila = mysqli_fetch_assoc(mysqli_query($Conexion, $Consulta));

    if (crypt($Password,$fila['PassUsuario'])==$fila['PassUsuario']) {
        $_SESSION['CodUser']=$fila['CodUsuario'];
        $_SESSION['Usuario']=$User;
        $_SESSION['Rol']=$fila['NombreRol'];

        switch($_SESSION['Rol']){
            case 'Egresado': echo "Egresados.html";break;
            case 'Empleado': echo "index.html";break;
            case 'Empresa': echo "Empresas.html";break;
            case 'Admin': echo "IndexSuperAdmin.html";break;
        }
    } else {
        echo 'Neg';
    }
?>