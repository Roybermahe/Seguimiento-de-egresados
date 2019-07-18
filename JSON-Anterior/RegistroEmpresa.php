<?php
    ob_start();
    include_once('Capas/BLL.php');
    include_once('Capas/Entity.php');
    $year = date("Y");
    $Edad = $year - $_POST['AnyoDeNacimiento'];
    if($Edad>=18){
        $Representante = new RepresentanteEmpresa(NULL,$_POST['Nombres'],$_POST['Apellidos'],$_POST['TipoDocumento'],$_POST['NumeroDocumento'],$_POST['AnyoDeNacimiento'],$_POST['CargoRepresentante'],$_POST['Correo'],$_POST['Telefono'],$_POST['Pass'],$_POST['PassConfirmacion'],NULL);
        $Empresa = new Empresas(NULL,$_POST['TipoDocumendoEP'],$_POST['NumDocumentoEP'],$_POST['RazonSocial'],$_POST['SectorDeEmpresa'],$_POST['Ciudad'],$_POST['TelefonoEP'],$_POST['DireccionEP']);
        echo GuardarRepresentanteEmpresas($Representante,$Empresa);
    }else{
        echo 'Solo pueden registrarse mayores de edad';
    }
?>