<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 19/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorAfiliado extends CI_Controller
{
           static function Tabla()
   {
        return "afiliado";
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
       
        $cedula = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;        
        $parametros = $this->ObtenerListaValoresAfiliado($ordenamiento, $desde, $cedula);                
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorAfiliado/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();       
       
       $this->load->view('vistaAfiliado', $parametros);
   }
   
   public function AdicionarAfiliado()
   {    
        if(isset($_POST['txtQueEstudiaAdic']))
           $queEstudia = $_POST['txtQueEstudiaAdic'];
        else
            $queEstudia = "";

        if(isset($_POST['sltCargoJuntaDirectivaAdic']))
           $cargoJuntaDirectiva = $_POST['sltCargoJuntaDirectivaAdic'];
        else
            $cargoJuntaDirectiva = "";
        
        if(isset($_POST['txtEntidadCreditoAdic']))
           $entidadCredito = $_POST['txtEntidadCreditoAdic'];
        else
            $entidadCredito = "";
        
        if(isset($_POST['txtOtroSindicatoAfiliacionAdic']))
           $otroSindicatoAfiliacion = $_POST['txtOtroSindicatoAfiliacionAdic'];
        else
            $otroSindicatoAfiliacion = "";
        
        if(isset($_POST['txtTituloProfesiAdic']))
           $tituloProfesi = $_POST['txtTituloProfesiAdic'];
        else
            $tituloProfesi = "";        
        
        $cedula = $_POST['txtCedulaAdic'];
        $datosAuditoria = $this->Auditoria($cedula, "AD");              
        $rpta = $this->procedimientos_model->SetProcedure("afiliado_insertar",
                "'".$cedula."',                                                    
                '".$cargoJuntaDirectiva."',
                '".$_POST['sltContratacionEmpleoPublicoAdic']."',
                '".$_POST['sltOrganizacionSocialAdic']."',                
                '".$_POST['sltEmpresaDondeLaboraAdic']."',                    
                '".$_POST['sltMunicipioResiAdic']."',
                '".$_POST['sltMunicipioAdic']."',
                '".$_POST['sltMunicipioLaboraAdic']."',                
                '".$_POST['sltTipoAfiliadoAdic']."',                    
                '".$_POST['sltTipoViviendaAdic']."',                    
                '".$_POST['sltNivelEducativoAdic']."',                    
                '".$_POST['sltMiembroJuntaDirectivaAdic']."',                    
                '".$_POST['sltCondicionAfiliacionAdic']."',                        
                '".$_POST['sltSalarioRangosAdic']."',                    
                '".$_POST['sltServidorPublicoAdic']."',                                        
                '".$_POST['sltDuracionContratoLaboralAdic']."',                    
                '".$_POST['sltModalidadContratoAdic']."',
                '".$_POST['sltCargoSectorPublicoAdic']."',                
                '".$_POST['sltCargoEmpresaPrivadaAdic']."',                    
                '".$_POST['sltEstadoCivilAdic']."',
                '".$_POST['sltGeneroAdic']."',
                '".$_POST['txtNombreAfliliadoAdic']."',                
                '".$_POST['txtFechaAdic']."',                    
                '".$_POST['txtDireccionAdic']."',                    
                '".$_POST['txtTelefonoAdic']."',                    
                '".$_POST['txtCelularAdic']."',                    
                '".$_POST['txtCorreoAdic']."',                        
                '".$_POST['txtFacebookAdic']."',                    
                '".$_POST['txtTwiterAdic']."',                                                            
                '".$_POST['txtComunaAdic']."',
                '".$_POST['txtFechaIngresoEmpresaAdic']."',                
                '".$_POST['txtSedeLaboraAdic']."',                    
                '".$_POST['txtSalarioBasicoAdic']."',
                '".$_POST['sltEpsAdic']."',
                '".$_POST['sltFondoPensionesAdic']."',                
                '".$_POST['sltFondoCesantiasAdic']."',                    
                '".$_POST['sltArlAdic']."',                    
                '".$_POST['sltCajaCompensacionAdic']."',                    
                '".$_POST['txtFechaIngresoSindiAdic']."',                    
                '".$_POST['txtFechaIngresoEmpresaAdic']."',                        
                '".$_POST['txtMotivoRetiroSindicatoAdic']."',                    
                '".$_POST['txtOtraOrganizacionSocialAdic']."',
                '".$otroSindicatoAfiliacion."',                                    
                '".$_POST['txtPorcentajeCuotaSindicalAdic']."',                        
                '".$tituloProfesi."',                        
                '".$queEstudia."',    
                '".$_POST['txtNumeroHijosAdic']."',
                '".$_POST['txtNumeroPreescolarAdic']."',                
                '".$_POST['txtNumeroPrimariaAdic']."',                    
                '".$_POST['txtNumeroSecundariaAdic']."',
                '".$_POST['txtNumerotecnicaAdic']."',                    
                '".$_POST['txtNumeroTecnologiaAdic']."',
                '".$_POST['txtNumeroUniversidadAdic']."',                                
                '".$entidadCredito."',    
                '".$_POST['txtNumeropersonasCargoAdic']."',                    
                '".$_POST['txtNumeroHorasTrabajoAdic']."',                    
                b'".$_POST['rdbPracticaDeportesAdic']."',                    
                b'".$_POST['rdbDelegadoAsambleaAdic']."',                        
                b'".$_POST['rdbCopasoAdic']."',                    
                b'".$_POST['rdbComiteConvivenciaAdic']."',                    
                b'".$_POST['rdbEstudiaActualmenteAdic']."',                    
                b'".$_POST['rdbCapacitacionSindicalAdic']."',                    
                b'".$_POST['rdbPerteneceOtroSindicatoAdic']."',                    
                b'".$_POST['rdbCreditoViviendaAdic']."',                                        
                '".date('Y')."'
                ", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresAfiliado(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);        
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaAfiliado', $parametros);
        
    }
   
   public function ModificarAfiliado()
   {   
        if(isset($_POST['txtQueEstudia']))
           $queEstudia = $_POST['txtQueEstudia'];
        else
            $queEstudia = "";

        if(isset($_POST['sltCargoJuntaDirectiva']))
           $cargoJuntaDirectiva = $_POST['sltCargoJuntaDirectiva'];
        else
            $cargoJuntaDirectiva = "";
        
        if(isset($_POST['txtEntidadCredito']))
           $entidadCredito = $_POST['txtEntidadCredito'];
        else
            $entidadCredito = "";
        
        if(isset($_POST['txtOtroSindicatoAfiliacion']))
           $otroSindicatoAfiliacion = $_POST['txtOtroSindicatoAfiliacion'];
        else
            $otroSindicatoAfiliacion = "";
        
        if(isset($_POST['txtTituloProfesi']))
           $tituloProfesi = $_POST['txtTituloProfesi'];
        else
            $tituloProfesi = "";          
        
       $cedula = $_POST['txtCedula'];
       $datosAuditoria = $this->Auditoria($cedula, "MD");                          
       $rpta = $this->procedimientos_model->SetProcedure("afiliado_modificar",
                "'".$cedula."',
                '".$cargoJuntaDirectiva."',                                        
                '".$_POST['sltContratacionEmpleoPublico']."',
                '".$_POST['sltOrganizacionSocial']."',                
                '".$_POST['sltEmpresaDondeLabora']."',                    
                '".$_POST['sltMunicipioResi']."',
                '".$_POST['sltMunicipio']."',
                '".$_POST['sltMunicipioLabora']."',                
                '".$_POST['sltTipoAfiliado']."',                    
                '".$_POST['sltTipoVivienda']."',                    
                '".$_POST['sltNivelEducativo']."',                    
                '".$_POST['sltMiembroJuntaDirectiva']."',                    
                '".$_POST['sltCondicionAfiliacion']."',                        
                '".$_POST['sltSalarioRangos']."',                    
                '".$_POST['sltServidorPublico']."',                                        
                '".$_POST['sltDuracionContratoLaboral']."',                    
                '".$_POST['sltModalidadContrato']."',
                '".$_POST['sltCargoSectorPublico']."',                
                '".$_POST['sltCargoEmpresaPrivada']."',                    
                '".$_POST['sltEstadoCivil']."',
                '".$_POST['sltGenero']."',
                '".$_POST['txtNombreAfliliado']."',                
                '".$_POST['txtFecha']."',                    
                '".$_POST['txtDireccion']."',                    
                '".$_POST['txtTelefono']."',                    
                '".$_POST['txtCelular']."',                    
                '".$_POST['txtCorreo']."',                        
                '".$_POST['txtFacebook']."',                    
                '".$_POST['txtTwiter']."',                                                            
                '".$_POST['txtComuna']."',
                '".$_POST['txtFechaIngresoEmpresa']."',                
                '".$_POST['txtSedeLabora']."',                    
                '".$_POST['txtSalarioBasico']."',
                '".$_POST['sltEps']."',
                '".$_POST['sltFondoPensiones']."',                
                '".$_POST['sltFondoCesantias']."',                    
                '".$_POST['sltArl']."',                    
                '".$_POST['sltCajaCompensacion']."',                    
                '".$_POST['txtFechaIngresoSindi']."',                    
                '".$_POST['txtFechaIngresoEmpresa']."',                        
                '".$_POST['txtMotivoRetiroSindicato']."',                    
                '".$_POST['txtOtraOrganizacionSocial']."',
                '".$otroSindicatoAfiliacion."',                                    
                '".$_POST['txtPorcentajeCuotaSindical']."',                        
                '".$tituloProfesi."',                                                                 
                '".$queEstudia."',                                             
                '".$_POST['txtNumeroHijos']."',
                '".$_POST['txtNumeroPreescolar']."',                
                '".$_POST['txtNumeroPrimaria']."',                    
                '".$_POST['txtNumeroSecundaria']."',
                '".$_POST['txtNumerotecnica']."',                    
                '".$_POST['txtNumeroTecnologia']."',
                '".$_POST['txtNumeroUniversidad']."',                
                '".$entidadCredito."',                     
                '".$_POST['txtNumeropersonasCargo']."',                    
                '".$_POST['txtNumeroHorasTrabajo']."',                    
                b'".$_POST['rdbPracticaDeportes']."',                    
                b'".$_POST['rdbDelegadoAsamblea']."',                        
                b'".$_POST['rdbCopaso']."',                    
                b'".$_POST['rdbComiteConvivencia']."',                    
                b'".$_POST['rdbEstudiaActualmente']."',                    
                b'".$_POST['rdbCapacitacionSindical']."',                    
                b'".$_POST['rdbPerteneceOtroSindicato']."',                    
                b'".$_POST['rdbCreditoVivienda']."'                                      
                ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresAfiliado(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                             
       
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaAfiliado', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarAfiliado($cedula)
   {
        $datosAuditoria = $this->Auditoria($cedula, "EL");       
        $rpta = $this->procedimientos_model->SetProcedure("afiliado_eliminar","'$cedula'", $datosAuditoria);        
        
        $parametros = $this->ObtenerListaValoresAfiliado(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                                
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaAfiliado', $parametros);  
    }
    
    
    public function Auditoria($cedula, $tipoCreacionCambio)
    {
        $datosAuditoria['idRegistro'] = $cedula;
        $datosAuditoria['idUsuario'] = $this->session->userdata('idUsuario');
        $datosAuditoria['tabla'] = $this->Tabla();
        $datosAuditoria['fecha'] = date('Y-m-d H:i:s');
        $datosAuditoria['tipo_creacion_cambio'] = $tipoCreacionCambio;
        $datosAuditoria['ip_usuario'] = $this->procedimientos_model->ObtenerIP();
        
        return $datosAuditoria;
    }    

    public function Paginacion($parametros)
    {
        $this->ObtenerListaValoresAfiliado();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorAfiliado/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }    
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarAfiliado($cedula, $consultar = "")
   {  
        $registro = $this->procedimientos_model->GetProcedure("afiliado_seleccionar_por_cedula","'$cedula'");
        $parametros = $this->ObtenerListaValoresAfiliado();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaAfiliado', $parametros);
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
        $objSheet->setTitle('DatosAfiliado');

        //Se obtiene la data del reporte    
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaAfiliado = $this->procedimientos_model->GetProcedure("afiliado_seleccionar","");
        else
           $registrosConsultaAfiliado = $this->procedimientos_model->GetProcedure("afiliado_seleccionar_por_empresa","'".$this->session->userdata('rutEmpresa')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('CEDULA'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE'));
        $objSheet->getCell('C1')->setValue(utf8_encode('NOMBRE DE EMPRESA'));
        $objSheet->getCell('D1')->setValue(utf8_encode('DEPARTAMENTO'));
        $objSheet->getCell('E1')->setValue(utf8_encode('MUNICIPIO'));
        $objSheet->getCell('F1')->setValue(utf8_encode('DIRECCIÓN'));
        $objSheet->getCell('G1')->setValue(utf8_encode('TELÉFONOS'));
        $objSheet->getCell('H1')->setValue(utf8_encode('AÑO CREACIÓN'));
            
        foreach($registrosConsultaAfiliado as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['cedula'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombres_apellidos'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['empresa'])));                
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['departamento'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['municipio'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['direccion'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['telefonos'])));
            $objSheet->getCell('H'.$i)->setValue(utf8_encode(utf8_decode($registro['anyo'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:H1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);
        $objSheet->getColumnDimension('F')->setAutoSize(true);
        $objSheet->getColumnDimension('G')->setAutoSize(true);
        $objSheet->getColumnDimension('H')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:H'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:H'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Afiliado.xlsx');               
        header('Location: /temp/Afiliado.xlsx');
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
        $pdf->Cabecera('LISTADO DE AFILIADOS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(22, 35, 31, 33, 30, 24, 38, 31, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('CEDULA', 'NOMBRE', 'NOMBRE EMPRESA','DEPARTAMENTO', 'MUNICIPIO', 'DIRECCION', 'TELEFONO', 'AÑO DE CREACION');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaAfiliado = $this->procedimientos_model->GetProcedure("afiliado_seleccionar","");
       else
           $registrosConsultaAfiliado = $this->procedimientos_model->GetProcedure("afiliado_seleccionar_por_empresa","'".$this->session->userdata('rutEmpresa')."'");
               
        foreach($registrosConsultaAfiliado as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["cedula"]), 
                            utf8_decode($registro["nombres_apellidos"]), 
                            utf8_decode($registro["empresa"]),                             
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
   public function ValidarCedula($cedula)
   {       
       $existe = $this->procedimientos_model->GetProcedure("afiliado_validar_cedula","'$cedula'");          
       
       if($existe[0]['count'] > 0)
        echo 'La Cedula ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresAfiliado($ordenamiento = 1, $pagina = 1, $cedula = "")
   {       
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaAfiliado = $this->procedimientos_model->GetProcedure("afiliado_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$cedula."'");
       else
           $registrosConsultaAfiliado = $this->procedimientos_model->GetProcedure("afiliado_seleccionar_por_empresa","'".$this->session->userdata('registroSindical')."'");
       
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $genero = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'GENERO'");
       $estadoCivil = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'ESTADOCIVIL'");
       $nivelEducativo = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'NIVELEDUCATIVO'");
       $tipoVivienda = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOVIVIENDA'");
       $tipoAfiliado = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOAFILIADO'");
       $eps = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EPS'");       
       $fondoPensiones = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'AFP'");       
       $fondoCesantias = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'AFP'");       
       $arl = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'ARL'");       
       $cajaCompensacion = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CCF'");       
       
       if($this->session->userdata('perfil') == 'Administracion')
           $empresaDondeLabora = $this->procedimientos_model->GetProcedure("afiliado_empresa_seleccionar","");
       else
           $empresaDondeLabora = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$this->session->userdata('registroSindical')."'");
              
       $cargoEmpresaPrivada = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CARGOEMPRESAPRIVADA'");
       $cargoSectorPublico = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CARGOSECTORPUBLICO'");
       $modalidadContrato = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'MODALIDADCONTRATO'");
       $duracionContratoLaboral = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'DURACICONTRALABORAL'");
       $servidorPublico = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOSERVIDORPUBLICO'");
       $contratacionEmpleoPublico = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'MODALIEMPLEOPUBLICO'");
       $salarioRangos = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'SALARIOBASICORANGOS'");
       $condicionAfiliacion = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CONDICIONAFILIACION'");
       $miembroJuntaDirectiva = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'MIEMBROJUNDIRECTIVA'");
       $cargoJuntaDirectiva = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CARGOJUNTADIRECTIVA'");
       $organizacionSocial = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'OTRAORGANIZASOCIAL'");
       $conteoTotal = $this->procedimientos_model->GetProcedure("Afiliado_seleccionar_conteo_total","");              
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaAfiliado = array(  
                    'registros' => $registrosConsultaAfiliado,
                    'departamentos' => $departamentos,
                    'municipios' => $municipios,
                    'genero' => $genero,
                    'estadoCivil' => $estadoCivil,
                    'nivelEducativo' => $nivelEducativo,
                    'tipoVivienda' => $tipoVivienda,
                    'tipoAfiliado' => $tipoAfiliado,
                    'empresaDondeLabora' => $empresaDondeLabora,
                    'cargoEmpresaPrivada' => $cargoEmpresaPrivada,
                    'cargoSectorPublico' => $cargoSectorPublico,
                    'modalidadContrato' => $modalidadContrato,
                    'duracionContratoLaboral' => $duracionContratoLaboral,
                    'servidorPublico' => $servidorPublico,
                    'contratacionEmpleoPublico' => $contratacionEmpleoPublico,
                    'salarioRangos' => $salarioRangos,
                    'condicionAfiliacion' => $condicionAfiliacion,
                    'miembroJuntaDirectiva' => $miembroJuntaDirectiva,
                    'cargoJuntaDirectiva' => $cargoJuntaDirectiva,
                    'organizacionSocial' => $organizacionSocial,
                    'eps' => $eps,
                    'fondoPensiones' => $fondoPensiones,
                    'fondoCesantias' => $fondoCesantias,
                    'arl' => $arl,
                    'cajaCompensacion' => $cajaCompensacion,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaAfiliado;
   }
}