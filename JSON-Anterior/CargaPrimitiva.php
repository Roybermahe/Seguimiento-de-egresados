<?php 
 
// conexión
$Host = "localhost";
    $Db = "bdegresado";
    $Usuario ="root";
    $Contrasena = "";
    $Conexion = mysqli_connect($Host,$Usuario,$Contrasena,$Db);
 $q = sprintf("INSERT INTO usuarios(NombreUsuario,PassUsuario,Rol) VALUES('%s','%s',5);",
                mysqli_real_escape_string($Conexion,'ADMIN_OFE'),
                password_hash('123', PASSWORD_DEFAULT));
	   mysqli_query($Conexion,$q);
/*if(isset($_POST['enviar']))
{
	mysqli_set_charset($Conexion,"utf8");
  $filename=$_FILES["file"]["name"];
  $info = new SplFileInfo($filename);
  $extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
 
   if($extension == 'csv')
   {
	$filename = $_FILES['file']['tmp_name'];
	$handle = fopen($filename, "r");
 
	while( ($data = fgetcsv($handle, 10000, ";") ) !== FALSE )
	{
       // $q = "INSERT INTO ciudades(NombreCiudad,CodDepartamento  ) VALUES ('".$data[0]."',".$data[1].")";
	  $q = sprintf("INSERT INTO usuarios(NombreUsuario,PassUsuario,Rol) VALUES('%s','%s',3);",
                mysqli_real_escape_string($Conexion,$data[0]),
                password_hash($data[1], PASSWORD_DEFAULT));
	   mysqli_query($Conexion,$q);
   }
 
      fclose($handle);
   }
}*/
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Importación</title>
</head>
<body>
	
<form enctype="multipart/form-data" method="post" action="">
   CSV File:<input type="file" name="file" id="file">
   <input type="submit" value="Enviar" name="enviar">
</form>
 
</body>
</html>