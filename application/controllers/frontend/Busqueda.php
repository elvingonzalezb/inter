<?php
class Busqueda extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Busqueda_model');
        $this->load->library('Validacion');                
	}
	function index()
	{
            // GENERAL
			$this->session->unset_userdata('nombre');
			$this->session->unset_userdata('codigo');
			$this->session->unset_userdata('categoria');
			
            $this->validacion->validacion_login_frontend();            
            $data2=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = 'busqueda';            
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
            
            $productos_x_pagina = getConfig('productos_x_pagina');
            $dataPrincipal['cuerpo'] = 'busqueda';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
	
	function buscar()
	{
            // GENERAL
            $this->validacion->validacion_login_frontend();            
            $data2=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = 'busqueda';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // LISTAR CATEGORIAS
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
			
			//****************************
			$nombre=$this->input->post('nombre');
			$codigo = $this->input->post('codigo');	
			$categoria = $this->input->post('categoria');
			$oculto= $this->input->post('oculto');			

			
			if($oculto=='oculto'){
				$this->session->set_userdata('nombre', $nombre);
			}else{
				$nombre=$this->session->userdata('nombre');
			}
		
			if($oculto=='oculto'){
				$this->session->set_userdata('codigo', $codigo);
			}else{
				$codigo=$this->session->userdata('codigo');
			}

			if($oculto=='oculto'){
				$this->session->set_userdata('categoria', $categoria);
			}else{
				$categoria=$this->session->userdata('categoria');
			}

//$nombre = $this->input->post('nombre');
//$codigo= $this->input->post('codigo');
//$categoria = $this->input->post('categoria');			
            
            $productos_x_pagina = getConfig('productos_x_pagina');
            $pagina_actual = $this->uri->segment(3);
            $dataPrincipal['pagina_actual'] = $pagina_actual;
            $dataPrincipal['numero_paginas'] = $this->Busqueda_model->getNumPaginas($nombre,$codigo,$categoria,$productos_x_pagina);
			


            $aux= $this->Busqueda_model->listProd($nombre,$codigo,$categoria,$pagina_actual, $productos_x_pagina);
            $productos = array();
            foreach($aux as $producto)
            {
                $aux2 = array();
                $id_producto= $producto->id_producto;                
                $aux2['id_producto'] = $id_producto;
                $aux2['colores'] = $this->Busqueda_model->listColores($id_producto);
                $aux2['nombre'] = $producto->nombre;
                $aux2['imagen'] = $producto->imagen;
                $aux2['codigo'] = $producto->codigo;				
                $aux2['url_nom'] = formateaCadena($producto->nombre);
                $productos[] = $aux2;
            }            
            $dataPrincipal['productos'] = $productos;            
            $dataPrincipal['cuerpo'] = 'busqueda';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}	
        
}
?>