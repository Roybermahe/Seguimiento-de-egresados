<?php
    include('ConexionSesions.php');
    session_start();
mysqli_set_charset($Conexion,"utf8");
    ob_start();
   if(($_SESSION['Rol']=='Egresado') || 
      ($_SESSION['Rol']=='Empleado') || 
      ($_SESSION['Rol']=='Empresa')  ||
      ($_SESSION['Rol']=='Admin')){
        $sql=mysqli_query($Conexion,'SELECT CodPrograma, NombrePrograma, CodFacultad FROM programasunicesar');
        $Data = array();
        while($datos =  mysqli_fetch_object($sql)){
        $Data[] = array("CodPrograma"=>$datos->CodPrograma,
                        "NombrePrograma"=>$datos->NombrePrograma,
                        "CodFacultad"=>$datos->CodFacultad);
        }
        echo ''.json_encode($Data).'';
    }
    mysqli_close($Conexion);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>