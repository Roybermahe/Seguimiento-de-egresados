<?php
    //Royber y Gustavo 
    //Correos: roybermanjarrez@gmail.com / gustavo-garcia-1994@hotmail.com
     class Empleado{
        public $CodEmpleado;
        public $CodUsuario;
        public $Nombre;
        public $SegundoNombre;
        public $Apellido;
        public $SegundoApellido;
        public $Cedula;
        
        function __construct($a,$b,$c,$d,$e,$f,$g){ 
            $this->CodEmpleado      = $a;
            $this->CodUsuario       = $b;
            $this->Nombre           = $c;
            $this->SegundoNombre    = $d;
            $this->Apellido         = $e;
            $this->SegundoApellido  = $f;
            $this->Cedula           = $g;
        }
    }

    class Procesos{
        public $CodOferta;
        public $HojaDeVida;
        public $NumProcess;
        
        function __construct($a,$b,$c){
            $this->CodOferta = $a;
            $this->HojaDeVida = $b;
            $this->NumProcess = $c; 
        }
        
        function CambioDeEstado(){
            switch($this->NumProcess){
                case 1: return "En revisión"; break;
                case 2: return "Admitido"; break;
                case 3: return "No admitido"; break;
                case 4: return "Vencido"; break;
            }
        }
    }
    class PublicacionOferta{
        public $Titulo;
        public $DescOferta;
        public $DescRequisitos;
        public $FechaInicio;
        public $FechaFin;
        public $Caracter;
        public $Estado;
        
        function __construct($a,$b,$c,$d,$e,$f,$g){
           $this->Titulo = $a;
           $this->DescOferta = $b;
           $this->DescRequisitos = $c;
           $this->FechaInicio = date('Y-m-d',strtotime(str_replace("/","-",$d)));
           $this->FechaFin = date('Y-m-d',strtotime(str_replace("/","-",$e)));
           $this->Caracter = $f;
           $this->Estado = $g;
        }
    }

    class ReqAspEstudios{
        public $EstudiosFormales;
        public $NivelEstudio;
        public $AreaEstudio;
        public $Idioma;
        public $NivelIdioma;
        
        function __construct($a,$b,$c,$d,$e){
            $this->EstudiosFormales= $a;
            $this->NivelEstudio= $b;
            $this->AreaEstudio= $c;
            $this->Idioma= $d;
            $this->NivelIdioma= $e;            
        }
    }

    class ReqAspExperiencia{
        public $Experiencia;
        public $Sector;
        public $AreaCargo;
        public $CargoEquivalente;
        public $ExperienciaAnyo;
        public $SalarioMinimo;
        public $SalarioMaximo;
        
        function __construct($a,$b,$c,$d,$e,$f,$g){
            $this->Experiencia = $a;
            $this->Sector = $b;
            $this->AreaCargo = $c;
            $this->CargoEquivalente = $d;
            $this->ExperienciaAnyo = $e;
            $this->SalarioMinimo = $f;
            $this->SalarioMaximo = $g;      
        }
    }

    class ReqAspFiltroDemografico{
        public $EdadPostulante;
        public $Mudarse;
        public $Viajar;
        function __construct($a,$b,$c){
            $this->EdadPostulante = $a;
            $this->Mudarse = $b;
            $this->Viajar = $c;            
        }
    }

    class RepresentanteEmpresa{
        public $CodRepresentante;
        public $Nombres;
        public $Apellidos;
        public $TipoDocumento;
        public $NumeroDocumento;
        public $AnyoNacimiento;
        public $Cargo;
        public $Correo;
        public $Telefono;
        public $Pass;
        public $PassConfirm;
        public $CodEmpresa;
        
        function __construct($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l){
            $this->CodRepresentante    = $a;
            $this->Nombres             = $b;
            $this->Apellidos           = $c;
            $this->TipoDocumento       = $d;
            $this->NumeroDocumento     = $e;
            $this->AnyoNacimiento      = $f;
            $this->Cargo               = $g;
            $this->Correo              = $h;
            $this->Telefono            = $i;
            $this->Pass                = $j;
            $this->PassConfirm         = $k;
            $this->CodEmpresa          = $l;  
        }
    }

    class Empresas{
        public $CodEmpresa;
        public $TipoDocumento;
        public $NumeroDocumento;
        public $RazonSocial;
        public $Sector;
        public $Ciudad;
        public $Telefono;
        public $Direccion;
        
        function __construct($a,$b,$c,$d,$e,$f,$g,$h){
            $this->CodEmpresa       = $a;
            $this->TipoDocumento    = $b;
            $this->NumeroDocumento  = $c;
            $this->RazonSocial      = $d;
            $this->Sector           = $e;
            $this->Ciudad           = $f;
            $this->Telefono         = $g;
            $this->Direccion        = $h; 
        }
    }
    
    class PEHojaDeVida{
        public $CodHojaDeVida;
        public $Egresado;
        public $Carpeta;
        public $UltimaActualizacion;
        
        function __construct($a,$b,$c,$d){
            $this->CodHojaDeVida           = $a;
            $this->Egresado                = $b;
            $this->Carpeta                 = $c;
            $this->UltimaActualizacion     = date('d M del Y',strtotime(str_replace("/","-",$d)));
        }
    }

    class HvRedesSociales{
        public $Facebook;
        public $Twitter;
        public $Google;
        
        function __construct($a,$b,$c){
            $this->Facebook    =$a;
            $this->Twitter     =$b;
            $this->Google      =$c;
        }
    }

    class HvGoogleDrive{
        public $DriveFile;
        
        function __construct($a){
            $this->DriveFile        =$a;
        }
        
        function CodigoCarpeta(){
            $a = explode("?",$this->DriveFile);
            $b = explode("/",$a[0]);
            return array_pop($b);
        }
        
        function EmbedCarpeta(){
            return "https://drive.google.com/embeddedfolderview?id=".$this->CodigoCarpeta()."#list";
        }
    }

    class PerfilLaboral{
        public $CodPerfil;
        public $CodHojaDeVida;
        public $Profesion;
        public $DescPerfil;
        public $TiempoExperiencia;
        public $AspiracionSalarial;
        public $Mudarse;
        public $Viajar;
        
        function __construct($a,$b,$c,$d,$e,$f,$g,$h){
            $this->CodPerfil               =$a;
            $this->CodHojaDeVida           =$b;
            $this->Profesion               =$c;
            $this->DescPerfil              =$d;
            $this->TiempoExperiencia       =$e;
            $this->AspiracionSalarial      =$f;
            $this->Mudarse                 =$g;
            $this->Viajar                  =$h;
        }
    }
    
    class PESectorEmpresa{
        public $CodSector;
        public $Sector;
        
        function __construct($a,$b){
            $this->CodSector        = $a;
            $this->NombreSector     = $b;
        }
    }
    class PEIdiomas{
        public $CodIdioma;
        public $CodHojaDeVida;
        public $Idioma;
        public $Escritura;
        public $Habla;
        public $Lectura;
        public $Escucha;
        
        function __construct($a,$b,$c,$d,$e,$f,$g){
            $this->CodIdioma        =$a;
            $this->CodHojaDeVida    =$b;
            $this->Idioma           =$c;
            $this->Escritura        =$d;
            $this->Habla            =$e;
            $this->Lectura          =$f;
            $this->Escucha          =$g;
        }
    }
    class PESubSector{
        public $CodSubSector;
        public $SubSector;
        public $CodSector;
        
        function __construct($a,$b,$c){
            $this->CodSubSector    = $a;
            $this->SubSector       = $b;
            $this->CodSector       = $c;
        }
    }

    class PEExperienciasLaborales{
        public $CodExpLaboral;
        public $CodHojaDeVida;
        public $NombreEmpresa;
        public $SectorDeEmpresa;
        public $SubSectorDeEmpresa;
        public $FechaDeInicio;
        public $FechaDeFin;
        public $NombreDelCargo;
        public $CargoEquivalente;
        public $NivelDelCargo;
        public $Area_o_Depto;
        public $Logro_y_Resp;
        public $Telefono;
        public $Ciudad;
        
        function __construct($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m,$n){
            $this->CodExpLaboral         = $a;
            $this->CodHojaDeVida         = $b;
            $this->NombreEmpresa         = $c;
            $this->SectorDeEmpresa       = $d;
            $this->SubSectorDeEmpresa    = $e;
            $this->FechaDeInicio         = date('Y-m-d',strtotime(str_replace("/","-",$f)));
            if($g!=null){
                $this->FechaDeFin            = date('Y-m-d',strtotime(str_replace("/","-",$g)));
            }else{
                $this->FechaDeFin            = null;
            }
            $this->NombreDelCargo        = $h;
            $this->CargoEquivalente      = $i;
            $this->NivelDelCargo         = $j;
            $this->Area_o_Depto          = $k;
            $this->Logro_y_Resp          = $l;
            $this->Telefono              = $m;
            $this->Ciudad                = $n;   
        }
    }
    class PENivelesDeCargos{
        public $CodNivel;
        public $NivelDeCargo;
        
        function __construct($a,$b){
            $this->CodNivel        = $a;
            $this->NivelDeCargo    = $b;  
        }
    }
    class PEHabilidades{
        public $CodHabilidad;
        public $CodHojaDeVida;
        public $Habilidad;
        
        function __construct($a,$b,$c){
            $this->CodHabilidad    = $a;
            $this->CodHojaDeVida   = $b;
            $this->Habilidad       = $c;
        }
    }
    
    class PEAreaDeEstudio{
        public $CodArea;
        public $Area;
        
        function __construct($a,$b){
            $this->CodArea = $a;
            $this->Area    = $b;
        }
    }

    class PEAreaDeCargo{
        public $CodArea;
        public $Area;
        
        function __construct($a){
            $this->CodArea = $a;
            $this->Area    = $b;
        }
    }
    
    class PENivelesDeEstudio{
        public $CodNivel;
        public $Descripcion;
        
        function __construct($a,$b){
            $this->CodNivel        =$a;
            $this->Descripcion     =$b;           
        }
    }
    
    class PEEstudios{
        public $CodEstudio;
        public $HojaDeVida;
        public $NivelEstudio;
        public $Area;
        public $Estado;
        public $FechaDeInicio;
        public $FechaDeFin;
        public $TituloRecibido;
        public $Instituto;
        public $Ciudad;
        
        function __construct($a,$j,$b,$c,$d,$e,$f,$g,$h,$i){
            $this->CodEstudio         = $a;
            $this->HojaDeVida         = $j;
            $this->NivelEstudio       = $b;
            $this->Area               = $c;
            $this->Estado             = $d;
            $this->FechaDeInicio      = date('Y-m-d',strtotime(str_replace("/","-",$e)));
            if($f!=NULL){
                $this->FechaDeFin         = date('Y-m-d',strtotime(str_replace("/","-",$f)));
            }else{
                $this->FechaDeFin         = NULL;
            }
            $this->TituloRecibido     = $g;
            $this->Instituto          = $h;
            $this->Ciudad             = $i;
        }
    }
    
    class GraficaPregunta{
        public $Tipo;
        public $FechaInicio;
        public $FechaFin;
        public $CodPregunta;
        public $Datos;
        
        function __construct($a,$b,$c,$d){
            $this->Tipo         = $a;
            $this->FechaInicio  = $b;
            $this->FechaFin     = $c;
            $this->CodPregunta  = $d;
            $this->Datos        = array();
        }
    }

    class ImgBase64{
        public $Data;
        public $img;
        function __construct($a,$b){
            $this->img         = $a;
            $this->Data        = $b;
        }
        
        public function TipoDeDato(){
            $base_to_php = explode(';', $this->Data);
            $format_img = explode('/',$base_to_php[0]);
            return $format_img[1];
        }
        
        public function Cabecera(){
            $base_to_php = explode(',', $this->Data);
            return $base_to_php[0];
        }
        
        public function Base64(){
            $base_to_php = explode(',', $this->Data);
            return base64_decode($base_to_php[1]);
        }
    }
    class RespuestaMomento{
        public $CodRespMomento;
        public $Egresado;
        public $CodMomento;
        public $FechaEstipulada;
        public $FechaReal;
        public $DiasEnDiligenciar;
        public $TotalPreguntas;
        
        function __construct($a,$b,$c,$d,$e,$f,$g){
            $this->CodRespMomento   = $a;
            $this->Egresado         = $b;
            $this->CodMomento       = $c;
            $this->FechaEstipulada  = $d;
            $this->FechaReal        = $e;
            $this->DiasEnDiligenciar= $f;
            $this->TotalPreguntas   = $g;
        }
    }

    class Egresados{
        public $CodEgresado;
        public $CodUsuario;
        public $Nombre;
        public $SegundoNombre;
        public $Apellido;
        public $SegundoApellido;
        public $FechaNacimiento;
        public $PaisResidencia;
        public $Departamento;
        public $Ciudad;
        public $TelefonoRes;
        public $Correo;
        public $Celular;
        public $Programa;
        public $Cedula;
        public $FechaMomentoActual;
        public $CodMomentoActual;
        
        function __construct($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m,$n,$o,$p,$q){
            
            $this->CodEgresado        = $a;
            $this->CodUsuario         = $b;
            $this->Nombre             = $c;
            $this->SegundoNombre      = $d;
            $this->Apellido           = $e;
            $this->SegundoApellido    = $f;
            $this->FechaNacimiento    = $g;
            $this->PaisResidencia     = $h;
            $this->Departamento       = $i;
            $this->Ciudad             = $j;
            $this->TelefonoRes        = $k;
            $this->Correo             = $l;
            $this->Celular            = $m;
            $this->Programa           = $n;
            $this->Cedula             = $o;
            $this->FechaMomentoActual = $p;
            $this->CodMomentoActual   = $q;
        
        }
    }
    
    class RespuestasEgresados{
        public $CodRespuesta;
        public $CodRespMomento;
        public $CodPregunta;
        public $CodPosRespuesta;
        public $PreguntaSistema;
        public $Respuesta;
        public $Tipo;
        
        function __construct($a,$b,$c,$d,$e,$f,$g){
            $this->CodRespuesta     = $a;
            $this->CodRespMomento   = $b;    
            $this->CodPregunta      = $c;
            $this->CodPosRespuesta  = $d;    
            $this->PreguntaSistema  = $e;    
            $this->Respuesta        = $f;
            $this->Tipo             = $g;
        }
        
        public function ConsultaNum(){
            switch($this->Tipo){
                    case 'PR_UR':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
                    break;
                    case 'PR_A':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta is NULL AND PreguntaSistema is NULL ";
                    break;
                    case 'PR_NU':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta is NULL AND PreguntaSistema is NULL ";
                    break;
                    case 'PR_SS':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta is NULL AND PreguntaSistema is NULL ";
                    break;
                    case 'PR_SN':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta is NULL AND PreguntaSistema is NULL ";
                    break;
                    case 'PR_SC':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta=".$this->CodPosRespuesta." AND PreguntaSistema=".$this->PreguntaSistema."";
                    break;
                    case 'EPR_SC':
                        return null;
                    break;
                    case 'PR_SM':
                        return "SELECT * FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta=".$this->CodPosRespuesta."";
                    break;
                    case 'EPR_SM': return null;break;
            }
        }
        
        public function Actualizar(){
            switch($this->Tipo){
                    case 'PR_UR':
                        return "UPDATE respuestasegresados SET CodPosRespuesta=".$this->CodPosRespuesta.", Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
                    break;
                    case 'PR_A':
                        return "UPDATE respuestasegresados SET Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
                    break;
                    case 'PR_NU':
                         return "UPDATE respuestasegresados SET Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
                    break;
                    case 'PR_SS':
                        return "UPDATE respuestasegresados SET Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
                    break;
                    case 'PR_SN':
                        return "UPDATE respuestasegresados SET Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
                    break;
                    case 'PR_SC':
                        return "UPDATE respuestasegresados SET Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta=".$this->CodPosRespuesta." AND PreguntaSistema=".$this->PreguntaSistema." ";
                    break;
                    case 'EPR_SC':
                    if($this->CodPosRespuesta=='null'){return "DELETE FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND Respuesta='".$this->Respuesta."'";}                 else{return "DELETE FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta=".$this->CodPosRespuesta."";}
                    break;
                    case 'PR_SM':
                        return "UPDATE respuestasegresados SET Respuesta='".$this->Respuesta."' WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta=".$this->CodPosRespuesta."";
                    break;
                    case 'EPR_SM':
                        return "DELETE FROM respuestasegresados WHERE CodRespMomento=".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta." AND CodPosRespuesta=".$this->CodPosRespuesta."";
                    break;
            }
        }
        
        public function ConocerRespuestas(){
            return "SELECT * FROM respuestasegresados WHERE CodRespMomento =".$this->CodRespMomento." AND CodPregunta=".$this->CodPregunta."";
        }
    }
    
    class Momento{
        public $CodMomento;
        public $Descripcion;
        public $Documentacion;
        
        function __construct($a,$b,$c){
            $this->CodMomento    = $a;
            $this->Descripcion   = $b;
            $this->Documentacion = $c;
        }
    }

    class PosiblesRespuestas{
        public $CodRespuesta;
        public $CodPregunta;
        public $Descripcion;
        public $Anotacion;
        public $DirPregunta;
        public $CodParte;
        public $Espacio;
        public $DirGrupo;
        
        function __construct($a, $b, $c, $d, $e, $f, $g, $h){
            $this->CodRespuesta   = $a;
            $this->CodPregunta    = $b;
            $this->Descripcion    = $c;
            $this->Anotacion      = $d;
            $this->DirPregunta    = $e;
            $this->CodParte       = $f;
            $this->Espacio        = $g;
            $this->DirGrupo       = $h;
        }
    }

    class Partes{
        public $CodParte;
        public $CodMomento;
        public $Descripcion;
        public $Info;
            
        function __construct($a, $b, $c, $d){
            $this->CodParte     = $a;
            $this->CodMomento   = $b;
            $this->Descripcion  = $c;
            $this->Info         = $d;
        }
    }

    class Grupo{
        public $CodGrupo;
        public $TituloGrupo;
        public $Descripcion;
        
        function __construct($a, $b, $c){
            $this->CodGrupo     = $a;
            $this->TituloGrupo  = $b;
            $this->Descripcion  = $c;
        }
    }
 
    class Pregunta{
        public $CodPregunta;
        public $CodParte;
        public $Descripcion;
        public $CodTipo;
        public $CodGrupo;
        public $Estado;
        
        function __construct($a, $b, $c, $d, $e, $f){
            $this->CodPregunta  = $a;
            $this->CodParte     = $b;
            $this->Descripcion  = $c;
            $this->CodTipo      = $d;
            $this->CodGrupo     = $e;
            $this->Estado       = $f;
        }
    }

    class PreguntaAbierta extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_A', $Grupo, $Estado);}}
        
    class PreguntaNumerica extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_NU', $Grupo, $Estado);}} 
    
    class EstructuraCompleja extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_SC', $Grupo, $Estado);}}
    
    class SeleccionMultiple extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_SM', $Grupo, $Estado);}}
    
    class PreguntaSN extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_SN', $Grupo, $Estado);}}
    
    class EstructuraSimple extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_SS', $Grupo, $Estado);}}
    
    class UnicaRespuesta extends Pregunta{function __construct($Pregunta, $Parte, $Descripcion, $Grupo, $Estado){parent::__construct($Pregunta, $Parte, $Descripcion, 'PR_UR', $Grupo, $Estado);}}

    
?>