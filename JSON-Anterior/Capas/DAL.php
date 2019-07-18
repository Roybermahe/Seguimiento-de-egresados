<?php
    include('Conexion.php');
    include_once('Entity.php');
    
    mysqli_set_charset($Conexion,"utf8");
    //  Funciones Generales
    function CantidadFilas($a){return mysqli_num_rows($a);}

    function Mres($a){return mysqli_real_escape_string($GLOBALS['Conexion'],$a);}

    function Consulta($a){return mysqli_query($GLOBALS['Conexion'],$a);}

    function LimpiarRespuestaEgresado($a){$a->CodRespuesta = Mres($a->CodRespuesta);$a->CodRespMomento = Mres($a->CodRespMomento);$a->CodPregunta = Mres($a->CodPregunta);$a->CodPosRespuesta  = Mres($a->CodPosRespuesta);$a->PreguntaSistema = Mres($a->PreguntaSistema);$a->Respuesta = Mres($a->Respuesta);$a->Tipo = Mres($a->Tipo);}

    //  Funciones Guardar en DAL
    function DLGuardarPregunta($a){$Consulta="INSERT INTO pregunta(CodParte,Descripcion,CodTipo) VALUES (".Mres($a->CodParte).",'".Mres($a->Descripcion)."','".Mres($a->CodTipo)."')";return Consulta($Consulta);}
    
    function DLGuardarGrupo($b){$Consulta="INSERT INTO grupo(TituloGrupo,DescripcionGrupo) VALUES ('".Mres($b->TituloGrupo)."','".Mres($b->Descripcion)."')";return Consulta($Consulta);}

    function DLGuardarParte($c){$Consulta="INSERT INTO partes(CodMomento,Descripcion,Info) VALUES (".Mres($c->CodMomento).",'".Mres($c->Descripcion)."','".Mres($c->Info)."')";return Consulta($Consulta);}

    function DLGuardarRespuestas($d){$Consulta="INSERT INTO posrespuestas(CodPregunta,Descripcion,Anotacion,DirPregunta,CodParte,DirGrupo,Espacio) VALUES (".Mres($d->CodPregunta).",'".Mres($d->Descripcion)."','".Mres($d->Anotacion)."',".Mres($d->DirPregunta).",".Mres($d->CodParte).",".Mres($d->DirGrupo).",".Mres($d->Espacio).")";return Consulta($Consulta);}

    function DLGuardarRespuestasUser($j){LimpiarRespuestaEgresado($j);$num=0;if($j->ConsultaNum()!=null){$num = CantidadFilas(Consulta($j->ConsultaNum()));}if($num==0 && $j->ConsultaNum()!=NULL){$Consulta= "INSERT INTO respuestasegresados(CodRespMomento,CodPregunta,CodPosRespuesta, PreguntaSistema,Respuesta) VALUES (".$j->CodRespMomento.",".$j->CodPregunta.",".$j->CodPosRespuesta.",".$j->PreguntaSistema.",'".$j->Respuesta."')";Consulta($Consulta);}else{$res=Consulta($j->Actualizar());} $resultado=Consulta($j->ConocerRespuestas());return CantidadFilas($resultado);}

    function DLHvCrear_Actualizar(){
        $r = Consulta("SELECT * FROM hojasdevida WHERE Egresado =".$_SESSION['CodEgresado']);
        if(CantidadFilas($r)==0){
            Consulta("INSERT INTO hojasdevida(Egresado,Actualizacion) VALUES (".$_SESSION['CodEgresado'].",SYSDATE())");
            $r = Consulta("SELECT * FROM hojasdevida WHERE Egresado =".$_SESSION['CodEgresado']);
        }else{
            Consulta("UPDATE hojasdevida SET Actualizacion=SYSDATE() WHERE Egresado=".$_SESSION['CodEgresado']);
        }
        while($data = mysqli_fetch_object($r)){
                $_SESSION['NumHojaDeVida'] = $data->CodHojaDevida;
        }    
    }
    

    function DLGuardarRepresentanteEmpresas($Rep, $Emp){
        $CodEmp = null;
        $CodUs = null;
        $resp = "No se cargarón los datos correctamente";
        $Error = 0;
        $r=Consulta("SELECT * FROM usuarios WHERE NombreUsuario = '".Mres($Rep->Correo)."'");
        $b=Consulta("SELECT * FROM empresasregistradas WHERE NumeroDocumento = ".Mres($Emp->NumeroDocumento)."");
        if(CantidadFilas($r)>0 && CantidadFilas($b)>0){
            $Error = 3;  
        }else if(CantidadFilas($b)>0){
            $Error = 2;
        }else if(CantidadFilas($r)>0){
            $Error = 1;
        }
        
        switch($Error){
            case 0 : 
            Consulta("INSERT INTO empresasregistradas(TipoDocumento,NumeroDocumento,RazonSocial,NombreComercial,Sector,Ciudad,Telefono, Direccion) VALUES (".Mres($Emp->TipoDocumento).",".Mres($Emp->NumeroDocumento).",'".Mres($Emp->RazonSocial)."','".Mres($Emp->RazonSocial)."',".Mres($Emp->Sector).",".Mres($Emp->Ciudad).",".Mres($Emp->Telefono).",'".Mres($Emp->Direccion)."')");    
                
            $b=Consulta("SELECT * FROM empresasregistradas WHERE NumeroDocumento = ".Mres($Emp->NumeroDocumento)."");
            if(CantidadFilas($b)>0){
                $q = sprintf("INSERT INTO usuarios(NombreUsuario,PassUsuario,Rol) VALUES('%s','%s',4);",
                Mres($Rep->Correo),
                password_hash(Mres($Rep->PassConfirm), PASSWORD_DEFAULT));
                Consulta($q);
                
                $r=Consulta("SELECT * FROM usuarios WHERE NombreUsuario = '".Mres($Rep->Correo)."'");
                while($data = mysqli_fetch_object($b)){
                    $CodEmp = $data->CodEmpresa;
                }               
                while($data2 = mysqli_fetch_object($r)){
                    $CodUs = $data2->CodUsuario;
                }
                
                $f = Consulta("INSERT INTO representantesdeempresas(Nombres, Apellidos,TipoDocumento,NumeroDocumento, AnyoNacimiento, Cargo, Correo, Telefono, CodUsuario, CodEmpresa) VALUES ('".Mres($Rep->Nombres)."','".Mres($Rep->Apellidos)."',".Mres($Rep->TipoDocumento).",".Mres($Rep->NumeroDocumento).",".Mres($Rep->AnyoNacimiento).",'".Mres($Rep->Cargo)."','".Mres($Rep->Correo)."',".Mres($Rep->Telefono).",".$CodUs.",".$CodEmp.")");
                if($f){
                    $resp = "Registro completado";
                }else{
                    $resp = "No se pudo realizar el registro";
                }
                
            }
            return $resp;
            break;
            case 1 : return "El correo (".$Rep->Correo.") se encuentra en uso";break;
            case 2 : return "Ya existe una empresa con este documento: ".$Emp->NumeroDocumento;break;
            case 3 : return "El correo y el numero de documento de la empresa ya estan siendo usados por otro usuario";break;
        }
    }
    function DLHvFormacion_Academica($hv){
        DLHvCrear_Actualizar();
        if($hv->CodEstudio==NULL){
            Consulta("INSERT INTO hvestudios(CodHojaDeVida,NivelEstudio,AreaDeEstudio,Estado,FechaDeInicio,FechaDeFin, TituloRecibido,Instituto,Ciudad) VALUES (".$_SESSION['NumHojaDeVida'].",".Mres($hv->NivelEstudio).",".Mres($hv->Area).",'".Mres($hv->Estado)."','".Mres($hv->FechaDeInicio)."','".Mres($hv->FechaDeFin)."','".Mres($hv->TituloRecibido)."','".Mres($hv->Instituto)."',".Mres($hv->Ciudad).")");
        }else{
            Consulta("UPDATE hvestudios SET NivelEstudio=".Mres($hv->NivelEstudio).",AreaDeEstudio=".Mres($hv->Area).",Estado='".Mres($hv->Estado)."',FechaDeInicio='".Mres($hv->FechaDeInicio)."',FechaDeFin='".Mres($hv->FechaDeFin)."', TituloRecibido='".Mres($hv->TituloRecibido)."',Instituto='".Mres($hv->Instituto)."',Ciudad=".Mres($hv->Ciudad)." WHERE CodEstudio =".Mres($hv->CodEstudio));
        }
    }
                     
    function DLHvPerfil_Laboral($hv){
        DLHvCrear_Actualizar();
        if($hv->CodPerfil==null){
            $r=Consulta("INSERT INTO hvperfileslaborales(CodHojaDeVida,Profesion,DescPerfil,TiempoExperiencia,AspiracionSalarial, Mudarse,Viajar) VALUES (".$_SESSION['NumHojaDeVida'].",'".Mres($hv->Profesion)."','".Mres($hv->DescPerfil)."',".Mres($hv->TiempoExperiencia).",".Mres($hv->AspiracionSalarial).",".Mres($hv->Mudarse).",".Mres($hv->Viajar).")");
            if(!$r){
                 Consulta("UPDATE hvperfileslaborales SET Profesion='".Mres($hv->Profesion)."',DescPerfil='".Mres($hv->DescPerfil)."',TiempoExperiencia=".Mres($hv->TiempoExperiencia).",AspiracionSalarial=".Mres($hv->AspiracionSalarial).", Mudarse=".Mres($hv->Mudarse).",Viajar=".Mres($hv->Viajar)." WHERE CodHojaDeVida=".$_SESSION['NumHojaDeVida']);
            }
        }else{
            Consulta("UPDATE hvperfileslaborales SET Profesion='".Mres($hv->Profesion)."',DescPerfil='".Mres($hv->DescPerfil)."',TiempoExperiencia=".Mres($hv->TiempoExperiencia).",AspiracionSalarial=".Mres($hv->AspiracionSalarial).", Mudarse=".Mres($hv->Mudarse).",Viajar=".Mres($hv->Viajar)." WHERE CodPerfilLaboral=".Mres($hv->CodPerfil));
        }
    }
    
    function DLHvExperiencia_Laboral($hv){
        DLHvCrear_Actualizar();
        if($hv->CodExpLaboral==null){
            Consulta("INSERT INTO experienciaslaborales(CodHojaDeVida,NombreEmpresa,SectorEmpresa, SubSector, FechaDeInicio, FechaDeFin, NombreDelCargo,CodCargoEquivalente, NivelDelCargo, Area_o_Depto, logros_y_Resp, Telefono, Ciudad) VALUES (".$_SESSION['NumHojaDeVida'].",'".Mres($hv->NombreEmpresa)."',".Mres($hv->SectorDeEmpresa).",".Mres($hv->SubSectorDeEmpresa).",'".Mres($hv->FechaDeInicio)."','".Mres($hv->FechaDeFin)."','".Mres($hv->NombreDelCargo)."',".Mres($hv->CargoEquivalente).",".Mres($hv->NivelDelCargo).",".Mres($hv->Area_o_Depto).",'".Mres($hv->Logro_y_Resp)."',".Mres($hv->Telefono).",'".Mres($hv->Ciudad)."')");
        }else{
            Consulta("UPDATE experienciaslaborales SET NombreEmpresa='".Mres($hv->NombreEmpresa)."',SectorEmpresa=".Mres($hv->SectorDeEmpresa).", SubSector=".Mres($hv->SubSectorDeEmpresa).", FechaDeInicio='".Mres($hv->FechaDeInicio)."', FechaDeFin='".Mres($hv->FechaDeFin)."', NombreDelCargo='".Mres($hv->NombreDelCargo)."',CodCargoEquivalente=".Mres($hv->CargoEquivalente).", NivelDelCargo=".Mres($hv->NivelDelCargo).", Area_o_Depto=".Mres($hv->Area_o_Depto).", logros_y_Resp='".Mres($hv->Logro_y_Resp)."', Telefono=".Mres($hv->Telefono).", Ciudad='".Mres($hv->Ciudad)."' WHERE CodExpLaboral=".Mres($hv->CodExpLaboral));
        }
    }
                     
    function DLHvGoogle_Drive($hv){
        DLHvCrear_Actualizar();
        Consulta("UPDATE hojasdevida SET Drive='".Mres($hv->DriveFile)."' WHERE CodHojaDevida=".$_SESSION['NumHojaDeVida']);
        return $hv->EmbedCarpeta();
    }
                     
    function DLHvIdiomas($hv){
        DLHvCrear_Actualizar();
        if($hv->CodIdioma==null){
            $r=Consulta("SELECT * FROM hvidiomas WHERE Idioma=".Mres($hv->Idioma)." AND CodHojaDevida=".$_SESSION['NumHojaDeVida']);
            if(CantidadFilas($r)>0){
                Consulta("UPDATE hvidiomas SET Idioma=".Mres($hv->Idioma).", Escritura='".Mres($hv->Escritura)."', Habla='".Mres($hv->Habla)."', Lectura='".Mres($hv->Lectura)."', Escucha='".Mres($hv->Escucha)."' WHERE Idioma=".Mres($hv->Idioma)." AND CodHojaDevida=".$_SESSION['NumHojaDeVida']);
            }else{
                Consulta("INSERT INTO hvidiomas(CodHojaDevida,Idioma, Escritura, Habla, Lectura, Escucha) VALUES (".$_SESSION['NumHojaDeVida'].",".Mres($hv->Idioma).",'".Mres($hv->Escritura)."','".Mres($hv->Habla)."','".Mres($hv->Lectura)."','".Mres($hv->Escucha)."')");
            }
        }else{
            Consulta("UPDATE hvidiomas SET Idioma=".Mres($hv->Idioma).", Escritura='".Mres($hv->Escritura)."', Habla='".Mres($hv->Habla)."', Lectura='".Mres($hv->Lectura)."', Escucha='".Mres($hv->Escucha)."' WHERE CodIdioma=".Mres($hv->CodIdioma));
        }
    }
                     
    function DLHvRedes_Sociales($hv){
        DLHvCrear_Actualizar();
        Consulta("UPDATE hojasdevida SET Facebook='".Mres($hv->Facebook)."', Twitter='".Mres($hv->Twitter)."', `Google+`='".Mres($hv->Google)."' WHERE CodHojaDevida=".$_SESSION['NumHojaDeVida']);
    }
    
    // Funciones Actualizar en DAL
    function DLActualizarEstado($e){$Consulta="UPDATE pregunta SET Estado=".Mres($e->Estado)." WHERE CodPregunta =".Mres($e->CodPregunta)."";return Consulta($Consulta);}

    function DLActualizarParte($f){$Consulta="UPDATE partes SET Descripcion='".Mres($f->Descripcion)."' WHERE CodParte =".Mres($f->CodParte)."";return Consulta($Consulta);}

    function DLActualizarInfoParte($f){$Consulta="UPDATE partes SET Info='".Mres($f->Info)."' WHERE CodParte =".Mres($f->CodParte)."";return Consulta($Consulta);}

    function DLActualizarRespuesta($g){$Consulta=$Consulta="UPDATE  posrespuestas SET CodPregunta=".Mres($g->CodPregunta).",Descripcion='".Mres($g->Descripcion)."',Anotacion='".Mres($g->Anotacion)."',DirPregunta=".Mres($g->DirPregunta).",CodParte=".Mres($g->CodParte).",Espacio=".Mres($g->Espacio)." ,DirGrupo=".Mres($g->DirGrupo)." WHERE CodRespuesta=".Mres($g->CodRespuesta)."";return Consulta($Consulta);}

    function DLActualizarPregunta($h){$Consulta="UPDATE pregunta SET Descripcion='".Mres($h->Descripcion)."' WHERE CodPregunta =".Mres($h->CodPregunta)."";return Consulta($Consulta);}
    
    function DLActualizarGrupo($i){$Consulta="UPDATE pregunta SET CodGrupo=".Mres($i->CodGrupo)." WHERE CodPregunta=".Mres($i->CodPregunta)."";return Consulta($Consulta);}

    function DLActualizarGrupo2($i){$Consulta="UPDATE grupo SET DescripcionGrupo='".Mres($i->Descripcion)."',TituloGrupo='".Mres($i->TituloGrupo)."' WHERE CodGrupo=".Mres($i->CodGrupo)."";return Consulta($Consulta);}

    function DLLimpiarSiguiente($j){$s=Consulta("SELECT * FROM respuestasegresados WHERE CodRespMomento=".$_SESSION['CodRespMomento']." AND CodPregunta=".$j." AND UPPER(Respuesta) IN (UPPER('Ninguno'),UPPER('No Tengo'))");if(CantidadFilas($s)==1){while($d=mysqli_fetch_object($s)){Consulta("DELETE FROM respuestasegresados WHERE CodRespMomento=".$d->CodRespMomento." AND CodPregunta=".$d->CodPregunta." AND CodRespuesta!=".$d->CodRespuesta."");}}}

    function DLFinalizarEncuesta(){$r=Consulta("SELECT COUNT(CodPregunta) as Total FROM respuestasegresados WHERE CodRespMomento=".$_SESSION['CodRespMomento']." GROUP BY CodPregunta");Consulta("UPDATE respmomento SET FechaReal=SYSDATE(),DiasEnDiligenciar=DATEDIFF(SYSDATE(),'".$_SESSION['FechaEstipulada']."'),TotalPreguntas=".CantidadFilas($r)." WHERE CodRespMomento=".$_SESSION['CodRespMomento']."");ActualizarMomentoDeEgresado();}

    function ActualizarMomentoDeEgresado(){
        $Diferencia = date("Y") - $_SESSION["AñoDeEgreso"]; 
        if($_SESSION['MomentoActual']==2){	
            Consulta("UPDATE egresados d SET d.FechaMomentoActual=DATE_ADD(DATE_ADD(d.FechaMomentoActual,INTERVAL 1 YEAR),INTERVAL DATEDIFF(SYSDATE(),'".$_SESSION['FechaEstipulada']."') DAY),d.CodMomentoActual=1 WHERE d.CodUsuario=".$_SESSION['CodUser']);
        }
        else if($_SESSION['MomentoActual']==1){
            $var_Years = 3-$Diferencia; 
            Consulta("UPDATE egresados d SET d.FechaMomentoActual=DATE_ADD(DATE_ADD(d.FechaMomentoActual,INTERVAL ".$var_Years." YEAR),INTERVAL DATEDIFF(SYSDATE(),'".$_SESSION['FechaEstipulada']."') DAY),d.CodMomentoActual=3 WHERE d.CodUsuario=".$_SESSION["CodUser"]);
        }
        else if($_SESSION['MomentoActual']==3){
            $var_Years = 5-$Diferencia;
            Consulta("UPDATE egresados d SET d.FechaMomentoActual=DATE_ADD(DATE_ADD(d.FechaMomentoActual,INTERVAL $var_Years YEAR),INTERVAL DATEDIFF(SYSDATE(),'".$_SESSION['FechaEstipulada']."') DAY),d.CodMomentoActual=4 WHERE d.CodUsuario=".$_SESSION["CodUser"]);
        }
        else if($_SESSION['MomentoActual']==4){
            Consulta("UPDATE egresados d SET d.FechaMomentoActual=NULL, d.CodMomentoActual=NULL WHERE d.CodUsuario=".$_SESSION['CodUser']);
        }
    }
    //Funciones Consultar en DAL
    function DLConsultaInfoEgresados(){
        $Data = array();
        $sql=Consulta('SELECT e.CodEgresado,e.AñoDeEgreso, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, e.Ciudad,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = e.CodUsuario) as ImgFormat, e.TelefonoRes, e.Correo, e.Celular,e.Programa, e.Cedula, e.FechaMomentoActual ,(SELECT m.Descripcion FROM momento m WHERE e.CodMomentoActual=m.CodMomento) as Descripcion,e.CodMomentoActual,(SELECT m.Documentacion FROM momento m WHERE e.CodMomentoActual=m.CodMomento) as Documentacion,IF((e.FechaMomentoActual>SYSDATE() OR  e.FechaMomentoActual is NULL),"NO","SI") as RealizarEncuesta,IF((e.FechaMomentoActual is NULL AND e.CodMomentoActual is NULL),"NO","SI") as NotificarEncuesta FROM egresados e WHERE e.CodUsuario='.$_SESSION['CodUser']);
             
            while($datos =  mysqli_fetch_object($sql)){
            $date = NULL;
            if($datos->FechaMomentoActual!=NULL){
                setlocale(LC_ALL,"es_ES");
                 $date=strftime("%A %d de %B del %Y",strtotime($datos->FechaMomentoActual));
//                $date=date('d l Y',strtotime($datos->FechaMomentoActual));
            }
            if($datos->ImgFormat!=NULL){
                $ImgFormat = explode(";",$datos->ImgFormat);
                $Type = explode("/",$ImgFormat[0]);
                $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$_SESSION['CodUser']).".".$Type[1];
            }else{
                $Img ="img/gender-neutral-user.jpg";
            }
            $Data[] = array("Nombre"=>$datos->Nombre,
                            "SegundoNombre"=>$datos->SegundoNombre,
                            "Apellido"=>$datos->Apellido,
                            "SegundoApellido"=>$datos->SegundoApellido,
                            "FechaNacimiento"=>date('d/m/Y',strtotime($datos->FechaNacimiento)),
                            "FechaDeGrado"=>$datos->AñoDeEgreso,
                            "PaisResidencia"=>$datos->PaisResidencia,
                            "Departamento"=>$datos->Departamento,
                            "Ciudad"=>$datos->Ciudad,
                            "TelefonoResidencia"=>$datos->TelefonoRes,
                            "NombreCompleto"=>strtoupper($datos->Nombre." ".$datos->SegundoNombre." ".$datos->Apellido." ".$datos->SegundoApellido),
                            "Correo"=>$datos->Correo,
                            "Celular"=>$datos->Celular,
                            "Image"=>$Img,
                            "Programa"=>$datos->Programa,
                            "Cedula"=>$datos->Cedula,
                            "FechaMomentoActual"=>$date,
                            "CodMomentoActual"=>$datos->CodMomentoActual,
                            "DescMomento"=>$datos->Descripcion,
                            "Documentacion"=>$datos->Documentacion,
                            "Realizar"=>$datos->RealizarEncuesta,
                            "Notificar"=>$datos->NotificarEncuesta);
                $_SESSION['PermisoDeNotificar']=$datos->NotificarEncuesta;
                $_SESSION['PermisoDeRealizar']=$datos->RealizarEncuesta;
                $_SESSION['MomentoActual']=$datos->CodMomentoActual;
                $_SESSION['CodEgresado']=$datos->CodEgresado;
                $_SESSION['AñoDeEgreso']=$datos->AñoDeEgreso;
                $_SESSION['FechaEstipulada']=$datos->FechaMomentoActual;
            }
            return json_encode($Data); 
    }
    
    function DLConsultaInfoEmpresa(){
        $Data =array();
        $sql = Consulta("SELECT (SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = re.CodUsuario) as ImgFormat,re.Nombres,re.Apellidos,td.Descripcion as TipoDocumento,re.NumeroDocumento,re.AnyoNacimiento,re.Cargo,re.Correo ,re.Telefono ,em.CodEmpresa,em.Fax,em.PaginaWeb,em.NumDeEmpleados,em.NombreComercial,tda.Descripcion as TipoDocumentoEP,em.NumeroDocumento as NumeroDocumentoEP,em.RazonSocial ,sec.Sector,em.Sector as CodSectorEP,(SELECT dep.CodPais FROM departamentos dep WHERE dep.CodDepartamento = ciu.CodDepartamento) as pais,ciu.CodDepartamento,em.Ciudad,ciu.NombreCiudad ,em.Telefono as TelefonoEP,em.Direccion ,fot.CodigoArchivo ,em.TipoDocumento as codTipoDocumentoEP,re.TipoDocumento as codTipoDocumento,fot.Base64 FROM representantesdeempresas re INNER JOIN empresasregistradas em ON re.CodEmpresa = em.CodEmpresa LEFT JOIN fotosdeusuarios fot ON fot.CodUsuario=re.CodUsuario INNER JOIN ciudades ciu ON em.Ciudad = ciu.CodCiudad INNER JOIN tiposdocumentos td ON td.CodDocumento = re.TipoDocumento INNER JOIN tiposdocumentos tda ON tda.CodDocumento = em.TipoDocumento INNER JOIN sectordeempresas sec ON sec.CodSector = em.Sector AND re.CodUsuario = ".$_SESSION['CodUser']);
        while($datos = mysqli_fetch_object($sql)){
            if($datos->ImgFormat!=NULL){
                $ImgFormat = explode(";",$datos->ImgFormat);
                $Type = explode("/",$ImgFormat[0]);
                $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$_SESSION['CodUser']).".".$Type[1];
            }else{
                $Img ="img/gender-neutral-user.jpg";
            }
            $Data[] = array("Image"=>$Img,
                            "Nombres"=>$datos->Nombres,
                            "Apellidos"=>$datos->Apellidos,
                            "TipoDocumento"=>$datos->TipoDocumento,
                            "TipoDoc"=>$datos->codTipoDocumento,
                            "NumeroDocumento"=>$datos->NumeroDocumento,
                            "AnyoNacimiento"=>$datos->AnyoNacimiento,
                            "Cargo"=>$datos->Cargo,
                            "Correo"=>$datos->Correo,
                            "Telefono"=>$datos->Telefono,
                            "TipoDocumentoEP"=>$datos->TipoDocumentoEP,
                            "TipoDocEP"=>$datos->codTipoDocumentoEP,
                            "NumeroDocumentoEP"=>$datos->NumeroDocumentoEP,
                            "RazonSocial"=>$datos->RazonSocial,
                            "NomComercial"=>$datos->NombreComercial,
                            "Sector"=>$datos->Sector,
                            "CodSector"=>$datos->CodSectorEP,
                            "Pais"=>$datos->pais,
                            "Depto"=>$datos->CodDepartamento,
                            "Ciudad"=>$datos->Ciudad,
                            "NombreCiudad"=>$datos->NombreCiudad,
                            "TelefonoEP"=>$datos->TelefonoEP,
                            "FaxEp"=>$datos->Fax,
                            "PaginaEp"=>$datos->PaginaWeb,
                            "NumEmpleados"=>$datos->NumDeEmpleados,
                            "Direccion"=>$datos->Direccion);
        }
        return json_encode($Data);
    }

    function DLEPConsultarNumeroEmpleados(){
        $Data = array();
        $sql = Consulta("SELECT * FROM numerodeempleados");
        while($datos = mysqli_fetch_object($sql)){
            $Data[] = array("Cod"=>$datos->CodNumero,
                           "Desc"=>$datos->Descripcion);
        }
        return json_encode($Data);
    }
    function DLHvConsultarAreasDeEstudio($hv){
        $r=Consulta("SELECT CodArea,Area FROM areadeestudio WHERE CodNivelEstudio = ".Mres($hv));
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodArea,
                            "Desc"=>$datos->Area);
        }
        return json_encode($Data);
    }
    
    function DLHvListaDeIdiomas(){
        $r=Consulta("SELECT * FROM hvlistadeidiomas");
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodIdioma,
                            "Desc"=>$datos->DescIdioma);
        }
        return json_encode($Data);
    }

    function DLHvNivelesDeEstudio(){
        $r=Consulta("SELECT CodNivelEstudio, Descripcion FROM nivelesdeestudio");
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodNivelEstudio,
                            "Desc"=>$datos->Descripcion);
        }
        return json_encode($Data);
    }

    function DLSectorDeEmpresas(){
        $r=Consulta("SELECT CodSector, Sector FROM sectordeempresas");
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodSector,
                            "Desc"=>$datos->Sector);
        }
        return json_encode($Data);
    }
    
    function DLSubSectorDeEmpresa($hv){
        $r=Consulta("SELECT CodSubSector,SubSector, CodSector FROM subsectorempresas WHERE CodSector =".Mres($hv));
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodSubSector,
                            "Desc"=>$datos->SubSector);
        }
        return json_encode($Data);
    }

    function DLAreaDeCargo(){
         $r=Consulta("SELECT CodArea, Area FROM areadecargo");
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodArea,
                            "Desc"=>$datos->Area);
        }
        return json_encode($Data);
    }
    
    function DLNivelDeCargo(){
        $r=Consulta("SELECT CodNivelCargo, NivelCargo FROM nivelesdecargos");
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodNivelCargo,
                            "Desc"=>$datos->NivelCargo);
        }
        return json_encode($Data);
    }

    function DLCargosEquivalentes(){
        $r=Consulta("SELECT CodCargoEquivalente, Descripcion FROM hvCargosEquivalentes");
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $Data[] = array("Cod"=>$datos->CodCargoEquivalente,
                            "Desc"=>$datos->Descripcion);
        }
        return json_encode($Data);
    }
    function DLConsultarMIN_MAX(){$r=Consulta("SELECT DATE_FORMAT(MIN(r.FechaDeCreacion),'%d-%m-%Y') as mindate, DATE_FORMAT(MAX(r.FechaDeCreacion),'%d-%m-%Y') as maxdate FROM respuestasegresados r WHERE r.FechaDeCreacion is NOT null  ");$Data=array();while($datos = mysqli_fetch_object($r)){$Data[] = array("mindate"=>$datos->mindate,"maxdate"=>$datos->maxdate);}return json_encode($Data);}

    function DLConsultarGrupo(){$Consulta = "SELECT * FROM grupo order by TituloGrupo asc";$sql=Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("TituloGrupo"=> $datos->TituloGrupo,"DescripcionGrupo" =>$datos->DescripcionGrupo,"CodGrupo"=>$datos->CodGrupo);} return "".json_encode($Data)."";}

    function DLConsultarMomentos(){$Consulta = "SELECT * FROM momento order by Descripcion desc";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodMomento"=> $datos->CodMomento,"Descripcion" =>$datos->Descripcion,"Documentacion" =>$datos->Documentacion);}return json_encode($Data);}
    
    function DLConsultarDocNatural(){
        $Datos = array();
        $r = Consulta("SELECT * FROM TiposDocumentos WHERE Persona ='N'");
        while($data = mysqli_fetch_object($r)){
            $Datos[] = array("Cod"=>$data->CodDocumento,"Desc"=>$data->Descripcion);
        }
        return json_encode($Datos);
    }

    function DLConsultarDocJuridica(){
        $Datos = array();
        $r = Consulta("SELECT * FROM TiposDocumentos WHERE Persona ='J'");
        while($data = mysqli_fetch_object($r)){
            $Datos[] = array("Cod"=>$data->CodDocumento,"Desc"=>$data->Descripcion);
        }
        return json_encode($Datos);
    }

    function DLConsultarPartes(){$Consulta = "SELECT p.CodMomento, p.CodParte,m.Descripcion as DescMomento,p.Descripcion, (SELECT COUNT(*) FROM pregunta WHERE CodParte = P.CodParte GROUP BY CodParte) as Preguntas,p.Info FROM partes p LEFT JOIN momento m on p.CodMomento = m.CodMomento ";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$cantidad = 0;if($datos->Preguntas != null){$cantidad = $datos->Preguntas;}$Data[] = array("CodParte" =>$datos->CodParte,"DescMomento" =>$datos->DescMomento,"Descripcion" =>$datos->Descripcion,"CodMomento" =>$datos->CodMomento,"Preguntas" =>"".$cantidad."","Info" =>$datos->Info,"RealDescripcion"=>Mres($datos->Descripcion));} return json_encode($Data);}
    
    function DLTagsCiudades(){
        $Consulta = "SELECT c.CodCiudad,p.NombrePais,d.NombreDepartamento,c.NombreCiudad FROM departamentos d INNER JOIN ciudades c ON d.CodDepartamento = c.CodDepartamento INNER JOIN pais p ON d.CodPais = p.CodPais";
        $sql = Consulta($Consulta);
        $Ciudad = array();
        while($datos = mysqli_fetch_object($sql)){
            array_push($Ciudad,$datos->NombrePais.", ".$datos->NombreDepartamento.", ".$datos->NombreCiudad);
        }
        return json_encode($Ciudad);
    }
    
    function DLConsultarPartesDeMomento($m){$Consulta = "SELECT p.CodMomento, p.CodParte,m.Descripcion as DescMomento,p.Descripcion, (SELECT COUNT(*) FROM pregunta WHERE CodParte = P.CodParte GROUP BY CodParte) as Preguntas FROM partes p LEFT JOIN momento m on p.CodMomento = m.CodMomento WHERE p.CodMomento=".Mres($m->CodMomento);$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$cantidad = 0;if($datos->Preguntas != null){$cantidad = $datos->Preguntas;}$Data[] = array("CodParte"=> $datos->CodParte,"DescMomento" =>$datos->DescMomento,"Descripcion" =>$datos->Descripcion,"CodMomento" =>$datos->CodMomento,"Preguntas" =>"".$cantidad."",   "RealDescripcion"=>Mres($datos->Descripcion));}return json_encode($Data);}
    
    function DLConsultarPosRespuestas($n){$Consulta = "SELECT * FROM posrespuestas WHERE CodPregunta=".Mres($n->CodPregunta)." order by CodRespuesta desc";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodRespuesta"=> $datos->CodRespuesta,"CodPregunta" =>$datos->CodPregunta,"Descripcion" =>$datos->Descripcion,"Anotacion" =>$datos->Anotacion,"DirPregunta" =>$datos->DirPregunta,"CodParte" =>$datos->CodParte,"DirGrupo" =>$datos->DirGrupo,"Espacio" =>$datos->Espacio,"RealDescripcion"=>Mres($datos->Descripcion));}return json_encode($Data);}

    function DLConsultarPosRespuestasDos($o){$Consulta = "SELECT pos.CodRespuesta,pos.CodPregunta,pos.Descripcion,pos.Anotacion,pos.DirPregunta,pos.CodParte,pos.Espacio,p.CodTipo,p.Descripcion as DescPregunta FROM posrespuestas pos inner join pregunta p on p.CodPregunta = pos.CodPregunta AND p.CodPregunta=".Mres($o->CodPregunta);$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodRespuesta"=> $datos->CodRespuesta,"CodPregunta" =>$datos->CodPregunta,"Descripcion" =>$datos->Descripcion,"Anotacion" =>$datos->Anotacion,       "DirPregunta" =>$datos->DirPregunta,"CodParte" =>$datos->CodParte,"Espacio" =>$datos->Espacio,"CodTipo" =>$datos->CodTipo,           "DescPregunta" => $datos->DescPregunta,"RealDescripcion"=>Mres($datos->Descripcion));}return json_encode($Data);}

   function DLConsultarPreguntas2($p){$Consulta = "SELECT p.CodGrupo,p.CodPregunta, p.CodParte,pr.Descripcion as DescParte,pr.CodMomento,p.Estado,(SELECT Descripcion FROM momento m WHERE m.CodMomento = pr.CodMomento) as DescMomento,(SELECT g.TituloGrupo FROM grupo g WHERE g.CodGrupo = p.CodGrupo) as TituloGrupo,(SELECT g.DescripcionGrupo FROM grupo g WHERE g.CodGrupo = p.CodGrupo) as DescGrupo,p.Descripcion,p.CodTipo,tp.Descripcion as DescTipo FROM pregunta p INNER JOIN tipopregunta tp ON p.CodTipo = tp.CodTipo INNER JOIN partes pr ON p.CodParte = pr.CodParte AND p.CodParte = ".Mres($p)." order by p.CodPregunta asc";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"DescParte" =>$datos->DescParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,"DescTipo" =>$datos->DescTipo,"CodMomento" =>$datos->CodMomento,"DescMomento" =>$datos->DescMomento,"CodGrupo"=>$datos->CodGrupo,"TituloGrupo"=>$datos->TituloGrupo,         "DescGrupo"=>$datos->DescGrupo,"Estado"=>$datos->Estado,"RealDescripcion"=>Mres($datos->Descripcion));}return json_encode($Data);}

    function DLConsultarPreguntas($sec){if($sec!=null){$Consulta = "SELECT p.CodGrupo,p.CodPregunta, p.CodParte,pr.Descripcion as DescParte,pr.CodMomento,p.Estado,(SELECT Descripcion FROM momento m WHERE m.CodMomento = pr.CodMomento) as DescMomento,(SELECT g.TituloGrupo FROM grupo g WHERE g.CodGrupo = p.CodGrupo) as TituloGrupo,(SELECT g.DescripcionGrupo FROM grupo g WHERE g.CodGrupo = p.CodGrupo) as DescGrupo,p.Descripcion,p.CodTipo,tp.Descripcion as DescTipo FROM pregunta p INNER JOIN tipopregunta tp ON p.CodTipo = tp.CodTipo INNER JOIN partes pr ON p.CodParte = pr.CodParte AND p.CodParte=".Mres($sec)." order by p.CodPregunta asc"; }else{$Consulta = "SELECT p.CodGrupo,p.CodPregunta, p.CodParte,pr.Descripcion as DescParte,pr.CodMomento,p.Estado,(SELECT Descripcion FROM momento m WHERE m.CodMomento = pr.CodMomento) as DescMomento,(SELECT g.TituloGrupo FROM grupo g WHERE g.CodGrupo = p.CodGrupo) as TituloGrupo,(SELECT g.DescripcionGrupo FROM grupo g WHERE g.CodGrupo = p.CodGrupo) as DescGrupo,p.Descripcion,p.CodTipo,tp.Descripcion as DescTipo FROM pregunta p INNER JOIN tipopregunta tp ON p.CodTipo = tp.CodTipo INNER JOIN partes pr ON p.CodParte = pr.CodParte order by p.CodPregunta asc";    } $sql = Consulta($Consulta); $Data = array(); while($datos =  mysqli_fetch_object($sql)){if($datos->Estado==0){           $Estado="<button type='button' id='EST".$datos->CodPregunta."' class='btn btn-dark' onclick='CambiarEstado(".$datos->CodPregunta.",".$datos->Estado.")'>E</button>";}else{$Estado="<button type='button' id='EST".$datos->CodPregunta."' class='btn btn-success' onclick='CambiarEstado(".$datos->CodPregunta.",".$datos->Estado.")'>E</button>";                  }$Data["data"][]=array("<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#largeShoes' onclick='ConstruirEstructura(\"".$datos->CodTipo."\",\"".$datos->DescTipo."\",\"".Mres($datos->Descripcion)."\",".$datos->CodPregunta.",".$datos->CodParte.",\"".trim(substr($datos->DescParte,0,20))."\",\"".$datos->CodMomento."\",\"".$datos->DescMomento."\")'>Editar</button>","".$datos->CodPregunta."","<textarea class='form-control' id='".$datos->CodPregunta."' rows='3' placeholder='Ingresa una pequeña descripcion para esta seccion' name='Descripcion' style='height: 35px;' onchange='ModificarPregunta(".$datos->CodPregunta.",\"".Mres($datos->Descripcion)."\")'>".$datos->Descripcion."</textarea>","".$datos->DescTipo."","<button type='button' class='btn btn-info' data-toggle='modal' data-target='#VerPregunta' class='btn btn-info' onclick='View(".$datos->CodPregunta.")'>V</button>",$Estado,    "<button class='btn btn-danger' onclick='Eliminar(".$datos->CodPregunta.",\"".Mres($datos->Descripcion)."\")'>Eliminar</button>");}return json_encode($Data);}
    
    function DLConsultarPreguntasDePartes($q){$Consulta = "SELECT p.CodGrupo,p.CodPregunta, p.CodParte,pr.Descripcion as DescParte,pr.CodMomento,(SELECT Descripcion FROM momento m WHERE m.CodMomento = pr.CodMomento) as DescMomento,p.Descripcion,p.CodTipo,tp.Descripcion as DescTipo FROM pregunta p INNER JOIN tipopregunta tp ON p.CodTipo = tp.CodTipo INNER JOIN partes pr ON p.CodParte = pr.CodParte WHERE p.CodParte=".Mres($q->CodParte);$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"DescParte" =>$datos->DescParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,"DescTipo" =>$datos->DescTipo,"CodMomento" =>$datos->CodMomento,"DescMomento" =>$datos->DescMomento,"CodGrupo"=>$datos->CodGrupo,"RealDescripcion"=>Mres($datos->Descripcion));}return json_encode($Data);}

    function DLConsultarPreguntaUnica($r){$Consulta = "SELECT p.CodGrupo,p.CodPregunta, p.Estado,p.CodParte,pr.Descripcion as DescParte,pr.CodMomento,(SELECT Descripcion FROM momento m WHERE m.CodMomento = pr.CodMomento) as DescMomento,p.Descripcion,p.CodTipo,tp.Descripcion as DescTipo FROM pregunta p INNER JOIN tipopregunta tp ON p.CodTipo = tp.CodTipo INNER JOIN partes pr ON p.CodParte = pr.CodParte WHERE p.CodPregunta=".Mres($r->CodPregunta)."";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"DescParte" =>$datos->DescParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,"DescTipo" =>$datos->DescTipo,"CodMomento" =>$datos->CodMomento,"DescMomento" =>$datos->DescMomento,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,"RealDescripcion"=>Mres($datos->Descripcion));}return json_encode($Data);}

    function DLConsultarTiposPreguntas(){$Consulta = "SELECT * FROM tipopregunta order by Descripcion asc";$sql = Consulta($Consulta);$Data = array();while($datos = mysqli_fetch_object($sql)){$Data[] = array("CodTipo"=> $datos->CodTipo,"Descripcion" =>$datos->Descripcion);}return json_encode($Data);}
    // Funciones de Eliminar en DAL
    function DLEliminarGrupo($t){$Consulta="DELETE FROM grupo WHERE CodGrupo = ".Mres($t->CodGrupo)."";$Resultado = Consulta($Consulta);return $Resultado;}
    
    function DLEliminarParte($u){$Consulta="DELETE FROM partes WHERE CodParte = ".Mres($u->CodParte)."";$Resultado = Consulta($Consulta);return $Resultado;}
    
    function DLEliminarPregunta($v){$Consulta="DELETE FROM pregunta WHERE CodPregunta = ".Mres($v->CodPregunta)."";$Resultado = Consulta($Consulta);return $Resultado;}
    
    function DLEliminarRespuesta($w){$Consulta="DELETE FROM posrespuestas WHERE CodRespuesta = ".Mres($w->CodRespuesta)."";$Resultado = Consulta($Consulta);return $Resultado;}

    //Metodos de Intuitivos DAL
    function Respuestas($CodPregunta){if(isset($_SESSION['CodRespMomento']) && $_SESSION['CodRespMomento'] != NULL){$sql = "SELECT * FROM respuestasegresados r WHERE r.CodPregunta=".$CodPregunta." and r.CodRespMomento = ".$_SESSION['CodRespMomento']."";$resultado = Consulta($sql);if(CantidadFilas($resultado)>=1){$respuestas = array();while($datos=mysqli_fetch_object($resultado)){$respuestas[] = array("CodRespuesta"=>$datos->CodRespuesta,"CodRespMomento"=>$datos->CodRespMomento,"CodPregunta"=>$datos->CodPregunta,"CodPosRespuesta"=>$datos->CodPosRespuesta,"PreguntaSistema"=>$datos->PreguntaSistema,"Respuesta"=>$datos->Respuesta);}return $respuestas;}}}

    function AvanceProgresivo(){DLLimpiarSiguiente($_SESSION['PreguntaActual']);$Consulta="SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=".$_SESSION['ParteActual']." AND p.CodPregunta>".$_SESSION['PreguntaActual']." AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1";$Resultado=mysqli_query($GLOBALS['Conexion'],$Consulta); $Num=mysqli_num_rows($Resultado);if($Num==1){return CuerpoDePregunta($Consulta);}else if($Num==0){$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=(SELECT d.CodParte FROM partes d WHERE d.CodMomento=".$_SESSION['MomentoActual']." AND d.CodParte>".$_SESSION['ParteActual']." ORDER BY d.CodParte ASC LIMIT 1) and p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1 ";return CuerpoDePregunta($Consulta);}}

    function AvanceGrupoDePregunta(){DLLimpiarSiguiente($_SESSION['PreguntaActual']);$Consulta="SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=".$_SESSION['ParteActual']." AND p.CodPregunta>".$_SESSION['PreguntaActual']." AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 AND p.CodGrupo=".$_SESSION['DirGrupo']." ORDER BY p.CodPregunta ASC LIMIT 1;";$Resultado = mysqli_query($GLOBALS['Conexion'],$Consulta);$Num=mysqli_num_rows($Resultado);if($Num==1){return CuerpoDePregunta($Consulta);}else if($Num==0){     $_SESSION['DirGrupo']=NULL;$_SESSION['FinGrupo']=TRUE;$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=(SELECT d.CodParte FROM partes d WHERE d.CodMomento=".$_SESSION['MomentoActual']." AND d.CodParte>".$_SESSION['ParteActual']." ORDER BY d.CodParte ASC LIMIT 1) AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1 ";return            CuerpoDePregunta($Consulta);}}

    function CuerpoDePregunta($Consulta){$sql=Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=>$datos->CodPregunta,"CodParte"=>$datos->CodParte,"Descripcion"=>$datos->Descripcion,"CodTipo"=>$datos->CodTipo,"DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,"Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaActual']= $datos->CodPregunta;$_SESSION['ParteActual']=$datos->CodParte;$_SESSION['CodTipo']=$datos->CodTipo;}return json_encode($Data);}

//    function DirigeVariasPreguntas(){
//        $Consulta = "SELECT (SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=pr.CodParte) as DescParte,pr.CodPregunta,pr.CodParte,pr.Descripcion,pr.CodTipo,pr.CodGrupo,pr.Estado FROM posrespuestas pos INNER JOIN respuestasegresados rep ON rep.CodPosRespuesta = pos.CodRespuesta INNER JOIN pregunta pr ON pr.CodPregunta = pos.DirPregunta AND rep.CodRespMomento=".$_SESSION['CodRespMomento']." AND rep.CodPregunta=".$_SESSION['PreguntaActual']."";
//        $Resultado = mysqli_query($GLOBALS['Conexion'],$Consulta);
//        $Num = mysqli_num_rows($Resultado);
//        if($Num>1){
//            PreguntaParcial();
//        }else if($Num==1){
//            CuerpoDePregunta($Consulta);
//        }
//    }
    
    function PreguntaParcial(){if(isset($_SESSION['PreguntaParcial']) || $_SESSION['PreguntaParcial']!=null){DLLimpiarSiguiente($_SESSION['PreguntaParcial']);$Consulta="SELECT (SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=pr.CodParte) as DescParte,pr.CodPregunta,pr.CodParte,pr.Descripcion,pr.CodTipo,pr.CodGrupo,pr.Estado FROM posrespuestas pos INNER JOIN respuestasegresados rep ON rep.CodPosRespuesta = pos.CodRespuesta INNER JOIN pregunta pr ON pr.CodPregunta = pos.DirPregunta AND rep.CodRespMomento=".$_SESSION['CodRespMomento']." AND rep.CodPregunta=".$_SESSION['PreguntaActual']." AND pr.CodPregunta>".$_SESSION['PreguntaParcial']." ORDER BY pr.CodPregunta ASC LIMIT 1;";return CuerpoDePreguntaParcial($Consulta);}else{               $Consulta="SELECT (SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=pr.CodParte) as DescParte,pr.CodPregunta,pr.CodParte,pr.Descripcion,pr.CodTipo,pr.CodGrupo,pr.Estado FROM posrespuestas pos INNER JOIN respuestasegresados rep ON rep.CodPosRespuesta = pos.CodRespuesta INNER JOIN pregunta pr ON pr.CodPregunta = pos.DirPregunta AND rep.CodRespMomento=".$_SESSION['CodRespMomento']." AND rep.CodPregunta=".$_SESSION['PreguntaActual']." ORDER BY pr.CodPregunta ASC LIMIT 1;";     return CuerpoDePreguntaParcial($Consulta);}}
    
    
    function CuerpoDePreguntaParcial($Consulta){$Resultado = mysqli_query($GLOBALS['Conexion'],$Consulta);$Num = mysqli_num_rows($Resultado);   if($Num==1){while($datos =  mysqli_fetch_object($Resultado)){$Data[] = array("CodPregunta"=>$datos->CodPregunta,                             "CodParte"=>$datos->CodParte,"Descripcion"=>$datos->Descripcion,"CodTipo"=>$datos->CodTipo,"DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,"Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaParcial']= $datos->CodPregunta;           $_SESSION['ParteActual']=$datos->CodParte;$_SESSION['CodTipo']=$datos->CodTipo;}return json_encode($Data);}else{DLLimpiarSiguiente($_SESSION['PreguntaParcial']);$_SESSION['PreguntaParcial']=null;$_SESSION['FinParcial']=FALSE;return AvanceProgresivo();}}
    
    function TraerDirParte(){if(isset($_SESSION['DirParte']) && $_SESSION['DirParte']!=NULL){$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=".$_SESSION['DirParte']." AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1";$sql = mysqli_query($GLOBALS['Conexion'],$Consulta);$_SESSION['DirParte']=NULL;$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,"DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,"Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaActual']= $datos->CodPregunta;$_SESSION['ParteActual']=$datos->CodParte; $_SESSION['CodTipo']=$datos->CodTipo;}return json_encode($Data);}}

    function DirigirseParte($CodPregunta){$Consulta = "SELECT pos.CodParte FROM respuestasegresados r INNER JOIN posrespuestas pos ON r.CodPosRespuesta=pos.CodRespuesta AND r.CodRespMomento=".$_SESSION['CodRespMomento']." AND r.CodPregunta=".$CodPregunta." AND pos.CodParte is not NULL  ORDER BY r.CodRespuesta DESC";$Resultado=mysqli_query($GLOBALS['Conexion'],$Consulta);$Num=mysqli_num_rows($Resultado);if($Num>=1){while($datos = mysqli_fetch_object($Resultado)){$_SESSION['DirParte']=$datos->CodParte;}}else{$_SESSION['DirParte']=NULL;           if($_SESSION['DirGrupo']!=NULL || isset($_SESSION['DirGrupo']) || $_SESSION['FinGrupo']==FALSE){$_SESSION['DirGrupo']=NULL ; $_SESSION['FinGrupo']=TRUE;}}}

    function PreguntaSiguiente($CodPregunta){$Consulta = "SELECT pos.DirGrupo,pos.CodParte,pos.DirPregunta FROM respuestasegresados r INNER JOIN posrespuestas pos ON r.CodPosRespuesta=pos.CodRespuesta AND r.CodRespMomento=".$_SESSION['CodRespMomento']." AND r.CodPregunta=".$CodPregunta." ORDER BY r.CodRespuesta DESC";$Resultado =mysqli_query($GLOBALS['Conexion'],$Consulta);$Num = mysqli_num_rows($Resultado);if($Num==1){while($datos = mysqli_fetch_object($Resultado)){if($datos->DirGrupo != NULL){$_SESSION['DirGrupo']=$datos->DirGrupo;$_SESSION['FinGrupo']==FALSE;}else if($datos->CodParte != NULL){$_SESSION['DirParte']=$datos->CodParte;}else if($datos->DirPregunta != NULL){$_SESSION['PreguntaDir']=$datos->DirPregunta;}}}else if($Num>1){while($datos = mysqli_fetch_object($Resultado)){if($datos->DirPregunta != NULL){$_SESSION['Parcial']=TRUE;}}}}

    function DLTraerPreguntaParte(){if(isset($_SESSION['DirParte']) && $_SESSION['DirParte']!=NULL){$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=".$_SESSION['DirParte']." AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,"DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,"Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaActual']= $datos->CodPregunta;$_SESSION['ParteActual']=$datos->CodParte;$_SESSION['CodTipo']=$datos->CodTipo;}}else{$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=(SELECT d.CodParte FROM partes d WHERE d.CodMomento=".$_SESSION['MomentoActual']." ORDER BY d.CodParte ASC LIMIT 1) and p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1 ";$sql = mysqli_query($GLOBALS['Conexion'],$Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,"DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,"Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaActual']= $datos->CodPregunta;$_SESSION['ParteActual']=$datos->CodParte;$_SESSION['CodTipo']=$datos->CodTipo;}}return json_encode($Data);}

    function DLConsultaParcialDeParte(){$Consulta="SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=".$_SESSION['ParteActual']." AND p.CodPregunta=".$_SESSION['PreguntaParcial']." AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1;";         $sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,                     "DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,               "Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaActual']= $datos->CodPregunta;           $_SESSION['ParteActual']=$datos->CodParte;$_SESSION['CodTipo']=$datos->CodTipo;}return json_encode($Data);}

    function DLConsultaActualDeParte(){$Consulta="SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodParte=".$_SESSION['ParteActual']." AND p.CodPregunta=".$_SESSION['PreguntaActual']." AND p.Estado = 1 AND (SELECT COUNT(*) as Total FROM posrespuestas ps WHERE ps.DirPregunta = p.CodPregunta)=0 ORDER BY p.CodPregunta ASC LIMIT 1;";$sql = Consulta($Consulta);$Data = array();while($datos =  mysqli_fetch_object($sql)){$Data[] = array("CodPregunta"=> $datos->CodPregunta,"CodParte" =>$datos->CodParte,"Descripcion" =>$datos->Descripcion,"CodTipo" =>$datos->CodTipo,                     "DescParte"=>$datos->DescParte,"CodGrupo"=>$datos->CodGrupo,"Estado"=>$datos->Estado,                     "Respuestas"=>Respuestas($datos->CodPregunta));$_SESSION['PreguntaActual']= $datos->CodPregunta;             $_SESSION['ParteActual']=$datos->CodParte;$_SESSION['CodTipo']=$datos->CodTipo;} return json_encode($Data);}

    function DLHVDatosHojaDeVida(){
        $cod= Consulta("SELECT * FROM hojasdevida WHERE Egresado =".$_SESSION['CodEgresado']);
        while($data = mysqli_fetch_object($cod)){
            $_SESSION['NumHojaDeVida'] = $data->CodHojaDevida;
        }
        $Data = array();
        $Data1 = array();
        $Data2 = array();
        $Data3 = array();
        $Data4 = array();
        $Data5 = array();
        $r =Consulta("SELECT * FROM hvestudios WHERE CodHojaDeVida =".$_SESSION['NumHojaDeVida']);
        $r2=Consulta("SELECT * FROM experienciaslaborales WHERE CodHojaDeVida =".$_SESSION['NumHojaDeVida']);
        $r3=Consulta("SELECT * FROM hvperfileslaborales WHERE CodHojaDeVida =".$_SESSION['NumHojaDeVida']);
        $r4=Consulta("SELECT hv.CodIdioma,hv.Idioma,li.DescIdioma,hv.Escritura,hv.Habla,hv.Lectura,hv.Escucha FROM hvidiomas hv INNER JOIN hvlistadeidiomas li ON hv.Idioma = li.CodIdioma AND CodHojaDevida = ".$_SESSION['NumHojaDeVida']);
        $r5=Consulta("SELECT CodHojaDevida, Egresado, Drive, Actualizacion, Facebook, Twitter, `Google+` as Google FROM hojasdevida WHERE CodHojaDeVida =".$_SESSION['NumHojaDeVida']);
        while($datos = mysqli_fetch_object($r)){
            $Data1[] = array("Estudio"=>$datos->CodEstudio,
                             "Estado"=>$datos->Estado,
                             "TituloRecibido"=>$datos->TituloRecibido,
                             "Instituto"=>$datos->Instituto);
            
        }
        while($datos = mysqli_fetch_object($r2)){
            $Data2[] = array("Experiencia"=>$datos->CodExpLaboral,
                             "Cargo"=>$datos->NombreDelCargo,
                             "Empresa"=>$datos->NombreEmpresa);
        }
        while($datos = mysqli_fetch_object($r3)){
            $Data3[] = array("Profesion"=>$datos->Profesion,
                            "Descripcion"=>$datos->DescPerfil,
                            "Perfilaboral"=>$datos->CodPerfilLaboral);
        }
        while($datos = mysqli_fetch_object($r4)){
            $Data4[] = array("CodIdioma"=>$datos->CodIdioma,
                             "Idioma"=>$datos->Idioma,
                            "Descripcion"=>$datos->DescIdioma,
                            "Escritura"=>$datos->Escritura,
                            "Habla"=>$datos->Habla,
                            "Lectura"=>$datos->Lectura,
                            "Escucha"=>$datos->Escucha);
        }
        while($datos = mysqli_fetch_object($r5)){
            $drive=new HvGoogleDrive($datos->Drive);
            $Data5[] = array("Drive"=>$datos->Drive,
                             "Embed"=>$drive->EmbedCarpeta(),
                            "Actualizacion"=>$datos->Actualizacion,
                            "Facebook"=>$datos->Facebook,
                            "Twitter"=>$datos->Twitter,
                            "Google+"=>$datos->Google);
        }
        $Data[]=array("Estudios"=>$Data1,"Experiencias"=>$Data2,"Perfil"=>$Data3,"Idioma"=>$Data4,"Drive"=>$Data5);
        return json_encode($Data);
    }

    function DLGraficCreation($g){
        $g->Tipo        = Mres($g->Tipo);
        $g->FechaInicio = Mres($g->FechaInicio);
        $g->FechaFin    = Mres($g->FechaFin);
        $g->CodPregunta = Mres($g->CodPregunta);
        if($g->Tipo == "PR_UR" || $g->Tipo == "PR_SM"){
            $r = Consulta("SELECT p.Descripcion,(SELECT COUNT(*) FROM respuestasegresados r WHERE r.CodPosRespuesta=p.CodRespuesta AND r.FechaDeCreacion is not NULL AND r.FechaDeCreacion BETWEEN '".$g->FechaInicio."' AND '".$g->FechaFin."') as Cantidad FROM posrespuestas p WHERE p.CodPregunta = ".$g->CodPregunta);
            while($datos = mysqli_fetch_object($r)){
                $g->Datos[]=array("Descripcion"=>$datos->Descripcion,"Cantidad"=>$datos->Cantidad);
            }
        }else if($g->Tipo == "PR_NU" || $g->Tipo == "PR_SN"){
            $r = Consulta("SELECT r.Respuesta,COUNT(r.CodRespMomento)as Cantidad FROM respuestasegresados r WHERE r.CodPregunta=".$g->CodPregunta." AND r.FechaDeCreacion is not NULL AND r.FechaDeCreacion BETWEEN '".$g->FechaInicio."' AND '".$g->FechaFin."' GROUP BY r.Respuesta");
            while($datos = mysqli_fetch_object($r)){
                $g->Datos[]=array("Respuesta"=>$datos->Cantidad." egresados respondierón ".$datos->Respuesta,"Egresados"=>$datos->Cantidad);
            }
        }else if($g->Tipo == "PR_A"){
            $r = Consulta("SELECT egre.CodUsuario as ImgUs,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = egre.CodUsuario ) as ImgFormat,CONCAT(egre.Nombre,' ',egre.SegundoNombre,' ',egre.Apellido,' ',egre.SegundoApellido) as NombreCompleto,(SELECT prog.NombrePrograma FROM programasunicesar prog WHERE prog.CodPrograma = egre.Programa)as Programa,egre.Celular,egre.Correo,res.Respuesta FROM respmomento rep INNER JOIN respuestasegresados res ON rep.CodRespMomento = res.CodRespMomento INNER JOIN egresados egre ON rep.Egresado = egre.CodEgresado AND res.CodPregunta = ".$g->CodPregunta." AND res.FechaDeCreacion is not null AND res.FechaDeCreacion BETWEEN '".$g->FechaInicio."' AND '".$g->FechaFin."' LIMIT 20");
            while($datos = mysqli_fetch_object($r)){
                if($datos->ImgFormat==NULL){
                    $Img="img/user-male-circle.png";
                }else{
                    $ImgFormat = explode(";",$datos->ImgFormat);
                    $Type = explode("/",$ImgFormat[0]);
                    $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$datos->ImgUs).".".$Type[1];
                }
                $g->Datos[]=array(  "NombreCompleto" => $datos->NombreCompleto,
                                    "Programa"=> $datos->Programa,
                                    "Celular"=> $datos->Celular,
                                    "Image"=>$Img,
                                    "Correo"=> $datos->Correo,
                                    "Respuesta"=> $datos->Respuesta);
            }
        }else if($g->Tipo == "PR_SS"){
            $r = Consulta("SELECT r.Respuesta,COUNT(r.CodRespMomento)as Cantidad FROM respuestasegresados r WHERE r.CodPregunta=".$g->CodPregunta." AND R.FechaDeCreacion IS NOT NULL and r.FechaDeCreacion BETWEEN '".$g->FechaInicio."' and '".$g->FechaFin."' GROUP BY r.Respuesta");
            while($datos = mysqli_fetch_object($r)){
                $g->Datos[]=array("Respuesta"=>$datos->Respuesta,"Egresados"=>$datos->Cantidad);
            }
        }else if($g->Tipo == "PR_SC"){
            $r = Consulta("SELECT p.CodRespuesta,p.Descripcion from posrespuestas p INNER JOIN pregunta pr on pr.CodPregunta = p.CodPregunta AND p.CodPregunta=".$g->CodPregunta."");while($datos = mysqli_fetch_object($r)){
                $g->Datos[]=array("CodResp"=>$datos->CodRespuesta,"Descripcion"=>$datos->Descripcion);
            }
        }
        return json_encode([$g]);
    }
    
    function PosSC_DLGraficCreation($g,$Respuesta){
        $g->Tipo        = Mres($g->Tipo);
        $g->FechaInicio = Mres($g->FechaInicio);
        $g->FechaFin    = Mres($g->FechaFin);
        $g->CodPregunta = Mres($g->CodPregunta);
        $Respuesta = Mres($Respuesta);
        if($Respuesta == "Ninguno"){
            $n = CantidadFilas(Consulta("SELECT COUNT(*) FROM respuestasegresados WHERE CodPregunta = ".$g->CodPregunta." AND Respuesta!='Ninguno' AND FechaDeCreacion is not null AND FechaDeCreacion BETWEEN '".$g->FechaInicio."' AND '".$g->FechaFin."' GROUP BY CodRespMomento"));
            $r = Consulta("SELECT COUNT(CodRespMomento) as ps1 FROM respuestasegresados WHERE CodPregunta = ".$g->CodPregunta." AND Respuesta ='Ninguno' AND FechaDeCreacion is not null AND FechaDeCreacion BETWEEN '".$g->FechaInicio."' AND '".$g->FechaFin."'");
            while($datos = mysqli_fetch_object($r)){
                $g->Datos[] = [$datos->ps1,"".$n.""];
            }
        }else{
            
            $r = Consulta(PosSC_SQL($g,'Alto',$Respuesta));
            while($datos = mysqli_fetch_object($r)){
                $g->Datos[] = array("label"=>'Nivel alto',"backgroundColor"=>dynamicColors(),"data"=>[$datos->ps1,$datos->ps2,$datos->ps3,$datos->ps4]);
                
            }
            $d = Consulta(PosSC_SQL($g,'Medio',$Respuesta));
            while($datos = mysqli_fetch_object($d)){
                $g->Datos[] = array("label"=>'Nivel medio',"backgroundColor"=>dynamicColors(),"data"=>[$datos->ps1,$datos->ps2,$datos->ps3,$datos->ps4]);
            }
            $f = Consulta(PosSC_SQL($g,'Bajo',$Respuesta));
            while($datos = mysqli_fetch_object($f)){
                $g->Datos[] = array("label"=>'NIvel bajo',"backgroundColor"=>dynamicColors(),"data"=>[$datos->ps1,$datos->ps2,$datos->ps3,$datos->ps4]);
            }
        }
        return json_encode([$g]);
    }
    
   function  dynamicColors(){$r = rand(0,255);$g = rand(0,255);$b = rand(0,255);return "rgba(".$r.",".$g.",".$b.",0.75)";}

    function PosSC_SQL($g,$Nivel,$Respuesta){return "SELECT (SELECT COUNT(r.CodRespMomento) as Cantidad FROM respuestasegresados r INNER JOIN preguntasistema p ON r.PreguntaSistema=p.CodSisPregunta AND  r.Respuesta = '".$Nivel."' AND r.PreguntaSistema = 1 AND r.CodPregunta = ".$g->CodPregunta." AND r.CodPosRespuesta = ".$Respuesta." AND r.FechaDeCreacion is not null AND r.FechaDeCreacion BETWEEN '".$g->FechaInicio."' and '".$g->FechaFin."') as ps1,(SELECT COUNT(ra.CodRespMomento) as Cantidad FROM respuestasegresados ra INNER JOIN preguntasistema pa ON ra.PreguntaSistema=pa.CodSisPregunta AND  ra.Respuesta = '".$Nivel."' AND ra.PreguntaSistema = 2 AND ra.CodPregunta = ".$g->CodPregunta." AND ra.CodPosRespuesta = ".$Respuesta." AND ra.FechaDeCreacion is not null AND ra.FechaDeCreacion BETWEEN '".$g->FechaInicio."' and '".$g->FechaFin."')as ps2,(SELECT COUNT(rb.CodRespMomento) as Cantidad FROM respuestasegresados rb INNER JOIN preguntasistema pb ON rb.PreguntaSistema=pb.CodSisPregunta AND  rb.Respuesta = '".$Nivel."' AND rb.PreguntaSistema = 3 AND rb.CodPregunta = ".$g->CodPregunta." AND rb.CodPosRespuesta = ".$Respuesta." AND rb.FechaDeCreacion is not null AND rb.FechaDeCreacion BETWEEN '".$g->FechaInicio."' and '".$g->FechaFin."') as ps3,(SELECT COUNT(rc.CodRespMomento) as Cantidad FROM respuestasegresados rc INNER JOIN preguntasistema pc ON rc.PreguntaSistema=pc.CodSisPregunta AND  rc.Respuesta = '".$Nivel."' AND rc.PreguntaSistema = 4 AND rc.CodPregunta = ".$g->CodPregunta." AND rc.CodPosRespuesta = ".$Respuesta." AND rc.FechaDeCreacion is not null AND rc.FechaDeCreacion BETWEEN '".$g->FechaInicio."' and '".$g->FechaFin."') as ps4 FROM respuestasegresados xr LIMIT 1";}

    function DLGuardarImagenes($i){
        $f = Consulta("SELECT * FROM fotosdeusuarios WHERE CodUsuario=".$_SESSION['CodUser']);
        $num = CantidadFilas($f);
        if($num==0){
            $r = Consulta("INSERT INTO fotosdeusuarios(CodUsuario,Base64) VALUES (".$_SESSION['CodUser'].",'".$i->Cabecera()."')");
        }else{
            while($data = mysqli_fetch_object($f)){
                if($data->Base64!=$i->Cabecera()){
                    $r= Consulta("UPDATE fotosdeusuarios SET Base64='".$i->Cabecera()."' WHERE CodigoArchivo=".$data->CodigoArchivo."");
                }
            }
        }

        $filepath = "/xampp/htdocs/JSON/Imagenes-User/".md5("Img_".$_SESSION['CodUser']).".".$i->TipoDeDato();
        echo "";
        file_put_contents($filepath,file_get_contents($i->img));
    }

    function DLHVConsultarEstudios($h){
        $Data = array();
        $r = Consulta("SELECT * FROM hvestudios est INNER JOIN ciudades ci ON ci.CodCiudad=est.Ciudad INNER JOIN departamentos pa ON pa.CodDepartamento = ci.CodDepartamento AND est.CodEstudio =".Mres($h));
        
        while($datos = mysqli_fetch_object($r)){
            $fecha_fin = date('Y',strtotime($datos->FechaDeFin));
            if($fecha_fin!="1970"){
                $fecha_fin = date('d/m/Y',strtotime($datos->FechaDeFin));
            }else{
                $fecha_fin= NULL;
            }
            
            switch($datos->Estado){
                case "Culminado": $estado = 0;break;
                case "En curso":$estado = 1;break;
                case "Abandonado": $estado = 2;break;
                case "Aplazado": $estado = 3;break;
            }
            $Data[] = array("CodEstudio"=>$datos->CodEstudio,
                           "NivelEstudio"=>$datos->NivelEstudio,
                           "AreaEstudio"=>$datos->AreaDeEstudio,
                           "Estado"=>$estado,
                           "FechaInicio"=>date('d/m/Y',strtotime($datos->FechaDeInicio)),
                           "FechaFin" =>$fecha_fin,
                           "TituloRecibido"=>$datos->TituloRecibido,
                           "Instituto"=>$datos->Instituto,
                           "Ciudad"=>$datos->Ciudad,
                           "Departamento"=>$datos->CodDepartamento,
                           "Pais"=>$datos->CodPais);
        }
        return json_encode($Data);
    }

    function DLHVConsultarExperienciasLaborales($a){
        $r = Consulta("SELECT * FROM experienciaslaborales WHERE CodExpLaboral = ".Mres($a));
        $Data = array();
        while($datos = mysqli_fetch_object($r)){
            $fecha_fin = date('Y',strtotime($datos->FechaDeFin));
            if($fecha_fin!="1970"){
                $fecha_fin = date('d/m/Y',strtotime($datos->FechaDeFin));
            }else{
                $fecha_fin= NULL;
            }
            $Data[]= array("NombreEmpresa"=>$datos->NombreEmpresa,
                          "SectorEmpresa"=>$datos->SectorEmpresa,
                          "SubSector"=>$datos->SubSector,
                          "FechaInicio"=>date('d/m/Y',strtotime($datos->FechaDeInicio)),
                          "FechaDeFin"=>$fecha_fin,
                          "NombreDelCargo"=>$datos->NombreDelCargo,
                          "CargoEquivalente"=>$datos->CodCargoEquivalente,
                          "NivelCargo"=>$datos->NivelDelCargo,
                          "Area_o_Depto"=>$datos->Area_o_Depto,
                          "Logros_y_Resp"=>$datos->logros_y_Resp,
                          "Telefono"=>$datos->Telefono,
                          "Ciudad"=>$datos->Ciudad);
        }
        return json_encode($Data);
    }
    function DLHVEliminarEstudios($h){
        Consulta("DELETE FROM hvestudios WHERE CodEstudio=".Mres($h));
    }

    function DLHVEliminarExperiencia($h){
        Consulta("DELETE FROM experienciaslaborales WHERE CodExpLaboral=".Mres($h));
    }

    function DLHVEliminarIdioma($i){
        Consulta("DELETE FROM hvidiomas WHERE CodIdioma = ".Mres($i));
    }

    function DLActualizarDatosDeEmpresa($Emp,$NumEmp,$Fax,$Web){
        $b = Consulta("SELECT * FROM representantesdeempresas WHERE CodUsuario=".$_SESSION['CodUser']."");
        while($data = mysqli_fetch_object($b)){
                    $CodEmp = $data->CodEmpresa;
                }
        Consulta("UPDATE empresasregistradas SET RazonSocial='".Mres($Emp->RazonSocial)."',Sector=".Mres($Emp->Sector).",Ciudad=".Mres($Emp->Ciudad).",Telefono=".Mres($Emp->Telefono).",Direccion='".Mres($Emp->Direccion)."',Fax=".Mres($Fax).",PaginaWeb='".Mres($Web)."',NumDeEmpleados=".Mres($NumEmp)." WHERE CodEmpresa = ".$CodEmp);
        return 0;
    }

    function DLActualizarDatosDelRepresentante($Rep){
        Consulta("UPDATE representantesdeempresas SET Nombres='".Mres($Rep->Nombres)."',Apellidos='".Mres($Rep->Apellidos)."',TipoDocumento=".Mres($Rep->TipoDocumento).",NumeroDocumento=".Mres($Rep->NumeroDocumento).",AnyoNacimiento=".Mres($Rep->AnyoNacimiento).",Cargo='".Mres($Rep->Cargo)."',Correo='".Mres($Rep->Correo)."',Telefono=".Mres($Rep->Telefono)." WHERE CodUsuario = ".$_SESSION['CodUser']);
        return 0;
    }

    function DLPublicarOfertaDeEmpleo($Pu,$Est,$Exp,$Demo){
        $CodOferta=NULL;
        $Resp = "Ocurrio un error al momento de crear la oferta revise los datos.";
        Consulta("INSERT INTO eppublicacionesdeofertas(Titulo,CodUsuario, Descripcion,DescripcionDeRequisitos,FechaInicio,FechaExpiracion, CaracterPublicación) VALUES ('".Mres($Pu->Titulo)."',".$_SESSION['CodUser'].",'".Mres($Pu->DescOferta)."','".Mres($Pu->DescRequisitos)."','".Mres($Pu->FechaInicio)."','".Mres($Pu->FechaFin)."',".Mres($Pu->Caracter).")");
        
        $r=Consulta("SELECT CodOferta FROM eppublicacionesdeofertas WHERE CodUsuario = ".$_SESSION['CodUser']." ORDER BY CodOferta DESC LIMIT 1");
        while($data = mysqli_fetch_object($r)){
            $CodOferta = $data->CodOferta;
        }
        $d=Consulta("INSERT INTO requisitoexperienciaoferta(CodOferta, Experiencia, SectorEmpresa, AreaCargo, CargoEquivalente, AniosDeExperiencia, SalarioMinimo, SalarioMaximo) VALUES (".$CodOferta.",'".Mres($Exp->Experiencia)."',".Mres($Exp->Sector).",".Mres($Exp->AreaCargo).",".Mres($Exp->CargoEquivalente).",".Mres($Exp->ExperienciaAnyo).",".Mres($Exp->SalarioMinimo).",".Mres($Exp->SalarioMaximo).")");
        if($d){
            $e=Consulta("INSERT INTO requisitoestudiosofertas(EstudiosFormales,NivelEstudio,AreaDeEstudio, CodIdioma, NivelIdioma,CodOferta) VALUES ('".Mres($Est->EstudiosFormales)."',".Mres($Est->NivelEstudio).",".Mres($Est->AreaEstudio).",".Mres($Est->Idioma).",'".Mres($Est->NivelIdioma)."',".$CodOferta.")");
            if($e){
                $f=Consulta("INSERT INTO requisitodemograficoofertas(CodOferta,EdadPostulante,Mudarse,Viajar) VALUES (".$CodOferta.",".Mres($Demo->EdadPostulante).",'".Mres($Demo->Mudarse)."','".Mres($Demo->Viajar)."')");
                if($f){
                     $Resp = "La oferta fue creada y publicada correctamente. <b>ya puede realizar procesos de selección para esta oferta</b>";   
                }
            } 
        }
        return $Resp;
    }

    function DLConsultarOfertas($Tipo){
        $Datos = array();
        $Table = array();
        $TableOfertas = array();
        $i = 1;
        $r="";
        if($Tipo==3){
            $r = Consulta("SELECT (SELECT (SELECT emp.NombreComercial FROM empresasregistradas emp WHERE rep.CodEmpresa = emp.CodEmpresa) FROM representantesdeempresas rep WHERE rep.CodUsuario = pu.CodUsuario) as NombreComercial,pu.CodOferta,pu.Titulo,pu.CodUsuario as ImgUs,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = pu.CodUsuario ) as ImgFormat,pu.Descripcion,pu.DescripcionDeRequisitos,pu.FechaInicio,pu.FechaExpiracion,pu.CaracterPublicación as CaracterPub,car.Descripcion as DescCaracter,exp.Experiencia,exp.SectorEmpresa,exp.SectorEmpresa,exp.CargoEquivalente,sec.Sector as DescSector,arc.Area as DescAreCargo,cre.Descripcion as dESCCargoEquivalente,est.EstudiosFormales,est.NivelEstudio,nes.Descripcion as DescNivel,est.AreaDeEstudio,ares.Area as DescAreaEstudio,est.CodIdioma,li.DescIdioma,est.NivelIdioma,dem.EdadPostulante,dem.Mudarse,dem.Viajar FROM eppublicacionesdeofertas pu INNER JOIN requisitoexperienciaoferta exp ON pu.CodOferta = exp.CodOferta INNER JOIN requisitoestudiosofertas est ON est.CodOferta=pu.CodOferta INNER JOIN requisitodemograficoofertas dem ON pu.CodOferta = dem.CodOferta INNER JOIN epcaracterdepublicaciones car ON car.CodigoCaracter = pu.CaracterPublicación INNER JOIN sectordeempresas sec ON exp.SectorEmpresa = sec.CodSector INNER JOIN areadecargo arc ON arc.CodArea = exp.AreaCargo INNER JOIN hvcargosequivalentes cre ON cre.CodCargoEquivalente = exp.CargoEquivalente INNER JOIN nivelesdeestudio nes ON nes.CodNivelEstudio = est.NivelEstudio INNER JOIN hvlistadeidiomas li ON li.CodIdioma = est.CodIdioma INNER JOIN areadeestudio ares ON ares.CodArea=est.AreaDeEstudio AND pu.FechaExpiracion >= STR_TO_DATE(SYSDATE(),'%Y-%m-%d')  ORDER BY pu.CaracterPublicación ASC");
        }else{
            $r = Consulta("SELECT pu.CodOferta,pu.Titulo,pu.Descripcion,pu.DescripcionDeRequisitos,pu.FechaInicio,pu.FechaExpiracion,pu.CaracterPublicación as CaracterPub,car.Descripcion as DescCaracter,exp.Experiencia,exp.SectorEmpresa,exp.SectorEmpresa,exp.CargoEquivalente,sec.Sector as DescSector,arc.Area as DescAreCargo,cre.Descripcion as dESCCargoEquivalente,est.EstudiosFormales,est.NivelEstudio,nes.Descripcion as DescNivel,est.AreaDeEstudio,ares.Area as DescAreaEstudio,est.CodIdioma,li.DescIdioma,est.NivelIdioma,dem.EdadPostulante,dem.Mudarse,dem.Viajar FROM eppublicacionesdeofertas pu INNER JOIN requisitoexperienciaoferta exp ON pu.CodOferta = exp.CodOferta INNER JOIN requisitoestudiosofertas est ON est.CodOferta=pu.CodOferta INNER JOIN requisitodemograficoofertas dem ON pu.CodOferta = dem.CodOferta INNER JOIN epcaracterdepublicaciones car ON car.CodigoCaracter = pu.CaracterPublicación INNER JOIN sectordeempresas sec ON exp.SectorEmpresa = sec.CodSector INNER JOIN areadecargo arc ON arc.CodArea = exp.AreaCargo INNER JOIN hvcargosequivalentes cre ON cre.CodCargoEquivalente = exp.CargoEquivalente INNER JOIN nivelesdeestudio nes ON nes.CodNivelEstudio = est.NivelEstudio INNER JOIN hvlistadeidiomas li ON li.CodIdioma = est.CodIdioma INNER JOIN areadeestudio ares ON ares.CodArea=est.AreaDeEstudio AND pu.CodUsuario = ".$_SESSION['CodUser']);
        }
        $Img="img/user-male-circle.png";
        $dataTable=null;
        while($data = mysqli_fetch_object($r)){
            if($Tipo==3){
                if($data->ImgFormat==NULL){
                    $Img="img/user-male-circle.png";
                }else{
                    $ImgFormat = explode(";",$data->ImgFormat);
                    $Type = explode("/",$ImgFormat[0]);
                    $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$data->ImgUs).".".$Type[1];
                }
            }
            $Datos[] = array("CodOferta"=>$data->CodOferta,
            "ImgOferta"=>$Img,
            "Titulo"=>$data->Titulo,    
            "Descripcion"=>$data->Descripcion,    
            "DescripcionDeRequisitos"=>$data->DescripcionDeRequisitos,
            "FechaInicio"=>$data->FechaInicio,    
            "FechaExpiracion"=>$data->FechaExpiracion,
            "CaracterPublicación"=>$data->CaracterPub,    
            "DescCaracter"=>$data->DescCaracter,    
            "Experiencia"=>$data->Experiencia,
            "SectorEmpresa"=>$data->SectorEmpresa,    
            "SectorEmpresa"=>$data->SectorEmpresa,    
            "CargoEquivalente"=>$data->CargoEquivalente,
            "DescSector"=>$data->DescSector,    
            "DescAreCargo"=>$data->DescAreCargo,    
            "dESCCargoEquivalente"=>$data->dESCCargoEquivalente,
            "EstudiosFormales"=>$data->EstudiosFormales,    
            "NivelEstudio"=>$data->NivelEstudio,    
            "DescNivel"=>$data->DescNivel,
            "AreaDeEstudio"=>$data->AreaDeEstudio,    
            "DescAreaEstudio"=>$data->DescAreaEstudio,    
            "CodIdioma"=>$data->CodIdioma,
            "DescIdioma"=>$data->DescIdioma,    
            "NivelIdioma"=>$data->NivelIdioma,    
            "EdadPostulante"=>$data->EdadPostulante,
            "Mudarse"=>$data->Mudarse,    
            "Viajar"=>$data->Viajar);
            $str = $data->Descripcion;
            if(strlen($data->Descripcion)>100){
                $str = trim(substr($data->Descripcion, 0, 100));
                $str .= " ...";
            }
            
            $Table["data"][] = array($i++,$data->Titulo,$str,date('d/m/Y',strtotime($data->FechaInicio)),date('d/m/Y',strtotime($data->FechaExpiracion)),'<button class="btn btn-outline-primary" data-toggle="modal" data-target=".Publicacion-Laboral" onclick="VerPublicacion('.$data->CodOferta.')"><span class="fa fa-eye"></span></button>','<button class="btn btn-outline-danger" onclick="EliminarPub('.$data->CodOferta.')"><span class="fa fa-trash-o"></span></button>');
            
            if($data->CaracterPub==1 && $Tipo == 3){
                $dataTable = '<a href="#" onclick="AbrirPublicacion('.$data->CodOferta.')" data-toggle="modal" data-target=".Publicacion-Laboral" class="list-group-item list-group-item-action border-warning shadow"> <div class="d-flex w-100 justify-content-between"> <h2 class="mb-1 green-item">'.$data->Titulo.'</h2>  <small class="text-warning shape-text">'.$data->DescCaracter.'</small>       </div>    <p class="mb-2 text-dark"><span class="text-secondary"> Empresa: '.$data->NombreComercial.'</span> <br><br>'.$str.'</p>    <small>'.date('d/m/Y',strtotime($data->FechaInicio)). '  hasta  '.date('d/m/Y',strtotime($data->FechaExpiracion)).'</small> </a>';
            }else if($Tipo == 3){
                $dataTable = '<a href="#" onclick="AbrirPublicacion('.$data->CodOferta.')" data-toggle="modal" data-target=".Publicacion-Laboral" class="list-group-item list-group-item-action shadow">    <div class="d-flex w-100 justify-content-between">      <h2 class="mb-1 green-item">'.$data->Titulo.'</h2>         </div>    <p class="mb-2 text-dark"><span class="text-secondary"> Empresa: '.$data->NombreComercial.'</span> <br><br>'.$str.'</p>    <small>'.date('d/m/Y',strtotime($data->FechaInicio)). '  hasta  '.date('d/m/Y',strtotime($data->FechaExpiracion)).'</small> </a>';
            }
            if($Tipo==3){
                $TableOfertas['data'][] = array('<img src="'.$Img.'" width="100%" class="img-fluid rounded shadow" alt="...">',$dataTable);
            }
        }
        switch($Tipo){
            case 1:return json_encode($Datos); break;
            case 2:return json_encode($Table);break;
            case 3:return json_encode($TableOfertas); break;
        }
    }

    function DLConsultarPublicacionOferta($Cod){
         $Datos = array();
        $r = Consulta("SELECT (SELECT (SELECT emp.NombreComercial FROM empresasregistradas emp WHERE rep.CodEmpresa = emp.CodEmpresa) FROM representantesdeempresas rep WHERE rep.CodUsuario = pu.CodUsuario) as NombreComercial,pu.CodOferta,pu.Titulo,pu.CodUsuario as ImgUs,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = pu.CodUsuario ) as ImgFormat,pu.Descripcion,pu.DescripcionDeRequisitos,pu.FechaInicio,pu.FechaExpiracion,pu.CaracterPublicación as CaracterPub,car.Descripcion as DescCaracter,exp.SalarioMinimo,exp.SalarioMaximo,exp.Experiencia,exp.SectorEmpresa,exp.AniosDeExperiencia,exp.SectorEmpresa,exp.CargoEquivalente,sec.Sector as DescSector,arc.Area as DescAreCargo,cre.Descripcion as dESCCargoEquivalente,est.EstudiosFormales,est.NivelEstudio,nes.Descripcion as DescNivel,est.AreaDeEstudio,ares.Area as DescAreaEstudio,est.CodIdioma,li.DescIdioma,est.NivelIdioma,dem.EdadPostulante,dem.Mudarse,dem.Viajar FROM eppublicacionesdeofertas pu INNER JOIN requisitoexperienciaoferta exp ON pu.CodOferta = exp.CodOferta INNER JOIN requisitoestudiosofertas est ON est.CodOferta=pu.CodOferta INNER JOIN requisitodemograficoofertas dem ON pu.CodOferta = dem.CodOferta INNER JOIN epcaracterdepublicaciones car ON car.CodigoCaracter = pu.CaracterPublicación INNER JOIN sectordeempresas sec ON exp.SectorEmpresa = sec.CodSector INNER JOIN areadecargo arc ON arc.CodArea = exp.AreaCargo INNER JOIN hvcargosequivalentes cre ON cre.CodCargoEquivalente = exp.CargoEquivalente INNER JOIN nivelesdeestudio nes ON nes.CodNivelEstudio = est.NivelEstudio INNER JOIN hvlistadeidiomas li ON li.CodIdioma = est.CodIdioma INNER JOIN areadeestudio ares ON ares.CodArea=est.AreaDeEstudio AND pu.CodOferta=".Mres($Cod));
        $Img="img/user-male-circle.png";
        while($data = mysqli_fetch_object($r)){
            if($data->ImgFormat==NULL){
                $Img="img/user-male-circle.png";
            }else{
                $ImgFormat = explode(";",$data->ImgFormat);
                $Type = explode("/",$ImgFormat[0]);
                $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$data->ImgUs).".".$Type[1];
            }
            
            $Datos[] = array("CodOferta"=>$data->CodOferta,
            "ImgOferta"=>$Img,
            "NombreComercial"=>$data->NombreComercial,
            "Titulo"=>$data->Titulo,    
            "Descripcion"=>$data->Descripcion,    
            "DescripcionDeRequisitos"=>$data->DescripcionDeRequisitos,
            "FechaInicio"=>date('d/m/Y',strtotime($data->FechaInicio)),    
            "FechaExpiracion"=>date('d/m/Y',strtotime($data->FechaExpiracion)),
            "CaracterPublicacion"=>$data->CaracterPub,    
            "DescCaracter"=>$data->DescCaracter,    
            "Experiencia"=>$data->Experiencia,
            "SectorEmpresa"=>$data->SectorEmpresa,    
            "SectorEmpresa"=>$data->SectorEmpresa,    
            "CargoEquivalente"=>$data->CargoEquivalente,
            "DescSector"=>$data->DescSector,    
            "DescAreCargo"=>$data->DescAreCargo,    
            "dESCCargoEquivalente"=>$data->dESCCargoEquivalente,
            "EstudiosFormales"=>$data->EstudiosFormales,    
            "NivelEstudio"=>$data->NivelEstudio,    
            "DescNivel"=>$data->DescNivel,
            "AreaDeEstudio"=>$data->AreaDeEstudio,    
            "DescAreaEstudio"=>$data->DescAreaEstudio,    
            "CodIdioma"=>$data->CodIdioma,
            "DescIdioma"=>$data->DescIdioma,    
            "NivelIdioma"=>$data->NivelIdioma,    
            "EdadPostulante"=>$data->EdadPostulante,
            "Mudarse"=>$data->Mudarse,    
            "Viajar"=>$data->Viajar,
            "SalarioMinimo"=>$data->SalarioMinimo,
            "SalarioMaximo"=>$data->SalarioMaximo,
            "AniosDeExperiencia"=>$data->AniosDeExperiencia);
        }
        return json_encode($Datos);
    }

      function DLEPConsultarEgresado($Anyo,$Programa){
        $Data = array();
        $sql="";
        if($Anyo == NULL && $Programa == NULL){
            $sql=Consulta("select (select base64 FROM fotosdeusuarios f where f.CodUsuario = e.CodUsuario ) ImgFormat, e.CodEgresado, e.CodUsuario, e.Cedula, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, e.Ciudad, e.TelefonoRes, e.Celular, e.Correo, e.FechaMomentoActual, e.CodMomentoActual, p.NombrePrograma, e.AñoDeEgreso, m.Descripcion from egresados e inner join programasunicesar p on e.Programa = p.CodPrograma INNER JOIN momento m on e.CodMomentoActual = m.CodMomento");
        }
        else if($Anyo != NULL && $Programa == NULL){
            $sql=Consulta("select (select base64 FROM fotosdeusuarios f where f.CodUsuario = e.CodUsuario ) ImgFormat, e.CodEgresado, e.CodUsuario, e.Cedula, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, e.Ciudad, e.TelefonoRes, e.Celular, e.Correo, e.FechaMomentoActual, e.CodMomentoActual, p.NombrePrograma, e.AñoDeEgreso, m.Descripcion from egresados e inner join programasunicesar p on e.Programa = p.CodPrograma INNER JOIN momento m on e.CodMomentoActual = m.CodMomento where e.AñoDeEgreso =".Mres($Anyo));
            
        }else if($Anyo == NULL && $Programa != NULL){
            $sql=Consulta("select (select base64 FROM fotosdeusuarios f where f.CodUsuario = e.CodUsuario ) ImgFormat, e.CodEgresado, e.CodUsuario, e.Cedula, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, e.Ciudad, e.TelefonoRes, e.Celular, e.Correo, e.FechaMomentoActual, e.CodMomentoActual, p.NombrePrograma, e.AñoDeEgreso, m.Descripcion from egresados e inner join programasunicesar p on e.Programa = p.CodPrograma INNER JOIN momento m on e.CodMomentoActual = m.CodMomento where e.Programa =".Mres($Programa));
        } else if($Anyo != NULL && $Programa != NULL){
            $sql=Consulta("select (select base64 FROM fotosdeusuarios f where f.CodUsuario = e.CodUsuario ) ImgFormat, e.CodEgresado,e.CodUsuario, e.Cedula, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, e.Ciudad, e.TelefonoRes, e.Celular, e.Correo, e.FechaMomentoActual, e.CodMomentoActual, p.NombrePrograma, e.AñoDeEgreso, m.Descripcion from egresados e inner join programasunicesar p on e.Programa = p.CodPrograma INNER JOIN momento m on e.CodMomentoActual = m.CodMomento where e.Programa =".Mres($Programa)." and e.AñoDeEgreso =".Mres($Anyo));
        }
        while($datos = mysqli_fetch_object($sql)){   
            
            if($datos->ImgFormat!=NULL){
                $ImgFormat = explode(";",$datos->ImgFormat);
                $Type = explode("/",$ImgFormat[0]);
                $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$datos->CodUsuario).".".$Type[1];
            }else{
                $Img ="img/gender-neutral-user.jpg";
            }
            $Data["data"][]=array('<img src="'.$Img.'" alt="" class="rounded mx-auto d-block img-thumbnail" >', $datos->Cedula,$datos->Nombre.' '.$datos->SegundoNombre. ' ' .$datos->Apellido. ' '.$datos->SegundoApellido, $datos->NombrePrograma, $datos->AñoDeEgreso, $datos->CodMomentoActual,  "<button type='button' class='btn btn-outline-success' onclick='EnviarEgresado(".$datos->Cedula.")'><span class='fa fa-eye'</span></button>"); 
            
        }
        return json_encode($Data);
    }

    function DLEPConsultarDetalleEgresado($Id){
        $Data = array();
      /*  $sql=Consulta('SELECT e.CodUsuario as DllC,e.CodEgresado,e.AñoDeEgreso, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, e.Ciudad,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = e.CodUsuario) as ImgFormat, e.TelefonoRes, e.Correo, e.Celular,e.Programa, e.Cedula, e.FechaMomentoActual ,(SELECT m.Descripcion FROM momento m WHERE e.CodMomentoActual=m.CodMomento) as Descripcion,e.CodMomentoActual,(SELECT m.Documentacion FROM momento m WHERE e.CodMomentoActual=m.CodMomento) as Documentacion,IF((e.FechaMomentoActual>SYSDATE() OR  e.FechaMomentoActual is NULL),"NO","SI") as RealizarEncuesta,IF((e.FechaMomentoActual is NULL AND e.CodMomentoActual is NULL),"NO","SI") as NotificarEncuesta FROM egresados e WHERE e.Cedula='.Mres($Id));*/
        
        $sql=Consulta('SELECT e.CodUsuario as DllC,e.CodEgresado,e.AñoDeEgreso, e.Nombre, e.SegundoNombre, e.Apellido, e.SegundoApellido, e.FechaNacimiento, e.PaisResidencia, e.Departamento, c.NombreCiudad,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = e.CodUsuario) as ImgFormat, e.TelefonoRes, e.Correo, e.Celular,p.NombrePrograma, e.Cedula, e.FechaMomentoActual ,(SELECT m.Descripcion FROM momento m WHERE e.CodMomentoActual=m.CodMomento) as Descripcion,e.CodMomentoActual,(SELECT m.Documentacion FROM momento m WHERE e.CodMomentoActual=m.CodMomento) as Documentacion,IF((e.FechaMomentoActual>SYSDATE() OR e.FechaMomentoActual is NULL),"NO","SI") as RealizarEncuesta,IF((e.FechaMomentoActual is NULL AND e.CodMomentoActual is NULL),"NO","SI") as NotificarEncuesta FROM egresados e INNER join ciudades c on e.Ciudad = c.CodCiudad INNER JOIN programasunicesar p ON e.Programa = p.CodPrograma WHERE e.Cedula='.Mres($Id));
            while($datos =  mysqli_fetch_object($sql)){
            $date = NULL;
            if($datos->FechaMomentoActual!=NULL){
                setlocale(LC_ALL,"es_ES");
                 $date=strftime("%A %d de %B del %Y",strtotime($datos->FechaMomentoActual));
//                $date=date('d l Y',strtotime($datos->FechaMomentoActual));
            }
            if($datos->ImgFormat!=NULL){
                $ImgFormat = explode(";",$datos->ImgFormat);
                $Type = explode("/",$ImgFormat[0]);
                $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$datos->DllC).".".$Type[1];
            }else{
                $Img ="img/gender-neutral-user.jpg";
            }
            $Data[] = array("Nombre"=>$datos->Nombre,
                            "SegundoNombre"=>$datos->SegundoNombre,
                            "Apellido"=>$datos->Apellido,
                            "SegundoApellido"=>$datos->SegundoApellido,
                            "FechaNacimiento"=>date('d/m/Y',strtotime($datos->FechaNacimiento)),
                            "FechaDeGrado"=>$datos->AñoDeEgreso,
                            "PaisResidencia"=>$datos->PaisResidencia,
                            "Departamento"=>$datos->Departamento,
                            "NombreCiudad"=>$datos->NombreCiudad,
                            "TelefonoResidencia"=>$datos->TelefonoRes,
                            "NombreCompleto"=>strtoupper($datos->Nombre." ".$datos->SegundoNombre." ".$datos->Apellido." ".$datos->SegundoApellido),
                            "Correo"=>$datos->Correo,
                            "Celular"=>$datos->Celular,
                            "Image"=>$Img,
                            "NombrePrograma"=>$datos->NombrePrograma,
                            "Cedula"=>$datos->Cedula,
                            "FechaMomentoActual"=>$date,
                            "CodMomentoActual"=>$datos->CodMomentoActual,
                            "DescMomento"=>$datos->Descripcion);

            }
        return json_encode($Data);
    }

    function DLAplicarOfertaDeEmpleo($Oferta){
        $r = Consulta("SELECT hv.CodHojaDevida as hoja FROM hojasdevida hv INNER JOIN egresados eg ON eg.CodEgresado = hv.Egresado AND eg.CodUsuario = ".$_SESSION['CodUser']);
        while($data = mysqli_fetch_object($r)){
            $CodHv = $data->hoja;
        }
        $d = Consulta("INSERT INTO aplicaciondeoferta(CodHojaDeVida,CodPublicacion) VALUES (".$CodHv.",".Mres($Oferta).")");
        if($d){
            return "Usted acaba de aplicar a esta oferta";
        }else{
            return "No puede volver a aplicar a la misma oferta";
        }
    }

    function DLEliminarPublicacion($Oferta){
        $r=Consulta("DELETE FROM eppublicacionesdeofertas WHERE CodOferta = ".Mres($Oferta));
        if($r){
            return 1;
        }else{
            return 2;
        }
    }
    
    function DLProcesoDeSeleccion($Process){
        $r= Consulta("UPDATE aplicaciondeoferta SET estado = '".Mres($Process->CambioDeEstado())."' WHERE CodPublicacion = ".Mres($Process->CodOferta)." AND CodHojaDeVida = ".Mres($Process->HojaDeVida));
        if($r){
            return 1;
        }else{
            return 2;
        }
    }

    function DLTableAspirantes($Oferta){
        $TableAsp = array();
        $r = Consulta("SELECT eg.CodEgresado as Aspirante,eg.CodUsuario as DllC,(SELECT pr.NombrePrograma FROM programasunicesar pr WHERE eg.Programa = pr.CodPrograma) as NombrePrograma,eg.AñoDeEgreso as AnyoEgreso,(SELECT Base64 FROM fotosdeusuarios fo WHERE fo.CodUsuario = eg.CodUsuario) as ImgFormat,eg.Nombre,eg.SegundoNombre,ap.FechaDeAplicacon as Fecha,eg.Apellido,eg.SegundoApellido,hvp.Profesion,hvp.DescPerfil FROM egresados eg INNER JOIN hojasdevida hv ON  eg.CodEgresado = hv.Egresado INNER JOIN hvperfileslaborales hvp ON 	hvp.CodHojaDeVida = hv.CodHojaDevida INNER JOIN aplicaciondeoferta ap ON	hv.CodHojaDevida = ap.CodHojaDeVida AND ap.CodPublicacion = ".Mres($Oferta));
        while($data = mysqli_fetch_object($r)){
            if($data->ImgFormat!=NULL){
                $ImgFormat = explode(";",$data->ImgFormat);
                $Type = explode("/",$ImgFormat[0]);
                $Img="http://localhost/JSON/Imagenes-User/".md5("Img_".$data->DllC).".".$Type[1];
            }else{
                $Img ="img/gender-neutral-user.jpg";
            }
            $NombreCompleto = trim($data->Nombre." ".$data->Apellido);
            $dataTable = '<div onclick="VerAspirante('.$data->Aspirante.',\''.$NombreCompleto.'\',\''.$Img.'\',\''.$data->DescPerfil.'\',\''.$data->Profesion.'\')" class="list-group-item list-group-item-action shadow">    <div class="d-flex w-100 justify-content-between">      <h5 class="mb-1 text-dark">'.$data->Profesion.'</h5><small>'.$data->Fecha.'</small> </div>    <p class="mb-2 text-dark">'.$data->DescPerfil.'</p><small>'.$data->NombrePrograma.'</small>  </div>';
            $TableAsp['data'][] = array($dataTable);
        }
        return json_encode($TableAsp);
    }

    function DLGuardarEmpleado($Emp,$NombreUsuario,$Pass){
        $Error = 0;
        $CodUs= null;
        $r=Consulta("SELECT * FROM usuarios WHERE NombreUsuario = '".Mres($NombreUsuario)."'");
        $b=Consulta("SELECT * FROM empleados WHERE Cedula = ".Mres($Emp->Cedula)."");
        if(CantidadFilas($r)>0 && CantidadFilas($b)>0){
            $Error = 3;  
        }else if(CantidadFilas($b)>0){
            $Error = 2;
        }else if(CantidadFilas($r)>0){
            $Error = 1;
        }
        
        switch($Error){
            case 0 :
                
            $q = sprintf("INSERT INTO usuarios(NombreUsuario,PassUsuario,Rol) VALUES('%s','%s',3);",
                Mres($NombreUsuario),
                password_hash(Mres($Pass), PASSWORD_DEFAULT));
                $r = Consulta($q);
             if($r){
               $f=Consulta("SELECT * FROM usuarios WHERE NombreUsuario = '".Mres($NombreUsuario)."'"); 
                 
                while($data2 = mysqli_fetch_object($f)){
                    $CodUs = $data2->CodUsuario;
                }
                if($CodUs!=null){
                    
                Consulta("INSERT INTO empleados(CodUsuario,Nombre,SegundoNombre,Apellido,SegundoApellido,Cedula) VALUES (".Mres($CodUs).",'".Mres($Emp->Nombre)."','".Mres($Emp->SegundoNombre)."','".Mres($Emp->Apellido)."','".Mres($Emp->SegundoApellido)."',".Mres($Emp->Cedula).")"); 
                    
                }
                 else{
                     return "No registrado";
                 }
             }
        
            return "Complete";
            break;
            case 1 : return "El Usuario (".$NombreUsuario.") se encuentra en uso";break;
            case 2 : return "Ya existe un empleado con este documento: ".$Emp->Cedula;break;
        }
        
    }


    function DLRegistrarEgresados($a,$fecha){
        $q = sprintf("INSERT INTO usuarios(NombreUsuario,PassUsuario,Rol,Estado) VALUES('%s','%s',1,'D');",
        Mres($a->Cedula),
        password_hash(Mres($a->Cedula), PASSWORD_DEFAULT));
        $r = Consulta($q);
        if($r){
            $Cod = Consulta('SELECT * FROM usuarios WHERE NombreUsuario = "'.Mres($a->Cedula).'"');
            while($datos = mysqli_fetch_object($Cod)){
                $CodUsuario = $datos->CodUsuario;
            }
            $sql="INSERT INTO egresados(CodUsuario, Nombre,SegundoNombre, Apellido, SegundoApellido, FechaNacimiento, AñoDeEgreso, PaisResidencia, Departamento, Ciudad, TelefonoRes, Correo, Celular,Programa, Cedula, FechaMomentoActual,CodMomentoActual) VALUES (".$CodUsuario.",'".Mres($a->Nombre)."','".Mres($a->SegundoNombre)."','".Mres($a->Apellido)."','".Mres($a->SegundoApellido)."','".date('Y-m-d',strtotime(str_replace("/","-",Mres($a->FechaNacimiento))))."',".Mres($fecha).",".Mres($a->PaisResidencia).",".Mres($a->Departamento).",".Mres($a->Ciudad).",'".Mres($a->TelefonoRes)."','".Mres($a->Correo)."','".Mres($a->Celular)."',".Mres($a->Programa).",'".Mres($a->Cedula)."',SYSDATE(),".UbicarMomento($fecha).")";
            $Res = Consulta($sql);
            if($Res){
                return "Registrado con exito, espere en 24 horas un correo de verificación.";
            }else{
                return "Ocurrio un error.";
            }
        }else{
            return "Esta cedula ".$a->Cedula." se encuentra en uso.";
        }
    }

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

    function DLReporteGeneralEgresadosPorCarrera($g){
        $Datos = array();
        if($g!=NULL){
            $r = Consulta('SELECT pr.NombrePrograma,COUNT(e.CodEgresado) as Cantidad  from egresados e INNER JOIN programasunicesar pr ON pr.CodPrograma = e.Programa AND e.AñoDeEgreso = '.Mres($g).' GROUP BY e.Programa');
        }else{
            $r = Consulta('SELECT pr.NombrePrograma,COUNT(e.CodEgresado) as Cantidad  from egresados e INNER JOIN programasunicesar pr ON pr.CodPrograma = e.Programa GROUP BY e.Programa');
        }
        while($datos = mysqli_fetch_object($r)){
            $Datos[]=array("Programas"=>$datos->NombrePrograma,"Cantidad"=>$datos->Cantidad);
        }
        return json_encode($Datos);
    }
?>