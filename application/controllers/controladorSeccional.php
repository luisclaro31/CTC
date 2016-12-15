<?php 
/*
 * Controlador Seccionales con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 18/09/14
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorSeccional extends CI_Controller
{
       static function Tabla()
   {
        return "seccional";
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
        $parametros = $this->ObtenerListaValoresSeccional($ordenamiento, $desde, $rut);        
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorSeccional/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();
        
       $this->load->view('vistaSeccional', $parametros);
   }
   
   public function AdicionarSeccional()
   {       
        if(isset($_POST['txtOtrosBienesInmueblesAdic']))
           $otrosBienesInmuebles = $_POST['txtOtrosBienesInmueblesAdic'];
        else
           $otrosBienesInmuebles = "";

        if(isset($_POST['txtOtraSecretariaAdic']))
           $otraSecretaria = $_POST['txtOtraSecretariaAdic'];
       else
           $otraSecretaria = "";       
       
        if(isset($_POST['sltCaracteristicasSeccionalInactivoAdic']))
           $caracteristicasSeccionalInactivo = $_POST['sltCaracteristicasSeccionalInactivoAdic'];
       else
           $caracteristicasSeccionalInactivo = "";              
       
        if(isset($_POST['txtNombreSeccionalFusionaAdic']))
           $nombreSeccionalFusiona = $_POST['txtNombreSeccionalFusionaAdic'];
       else
           $nombreSeccionalFusiona = "";         
       
        $rut = $_POST['txtRutAdic'];
        $registroSindical = $_POST['txtRegistroSindicalAdic'];                
        $datosAuditoria = $this->Auditoria($rut, "AD");
        $rpta = $this->procedimientos_model->SetProcedure("seccional_insertar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacionAdic']."',            
                '".$registroSindical."',                                            
                '".$caracteristicasSeccionalInactivo."',                                                                   
                '".$_POST['sltEstadoAdic']."',                                
                '".$_POST['sltMunicipioAdic']."',                
                '".$_POST['sltPeriodoVigJuntaDirectivaAdic']."',                
                '".$_POST['sltTipoSeccionalAdic']."',
                '".$_POST['txtNumeroResolucionAdic']."',
                '".date('Y')."',
                '".$_POST['txtFechaAdic']."',
                '".$_POST['txtNombreSeccionalAdic']."',
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
                '".$nombreSeccionalFusiona."',                    
                '".$otrosBienesInmuebles."',
                '".$otraSecretaria."',                
                '".date('Y-m-d')."',                                    
                '".$_POST['txtObservacionesAdic']."'
                ", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresSeccional(1, 0, "");
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
                     $this->procedimientos_model->SetProcedure("seccional_medio_comunicacion_adicionar",
                             "'".$_POST['chkBoletinAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkPeriodicoAdic']))
           {
                if($_POST['chkPeriodicoAdic'] == 'PERIODICO')
                {
                     $this->procedimientos_model->SetProcedure("seccional_medio_comunicacion_adicionar",
                             "'".$_POST['chkPeriodicoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkProgramaRadioAdic']))
           {
                if($_POST['chkProgramaRadioAdic'] == 'PROGRAMARADIO')
                {
                     $this->procedimientos_model->SetProcedure("seccional_medio_comunicacion_adicionar",
                             "'".$_POST['chkProgramaRadioAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           if(isset($_POST['chkTelevisionAdic']))
           {
                if($_POST['chkTelevisionAdic'] == 'TELEVISION')
                {
                     $this->procedimientos_model->SetProcedure("seccional_medio_comunicacion_adicionar",
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
                     $this->procedimientos_model->SetProcedure("seccional_bien_inmueble_adicionar",
                             "'".$_POST['chkCentroRecreativoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkOtrosBienesInmueblesAdic']))
           {
                if($_POST['chkOtrosBienesInmueblesAdic'] == 'OTROSBIENESINMUEBLES')
                {
                     $this->procedimientos_model->SetProcedure("seccional_bien_inmueble_adicionar",
                             "'".$_POST['chkOtrosBienesInmueblesAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkSedePropiaAdic']))
           {
                if($_POST['chkSedePropiaAdic'] == 'SEDEPROPIA')
                {
                     $this->procedimientos_model->SetProcedure("seccional_bien_inmueble_adicionar",
                             "'".$_POST['chkSedePropiaAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                      

           // </editor-fold>            
            // <editor-fold defaultstate="collapsed" desc="Secretarias">
        
            if(isset($_POST['chkAdministracionFinanzasAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAdministracionFinanzasAdic'], 'ADMINISTRAFINANZAS', $rut);           
            if(isset($_POST['chkAsuntosAgrariosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosAgrariosAdic'], 'ASUNTOSAGRARIOS', $rut);
            if(isset($_POST['chkAsuntosCooperativosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosCooperativosAdic'], 'ASUNTOSCOOPERATIVOS', $rut);
            if(isset($_POST['chkAsuntosNinezAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosNinezAdic'], 'ASUNTOSNINEZ', $rut);
            if(isset($_POST['chkAsuntosEnergeticosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosEnergeticosAdic'], 'ASUNTOSENERGETICOS', $rut);
            if(isset($_POST['chkAsuentosInternacionalesAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuentosInternacionalesAdic'], 'ASUNTOSINTERNACIONA', $rut);
            if(isset($_POST['chkAsuntosInterSindicalesAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosInterSindicalesAdic'], 'ASUNTOSINTERSINDICA', $rut);
            if(isset($_POST['chkAsuntosJuridicosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosJuridicosAdic'], 'ASUNTOSJURILABOR', $rut);
            if(isset($_POST['chkAsuntosPoliticosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkAsuntosPoliticosAdic'], 'ASUNTOSPOLILEGISLATI', $rut);           
            if(isset($_POST['chkComunicacionAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkComunicacionAdic'], 'COMUNICACION', $rut);           
            if(isset($_POST['chkConflictosLaboralesAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkConflictosLaboralesAdic'], 'CONFLICTOSLABORALES', $rut);           
            if(isset($_POST['chkDerechosHumanosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkDerechosHumanosAdic'], 'DERECHOSHUMASINDICA', $rut);
            if(isset($_POST['chkEcologiaMedioAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkEcologiaMedioAdic'], 'ECOLOGIAMEDIOAMBIEN', $rut);
            if(isset($_POST['chkEcologiaRecursosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkEcologiaRecursosAdic'], 'ECOLOGIARECURNATURAL', $rut);
            if(isset($_POST['chkEducacionAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkEducacionAdic'], 'EDUCACION', $rut);
            if(isset($_POST['chkEducacionInvestigacionAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkEducacionInvestigacionAdic'], 'EDUCACIONINVESTIGA', $rut);
            if(isset($_POST['chkJuventudAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkJuventudAdic'], 'JUVENTUD', $rut);
            if(isset($_POST['chkMedioAmbienteAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkMedioAmbienteAdic'], 'MEDIOAMBIENTE', $rut);
            if(isset($_POST['chkMujerAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkMujerAdic'], 'MUJER', $rut);
            if(isset($_POST['chkOrganizacionAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkOrganizacionAdic'], 'ORGANIZACION', $rut);           
            if(isset($_POST['chkOrganizacionSocialesAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkOrganizacionSocialesAdic'], 'ORGANIZACIONSOCIAL', $rut);
            if(isset($_POST['chkPlaneacionAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkPlaneacionAdic'], 'PLANEACION', $rut);
            if(isset($_POST['chkProyectosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkProyectosAdic'], 'PROYECTOS', $rut);            
            if(isset($_POST['chkRelacionesPublicasAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkRelacionesPublicasAdic'], 'RELACIONESPUBLICAS', $rut);                        
            if(isset($_POST['chkSecretariaActasAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkSecretariaActasAdic'], 'SECRETARIAACTAS', $rut);
            if(isset($_POST['chkSeguridadSocialAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkSeguridadSocialAdic'], 'SEGURIDADSOCIAL', $rut);
            if(isset($_POST['chkServidoresPublicosAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkServidoresPublicosAdic'], 'SERVIDORESPUBLICOS', $rut);            
            if(isset($_POST['chkTrabajoInformalAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkTrabajoInformalAdic'], 'TRABAJOINFORMAL', $rut);            
            if(isset($_POST['chkTransporteAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkTransporteAdic'], 'TRANSPORTE', $rut);
            if(isset($_POST['chkOtraSecretariaAdic']))
                $this->AdicionarSecretariaSeccional($_POST['chkOtraSecretariaAdic'], 'OTRASECRETARIA', $rut);                                    
            
           // </editor-fold>

           if($this->session->userdata('perfil') == 'Editor Seccional')
           {
                $this->procedimientos_model->SetProcedure("usuario_seccional_insertar", "'".$registroSindical."','".$this->session->userdata('idUsuario')."'");                
                $this->session->set_userdata('registroSeccional', $registroSindical);
                $parametros = $this->ObtenerListaValoresSeccional();
           }                        
           
           $parametros['estadoAdicionar'] = true;
        }
       
        $this->load->view('vistaSeccional', $parametros);
    }
   
   public function ModificarSeccional()
   {   
       if(isset($_POST['txtOtrosBienesInmubles']))
           $otrosBienesInmuebles = $_POST['txtOtrosBienesInmubles'];
       else
           $otrosBienesInmuebles = "";
       
       if(isset($_POST['txtOtraSecretaria']))
           $otraSecretaria = $_POST['txtOtraSecretaria'];
       else
           $otraSecretaria = "";              

        if(isset($_POST['sltCaracteristicasSeccionalInactivo']))
           $caracteristicasSeccionalInactivo = $_POST['sltCaracteristicasSeccionalInactivo'];
       else
           $caracteristicasSeccionalInactivo = "";              
       
        if(isset($_POST['txtNombreSeccionalFusiona']))
           $nombreSeccionalFusiona = $_POST['txtNombreSeccionalFusiona'];
       else
           $nombreSeccionalFusiona = "";        
       
       $rut = $_POST['txtRut'];
       $registroSindical = $_POST['txtRegistroSindical'];                 
       $datosAuditoria = $this->Auditoria($rut, "MD");
       $rpta = $this->procedimientos_model->SetProcedure("seccional_modificar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacion']."',     
                '".$registroSindical."',                                                            
                '".$caracteristicasSeccionalInactivo."',                    
                '".$_POST['sltEstado']."',
                '".$_POST['sltCodMunicipio']."',
                '".$_POST['sltPeriodoVigJuntaDirectiva']."',                
                '".$_POST['sltTipoSeccional']."',
                '".$_POST['txtNumeroResolucion']."',                
                '".$_POST['txtFecha']."',
                '".$_POST['txtNombreSeccional']."',
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
                '".$nombreSeccionalFusiona."',                    
                '".$otrosBienesInmuebles."',
                '".$otraSecretaria."',
                '".date('Y-m-d')."',                                                    
                '".$_POST['txtObservaciones']."'
            ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresSeccional(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaSeccional', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarSeccional($rut)
   {
       $datosAuditoria = $this->Auditoria($rut, "EL");
        $rpta = $this->procedimientos_model->SetProcedure("seccional_eliminar","'$rut'", $datosAuditoria);        
        
        $parametros = $this-> ObtenerListaValoresSeccional(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaSeccional', $parametros);  
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
        $opciones['base_url'] = '/index.php/controladorSeccional/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }    
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarSeccional($rut, $consultar = "")
   {
        $registro = $this->procedimientos_model->GetProcedure("seccional_seleccionar_por_rut","'$rut'");
        $mediosComunicacion = $this->procedimientos_model->GetProcedure("seccional_medio_comunicacion_seleccionar_por_rut","'$rut'");
        $bienInmueble = $this->procedimientos_model->GetProcedure("seccional_bien_inmueble_seleccionar_por_rut","'$rut'");        
        $secretariasSeccional = $this->procedimientos_model->GetProcedure("seccional_secretarias_seccional_seleccionar_por_rut","'$rut'");
        $parametros = $this->ObtenerListaValoresSeccional();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        $parametros['mediosComunicacion'] = $mediosComunicacion;
        $parametros['bienInmueble'] = $bienInmueble;        
        $parametros['secretariasSeccional'] = $secretariasSeccional;
        
        $this->load->view('vistaSeccional', $parametros);
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
        $objSheet->setTitle('DatosSeccional');

        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
            $registrosConsultaSeccional = $this->procedimientos_model->GetProcedure("seccional_seleccionar","");
        else 
            $registrosConsultaSeccional = $this->procedimientos_model->GetProcedure("seccional_seleccionar_x_perfil","'".$this->session->userdata('registroSeccional')."'");
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
        
        foreach($registrosConsultaSeccional as $registro)        
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
        $objWriter->save('temp/Seccional.xlsx');               
        header('Location: /temp/Seccional.xlsx');
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
        $pdf->Cabecera('LISTADO DE SECCIONALES', '', 125);        
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
            $registrosConsultaSeccional = $this->procedimientos_model->GetProcedure("seccional_seleccionar","");
        else 
            $registrosConsultaSeccional = $this->procedimientos_model->GetProcedure("seccional_seleccionar_x_perfil","'".$this->session->userdata('registroSeccional')."'");
                
        foreach($registrosConsultaSeccional as $registro)
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
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer        
   }
   
   /*
    * Validar rut existente
    */
   public function ValidarRut($rut)
   {          
       $existe = $this->procedimientos_model->GetProcedure("seccional_validar_rut","'$rut'");       
       if($existe[0]['count'] > 0)
        echo 'El RUT ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Validar Registro Sindical existente
    */   
   
   public function ValidardivRegistroSindicalVal($registroSindical)
   {           
       $existe = $this->procedimientos_model->GetProcedure("seccional_validar_registroSindical","'$registroSindical'");       
       if($existe[0]['count'] > 0)
        echo utf8_encode('El Número Personería Jurídica o Registro Sindical ya existe, escriba uno nuevo.');       
   }         
   
   private function AdicionarSecretariaSeccional($chk, $valor, $rut)
   {       
        if($chk == $valor)
        {
             $this->procedimientos_model->SetProcedure("seccional_secretarias_adicionar",
                     "'".$chk."',
                     '".$rut."'");
        }
   }
   
   /*
    * Listas de valores b?sicas
    */
   private function ObtenerListaValoresSeccional($ordenamiento = 1, $pagina = 1, $rut = "")
   {   
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSeccional = $this->procedimientos_model->GetProcedure("seccional_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$rut."'");
       else 
           $registrosConsultaSeccional = $this->procedimientos_model->GetProcedure("seccional_seleccionar_x_perfil","'".$this->session->userdata('registroSeccional')."'");             
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $tipoSeccional = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOFEDERACION'");
       $periodoVigencia = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'PERIODVIGEJUNDIREC'");
       $estadoSeccional = $this->procedimientos_model->GetProcedure("tipo_estado_por_codigo","'ESTADOS'");
       $caracteristicasSeccionalInac = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CARACTERSECCIONANAC'");        
       $edadPorCategorias = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EDADPORCATEGORIAS'");
       $nivelEducativo = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'NIVELEDUCATIVO'");
       $cargos = $this->procedimientos_model->GetProcedure("cargo_seleccionar","");              
       if($this->session->userdata('perfil') == 'Administracion')
           $conteoTotal = $this->procedimientos_model->GetProcedure("seccional_seleccionar_conteo_total","");       
       else 
           $conteoTotal = $this->procedimientos_model->GetProcedure("seccional_seleccionar_conteo_total_x_perfil","'".$this->session->userdata('registroSeccional')."'");
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaSeccional = array(
                    'registros' => $registrosConsultaSeccional,
                    'departamentos' => $departamentos,
                    'municipios' => $municipios,
                    'tipoSeccional' => $tipoSeccional,
                    'periodoVigencia' => $periodoVigencia,
                    'estadoSeccional' => $estadoSeccional,
                    'caracteristicasSeccionalInac' => $caracteristicasSeccionalInac,                    
                    'edadPorCategorias' => $edadPorCategorias,
                    'nivelEducativo' => $nivelEducativo,
                    'cargos' => $cargos,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
       
                );
       
       return $datosVistaSeccional;
   }   
}