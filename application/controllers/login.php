<?php 
/*
 * Controlador Login con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{	
    public function __construct()
    {
       parent::__construct();
       $this->load->model('procedimientos_model');
       $this->load->library(array('session','form_validation'));
       $this->load->helper(array('url','form'));
       $this->load->library('form_validation');
    }
  
    function index()
    {
       switch ($this->session->userdata('perfil')) {
            case '':
                $data['token'] = $this->token();
                $data['titulo'] = 'Login con roles de usuario en codeigniter';
                $this->load->view('login',$data);
                break;
            case 'Administracion':
                redirect('controladorInicio');
                break;
            case 'editor':
                redirect(base_url().'editor');
                break;    
            case 'suscriptor':
                redirect(base_url().'suscriptor');
                break;
            default:                        
                redirect('controladorInicio');
                break;        
        }
   }

    public function ValidaUsuario()
    {
        $rutEmpresa = 0;
        
        if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
        {
            $this->form_validation->set_rules('txtUsuario', 'nombre de usuario', 'required|trim|min_length[2]|max_length[150]|xss_clean');
            $this->form_validation->set_rules('txtPassword', 'password', 'required|trim|min_length[5]|max_length[150]|xss_clean');
 
            //lanzamos mensajes de error si es que los hay            
            if($this->form_validation->run() == FALSE)            
                $this->index();
            else
            {
                $username = $this->input->post('txtUsuario');
                $password = sha1($this->input->post('txtPassword'));
                $usuario = $this->procedimientos_model->LoginUsuario($username,$password);
                
                if(isset($usuario['rutSindicato']))
                {
                    $datosEmpresa = $this->procedimientos_model->GetProcedure("sindicato_empresa_seleccionar_por_rut","'".$usuario['rutSindicato']."'");
                    
                    if(count($datosEmpresa) > 0)
                    {
                        if($usuario['nombre_grupo'] != 'Administracion')
                            $rutEmpresa = $datosEmpresa[0]['empresa_rut'];
                    }
                    else
                        $rutEmpresa = '';
                }
                else
                    $rutEmpresa = '';
                
                if(count($usuario) > 0)
                {                    
                    $data = array(
                    'esLogueado' => TRUE,
                    'idUsuario' => $usuario['id_usuario'],
                    'perfil' => $usuario['nombre_grupo'],
                    'usuario' => $usuario['login_usuario'],
                    'rutEmpresa' => $rutEmpresa,    
                    'registroSindical' => $usuario['rutSindicato'],
                    'registroFederacion' => $usuario['registro_sindicalFederacion'],
                    'registroSeccional' => $usuario['registro_sindicalSeccional']
                    );                    
                    
                    $this->session->set_userdata($data);
                    $this->index();
                }
            }
        }
        else        
            redirect('login');        
    }
    
    public function Token()
    {
        $token = md5(uniqid(rand(),true));
        $this->session->set_userdata('token', $token);
        return $token;
    }
    
    public function Logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}