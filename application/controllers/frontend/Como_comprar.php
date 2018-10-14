<?php
class Como_comprar extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Como_comprar_model');
	}
	function index()
	{
            // GENERAL
            $data2=array();
            $dato3=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = 'como-comprar';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // INFO DE LA SECCION
            $dato3['banners']= getBanners();
            $dataPrincipal['banners']= $this->load->view('frontend/includes/banner', $dato3, true);            
            $data2['categorias'] = $this->Como_comprar_model->getCategorias();
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true);
            $dataPrincipal['como_comprar'] = getInfo("como-comprar");            
            $dataPrincipal['cuerpo'] = 'como_comprar';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
}
?>