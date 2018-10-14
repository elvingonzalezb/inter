<?php
class Compras extends CI_Controller {
    function __construct()
    {
            parent::__construct();
            $this->load->library('My_PHPMailer');
            $this->load->model('frontend/Inicio_model');
            $this->load->model('frontend/Compras_model');  
            $this->load->library('Validacion');
    }

    function listado() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);
         
        // *********** LISTADO DE COMPRAS DEL CLIENTE ************
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $pagina = $this->uri->segment(3);
        $num_reservas = $this->Compras_model->getNumCompras($id_cliente);
        $reservas_x_pagina = 20;
        $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
        $reg_inicial = $reservas_x_pagina*($pagina - 1);
        $ordenes = $this->Compras_model->getListaComprasPagina($reservas_x_pagina, $reg_inicial, $id_cliente);
        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_reservas;
        $dataPrincipal['pagina'] = $pagina;
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'listado_compras';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function detalle() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);
         
        // *********** DATOS DE LA RESERVA ************        
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Compras_model->getCompra($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $detalles = $this->Compras_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'detalle_compra';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function impresion() {
        $this->validacion->validacion_login_frontend(); 
         
        // *********** DATOS DE LA RESERVA ************        
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Compras_model->getCompra($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $detalles = $this->Compras_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
        }
        $this->load->view('frontend/impresion_compra', $dataPrincipal);        
    }
    
}
?>