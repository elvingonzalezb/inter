<?php
class Proximos_ingresos extends CI_Controller {
    function __construct()
    {
            parent::__construct();
            $this->load->model('frontend/Inicio_model');
            $this->load->model('frontend/Proximos_ingresos_model');
            $this->load->library('Validacion');
    }
    function index()
    {
        
    }
    
    function listado_prueba() {
        $dataPrincipal = array();
        $dataPrincipal['mensaje'] = 'hola';
        $dataPrincipal['cuerpo'] = 'proximos_ingresos';
        $this->load->view("frontend/vista_prueba", $dataPrincipal); 
    }
    function listado() {
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
        
        $categorias = $this->Proximos_ingresos_model->getCategorias();
        // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
        $listaCategorias = array();
        foreach($categorias as $auxCategoria)
        {
            $auxCats = array();
            $auxCats['id_categoria'] = $auxCategoria->id_categoria;
            $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
            $listaSubcategorias = $this->Proximos_ingresos_model->getListaSubCategorias($auxCategoria->id_categoria);
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
        $data2['categorias'] = $listaCategorias;
        $data2['newsletter'] = getInfo("newsletter");
        $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); 
        

        // ********* CONTENIDO DERECHO ************** /   
        $productos_x_pagina = getConfig('productos_x_pagina');
        $aux = $this->uri->segment(2);
        if($aux>0)
        {
            $pagina_actual = $this->uri->segment(2);
        }
        else
        {
            $pagina_actual = 1;
        }
        $dataPrincipal['pagina_actual'] = $pagina_actual;
        $inicio = ($pagina_actual - 1)*$productos_x_pagina;
        $dataPrincipal['numero_paginas'] = $this->Proximos_ingresos_model->getNumPaginas($productos_x_pagina);
        
        $aux_primera = $this->Proximos_ingresos_model->primeraFechaProximamente();
        $primera_fecha = $aux_primera->fecha_llegada;
        
        $dataPrincipal['primera_fecha'] = $primera_fecha;
        
        /************* ANTERIOR *********/
        $aux3 = $this->Proximos_ingresos_model->getListaProductos($inicio, $productos_x_pagina);
        $productos = array();
        $numeroProductos = 0; 
        foreach($aux3 as $producto)
        {
            $aux4 = array();
            $aux4['id_producto'] = $producto->id_producto;
            $aux4['fecha_llegada'] = $producto->fecha_llegada;
            $aux_producto = $this->Proximos_ingresos_model->getProducto($producto->id_producto);
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

        $dataPrincipal['cuerpo'] = 'proximos_ingresos';
        $this->load->view("frontend/includes/template", $dataPrincipal); 
    }
    
    function listado_26Jun2015() {
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
        
        $categorias = $this->Proximos_ingresos_model->getCategorias();
        // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
        $listaCategorias = array();
        foreach($categorias as $auxCategoria)
        {
            $auxCats = array();
            $auxCats['id_categoria'] = $auxCategoria->id_categoria;
            $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
            $listaSubcategorias = $this->Proximos_ingresos_model->getListaSubCategorias($auxCategoria->id_categoria);
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
        $data2['categorias'] = $listaCategorias;
        $data2['newsletter'] = getInfo("newsletter");
        $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); 
        

        // ********* CONTENIDO DERECHO ************** /
        $productos_x_pagina = getConfig('productos_x_pagina');
        $aux = $this->uri->segment(2);
        //echo $aux; die();
        if($aux>0)
        {
            $pagina_actual = $this->uri->segment(2);
        }
        else
        {
            $pagina_actual = 1;
        }
        $dataPrincipal['pagina_actual'] = $pagina_actual;
        $inicio = ($pagina_actual - 1)*$productos_x_pagina;
        $dataPrincipal['numero_paginas'] = $this->Proximos_ingresos_model->getNumPaginas($productos_x_pagina);
        $aux3 = $this->Proximos_ingresos_model->getListaProductos($inicio, $productos_x_pagina);
        $productos = array();
        $numeroProductos = 0; 
        foreach($aux3 as $producto)
        {
            $aux4 = array();
            $aux4['id_producto'] = $producto->id_producto;
            $aux_producto = $this->Proximos_ingresos_model->getProducto($producto->id_producto);
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

        $dataPrincipal['cuerpo'] = 'proximos_ingresos';
        $this->load->view("frontend/includes/template", $dataPrincipal);    
    }
    
    function xfecha() {
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
        
        $categorias = $this->Proximos_ingresos_model->getCategorias();
        // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
        $listaCategorias = array();
        foreach($categorias as $auxCategoria)
        {
            $auxCats = array();
            $auxCats['id_categoria'] = $auxCategoria->id_categoria;
            $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
            $listaSubcategorias = $this->Proximos_ingresos_model->getListaSubCategorias($auxCategoria->id_categoria);
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
        $data2['categorias'] = $listaCategorias;
        $data2['newsletter'] = getInfo("newsletter");
        $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); 
        

        // ********* CONTENIDO DERECHO ************** /
        $fecha = $this->uri->segment(2);
        $fecha_aux = dmY_2_Ymd($fecha);
        $productos_x_pagina = getConfig('productos_x_pagina');
        $aux = $this->uri->segment(3);
        if($aux>0)
        {
            $pagina_actual = $this->uri->segment(3);
        }
        else
        {
            $pagina_actual = 1;
        }
        $dataPrincipal['pagina_actual'] = $pagina_actual;
        $inicio = ($pagina_actual - 1)*$productos_x_pagina;
        $numero_paginas = $this->Proximos_ingresos_model->getNumPaginas_x_fecha($productos_x_pagina, $fecha_aux);
        $dataPrincipal['numero_paginas'] = $numero_paginas;
        $aux3 = $this->Proximos_ingresos_model->getListaProductos_x_fecha($inicio, $productos_x_pagina, $fecha_aux);
        $productos = array();
        $numeroProductos = 0;
        foreach($aux3 as $producto)
        {
            $aux4 = array();
            $aux4['id_producto'] = $producto->id_producto;
            $aux_producto = $this->Proximos_ingresos_model->getProducto($producto->id_producto);
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
        $dataPrincipal["fecha"] = $fecha;

        $dataPrincipal['cuerpo'] = 'proximos_ingresos_x_fecha';
        $this->load->view("frontend/includes/template", $dataPrincipal);            
    }
}