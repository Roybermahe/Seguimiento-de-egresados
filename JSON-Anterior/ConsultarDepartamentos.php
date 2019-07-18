<?php

    include('ConexionSesions.php');
 
    session_start();
    mysqli_set_charset($Conexion,"utf8");
    ob_start();
           $CodPais=mysqli_real_escape_string($Conexion,$_GET['c']);
            $sql=mysqli_query($Conexion,'SELECT CodDepartamento, NombreDepartamento, CodPais FROM departamentos WHERE CodPais='.$CodPais.'');
            $Data = array();
            while($datos =  mysqli_fetch_object($sql)){
            $Data[] = array("CodDepartamento"=>$datos->CodDepartamento,
                            "NombreDepartamento"=>$datos->NombreDepartamento,
                            "CodPais"=>$datos->CodPais);
            }
            echo ''.json_encode($Data).'';
 
    mysqli_close($Conexion);
    header('Content-type: application/json');//tipo de contenido
    header('access-content-allow-origin: *');//acceso de cualquier origen
?>