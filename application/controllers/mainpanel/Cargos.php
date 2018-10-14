<?php
class Cargos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Cargos_model');
        $this->load->library('My_upload');
        $this->load->library('My_PHPMailer');        
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function listado() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/unidades/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="cargos/index_view";
        // LISTA UNIDADES
        $aux = $this->Cargos_model->getListaCargos();
        $cargos = array();
        foreach($aux as $cargo)
        {
            $aux2 = array();
            $aux2['id'] = $cargo->id;
            $aux2['concepto'] = $cargo->concepto;
            $aux2['monto'] = $cargo->monto;            
            $aux2['estado'] = $cargo->estado; 
            $cargos[] = $aux2;
        }
        $dataPrincipal['cargos'] = $cargos;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
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
        $dataPrincipal["cuerpo"]="cargos/edit_view";
        // EDIT CLIENTE
        $id = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $cargo = $this->Cargos_model->getCargo($id);
        $dataPrincipal['cargo'] = $cargo;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR CLIENTE
        $id = $this->input->post('id');
        $concepto = $this->input->post('concepto');
        $monto = $this->input->post('monto');
        $estado= $this->input->post('estado');
        $data = array();
        $data['concepto']=$concepto;
        $data['monto']=$monto;
        $data['estado']=$estado;
        $this->Cargos_model->updateCargo($id, $data);
        redirect('mainpanel/cargos/edit/'.$id.'/success');
    }
    
    public function delete_cargo() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $this->Cargos_model->deleteCargo($id_registro);
        redirect('mainpanel/cargos/listado/success');
    }

    public function nuevo() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="cargos/nuevo_view";
        // NUEVA CATEGORIA
        $resultado = $this->uri->segment(4);
        if($resultado=="error")
        {
            $error = $this->uri->segment(5);
        }
        else
        {
            $error = '';
        }
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function grabar() {
        $this->validacion->validacion_login();
        // GRABAR CATEGORIA
        $concepto = $this->input->post('concepto');
        $monto = $this->input->post('monto');
        $estado = $this->input->post('estado');
        $data = array('concepto'=>$concepto, 'monto'=>$monto, 'estado'=>$estado);

        $resultado = $this->Cargos_model->grabarCargo($data);
        if($resultado==1)
        {
            redirect('mainpanel/cargos/listado/success');
        }
        else
        {
            redirect('mainpanel/cargos/nuevo/error/bd');
        }

    }
    
}
?>
