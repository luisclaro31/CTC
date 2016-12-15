<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorEstado extends CI_Controller
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
    }
      
   /*
    * Método inicial del controlador
    */
   public function index()
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
                   
       $parametros = $this->ObtenerListaValoresEstado();        
       $this->load->view('vistaEstado', $parametros);
   }
      
   public function AdicionarEstado()
   {
        $rpta = $this->procedimientos_model->SetProcedure("tipo_estado_insertar",
                "'".$_POST['txtCodigoAdic']."',
                '".$_POST['sltNombreEstadoAdic']."',                    
                '".$_POST['txtDescripcionEstadoAdic']."'
                ");

        
       $parametros = $this->ObtenerListaValoresEstado();      
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaEstado', $parametros);
    }
   
   public function ModificarEstado()
   {   
       $rpta = $this->procedimientos_model->SetProcedure("tipo_estado_modificar",
                "'".$_POST['txtCodigo']."',
                '".$_POST['sltNombreEstado']."',                    
                '".$_POST['txtDescripcionEstado']."'
                ");

       $parametros = $this->ObtenerListaValoresEstado();      
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaEstado', $parametros);
   }
   
   /*
    * Eliminación de registro por codigo
    */
   public function EliminarEstado($codigo)
   {
        $rpta = $this->procedimientos_model->SetProcedure("tipo_estado_eliminar","'$codigo'");        
        
        $parametros = $this->ObtenerListaValoresEstado();      
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaEstado', $parametros);  
    }
    
   /*
    * Consulta detallada por codigo
    */
   public function ConsultarEstado($codigo, $consultar = "")
   {
        $registro = $this->procedimientos_model->GetProcedure("tipo_estado_seleccionar_por_codigo","'$codigo'");
        $parametros = $this->ObtenerListaValoresEstado();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaEstado', $parametros);
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
        $objSheet->setTitle('DatosEstado');

        //Se obtiene la data del reporte
        $registrosConsultaEstado = $this->procedimientos_model->GetProcedure("tipo_estado_seleccionar","");
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('CODIGO'));
        $objSheet->getCell('B1')->setValue(utf8_encode('DESCRIPCION LISTA DE ESTADO'));
        $objSheet->getCell('C1')->setValue(utf8_encode('NOMBRE ESTADO'));
            
        foreach($registrosConsultaEstado as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['codigo'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_estado'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        
        
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/ListaDeCategoria.xlsx');               
        header('Location: /temp/ListaDeCategoria.xlsx');
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
        $pdf->Cabecera('LISTA DE CATEGORIA', '', 125);        
        //Defino el ancho de cada columna
        $w = array(22, 35, 21, 33, 30, 24, 38, 27, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('CODIGO', 'DESCRIPCION LISTA DE CATEGORIA', 'NOMBRE CATEGORIA');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        $registrosConsultaEstado = $this->procedimientos_model->GetProcedure("tipo_estado_seleccionar","");
        
        foreach($registrosConsultaEstado as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["codigo"]),                             
                            utf8_decode($registro["descripcion"]),                             
                            utf8_decode($registro["nombre_estado"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
    
   /*
    * Validar codigo existente
    */
   public function ValidarCodigo($codigo)
   {       
       $existe = $this->procedimientos_model->GetProcedure("tipo_estado_validar_codigo","'$codigo'");          
       if($existe[0]['count'] > 0)
        echo 'El Codigo para la lista de categoria ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresEstado()
   {       
       $registrosConsultaEstado = $this->procedimientos_model->GetProcedure("tipo_estado_seleccionar",""); 
       $nombreEstado = $this->procedimientos_model->GetProcedure("estado_seleccionar",""); 
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaEstado = array(  
                    'registros' => $registrosConsultaEstado,                    
                    'nombreEstado' => $nombreEstado,                                        
           
                    'usuario'=> $usuario
                );
       
       return $datosVistaEstado;
   }
}