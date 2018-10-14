<?php
class Informativa extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Informativa_model');
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function edit() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="informativa/index_view";
        // EDITAR INFORMATIVA
        $seccion = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $contenido= $this->Informativa_model->getContenido($seccion);
        $dataPrincipal["titulo_seccion"] = $contenido->titulo;
        $dataPrincipal["texto_seccion"] = $contenido->texto;
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["seccion"] = $seccion;        
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        $titulo = $this->input->post('titulo');
        $texto = $this->input->post('texto');
        $seccion = $this->input->post('seccion');
        $data = array('titulo'=>$titulo, 'texto'=>$texto);
        $resultado = $this->Informativa_model->updateSeccion($seccion, $data);
        redirect('mainpanel/informativa/edit/'.$seccion.'/success');
    }
}
?>