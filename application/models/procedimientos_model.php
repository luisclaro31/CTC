<?php
class Procedimientos_model extends CI_Model
{
    //Constructor para método de procedimientos almacenados
    public function __construct(){ parent::__construct(); }
    
    //Función para ejecutar un procedimiento
    public function SetProcedure($procedure, $parameters, $datosAuditoria = "")
    {
        $sql = $this->db->query("CALL $procedure($parameters)");
         
        if($sql)
        {
    //Función para imprimir
             $error = $this->db->_error_message();
            
            if(!empty($error))
                return false;
            
            if(@!empty($datosAuditoria['idUsuario']))
                $this->AdicionarAuditoria($datosAuditoria);
        
            $sql->next_result();
            $sql->free_result();
            return true;
        }
        else
        {
             $error = $this->db->_error_message();            
            //echo $error;
            
            if(!empty($error))
                return false;
                        
            $sql->next_result();
            $sql->free_result();
            return false;
         }
     }
     
     //Obtiene los resultados de un procedimiento almacenado
     public function GetProcedure($procedure,$parameters)
     {
         $sql = $this->db->query("CALL $procedure ($parameters);");
         
         $error = $this->db->_error_message();
            
         if(!empty($error))
             return null;

         $rows = $sql->result_array();
         $sql->next_result();
         $sql->free_result();         
         return $rows;
     }
     
     public function LoginUsuario($username, $password)
     {
        $sql = $this->db->query("CALL usuario_validar_login('$username', '$password');");
        
        $regristro = $sql->result_array();
        $sql->next_result();
        $sql->free_result();   
        
        if(count($regristro) > 0)
            if($regristro[0]['estado_codigo'] != 'INACTIVOUSUARIO')
                return $regristro[0];
            else
            {
                $this->session->set_flashdata('usuario_incorrecto','Cuenta inactiva. Por favor comuniquese con un administrador.');
                redirect('login','refresh');
            }
        else
        {
            $this->session->set_flashdata('usuario_incorrecto','Usuario o contraseña incorrecta');
            redirect('login','refresh');
        }
     }
     
     private function AdicionarAuditoria($datosAuditoria)
     {
        $sql = $this->db->query("CALL auditoria_insertar('".$datosAuditoria['idUsuario']."',
                                                         '".$datosAuditoria['tabla']."',
                                                         '".$datosAuditoria['fecha']."',
                                                         '".$datosAuditoria['tipo_creacion_cambio']."',
                                                         '".$datosAuditoria['ip_usuario']."',
                                                         '".$datosAuditoria['idRegistro']."')");         
        if($sql)
        {
            $sql->next_result();
            $sql->free_result();
            return true;
        }
        else
        {
            $sql->next_result();
            $sql->free_result();
            return false;
         }
     }
     
     public function ObtenerIP()
     { 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))        
            return $_SERVER["HTTP_CLIENT_IP"];        
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))        
            return $_SERVER["HTTP_X_FORWARDED_FOR"];        
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))        
            return $_SERVER["HTTP_X_FORWARDED"];        
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))        
            return $_SERVER["HTTP_FORWARDED_FOR"];        
        elseif (isset($_SERVER["HTTP_FORWARDED"]))        
            return $_SERVER["HTTP_FORWARDED"];        
        else        
            return $_SERVER["REMOTE_ADDR"];        
    }    
}
?>