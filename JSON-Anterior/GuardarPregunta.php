<?php
ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
        $Pregunta = NULL;
        $Parte = $_POST['Seccion'];
        $Descripcion = $_POST['Descripcion'];
        $Tipo = $_POST['TipoPregunta'];
        switch($Tipo){
            case 'PR_A':$Pregunta = new PreguntaAbierta(NULL,$Parte,$Descripcion,NULL,NULL);break;
            case 'PR_NU':$Pregunta = new PreguntaNumerica(NULL,$Parte,$Descripcion,NULL,NULL);break;
            case 'PR_SC':$Pregunta = new EstructuraCompleja(NULL,$Parte,$Descripcion,NULL,NULL);break;
            case 'PR_SM':$Pregunta = new SeleccionMultiple(NULL,$Parte,$Descripcion,NULL,NULL);break;
            case 'PR_SN':$Pregunta = new PreguntaSN(NULL,$Parte,$Descripcion,NULL,NULL);break;
            case 'PR_SS':$Pregunta = new EstructuraSimple(NULL,$Parte,$Descripcion,NULL,NULL);break;
            case 'PR_UR':$Pregunta = new UnicaRespuesta(NULL,$Parte,$Descripcion,NULL,NULL);break;
        }
        echo GuardarPregunta($Pregunta);
?>