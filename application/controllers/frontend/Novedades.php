<?php
class Novedades extends CI_Controller {
	function __construct()
	{
		parent::__construct();
                $this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Novedad_model');
                $this->load->library('Validacion'); 
	}
	function index()
	{
            // GENERAL
            $this->validacion->validacion_login_frontend();
            $data2=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = 'novedades';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
            $categorias = $this->Inicio_model->getCategorias();
            $listaCategorias = array();
            foreach($categorias as $auxCategoria)
            {
                $auxCats = array();
                $auxCats['id_categoria'] = $auxCategoria->id_categoria;
                $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
                $listaSubcategorias = $this->Inicio_model->getListaSubCategorias($auxCategoria->id_categoria);
                $subcategoriasItem = array();
                foreach($listaSubcategorias as $subcategoria)
                {
                    $auxSubCats = array();
                    $auxSubCats['id_subcategoria'] = $subcategoria->id_subcategoria;
                    $auxSubCats['nombre'] = $subcategoria->nombre;
                    $subcategoriasItem[] = $auxSubCats;
                }
                $auxCats['subcategorias'] = $subcategoriasItem;
                $listaCategorias[] = $auxCats;
            }
            $data2['id_cat_current'] = 0;
            $data2['id_subcat_current'] = 0;
            $data2['categorias'] = $listaCategorias;
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true);             
            
            // INFO DE LA SECCION            
            $novedades_x_pagina = getConfig('novedades_x_pagina');
            $pagina_actual = $this->uri->segment(2);
            $dataPrincipal['pagina_actual'] = $pagina_actual;
            $dataPrincipal['numero_paginas'] = $this->Novedad_model->getNumPaginas($novedades_x_pagina);   
            $aux = $this->Novedad_model->listProdNov($pagina_actual, $novedades_x_pagina);
            $productos = array();
            foreach($aux as $producto)
            {
                $aux2 = array();
                $aux2['id_producto'] = $producto->id_producto;                                
                $aux2['nombre'] = $producto->nombre;
                $aux2['imagen'] = $producto->imagen;
                $aux2['codigo'] = $producto->codigo;				
                $aux2['url_nom'] = formateaCadena($producto->nombre);
                $productos[] = $aux2;
            }            
            $dataPrincipal['productos'] = $productos;            
            $dataPrincipal['novedades'] = getInfo("novedades");
            $dataPrincipal['cuerpo'] = 'novedades';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
        
}
?>