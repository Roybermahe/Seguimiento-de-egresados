<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo HvIdiomas(new PEIdiomas(NULL,NULL,$_POST['Idioma'],$_POST['Escritura'],$_POST['Habla'],$_POST['Lectura'],$_POST['Escucha']));
?>