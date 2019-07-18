<?php
    include('ConexionSesions.php');
    session_start();
    ob_start();
    $Resp='';
    if(($_SESSION['Rol']=='Egresado') || 
      ($_SESSION['Rol']=='Empleado') || 
      ($_SESSION['Rol']=='Empresa')  ||
      ($_SESSION['Rol']=='Admin')){

                mysqli_set_charset($Conexion,"utf8");
                $sql=mysqli_query($Conexion,"SELECT * FROM egresados WHERE CodUsuario=".$_SESSION['CodUser']."");
                $Cedula=mysqli_real_escape_string($Conexion,$_POST['Cedula']);
                $Nombre=mysqli_real_escape_string($Conexion,$_POST['Nombre']);
                $SegundoNombre=mysqli_real_escape_string($Conexion,$_POST['SegundoNombre']); 
                $Apellido=mysqli_real_escape_string($Conexion,$_POST['Apellido']); 
                $SegundoApellido=mysqli_real_escape_string($Conexion,$_POST['SegundoApellido']); 
                $FechaNacimiento=date('Y-m-d',strtotime(str_replace("/","-",mysqli_real_escape_string($Conexion,$_POST['FechaNacimiento'])))); 
                $TelefonoResidencia=mysqli_real_escape_string($Conexion,$_POST['TelefonoResidencia']); 
                $Celular=mysqli_real_escape_string($Conexion,$_POST['Celular']);
                $FechaDeGrado=mysqli_real_escape_string($Conexion,$_POST["FechaDeGrado"]);
                $Correo=mysqli_real_escape_string($Conexion,$_POST['Correo']); 
                $Programa=mysqli_real_escape_string($Conexion,$_POST['Programa']); 
                $Pais=mysqli_real_escape_string($Conexion,$_POST['Pais']); 
                $Departamento=mysqli_real_escape_string($Conexion,$_POST['Departamento']); 
                $Ciudad=mysqli_real_escape_string($Conexion,$_POST['Ciudad']); 
                $ConsultaDeEstado="SELECT * FROM egresados e INNER JOIN respmomento r ON e.CodEgresado = r.Egresado AND e.CodUsuario =".$_SESSION['CodUser'];
                if(mysqli_num_rows($sql)<1){
                    $sql="INSERT INTO egresados(CodUsuario, Nombre,SegundoNombre, Apellido, SegundoApellido, FechaNacimiento, AñoDeEgreso, PaisResidencia, Departamento, Ciudad, TelefonoRes, Correo, Celular,Programa, Cedula, FechaMomentoActual,CodMomentoActual) VALUES (".$_SESSION['CodUser'].",'".$Nombre."','".$SegundoNombre."','".$Apellido."','".$SegundoApellido."','".$FechaNacimiento."',".$FechaDeGrado.",".$Pais.",".$Departamento.",".$Ciudad.",'".$TelefonoResidencia."','".$Correo."','".$Celular."',".$Programa.",'".$Cedula."',SYSDATE(),".UbicarMomento($FechaDeGrado).")";
                    $Resp="<div class='alert alert-success'>Se guardo correctamente tu informacion</div>";
                   
                }else{
                    if(mysqli_num_rows(mysqli_query($Conexion,$ConsultaDeEstado))==0){
                        $sql="UPDATE egresados SET Nombre='".$Nombre."',SegundoNombre='".$SegundoNombre."', Apellido='".$Apellido."', SegundoApellido='".$SegundoApellido."', FechaNacimiento='".$FechaNacimiento."',AñoDeEgreso = ".$FechaDeGrado.", PaisResidencia=".$Pais.", Departamento=".$Departamento.", Ciudad=".$Ciudad.", TelefonoRes='".$TelefonoResidencia."', Correo='".$Correo."', Celular='".$Celular."',Programa=".$Programa.", Cedula='".$Cedula."',FechaMomentoActual = SYSDATE(),CodMomentoActual=".UbicarMomento($FechaDeGrado)." WHERE CodUsuario=".$_SESSION['CodUser'];   
                        $Resp="<div class='alert alert-info'>Se actualizaron correctamente tus datos</div>";
                    }else{
                        $sql="UPDATE egresados SET Nombre='".$Nombre."',SegundoNombre='".$SegundoNombre."', Apellido='".$Apellido."', SegundoApellido='".$SegundoApellido."', FechaNacimiento='".$FechaNacimiento."', PaisResidencia=".$Pais.", Departamento=".$Departamento.", Ciudad=".$Ciudad.", TelefonoRes='".$TelefonoResidencia."', Correo='".$Correo."', Celular='".$Celular."',Programa=".$Programa.", Cedula='".$Cedula."' WHERE CodUsuario=".$_SESSION['CodUser'];
                        $Resp="<div class='alert alert-info'>Se actualizarón los datos pero, el <b>El Año de graduado</b> no puede ser modificado nuevamente.</div>";
                    }
                }
                $resultado = mysqli_query($Conexion,$sql);
                if(!$resultado){
                   $Resp="<div class='alert alert-warning'>Ocurrio un error revisa tus datos</div>"; 
                }
    }
    echo $Resp;


    function UbicarMomento($Fecha){
        $FechaActual = date("Y");
        $Diferencia = $FechaActual - $Fecha;
        $Momento = 2;
        if($Diferencia == 0){
            $Momento = 2;
        }else if($Diferencia >= 1 && $Diferencia < 3){
            $Momento = 1;
        }else if($Diferencia >= 3 && $Diferencia < 5){
            $Momento = 3;
        }else if($Diferencia >= 5){
            $Momento = 4;
        }
        return $Momento;
    }
?>