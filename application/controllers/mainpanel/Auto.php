<?php
class Auto extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Auto_model');
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
        $contenido= $this->Auto_model->getContenido($seccion);
        $dataPrincipal["titulo_seccion"] = $contenido->titulo;
        $dataPrincipal["texto_seccion"] = $contenido->texto;
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["seccion"] = $seccion;        
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function inactivo30Dias() {
        $hoy=fecha_hoy_Ymd();
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $hoy ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $aux=$this->Auto_model->lista_clientes_dias($nuevafecha);        
        foreach ($aux as $value) {
            $email=$value->email;
            $data=array();
            $data['estado']='Inactivo';
            $this->Auto_model->updateCli30Dias($email,$data);
        }

    }
}
?>