<?php 
/*
 * Controlador Empresa con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 12/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorCargue extends CI_Controller
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
       
       $parametros = $this->ObtenerListaValoresCargue();        
       $this->load->view('vistaCargue', $parametros);
   }
   
   public function validacion()
   {
       $tabla   = strtolower($_POST['sltTabla']);
       
       switch ($tabla) 
       {
            case "afiliado":
                $this->importarExcelAfiliado();        
                break;
            case "convenio_colectivo":
                $this->importarExcelConvenio(); 
                break;            
            case "empresa":
                $this->importarExcelEmpresa(); 
                break;
            case "federacion":
                $this->importarExcelFederacion(); 
                break;
            case "sindicato":
                $this->importarExcelSindicato(); 
                break;            
            default:
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");
                
                $parametros['estadoValidar'] = true;
                
        $this->load->view('vistaCargue', $parametros);            
       }       
   }
   
//Importar desde Excel Afiliado
    public function importarExcelAfiliado(){
    	
        //Cargar PHPExcel library
        $this->load->library('Excel');
 
    	$name   = $_FILES['archivo']['name'];
     	$tname  = $_FILES['archivo']['tmp_name'];
 
        $obj_excel = PHPExcel_IOFactory::load($tname);       
       	$sheetData = $obj_excel->getActiveSheet()->  setTitle() -> toArray(null,true,true,true,true,true);
 
       	$arr_datos = array();
        
       	foreach ($sheetData as $index => $value) 
        {
            if($value['A'] != "" && $index != 1 )
            {
                if(is_numeric($value['A']) 
                   && is_numeric($value['E'])
                   && is_numeric($value['AU'])
                   && is_numeric($value['AV'])
                   && is_numeric($value['AW'])
                   && is_numeric($value['AX'])
                   && is_numeric($value['AY'])
                   && is_numeric($value['AZ'])
                   && is_numeric($value['BA'])
                   && is_numeric($value['BC'])
                   && is_numeric($value['BD'])
                   && is_numeric($value['BE'])
                   && is_numeric($value['BF'])
                   && is_numeric($value['BG'])
                   && is_numeric($value['BH'])
                   && is_numeric($value['BI'])
                   && is_numeric($value['BJ'])
                   && is_numeric($value['BK'])
                   && is_numeric($value['BL'])
                   && is_numeric($value['BM'])){
            $rpta = $this->procedimientos_model->SetProcedure("afiliado_insertar",
                    "'".$value['A']."',
                    '".$value['B']."',                    
                    '".$value['C']."',
                    '".$value['D']."',                           
                    '".$value['E']."',   
                    '".$value['F']."',                    
                    '".$value['G']."',
                    '".$value['H']."',                           
                    '".$value['I']."',   
                    '".$value['J']."',                    
                    '".$value['K']."',
                    '".$value['L']."',                           
                    '".$value['M']."',   
                    '".$value['N']."',                    
                    '".$value['O']."',
                    '".$value['P']."',                           
                    '".$value['Q']."',   
                    '".$value['R']."',                    
                    '".$value['S']."',
                    '".$value['T']."',   
                    '".$value['U']."',                    
                    '".$value['V']."',
                    '".$value['W']."',                           
                    '".$value['X']."',                           
                    '".$value['Y']."',                           
                    '".$value['Z']."',                        
                    '".$value['AA']."',
                    '".$value['AB']."',                    
                    '".$value['AC']."',
                    '".$value['AD']."',                           
                    '".$value['AE']."',   
                    '".$value['AF']."',                    
                    '".$value['AG']."',
                    '".$value['AH']."',                           
                    '".$value['AI']."',   
                    '".$value['AJ']."',                    
                    '".$value['AK']."',
                    '".$value['AL']."',                           
                    '".$value['AM']."',   
                    '".$value['AN']."',                    
                    '".$value['AO']."',
                    '".$value['AP']."',                           
                    '".$value['AQ']."',   
                    '".$value['AR']."',                    
                    '".$value['AS']."',
                    '".$value['AT']."',   
                    '".$value['AU']."',                    
                    '".$value['AV']."',
                    '".$value['AW']."',                           
                    '".$value['AX']."',                           
                    '".$value['AY']."',                           
                    '".$value['AZ']."',                                                
                    '".$value['BA']."',                                           
                    '".$value['BB']."',                    
                    '".$value['BC']."',
                    '".$value['BD']."',                           
                    '".$value['BE']."',   
                    '".$value['BF']."',                    
                    '".$value['BG']."',
                    '".$value['BH']."',                           
                    '".$value['BI']."',   
                    '".$value['BJ']."',                    
                    '".$value['BK']."',
                    '".$value['BL']."',                           
                    '".$value['BM']."'");           
            
        $parametros = $this->ObtenerListaValoresCargue(1, 0, "");
        
        if(!$rpta)           
           $parametros['estadoAdicionar'] = false;
        else
           $parametros['estadoAdicionar'] = true;
       
        $this->load->view('vistaCargue', $parametros);
                }
                
                
                else {
                    
                    $parametros = $this->ObtenerListaValoresCargue(1, 0, "");                
                    $parametros['estadoCampos'] = true;                

                    $this->load->view('vistaCargue', $parametros);        
                    }                

            }
       	}        

    }
   
//Importar desde Excel Empresa
    public function importarExcelEmpresa(){
    	
        //Cargar PHPExcel library
        $this->load->library('Excel');
 
    	$name   = $_FILES['archivo']['name'];
     	$tname  = $_FILES['archivo']['tmp_name'];
 
        $obj_excel = PHPExcel_IOFactory::load($tname);       
       	$sheetData = $obj_excel->getActiveSheet()->  setTitle() -> toArray(null,true,true,true,true,true);
 
       	$arr_datos = array();
        
       	foreach ($sheetData as $index => $value) 
        {
            if($value['A'] != "" && $index != 1 )
            {
                if(is_numeric($value['A'])
                   && is_numeric($value['B'])                        
                   && is_numeric($value['O'])
                   && is_numeric($value['Q'])){
                    $rpta = $this->procedimientos_model->SetProcedure("empresa_insertar",
                    "'".$value['A']."',
                    '".$value['B']."',                    
                    '".$value['C']."',
                    '".$value['D']."',                           
                    '".$value['E']."',   
                    '".$value['F']."',                    
                    '".$value['G']."',
                    '".$value['H']."',                           
                    '".$value['I']."',   
                    '".$value['J']."',                    
                    '".$value['K']."',
                    '".$value['L']."',                           
                    '".$value['M']."',   
                    '".$value['N']."',                    
                    '".$value['O']."',
                    '".$value['P']."',                        
                    '".$value['Q']."'"); 
                    
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");

                if(!$rpta)           
                   $parametros['estadoAdicionar'] = false;
                else
                   $parametros['estadoAdicionar'] = true;

                $this->load->view('vistaCargue', $parametros);                    
                }else {
                    
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");                
                $parametros['estadoCampos'] = true;                

                $this->load->view('vistaCargue', $parametros);        
                    }
            }
       	}
    }  

//Importar desde Excel Sindicato
    public function importarExcelSindicato(){
    	
        //Cargar PHPExcel library
        $this->load->library('Excel');
 
    	$name   = $_FILES['archivo']['name'];
     	$tname  = $_FILES['archivo']['tmp_name'];
 
        $obj_excel = PHPExcel_IOFactory::load($tname);       
       	$sheetData = $obj_excel->getActiveSheet()->  setTitle() -> toArray(null,true,true,true,true,true);
 
       	$arr_datos = array();
        
       	foreach ($sheetData as $index => $value) 
        {
            if($value['A'] != "" && $index != 1 )
            {
                if(is_numeric($value['A'])
                   && is_numeric($value['B'])
                   && is_numeric($value['R'])
                   && is_numeric($value['AE'])                        
                   && is_numeric($value['AF'])     
                   && is_numeric($value['AG'])
                   && is_numeric($value['AH'])
                   && is_numeric($value['AI'])
                   && is_numeric($value['AJ'])
                   && is_numeric($value['AK'])
                   && is_numeric($value['AQ'])                        
                   && is_numeric($value['AR'])                                                
                   && is_numeric($value['AS'])){                
            $rpta = $this->procedimientos_model->SetProcedure("sindicato_insertar",
                    "'".$value['A']."',
                    '".$value['B']."',                    
                    '".$value['C']."',
                    '".$value['D']."',                           
                    '".$value['E']."',   
                    '".$value['F']."',                    
                    '".$value['G']."',
                    '".$value['H']."',                           
                    '".$value['I']."',   
                    '".$value['J']."',                    
                    '".$value['K']."',
                    '".$value['L']."',                           
                    '".$value['M']."',   
                    '".$value['N']."',                    
                    '".$value['O']."',
                    '".$value['P']."',                           
                    '".$value['Q']."',   
                    '".$value['R']."',                    
                    '".$value['S']."',
                    '".$value['T']."',   
                    '".$value['U']."',                    
                    '".$value['V']."',
                    '".$value['W']."',                           
                    '".$value['X']."',                           
                    '".$value['Y']."',                           
                    '".$value['Z']."',                        
                    '".$value['AA']."',
                    '".$value['AB']."',                    
                    '".$value['AC']."',
                    '".$value['AD']."',                           
                    '".$value['AE']."',   
                    '".$value['AF']."',                    
                    '".$value['AG']."',
                    '".$value['AH']."',                           
                    '".$value['AI']."',   
                    '".$value['AJ']."',                    
                    '".$value['AK']."',
                    '".$value['AL']."',                           
                    '".$value['AM']."',   
                    '".$value['AN']."',                    
                    '".$value['AO']."',
                    '".$value['AP']."',                           
                    '".$value['AQ']."',   
                    '".$value['AR']."',                    
                    '".$value['AS']."'");           
            
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");

                if(!$rpta)           
                   $parametros['estadoAdicionar'] = false;
                else
                   $parametros['estadoAdicionar'] = true;

                $this->load->view('vistaCargue', $parametros);                    
                }else {
                    
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");                
                $parametros['estadoCampos'] = true;                

                $this->load->view('vistaCargue', $parametros);        
                    }            
            }
       	}
    }
    
//Importar desde Excel Federacion
    public function importarExcelFederacion(){
    	
        //Cargar PHPExcel library
        $this->load->library('Excel');
 
    	$name   = $_FILES['archivo']['name'];
     	$tname  = $_FILES['archivo']['tmp_name'];
 
        $obj_excel = PHPExcel_IOFactory::load($tname);       
       	$sheetData = $obj_excel->getActiveSheet()->  setTitle() -> toArray(null,true,true,true,true,true);
 
       	$arr_datos = array();
        
       	foreach ($sheetData as $index => $value) 
        {
            if($value['A'] != "" && $index != 1 )
            {
                if(is_numeric($value['A'])
                   && is_numeric($value['B'])     
                   && is_numeric($value['I'])){                                
            $rpta = $this->procedimientos_model->SetProcedure("federacion_insertar",
                    "'".$value['A']."',
                    '".$value['B']."',                    
                    '".$value['C']."',
                    '".$value['D']."',                           
                    '".$value['E']."',   
                    '".$value['F']."',                    
                    '".$value['G']."',
                    '".$value['H']."',                           
                    '".$value['I']."',   
                    '".$value['J']."',                    
                    '".$value['K']."',
                    '".$value['L']."',                           
                    '".$value['M']."',   
                    '".$value['N']."',                    
                    '".$value['O']."',
                    '".$value['P']."',                           
                    '".$value['Q']."',   
                    '".$value['R']."',                    
                    '".$value['S']."',
                    '".$value['T']."',   
                    '".$value['U']."',                    
                    '".$value['V']."',
                    '".$value['W']."',                           
                    '".$value['X']."',                           
                    '".$value['Y']."',
                    '".$value['Z']."'");           
            
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");

                if(!$rpta)           
                   $parametros['estadoAdicionar'] = false;
                else
                   $parametros['estadoAdicionar'] = true;

                $this->load->view('vistaCargue', $parametros);                    
                }else {
                    
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");                
                $parametros['estadoCampos'] = true;                

                $this->load->view('vistaCargue', $parametros);        
                    }                        
            }
       	}        

    }    
    
//Importar desde Excel Empresa
    public function importarExcelConvenio(){
    	
        //Cargar PHPExcel library
        $this->load->library('Excel');
 
    	$name   = $_FILES['archivo']['name'];
     	$tname  = $_FILES['archivo']['tmp_name'];
 
        $obj_excel = PHPExcel_IOFactory::load($tname);       
       	$sheetData = $obj_excel->getActiveSheet()->  setTitle() -> toArray(null,true,true,true,true,true);
 
       	$arr_datos = array();
        
       	foreach ($sheetData as $index => $value) 
        {

            if($value['A'] != "" && $index != 1 )
            {
                if(is_numeric($value['D'])
                   && is_numeric($value['K'])
                   && is_numeric($value['L'])
                   && is_numeric($value['M'])                        
                   && is_numeric($value['Q'])     
                   && is_numeric($value['V'])
                   && is_numeric($value['W'])
                   && is_numeric($value['X'])){                                
            $rpta = $this->procedimientos_model->SetProcedure("convenio_insertar",
                    "'',
                    '".$value['A']."',                                            
                    '".$value['B']."',                    
                    '".$value['C']."',
                    '".$value['D']."',                           
                    '".$value['E']."',   
                    '".$value['F']."',                    
                    '".$value['G']."',
                    '".$value['H']."',                           
                    '".$value['I']."',   
                    '".$value['J']."',                    
                    '".$value['K']."',
                    '".$value['L']."',                           
                    '".$value['M']."',   
                    '".$value['N']."',                    
                    '".$value['O']."',
                    '".$value['P']."',
                    '".$value['Q']."',                           
                    '".$value['R']."',   
                    '".$value['S']."',                    
                    '".$value['T']."',                        
                    '".$value['U']."',
                    '".$value['V']."',                           
                    '".$value['W']."',   
                    '".$value['X']."'");           
                    
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");

                if(!$rpta)           
                   $parametros['estadoAdicionar'] = false;
                else
                   $parametros['estadoAdicionar'] = true;

                $this->load->view('vistaCargue', $parametros);                    
                }else {
                    
                $parametros = $this->ObtenerListaValoresCargue(1, 0, "");                
                $parametros['estadoCampos'] = true;                

                $this->load->view('vistaCargue', $parametros);        
                    }            
            }
       	}
    }    
   
    
   /*
    * Listas de valores básicas
    */
   private function ObtenerListaValoresCargue()
   {           
 
       $usuario = array('perfil' => $this->session->userdata('perfil'),
                        'idUsuario' => $this->session->userdata('idUsuario'),
                        'rutSindicato' => $this->session->userdata('rutSindicato'),
                        'usuario' => $this->session->userdata('usuario'));                        

       $datosVistaCargue = array(                      
                    'usuario'=> $usuario
                );
       
       return $datosVistaCargue;
   }
}