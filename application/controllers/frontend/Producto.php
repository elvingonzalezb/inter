<?php
class Producto extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Producto_model');
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
		$data['seccion'] = 'productos';            
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
		
                // LISTAR PRODUCTOS
		$productos_x_pagina = getConfig('productos_x_pagina');
		$pagina_actual = $this->uri->segment(2);
		$dataPrincipal['pagina_actual'] = $pagina_actual;
		$dataPrincipal['numero_paginas'] = $this->Producto_model->getNumPaginas($productos_x_pagina);
		$aux= $this->Producto_model->listProd($pagina_actual, $productos_x_pagina);
		$productos = array();
		foreach($aux as $producto)
		{
			$aux2 = array();
			$id_producto= $producto->id_producto;                
			$aux2['id_producto'] = $id_producto;
			$aux2['colores'] = $this->Producto_model->listColores($id_producto);
			$aux2['nombre'] = $producto->nombre;
			$aux2['imagen'] = $producto->imagen;
			$aux2['codigo'] = $producto->codigo;				
			$aux2['url_nom'] = formateaCadena($producto->nombre);
			$productos[] = $aux2;
		}            
		$dataPrincipal['productos'] = $productos;
		$dataPrincipal['getInfo'] = getInfo("productos");
		$dataPrincipal['cuerpo'] = 'productos';
		
		$this->load->view("frontend/includes/template", $dataPrincipal);
	}
        
    function detalle()
    {
        // GENERAL
        $this->validacion->validacion_login_frontend();
        $id_producto = $this->uri->segment(2);
        if($this->uri->segment(3)>0)
        {
            $id_categoria = $this->uri->segment(3);
            $url_nombre = $this->uri->segment(4); 
            $resultado = $this->uri->segment(5); 
        }
        else
        {
            $id_categoria = 0;
            $url_nombre = $this->uri->segment(3); 
            $resultado = $this->uri->segment(4); 
        }
        
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

        $data2=array();
        $data['twitter'] = getConfig('enlace_twitter');
        $data['facebook'] = getConfig('enlace_facebook');
        $data['telefono'] = getConfig("telefono");
        $data['horario'] = getConfig("horario");
        $data['direccion'] = getConfig("direccion");            
        $data['seccion'] = 'incio';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);

        // INFO DE LA SECCION
                   
        $colores=array();
        $aux4=$this->Inicio_model->listColores($id_producto);
        foreach ($aux4 as $val) 
        {
                $aux6=array();
                $aux6['stock']=$val->stock;
                $aux5=$this->Inicio_model->getCol($val->id_color);
                if(count($aux5)>0)
                {
                    $aux6['nombre']=$aux5->nombre;
                    $aux6['color']=$aux5->color;
                }
                else
                {
                    $aux6['nombre']='';
                    $aux6['color']='';
                }
                $aux6['id']=$val->id;
                $aux6['id_color'] = $val->id_color;
                $colores[]=$aux6;
        }
        $dataPrincipal['colores']=$colores;
        
        // COLORES QUE LLEGARAN PROXIMAMENTE
        $colores_prox = array();
        $aux4 = $this->Inicio_model->listColoresProximamente($id_producto);
        foreach ($aux4 as $val) 
        {
            $aux6=array();
            $aux6['stock_proximamente'] = $val->stock_proximamente;
            $aux6['fecha_llegada'] = Ymd_2_dmY($val->fecha_llegada);
            $aux6['precio_proximamente'] = $val->precio_proximamente;
            $aux5 = $this->Inicio_model->getCol($val->id_color);
            if(count($aux5)>0)
            {
                $aux6['nombre']=$aux5->nombre;
                $aux6['color']=$aux5->color;
            }
            else
            {
                $aux6['nombre']='';
                $aux6['color']='';
            }
            $aux6['id']=$val->id;
            $aux6['id_color'] = $val->id_color;
            $colores_prox[] = $aux6;
        }
        //var_dump($colores_prox);die();
        $dataPrincipal['colores_prox'] = $colores_prox;
        
        
        
        
        $dataPrincipal['fotos']=$this->Producto_model->listFotos($id_producto);            
        
        $dataPrincipal['id_categoria'] = $id_categoria;
        $dataPrincipal['base_url'] = $this->config->item('base_url');
        $dataPrincipal['url_nombre'] = $url_nombre;
        $dataPrincipal['resultado'] = $resultado;
        $producto = $this->Producto_model->getProducto($id_producto);
        $id_categoria_padre=$producto->id_categoria_padre;
        //$cat= $this->Producto_model->getCategoria($id_categoria_padre);
        //$dataPrincipal['nombre_categoria'] = $cat->nombre_categoria;
        $dataPrincipal['nombre_categoria'] = '';
        $dataPrincipal['descuento']=$producto->descuento;
        $aux_p1 = $producto->descuento_especial;
        $oferta=$producto->oferta;
        $novedad=$producto->novedad;

        // LISTA DE PRECIOS
        $aux=$this->Producto_model->listPrecios($id_producto);
        $precios=array();
        foreach ($aux as $value) 
        {
            $aux2=array();
            $descuento_cm = $this->session->userdata('descuento_cambio_moneda');
            if($descuento_cm=="si")
            {
                $descuento_cambio_moneda = getConfig("descuento");
                $ratio_cm = (100 - $descuento_cambio_moneda)/100;
                $ratio_cm = redondeado($ratio_cm, 3);
            }
            else
            {
                $descuento_cambio_moneda = 1;
                $ratio_cm = 1;
            }
            $descuento_esp = $this->session->userdata('descuento_especial');
            if($descuento_esp=="si")
            {
                $descuento_especial = $producto->descuento_especial;
                $ratio_de = (100 - $descuento_especial)/100;
                $ratio_de = redondeado($ratio_de, 3);
                $aux2['tiene_descuento'] = 'si';
            }
            else
            {
                $descuento_especial = 1;
                $ratio_de = 1;
                $aux2['tiene_descuento'] = 'no';
            } 
            $precio_normal = $value->precio;
            $aux_precio = ($value->precio)*$ratio_cm*$ratio_de;
            $aux2['precio'] = $aux_precio;
            $aux2['precio_normal'] = $precio_normal;
            $aux2['moneda']=$value->moneda;
            $aux3=$this->Producto_model->getUnidad($value->id_unidad);
            $aux2['unidad']=$aux3->texto;
            $aux2['id_unidad']=$value->id_unidad;                
            $precios[]=$aux2;
        }
        $dataPrincipal['precios']=$precios;

        $subCatId=$this->Producto_model->getsubcategoriasids($producto->id_producto);
        $relacionados=$this->Producto_model->getProductosRelacionados(explode(',',$subCatId),$producto->id_producto,$producto->id_categoria);
        $dataPrincipal['relacionados'] =$relacionados ;
        //echo '<pre>';print_r($relacionados);echo '</pre>';die;
        /****************************/
        if($oferta =='1' || $novedad=='1') {
            $dataPrincipal['producto'] =$producto ;
            $dataPrincipal['cuerpo'] = 'detalle_producto';
            $this->load->view("frontend/includes/template", $dataPrincipal);
        } else {
            $this->validacion->validacion_login_frontend();
            $dataPrincipal['producto'] =$producto ;
            $dataPrincipal['cuerpo'] = 'detalle_producto';
            $this->load->view("frontend/includes/template", $dataPrincipal);
        }			
    }        
}
?>