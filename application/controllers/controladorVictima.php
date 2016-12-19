<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 19/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorVictima extends CI_Controller
{
           static function Tabla()
   {
        return "victima";
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
        $parametros = $this->ObtenerListaValoresVictima($ordenamiento, $desde, $cedula);                
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorVictima/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();       
       
       $this->load->view('vistaVictima', $parametros);
   }
   
   public function AdicionarVictima()
   {    
        if(isset($_POST['sltFederacionRamaAdic']))
           $federacionRama = $_POST['sltFederacionRamaAdic'];
        else
            $federacionRama = "";
        
        if(isset($_POST['sltDivisionEconomicaAdic']))
           $divisionEconomica = $_POST['sltDivisionEconomicaAdic'];
        else
            $divisionEconomica = "";        
        
        if(isset($_POST['txtOtroTipoViolacionAdic']))
           $otroTipoViolacion = $_POST['txtOtroTipoViolacionAdic'];
        else
            $otroTipoViolacion = "";         
        
        if(isset($_POST['txtResponsablesAdic']))
           $responsables = $_POST['txtResponsablesAdic'];
        else
            $responsables = "";                
       
        $cedula = $_POST['txtCedulaVictimaAdic'];
        $datosAuditoria = $this->Auditoria($cedula, "AD");              
        $rpta = $this->procedimientos_model->SetProcedure("victima_insertar",
                "
                '".$_POST['sltMunicipioHechosAdic']."',                    
                '".$divisionEconomica."',                       
                '".$_POST['sltSiglasSindicatoAdic']."',                
                '".$federacionRama."',                                       
                '".$_POST['sltEmpresaAdic']."',
                '".$_POST['sltTipoViolacionAdic']."',
                '".$_POST['sltGeneroAdic']."',                
                '".$_POST['sltMunicipioAdic']."',                    
                '".$cedula."',                    
                '".$_POST['txtNombreVictimaAdic']."',                    
                '".$_POST['txtLugarAdic']."',                    
                '".$_POST['txtCausasAdic']."',                        
                '".date('Y')."',                    
                '".$_POST['txtFechaAdic']."',                                        
                '".$_POST['txtFuenteAdic']."',                    
                '".$_POST['txtResumenHechosAdic']."',
                '".$responsables."',                
                '".$_POST['txtClaseTrabajadorAdic']."',                    
                '".$_POST['txtSubTipoTrabajadorAdic']."',
                '".$_POST['txtFederacionRegionAdic']."',
                '".$_POST['txtActividadSindicatoAdic']."',                
                '".$_POST['txtConfederacionAdic']."',                    
                '".$_POST['txtOrganizacionPoliticaAdic']."',                    
                '".$otroTipoViolacion."',                        
                '".$_POST['txtTipoEmpresaAdic']."'
                ", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresVictima(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);        
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaVictima', $parametros);
        
    }
   
   public function ModificarVictima()
   {   
       
        if(isset($_POST['sltFederacionRama']))
           $federacionRama = $_POST['sltFederacionRama'];
        else
            $federacionRama = "";
        
        if(isset($_POST['sltDivisionEconomica']))
           $divisionEconomica = $_POST['sltDivisionEconomica'];
        else
            $divisionEconomica = "";   
        
        if(isset($_POST['txtOtroTipoViolacion']))
           $otroTipoViolacion = $_POST['txtOtroTipoViolacion'];
        else
            $otroTipoViolacion = "";           
        
        if(isset($_POST['txtResponsables']))
           $responsables = $_POST['txtResponsables'];
        else
            $responsables = "";                   
        
       $cedula = $_POST['txtCedulaVictima'];
       $idVictima = $_POST['txtIdVictima'];
       $datosAuditoria = $this->Auditoria($cedula, "MD");                          
       $rpta = $this->procedimientos_model->SetProcedure("victima_modificar",
                "'".$idVictima."',               
                '".$_POST['sltMunicipioHechos']."',
                '".$divisionEconomica."',                                           
                '".$_POST['sltSiglasSindicato']."', 
                '".$federacionRama."',                                                           
                '".$_POST['sltEmpresa']."',
                '".$_POST['sltTipoViolacion']."',
                '".$_POST['sltGenero']."',                
                '".$_POST['sltMunicipio']."',                    
                '".$cedula."',                    
                '".$_POST['txtNombreVictima']."',                    
                '".$_POST['txtLugar']."',                    
                '".$_POST['txtCausas']."',                        
                '".date('Y')."',                    
                '".$_POST['txtFecha']."',                                        
                '".$_POST['txtFuente']."',                    
                '".$_POST['txtResumenHechos']."',
                '".$responsables."',                
                '".$_POST['txtClaseTrabajador']."',                    
                '".$_POST['txtSubTipoTrabajador']."',
                '".$_POST['txtFederacionRegion']."',
                '".$_POST['txtActividadSindicato']."',                
                '".$_POST['txtConfederacion']."',                    
                '".$_POST['txtOrganizacionPolitica']."',                    
                '".$otroTipoViolacion."',                                        
                '".$_POST['txtTipoEmpresa']."'
                ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresVictima(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                             
       
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaVictima', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarVictima($idVictima)
   {
        $datosAuditoria = $this->Auditoria($idVictima, "EL");       
        $rpta = $this->procedimientos_model->SetProcedure("victima_eliminar","'$idVictima'", $datosAuditoria);        
        
        $parametros = $this->ObtenerListaValoresVictima(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                                
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaVictima', $parametros);  
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
        $this->ObtenerListaValoresVictima();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorVictima/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }    
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarVictima($idVictima, $consultar = "")
   {  
        $registro = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_cedula","'$idVictima'");
        $parametros = $this->ObtenerListaValoresVictima();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaVictima', $parametros);
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
        $objSheet->setTitle('DatosVictima');

        //Se obtiene la data del reporte    
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar","");
        else if($this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion')
            $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_federacion","'".$this->session->userdata('rutFederacion')."'");                           
        else
           $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_sindicato","'".$this->session->userdata('rutSindicato')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('CEDULA'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE'));
        $objSheet->getCell('C1')->setValue(utf8_encode('NOMBRE DE EMPRESA'));
        $objSheet->getCell('D1')->setValue(utf8_encode('DEPARTAMENTO'));
        $objSheet->getCell('E1')->setValue(utf8_encode('MUNICIPIO'));
        $objSheet->getCell('F1')->setValue(utf8_encode('AÑO CREACIÓN'));
            
        foreach($registrosConsultaVictima as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['cedula'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombres_apellidos'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['empresa'])));                
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['departamento'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['M'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['anyo'])));
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
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:H'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:H'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Victima.xlsx');               
        header('Location: /temp/Victima.xlsx');
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
        $pdf->Cabecera('LISTADO DE VICTIMAS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(22, 35, 31, 33, 30, 24, 38, 31, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('CEDULA', 'NOMBRE', 'NOMBRE EMPRESA','DEPARTAMENTO', 'MUNICIPIO', 'AÑO DE CREACION');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar","");           
        else if($this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion')
            $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_federacion","'".$this->session->userdata('rutFederacion')."'");                   
        else
            $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_sindicato","'".$this->session->userdata('rutSindicato')."'");
               
        foreach($registrosConsultaVictima as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["cedula"]), 
                            utf8_decode($registro["nombres_apellidos"]), 
                            utf8_decode($registro["empresa"]),                             
                            utf8_decode($registro["departamento"]), 
                            utf8_decode($registro["M"]),                             
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
       $existe = $this->procedimientos_model->GetProcedure("victima_validar_cedula","'$cedula'");          
       
       if($existe[0]['count'] > 0)
        echo 'La Cedula ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresVictima($ordenamiento = 1, $pagina = 1, $cedula = "")
   {       
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$cedula."'");
       else if($this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion')
           $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_federacion","'".$this->session->userdata('rutFederacion')."'");           
       else
           $registrosConsultaVictima = $this->procedimientos_model->GetProcedure("victima_seleccionar_por_sindicato","'".$this->session->userdata('rutSindicato')."'");
       
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $genero = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'GENERO'");
       $tipoViolacion = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOVIOLACION'");
       $federacionRama = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'AFILIAFEDERARAMA'");
       if($this->session->userdata('perfil') == 'Administracion')
           $siglasSindicato = $this->procedimientos_model->GetProcedure("seleccionar_sindicato_siglas","");
       else
           $siglasSindicato = $this->procedimientos_model->GetProcedure("empresa_sindicato_siglas","'".$this->session->userdata('rutSindicato')."'");
       $divisionEconomica = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CLASIFICAECONOSINDIC'");
       $conteoTotal = $this->procedimientos_model->GetProcedure("victima_seleccionar_conteo_total","");       
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       if($this->session->userdata('perfil') == 'Administracion')
           $empresa = $this->procedimientos_model->GetProcedure("afiliado_empresa_seleccionar","");
       else
           $empresa = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$this->session->userdata('rutSindicato')."'");

       
       $datosVistaVictima = array(  
                    'registros' => $registrosConsultaVictima,
                    'departamentos' => $departamentos,
                    'municipios' => $municipios,
                    'genero' => $genero,
                    'tipoViolacion' => $tipoViolacion,                    
                    'empresa' => $empresa,
                    'federacionRama' => $federacionRama,                    
                    'siglasSindicato' => $siglasSindicato,
                    'divisionEconomica' => $divisionEconomica,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario           


                );
       
       return $datosVistaVictima;
   }
}