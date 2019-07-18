<?php
    include('Capas/BLL.php');
    session_start();
    mysqli_set_charset($Conexion,"utf8");
    ob_start();$resp="";
   if(($_SESSION['Rol']=='Egresado') || ($_SESSION['Rol']=='Empleado') || 
      ($_SESSION['Rol']=='Empresa')  || ($_SESSION['Rol']=='Admin')){
       if(!isset($_SESSION['PermisoDeRealizar'])){$_SESSION['PermisoDeRealizar']='NO';}
       if(!isset($_SESSION['PermisoDeNotificar'])){$_SESSION['PermisoDeNotificar']='NO';}
       if($_SESSION['PermisoDeRealizar']=='NO'){
           echo 'Egresados.html';
       }else{    
            $resultado=mysqli_query($Conexion,"SELECT * FROM respmomento WHERE Egresado = ".$_SESSION['CodEgresado']." AND CodMomento =".$_SESSION['MomentoActual']."");
           while($datos = mysqli_fetch_object($resultado)){
               $_SESSION['CodRespMomento'] = $datos->CodRespMomento;
           }
           if(mysqli_num_rows($resultado)==0){
            $Sql = "INSERT INTO respmomento(Egresado,FechaEstipulada,CodMomento,DiasEnDiligenciar) VALUES (".$_SESSION['CodEgresado'].",'".$_SESSION['FechaEstipulada']."',".$_SESSION['MomentoActual']." ,DATEDIFF(SYSDATE(),'".$_SESSION['FechaEstipulada']."'))";
           
                $resultado = mysqli_query($Conexion,$Sql);            
                $resultado=mysqli_query($Conexion,"SELECT * FROM respmomento WHERE Egresado = ".$_SESSION['CodEgresado']." AND CodMomento =".$_SESSION['MomentoActual']."");
                while($datos = mysqli_fetch_object($resultado)){
                   $_SESSION['CodRespMomento'] = $datos->CodRespMomento;
                   $_SESSION['PreguntaParcial']=null;
                }
           }
       echo "Actualizacion-de-Momentos-Encuesta.html";
           }
   }    

?>