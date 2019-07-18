<?php
session_start();
ob_start(); 
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $Caracter = 2;
    $Mudarse = 'N';
    $Viajar = 'N';
    $Edad =18;
    if(isset($_POST['EdadPostulante'])){$Edad=$_POST['EdadPostulante'];}
    if(isset($_POST['Urgente'])){$Caracter = $_POST['Urgente'];    }
    if(isset($_POST['Mudarse'])){$Mudarse = $_POST['Mudarse'];}
    if(isset($_POST['Viajar'])){$Viajar = $_POST['Viajar'];}
    $Pu= new PublicacionOferta($_POST['Titulo'],$_POST['DescOferta'],$_POST['DescRequis'],$_POST['FechaInicioOferta'],$_POST['FechaFinOferta'], $Caracter,NULL);
    $Est = new ReqAspEstudios($_POST['Estudiosformales'],$_POST['NivelEstudio'],$_POST['AreaEstudio'],$_POST['Idioma'],$_POST['NivelIdioma']);

    $Exp = new ReqAspExperiencia($_POST['Experiencia'],$_POST['Sector'],$_POST['AreaCargo'],$_POST['CargoEquivalente'],$_POST['ExperienciaAnyo'],$_POST['SalarioMinimo'],$_POST['SalarioMaximo']);
    #("abcdefg","abcedfghijklm","aaaaaaaaaaaa","01/08/2019","01/10/2019","true",{"true","01","01","02","B+"},{"5","01","02","03","5","12345","123456"},{"18","true",false})
    $Demo = new ReqAspFiltroDemografico($Edad,$Mudarse,$Viajar);
    echo PublicarOfertaDeEmpleo($Pu,$Est,$Exp,$Demo);
?>