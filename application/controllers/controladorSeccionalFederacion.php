<?php 
/*
 * Controlador Seccional Federacion con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 10/07/15
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorSeccionalFederacion extends CI_Controller
{
   
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
        $parametros = $this->ObtenerListaValoresSeccionalFederacion($ordenamiento, $desde, $rut);
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorSeccionalFederacion/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();                                 
        
       $this->load->view('vistaSeccionalFederacion', $parametros);
   }
   

    public function Paginacion($parametros)
    {
        $this->ObtenerListaValoresSeccionalFederacion();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorSeccionalFederacion/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
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
        $objSheet->setTitle('DatosSeccional_x_Federaciones');

        //Se obtiene la data del reporte   
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSeccionalFederacion = $this->procedimientos_model->GetProcedure("seccional_federacion_seleccionar","");
        else
            $registrosConsultaSeccionalFederacion = $this->procedimientos_model->GetProcedure("seccional_federacion_seleccionar_x_perfil","'".$this->session->userdata('registroSeccional')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('RUT SECCIONAL'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE SECCIONAL'));
        $objSheet->getCell('C1')->setValue(utf8_encode('SIGLA SECCIONAL'));
        $objSheet->getCell('D1')->setValue(utf8_encode('ESTADO SECCIONAL'));
        $objSheet->getCell('E1')->setValue(utf8_encode('RUT FEDERACION'));
        $objSheet->getCell('F1')->setValue(utf8_encode('NOMBRE FEDERACION'));
        $objSheet->getCell('G1')->setValue(utf8_encode('SIGLA FEDERACION'));
        $objSheet->getCell('H1')->setValue(utf8_encode('ESTADO FEDERACION'));        
            
        foreach($registrosConsultaSeccionalFederacion as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['rut_seccional'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_seccional'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['siglas_seccional'])));    
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['estado_seccional_descripcion'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['rut'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_federacion'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['siglas_federacion'])));
            $objSheet->getCell('H'.$i)->setValue(utf8_encode(utf8_decode($registro['estado_federacion_descripcion'])));            
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
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Seccional_x_Federaciones.xlsx');               
        header('Location: /temp/Seccional_x_Federaciones.xlsx');
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
           $pdf->Cabecera('LISTADO DE FEDERACIONES AFILIADAS A SECCIONAL', '', 125);
       else
           $pdf->Cabecera('INFORMACIÓN DE FEDERACIONES AFILIADAS A SECCIONAL', '', 125);
               
        //Defino el ancho de cada columna
        $w = array(30, 40, 30, 35, 30, 30, 40, 30, 30);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('RUT SECCIONAL', 'NOMBRE SECCIONAL', 'SIGLA SECCIONAL', 'ESTADO SECCIONAL', 'RUT FEDERACION', 'NOMBRE FEDERACION', 'SIGLA FEDERACION', 'ESTADO FEDERACION');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSeccionalFederacion = $this->procedimientos_model->GetProcedure("seccional_federacion_seleccionar","");
        else
           $registrosConsultaSeccionalFederacion = $this->procedimientos_model->GetProcedure("seccional_federacion_seleccionar_x_perfil","'".$this->session->userdata('registroSeccional')."'");
       
        foreach($registrosConsultaSeccionalFederacion as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["rut_seccional"]), 
                            utf8_decode($registro["nombre_seccional"]), 
                            utf8_decode($registro["siglas_seccional"]), 
                            utf8_decode($registro["estado_seccional_descripcion"]), 
                            utf8_decode($registro["rut"]), 
                            utf8_decode($registro["nombre_federacion"]), 
                            utf8_decode($registro["siglas_federacion"]),                             
                            utf8_decode($registro["estado_federacion_descripcion"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresSeccionalFederacion($ordenamiento = 1, $pagina = 1, $rut = "")
   {   
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSeccionalFederacion = $this->procedimientos_model->GetProcedure("seccional_federacion_seleccionar_princial","'".$ordenamiento."', '".$pagina."', '".$rut."'");
       else
           $registrosConsultaSeccionalFederacion = $this->procedimientos_model->GetProcedure("seccional_federacion_seleccionar_x_perfil","'".$this->session->userdata('registroSeccional')."'");              
       $conteoTotal = $this->procedimientos_model->GetProcedure("federacion_sindicato_seleccionar_conteo_total","");                     
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'registroSindical' => $this->session->userdata('registroSindical'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaSeccionalFederacion = array(  
                    'registros' => $registrosConsultaSeccionalFederacion,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaSeccionalFederacion;
   }
}