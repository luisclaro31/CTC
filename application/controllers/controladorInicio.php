<?php 
/*
 * Controlador Inicio con metodos principales
 * Excellentiam S.E.
 * Fecha creacion: 17/09/14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controladorInicio extends CI_Controller
{   
    public function __construct() 
    {
        parent::__construct();
        $this->load->library(array('session','form_validation'));        
        $this->load->helper(array('url','form'));
    }
    
    public function index()
    {         
        if($this->session->userdata('esLogueado') == FALSE)        
            redirect('login');
                
        $data = array(                    
                    'usuario' => array('perfil' => $this->session->userdata('perfil'),
                                       'idUsuario' => $this->session->userdata('idUsuario'),
                                       'usuario' => $this->session->userdata('usuario'))
                    );
        $this->load->view('vistaInicio', $data);
    }
}