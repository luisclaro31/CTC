<?php 
/*
 * Controlador Federaciones con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 18/09/14
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorFederacion extends CI_Controller
{
       static function Tabla()
   {
        return "federacion";
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
    * Mï¿½todo inicial del controlador
    */
   public function index($ordenamiento = 1)
   {  
       if($this->session->userdata('esLogueado') == FALSE)        
            redirect('login');
              
        $rut = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;        
        $parametros = $this->ObtenerListaValoresFederacion($ordenamiento, $desde, $rut);        
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorFederacion/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();
        
       $this->load->view('vistaFederacion', $parametros);
   }
   
   public function AdicionarFederacion()
   {       
        if(isset($_POST['txtOtrosBienesInmueblesAdic']))
           $otrosBienesInmuebles = $_POST['txtOtrosBienesInmueblesAdic'];
        else
           $otrosBienesInmuebles = "";

        if(isset($_POST['txtOtraSecretariaAdic']))
           $otraSecretaria = $_POST['txtOtraSecretariaAdic'];
       else
           $otraSecretaria = "";       
       
        if(isset($_POST['sltCaracteristicasFederacionInactivoAdic']))
           $caracteristicasFederacionInactivo = $_POST['sltCaracteristicasFederacionInactivoAdic'];
       else
           $caracteristicasFederacionInactivo = "";              
       
        if(isset($_POST['txtNombreFederacionFusionaAdic']))
           $nombreFederacionFusiona = $_POST['txtNombreFederacionFusionaAdic'];
       else
           $nombreFederacionFusiona = "";                
       
        $rut = $_POST['txtRutAdic'];
        $registroSindical = $_POST['txtRegistroSindicalAdic'];        
        $datosAuditoria = $this->Auditoria($rut, "AD");
        $rpta = $this->procedimientos_model->SetProcedure("federacion_insertar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacionAdic']."',                    
                '".$registroSindical."',                        
                '".$_POST['sltSeccionalAfiliacionAdic']."',                    
                '".$caracteristicasFederacionInactivo."',                     
                '".$_POST['sltEstadoAdic']."',                                
                '".$_POST['sltMunicipioAdic']."',                
                '".$_POST['sltPeriodoVigJuntaDirectivaAdic']."',                
                '".$_POST['sltTipoFederacionAdic']."',
                '".$_POST['txtNumeroResolucionAdic']."',
                '".date('Y')."',
                '".$_POST['txtFechaAdic']."',
                '".$_POST['txtNombreFederacionAdic']."',
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
                '".$nombreFederacionFusiona."',                    
                '".$otrosBienesInmuebles."',
                '".$otraSecretaria."',                
                '".date('Y-m-d')."',                                    
                '".$_POST['txtObservacionesAdic']."'
                ", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresFederacion(1, 0, "");
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
                     $this->procedimientos_model->SetProcedure("federacion_medio_comunicacion_adicionar",
                             "'".$_POST['chkBoletinAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkPeriodicoAdic']))
           {
                if($_POST['chkPeriodicoAdic'] == 'PERIODICO')
                {
                     $this->procedimientos_model->SetProcedure("federacion_medio_comunicacion_adicionar",
                             "'".$_POST['chkPeriodicoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkProgramaRadioAdic']))
           {
                if($_POST['chkProgramaRadioAdic'] == 'PROGRAMARADIO')
                {
                     $this->procedimientos_model->SetProcedure("federacion_medio_comunicacion_adicionar",
                             "'".$_POST['chkProgramaRadioAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkTelevisionAdic']))
           {
                if($_POST['chkTelevisionAdic'] == 'TELEVISION')
                {
                     $this->procedimientos_model->SetProcedure("federacion_medio_comunicacion_adicionar",
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
                     $this->procedimientos_model->SetProcedure("federacion_bien_inmueble_adicionar",
                             "'".$_POST['chkCentroRecreativoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkOtrosBienesInmueblesAdic']))
           {
                if($_POST['chkOtrosBienesInmueblesAdic'] == 'OTROSBIENESINMUEBLES')
                {
                     $this->procedimientos_model->SetProcedure("federacion_bien_inmueble_adicionar",
                             "'".$_POST['chkOtrosBienesInmueblesAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkSedePropiaAdic']))
           {
                if($_POST['chkSedePropiaAdic'] == 'SEDEPROPIA')
                {
                     $this->procedimientos_model->SetProcedure("federacion_bien_inmueble_adicionar",
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
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkBwiAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkEiAdic']))
           {
                if($_POST['chkEiAdic'] == 'EI')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkEiAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkIaeaAdic']))
           {
                if($_POST['chkIaeaAdic'] == 'IAEA')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIaeaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkIfjAdic']))
           {
                if($_POST['chkIfjAdic'] == 'IFJ')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIfjAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkIndustryAllAdic']))
           {
                if($_POST['chkIndustryAllAdic'] == 'INDUSTRYALL')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIndustryAllAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkItfAdic']))
           {
                if($_POST['chkItfAdic'] == 'ITF')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkItfAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           if(isset($_POST['chkIufAdic']))
           {
                if($_POST['chkIufAdic'] == 'IUF')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkIufAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkPsiAdic']))
           {
                if($_POST['chkPsiAdic'] == 'PSI')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkPsiAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkUniAdic']))
           {
                if($_POST['chkUniAdic'] == 'UNI')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkUniAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      
           
           if(isset($_POST['chkNoAfiliadoAdic']))
           {
                if($_POST['chkNoAfiliadoAdic'] == 'NOAFILIADO')
                {
                     $this->procedimientos_model->SetProcedure("federacion_afiliacion_internacional_adicionar",
                             "'".$_POST['chkNoAfiliadoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                 
           
           // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="Secretarias">
        
            if(isset($_POST['chkAdministracionFinanzasAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAdministracionFinanzasAdic'], 'ADMINISTRAFINANZAS', $rut);           
            if(isset($_POST['chkAsuntosAgrariosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosAgrariosAdic'], 'ASUNTOSAGRARIOS', $rut);
            if(isset($_POST['chkAsuntosCooperativosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosCooperativosAdic'], 'ASUNTOSCOOPERATIVOS', $rut);
            if(isset($_POST['chkAsuntosNinezAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosNinezAdic'], 'ASUNTOSNINEZ', $rut);
            if(isset($_POST['chkAsuntosEnergeticosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosEnergeticosAdic'], 'ASUNTOSENERGETICOS', $rut);
            if(isset($_POST['chkAsuentosInternacionalesAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuentosInternacionalesAdic'], 'ASUNTOSINTERNACIONA', $rut);
            if(isset($_POST['chkAsuntosInterSindicalesAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosInterSindicalesAdic'], 'ASUNTOSINTERSINDICA', $rut);
            if(isset($_POST['chkAsuntosJuridicosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosJuridicosAdic'], 'ASUNTOSJURILABOR', $rut);
            if(isset($_POST['chkAsuntosPoliticosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkAsuntosPoliticosAdic'], 'ASUNTOSPOLILEGISLATI', $rut);           
            if(isset($_POST['chkComunicacionAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkComunicacionAdic'], 'COMUNICACION', $rut);           
            if(isset($_POST['chkConflictosLaboralesAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkConflictosLaboralesAdic'], 'CONFLICTOSLABORALES', $rut);           
            if(isset($_POST['chkDerechosHumanosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkDerechosHumanosAdic'], 'DERECHOSHUMASINDICA', $rut);
            if(isset($_POST['chkEcologiaMedioAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkEcologiaMedioAdic'], 'ECOLOGIAMEDIOAMBIEN', $rut);
            if(isset($_POST['chkEcologiaRecursosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkEcologiaRecursosAdic'], 'ECOLOGIARECURNATURAL', $rut);
            if(isset($_POST['chkEducacionAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkEducacionAdic'], 'EDUCACION', $rut);
            if(isset($_POST['chkEducacionInvestigacionAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkEducacionInvestigacionAdic'], 'EDUCACIONINVESTIGA', $rut);
            if(isset($_POST['chkJuventudAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkJuventudAdic'], 'JUVENTUD', $rut);
            if(isset($_POST['chkMedioAmbienteAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkMedioAmbienteAdic'], 'MEDIOAMBIENTE', $rut);
            if(isset($_POST['chkMujerAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkMujerAdic'], 'MUJER', $rut);
            if(isset($_POST['chkOrganizacionAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkOrganizacionAdic'], 'ORGANIZACION', $rut);           
            if(isset($_POST['chkOrganizacionSocialesAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkOrganizacionSocialesAdic'], 'ORGANIZACIONSOCIAL', $rut);
            if(isset($_POST['chkPlaneacionAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkPlaneacionAdic'], 'PLANEACION', $rut);
            if(isset($_POST['chkProyectosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkProyectosAdic'], 'PROYECTOS', $rut);            
            if(isset($_POST['chkRelacionesPublicasAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkRelacionesPublicasAdic'], 'RELACIONESPUBLICAS', $rut);                        
            if(isset($_POST['chkSecretariaActasAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkSecretariaActasAdic'], 'SECRETARIAACTAS', $rut);
            if(isset($_POST['chkSeguridadSocialAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkSeguridadSocialAdic'], 'SEGURIDADSOCIAL', $rut);
            if(isset($_POST['chkServidoresPublicosAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkServidoresPublicosAdic'], 'SERVIDORESPUBLICOS', $rut);            
            if(isset($_POST['chkTrabajoInformalAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkTrabajoInformalAdic'], 'TRABAJOINFORMAL', $rut);            
            if(isset($_POST['chkTransporteAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkTransporteAdic'], 'TRANSPORTE', $rut);
            if(isset($_POST['chkOtraSecretariaAdic']))
                $this->AdicionarSecretariaFederacion($_POST['chkOtraSecretariaAdic'], 'OTRASECRETARIA', $rut);                                    
            
           // </editor-fold>
           
           if($this->session->userdata('perfil') == 'Editor Federacion')
           {
                $this->procedimientos_model->SetProcedure("usuario_federacion_insertar", "'".$registroSindical."','".$this->session->userdata('idUsuario')."'");                
                $this->session->set_userdata('registroFederacion', $registroSindical);
                $parametros = $this->ObtenerListaValoresFederacion();
           }            
           
           $parametros['estadoAdicionar'] = true;
        }
       
        $this->load->view('vistaFederacion', $parametros);
    }
   
   public function ModificarFederacion()
   {   
       if(isset($_POST['txtOtrosBienesInmubles']))
           $otrosBienesInmuebles = $_POST['txtOtrosBienesInmubles'];
       else
           $otrosBienesInmuebles = "";
       
       if(isset($_POST['txtOtraSecretaria']))
           $otraSecretaria = $_POST['txtOtraSecretaria'];
       else
           $otraSecretaria = "";              

        if(isset($_POST['sltCaracteristicasFederacionInactivo']))
           $caracteristicasFederacionInactivo = $_POST['sltCaracteristicasFederacionInactivo'];
       else
           $caracteristicasFederacionInactivo = "";              
       
        if(isset($_POST['txtNombreFederacionFusiona']))
           $nombreFederacionFusiona = $_POST['txtNombreFederacionFusiona'];
       else
           $nombreFederacionFusiona = "";                       
       
       $rut = $_POST['txtRut'];
       $registroSindical = $_POST['txtRegistroSindical'];          
       $datosAuditoria = $this->Auditoria($rut, "MD");
       $rpta = $this->procedimientos_model->SetProcedure("federacion_modificar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacion']."',      
                '".$registroSindical."',                                        
                '".$_POST['sltSeccionalAfiliacion']."',                                        
                '".$caracteristicasFederacionInactivo."',                    
                '".$_POST['sltEstado']."',
                '".$_POST['sltCodMunicipio']."',
                '".$_POST['sltPeriodoVigJuntaDirectiva']."',                
                '".$_POST['sltTipoFederacion']."',
                '".$_POST['txtNumeroResolucion']."',                
                '".$_POST['txtFecha']."',
                '".$_POST['txtNombreFederacion']."',
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
                '".$nombreFederacionFusiona."',                    
                '".$otrosBienesInmuebles."',
                '".$otraSecretaria."',
                '".date('Y-m-d')."',                                                    
                '".$_POST['txtObservaciones']."'
            ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresFederacion(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaFederacion', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarFederacion($rut)
   {
       $datosAuditoria = $this->Auditoria($rut, "EL");
        $rpta = $this->procedimientos_model->SetProcedure("federacion_eliminar","'$rut'", $datosAuditoria);        
        
        $parametros = $this-> ObtenerListaValoresFederacion(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaFederacion', $parametros);  
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
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorFederacion/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }    
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarFederacion($rut, $consultar = "")
   {
        $registro = $this->procedimientos_model->GetProcedure("federacion_seleccionar_por_rut","'$rut'");
        $mediosComunicacion = $this->procedimientos_model->GetProcedure("federacion_medio_comunicacion_seleccionar_por_rut","'$rut'");
        $bienInmueble = $this->procedimientos_model->GetProcedure("federacion_bien_inmueble_seleccionar_por_rut","'$rut'");
        $afiliacionInternacional = $this->procedimientos_model->GetProcedure("federacion_afiliacion_internacional_seleccionar_por_rut","'$rut'");
        $secretariasFederacion = $this->procedimientos_model->GetProcedure("federacion_secretarias_federacion_seleccionar_por_rut","'$rut'");
        $parametros = $this->ObtenerListaValoresFederacion();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        $parametros['mediosComunicacion'] = $mediosComunicacion;
        $parametros['bienInmueble'] = $bienInmueble;
        $parametros['afiliacionInternacional'] = $afiliacionInternacional;
        $parametros['secretariasFederacion'] = $secretariasFederacion;
        
        $this->load->view('vistaFederacion', $parametros);
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
        $objSheet->setTitle('DatosFederacion');

        //Se obtiene la data del reporte
        
      if($this->session->userdata('perfil') == 'Administracion')
          $registrosConsultaFederacion = $this->procedimientos_model->GetProcedure("federacion_seleccionar","");
      else 
          $registrosConsultaFederacion = $this->procedimientos_model->GetProcedure("federacion_seleccionar_x_perfil","'".$this->session->userdata('registroFederacion')."'");        
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('RUT'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE'));
        $objSheet->getCell('C1')->setValue(utf8_encode('SIGLA'));
        $objSheet->getCell('D1')->setValue(utf8_encode('ESTADO'));
        $objSheet->getCell('E1')->setValue(utf8_encode('DEPARTAMENTO'));
        $objSheet->getCell('F1')->setValue(utf8_encode('MUNICIPIO'));
        $objSheet->getCell('G1')->setValue(utf8_encode('DIRECCIÓN'));
        $objSheet->getCell('H1')->setValue(utf8_encode('TELÉFONOS'));
        $objSheet->getCell('I1')->setValue(utf8_encode('AÑO CREACIÓN'));
        
        foreach($registrosConsultaFederacion as $registro)        
        {     
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['rut'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['sigla'])));    
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
        $objWriter->save('temp/Federacion.xlsx');               
        header('Location: /temp/Federacion.xlsx');
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
        $pdf->Cabecera('LISTADO DE FEDERACIONES', '', 125);        
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
            $registrosConsultaFederacion = $this->procedimientos_model->GetProcedure("Federacion_seleccionar","");
        else
            $registrosConsultaFederacion = $this->procedimientos_model->GetProcedure("federacion_seleccionar_x_perfil","'".$this->session->userdata('registroFederacion')."'");                
        
        if($registrosConsultaFederacion > 0)
        {

            foreach($registrosConsultaFederacion as $registro)
            {               
                $pdf->Row(array(utf8_decode($registro["rut"]), 
                                utf8_decode($registro["nombre"]), 
                                utf8_decode($registro["sigla"]), 
                                utf8_decode($registro["estado_codigo"]), 
                                utf8_decode($registro["departamento"]), 
                                utf8_decode($registro["municipio"]), 
                                utf8_decode($registro["direccion"]), 
                                utf8_decode($registro["telefonos"]),
                                utf8_decode($registro["anyo"])));
            }
        }                        
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer        
   }
   
   /*
    * Validar rut existente
    */
   public function ValidarRut($rut)
   {          
       $existe = $this->procedimientos_model->GetProcedure("federacion_validar_rut","'$rut'");       
       if($existe[0]['count'] > 0)
        echo 'El RUT ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Validar Registro Sindical existente
    */   
   
   public function ValidardivRegistroSindicalVal($registroSindical)
   {           
       $existe = $this->procedimientos_model->GetProcedure("federacion_validar_registroSindical","'$registroSindical'");       
       if($existe[0]['count'] > 0)
        echo utf8_encode('El Número Personería Jurídica o Registro Sindical ya existe, escriba uno nuevo.');       
   }      
   
   private function AdicionarSecretariaFederacion($chk, $valor, $rut)
   {       
        if($chk == $valor)
        {
             $this->procedimientos_model->SetProcedure("federacion_secretarias_adicionar",
                     "'".$chk."',
                     '".$rut."'");
        }
   }
   
   /*
    * Listas de valores b?sicas
    */
   private function ObtenerListaValoresFederacion($ordenamiento = 1, $pagina = 1, $rut = "")
   {
      if($this->session->userdata('perfil') == 'Administracion')
          $registrosConsultaFederacion = $this->procedimientos_model->GetProcedure("federacion_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$rut."'");
      else 
          $registrosConsultaFederacion = $this->procedimientos_model->GetProcedure("federacion_seleccionar_x_perfil","'".$this->session->userdata('registroFederacion')."'");      
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $seccionalAfiliacion = $this->procedimientos_model->GetProcedure("seccional_afiliacion_rut","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $tipoFederacion = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOFEDERACION'");
       $periodoVigencia = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'PERIODVIGEJUNDIREC'");
       $estadoFederacion = $this->procedimientos_model->GetProcedure("tipo_estado_por_codigo","'ESTADOS'");
       $caracteristicasFederacionInac = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CARACTERFEDERACINAC'");        
       $edadPorCategorias = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EDADPORCATEGORIAS'");
       $nivelEducativo = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'NIVELEDUCATIVO'");
       $cargos = $this->procedimientos_model->GetProcedure("cargo_seleccionar","");              
       $conteoTotal = $this->procedimientos_model->GetProcedure("federacion_seleccionar_conteo_total","");       
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaFederacion = array(
                    'registros' => $registrosConsultaFederacion,
                    'departamentos' => $departamentos,
                    'seccionalAfiliacion' => $seccionalAfiliacion,           
                    'municipios' => $municipios,
                    'tipoFederacion' => $tipoFederacion,
                    'periodoVigencia' => $periodoVigencia,
                    'estadoFederacion' => $estadoFederacion,
                    'caracteristicasFederacionInac' => $caracteristicasFederacionInac,                    
                    'edadPorCategorias' => $edadPorCategorias,
                    'nivelEducativo' => $nivelEducativo,
                    'cargos' => $cargos,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
       
                );
       
       return $datosVistaFederacion;
   }   
}