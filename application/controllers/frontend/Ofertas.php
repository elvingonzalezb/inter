<?php
class Ofertas extends CI_Controller {
	function __construct()
	{
		parent::__construct();
                $this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Ofertas_model');
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
            $data['seccion'] = 'ofertas';            
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
            $ofertas_x_pagina = getConfig('ofertas_x_pagina');
            $pagina_actual = $this->uri->segment(2);
            $dataPrincipal['pagina_actual'] = $pagina_actual;
            $dataPrincipal['numero_paginas'] = $this->Ofertas_model->getNumPaginas($ofertas_x_pagina);   
            $aux = $this->Ofertas_model->listProdOfer($pagina_actual, $ofertas_x_pagina);
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
            $dataPrincipal['novedades'] = getInfo("ofertas");
            $dataPrincipal['cuerpo'] = 'ofertas';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
        
}
?>