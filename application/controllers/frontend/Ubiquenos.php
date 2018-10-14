<?php
class Ubiquenos extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('googlemaps/googlemaps');
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Ubiquenos_model');
	}
	function index()
	{
		// GENERALES
		$theme = $this->config->item('frontend_theme');
		$data['twitter'] = getConfig('enlace_twitter');
		$data['facebook'] = getConfig('enlace_facebook');
		$data['theme'] = $theme; 
		$dataPrincipal['header'] = $this->load->view('frontend/includes/header', $data, true);
		$data2['seccion'] = 'ubiquenos';
		$data2['direccion'] = getConfig("direccion");
		$dataPrincipal['menu'] = $this->load->view('frontend/includes/menu', $data2, true);
		$data2['categorias'] = $this->Inicio_model->getCategorias(0, 6);
		$data2['categorias2'] = $this->Inicio_model->getCategorias(6, 6);
		$dataPrincipal['footer'] = $this->load->view('frontend/includes/footer', $data2, true);
		// UBIQUENOS
		$dataPrincipal['theme'] = $theme;
		$dataPrincipal['contenido'] = $this->Ubiquenos_model->getContenido('ubiquenos');		
		$centro = $this->Ubiquenos_model->getCentro();		
		$config['center'] = $centro->latitud_centro.", ".$centro->longitud_centro;
		$config['zoom'] = 14;
		$config['map_height'] = 600;
		$config['map_width'] = 950;
		$this->googlemaps->initialize($config);
		$dataPrincipal['centro'] = $centro->latitud_centro.", ".$centro->longitud_centro;
		$ubicaciones = $this->Ubiquenos_model->getUbicaciones();
		foreach($ubicaciones as $ubicacion)
		{
			$marker = array();
			$marker['position'] = $ubicacion->latitud_punto.", ".$ubicacion->longitud_punto;	
			$marker['infowindow_content'] = $ubicacion->texto_globo;
			$marker['animation'] = 'DROP';
			$this->googlemaps->add_marker($marker);
		}
		$dataPrincipal['map'] = $this->googlemaps->create_map();
		$this->load->view('frontend/ubiquenos', $dataPrincipal);
	}
}
?>