<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validacion {
    var $CI;
    public function  __construct() {
        $this->CI =& get_instance();
    }

    public function validacion_login(){
        if(!$this->CI->session->userdata('registrado'))
        {
            $url = base_url().'mainpanel';
            redirect($url);
        }
    }
    
    public function validacion_login_frontend(){
        if(!$this->CI->session->userdata('logueadocki'))
        {
            $url = base_url().'ingresar';
            redirect($url);
        }
    }    
    
}
?>
