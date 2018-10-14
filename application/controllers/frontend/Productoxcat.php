<?php
class Productoxcat extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Productoxcat_model');
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
            $data['seccion'] = 'productoxcat'; 
            $data['idCat'] = $this->uri->segment(2);       
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            
            
            $id_categoria = $this->uri->segment(2);
            // LISTAR PRODUCTOS
            $categorias = $this->Productoxcat_model->getCategorias();
            // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
            $listaCategorias = array();
            $subcategorias = array();
            foreach($categorias as $auxCategoria)
            {
                $auxCats = array();
                $auxCats['id_categoria'] = $auxCategoria->id_categoria;
                $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
                $listaSubcategorias = $this->Productoxcat_model->getListaSubCategorias($auxCategoria->id_categoria);
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
            $data2['categorias'] = $listaCategorias;
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); 
            
            
            
            
            
            $dataPrincipal['id_categoria'] =$id_categoria;
            $dataPrincipal['url_nombre'] =$this->uri->segment(3);
            foreach ($categorias as $value) {
                if($value->id_categoria==$id_categoria){
                    $dataPrincipal['nombre_categoria'] = $value->nombre_categoria;
                }
            }
            $productos_x_pagina = getConfig('productos_x_pagina');
            $pagina_actual = $this->uri->segment(4);
            $dataPrincipal['pagina_actual'] = $pagina_actual;
            
            $aux = $this->Productoxcat_model->getListaSubCategorias($id_categoria);
            foreach($aux as $subcategoria)
            {
                $aux2 = array();
                $aux2['id_subcategoria'] = $subcategoria->id_subcategoria;
                $aux2['nombre'] = $subcategoria->nombre;
                //$aux2['numero_productos'] = $this->Productoxcat_model->numeroProductos($subcategoria->id_subcategoria);
                $aux2['orden'] = $subcategoria->orden;
                $aux2['estado'] = $subcategoria->estado;
                
                $aux3 = $this->Productoxcat_model->getListaProductos($subcategoria->id_subcategoria);
                $productos = array();
                $numeroProductos = 0; 
                foreach($aux3 as $producto)
                {
                    $aux4 = array();
                    $aux4['id_producto'] = $producto->id_producto;
                    /*
                    $aux4['nombre'] = $producto->nombre;
                    $aux4['imagen'] = $producto->imagen;
                    $aux4['codigo'] = $producto->codigo;
                    $aux4['orden'] = $producto->orden;
                    $aux4['tipo'] = $producto->tipo; 
                    $aux4['actualizacion'] = $producto->actualizacion;
                    $aux4['url_nom'] = formateaCadena($producto->nombre);
                    */
                    
                    $aux_producto = $this->Productoxcat_model->getProducto($producto->id_producto);
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
                //$aux2["productos"] = implode("@@", $productos);
                $aux2['numero_productos'] = $numeroProductos;
                $aux2["productos"] = $productos;
                $subcategorias[] = $aux2;
            }
            $dataPrincipal['subcategorias'] = $subcategorias; 
            $dataPrincipal['cuerpo'] = 'productosxcat';
            $this->load->view("frontend/includes/template", $dataPrincipal);
               
            /*
            $dataPrincipal['numero_paginas'] = $this->Productoxcat_model->getNumPaginas($productos_x_pagina,$id_categoria);
            $aux= $this->Productoxcat_model->listProd($pagina_actual, $productos_x_pagina,$id_categoria);
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
            $dataPrincipal['cuerpo'] = 'productosxcat';            
             */
	}
        
        function index_old()
	{
            // GENERAL
            $this->validacion->validacion_login_frontend();                        
            $data2=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = 'productoxcat'; 
			$data['idCat'] = $this->uri->segment(2);       
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // LISTAR PRODUCTOS
            $categorias = $this->Productoxcat_model->getCategorias();
            $data2['categorias']=$categorias;
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); 
            
            $id_categoria= $this->uri->segment(2);
            $dataPrincipal['id_categoria'] =$id_categoria;
            $dataPrincipal['url_nombre'] =$this->uri->segment(3);
            foreach ($categorias as $value) {
                if($value->id_categoria==$id_categoria){
                    $dataPrincipal['nombre_categoria'] = $value->nombre_categoria;
                }
            }
            $productos_x_pagina = getConfig('productos_x_pagina');
            $pagina_actual = $this->uri->segment(4);
            $dataPrincipal['pagina_actual'] = $pagina_actual;
            $dataPrincipal['numero_paginas'] = $this->Productoxcat_model->getNumPaginas($productos_x_pagina,$id_categoria);
            $aux= $this->Productoxcat_model->listProd($pagina_actual, $productos_x_pagina,$id_categoria);
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
            $dataPrincipal['cuerpo'] = 'productosxcat';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
        
      
}
?>