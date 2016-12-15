<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorSindicato extends CI_Controller
{
   static function Tabla()
   {
        return "sindicato";
   }
   
   /*
    * Constructor del controlador
    */
   public function __construct()
   {
       parent::__construct();
        $this->load->model('procedimientos_model');      
        $this->load->helper('url');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session','form_validation'));                
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }
      
   /*
    * Método inicial del controlador
    */
   public function index($ordenamiento = 1)
   {  
        if($this->session->userdata('esLogueado') == FALSE)        
            redirect('login');
       
        $rut = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;        
        $parametros = $this->ObtenerListaValoresSindicato($ordenamiento, $desde, $rut);        
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorSindicato/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();
        
        $this->load->view('vistaSindicato',$parametros);                   
   }
   
   public function AdicionarSindicato()
   {       
        if(isset($_POST['txtOtrosBienesInmueblesAdic']))
           $otrosBienesInmuebles = $_POST['txtOtrosBienesInmueblesAdic'];
        else
            $otrosBienesInmuebles = "";
       
        if(isset($_POST['txtOtraSecretariaAdic']))
           $otraSecretaria = $_POST['txtOtraSecretariaAdic'];
        else
            $otraSecretaria = "";       
       
        if(isset($_POST['sltCaracteristicasSindicatoInactivoAdic']))
            $caracteristicasSindicatoInactivo = $_POST['sltCaracteristicasSindicatoInactivoAdic'];
        else
            $caracteristicasSindicatoInactivo = "";       
       
        if(isset($_POST['txtNombreSindicatoFusionaAdic']))
            $nombreSindicatoFusiona = $_POST['txtNombreSindicatoFusionaAdic'];
        else
            $nombreSindicatoFusiona = "";              
        
        if(isset($_POST['txtOtroTipoViolenciaAdic']))
            $otroTipoViolencia = $_POST['txtOtroTipoViolenciaAdic'];
        else
            $otroTipoViolencia = "";                      
        
        if(isset($_POST['sltSindicatoSegCapEmpAdic']))
            $sindicatoSegCapEmp = $_POST['sltSindicatoSegCapEmpAdic'];
        else
            $sindicatoSegCapEmp = "";                              
       
        $rut = $_POST['txtRutAdic'];
        $registroSindical = $_POST['txtRegistroSindicalAdic'];        
        
        $datosAuditoria = $this->Auditoria($rut, "AD");
        $rpta = $this->procedimientos_model->SetProcedure("sindicato_insertar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacionAdic']."',
                '".$registroSindical."',
                '".$_POST['sltFederacionAfiliacionAdic']."',
                '".$caracteristicasSindicatoInactivo."',                    
                '".$_POST['sltSindicatoSegOriCapAdic']."',
                '".$sindicatoSegCapEmp."',                
                '".$_POST['sltSindicatoEstModaContraAdic']."',
                '".$_POST['sltEstadoAdic']."',
                '".$_POST['sltAfiliacionFedRamaAdic']."',
                '".$_POST['sltPeriodoVigJuntaDirectivaAdic']."',                
                '".$_POST['sltCentralSindProvAdic']."',
                '".$_POST['sltAfiliacionFedRamaAdic']."',                
                '".$_POST['sltSindicatoSegTipEmprEstAdic']."',
                '".$_POST['sltClaseSindicatoAdic']."',                
                '".$_POST['sltClaseDirectivaAdic']."',                
                '".$_POST['sltMunicipioAdic']."',                
                '".$_POST['txtNumeroResolucionAdic']."',                
                '".date('Y')."',                
                '".$_POST['txtFechaAdic']."',
                '".$_POST['txtNombreSindicatoAdic']."',
                '".$_POST['txtSiglaAdic']."',
                '".$_POST['txtDireccionAdic']."',
                '".$_POST['txtTelefonoAdic']."',
                '".$_POST['txtCelularAdic']."',
                '".$_POST['txtFaxAdic']."',
                '".$_POST['txtCorreoAdic']."',
                '".$_POST['txtPaginaWebAdic']."',      
                '".$_POST['txtFacebookAdic']."',
                '".$_POST['txtTwiterAdic']."',
                '".$_POST['txtFechaUltInscrJunDirectivaAdic']."',
                '".$_POST['txtNumeroTotalAfiliadosAdic']."',
                '".$_POST['txtDescripcionAfiliadosEmpresaAdic']."',
                '".$_POST['txtNumeroAfiliadosHombresAdic']."',
                '".$_POST['txtNumeroAfiliadosMujeresAdic']."',
                '".$_POST['txtNumeroAfiliadosJovenesMenor35Adic']."',
                '".$_POST['txtNumeroAfiliadosSectorFormalAdic']."',
                '".$_POST['txtNumeroAfiliadosSectorInformalAdic']."',
                '".$nombreSindicatoFusiona."',                    
                '".$otrosBienesInmuebles."',
                '".$otraSecretaria."',
                '".date('Y-m-d')."',                                    
                '".$_POST['txtObservacionesAdic']."',
                b'".$_POST['rdbActividadEconomicaServPubAdic']."',
                b'".$_POST['rdbDescuentoCuotaSindicalAdic']."',
                b'".$_POST['rdbVictimaViolenciaAdic']."',    
                '".$otroTipoViolencia."'    
                ", $datosAuditoria);        
        
        $parametros = $this->ObtenerListaValoresSindicato(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);        

       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
        {
            // <editor-fold defaultstate="collapsed" desc="Medios de comunicación">
            
           if(isset($_POST['chkBoletinAdic']))
           {
                if($_POST['chkBoletinAdic'] == 'BOLETIN')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_medio_comunicacion_adicionar",
                             "'".$_POST['chkBoletinAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkPeriodicoAdic']))
           {
                if($_POST['chkPeriodicoAdic'] == 'PERIODICO')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_medio_comunicacion_adicionar",
                             "'".$_POST['chkPeriodicoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkProgramaRadioAdic']))
           {
                if($_POST['chkProgramaRadioAdic'] == 'PROGRAMARADIO')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_medio_comunicacion_adicionar",
                             "'".$_POST['chkProgramaRadioAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkTelevisionAdic']))
           {
                if($_POST['chkTelevisionAdic'] == 'TELEVISION')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_medio_comunicacion_adicionar",
                             "'".$_POST['chkTelevisionAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="Bienes Inmuebles">
           
           if(isset($_POST['chkCentroRecreativoAdic']))
           {
                if($_POST['chkCentroRecreativoAdic'] == 'CENTROECREATIVO')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_bien_inmueble_adicionar",
                             "'".$_POST['chkCentroRecreativoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkOtrosBienesInmueblesAdic']))
           {
                if($_POST['chkOtrosBienesInmueblesAdic'] == 'OTROSBIENESINMUEBLES')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_bien_inmueble_adicionar",
                             "'".$_POST['chkOtrosBienesInmueblesAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkSedePropiaAdic']))
           {
                if($_POST['chkSedePropiaAdic'] == 'SEDEPROPIA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_bien_inmueble_adicionar",
                             "'".$_POST['chkSedePropiaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           // </editor-fold>                      
            // <editor-fold defaultstate="collapsed" desc="Afiliación Internacional">
           
           if(isset($_POST['chkBwiAdic']))
           {
                if($_POST['chkBwiAdic'] == 'BWI')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkBwiAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkEiAdic']))
           {
                if($_POST['chkEiAdic'] == 'EI')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkEiAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkIaeaAdic']))
           {
                if($_POST['chkIaeaAdic'] == 'IAEA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIaeaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkIfjAdic']))
           {
                if($_POST['chkIfjAdic'] == 'IFJ')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIfjAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkIndustryAllAdic']))
           {
                if($_POST['chkIndustryAllAdic'] == 'INDUSTRYALL')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIndustryAllAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkItfAdic']))
           {
                if($_POST['chkItfAdic'] == 'ITF')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkItfAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkIufAdic']))
           {
                if($_POST['chkIufAdic'] == 'IUF')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIufAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkPsiAdic']))
           {
                if($_POST['chkPsiAdic'] == 'PSI')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkPsiAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkUniAdic']))
           {
                if($_POST['chkUniAdic'] == 'UNI')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkUniAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      
           
           if(isset($_POST['chkNoAfiliadoAdic']))
           {
                if($_POST['chkNoAfiliadoAdic'] == 'NOAFILIADO')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_internacional_adicionar",
                             "'".$_POST['chkNoAfiliadoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                 
           
           // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="Afiliación federación regional ">
           
           if(isset($_POST['chkAntioquiaAdic']))
           {
                if($_POST['chkAntioquiaAdic'] == 'ANTIOQUIA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkAntioquiaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkBogotaAdic']))
           {
                if($_POST['chkBogotaAdic'] == 'BOGOTA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkBogotaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkBolivarAdic']))
           {
                if($_POST['chkBolivarAdic'] == 'BOLIVAR')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkBolivarAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkCaldasAdic']))
           {
                if($_POST['chkCaldasAdic'] == 'CALDAS')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkCaldasAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkCesarAdic']))
           {
                if($_POST['chkCesarAdic'] == 'CESAR')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkCesarAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkCordobaAdic']))
           {
                if($_POST['chkCordobaAdic'] == 'CORDOBA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkCordobaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkFedetralAdic']))
           {
                if($_POST['chkFedetralAdic'] == 'FEDETRAL')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFedetralAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkFedetrarAdic']))
           {
                if($_POST['chkFedetrarAdic'] == 'FEDETRAR')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFedetrarAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkFertrasuccolAdic']))
           {
                if($_POST['chkFertrasuccolAdic'] == 'FERTRASUCCOL')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFertrasuccolAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      
           
           if(isset($_POST['chkFesinuvalcAdic']))
           {
                if($_POST['chkFesinuvalcAdic'] == 'FESINUVALC')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFesinuvalcAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                 
           
           if(isset($_POST['chkFesrtralvaAdic']))
           {
                if($_POST['chkFesrtralvaAdic'] == 'FESRTRALVA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFesrtralvaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkFestratolAdic']))
           {
                if($_POST['chkFestratolAdic'] == 'FESTRATOL')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFestratolAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkFetrabolAdic']))
           {
                if($_POST['chkFetrabolAdic'] == 'FETRABOL')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFetrabolAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkFetralmagAdic']))
           {
                if($_POST['chkFetralmagAdic'] == 'FETRALMAG')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFetralmagAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      
           
           if(isset($_POST['chkFetralnaAdic']))
           {
                if($_POST['chkFetralnaAdic'] == 'FETRALNA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFetralnaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                            
           
           if(isset($_POST['chkFetralnorteAdic']))
           {
                if($_POST['chkFetralnorteAdic'] == 'FETRALNORTE')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkFetralnorteAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                            
           
           if(isset($_POST['chkSantanderAdic']))
           {
                if($_POST['chkSantanderAdic'] == 'SANTANDER')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkSantanderAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                            
           
           if(isset($_POST['chkValledelcaucaAdic']))
           {
                if($_POST['chkValledelcaucaAdic'] == 'VALLEDELCAUCA')
                {
                     $this->procedimientos_model->SetProcedure("sindicato_afiliacion_subdirectiva_regional_adicionar",
                             "'".$_POST['chkValledelcaucaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                                       
           
           // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="Secretarias">
        
            if(isset($_POST['chkAdministracionFinanzasAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAdministracionFinanzasAdic'], 'ADMINISTRAFINANZAS', $rut);           
            if(isset($_POST['chkAsuntosAgrariosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosAgrariosAdic'], 'ASUNTOSAGRARIOS', $rut);
            if(isset($_POST['chkAsuntosCooperativosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosCooperativosAdic'], 'ASUNTOSCOOPERATIVOS', $rut);
            if(isset($_POST['chkAsuntosNinezAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosNinezAdic'], 'ASUNTOSNINEZ', $rut);
            if(isset($_POST['chkAsuntosEnergeticosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosEnergeticosAdic'], 'ASUNTOSENERGETICOS', $rut);
            if(isset($_POST['chkAsuentosInternacionalesAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuentosInternacionalesAdic'], 'ASUNTOSINTERNACIONA', $rut);
            if(isset($_POST['chkAsuntosInterSindicalesAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosInterSindicalesAdic'], 'ASUNTOSINTERSINDICA', $rut);
            if(isset($_POST['chkAsuntosJuridicosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosJuridicosAdic'], 'ASUNTOSJURILABOR', $rut);
            if(isset($_POST['chkAsuntosPoliticosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkAsuntosPoliticosAdic'], 'ASUNTOSPOLILEGISLATI', $rut);           
            if(isset($_POST['chkComunicacionAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkComunicacionAdic'], 'COMUNICACION', $rut);           
            if(isset($_POST['chkConflictosLaboralesAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkConflictosLaboralesAdic'], 'CONFLICTOSLABORALES', $rut);           
            if(isset($_POST['chkDerechosHumanosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkDerechosHumanosAdic'], 'DERECHOSHUMASINDICA', $rut);
            if(isset($_POST['chkEcologiaMedioAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkEcologiaMedioAdic'], 'ECOLOGIAMEDIOAMBIEN', $rut);
            if(isset($_POST['chkEcologiaRecursosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkEcologiaRecursosAdic'], 'ECOLOGIARECURNATURAL', $rut);
            if(isset($_POST['chkEducacionAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkEducacionAdic'], 'EDUCACION', $rut);
            if(isset($_POST['chkEducacionInvestigacionAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkEducacionInvestigacionAdic'], 'EDUCACIONINVESTIGA', $rut);
            if(isset($_POST['chkJuventudAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkJuventudAdic'], 'JUVENTUD', $rut);
            if(isset($_POST['chkMedioAmbienteAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkMedioAmbienteAdic'], 'MEDIOAMBIENTE', $rut);
            if(isset($_POST['chkMujerAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkMujerAdic'], 'MUJER', $rut);
            if(isset($_POST['chkOrganizacionAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkOrganizacionAdic'], 'ORGANIZACION', $rut);           
            if(isset($_POST['chkOrganizacionSocialesAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkOrganizacionSocialesAdic'], 'ORGANIZACIONSOCIAL', $rut);                       
            if(isset($_POST['chkPlaneacionAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkPlaneacionAdic'], 'PLANEACION', $rut);                                   
            if(isset($_POST['chkProyectosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkProyectosAdic'], 'PROYECTOS', $rut);            
            if(isset($_POST['chkRelacionesPublicasAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkRelacionesPublicasAdic'], 'RELACIONESPUBLICAS', $rut);
            if(isset($_POST['chkSecretariaActasAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkSecretariaActasAdic'], 'SECRETARIAACTAS', $rut);            
            if(isset($_POST['chkSeguridadSocialAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkSeguridadSocialAdic'], 'SEGURIDADSOCIAL', $rut);
            if(isset($_POST['chkServidoresPublicosAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkServidoresPublicosAdic'], 'SERVIDORESPUBLICOS', $rut);            
            if(isset($_POST['chkTrabajoInformalAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkTrabajoInformalAdic'], 'TRABAJOINFORMAL', $rut);            
            if(isset($_POST['chkTransporteAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkTransporteAdic'], 'TRANSPORTE', $rut);            
            if(isset($_POST['chkOtraSecretariaAdic']))
                $this->AdicionarSecretariaSindicato($_POST['chkOtraSecretariaAdic'], 'OTRASECRETARIA', $rut);                       
            
           // </editor-fold>           
            // <editor-fold defaultstate="collapsed" desc="tipo de Violencia">
        
            if(isset($_POST['chkAllanamientoIlegalAdic']))
                $this->AdicionarTipoViolencia($_POST['chkAllanamientoIlegalAdic'], 'ALLANAMIENTOILEGAL', $rut);           
            if(isset($_POST['chkAmenazasAdic']))
                $this->AdicionarTipoViolencia($_POST['chkAmenazasAdic'], 'AMENAZAS', $rut);                       
            if(isset($_POST['chkAtentadoLesionesAdic']))
                $this->AdicionarTipoViolencia($_POST['chkAtentadoLesionesAdic'], 'ATENTADOLESIONES', $rut);
            if(isset($_POST['chkDesaparicionAdic']))
                $this->AdicionarTipoViolencia($_POST['chkDesaparicionAdic'], 'DESAPARICION', $rut);
            if(isset($_POST['chkDesplazamientoForzosoAdic']))
                $this->AdicionarTipoViolencia($_POST['chkDesplazamientoForzosoAdic'], 'DESPLAZADOFORZOSO', $rut);            
            if(isset($_POST['chkDetencionArbitrariaAdic']))
                $this->AdicionarTipoViolencia($_POST['chkDetencionArbitrariaAdic'], 'DETENCIONARBITRARIA', $rut);            
            if(isset($_POST['chkHomicidiosAdic']))
                $this->AdicionarTipoViolencia($_POST['chkHomicidiosAdic'], 'HOMICIDIOS', $rut);                        
            if(isset($_POST['chkHostigamientoAdic']))
                $this->AdicionarTipoViolencia($_POST['chkHostigamientoAdic'], 'HOSTIGAMIENTO', $rut);
            if(isset($_POST['chkSecuestroAdic']))
                $this->AdicionarTipoViolencia($_POST['chkSecuestroAdic'], 'SECUESTRO', $rut);                                                
            if(isset($_POST['chkOtroTipoViolenciaAdic']))
                $this->AdicionarTipoViolencia($_POST['chkOtroTipoViolenciaAdic'], 'OTROTIPOVIOLENCIA', $rut);
            
           // </editor-fold>                       
           
           
           if($this->session->userdata('perfil') == 'Editor Sindicato')
           {
                $this->procedimientos_model->SetProcedure("usuario_sindicato_insertar", "'".$registroSindical."','".$this->session->userdata('idUsuario')."'");                
                $this->session->set_userdata('registroSindical', $registroSindical);
                $parametros = $this->ObtenerListaValoresSindicato();
           }
           
           $parametros['estadoAdicionar'] = true;
        }
       
        $this->load->view('vistaSindicato', $parametros);
    }
   
   public function ModificarSindicato()
   {       
       if(isset($_POST['txtOtrosBienesInmubles']))
           $otrosBienesInmuebles = $_POST['txtOtrosBienesInmubles'];
       else
           $otrosBienesInmuebles = "";
       
       if(isset($_POST['txtOtraSecretaria']))
           $otraSecretaria = $_POST['txtOtraSecretaria'];
       else
           $otraSecretaria = "";                     

        if(isset($_POST['sltCaracteristicasSindicatoInactivo']))
            $caracteristicasSindicatoInactivo = $_POST['sltCaracteristicasSindicatoInactivo'];
        else
            $caracteristicasSindicatoInactivo = "";       
       
        if(isset($_POST['txtNombreSindicatoFusiona']))
            $nombreSindicatoFusiona = $_POST['txtNombreSindicatoFusiona'];
        else
            $nombreSindicatoFusiona = "";                     
        
        if(isset($_POST['txtOtroTipoViolencia']))
            $otroTipoViolencia = $_POST['txtOtroTipoViolencia'];
        else
            $otroTipoViolencia = "";
        
        if(isset($_POST['sltSindicatoSegCapEmpAdic']))
            $sindicatoSegCapEmp = $_POST['sltSindicatoSegCapEmpAdic'];
        else
            $sindicatoSegCapEmp = "";                                      
       
       $rut = $_POST['txtRut'];
       $registroSindical = $_POST['txtRegistroSindical'];               
       
       $datosAuditoria = $this->Auditoria($rut, "MD");                   
       $rpta = $this->procedimientos_model->SetProcedure("sindicato_modificar",        
                "'".$rut."',
                '".$_POST['txtDigitoVerificacion']."',                                            
                '".$registroSindical."',              
                '".$_POST['sltFederacionAfiliacion']."',                                        
                '".$caracteristicasSindicatoInactivo."',
                '".$_POST['sltSindicatoSegOriCap']."',
                '".$sindicatoSegCapEmp."',
                '".$_POST['sltSindicatoEstModaContra']."',
                '".$_POST['sltEstado']."',
                '".$_POST['sltAfiliacionFedRama']."',
                '".$_POST['sltPeriodoVigJuntaDirectiva']."',                
                '".$_POST['sltCentralSindProv']."',
                '".$_POST['sltAfiliacionFedRama']."',                
                '".$_POST['sltSindicatoSegTipEmprEst']."',
                '".$_POST['sltClaseSindicato']."',                
                '".$_POST['sltClaseDirectiva']."',                
                '".$_POST['sltCodMunicipio']."',                
                '".$_POST['txtNumeroResolucion']."',                                
                '".$_POST['txtFecha']."',
                '".$_POST['txtNombSindicato']."',
                '".$_POST['txtSigla']."',
                '".$_POST['txtDireccion']."',
                '".$_POST['txtTelefono']."',
                '".$_POST['txtCelular']."',
                '".$_POST['txtFax']."',
                '".$_POST['txtCorreo']."',
                '".$_POST['txtPaginaWeb']."',    
                '".$_POST['txtFacebook']."',
                '".$_POST['txtTwiter']."',
                '".$_POST['txtFechaUltimaInscJunta']."',
                '".$_POST['txtNumeroTotalAfiliados']."',
                '".$_POST['txtDescripcionAfiliadosEmpresa']."',
                '".$_POST['txtNumeroAfiliadosHombres']."',
                '".$_POST['txtNumeroAfiliadosMujeres']."',
                '".$_POST['txtNumeroAfiliadosJovenes35']."',
                '".$_POST['txtNumeroAfiliadosSectorFormal']."',
                '".$_POST['txtNumeroAfiliadosSectorInformal']."',
                '".$nombreSindicatoFusiona."',
                '".$otrosBienesInmuebles."',
                '".$otraSecretaria."',                                
                '".date('Y-m-d')."',    
                '".$_POST['txtObservaciones']."',
                b'".$_POST['rdbActividadEconomicaServPub']."',
                b'".$_POST['rdbDescuentoCuotaSindical']."',
                b'".$_POST['rdbVictimaViolencia']."',                    
                '".$otroTipoViolencia."'
                ", $datosAuditoria);       
        
        $parametros = $this->ObtenerListaValoresSindicato(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);        
        
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaSindicato', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarSindicato($rut)
   {            
        $datosAuditoria = $this->Auditoria($rut, "EL");
        $rpta = $this->procedimientos_model->SetProcedure("sindicato_eliminar","'$rut'", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresSindicato(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);
                
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaSindicato', $parametros);  
    }
    
    public function Auditoria($rut, $tipoCreacionCambio)
    {
        $datosAuditoria['idRegistro'] = $rut;
        $datosAuditoria['idUsuario'] = $this->session->userdata('idUsuario');
        $datosAuditoria['tabla'] = $this->Tabla();
        $datosAuditoria['fecha'] = date('Y-m-d H:i:s');
        $datosAuditoria['tipo_creacion_cambio'] = $tipoCreacionCambio;
        $datosAuditoria['ip_usuario'] = $this->procedimientos_model->ObtenerIP();
        
        return $datosAuditoria;
    }
    
    public function Paginacion($parametros)
    {
        $this->ObtenerListaValoresSindicato();        
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorSindicato/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarSindicato($rut, $consultar = "")
   {
        $registro = $this->procedimientos_model->GetProcedure("sindicato_seleccionar_por_rut","'$rut'");
        $mediosComunicacion = $this->procedimientos_model->GetProcedure("sindicato_medio_comunicacion_seleccionar_por_rut","'$rut'");
        $secretariasSindicato = $this->procedimientos_model->GetProcedure("sindicato_secretarias_sindicato_seleccionar_por_rut","'$rut'");
        $bienInmueble = $this->procedimientos_model->GetProcedure("sindicato_bien_inmueble_seleccionar_por_rut","'$rut'");
        $tipoViolencia = $this->procedimientos_model->GetProcedure("sindicato_tipo_Violencia_seleccionar_por_rut","'$rut'");
        $afiliacionInternacional = $this->procedimientos_model->GetProcedure("sindicato_afiliacion_internacional_seleccionar_por_rut","'$rut'");        
        $afiliacionSubdirectivaRegional = $this->procedimientos_model->GetProcedure("sindicato_afiliacion_subdirectiva_regional_seleccionar_por_rut","'$rut'");        
        $directivos = $this->procedimientos_model->GetProcedure("sindicato_directivo_seleccionar_por_rut","'$rut'");
        $parametros = $this->ObtenerListaValoresSindicato();
        $parametros['registros'] = $registro;
        $parametros['mediosComunicacion'] = $mediosComunicacion;
        $parametros['bienInmueble'] = $bienInmueble;
        $parametros['tipoViolencia'] = $tipoViolencia;
        $parametros['afiliacionInternacional'] = $afiliacionInternacional;        
        $parametros['afiliacionSubdirectivaRegional'] = $afiliacionSubdirectivaRegional;        
        $parametros['secretariasSindicato'] = $secretariasSindicato;
        $parametros['registroDirectivos'] = $directivos;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaSindicato', $parametros);
    }
        
   /*
    * Generación de excel
    */
   public function GenerarExcel()
   {
        @ob_start("ob_gzhandler");  //Inicio de buffer       
        include($_SERVER['DOCUMENT_ROOT'].'/application/libraries/PHPExcel.php');
        
        /*
        * PHP Excel - Create a simple 2007 XLSX Excel file
        */
        // create new PHPExcel object
        $objPHPExcel = new PHPExcel;        
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');        
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);
        // Se crea el archivo
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

        // Se ubica sobre la primera hoja
        $objSheet = $objPHPExcel->getActiveSheet();
        
        // Se renombra la hoja
        $objSheet->setTitle('DatosSindicatos');

        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSindicatos = $this->procedimientos_model->GetProcedure("sindicato_seleccionar","");
        else
           $registrosConsultaSindicatos = $this->procedimientos_model->GetProcedure("sindicato_seleccionar_por_perfil","'".$this->session->userdata('registroSindical')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('RUT'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE'));
        $objSheet->getCell('C1')->setValue(utf8_encode('SIGLAS'));
        $objSheet->getCell('D1')->setValue(utf8_encode('ESTADO'));
        $objSheet->getCell('E1')->setValue(utf8_encode('DEPARTAMENTO'));
        $objSheet->getCell('F1')->setValue(utf8_encode('MUNICIPIO'));
        $objSheet->getCell('G1')->setValue(utf8_encode('DIRECCIÓN'));
        $objSheet->getCell('H1')->setValue(utf8_encode('TELÉFONOS'));
        $objSheet->getCell('I1')->setValue(utf8_encode('AÑO CREACIÓN'));

        foreach($registrosConsultaSindicatos as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['rut'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['siglas'])));    
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['estado_codigo'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['departamento'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['municipio'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['direccion'])));
            $objSheet->getCell('H'.$i)->setValue(utf8_encode(utf8_decode($registro['telefonos'])));
            $objSheet->getCell('I'.$i)->setValue(utf8_encode(utf8_decode($registro['anyo'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);
        $objSheet->getColumnDimension('F')->setAutoSize(true);
        $objSheet->getColumnDimension('G')->setAutoSize(true);
        $objSheet->getColumnDimension('H')->setAutoSize(true);
        $objSheet->getColumnDimension('I')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Sindicatos.xlsx');               
        header('Location: /temp/Sindicatos.xlsx');
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Generación de pdf
    */
   public function GenerarPdf()
   {
        @ob_start("ob_gzhandler");  //Inicio de buffer               
        require($_SERVER['DOCUMENT_ROOT'].'/application/controllers/pdf.php'); 
        date_default_timezone_set('America/Bogota');
        
        //Definición del archiv pdf
        $pdf = new PDF('L','mm','A4');
        //Agrego página
        $pdf->AddPage();
        //Cabecera del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $pdf->Cabecera('LISTADO DE SINDICATOS', '', 125);        
        else
           $pdf->Cabecera('INFORMACIÓN DEL SINDICATO', '', 125);        
        
        //Defino el ancho de cada columna
        $w = array(22, 35, 21, 33, 30, 24, 38, 27, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('RUT', 'NOMBRE', 'SIGLAS', 'ESTADO', 'DEPARTAMENTO', 'MUNICIPIO', 'DIRECCION', 'TELEFONO', 'AÑO DE CREACION');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSindicatos = $this->procedimientos_model->GetProcedure("sindicato_seleccionar","");
        else
           $registrosConsultaSindicatos = $this->procedimientos_model->GetProcedure("sindicato_seleccionar_por_perfil","'".$this->session->userdata('registroSindical')."'");
        
                        
        foreach($registrosConsultaSindicatos as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["rut"]), 
                            utf8_decode($registro["nombre"]), 
                            utf8_decode($registro["siglas"]), 
                            utf8_decode($registro["estado_codigo"]), 
                            utf8_decode($registro["departamento"]), 
                            utf8_decode($registro["municipio"]), 
                            utf8_decode($registro["direccion"]), 
                            utf8_decode($registro["telefonos"]),
                            utf8_decode($registro["anyo"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer          
   }
   
   /*
    * Se obtienen municipios por código de departmento.
    */
   public function ObtenerMunicipiosPorDepartamento($codDepartamento)
   {           
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar_por_departamento","'$codDepartamento'");
       
       echo '<option value="">Seleccionar </option>';
       
       foreach($municipios as $municipio)
        echo '<option value="'.$municipio['codigo'].'">'.utf8_encode(utf8_decode($municipio['Nombre'])).'</option>';
   }
   
   /*
    * Validar rut existente
    */
   public function ValidarRut($rut)
   {           
       $existe = $this->procedimientos_model->GetProcedure("sindicato_validar_rut","'$rut'");       
       if($existe[0]['count'] > 0)
        echo utf8_encode('El RUT ya existe, escriba uno nuevo.');       
   }

   /*
    * Validar Registro Sindical existente
    */   
   
   public function ValidardivRegistroSindicalVal($registroSindical)
   {           
       $existe = $this->procedimientos_model->GetProcedure("sindicato_validar_registroSindical","'$registroSindical'");       
       if($existe[0]['count'] > 0)
        echo utf8_encode('El Número Personería Jurídica o Registro Sindical ya existe, escriba uno nuevo.');       
   }   
   
   private function AdicionarSecretariaSindicato($chk, $valor, $rut)
   {       
        if($chk == $valor)
        {
             $this->procedimientos_model->SetProcedure("sindicato_secretarias_sindicato_adicionar",
                     "'".$chk."',
                     '".$rut."'");
        }
   }
   
   private function AdicionarTipoViolencia($chk, $valor, $rut)
   {       
        if($chk == $valor)
        {
             $this->procedimientos_model->SetProcedure("sindicato_tipo_violencia_adicionar",
                     "'".$chk."',
                     '".$rut."'");
        }
   }   
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresSindicato($ordenamiento = 1, $pagina = 1, $rut = "")
   {       
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSindicatos = $this->procedimientos_model->GetProcedure("sindicato_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$rut."'");
       else
           $registrosConsultaSindicatos = $this->procedimientos_model->GetProcedure("sindicato_seleccionar_por_perfil","'".$this->session->userdata('registroSindical')."'");

       $claseDirectiva = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CLASEDIRECTIVA'");
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $periodoVigencia = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'PERIODVIGEJUNDIREC'");
       $estadoSindicato = $this->procedimientos_model->GetProcedure("tipo_estado_por_codigo","'ESTADOS'");
       $caracteristicasSindicatInac = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CARACTERSINDICATINAC'");       
       $claseSindicato = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CLASESINDICATO'");
       $sindicatoOri = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'SINDICORIGCAPITEMPRE'");
       $sindicatoOriCap = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EMPRESASEGUNCAPITAL'");
       $sindicatoTipoEmprEst = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'SINDICATOTIPOEMPREST'");
       $sindicatoEstModaContra = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'SINDICESTAMODACONTRA'");
       $clasificaEconoSindic = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CLASIFICAECONOSINDIC'");       
       $afiliaFederaRama = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'AFILIAFEDERARAMA'");
       $federacionAfiliacion = $this->procedimientos_model->GetProcedure("federacion_afiliacion_rut","");
       $centralSindicProv = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CENTRSINDICPROV'"); 
       $conteoTotal = $this->procedimientos_model->GetProcedure("sindicato_seleccionar_conteo_total","");
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'registroSindical' => $this->session->userdata('registroSindical'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaSindicato = array(  
                    'registros' => $registrosConsultaSindicatos,
                    'claseDirectiva' => $claseDirectiva,
                    'departamentos' => $departamentos,
                    'municipios' => $municipios,
                    'periodoVigencia' => $periodoVigencia,
                    'estadoSindicato' => $estadoSindicato,
                    'caracteristicasSindicatInac' => $caracteristicasSindicatInac,                    
                    'claseSindicato' => $claseSindicato,
                    'sindicatoOri' => $sindicatoOri,
                    'sindicatoOriCap' => $sindicatoOriCap,
                    'sindicatoTipoEmprEst' => $sindicatoTipoEmprEst,
                    'sindicatoEstModaContra' => $sindicatoEstModaContra,
                    'clasificaEconoSindic' => $clasificaEconoSindic,                    
                    'afiliaFederaRama' => $afiliaFederaRama,
                    'federacionAfiliacion' => $federacionAfiliacion,           
                    'centralSindicProv' => $centralSindicProv,                    
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaSindicato;
   }   
}