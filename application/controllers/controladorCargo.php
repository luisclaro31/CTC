<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorCargo extends CI_Controller
{
       static function Tabla()
   {
        return "cargo";
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
       
       //Solo se permite el ingreso al perfil administrador
       if($this->session->userdata('perfil') != "Administracion")
       {
           echo "Acceso denegado, solo se permite para perfil administrador. 
                <br/>
                <a href='/index.php/controladorInicio'>Regresar</a>";
           exit;
       }
        $codigo = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                        
        $parametros = $this->ObtenerListaValoresCargo($ordenamiento, $desde, $codigo);        
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorCargo/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();                          
                   
       
       $this->load->view('vistaCargo', $parametros);
   }
      
   public function AdicionarCargo()
   {
        
        
        $rpta = $this->procedimientos_model->SetProcedure("cargo_insertar",
                "'',
                '".$_POST['txtNombreCargoAdic']."'                
                ");

       $parametros = $this->ObtenerListaValoresCargo(1, 0, "");
       $parametros['paginacion'] = $this->Paginacion($parametros); 
       
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaCargo', $parametros);
    }
   
   public function ModificarCargo()
   {   
       $codigo = $_POST['txtCodigoCargo'];
       $datosAuditoria = $this->Auditoria($codigo, "MD");                          
       $rpta = $this->procedimientos_model->SetProcedure("cargo_modificar",
                "'".$codigo."',
                '".$_POST['txtNombreCargo']."'
                ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresCargo(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                             
             
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaCargo', $parametros);
   }
   
   /*
    * Eliminación de registro por codigo
    */
   public function EliminarCargo($codigo)
   {
       $datosAuditoria = $this->Auditoria($codigo, "EL");
        $rpta = $this->procedimientos_model->SetProcedure("cargo_eliminar","'$codigo'", $datosAuditoria);        
        
        $parametros = $this->ObtenerListaValoresCargo(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);              
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaCargo', $parametros);  
    }
    
    public function Auditoria($codigo, $tipoCreacionCambio)
    {
        $datosAuditoria['idRegistro'] = $codigo;
        $datosAuditoria['idUsuario'] = $this->session->userdata('idUsuario');
        $datosAuditoria['tabla'] = $this->Tabla();
        $datosAuditoria['fecha'] = date('Y-m-d H:i:s');
        $datosAuditoria['tipo_creacion_cambio'] = $tipoCreacionCambio;
        $datosAuditoria['ip_usuario'] = $this->procedimientos_model->ObtenerIP();
        
        return $datosAuditoria;
    }    
    
    public function Paginacion($parametros)
    {
        $this->ObtenerListaValoresCargo();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorCargo/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }        
   /*
    * Consulta detallada por codigo
    */
   public function ConsultarCargo($codigo, $consultar = "")
   {
        $registro = $this->procedimientos_model->GetProcedure("cargo_seleccionar_por_codigo","'$codigo'");
        $parametros = $this->ObtenerListaValoresCargo();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaCargo', $parametros);
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
        $objSheet->setTitle('DatosCargo');

        //Se obtiene la data del reporte
        $registrosConsultaCargo = $this->procedimientos_model->GetProcedure("cargo_seleccionar","");
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('CODIGO'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE CARGO'));                
            
        foreach($registrosConsultaCargo as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['id_cargo'])));                        
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        
        
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Cargos.xlsx');               
        header('Location: /temp/Cargos.xlsx');
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
        $pdf->Cabecera('LISTADO DE CARGOS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(22, 35, 21, 33, 30, 24, 38, 27, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('CODIGO', 'NOMBRE CARGO');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        $registrosConsultaCargos = $this->procedimientos_model->GetProcedure("cargo_seleccionar","");
        
        foreach($registrosConsultaCargos as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["id_cargo"]),                             
                            utf8_decode($registro["descripcion"])));
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
       $existe = $this->procedimientos_model->GetProcedure("cargo_validar_codigo","'$codigo'");          
       if($existe[0]['count'] > 0)
        echo 'El Codigo de cargo ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresCargo($ordenamiento = 1, $pagina = 1, $codigo = "")
   {       
       $registrosConsultaCargos = $this->procedimientos_model->GetProcedure("cargo_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$codigo."'");
       $conteoTotal = $this->procedimientos_model->GetProcedure("cargo_seleccionar_conteo_total","");
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaCargo = array(  
                    'registros' => $registrosConsultaCargos,                    
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaCargo;
   }
}