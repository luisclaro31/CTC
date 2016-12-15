<?php 
/*
 * Controlador Usuarios con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorUsuario extends CI_Controller
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
                
       $datos = $this->ObtenerListaValoresUsuario();
       
       $this->load->view('vistaUsuario', $datos);                   
   }
   
   function ConsultarUsuario($idUsuario, $consultar = "")
   {  
        $registro = $this->procedimientos_model->GetProcedure("usuario_seleccionar_por_id","'$idUsuario'");
        $parametros = $this->ObtenerListaValoresUsuario();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaUsuario', $parametros);
   }
     
   public function AdicionarUsuario()
   {       
        $rpta = $this->procedimientos_model->SetProcedure("usuario_adicionar",
                "'ACTIVO',
                '".$_POST['sltGrupoUsuarioAdic']."',                
                '".$_POST['txtNombresApellidosAdic']."',                    
                '".$_POST['txtCorreoAdic']."',
                '".date('Y')."',
                '".$_POST['txtUsuarioAdic']."',
                '".sha1($_POST['txtPasswordAdic'])."'          
                ");
        
       $parametros = $this->ObtenerListaValoresUsuario();      
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaUsuario', $parametros);
    }
    
   function EliminarUsuario($id)
   {              
        $rpta = $this->procedimientos_model->SetProcedure("usuario_eliminar","'$id'");
        
        $parametros = $this->ObtenerListaValoresUsuario();      
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaUsuario', $parametros); 
    }    
    
   public function ModificarUsuario()
   {     
       $rpta = $this->procedimientos_model->SetProcedure("usuario_modificar",
                "'".$_POST['txtId']."',                
                '".$_POST['sltGrupoUsuario']."',                
                '".$_POST['sltEstado']."',                
                '".$_POST['txtNombresApellidos']."',                    
                '".$_POST['txtCorreo']."',
                '".$_POST['txtUsuario']."',
                '".sha1($_POST['txtPassword'])."' 
                ");
        
        $parametros = $this->ObtenerListaValoresUsuario();      
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
       
       if($this->session->userdata('perfil') == 'Administracion')
           $this->load->view('vistaUsuario', $parametros);
       else
           $this->load->view('vistaInicio', $parametros);
   }    
           
   /*
    * Validar usuario existente
    */
   public function ValidarUsuario($usuario)
   {            
       $existe = $this->procedimientos_model->GetProcedure("usuario_validar_usuario","'$usuario'");          
       
       if($existe[0]['count'] > 0)
        echo 'El usuario ya existe, escriba uno nuevo.';
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
        $objSheet->setTitle('DatosUsuario');

        //Se obtiene la data del reporte
        $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("usuario_seleccionar","'1'");
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('NOMBRES'));
        $objSheet->getCell('B1')->setValue(utf8_encode('CORREO'));
        $objSheet->getCell('C1')->setValue(utf8_encode('ESTADO'));
        $objSheet->getCell('D1')->setValue(utf8_encode('GRUPO USUARIO'));
        $objSheet->getCell('E1')->setValue(utf8_encode('USUARIO'));
        $objSheet->getCell('F1')->setValue(utf8_encode('FECHA ÚLTIMO INGRESO'));
        
        foreach($registrosConsultaConvenio as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_apellido'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['correo'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_estado'])));    
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_grupo'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['login_usuario'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_ultimo_ingreso'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);
        $objSheet->getColumnDimension('F')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:F'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:F'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/ConveniosUsuarios.xlsx');               
        header('Location: /temp/ConveniosUsuarios.xlsx');
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
        $pdf->Cabecera('LISTADO DE USUARIOS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(48, 45, 32, 37, 41, 41);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('L', 'L', 'C', 'C', 'C', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('NOMBRES', 'CORREO', 'ESTADO', 'GRUPO USUARIO', 'USUARIO', 'FECHA ÚLTIMO INGRESO');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte  
        $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("usuario_seleccionar","'1'");
        
        foreach($registrosConsultaConvenio as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["nombre_apellido"]), 
                            utf8_decode($registro["correo"]), 
                            utf8_decode($registro["descripcion_estado"]), 
                            utf8_decode($registro["nombre_grupo"]), 
                            utf8_decode($registro["login_usuario"]), 
                            utf8_decode($registro["fecha_ultimo_ingreso"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresUsuario($ordenamiento = 1)
   {   
       $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("usuario_seleccionar","'".$ordenamiento."'");
       $estados = $this->procedimientos_model->GetProcedure("tipo_estado_seleccionar_por_estado","'ESTADOUSUARIO'");
       $grupoUsuario = $this->procedimientos_model->GetProcedure("grupo_usuario_seleccionar","");
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaConvenio = array(
                    'registros' => $registrosConsultaConvenio,                    
                    'estados'=> $estados,
                    'grupoUsuario'=> $grupoUsuario,
                    'usuario'=> $usuario
                );
       
       return $datosVistaConvenio;
   }      
}