<?php
    ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo EliminarExperiencia($_POST['Cod']);
?>