<?php 
/*
 * Controlador Convenios Colectivos con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 13/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorConvenioColectivo extends CI_Controller
{
       static function Tabla()
   {
        return "convenio colectivo";
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
    * 
    */
   function index($ordenamiento = 26)
   {  
       if($this->session->userdata('esLogueado') == FALSE)        
            redirect('login');
       
        $id_convenio_colectivo = "";
                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;        
        $parametros = $this->ObtenerListaValoresEmpresa($ordenamiento, $desde, $id_convenio_colectivo);                       
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorConvenioColectivo/index/'.$ordenamiento.'/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
                
        $parametros['paginacion'] = $this->pagination->create_links();              
                

       $this->load->view('vistaConvenio', $parametros);                   
   }
   
   /*
    * 
    */
   function ConsultarConvenio($id_convenio_colectivo, $consultar = "")
   {        
        $registro = $this->procedimientos_model->GetProcedure("convenio_seleccionar_por_id","'$id_convenio_colectivo'");
        $parametros = $this->ObtenerListaValoresEmpresa();
        $parametros['registros'] = $registro;
        $parametros['consultar'] = $consultar;
        
        $this->load->view('vistaConvenio', $parametros);
     }
  
   /*
    * 
    */
   public function AdicionarConvenio()
   {   
        if(isset($_POST['txtIndiqModaliIncreAdic']))
            $indiqModaliIncre = $_POST['txtIndiqModaliIncreAdic'];
        else
            $indiqModaliIncre = "";                            
        
        if(isset($_POST['sltPorcAcuerLaboralAdic']))
            $porcAcuerLaboralAdic = $_POST['sltPorcAcuerLaboralAdic'];
        else
            $porcAcuerLaboralAdic = "";                                            
        
        if(isset($_POST['txtOtroPorcAcuerLaboralAdic']))
            $otroPorcAcuerLaboral = $_POST['txtOtroPorcAcuerLaboralAdic'];
        else
            $otroPorcAcuerLaboral = "";               
        
        if(isset($_POST['txtCualOtroPeriodoFirmaAdic']))
            $cualOtroPeriodoFirma = $_POST['txtCualOtroPeriodoFirmaAdic'];
        else
            $cualOtroPeriodoFirma = "";         
       
        $empresa = $_POST['sltEmpresaFirmaConvenioAdic'];
        $datosAuditoria = $this->Auditoria($empresa, "AD");              
        $rpta = $this->procedimientos_model->SetProcedure("convenio_insertar",
                "'',
                '".$porcAcuerLaboralAdic."',  
                '".$_POST['sltModaliIncremSalarialAdic']."',                
                '".$_POST['sltDireccTerriAdic']."',   
                '".$empresa."',                    
                '".$_POST['sltEstaPagoAuxConvAdic']."',
                '".$_POST['sltPeriodoFirmaConvenAdic']."',                
                '".$_POST['sltMunicipioAdic']."',                    
                '".$_POST['sltConvenioAcuerdoLaboEstatalAdic']."',                    
                '".$_POST['txtFechaInicioConvenioAdic']."',                    
                '".$_POST['txtFechaFinalizConvenioAdic']."',                    
                '".$_POST['txtTiemVigenConvenioAdic']."',                        
                '".$_POST['txtNumeroTrabaBenefiAdic']."',                    
                '".$_POST['txtNumeroTrabaNoBenefiAdic']."',                    
                '".$cualOtroPeriodoFirma."',                        
                '".$_POST['txtFechaConvocaTribArbiAdic']."',                        
                '".$_POST['txtFechaResolTribArbiAdic']."',                    
                '".$_POST['txtMesesDuracTribuArbitraAdic']."',                    
                '".$_POST['txtInspeTrabaAdic']."',                    
                '".$indiqModaliIncre."',     
                '".$_POST['txtValorIncreModaAnyoVigenciaAdic']."',                    
                '".$_POST['txtMontoCuantiAuxCentrAdic']."',                    
                b'".$_POST['rdbProrrConvColecAdic']."',
                b'".$_POST['rdbAuxConvenCentralAdic']."',
                '".$otroPorcAcuerLaboral."',                                      
                '".date('Y')."'
                ", $datosAuditoria);

        $parametros = $this->ObtenerListaValoresEmpresa(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);             
       
       if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaConvenio', $parametros);
    }
    
   public function ModificarConvenio()
   {  
        if(isset($_POST['txtIndiqModaliIncre']))
            $indiqModaliIncre = $_POST['txtIndiqModaliIncre'];
        else
            $indiqModaliIncre = "";                            

        if(isset($_POST['sltPorcAcuerLaboral']))
            $porcAcuerLaboralAdic = $_POST['sltPorcAcuerLaboral'];
        else
            $porcAcuerLaboralAdic = "";                                    
        
        if(isset($_POST['txtOtroPorcAcuerLaboral']))
            $otroPorcAcuerLaboral = $_POST['txtOtroPorcAcuerLaboral'];
        else
            $otroPorcAcuerLaboral = "";               
        
        if(isset($_POST['txtCualOtroPeriodoFirma']))
            $cualOtroPeriodoFirma = $_POST['txtCualOtroPeriodoFirma'];
        else
            $cualOtroPeriodoFirma = "";                 
        
        $empresa = $_POST['sltEmpresaFirmaConvenio'];
        $datosAuditoria = $this->Auditoria($empresa, "MO");                     
        $rpta = $this->procedimientos_model->SetProcedure("convenio_modificar",
                "'".$_POST['idConvenio']."',
                '".$porcAcuerLaboralAdic."',
                '".$_POST['sltModaliIncremSalarial']."',                
                '".$_POST['sltDireccTerri']."',                    
                '".$empresa."',                    
                '".$_POST['sltEstaPagoAuxConv']."',
                '".$_POST['sltPeriodoFirmaConven']."',                
                '".$_POST['sltCodMunicipio']."',                    
                '".$_POST['sltConvenioAcuerdoLaboEstatal']."',                    
                '".$_POST['txtFechaInicioConvenio']."',                    
                '".$_POST['txtFechaFinalizConvenio']."',                    
                '".$_POST['txtTiemVigenConvenio']."',                        
                '".$_POST['txtNumeroTrabaBenefi']."',                    
                '".$_POST['txtNumeroTrabaNoBenefi']."',                    
                '".$cualOtroPeriodoFirma."',                         
                '".$_POST['txtFechaConvocaTribArbi']."',                    
                '".$_POST['txtFechaResolTribArbiArbi']."',                    
                '".$_POST['txtMesesDuracTribuArbitra']."',                    
                '".$_POST['txtInspeTraba']."',                        
                '".$indiqModaliIncre."',     
                '".$_POST['txtValorIncreModaAnyoVigencia']."',                    
                '".$_POST['txtMontoCuantiAuxCentr']."',                    
                b'".$_POST['rdbProrrConvColec']."',                    
                b'".$_POST['rdbAuxConvenCentral']."',                    
                '".$otroPorcAcuerLaboral."',                         
                '".$_POST['anyo']."'
                ", $datosAuditoria);
        
        $parametros = $this->ObtenerListaValoresEmpresa(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);             
       
       if(!$rpta)           
           $parametros['estadoModificar'] = false;
       else
           $parametros['estadoModificar'] = true;
                  
       $this->load->view('vistaConvenio', $parametros);
   }        
   
   /*
    * 
    */
   function EliminarConvenio($id)
   {
        $datosAuditoria = $this->Auditoria($id, "EL");       
        $rpta = $this->procedimientos_model->SetProcedure("convenio_eliminar","'$id'", $datosAuditoria);
                
        $parametros = $this->ObtenerListaValoresEmpresa(1, 0, "");
        $parametros['paginacion'] = $this->Paginacion($parametros);                        
        
        if(!$rpta)           
           $parametros['estadoEliminar'] = false;
        else
           $parametros['estadoEliminar'] = true;
       
        $this->load->view('vistaConvenio', $parametros); 
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
        $this->ObtenerListaValoresEmpresa();                
        $opciones = array();
        $desde = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $opciones['per_page'] = 10;
        $opciones['base_url'] = '/index.php/controladorConvenioColectivo/index/26/';
        $opciones['total_rows'] = $parametros['conteoTotal'][0]['total'];
        $opciones['uri_segment'] = 4;

        $this->pagination->initialize($opciones);
        
        return $this->pagination->create_links();
    }        
    
   /*
    * 
    */

        
   /*
    * Consulta detallada por rut
    */
   public function ConsultarEmpresaPorRut($rut)
   {  
        $registroEmpresa = $this->procedimientos_model->GetProcedure("empresa_seleccionar_por_rut","'$rut'");        
        
        if(isset($registroEmpresa[0]['sigla']))
            $sigla = $registroEmpresa[0]['sigla'];
        else
            $sigla =  '';
        
        if(isset($registroEmpresa[0]['descripcion_departamento']))
            $departamento = $registroEmpresa[0]['descripcion_departamento'];
        else
            $departamento =  '';
        
        if(isset($registroEmpresa[0]['descripcion_municipio']))
            $municipio = $registroEmpresa[0]['descripcion_municipio'];
        else
            $municipio =  '';
        
        if(isset($registroEmpresa[0]['direccion']))
            $direccion = $registroEmpresa[0]['direccion'];
        else
            $direccion =  '';
        
        if(isset($registroEmpresa[0]['telefonos']))
            $telefonos = $registroEmpresa[0]['telefonos'];
        else
            $telefonos =  '';
        
        if(isset($registroEmpresa[0]['descripcion_clasificacion_economica']))
            $clasificacionEconomica = $registroEmpresa[0]['descripcion_clasificacion_economica'];
        else
            $clasificacionEconomica =  '';
        
        echo utf8_encode('<table align="left" width="500" cellpadding="4">                                                                          
                <tr>
                    <td align="left" class="tdFormulario">
                        <label>Sigla Empresa</label>
                    </td>
                    <td align="left" class="tdFormulario">
                        '.utf8_decode($sigla).'
                    </td>
                </tr>                                
                <tr>
                    <td align="left" class="tdFormulario">
                        <label>Departamento Sede Empresa</label>
                    </td>
                    <td align="left" class="tdFormulario">
                        '.utf8_decode($departamento).'
                    </td>
                </tr> 
                <tr>
                    <td align="left" class="tdFormulario">
                        <label>Municipio sede empresa</label>
                    </td>
                    <td align="left" class="tdFormulario">
                        '.utf8_decode($municipio).'
                    </td>
                </tr> 
                <tr>
                    <td align="left" class="tdFormulario">
                        <label>Dirección Sede Empresa</label>
                    </td>
                    <td align="left" class="tdFormulario">
                        '.utf8_decode($direccion).'
                    </td>
                </tr> 
                <tr>
                    <td align="left" class="tdFormulario">
                        <label>Teléfono de la empresa</label>
                    </td>
                    <td align="left" class="tdFormulario">
                        '.utf8_decode($telefonos).'
                    </td>
                </tr> 
                <tr>
                    <td align="left" class="tdFormulario">
                        <label>Clasificación Económica</label>
                    </td>
                    <td align="left" class="tdFormulario">
                        '.utf8_decode($clasificacionEconomica).'
                    </td>
                </tr> 
            </table>');
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
        $objSheet->setTitle('DatosConvenioColectivo');

        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar","");
        else
           $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar_por_empresa","'".$this->session->userdata('registroSindical')."'");
        
        $i = 2;
        
        //Titulos
        $objSheet->getCell('A1')->setValue(utf8_encode('EMPRESA CON LA CUAL SE FIRMA EL CONVENIO'));
        $objSheet->getCell('B1')->setValue(utf8_encode('FECHA INICIO CONVENIO'));
        $objSheet->getCell('C1')->setValue(utf8_encode('FECHA FINALIZACIÓN CONVENIO'));
        $objSheet->getCell('D1')->setValue(utf8_encode('MUNICIPIO SEDE EMPRESA'));
        $objSheet->getCell('E1')->setValue(utf8_encode('DIRECCIÓN SEDE EMPRESA'));
        $objSheet->getCell('F1')->setValue(utf8_encode('TELÉFONO SEDE EMPRESA'));
        $objSheet->getCell('G1')->setValue(utf8_encode('AÑO CREACIÓN'));
            
        foreach($registrosConsultaConvenio as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['empresa_nombre'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_inicio_convenio'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_finalizacion_convenio'])));    
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['departamento'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['municipio'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['telefonos'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['anyo_creacion'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:G1')->getFont()->setBold(true)->setSize(10);
        
        // Se ajusta el ancho automatico
        $objSheet->getColumnDimension('A')->setAutoSize(true);
        $objSheet->getColumnDimension('B')->setAutoSize(true);
        $objSheet->getColumnDimension('C')->setAutoSize(true);
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);
        $objSheet->getColumnDimension('F')->setAutoSize(true);
        $objSheet->getColumnDimension('G')->setAutoSize(true);
        
        //Se genera bordes de la tabla
        $objSheet->getStyle('A1:G'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A2:G'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/ConveniosColectivos.xlsx');               
        header('Location: /temp/ConveniosColectivos.xlsx');
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
        $pdf->Cabecera('LISTADO DE CONVENIOS COLECTIVOS', '', 125);        
        //Defino el ancho de cada columna
        $w = array(48, 37, 37, 39, 41, 34, 29);
        $pdf->SetWidths($w);
        //Defino alineación de cada columna
        $align = array('C', 'C', 'C', 'L', 'L', 'L', 'C');
        $pdf->SetAligns($align);
        //Tabla con los titulos de columnas
        $header = array('EMPRESA FIRMA EL CONVENIO', 'FECHA INI. CONVENIO', 'FECHA FIN. CONVENIO', 'MUNICIPIO EMPRESA', 'DIRECCIÓN EMPRESA', 'TELÉFONO EMPRESA', 'AÑO CREACIÓN');
        $pdf->Titulo($header,$w);
        //Se obtiene la data del reporte
        if($this->session->userdata('perfil') == 'Administracion')
           $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar","");
        else
           $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar_por_empresa","'".$this->session->userdata('registroSindical')."'");
               
        foreach($registrosConsultaConvenio as $registro)
        {               
            $pdf->Row(array(utf8_decode($registro["empresa_nombre"]), 
                            utf8_decode($registro["fecha_inicio_convenio"]), 
                            utf8_decode($registro["fecha_finalizacion_convenio"]), 
                            utf8_decode($registro["departamento"]), 
                            utf8_decode($registro["municipio"]), 
                            utf8_decode($registro["telefonos"]),
                            utf8_decode($registro["anyo_creacion"])));
        }
        //Imprimo el archivo final
        $pdf->Output();        
        @ob_end_flush();    //fin de buffer
   }
   
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresEmpresa($ordenamiento = 26, $pagina = 1, $id_convenio_colectivo = "")
   {   
       if($this->session->userdata('perfil') == 'Administracion')          
          $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar_principal","'".$ordenamiento."', '".$pagina."', '".$id_convenio_colectivo."'");       
       else
           $registrosConsultaConvenio = $this->procedimientos_model->GetProcedure("convenio_seleccionar_por_empresa","'".$this->session->userdata('registroSindical')."'");
       
       $departamentos = $this->procedimientos_model->GetProcedure("departamento_seleccionar","");
       $municipios = $this->procedimientos_model->GetProcedure("municipio_seleccionar","");
       $sindicaFirmanConvenio = $this->procedimientos_model->GetProcedure("convenio_sindicato_seleccionar","");       
       
       if($this->session->userdata('perfil') == 'Administracion')
           $empresaFirmaConvenio = $this->procedimientos_model->GetProcedure("empresa_seleccionar_por_rut_nombre","");
       else
           $empresaFirmaConvenio = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$this->session->userdata('registroSindical')."'");
       
       $siglaEmpresa = $this->procedimientos_model->GetProcedure("convenio_seleccionar","");
       $direccion = $this->procedimientos_model->GetProcedure("convenio_seleccionar","");
       $clasificaEcono = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'CLASIFICAECONOSINDIC'");
       $convenioAcuerdoLaboEstatal = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'TIPACULABORAESTATAL'");
       $periodoFirmaConven = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'PERIODOFIRMCONVENIO'");
       $direccTerri = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'DIRECCTERRITORIAL'");
       $modaliIncremSalarial = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'INCREMENTOSALARIAL'");
       $estaPagoAuxConv = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'ESTADOPAGOAUXILIO'");
       $prcAcuerLaboral = $this->procedimientos_model->GetProcedure("tipo_generico_seleccionar_por_categoria","'PORCEARTICULCONVEN'");
       $conteoTotal = $this->procedimientos_model->GetProcedure("Convenio_seleccionar_conteo_total","");                     
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'usuario' => $this->session->userdata('usuario'));
       
       $datosVistaConvenio = array(
                    'registros' => $registrosConsultaConvenio,
                    'departamentos' => $departamentos,
                    'municipios' => $municipios,
                    'sindicaFirmanConvenio' => $sindicaFirmanConvenio,
                    'empresaFirmaConvenio'=> $empresaFirmaConvenio,
                    'siglaEmpresa'=> $siglaEmpresa,
                    'direccion'=> $direccion,
                    'clasificaEcono'=> $clasificaEcono,
                    'convenioAcuerdoLaboEstatal'=> $convenioAcuerdoLaboEstatal,
                    'periodoFirmaConven'=> $periodoFirmaConven,
                    'direccTerri'=> $direccTerri,
                    'modaliIncremSalarial'=> $modaliIncremSalarial,
                    'estaPagoAuxConv'=> $estaPagoAuxConv,
                    'prcAcuerLaboral'=> $prcAcuerLaboral,
                    'conteoTotal' => $conteoTotal,           
                    'usuario'=> $usuario
                );
       
       return $datosVistaConvenio;
   }      
}