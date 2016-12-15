<?php 
/*
 * Controlador Empresa con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 12/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorEmpresa extends CI_Controller
{
       static function Tabla()
   {
        return "empresa";
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

        $rut = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                
        $parametros = $this->ObtenerListaValoresEmpresa($ordenamiento, $desde, $rut);
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorEmpresa/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();                                 
        
       $this->load->view('vistaEmpresa', $parametros);
   }
   
   /*
    * 
    */
   public function AdicionarEmpresa()
   {          
        if(isset($_POST['sltEmpresaTipEstAdic']))
            $empresaTipEst = $_POST['sltEmpresaTipEstAdic'];
        else
            $empresaTipEst = "";                     
       
        $rut = $_POST['txtRutAdic'];
        $datosAuditoria = $this->Auditoria($rut, "AD");       
        $rpta = $this->procedimientos_model->SetProcedure("empresa_insertar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacionAdic']."',
                '".$_POST['sltEmpresaSegOriCapAdic']."',                    
                '".$_POST['sltGrupoEconomAdic']."',
                '".$_POST['sltMunicipioAdic']."',                
                '".$empresaTipEst."',
                '".$_POST['sltEmpresaSegCapAdic']."',                
                '".$_POST['txtNombreEmpresaAdic']."',                
                '".$_POST['txtSiglaAdic']."',                    
                '".$_POST['txtDireccionAdic']."',                    
                '".$_POST['txtTelefonoAdic']."',                    
                '".$_POST['txtCorreoAdic']."',                    
                '".$_POST['txtPaginaWebAdic']."',                        
                '".$_POST['txtNumeroTrabajaEmprAdic']."',                    
                '".$_POST['txtNumeroAfiliadosSindicatoAdic']."',                    
                '".$_POST['txtObservacionesAdic']."',                                        
                '".date('Y')."'
                ",$datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresEmpresa(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                      

       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
        {
            // <editor-fold defaultstate="collapsed" desc="Clase de Contrato">
           
           if(isset($_POST['chkFijoAdic']))
           {
                if($_POST['chkFijoAdic'] == 'FIJO')
                {
                     $this->procedimientos_model->SetProcedure("empresa_clase_contrato_adicionar",
                             "'".$_POST['chkFijoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkIndefinidoAdic']))
           {
                if($_POST['chkIndefinidoAdic'] == 'INDEFINIDOCONTRATO')
                {
                     $this->procedimientos_model->SetProcedure("empresa_clase_contrato_adicionar",
                             "'".$_POST['chkIndefinidoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }           
           
           if(isset($_POST['chkPrestacionServiciosAdic']))
           {
                if($_POST['chkPrestacionServiciosAdic'] == 'PRESTACIONSERVICIO')
                {
                     $this->procedimientos_model->SetProcedure("empresa_clase_contrato_adicionar",
                             "'".$_POST['chkPrestacionServiciosAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkCooperativatrabajoAdic']))
           {
                if($_POST['chkCooperativatrabajoAdic'] == 'COOPERATIVATRABAJO')
                {
                     $this->procedimientos_model->SetProcedure("empresa_clase_contrato_adicionar",
                             "'".$_POST['chkCooperativatrabajoAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }
           
           if(isset($_POST['chkEmpresaTemporalSasAdic']))
           {
                if($_POST['chkEmpresaTemporalSasAdic'] == 'EMPRESATEMPORALSAS')
                {
                     $this->procedimientos_model->SetProcedure("empresa_clase_contrato_adicionar",
                             "'".$_POST['chkEmpresaTemporalSasAdic']."',
                             '".$_POST['txtRutAdic']."'");
                }
           }                                            

           // </editor-fold>                                  
           
            if($this->session->userdata('perfil') == 'Editor Sindicato')
            {
                 $this->procedimientos_model->SetProcedure("sindicato_empresa_insertar", "'".$_POST['txtRutAdic']."','".$this->session->userdata('registroSindical')."'");                
                 $this->session->set_userdata('rutEmpresa', $_POST['txtRutAdic']);
                 $parametros = $this->ObtenerListaValoresEmpresa();
            }
            
           $parametros['estadoAdicionar'] = true;
        }
       
        $this->load->view('vistaEmpresa', $parametros);
    }
   
   /*
    * 
    */
   public function ModificarEmpresa()
   {          
        if(isset($_POST['sltEmpresaTipEst']))
            $empresaTipEst = $_POST['sltEmpresaTipEst'];
        else
            $empresaTipEst = "";                     
        
       $rut = $_POST['txtRut'];
       $datosAuditoria = $this->Auditoria($rut, "MD");                   
       $rpta = $this->procedimientos_model->SetProcedure("empresa_modificar",
                "'".$rut."',
                '".$_POST['txtDigitoVerificacion']."',                    
                '".$_POST['sltEmpresaSegOriCap']."',                                        
                '".$_POST['sltGrupoEconom']."',
                '".$_POST['sltCodMunicipio']."',                
                '".$empresaTipEst."',
                '".$_POST['sltEmpresaSegCap']."',                
                '".$_POST['txtNombreEmpresa']."',                
                '".$_POST['txtSigla']."',                    
                '".$_POST['txtDireccion']."',                    
                '".$_POST['txtTelefono']."',                    
                '".$_POST['txtCorreo']."',                    
                '".$_POST['txtPaginaWeb']."',                        
                '".$_POST['txtNumeroTrabajaEmpr']."',                    
                '".$_POST['txtNumeroAfiliadosSindicato']."',    
                '".$_POST['txtObservaciones']."'
                ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresEmpresa(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                      
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaEmpresa', $parametros);
   }
   
   /*
    * Eliminación de registro por rut
    */
   public function EliminarEmpresa($rut)
   {
        $datosAuditoria = $this->Auditoria($rut, "EL");
        $rpta = $this->procedimientos_model->SetProcedure("empresa_eliminar","'$rut'", $datosAuditoria);        
        
        $parametros = $this->ObtenerListaValoresEmpresa(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaEmpresa', $parametros);  
    }
    
    public function Auditoria($rut, $tipoCreacionCambio)
    {
        $datosAuditoria['idRegistro'] = $rut;
        $datosAuditoria['idUsuario'] = $this->session->userdata('idUsuario');
        $datosAuditoria['tabla'] = $this->Tabla();
        $datosAuditoria['fecha'] = date('Y-m-d H:i:s');
        $datosAuditoria['tipo_creacion_cambio'] = $tipoCreacionCambio;
        $datosAuditoria['ip_usuario'] = $this->procedimientos_model->ObtenerIP();
        
        return $datosAuditoria;
    }
    
    public function Paginacion($parametros)
    {
        $this->ObtenerListaValoresEmpresa();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorEmpresa/index/1/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }    
    
   /*
    * Consulta detallada por rut
    */
   public function ConsultarEmpresa($rut, $consultar = "")
   {
        $registro = $this->procedimientos_model->GetProcedure("empresa_seleccionar_por_rut","'$rut'");
        $claseContrato = $this->procedimientos_model->GetProcedure("empresa_clase_contrato_seleccionar_por_rut","'$rut'");
        $parametros = $this->ObtenerListaValoresEmpresa();
        $parametros['registros'] = $registro;
        $parametros['claseContrato'] = $claseContrato;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaEmpresa', $parametros);
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
        $objSheet->setTitle('DatosEmpresa');

        //Se obtiene la data del reporte   
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaEmpresas = $this->procedimientos_model->GetProcedure("empresa_seleccionar","");
       else
           $registrosConsultaEmpresas = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$this->session->userdata('registroSindical')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('RUT'));
        $objSheet->getCell('B1')->setValue(utf8_encode('NOMBRE'));
        $objSheet->getCell('C1')->setValue(utf8_encode('SIGLA'));
        $objSheet->getCell('D1')->setValue(utf8_encode('PÁGINA WEB'));
        $objSheet->getCell('E1')->setValue(utf8_encode('DEPARTAMENTO'));
        $objSheet->getCell('F1')->setValue(utf8_encode('MUNICIPIO'));
        $objSheet->getCell('G1')->setValue(utf8_encode('DIRECCIÓN'));
        $objSheet->getCell('H1')->setValue(utf8_encode('TELÉFONO'));
        $objSheet->getCell('I1')->setValue(utf8_encode('AÑO CREACIÓN'));
            
        foreach($registrosConsultaEmpresas as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['rut'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['sigla'])));    
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['pagina_web'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['departamento'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['municipio'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['direccion'])));
            $objSheet->getCell('H'.$i)->setValue(utf8_encode(utf8_decode($registro['telefonos'])));
            $objSheet->getCell('I'.$i)->setValue(utf8_encode(utf8_decode($registro['anyo'])));
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
        $objSheet->getColumnDimension('I')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:I'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/Empresa.xlsx');               
        header('Location: /temp/Empresa.xlsx');
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
           $pdf->Cabecera('LISTADO DE EMPRESAS', '', 125);
       else
           $pdf->Cabecera('INFORMACIÓN DE EMPRESA', '', 125);
               
        //Defino el ancho de cada columna
        $w = array(22, 35, 21, 33, 30, 24, 38, 27, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('RUT', 'NOMBRE', 'SIGLAS', 'PAGINA WEB', 'DEPARTAMENTO', 'MUNICIPIO', 'DIRECCION', 'TELEFONO', 'AÑO DE CREACION');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaEmpresas = $this->procedimientos_model->GetProcedure("empresa_seleccionar","");
       else
           $registrosConsultaEmpresas = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$this->session->userdata('registroSindical')."'");
       
        foreach($registrosConsultaEmpresas as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["rut"]), 
                            utf8_decode($registro["nombre"]), 
                            utf8_decode($registro["sigla"]), 
                            utf8_decode($registro["pagina_web"]), 
                            utf8_decode($registro["departamento"]), 
                            utf8_decode($registro["municipio"]), 
                            utf8_decode($registro["direccion"]), 
                            utf8_decode($registro["telefonos"]),
                            utf8_decode($registro["anyo"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
    
   /*
    * Validar rut existente
    */
   public function ValidarRut($rut)
   {           
       $existe = $this->procedimientos_model->GetProcedure("empresa_validar_rut","'$rut'");          
       
       if($existe[0]['count'] > 0)
        echo 'El RUT ya existe, escriba uno nuevo.';       
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresEmpresa($ordenamiento = 1, $pagina = 1, $rut = "")
   {   
       if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaEmpresas = $this->procedimientos_model->GetProcedure("empresa_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$rut."'");
       else
           $registrosConsultaEmpresas = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$this->session->userdata('registroSindical')."'");
       
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $clasificaEconoEmpr = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CLASIFICAECONOSINDIC'");
       $grupoEconoEmpr = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'GRUPOECONOMICO'");
       $empresaSegOriCap = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EMPRSEGUNORIGENCAPI'");
       $empresaSegCap = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'EMPRESASEGUNCAPITAL'");
       $empresaTipEst = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPOEMPRESAESTATAL'");
       $conteoTotal = $this->procedimientos_model->GetProcedure("empresa_seleccionar_conteo_total","");                     
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'registroSindical' => $this->session->userdata('registroSindical'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaEmpresa = array(  
                    'registros' => $registrosConsultaEmpresas,
                    'departamentos' => $departamentos,
                    'municipios' => $municipios,
                    'clasificaEconoEmpr' => $clasificaEconoEmpr,
                    'grupoEconoEmpr' => $grupoEconoEmpr,
                    'empresaSegOriCap' => $empresaSegOriCap,
                    'empresaSegCap' => $empresaSegCap,
                    'empresaTipEst' => $empresaTipEst,
                    'conteoTotal' => $conteoTotal,
                    'usuario'=> $usuario
                );
       
       return $datosVistaEmpresa;
   }
}