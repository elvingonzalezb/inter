<?php
class Inicio extends CI_Controller {
    function __construct()
    {
            parent::__construct();
            $this->load->library('Validacion');
    }
    
    public function index()
    {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $data['no_visible_elements'] = false;
        $datos2['current_section'] = '';
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="admin_inicio";
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
}
?>
