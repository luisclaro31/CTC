<?php 
/*
 * Controlador Grupo Menú con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorUsuarioSindicato extends CI_Controller
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
       
       //Solo se permite el ingreso al perfil administrador
       if($this->session->userdata('perfil') != "Administracion")
       {
           echo "Acceso denegado, solo se permite para perfil administrador. 
                <br/>
                <a href='/index.php/controladorInicio'>Regresar</a>";
           exit;
       }
   
       $datos = $this->ObtenerListaValoresUsuarioSindicato();       
       $this->load->view('vistaUsuarioSindicato', $datos);                   
   }

   function ConsultarUsuarioSindicato($usuario_id_usuario, $consultar = "")
   {      
        $registro = $this->procedimientos_model->GetProcedure("usuario_sindicato_seleccionar_por_id","'$usuario_id_usuario'");
        $parametros = $this->ObtenerListaValoresUsuarioSindicato();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        

        $this->load->view('vistaUsuarioSindicato', $parametros);
   }
        
   public function AdicionarUsuarioSindicato()
   {       
        $rpta = $this->procedimientos_model->SetProcedure("usuario_perfil_insertar",
                "'".$_POST['sltSindicatoAdic']."',
                '".$_POST['sltUsuarioAdic']."'          
                ");
        
       $parametros = $this->ObtenerListaValoresUsuarioSindicato();      
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaUsuarioSindicato', $parametros);
    }
    
   function EliminarUsuarioSindicato($usuario_id_usuario,$sindicato_rut)
   {                   
        $rpta = $this->procedimientos_model->SetProcedure("usuario_sindicato_eliminar","'$usuario_id_usuario', '$sindicato_rut'");
        
        $parametros = $this->ObtenerListaValoresUsuarioSindicato();      
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaUsuarioSindicato', $parametros); 
    }        
   
   /*
    * Validar menu existente

   public function ValidarMenu($menu)
   {       
       $existe = $this->procedimientos_model->GetProcedure("menu_validar_menu","'$menu'");          
       
       if($existe[0]['count'] > 0)
        echo 'El menu ya existe, escriba uno nuevo.';
   }
    * 
    */
   
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
        $objSheet->setTitle('DatosUsuarioSindicato');

        //Se obtiene la data del reporte    
        $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("usuario_sindicato_seleccionar","");
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('NOMBRE DEL USUARIO'));        
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE DEL SINDICATO'));
        
        foreach($registrosConsultaConvenio as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_apellido'])));            
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre'])));
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
        $objWriter->save('temp/UsuarioSindicato.xlsx');               
        header('Location: /temp/UsuarioSindicato.xlsx');
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
        $pdf->Cabecera('LISTADO DE USUARIO SINDICATOS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(48, 45, 32, 37, 41, 41);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('L', 'L', 'C', 'C', 'C', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('NOMBRE DEL USUARIO', 'NOMBRE DEL SINDICATO');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        $this->load->model('procedimientos_model');       
        $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("usuario_sindicato_seleccionar","");
        
        foreach($registrosConsultaConvenio as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["nombre_apellido"]),                             
                            utf8_decode($registro["nombre"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresUsuarioSindicato()
   {   
       $registrosConsultaUsuarioSindicato = $this->procedimientos_model->GetProcedure("usuario_perfil_seleccionar","");
       $registrosConsultaSindicato = $this->procedimientos_model->GetProcedure("organizacion_sindical_seleccionar","");
       $nombreUsuario = $this->procedimientos_model->GetProcedure("usuario_nombre_seleccionar","");       
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'rutSindicato' => $this->session->userdata('rutSindicato'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaUsuarioSindicato = array(
                    'registros' => $registrosConsultaUsuarioSindicato,                    
                    'registrosConsultaSindicato' => $registrosConsultaSindicato,                    
                    'nombreUsuario' => $nombreUsuario,
                    'usuario'=> $usuario
                );
       
       return $datosVistaUsuarioSindicato;
   }
}