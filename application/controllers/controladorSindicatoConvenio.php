<?php 
/*
 * Controlador Sindicato por convenio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 20/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorSindicatoConvenio extends CI_Controller
{

   public function __construct()
   {
        parent::__construct();
        $this->load->model('procedimientos_model');      
        $this->load->helper('url');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session','form_validation'));                
        $this->load->library('form_validation');
    }    
    
   function index()
   {  
       if($this->session->userdata('esLogueado') == FALSE)        
            redirect('login');
              
       $parametros = $this->ObtenerListaValoresSindicatoConvenio();       
       $this->load->view('vistaSindicatoConvenio', $parametros);          
   }       
   
   public function AdicionarSindicatoEmpresa()
   {       
       $rpta = $this->procedimientos_model->SetProcedure("sindicato_convenio_insertar",
                "'".$_POST['sltSindicaFirmanConvenioAdic']."',
                '".$_POST['sltEmpresaFirmaConvenioAdic']."'      
                ");
        
        $parametros = $this->ObtenerListaValoresSindicatoConvenio();      
       
        if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaSindicatoConvenio', $parametros);
    }
    
   function EliminarSindicatoEmpresa($convenio_colectivo_id_convenio_colectivo)
   {
        $rpta = $this->procedimientos_model->SetProcedure("sindicato_convenio_eliminar","'$convenio_colectivo_id_convenio_colectivo'");
        
        $parametros = $this->ObtenerListaValoresSindicatoConvenio();      
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaSindicatoConvenio', $parametros);         
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
        $objSheet->setTitle('DatosSindicatoConvenio');
        
        if($this->session->userdata('perfil') == 'Administracion')
            $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("sindicato_convenio_seleccionar","");
        else 
            $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("sindicato_convenio_x_perfil_seleccionar","'".$this->session->userdata('registroSindical')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('SINDICATO'));
        $objSheet->getCell('B1')->setValue(utf8_encode('CONVENIO (FECHA INI - FECHA FIN)'));
            
        foreach($registrosConsultaConvenio as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_sindicato'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro["nombre_empresa"].' ('.$registro["fecha_inicio_convenio"].' - '.$registro["fecha_finalizacion_convenio"].')')));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:B1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:B'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:B'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/SindicatoPorConvenios.xlsx');               
        header('Location: /temp/SindicatoPorConvenios.xlsx');
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
        $pdf->Cabecera('LISTADO DE SINDICATO POR CONVENIO', '', 125);        
        //Defino el ancho de cada columna
        $w = array(48, 78);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('L', 'L');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('SINDICATO', 'CONVENIO');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
            $registrosConsultaSindicatoEmpresa = $this->procedimientos_model->GetProcedure("sindicato_convenio_seleccionar","");
        else 
            $registrosConsultaSindicatoEmpresa = $this->procedimientos_model->GetProcedure("sindicato_convenio_x_perfil_seleccionar","'".$this->session->userdata('registroSindical')."'");
        
        foreach($registrosConsultaSindicatoEmpresa as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["nombre_sindicato"]), 
                            utf8_decode($registro["nombre_empresa"].' ('.$registro["fecha_inicio_convenio"].' - '.$registro["fecha_finalizacion_convenio"].')')));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresSindicatoConvenio()
   {   
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaSindicatoEmpresa = $this->procedimientos_model->GetProcedure("sindicato_convenio_seleccionar","");
       else
           $registrosConsultaSindicatoEmpresa = $this->procedimientos_model->GetProcedure("sindicato_convenio_x_perfil_seleccionar","'".$this->session->userdata('registroSindical')."'");       
       if($this->session->userdata('perfil') == 'Administracion')
           $sindicaFirmanConvenio = $this->procedimientos_model->GetProcedure("convenio_sindicato_seleccionar","");
       else
           $sindicaFirmanConvenio = $this->procedimientos_model->GetProcedure("convenio_sindicato_x_perfil_seleccionar","'".$this->session->userdata('registroSindical')."'");              
       if($this->session->userdata('perfil') == 'Administracion')
           $empresaFirmaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar_por_rut","");
       else
           $empresaFirmaConvenio = $this->procedimientos_model->GetProcedure("convenio_x_pefil_seleccionar_por_rut","'".$this->session->userdata('registroSindical')."'");              
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaSindicatoConvenio = array(
                    'registros' => $registrosConsultaSindicatoEmpresa,
                    'sindicaFirmanConvenio' => $sindicaFirmanConvenio,
                    'empresaFirmaConvenio'=> $empresaFirmaConvenio,
                    'usuario'=> $usuario
                );
       
       return $datosVistaSindicatoConvenio;
   }   
}