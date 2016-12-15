<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorAuditoria extends CI_Controller
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
       
       //Solo se permite el ingreso al perfil administrador
       if($this->session->userdata('perfil') != "Administracion")
       {
           echo "Acceso denegado, solo se permite para perfil administrador. 
                <br/>
                <a href='/index.php/controladorInicio'>Regresar</a>";
           exit;
       }
       
        $id_auditoria = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                
        $parametros = $this->ObtenerListaValoresAuditoria($ordenamiento, $desde, $id_auditoria);        
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorAuditoria/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();                   
       
       $this->load->view('vistaAuditoria', $parametros);
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
        $objSheet->setTitle('DatosAuditoria');

        //Se obtiene la data del reporte
        $registrosConsultaAuditoria = $this->procedimientos_model->GetProcedure("auditoria_seleccionar","");
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('CODIGO'));
        $objSheet->getCell('B1')->setValue(utf8_encode('CODIGO REGISTRO'));                
        $objSheet->getCell('C1')->setValue(utf8_encode('NOMBRE USUARIO'));                
        $objSheet->getCell('D1')->setValue(utf8_encode('NOMBRE TABLA'));                
        $objSheet->getCell('E1')->setValue(utf8_encode('FECHA EVENTO'));                
        $objSheet->getCell('F1')->setValue(utf8_encode('TIPO CAMBIO'));                
        $objSheet->getCell('G1')->setValue(utf8_encode('IP USUARIO'));                
            
        foreach($registrosConsultaAuditoria as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['id_auditoria'])));                        
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['id_registro'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_apellido'])));
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_tabla'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['tipo_creacion_cambio'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['ip_usuario'])));
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
        
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Auditoria.xlsx');               
        header('Location: /temp/Auditoria.xlsx');
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
        $pdf->Cabecera('LISTADO DE AUDITORIA', '', 125);        
        //Defino el ancho de cada columna
        $w = array(22, 35, 21, 33, 30, 24, 38, 27, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('CODIGO', 'CODIGO REGISTRO', 'NOMBRE USUARIO', 'NOMBRE TABLA', 'FECHA EVENTO', 'TIPO CAMBIO', 'IP USUARIO');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        $registrosConsultaAuditoria = $this->procedimientos_model->GetProcedure("auditoria_seleccionar","");
        
        foreach($registrosConsultaAuditoria as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["id_auditoria"]),                             
                            utf8_decode($registro["id_registro"]), 
                            utf8_decode($registro["nombre_apellido"]),                             
                            utf8_decode($registro["nombre_tabla"]), 
                            utf8_decode($registro["fecha"]), 
                            utf8_decode($registro["tipo_creacion_cambio"]),                             
                            utf8_decode($registro["ip_usuario"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }   
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresAuditoria($ordenamiento = 1, $pagina = 1, $id_auditoria = "")
   {       
       $registrosConsultaAuditoria = $this->procedimientos_model->GetProcedure("auditoria_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$id_auditoria."'");
       $conteoTotal = $this->procedimientos_model->GetProcedure("auditoria_seleccionar_conteo_total","");                     
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaAuditoria = array(  
                    'registros' => $registrosConsultaAuditoria,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaAuditoria;
   }
}