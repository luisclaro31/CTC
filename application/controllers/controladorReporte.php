<?php 
/*
 * Controlador Empresa con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 12/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorReporte extends CI_Controller
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
       
       $parametros = $this->ObtenerListaValoresReporte();        
       $this->load->view('vistaReporte', $parametros);
   }
   
   /*
    * 
    */
   public function GenerarReporte()
   {          
       $this->GenerarExcel($_POST['sltOrdernarPor'], $_POST['sltTabla'], $_POST['sltCampo'], 
                            $_POST['sltOperador'], $_POST['txtCondicion']);
   }
   
   /*
    * Generación de excel
    */
   public function GenerarExcel($ordernarPor, $tabla, $campo, $operador, $condicion)
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
        $objSheet->setTitle('DatosTabla');

        //Se obtiene la data del reporte           
        $registrosConsultaTabla = $this->procedimientos_model->GetProcedure("reporte_seleccionar_por_tabla",
                "'".strtolower($ordernarPor)."',
                '".strtolower($tabla)."',                    
                '".$campo."',
                '".$operador."',                
                '".$condicion."'");
        
        //Titulos
        $columnas = $this->procedimientos_model->GetProcedure("columnas_seleccionar_por_tabla","'".strtolower($tabla)."'");        
        $j = 1;
        $i = 65;
        
        foreach($columnas as $columna)
        {
            if($columna['codigo'] != 'contrasena')
            {
                if($i > 90)
                {
                    $k = 65;
                    $letra = strtoupper(chr($k));
                    $objSheet->getCell("A".$letra.$j)->setValue(utf8_encode($columna['codigo']));
                    $k++;
                }
                else
                {
                    $letra = strtoupper(chr($i));            
                    $objSheet->getCell($letra.$j)->setValue(utf8_encode($columna['codigo']));
                }            
                $i++;
            }
        }
                        
        $i = 65;
        $j = 2;
        foreach($registrosConsultaTabla as $registro)        
        {               
            $i = 65;
            
            foreach($columnas as $columna)
            {
                if($columna['codigo'] != 'contrasena')
                {
                    if($i > 90)
                    {
                        $k = 65;
                        $letra = strtoupper(chr($k));
                        $objSheet->getCell("A".$letra.$j)->setValue(utf8_encode(utf8_decode($registro[$columna['codigo']])));                                    
                        $k++;
                    }
                    else
                    {
                        $letra = strtoupper(chr($i));            
                        $objSheet->getCell($letra.$j)->setValue(utf8_encode(utf8_decode($registro[$columna['codigo']])));
                    }            
                    $i++;
                }
            }
            $j++;
        }
        
        /*
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A1:I'.$j)->getFont()->setBold(true)->setSize(10);
        
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
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);*/

        // Se guarda el archivo
        $objWriter->save('temp/ReporteTabla.xlsx');               
        header('Location: /temp/ReporteTabla.xlsx');
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
        $pdf->Cabecera('LISTADO DE EMPRESAS', '', 125);        
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
        $registrosConsultaEmpresa = $this->procedimientos_model->GetProcedure("empresa_seleccionar","");
        
        foreach($registrosConsultaEmpresa as $registro)
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
    * Se obtienen municipios por código de departmento.
    */
   public function ObtenerTablaPorColumna($columna)
   {
       $columnas = $this->procedimientos_model->GetProcedure("columnas_seleccionar_por_tabla","'$columna'");
       
       echo '<option value="">Seleccionar </option>';
       
       foreach($columnas as $dato)
        echo '<option value="'.$dato['codigo'].'">'.utf8_encode(utf8_decode($dato['descripcion'])).'</option>';
   }

   /*
    * Edad Afiliado
    */      
   
   public function GenerarExcelReporte($numeroReporte)
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
        
        //Generar Grafica 
        $this->numeroReporte($numeroReporte);        
        
        // Se inserta la imagen del reporte 
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Reporte');
        $objDrawing->setDescription('Grafica Reporte CTC');
        $objDrawing->setPath('archivos/reporte/reporte.png');
        $objDrawing->setHeight(300);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());        
        
        // Se renombra la hoja
        $objSheet->setTitle('DatosReporteAfiliados');

        //Se obtiene la data del reporte   
        if($this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 0 || $this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 2 || $this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 3)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados","");
        else if($this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' && $numeroReporte == 0 || $this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' && $numeroReporte == 2 || $this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' && $numeroReporte == 3)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_x_sindicato","'".$this->session->userdata('registroSindical')."'");        
        else if($this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' && $numeroReporte == 0 || $this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' && $numeroReporte == 2 || $this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' && $numeroReporte == 3)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_x_federacion","'".$this->session->userdata('registroFederacion')."'");                
        else if($this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' && $numeroReporte == 0 || $this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' && $numeroReporte == 2 || $this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' && $numeroReporte == 3)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_x_Seccional","'".$this->session->userdata('registroSeccional')."'");                        
        else if ($this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 1)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_seleccionar","");
        else if ($this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' && $numeroReporte == 1)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_seleccionar_x_sindicato","'".$this->session->userdata('registroSindical')."'");        
        else if ($this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' && $numeroReporte == 1)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_seleccionar_x_federacion","'".$this->session->userdata('registroFederacion')."'");                
        else if ($this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' && $numeroReporte == 1)
           $registrosReporte = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_seleccionar_x_seccional","'".$this->session->userdata('registroSeccional')."'");                        
        
        
        $i = 19;
        
        //Titulos
        $objSheet->getCell('A18')->setValue(utf8_encode('Cedula'));
        $objSheet->getCell('B18')->setValue(utf8_encode('Nombres Apellidos'));
        $objSheet->getCell('C18')->setValue(utf8_encode('Fecha Nacimiento'));
        $objSheet->getCell('D18')->setValue(utf8_encode('Edad'));
        $objSheet->getCell('E18')->setValue(utf8_encode('Dirección'));
        $objSheet->getCell('F18')->setValue(utf8_encode('Teléfonos'));
        $objSheet->getCell('G18')->setValue(utf8_encode('Celular'));
        $objSheet->getCell('H18')->setValue(utf8_encode('Correo'));
        $objSheet->getCell('I18')->setValue(utf8_encode('Facebook'));
        $objSheet->getCell('J18')->setValue(utf8_encode('Twiter'));
        $objSheet->getCell('K18')->setValue(utf8_encode('Comuna Localidad Corregimiento'));
        $objSheet->getCell('L18')->setValue(utf8_encode('Fecha Ingreso Empresa'));
        $objSheet->getCell('M18')->setValue(utf8_encode('Sede Lugar Región Donde labora'));
        $objSheet->getCell('N18')->setValue(utf8_encode('Salario Básico'));
        $objSheet->getCell('O18')->setValue(utf8_encode('Eps'));
        $objSheet->getCell('P18')->setValue(utf8_encode('Fondo Pensiones'));
        $objSheet->getCell('Q18')->setValue(utf8_encode('Fondo Cesantías'));
        $objSheet->getCell('R18')->setValue(utf8_encode('Arl'));
        $objSheet->getCell('S18')->setValue(utf8_encode('Caja Compensación'));
        $objSheet->getCell('T18')->setValue(utf8_encode('Fecha Ingreso Sindicato'));
        $objSheet->getCell('U18')->setValue(utf8_encode('Fecha Retiro Sindicato'));
        $objSheet->getCell('V18')->setValue(utf8_encode('Motivo Retiro Sindicato'));
        $objSheet->getCell('W18')->setValue(utf8_encode('Otra Organización Social'));
        $objSheet->getCell('X18')->setValue(utf8_encode('Otro Sindicato Afiliación'));
        $objSheet->getCell('Y18')->setValue(utf8_encode('Porcentaje Valor Cuota Sindical'));
        $objSheet->getCell('Z18')->setValue(utf8_encode('Nombre Título Profesional'));
        $objSheet->getCell('AA18')->setValue(utf8_encode('Nombre Estudia'));
	$objSheet->getCell('AB18')->setValue(utf8_encode('Numero de Hijos'));
        $objSheet->getCell('AC18')->setValue(utf8_encode('Numero de Hijos Preescolar'));
        $objSheet->getCell('AD18')->setValue(utf8_encode('Numero de Hijos Primaria'));
        $objSheet->getCell('AE18')->setValue(utf8_encode('Numero de Hijos Secundaria'));
        $objSheet->getCell('AF18')->setValue(utf8_encode('Numero de Hijos Técnica'));
        $objSheet->getCell('AG18')->setValue(utf8_encode('Numero de Hijos Tecnología'));
        $objSheet->getCell('AH18')->setValue(utf8_encode('Numero de Hijos Universidad'));
        $objSheet->getCell('AI18')->setValue(utf8_encode('Entidad Préstamo Vivienda'));
        $objSheet->getCell('AJ18')->setValue(utf8_encode('Numero Personas a Cargo'));
        $objSheet->getCell('AK18')->setValue(utf8_encode('Horas Laboradas Semana'));
        $objSheet->getCell('AL18')->setValue(utf8_encode('Practica Deportes'));
        $objSheet->getCell('AM18')->setValue(utf8_encode('Delegado Asamblea'));
        $objSheet->getCell('AN18')->setValue(utf8_encode('Integrante Copaso'));
        $objSheet->getCell('AO18')->setValue(utf8_encode('Integrante Comité Convivencia'));
        $objSheet->getCell('AP18')->setValue(utf8_encode('Estudia Actualmente'));
        $objSheet->getCell('AQ18')->setValue(utf8_encode('Capacitación Sindical'));
        $objSheet->getCell('AR18')->setValue(utf8_encode('Pertenece Otro Sindicato'));
        $objSheet->getCell('AS18')->setValue(utf8_encode('Crédito Vivienda'));        
        $objSheet->getCell('AT18')->setValue(utf8_encode('Cargo Junta Directiva'));        
        $objSheet->getCell('AU18')->setValue(utf8_encode('Modalidad Contrato Empleado Publico'));        
        $objSheet->getCell('AV18')->setValue(utf8_encode('Organización Social'));        
        $objSheet->getCell('AW18')->setValue(utf8_encode('Nombre Empresa'));        
        $objSheet->getCell('AX18')->setValue(utf8_encode('Municipio Residencia'));        
        $objSheet->getCell('AY18')->setValue(utf8_encode('Municipio Nacimiento'));        
        $objSheet->getCell('AZ18')->setValue(utf8_encode('Municipio Donde Labora'));        
        $objSheet->getCell('BA18')->setValue(utf8_encode('Tipo Afiliado'));        
        $objSheet->getCell('BB18')->setValue(utf8_encode('Tipo Vivienda'));        
        $objSheet->getCell('BC18')->setValue(utf8_encode('Nivel Educativo'));        
        $objSheet->getCell('BD18')->setValue(utf8_encode('Miembro Junta Directiva'));        
        $objSheet->getCell('BE18')->setValue(utf8_encode('Condición Afiliación'));        
        $objSheet->getCell('BF18')->setValue(utf8_encode('Salario Básico x Rangos'));        
        $objSheet->getCell('BG18')->setValue(utf8_encode('Tipo Servidor Público'));        
        $objSheet->getCell('BH18')->setValue(utf8_encode('Duración Contrato laboral'));        
        $objSheet->getCell('BI18')->setValue(utf8_encode('Modalidad Contrato'));        
        $objSheet->getCell('BJ18')->setValue(utf8_encode('Cargo Sector Publico'));        
        $objSheet->getCell('BK18')->setValue(utf8_encode('Cargo Empresa Privada'));                
        $objSheet->getCell('BL18')->setValue(utf8_encode('Estado Civil'));                
        $objSheet->getCell('BM18')->setValue(utf8_encode('Genero'));         
        $objSheet->getCell('BN18')->setValue(utf8_encode('Año Creación'));

            
        foreach($registrosReporte as $registro)        
        {   
            //Valores
            $objSheet->getCell('A'.$i)->setValue(utf8_encode(utf8_decode($registro['cedula'])));
            $objSheet->getCell('B'.$i)->setValue(utf8_encode(utf8_decode($registro['nombres_apellidos'])));
            $objSheet->getCell('C'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_nacimiento'])));    
            $objSheet->getCell('D'.$i)->setValue(utf8_encode(utf8_decode($registro['edad'])));
            $objSheet->getCell('E'.$i)->setValue(utf8_encode(utf8_decode($registro['direccion'])));
            $objSheet->getCell('F'.$i)->setValue(utf8_encode(utf8_decode($registro['telefonos'])));
            $objSheet->getCell('G'.$i)->setValue(utf8_encode(utf8_decode($registro['celular'])));
            $objSheet->getCell('H'.$i)->setValue(utf8_encode(utf8_decode($registro['correo'])));
            $objSheet->getCell('I'.$i)->setValue(utf8_encode(utf8_decode($registro['usuario_facebook'])));
            $objSheet->getCell('J'.$i)->setValue(utf8_encode(utf8_decode($registro['usuario_Twiter'])));
            $objSheet->getCell('K'.$i)->setValue(utf8_encode(utf8_decode($registro['comuna_localidad_corregimiento'])));
            $objSheet->getCell('L'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_ingreso_empresa'])));
            $objSheet->getCell('M'.$i)->setValue(utf8_encode(utf8_decode($registro['sede_lugar_region_donde_labora'])));
            $objSheet->getCell('N'.$i)->setValue(utf8_encode(utf8_decode($registro['salario_basico'])));
            $objSheet->getCell('O'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_eps'])));
            $objSheet->getCell('P'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_fondo_pensiones'])));
            $objSheet->getCell('Q'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_fondo_cesantias'])));
            $objSheet->getCell('R'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_arl'])));
            $objSheet->getCell('S'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_caja_compensacion'])));
            $objSheet->getCell('T'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_ingreso_sindicato'])));
            $objSheet->getCell('U'.$i)->setValue(utf8_encode(utf8_decode($registro['fecha_retiro_sindicato'])));
            $objSheet->getCell('V'.$i)->setValue(utf8_encode(utf8_decode($registro['motivo_retiro_sindicato'])));
            $objSheet->getCell('W'.$i)->setValue(utf8_encode(utf8_decode($registro['otra_organizacion_social'])));
            $objSheet->getCell('X'.$i)->setValue(utf8_encode(utf8_decode($registro['otro_sindicato_afiliacion'])));
            $objSheet->getCell('Y'.$i)->setValue(utf8_encode(utf8_decode($registro['porcentaje_valor_cuota_sindical'])));
            $objSheet->getCell('Z'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_titulo_profesional'])));
            $objSheet->getCell('AA'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_estudia'])));
            $objSheet->getCell('AB'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos'])));
            $objSheet->getCell('AC'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos_preescolar'])));
            $objSheet->getCell('AD'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos_primaria'])));
            $objSheet->getCell('AE'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos_secundaria'])));
            $objSheet->getCell('AF'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos_tecnica'])));
            $objSheet->getCell('AG'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos_tecnologia'])));
            $objSheet->getCell('AH'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_hijos_universidad'])));
            $objSheet->getCell('AI'.$i)->setValue(utf8_encode(utf8_decode($registro['entidad_prestamo_vivienda'])));
            $objSheet->getCell('AJ'.$i)->setValue(utf8_encode(utf8_decode($registro['numero_personas_a_cargo'])));
            $objSheet->getCell('AK'.$i)->setValue(utf8_encode(utf8_decode($registro['horas_laboradas_semana'])));
            $objSheet->getCell('AL'.$i)->setValue(utf8_encode(utf8_decode($registro['practica_deportes'])));
            $objSheet->getCell('AM'.$i)->setValue(utf8_encode(utf8_decode($registro['delegado_asamblea'])));
            $objSheet->getCell('AN'.$i)->setValue(utf8_encode(utf8_decode($registro['integrante_copaso'])));
            $objSheet->getCell('AO'.$i)->setValue(utf8_encode(utf8_decode($registro['integrante_comite_convivencia'])));
            $objSheet->getCell('AP'.$i)->setValue(utf8_encode(utf8_decode($registro['estudia_actualmente'])));
            $objSheet->getCell('AQ'.$i)->setValue(utf8_encode(utf8_decode($registro['capacitacion_sindical'])));
            $objSheet->getCell('AR'.$i)->setValue(utf8_encode(utf8_decode($registro['pertenece_otro_sindicato'])));            
            $objSheet->getCell('AS'.$i)->setValue(utf8_encode(utf8_decode($registro['credito_vivienda'])));            
            $objSheet->getCell('AT'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_cargo_jd'])));            
            $objSheet->getCell('AU'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_modalidad_contrato'])));            
            $objSheet->getCell('AV'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_organizacion_social'])));            
            $objSheet->getCell('AW'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_empresa'])));            
            $objSheet->getCell('AX'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_municipio_residencia'])));            
            $objSheet->getCell('AY'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_municipio_nacimiento'])));            
            $objSheet->getCell('AZ'.$i)->setValue(utf8_encode(utf8_decode($registro['nombre_municipio_donde_labora'])));            
            $objSheet->getCell('BA'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_tipo_afiliado'])));            
            $objSheet->getCell('BB'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_tipo_vivienda'])));            
            $objSheet->getCell('BC'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_nivel_educativo'])));            
            $objSheet->getCell('BD'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_miembro_junta_directiva'])));            
            $objSheet->getCell('BE'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_condicion_afiliacion'])));            
            $objSheet->getCell('BF'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_salario_basico_x_rangos'])));            
            $objSheet->getCell('BG'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_tipo_servidor_publico'])));            
            $objSheet->getCell('BH'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_duracion_contrato_laboral'])));            
            $objSheet->getCell('BI'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_modalidad_contrato'])));            
            $objSheet->getCell('BJ'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_cargo_sector_publico'])));            
            $objSheet->getCell('BK'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_cargo_empresa_privada'])));            
            $objSheet->getCell('BL'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_estado_civil'])));            
            $objSheet->getCell('BM'.$i)->setValue(utf8_encode(utf8_decode($registro['descripcion_genero'])));            
            $objSheet->getCell('BN'.$i)->setValue(utf8_encode(utf8_decode($registro['anyo'])));
            $i++;
        }
        
        // Se asigna los estilos de fuentes
        $objSheet->getStyle('A18:BN18')->getFont()->setBold(true)->setSize(10);
        
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
        $objSheet->getStyle('A18:BN'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objSheet->getStyle('A18:BN'.($i - 1))->getBorders()->
        getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Se guarda el archivo
        $objWriter->save('temp/reporteAfiliados.xlsx');               
        header('Location: /temp/reporteAfiliados.xlsx');
        @ob_end_flush();    //fin de buffer
   }      
   
   /*
    * Grafica php
    */   
   
   public function numeroReporte($numeroReporte)
   {

        if ($this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 0) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados","");
                $menor = $this->procedimientos_model->GetProcedure("obtieneMenorA35","");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['menorA35'];                
                $this->GraficaReporte($numeroReporte, $uno, $dos);                    
        } else if ($numeroReporte == 0 && $this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $menor = $this->procedimientos_model->GetProcedure("obtieneMenorA35_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['menorA35'];                
                $this->GraficaReporte($numeroReporte, $uno, $dos);                    
        } else if ($numeroReporte == 0 && $this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $menor = $this->procedimientos_model->GetProcedure("obtieneMenorA35_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['menorA35'];                
                $this->GraficaReporte($numeroReporte, $uno, $dos);                    
        } else if ($numeroReporte == 0 && $this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $menor = $this->procedimientos_model->GetProcedure("obtieneMenorA35_x_Seccional","'".$this->session->userdata('registroSeccional')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['menorA35'];                
                $this->GraficaReporte($numeroReporte, $uno, $dos);                    
        } else if ($this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 1) {
                $mayor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_total","");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_cargo_directivo_total","");
                $uno = $mayor[0]['genero_femenino_total'];
                $dos = $menor[0]['genero_femenino_cargo_directivo_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);
            
        } else if ($numeroReporte == 1 && $this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' ) {
                $mayor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_total_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_cargo_directivo_total_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $uno = $mayor[0]['genero_femenino_total'];
                $dos = $menor[0]['genero_femenino_cargo_directivo_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);
            
        } else if ($numeroReporte == 1 && $this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' ) {
                $mayor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_total_x_Federacion","'".$this->session->userdata('registroFederacion')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_cargo_directivo_total_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $uno = $mayor[0]['genero_femenino_total'];
                $dos = $menor[0]['genero_femenino_cargo_directivo_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);
            
        } else if ($numeroReporte == 1 && $this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' ) {
                $mayor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_total_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_genero_femenino_cargo_directivo_total_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $uno = $mayor[0]['genero_femenino_total'];
                $dos = $menor[0]['genero_femenino_cargo_directivo_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);
            
        } else if ($this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 2) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados","");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_educacion_nivel_superior_total","");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['educacion_nivel_superior_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($numeroReporte == 2 && $this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_educacion_nivel_superior_total_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['educacion_nivel_superior_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($numeroReporte == 2 && $this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_educacion_nivel_superior_total_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['educacion_nivel_superior_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($numeroReporte == 2 && $this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_educacion_nivel_superior_total_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['educacion_nivel_superior_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($this->session->userdata('perfil') == 'Administracion' && $numeroReporte == 3) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados","");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_capacitacion_sindical_total","");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['capacitacion_sindical_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($numeroReporte == 3 && $this->session->userdata('perfil') == 'Editor Sindicato' || $this->session->userdata('perfil') == 'Lector Sindicato' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_capacitacion_sindical_total_x_sindicato","'".$this->session->userdata('registroSindical')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['capacitacion_sindical_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($numeroReporte == 3 && $this->session->userdata('perfil') == 'Editor Federacion' || $this->session->userdata('perfil') == 'Lector Federacion' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_capacitacion_sindical_total_x_federacion","'".$this->session->userdata('registroFederacion')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['capacitacion_sindical_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } else if ($numeroReporte == 3 && $this->session->userdata('perfil') == 'Editor Seccional' || $this->session->userdata('perfil') == 'Lector Seccional' ) {
                $mayor = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $menor = $this->procedimientos_model->GetProcedure("afiliados_capacitacion_sindical_total_x_seccional","'".$this->session->userdata('registroSeccional')."'");
                $uno = $mayor[0]['total'];
                $dos = $menor[0]['capacitacion_sindical_total'];                            
                $this->GraficaReporte($numeroReporte, $uno, $dos);            
        } 
        
        //$mayorA35anyo = $this->procedimientos_model->GetProcedure("obtieneTotalAfiliados","");
        //$menorA35anyo = $this->procedimientos_model->GetProcedure("obtieneMenorA35","");        

   }   
   
   public function GraficaReporte($numeroReporte, $uno, $dos)        
    {
       include "application/libraries/libchart/classes/libchart.php";
       
       header("Content-type: image/png");       

	$chart = new PieChart(800, 250); 
        
        $dataSet = new XYDataSet();
        if ($numeroReporte == 0) {
            $dataSet->addPoint(new Point("Total de Afiliados ($uno)", $uno));
            $dataSet->addPoint(new Point("Menores de 35 ($dos)", $dos));	
            $chart->setDataSet($dataSet);
        }        
        else if ($numeroReporte == 1) {
            $dataSet->addPoint(new Point("Total de Afiliados Género Femenino ($uno)", $uno));
            $dataSet->addPoint(new Point("Afiliados Género Femenino Cargo Directivo ($dos)", $dos));	
            $chart->setDataSet($dataSet);
        }                
        else if ($numeroReporte == 2) {
            $dataSet->addPoint(new Point("Total de Afiliados ($uno)", $uno));
            $dataSet->addPoint(new Point("Afiliados con Educación Superior ($dos)", $dos));	
            $chart->setDataSet($dataSet);
        }                
        else if ($numeroReporte == 3) {
            $dataSet->addPoint(new Point("Total de Afiliados ($uno)", $uno));
            $dataSet->addPoint(new Point("Afiliados con Capacitación Sindical ($dos)", $dos));	
            $chart->setDataSet($dataSet);
        }                        
        
        if ($numeroReporte == 0) {
            $chart->setTitle("Porcentaje de Afiliados Menores de 35 años");                  
        }
        else if ($numeroReporte == 1){
            $chart->setTitle("Porcentaje de Afiliados Género Femenino");            
        }       
        else if ($numeroReporte == 2){
            $chart->setTitle("Porcentaje de Afiliados con Educación Superior");            
        }               
        else if ($numeroReporte == 3){
            $chart->setTitle("Porcentaje de Afiliados con Capacitación Sindical");            
        }                       
	
        //$chart->render();
	$chart->render("archivos/reporte/reporte.png");                        
    }   
   



   /*
    * Validar rut existente
    
   public function ValidarRut($rut)
   {           
       $existe = $this->procedimientos_model->GetProcedure("empresa_validar_rut","'$rut'");          
       
       if($existe[0]['count'] > 0)
        echo 'El RUT ya existe, escriba uno nuevo.';       
   }
   */
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresReporte()
   {    
       
       $tablas = $this->procedimientos_model->GetProcedure("tablas_seleccionar","");
       $operador = $this->procedimientos_model->GetProcedure("operador_logico_seleccionar","");                     
       $columna = $this->procedimientos_model->GetProcedure("columnas_seleccionar_por_tabla","'sindicato'");
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'rutSindicato' => $this->session->userdata('rutSindicato'),
                        'tablas' => $tablas,                    
                        'usuario' => $this->session->userdata('usuario'));                        

       $datosVistaReporte = array(                      
                    'tablas' => $tablas,                    
                    'operador' => $operador,
                    'columna' => $columna,
                    'usuario'=> $usuario
                );
       
       return $datosVistaReporte;
   }
}