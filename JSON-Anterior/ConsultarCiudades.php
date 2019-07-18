<?php
    include('ConexionSesions.php');
    session_start();
mysqli_set_charset($Conexion,"utf8");
    ob_start();
       $CodDepartamento=mysqli_real_escape_string($Conexion,$_GET['c']);
        $sql=mysqli_query($Conexion,'SELECT CodCiudad, NombreCiudad, CodDepartamento FROM ciudades WHERE CodDepartamento='.$CodDepartamento.'');
        $Data = array();
        while($datos =  mysqli_fetch_object($sql)){
        $Data[] = array("CodCiudad"=>$datos->CodCiudad,
                        "NombreCiudad"=>$datos->NombreCiudad,
                        "CodDepartamento"=>$datos->CodDepartamento);
        }
        echo ''.json_encode($Data).'';

    mysqli_close($Conexion);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>