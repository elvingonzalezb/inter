<?php
class Acerca extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Acerca_model');
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
            $data['seccion'] = 'acerca-nosotros';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // INFO DE LA SECCION
            $dato3['banners']= getBanners();
            $dataPrincipal['banners']= $this->load->view('frontend/includes/banner', $dato3, true);            
            $data2['categorias'] = $this->Acerca_model->getCategorias();
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true);
            $dataPrincipal['acerca_nosotros'] = getInfo("acerca-nosotros");            
            $dataPrincipal['cuerpo'] = 'acerca';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
}
?>