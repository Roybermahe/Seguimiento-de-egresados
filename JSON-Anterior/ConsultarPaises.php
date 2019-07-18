<?php
    include('ConexionSesions.php');
    session_start();
mysqli_set_charset($Conexion,"utf8");
    ob_start();
   
        $sql=mysqli_query($Conexion,'SELECT CodPais, NombrePais, CodContinente FROM pais');
        $Data = array();
        while($datos =  mysqli_fetch_object($sql)){
        $Data[] = array("CodPais"=>$datos->CodPais,
                        "NombrePais"=>$datos->NombrePais,
                        "CodContinente"=>$datos->CodContinente);
        }
        echo ''.json_encode($Data).'';
   
    mysqli_close($Conexion);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>