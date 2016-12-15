<?php 
/*
 * Controlador Grupo Menú con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorGrupoMenu extends CI_Controller
{
   public function __construct()
   {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
    }
                
   function index()
   {
       $this->load->model('procedimientos_model');      
       $datos = $this->ObtenerListaValoresGrupoMenu();
       
       $this->load->view('vistaGrupoMenu', $datos);                   
   }
   
   
     
   public function AdicionarGrupoMenu()
   {       
        $this->load->model('procedimientos_model');        
        $rpta = $this->procedimientos_model->SetProcedure("grupo_menu_insertar",
                "'".$_POST['sltNombreMenuAdic']."',
                '".$_POST['sltNombreGrupoAdic']."'          
                ");
        
       $parametros = $this->ObtenerListaValoresGrupoMenu();      
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaGrupoMenu', $parametros);
    }
    
   function EliminarGrupoMenu($id)
   {
        $this->load->model('procedimientos_model');                     
        $rpta = $this->procedimientos_model->SetProcedure("grupo_menu_eliminar","'$id'");
        
        $parametros = $this->ObtenerListaValoresGrupoMenu();      
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaGrupoMenu', $parametros); 
    }        
         
   
   
   /*
    * Validar menu existente
    */
   public function ValidarMenu($menu)
   {       
       $this->load->model('procedimientos_model');        
       $existe = $this->procedimientos_model->GetProcedure("menu_validar_menu","'$menu'");          
       if($existe[0]['count'] > 0)
        echo 'El menu ya existe, escriba uno nuevo.';
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
        $objSheet->setTitle('DatosGrupoMenu');

        //Se obtiene la data del reporte
        $this->load->model('procedimientos_model');       
        $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("grupo_menu_seleccionar","");
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('NOMBRE DEL MENÚ'));        
        $objSheet->getCell('C1')->setValue(utf8_encode('NOMBRE DEL GRUPO'));
        
        foreach($registrosConsultaConvenio as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_nenu'])));            
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_grupo'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:F'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:F'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Grupo Menu.xlsx');               
        header('Location: /temp/Grupo Menu.xlsx');
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
        $pdf->Cabecera('LISTADO DE GRUPO MENU', '', 125);        
        //Defino el ancho de cada columna
        $w = array(48, 45, 32, 37, 41, 41);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('L', 'L', 'C', 'C', 'C', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('NOMBRE DEL MENÚ', 'NOMBRE DEL GRUPO');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        $this->load->model('procedimientos_model');       
        $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("grupo_menu_seleccionar","");
        
        foreach($registrosConsultaConvenio as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["nombre_nenu"]),                             
                            utf8_decode($registro["nombre_grupo"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresGrupoMenu()
   {   
       $registrosConsultaGrupoMenu = $this->procedimientos_model->GetProcedure("grupo_menu_seleccionar","");
       $nombreMenu = $this->procedimientos_model->GetProcedure("menu_nombre_seleccionar","");       
       $nombreGrupo = $this->procedimientos_model->GetProcedure("grupo_usuario_nombre_seleccionar","");       
       
       $datosVistaGrupoMenu = array(
                    'registros' => $registrosConsultaGrupoMenu,                    
                    'nombreMenu' => $nombreMenu,
                    'nombreGrupo' => $nombreGrupo

                );
       
       return $datosVistaGrupoMenu;
   }      
}