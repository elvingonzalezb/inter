<?php
class Catalogo extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Catalogo_model');
	}
	function index()
	{
            // GENERALES
            $theme = $this->config->item('frontend_theme');
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['theme'] = $theme; 
            $dataPrincipal['header'] = $this->load->view('frontend/includes/header', $data, true);
            $data2['seccion'] = 'catalogo';
            $data2['direccion'] = getConfig("direccion");
            $dataPrincipal['menu'] = $this->load->view('frontend/includes/menu', $data2, true);
            $data2['categorias'] = $this->Inicio_model->getCategorias(0, 6);
            $data2['categorias2'] = $this->Inicio_model->getCategorias(6, 6);
            $dataPrincipal['footer'] = $this->load->view('frontend/includes/footer', $data2, true);
            // CATALOGO
            $dataPrincipal['theme'] = $theme;
            $dataPrincipal['listacats'] = $this->Catalogo_model->getListaCategorias();
            $this->load->view('frontend/catalogo', $dataPrincipal);
            //echo 'hola mundo 4';
        }
}
?>