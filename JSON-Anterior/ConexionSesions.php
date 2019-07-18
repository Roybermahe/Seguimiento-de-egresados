<?php
ob_start();
    $Host = "localhost";
    $Db = "bdegresado";
    $Usuario ="root";
    $Contrasena = "";
    $Conexion = mysqli_connect($Host,$Usuario,$Contrasena,$Db);
?>