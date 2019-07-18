<?php
ob_start();
    include_once('ConexionSesions.php');
session_start();
    mysqli_set_charset($Conexion,"utf8");
if(($_SESSION['Rol']=='Egresado') || 
      ($_SESSION['Rol']=='Empleado') || 
      ($_SESSION['Rol']=='Empresa')  ||
      ($_SESSION['Rol']=='Admin')){
    
    $Consulta = "SELECT p.CodMomento, p.CodParte,m.Descripcion as DescMomento,p.Descripcion, (SELECT COUNT(*) FROM pregunta WHERE CodParte = P.CodParte GROUP BY CodParte) as Preguntas FROM partes p LEFT JOIN momento m on p.CodMomento = m.CodMomento WHERE p.CodMomento=".$_SESSION['MomentoActual'];
    $sql = mysqli_query($Conexion,$Consulta);
    
    $Data = array();
    while($datos =  mysqli_fetch_object($sql)){
        $cantidad = 0;
        if($datos->Preguntas != null){
            $cantidad = $datos->Preguntas;
        }
        $Data[] = array("CodParte"=> $datos->CodParte,
                        "DescMomento" =>$datos->DescMomento,
                        "Descripcion" =>$datos->Descripcion,
                        "CodMomento" =>$datos->CodMomento,
                        "Preguntas" =>"".$cantidad."",
                        "RealDescripcion"=>mysqli_real_escape_string($Conexion,$datos->Descripcion));
    }
    echo ''.json_encode($Data).'';
    
    
    
}
    
    mysqli_close($Conexion);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>