<?php
   include_once('ConexionSesions.php');
session_start();
    mysqli_set_charset($Conexion,"utf8");
    ob_start();
   if(($_SESSION['Rol']=='Egresado') || 
      ($_SESSION['Rol']=='Empleado') || 
      ($_SESSION['Rol']=='Empresa')  ||
      ($_SESSION['Rol']=='Admin')){
    $Codigo=mysqli_real_escape_string($Conexion,$_GET['p']);
    $Consulta = "SELECT * FROM pregunta WHERE CodParte=".$_SESSION['ParteActual']." AND Estado = 1 AND CodPregunta=".$Codigo."";
    $sql = mysqli_query($Conexion,$Consulta);
    $Data = array();
    while($datos =  mysqli_fetch_object($sql)){
        $Data[] = array("CodPregunta"=> $datos->CodPregunta,
                        "CodParte" =>$datos->CodParte,
                        "Descripcion" =>$datos->Descripcion,
                        "CodTipo" =>$datos->CodTipo,                    
                        "CodGrupo"=>$datos->CodGrupo,
                        "Estado"=>$datos->Estado,
                        "Respuestas"=>Respuestas($datos->CodPregunta));
    }
    
    echo ''.json_encode($Data).'';
   }
    function Respuestas($CodPregunta){
        $sql = "SELECT * FROM respuestasegresados r WHERE r.CodPregunta=".$CodPregunta." and r.CodRespMomento = ".$_SESSION['CodRespMomento']."";
        $resultado = mysqli_query($GLOBALS['Conexion'],$sql);
        $respuestas = array();
        while($datos=mysqli_fetch_object($resultado)){
            $respuestas[] = array("CodRespuesta"=>$datos->CodRespuesta,
                                  "CodRespMomento"=>$datos->CodRespMomento,
                                  "CodPregunta"=>$datos->CodPregunta,
                                  "CodPosRespuesta"=>$datos->CodPosRespuesta,
                                  "PreguntaSistema"=>$datos->PreguntaSistema,
                                  "Respuesta"=>$datos->Respuesta);
        }
       return $respuestas;
    }
    mysqli_close($Conexion);
    header('Content-type: application/json');
    header('access-content-allow-origin: *');
?>