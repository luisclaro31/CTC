<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 19/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorDirectivoFederacion extends CI_Controller
{
           static function Tabla()
   {
        return "directivo";
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
        $parametros = $this->ObtenerListaValoresDirectivoFederacion($ordenamiento, $desde, $cedula);                
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorDirectivoFederacion/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();       
       
       $this->load->view('vistaDirectivoFederacion', $parametros);
   }
   
   public function AdicionarDirectivoFederacion()
   {    
        $cedula = $_POST['txtCedulaDirectivoAdic'];
        $datosAuditoria = $this->Auditoria($cedula, "AD");              
        $rpta = $this->procedimientos_model->SetProcedure("directivo_Federacion_insertar",
                "'".$_POST['sltFederacionDirectivoAdic']."',
                '".$_POST['sltCargoDirectivoAdic']."',
                '".$_POST['sltEdadCategoriasAdic']."',                    
                '".$_POST['sltNivelEducativoAdic']."',
                '".$cedula."',                
                '".$_POST['txtNombreApellidoAdic']."',                    
                '".$_POST['txtFechaNacimientoAdic']."',
                '".$_POST['txtNumeroCelularAdic']."',
                '".$_POST['txtCorreoAdic']."',                
                '".$_POST['txtUsuarioFacebookAdic']."',                    
                '".$_POST['txtUsuarioTwiterAdic']."',                    
                '".$_POST['txtTelefonosAdic']."'                
                ", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresDirectivoFederacion(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);        
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaDirectivoFederacion', $parametros);
        
    }
   
   public function ModificarDirectivoFederacion()
   {   
       $cedula = $_POST['txtCedulaDirectivo'];
       $datosAuditoria = $this->Auditoria($cedula, "MD");                          
       $rpta = $this->procedimientos_model->SetProcedure("directivo_federacion_modificar",
                "'".$_POST['sltFedeacionDirectivo']."',
                '".$_POST['sltCargoDirectivo']."',
                '".$_POST['sltEdadCategorias']."',                    
                '".$_POST['sltNivelEducativo']."',
                '".$cedula."',                
                '".$_POST['txtNombreApellido']."',                    
                '".$_POST['txtFechaNacimiento']."',
                '".$_POST['txtNumeroCelular']."',
                '".$_POST['txtCorreo']."',                
                '".$_POST['txtUsuarioFacebook']."',                    
                '".$_POST['txtUsuarioTwiter']."',                    
                '".$_POST['txtTelefonos']."',                    
                '".$_POST['txtIdDirectivo']."'                
                ", $datosAuditoria);
                

        $parametros = $this->ObtenerListaValoresDirectivoFederacion(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                             
       
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaDirectivoFederacion', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarDirectivoFederacion($cedula)
   {
        $datosAuditoria = $this->Auditoria($cedula, "EL");       
        $rpta = $this->procedimientos_model->SetProcedure("directivo_federacion_eliminar","'$cedula'", $datosAuditoria);        
        
        $parametros = $this->ObtenerListaValoresDirectivoFederacion(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                                
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaDirectivoFederacion', $parametros);  
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
        $this->ObtenerListaValoresDirectivoFederacion();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorDirectivoFederacion/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }    
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarDirectivoFederacion($cedula, $consultar = "")
   {  
        $registro = $this->procedimientos_model->GetProcedure("directivo_federacion_seleccionar_por_cedula","'$cedula'");
        $parametros = $this->ObtenerListaValoresDirectivoFederacion();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaDirectivoFederacion', $parametros);
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
        $objSheet->setTitle('DatosDirectivoFederacion');        
        
        
        //Se obtiene la data del reporte    
        if($this->session->userdata('perfil') == 'Administracion')
            $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_seleccionar","");
        else
            $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_x_perfil","'".$this->session->userdata('registroFederacion')."'");

        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('CEDULA'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRES APELLIDOS'));
        $objSheet->getCell('C1')->setValue(utf8_encode('CARGO'));        
        $objSheet->getCell('D1')->setValue(utf8_encode('CORREO'));
        $objSheet->getCell('E1')->setValue(utf8_encode('NOMBRE FEDERACION'));        
            
        foreach($registrosConsultaDirectivo as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['cedula'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombres_apellidos'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['cargo'])));                
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['correo'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['federacion'])));            
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
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:H'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:H'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Directivo.xlsx');               
        header('Location: /temp/Directivo.xlsx');
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
        $pdf->Cabecera('LISTADO DE DIRECTIVOS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(22, 35, 31, 33, 30, 24, 38, 31, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('CEDULA', 'NOMBRES APELLIDOS','CARGO', 'CORREO', 'NOMBRE FEDERACION');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte           

        
        if($this->session->userdata('perfil') == 'Administracion')
            $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_seleccionar","");
        else
            $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_x_perfil","'".$this->session->userdata('registroFederacion')."'");        

             
        foreach($registrosConsultaDirectivo as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["cedula"]), 
                            utf8_decode($registro["nombres_apellidos"]), 
                            utf8_decode($registro["cargo"]),                             
                            utf8_decode($registro["correo"]),                             
                            utf8_decode($registro["federacion"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
    
    
   /*
    * Validar cedula existente
    */
   public function ValidarCedula($cedula)
   {       
       $existe = $this->procedimientos_model->GetProcedure("directivo_validar_cedula","'$cedula'");          
       
       if($existe[0]['count'] > 0)
        echo 'La Cedula ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresDirectivoFederacion($ordenamiento = 1, $pagina = 1, $cedula = "")
   {
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$cedula."'");       
       else if($this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional')
           $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_x_seccional","'".$this->session->userdata('registroSeccional')."'");       
       else 
           $registrosConsultaDirectivo = $this->procedimientos_model->GetProcedure("directivo_federacion_x_perfil","'".$this->session->userdata('registroFederacion')."'");
       $nivelEducativo = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'NIVELEDUCATIVO'");       
       $cargos = $this->procedimientos_model->GetProcedure("cargo_seleccionar","");       
       $edadPorCategorias = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EDADPORCATEGORIAS'");
       if($this->session->userdata('perfil') == 'Administracion')
           $federacionDirectivo = $this->procedimientos_model->GetProcedure("seleccionar_directivo_federacion_seleccionar","");       
       else
           $federacionDirectivo = $this->procedimientos_model->GetProcedure("seleccionar_directivo_federacion_x_perfil","'".$this->session->userdata('registroFederacion')."'");              
       $conteoTotal = $this->procedimientos_model->GetProcedure("directivo_seleccionar_conteo_total","");              
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaDirectivoFederacion = array(  
                    'registros' => $registrosConsultaDirectivo,                    
                    'nivelEducativo' => $nivelEducativo,
                    'cargos' => $cargos,
                    'edadPorCategorias' => $edadPorCategorias,
                    'federacionDirectivo' => $federacionDirectivo,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaDirectivoFederacion;
   }
}
