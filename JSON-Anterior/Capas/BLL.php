<?php
    include_once('Entity.php');
    include_once('DAL.php');
    //Metodos Guardar
    function GuardarPregunta($a){return DLGuardarPregunta($a);}
    function GuardarGrupo($b){return DLGuardarGrupo($b);}
    function GuardarParte($c){return DLGuardarParte($c);}
    function GuardarRespuestas($d){return DLGuardarRespuestas($d);}
    function GuardarRespuestasUser($j){return DLGuardarRespuestasUser($j);}
    function GuardarImagenes($i){DLGuardarImagenes($i);}
    function HvFormacion_Academica($hv){return DLHvFormacion_Academica($hv);}
    function HvPerfil_Laboral($hv){return DLHvPerfil_Laboral($hv);}
    function HvExperiencia_Laboral($hv){return DLHvExperiencia_Laboral($hv);}
    function HvGoogle_Drive($hv){return DLHvGoogle_Drive($hv);}
    function HvIdiomas($hv){return DLHvIdiomas($hv);}
    function HvRedes_Sociales($hv){return DLHvRedes_Sociales($hv);}
    function GuardarRepresentanteEmpresas($Rep, $Emp){return DLGuardarRepresentanteEmpresas($Rep, $Emp);}
    function DatosHojaDeVida(){return DLHVDatosHojaDeVida();}
    function PublicarOfertaDeEmpleo($Pu,$Est,$Exp,$Demo){return DLPublicarOfertaDeEmpleo($Pu,$Est,$Exp,$Demo);}
    function AplicarOfertaDeEmpleo($Oferta){return DLAplicarOfertaDeEmpleo($Oferta);};
    function GuardarEmpleado($Emp,$NombreUsuario,$Pass){return DLGuardarEmpleado($Emp,$NombreUsuario,$Pass);}
    function RegistrarEgresados($a,$fecha){ return DLRegistrarEgresados($a,$fecha);}
    
    //Metodos Actualizar
    function ActualizarEstado($e){return DLActualizarEstado($e);}
    function ActualizarParte($f){return DLActualizarParte($f);}
    function ActualizarRespuesta($g){return DLActualizarRespuesta($g);}
    function ActualizarPregunta($h){return DLActualizarPregunta($h);}
    function ConsultarPreguntas2($p){return DLConsultarPreguntas2($p);}
    function ActualizarGrupo($i){return DLActualizarGrupo($i);}
    function ActualizarGrupo2($i){return DLActualizarGrupo2($i);}
    function FinalizarEncuesta(){DLFinalizarEncuesta();}
    function ActualizarInfoParte($f){return DLActualizarInfoParte($f);}
    function ConsultarMIN_MAX(){return DLConsultarMIN_MAX();}
    function GraficCreation($g){return DLGraficCreation($g);}
    function GraficCreation2($g,$Respuesta){return PosSC_DLGraficCreation($g,$Respuesta);}
    function ConsultarDocNatural(){return DLConsultarDocNatural();};
    function ConsultarDocJuridica(){return DLConsultarDocJuridica();};
    function ConsultarInfoUsuarios(){
        switch($_SESSION['Rol']){
            case 'Egresado':
                return DLConsultaInfoEgresados();
                break;
            case 'Empleado':
                return DLConsultaInfoEmpleado();
                break;
            case 'Empresa':
                return DLConsultaInfoEmpresa();
                break;
            case 'Admin':
                return DLConsultaInfoAdmin();
                break;
        }
        
    }
    function ActualizarDatosDeEmpresa($Emp,$NumEmp,$Fax,$Web){return DLActualizarDatosDeEmpresa($Emp,$NumEmp,$Fax,$Web);}
    function ActualizarDatosDelRepresentante($Rep){
        return DLActualizarDatosDelRepresentante($Rep);
    }
    function ProcesoDeSeleccion($Process){return DLProcesoDeSeleccion($Process);}
    //Metodos Consultar
    function ConsultarGrupo(){return DLConsultarGrupo();}
    function ConsultarMomentos(){return DLConsultarMomentos();}
    function ConsultarPartes(){return DLConsultarPartes();}
    function ConsultarPartesDeMomento($m){return DLConsultarPartesDeMomento($m);}
    function ConsultarPosRespuestas($n){return DLConsultarPosRespuestas($n);}
    function ConsultarPosRespuestasDos($o){return DLConsultarPosRespuestasDos($o);}
    function ConsultarPreguntas($sec){return DLConsultarPreguntas($sec);}
    function ConsultarPreguntasDePartes($q){return DLConsultarPreguntasDePartes($q);}
    function ConsultarPreguntaUnica($r){return DLConsultarPreguntaUnica($r);}
    function ConsultarTiposPreguntas(){return DLConsultarTiposPreguntas();}
    function PRuebaDataTable(){return DLPRuebaDataTable();}
    function TagsCiudades(){return DLTagsCiudades();}
    function HvConsultarAreasDeEstudio($hv){return DLHvConsultarAreasDeEstudio($hv);}
    function HvNivelesDeEstudio(){return DLHvNivelesDeEstudio();}
    function ListaDeIdiomas(){return DLHvListaDeIdiomas();}
    function SectorDeEmpresas(){return DLSectorDeEmpresas();}
    function SubSectorDeEmpresa($hv){return DLSubSectorDeEmpresa($hv);}
    function AreaDeCargo(){return DLAreaDeCargo();}
    function NivelDeCargo(){return DLNivelDeCargo();}
    function CargosEquivalentes(){return DLCargosEquivalentes();}
    function ConsultarEstudios($h){return DLHVConsultarEstudios($h);}
    function ConsultarExperienciasLaborales($a){return DLHVConsultarExperienciasLaborales($a);}
    function ConsultarNumeroEmpleados(){return DLEPConsultarNumeroEmpleados();}
    function ConsultarOfertas($Tipo){return DLConsultarOfertas($Tipo);}
    function ConsultarPublicacionOferta($Id){return DLConsultarPublicacionOferta($Id);}
    function EPConsultarEgresado($Anyo,$Programa){return DLEPConsultarEgresado($Anyo,$Programa);}
    function EPConsultarDetalleEgresado($Id){return DLEPConsultarDetalleEgresado($Id);}
    function TableAspirantes($Oferta){return DLTableAspirantes($Oferta);}
    function EPConsultarHojaDeVida($Id){return DLEPConsultarHojaDeVida($Id);}
    function ReporteGeneralEgresadosPorCarrera($g){return  DLReporteGeneralEgresadosPorCarrera($g);}
    //Metodos Eliminar
    function EliminarGrupo($t){return EliminarGrupo($t);}
    function EliminarParte($u){return DLEliminarParte($u);}
    function EliminarPregunta($v){return DLEliminarPregunta($v);}
    function EliminarRespuesta($w){return DLEliminarRespuesta($w);}
    function EliminarEstudios($h){return DLHVEliminarEstudios($h);}
    function EliminarExperiencia($h){return DLHVEliminarExperiencia($h);}
    function EliminarIdioma($i){return DLHVEliminarIdioma($i);}
    function EliminarPublicacion($Oferta){return DLEliminarPublicacion($Oferta);}
    //Metodos de Envio BLL
    function EnviarPregunta(){DLLimpiarSiguiente($_SESSION['PreguntaActual']);PreguntaSiguiente($_SESSION['PreguntaActual']);if($_SESSION['DirGrupo']!=NULL && isset($_SESSION['DirGrupo']) && $_SESSION['FinGrupo']==FALSE){if($_SESSION['DirParte']!=NULL || isset($_SESSION['DirParte'])){return TraerDirParte();}else if($_SESSION['PreguntaDir']!=NULL || isset($_SESSION['PreguntaDir'])){$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodPregunta=".$_SESSION['PreguntaDir']."";$_SESSION['PreguntaDir']=NULL;return CuerpoDePregunta($Consulta);}else{return AvanceGrupoDePregunta();   }}else if($_SESSION['DirParte']!=NULL || isset($_SESSION['DirParte'])){return TraerDirParte();}else if($_SESSION['Parcial']!=FALSE && $_SESSION['Parcial']!=NULL && $_SESSION['FinParcial']==TRUE){;return PreguntaParcial();}else if($_SESSION['PreguntaDir']!=NULL || isset($_SESSION['PreguntaDir'])){$Consulta = "SELECT p.CodPregunta,p.CodParte,(SELECT ps.Descripcion FROM partes ps WHERE ps.CodParte=p.CodParte) as DescParte,p.Descripcion,p.CodTipo,p.CodGrupo,p.Estado FROM pregunta p WHERE p.CodPregunta=".$_SESSION['PreguntaDir']."";   $_SESSION['PreguntaDir']=NULL;return CuerpoDePregunta($Consulta);}else{return AvanceProgresivo();}}

    function PreguntasEnProceso(){/*$var=EnviarPregunta();if(empty(json_decode($var,true))){echo $var;}else*/if(isset($_SESSION['PreguntaParcial']) && $_SESSION['PreguntaParcial']!=NULL){return   DLConsultaParcialDeParte();}else if(isset($_SESSION['PreguntaActual']) && $_SESSION['PreguntaActual']!=NULL){return   DLConsultaActualDeParte();}else{return DLTraerPreguntaParte();}}

    function ConsultarFechasDeGrado(){
         $year = date("Y");
        $Fechas = array();
        for($i=1945;$i<$year+1;$i++){
            array_push($Fechas,$i);
        }
        return json_encode($Fechas);
    }
?>