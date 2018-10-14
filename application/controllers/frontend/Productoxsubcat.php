<?php
class Productoxsubcat extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Productoxsubcat_model');
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
            $data['seccion'] = 'productosxsubcat'; 
            $data['idCat'] = $this->uri->segment(2);       
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            $id_subcategoria = $this->uri->segment(2);
            $auxSubCategoria = $this->Productoxsubcat_model->getSubCategoria($id_subcategoria);
            $id_categoria = $auxSubCategoria->id_categoria;
            $auxCategoria = $this->Productoxsubcat_model->getCategoria($id_categoria);
            $nombre_categoria = $auxCategoria->nombre_categoria;
            
            $categorias = $this->Productoxsubcat_model->getCategorias();
            // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
            $listaCategorias = array();
            foreach($categorias as $auxCategoria)
            {
                $auxCats = array();
                $auxCats['id_categoria'] = $auxCategoria->id_categoria;
                $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
                $listaSubcategorias = $this->Productoxsubcat_model->getListaSubCategorias($auxCategoria->id_categoria);
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
            $data2['id_cat_current'] = $id_categoria;
            $data2['id_subcat_current'] = $id_subcategoria;
            $data2['categorias'] = $listaCategorias;
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); 
            
            //********* CONTENIDO DERECHO **************/
            $dataPrincipal['id_categoria'] = $id_categoria;
            $dataPrincipal['id_subcategoria'] =$id_subcategoria;
            $dataPrincipal['url_nombre'] = $this->uri->segment(3);
            $nombre_subcategoria = $auxSubCategoria->nombre;
            $dataPrincipal['nombre_categoria'] = $nombre_categoria;
            $dataPrincipal['nombre_subcategoria'] = $nombre_subcategoria;
            $productos_x_pagina = getConfig('productos_x_pagina');
            $pagina_actual = $this->uri->segment(4);
            $dataPrincipal['pagina_actual'] = $pagina_actual;
            $inicio = ($pagina_actual - 1)*$productos_x_pagina;
            $dataPrincipal['numero_paginas'] = $this->Productoxsubcat_model->getNumPaginas($productos_x_pagina,$id_subcategoria);
            $aux3 = $this->Productoxsubcat_model->getListaProductos($id_subcategoria, $inicio, $productos_x_pagina);
            $productos = array();
            $numeroProductos = 0; 
            foreach($aux3 as $producto)
            {
                $aux4 = array();
                $aux4['id_producto'] = $producto->id_producto;
                $aux_producto = $this->Productoxsubcat_model->getProducto($producto->id_producto);
                $aux4['nombre'] = $aux_producto->nombre;
                $aux4['imagen'] = $aux_producto->imagen;
                $aux4['codigo'] = $aux_producto->codigo;
                $aux4['orden'] = $aux_producto->orden;
                $aux4['tipo'] = $aux_producto->tipo; 
                $aux4['actualizacion'] = $aux_producto->actualizacion;
                $aux4['url_nom'] = formateaCadena($aux_producto->nombre);
                //$productos[] = implode("##", $aux4);
                $productos[] = $aux4;
                $numeroProductos++;
            }
            $dataPrincipal['numero_productos'] = $numeroProductos;
            $dataPrincipal["productos"] = $productos;
                
            $dataPrincipal['cuerpo'] = 'productosxsubcat';
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
        
      
}
?>