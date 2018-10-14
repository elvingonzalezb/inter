<?php
class Categoria extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Catalogo_model');
		$this->load->model('frontend/Categoria_model');
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
		// CATEGORIA
		$dataPrincipal['theme'] = $theme;
		$dataPrincipal['listacats'] = $this->Catalogo_model->getListaCategorias();
		$id_categoria = $this->uri->segment(2);
		$dataPrincipal['id_categoria'] = $id_categoria;
		$dataPrincipal['nombre_categoria'] = $this->Categoria_model->getNombreCategoria($id_categoria);
		$productos_x_pagina = getConfig('productos_x_pagina');
		$dataPrincipal['numero_paginas'] = $this->Categoria_model->getNumPaginas($id_categoria, $productos_x_pagina);
		$dataPrincipal['url'] = $this->uri->segment(3);
		$pagina_actual = $this->uri->segment(4);
		$dataPrincipal['pagina_actual'] = $pagina_actual;
		$dataPrincipal['productos'] = $this->Categoria_model->getProductos($id_categoria, $pagina_actual, $productos_x_pagina);
		$this->load->view('frontend/categoria', $dataPrincipal);
	}
}
?>