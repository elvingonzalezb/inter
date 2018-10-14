<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('mainpanel/Login_model');
        $this->load->helper('captcha');
	}
	public function index()
	{
            // GENERAL
            $theme = $this->config->item('admin_theme');
            $data['theme'] = $theme;
            #captcha
            $data['recaptcha'] = $this->recaptcha->render();
            $error = $this->uri->segment(2);
            if( isset($error) && (!empty($error)) )
            {
                $data['error'] = $this->uri->segment(3);
            }
            $this->load->view('mainpanel/login_view', $data);
	}
        
        public function validar() {
            // GENERAL
            $theme = $this->config->item('admin_theme');
            $data['theme'] = $theme;
            $data['no_visible_elements'] = false;
            $datos2['current_section'] = '';
            #captcha
            $data['recaptcha'] = $this->recaptcha->render();
            $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
            $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
            $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true);
            
            // PROCESAR LOGIN
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $recaptcha = $this->input->post('g-recaptcha-response');
            $response = $this->recaptcha->verifyResponse($recaptcha);

            if($response['success']){

                $existe = $this->Login_model->valida_usuario($username, $password);
                if($existe)
                {
                    $this->session->set_userdata('registrado', true);
                    $this->session->set_userdata('nombre_admin', $existe->nombre);
                    redirect('mainpanel/inicio');
                }else{
                    $user_correcto = $this->Login_model->userCorrecto($username);
                    if($user_correcto){
                        $this->session->set_flashdata('message', '<div class="form-group has-feedback"><div class="alert alert-danger">Contraseña incorrecta.</div></div>');
                    }else{
                        $this->session->set_flashdata('message', '<div class="form-group has-feedback"><div class="alert alert-danger">Usuario incorrecto.</div></div>'); 
                    }
                }
            }else{
                $this->session->set_flashdata('message', '<div class="form-group has-feedback"><div class="alert alert-warning">Re-captcha incorrecto.</div></div>');
            }
            redirect('mainpanel');
        }
        
        public function logout() {
            $this->session->unset_userdata('registrado');
            $this->session->unset_userdata('nombre_admin');
            $url= base_url()."mainpanel";
            redirect($url);
        }
}
?>