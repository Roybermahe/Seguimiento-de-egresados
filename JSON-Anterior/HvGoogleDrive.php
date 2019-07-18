<?php
    ob_start();
    session_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    echo HvGoogle_Drive(new HvGoogleDrive($_POST['UrlDrive']));
?>