<?php
class Vendedores extends CI_Controller {
    function __construct()
    {
            parent::__construct();
            $this->load->library('My_PHPMailer');
            $this->load->model('frontend/Inicio_model');  
            $this->load->model('frontend/Vendedores_model');
            $this->load->model('frontend/Compras_model');
            $this->load->model('frontend/Reservas_model'); 
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
         
        // *********** LISTADO DE VENDEDORES ************
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $vendedores = $this->Vendedores_model->getListaVendedores($id_cliente);        
        $dataPrincipal['vendedores'] = $vendedores; 
        $resultado = $this->uri->segment(3);
        $dataPrincipal['resultado'] = $resultado; 
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'listado_vendedores';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function nuevo() {
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
        
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'nuevo_vendedor_view';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function grabar() {
        $this->validacion->validacion_login_frontend(); 
        
        $nombre = $this->input->post('nombre'); 
        $cargo = $this->input->post('cargo');
        $telefono = $this->input->post('telefono');
        $email = $this->input->post('email');
        $clave = $this->input->post('clave');
        $ver_precio = $this->input->post('ver_precio');
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        
        $resultEmail = $this->Vendedores_model->verfCorreo($email);
        if($resultEmail)
        {
            $str='El Email '.$email.' ya esta registrado en nuestra Base de Datos';
            $this->session->set_flashdata("errorRegistro",$str);
            redirect('vendedores/nuevo');
        }
        else
        {
            $cliente = $this->Vendedores_model->getCliente($id_cliente);
            $cliente->nombre = $nombre;
            $cliente->cargo = $cargo;
            $cliente->telefono = $telefono;
            $cliente->email = $email;
            $cliente->clave = $clave;
            $cliente->nivel = 'vendedor';
            $cliente->id_padre = $id_cliente;
            $cliente->ver_precio = $ver_precio;
            $cliente->id = '';
            $this->Vendedores_model->grabaVendedor($cliente);
            redirect('vendedores/listado/agregado');            
        }
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
         
        // *********** DATOS DEL VENDEDOR ************
        $id_vendedor = $this->uri->segment(3);
        $owner = $this->Vendedores_model->getOwner($id_vendedor);
        $id_jefe = $this->session->userdata('id_cliente_logueado');
        if($id_jefe!=$owner)
        {
            redirect('vendedores/listado/nodetalle');
        }
        else
        {
            $vendedor = $this->Vendedores_model->getVendedor($id_vendedor);
            //var_dump($vendedor);die();
            $dataPrincipal['vendedor'] = $vendedor; 
            // ****** LLAMAMOS AL CUERPO *********
            $dataPrincipal['cuerpo'] = 'detalle_vendedor';
            $this->load->view('frontend/includes/template', $dataPrincipal); 
        }               
    }
    
    function editar() {
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
         
        // *********** DATOS DEL VENDEDOR ************
        $id_vendedor = $this->uri->segment(3);
        $resultado = $this->uri->segment(4);
        $vendedor = $this->Vendedores_model->getVendedor($id_vendedor);
        
        $owner = $this->Vendedores_model->getOwner($id_vendedor);
        $id_jefe = $this->session->userdata('id_cliente_logueado');
        if($id_jefe!=$owner)
        {
            redirect('vendedores/listado/noedit');
        }
        else
        {
            //var_dump($vendedor);die();
            $dataPrincipal['vendedor'] = $vendedor; 
            $dataPrincipal['resultado'] = $resultado;
            // ****** LLAMAMOS AL CUERPO *********
            $dataPrincipal['cuerpo'] = 'editar_vendedor';
            $this->load->view('frontend/includes/template', $dataPrincipal);  
        }
    }
    
    function actualizar() {
        $datos = array();
        $datos['nombre'] = $this->input->post('nombre'); 
        $datos['cargo'] = $this->input->post('cargo'); 
        $datos['telefono'] = $this->input->post('telefono'); 
        $datos['email'] = $this->input->post('email'); 
        $datos['clave'] = $this->input->post('clave'); 
        $datos['estado'] = $this->input->post('estado');
        $datos['ver_precio'] = $this->input->post('ver_precio');
        $id = $this->input->post('id');
        $this->Vendedores_model->actualizarVendedor($id, $datos);
        redirect('vendedores/editar/'.$id.'/actualizado');
    }
    
    function eliminar() {
        $id_vendedor = $this->uri->segment(3);
        
        $owner = $this->Vendedores_model->getOwner($id_vendedor);
        $id_jefe = $this->session->userdata('id_cliente_logueado');
        if($id_jefe!=$owner)
        {
            redirect('vendedores/listado/nodelete');
        }
        else
        {        
            $datos = array();
            $datos['estado'] = 'Borrado';
            $this->Vendedores_model->actualizarVendedor($id_vendedor, $datos);
            redirect('vendedores/listado/eliminado');
        }
    }
    
    function listaCompras() {
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
        $id_cliente = $this->uri->segment(3);
        
        $owner = $this->Vendedores_model->getOwner($id_cliente);
        $id_jefe = $this->session->userdata('id_cliente_logueado');
        if($id_jefe!=$owner)
        {
            redirect('vendedores/listado/nocompras');
        }
        else
        {
            $pagina = $this->uri->segment(4);
            $num_reservas = $this->Compras_model->getNumCompras($id_cliente);
            $reservas_x_pagina = 50;
            $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
            $reg_inicial = $reservas_x_pagina*($pagina - 1);
            $ordenes = $this->Compras_model->getListaComprasPagina($reservas_x_pagina, $reg_inicial, $id_cliente);
            $dataPrincipal['ordenes'] = $ordenes;
            $dataPrincipal['num_paginas'] = $num_paginas;
            $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
            $dataPrincipal['num_pedidos'] = $num_reservas;
            $dataPrincipal['pagina'] = $pagina;
        
            $dataPrincipal['id_vendedor'] = $id_cliente;
            $vendedor = $this->Vendedores_model->getVendedor($id_cliente);
            $dataPrincipal['vendedor'] = $vendedor; 

            // ****** LLAMAMOS AL CUERPO *********
            $dataPrincipal['cuerpo'] = 'listado_compras_vendedor';
            $this->load->view('frontend/includes/template', $dataPrincipal);
        }
    }

    function detalleCompra() {
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
        $id_cliente = $this->uri->segment(3);
        $id_reserva = $this->uri->segment(4);
        $orden= $this->Compras_model->getCompra($id_reserva);
        
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
            $dataPrincipal['id_vendedor'] = $id_cliente;
            $detalles = $this->Compras_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'detalle_compra_vendedor';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function impresionCompra() {
        $this->validacion->validacion_login_frontend();        
        $id_cliente = $this->uri->segment(3);
        $id_reserva = $this->uri->segment(4);
        $orden= $this->Compras_model->getCompra($id_reserva);
        
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
            echo 'Esta compra le pertenece a un vendedor de otra empresa';
            die();
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $detalles = $this->Compras_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
            $this->load->view('frontend/impresion_compra_vendedor', $dataPrincipal);
        }
    }
    
    function listaReservas() {
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
         
        // *********** LISTADO DE RESERVAS DEL CLIENTE ************
        $id_cliente = $this->uri->segment(3);
        
        $owner = $this->Vendedores_model->getOwner($id_cliente);
        $id_jefe = $this->session->userdata('id_cliente_logueado');
        if($id_jefe!=$owner)
        {
            redirect('vendedores/listado/noreservas');
        }
        else
        {
            $pagina = $this->uri->segment(4);
            $num_reservas = $this->Reservas_model->getNumReservas($id_cliente);
            $reservas_x_pagina = 20;
            $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
            $reg_inicial = $reservas_x_pagina*($pagina - 1);
            $ordenes = $this->Reservas_model->getListaReservasPagina($reservas_x_pagina, $reg_inicial, $id_cliente);
            $dataPrincipal['ordenes'] = $ordenes;
            $dataPrincipal['num_paginas'] = $num_paginas;
            $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
            $dataPrincipal['num_pedidos'] = $num_reservas;
            $dataPrincipal['pagina'] = $pagina;
            $dataPrincipal['id_vendedor'] = $id_cliente;
            $vendedor = $this->Vendedores_model->getVendedor($id_cliente);
            $dataPrincipal['vendedor'] = $vendedor; 

            // ****** LLAMAMOS AL CUERPO *********
            $dataPrincipal['cuerpo'] = 'listado_reservas_vendedor';
            $this->load->view('frontend/includes/template', $dataPrincipal);  
        }
    }
    
    function detalleReserva() {
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
        $id_cliente = $this->uri->segment(3);
        $id_reserva = $this->uri->segment(4);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        
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
            $cargos = $this->Reservas_model->getListaCargos($id_reserva); 
            $dataPrincipal['cargos'] = $cargos;
            $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
            $dataPrincipal['id_vendedor'] = $id_cliente;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'detalle_reserva_vendedor';
        $this->load->view('frontend/includes/template', $dataPrincipal);        
    }
    
    function impresion() {
        $this->validacion->validacion_login_frontend();         
        // *********** DATOS DE LA RESERVA ************ 
        $id_cliente = $this->uri->segment(3);
        $id_reserva = $this->uri->segment(4);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
            echo 'Esta reserva le pertenece a un vendedor que no es suyo';
            die();
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $cargos = $this->Reservas_model->getListaCargos($id_reserva); 
            $dataPrincipal['cargos'] = $cargos;
            $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
            $cliente = $this->Reservas_model->getCliente($id_cliente);
            $dataPrincipal['cliente'] = $cliente;
            $this->load->view('frontend/impresion_reserva_vendedor', $dataPrincipal);  
        }
              
    }
    
    
}
?>