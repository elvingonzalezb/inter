<?php
class Informativa extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Informativa_model');
	}
	function index()
	{
		// GENERALES
		$theme = $this->config->item('frontend_theme');
		$data['twitter'] = getConfig('enlace_twitter');
		$data['facebook'] = getConfig('enlace_facebook');
		$data['theme'] = $theme; 
		$dataPrincipal['header'] = $this->load->view('frontend/includes/header', $data, true);
		$data2['seccion'] = 'quienes-somos';
		$data2['direccion'] = getConfig("direccion");
		$dataPrincipal['menu'] = $this->load->view('frontend/includes/menu', $data2, true);
		$data2['categorias'] = $this->Inicio_model->getCategorias(0, 6);
		$data2['categorias2'] = $this->Inicio_model->getCategorias(6, 6);
		$dataPrincipal['footer'] = $this->load->view('frontend/includes/footer', $data2, true);
		// INFORMATIVA
		$dataPrincipal['theme'] = $theme;
		$dataPrincipal['cuadros'] = $this->Inicio_model->getCuadros();
		$dataPrincipal['clientes'] = $this->Inicio_model->getClientes();
		$dataPrincipal['contenido'] = $this->Informativa_model->getContenido('quienes-somos');
		$this->load->view('frontend/informativa', $dataPrincipal);
	}
}
?>