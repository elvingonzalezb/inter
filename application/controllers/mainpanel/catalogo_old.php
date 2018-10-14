<?php
class Catalogo extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('validacion');
        $this->load->model('mainpanel/Catalogo_model');
        $this->load->library('my_upload');
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function listado() {
        $this->validacion->validacion_login();
        //GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/index_view";
        // LISTA CATEGORIAS CATALOGO
        $aux = $this->Catalogo_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id_categoria'] = $categoria->id_categoria;
            $aux2['nombre_categoria'] = $categoria->nombre_categoria;
            $aux2['imagen'] = $categoria->imagen;
            $aux2['numero_productos'] = $this->Catalogo_model->numeroProductos($categoria->id_categoria);
            $aux2['orden'] = $categoria->orden;
            $aux2['estado'] = $categoria->estado;
            $aux2['tipo'] = $categoria->tipo;
            $categorias[] = $aux2;
        }
        //$dataPrincipal["categorias"] = $this->Catalogo_model->getListaCategorias();
        $dataPrincipal["categorias"] = $categorias;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    
    public function edit() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/edit_view";
        // EDIT CATALOGO
        $id_categoria = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $categoria = $this->Catalogo_model->getCategoria($id_categoria);
        $dataPrincipal['categoria'] = $categoria;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
   
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR CATEGORIA
        $id_categoria = $this->input->post('id_categoria');
        $nombre_categoria = $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $tipo = $this->input->post('tipo');
        $estado = $this->input->post('estado');
        $data = array('nombre_categoria'=>$nombre_categoria, 'orden'=>$orden, 'estado'=>$estado, 'tipo'=>$tipo);
        
        $this->my_upload->upload($_FILES["foto"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 150;
            $this->my_upload->image_y          = 150;
            $this->my_upload->process('./files/categorias/');
            if ($this->my_upload->processed == true ) {
                $data['imagen'] = $this->my_upload->file_dst_name;
                $this->my_upload->clean();
            } else {
                $error = $this->my_upload->error;
            }
        }
        else
        {
            $error = $this->my_upload->error;
        }        
        $this->Catalogo_model->updateCategoria($id_categoria, $data);
        redirect('mainpanel/catalogo/edit/'.$id_categoria.'/success');
    }
    
    public function delete() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        
        // hallamos quienes son los productos que pertencen a esta categoria
        $aux = $this->Catalogo_model->getListaProductos($id_registro);
        foreach ($aux as $value) {
            $id_producto=$value->id_producto;
            
            $this->Catalogo_model->deleteColor($id_producto);
            $this->Catalogo_model->deletePrecio($id_producto);
            $producto = $this->Catalogo_model->getProducto($id_producto);
            $imagen=$producto->imagen;
            @unlink('files/productos/'.$imagen);
            @unlink('files/productos_thumbs_m/'.$imagen);
            @unlink('files/productos_thumbs/'.$imagen);        
            $this->Catalogo_model->deleteProducto($id_producto);
            
            // Borramos las fotos de la galeria de fotos
            $fotos = $this->Catalogo_model->getFotosProductos($id_producto);
            foreach($fotos as $pic) {
                $current = $pic->foto;
                $id = $pic->id;
                @unlink('files/fotografias/'.$current);
                @unlink('files/thumbnails_fotografias/'.$current);
                $this->Catalogo_model->deleteFoto($id);            
            }  
            
        }

        
        // Borramos la imagen de las categoria
        $categoria = $this->Catalogo_model->getCategoria($id_registro);
	$imagen=$categoria->imagen;
        @unlink('files/categorias/'.$imagen);
        //Borramos las categorias
        $this->Catalogo_model->deleteCategoria($id_registro);        
        // Borramos las fotos de los productos
        $fotos = $this->Catalogo_model->getListaProductos($id_registro);
        foreach($fotos as $pic) {
            $current = $pic->imagen;
            @unlink('files/productos_thumbs/'.$current);
            @unlink('files/productos_thumbs_m/'.$current);
            @unlink('files/productos/'.$current);
        }
	//Borramos los productos
        $this->Catalogo_model->deleteProductos($id_registro);

        redirect('mainpanel/catalogo/listado/success');
    }
    
    public function nuevo() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/nuevo_view";
        // NUEVA CATEGORIA
        $resultado = $this->uri->segment(4);
        if($resultado=="error")
        {
            $error = $this->uri->segment(5);
        }
        else
        {
            $error = '';
        }
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function grabar() {
        $this->validacion->validacion_login();
        // GRABAR CATEGORIA
        $nombre= $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $tipo = $this->input->post('tipo');
        $data = array('nombre_categoria'=>$nombre, 'orden'=>$orden, 'estado'=>$estado, 'tipo'=>$tipo);
        
        $this->my_upload->upload($_FILES["foto"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 150;
            $this->my_upload->image_y          = 150;
            $this->my_upload->process('./files/categorias/');
            if ( $this->my_upload->processed == true )
            {
                $data['imagen'] = $this->my_upload->file_dst_name;
                $this->my_upload->clean();
                $resultado = $this->Catalogo_model->grabarCategoria($data);
                if($resultado==1)
                {
                    redirect('mainpanel/catalogo/listado/success');
                }
                else
                {
                    redirect('mainpanel/catalogo/nuevo/error/bd');
                }
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                redirect('mainpanel/catalogo/nuevo/error/'.$error);
            }
        }
        else
        {
            $error = formateaCadena($this->my_upload->error);
            redirect('mainpanel/catalogo/nuevo/error/'.$error);
        }
    }
	
    
    public function listado_productos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/index_view_producto";
		
        $id_categoria= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA CATEOGRIA		
        $fila_categoria= $this->Catalogo_model->getCategoria($id_categoria);
	$nombre_categoria=$fila_categoria->nombre_categoria;
        $dataPrincipal["nombre_categoria"] = $nombre_categoria;
        // ENVIA LISTA DE CATEGORIAS
        $aux = $this->Catalogo_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id_categoria'] = $categoria->id_categoria;
            $aux2['nombre_categoria'] = $categoria->nombre_categoria;
            $categorias[] = $aux2;
        }
        $dataPrincipal["categorias"] = $categorias;           

        // LISTA PRODUCTOS CATALOGO
        $aux = $this->Catalogo_model->getListaProductos($id_categoria);
        $productos = array();
        foreach($aux as $producto)
        {
            $aux2 = array();
            $aux2['id_producto'] = $producto->id_producto;
            $aux2['nombre'] = $producto->nombre;
            $aux2['imagen'] = $producto->imagen;
            $aux2['codigo'] = $producto->codigo;
            $aux2['orden'] = $producto->orden;
            $aux2['tipo'] = $producto->tipo; 
            $aux2['actualizacion'] = $producto->actualizacion;
            $productos[] = $aux2;
        }
        $dataPrincipal["productos"] = $productos;

        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["id_categoria"] = $id_categoria;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function mantto() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/index_view_producto_mantto";
		
        $id_categoria= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA CATEOGRIA		
        $fila_categoria= $this->Catalogo_model->getCategoria($id_categoria);
	$nombre_categoria=$fila_categoria->nombre_categoria;
        $dataPrincipal["nombre_categoria"] = $nombre_categoria;

        // LISTA PRODUCTOS CATALOGO
        $aux = $this->Catalogo_model->getListaProductos($id_categoria);
        $productos = array();
        
                
        foreach($aux as $producto)
        {
            $aux2 = array();

            $aux2['id_producto'] = $producto->id_producto;
            $aux2['nombre'] = $producto->nombre;
            $aux2['imagen'] = $producto->imagen;
            $aux2['codigo'] = $producto->codigo;
            $aux3 =  $this->Catalogo_model->getPrecio($producto->id_producto);
            $precios = array();
            foreach ($aux3 as $valu) {
                $aux5=array();
                $aux4=$this->Catalogo_model->getUnidad($valu->id_unidad);
                $aux5['unidad']=$aux4->texto;
                $aux5['precio']=$valu->precio; 
                $aux5['id_precio']=$valu->id;
                $precios[]=$aux5;
            }
            $aux2['precios'] = $precios;            
            
            $aux7 =  $this->Catalogo_model->getColores($producto->id_producto);
            $stock= array();    
            foreach ($aux7 as $valuq) {
                $aux6=array();
                $aux4=$this->Catalogo_model->getCol($valuq->id_color);
                $aux6['nombre']=$aux4->nombre;
                $aux6['color']=$aux4->color;                
                $aux6['stock']=$valuq->stock; 
                $aux6['id_stock']=$valuq->id;                 
                $stock[]=$aux6;
            }
            $aux2['stock'] = $stock;              
            $productos[] = $aux2;
        }
        $dataPrincipal["productos"] = $productos;

        $dataPrincipal["id_categoria"] = $id_categoria;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    

    
    public function edit_producto() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/edit_view_producto";
        
        // EDIT PRODUCTO
        $id_producto = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        
        // LISTA FAMILIA*********************************       
        $dataPrincipal["familias"] = $this->Catalogo_model->getListaFamilia();        
        
        // ENVIA LISTA DE CATEGORIAS
        $aux = $this->Catalogo_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id_categoria'] = $categoria->id_categoria;
            $aux2['nombre_categoria'] = $categoria->nombre_categoria;
            $categorias[] = $aux2;
        }
        $dataPrincipal["categorias"] = $categorias;           
        
        // PRECIOS
        $aux = $this->Catalogo_model->getPrecio($id_producto);
        $precios=array();
        foreach($aux as $pre)
        {
            $aux2 = array();
            $aux2['precio'] = $pre->precio;
            $aux2['id_unidad'] = $pre->id_unidad;
            $aux2['moneda'] = $pre->moneda;            
            $aux2['id'] = $pre->id;
            $precios[] = $aux2;
        }
        $dataPrincipal["precios"] = $precios;
        
        // COLORES
        $aux = $this->Catalogo_model->getColores($id_producto);
        $colores=array();
        foreach($aux as $col)
        {
            $aux2 = array();
            $aux2['id'] = $col->id;
            $aux3=$this->Catalogo_model->getCol($col->id_color);
            if(count($aux3)>0){
                $aux2['color'] = $aux3->color;
                $aux2['nombre'] = $aux3->nombre;
            }else{
                $aux2['color'] ='';
                $aux2['nombre'] ='';
            }
            $aux2['id_color'] = $col->id_color;            
            $aux2['stock'] = $col->stock;            

            $colores[] = $aux2;
        }
        $dataPrincipal["colores"] = $colores;
        
        // LISTA UNIDADDES
        $aux = $this->Catalogo_model->getListaUnidades();
        $unidades = array();
        foreach($aux as $unidad)
        {
            $aux2 = array();
            $aux2['id'] = $unidad->id;
            $aux2['texto'] = $unidad->texto;
            $unidades[] = $aux2;
        }        
        $dataPrincipal["unidades"] = $unidades;
        //*********************************
        
        $producto = $this->Catalogo_model->getProducto($id_producto);
        $dataPrincipal['producto'] = $producto;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar_producto() {
        $this->validacion->validacion_login();
        // RECEPCIONO LOS VALORES
        $id_categoria_padre = $this->input->post('id_categoria_padre');        
        $id_producto = $this->input->post('id_producto');
        $nombre = $this->input->post('nombre');
        $codigo = $this->input->post('codigo');
        $precio= $this->input->post('precio');
        $orden= $this->input->post('orden');
//        $tipo = $this->input->post('tipo');
        $tipo = "1";
        $colores = $this->input->post('elegidos');
        $oferta = $this->input->post('oferta');
		$orden_proximamente = $this->input->post('orden_proximamente');
        $novedad = $this->input->post('novedad');
		$orden_novedad = $this->input->post('orden_novedad');
        $fotoantg= $this->input->post('fotoantg');
        $stock = $this->input->post('stock');
        $show_stock = $this->input->post('show_stock'); 
		$descuento_especial = $this->input->post('descuento_especial'); 
        $descripcion = $this->input->post('descripcion');
        $material = $this->input->post('material');
        $medidas = $this->input->post('medidas');
        $area_impresion = $this->input->post('area_impresion');
        $metodo_impresion = $this->input->post('metodo_impresion'); 
        $descuento = $this->input->post('descuento');         

        // se prepara info para actualizar
        $num_precios= $this->input->post('num_precios');
        $num_unidades= $this->input->post('num_unidades');        
        $data3=array();
        for($r=0;$r<$num_precios;$r++){
            $precio= $this->input->post('precio_'.$r);            
            $moneda= $this->input->post('moneda_'.$r);
            $unidad= $this->input->post('unidad_'.$r);            
            $id_precio= $this->input->post('id_precio_'.$r);
            if($unidad<>'0' and $moneda<>'0' and $precio<>''){
                $data2=array();
                $data2['precio']=$precio;
                $data2['id_unidad']=$unidad;
                $data2['moneda']=$moneda;
                $data2['id_precio']=$id_precio;                
                $data3[]=$data2;
            }
        }
        //***************************
        if(($num_unidades-$num_precios)>0){
            $data4=array();
            for($r=$num_precios;$r<$num_unidades;$r++){
                $precio= $this->input->post('precio_'.$r);            
                $moneda= $this->input->post('moneda_'.$r);
                $unidad= $this->input->post('unidad_'.$r);            
                if($unidad<>'0' and $moneda<>'0' and $precio<>''){
                    $dat=array();
                    $dat['precio']=$precio;
                    $dat['id_unidad']=$unidad;
                    $dat['moneda']=$moneda;
                    $data4[]=$dat;
                }
            }            
        }
        
        //COLORES
        $id_concatenados= $this->input->post('id_concatenados');
        $cad=explode("##",$id_concatenados);
        $data5=array();
        for ($r=0;$r<count($cad);$r++) {
            $id=$cad[$r];
            $stock= $this->input->post('stock_c_'.$id);
            $id_color= $this->input->post('idcolor_'.$id);            
            
            if($id_color<>'' and $stock<>''){
                $data2=array();
                $data2['stock']=$stock;
                $data2['id_color']=$id_color;
                $data5[]=$data2;
            }
        }
        //***********************
        
        $data = array();
        $data['nombre']=$nombre;
        $data['codigo']=$codigo;
        $data['precio']=$precio;
        $data['orden']=$orden;
        $data['nivel']='1';        
        $data['tipo']=$tipo;
        $data['colores']=$colores;        
        $data['oferta']=$oferta; 
		$data['orden_proximamente']=$orden_proximamente;       
        $data['novedad']=$novedad;
		$data['orden_novedad']=$orden_novedad;
        $data['id_categoria_padre']=$id_categoria_padre;
        $data['stock']=$stock;
        $data['show_stock']=$show_stock; 
        $data['descripcion']=$descripcion;
		$data['descuento_especial'] = $descuento_especial;
        $data['material']=$material;
        $data['medidas']=$medidas;
        $data['area_impresion']=$area_impresion;
        $data['metodo_impresion']=$metodo_impresion;        
        $data['descuento']=$descuento;
        
        
        $this->my_upload->upload($_FILES["foto"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 125;
            $this->my_upload->image_ratio_y    = true;            
            $this->my_upload->process('./files/productos_thumbs/');
            
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 250;
            $this->my_upload->image_ratio_y    = true;
            $this->my_upload->process('./files/productos_thumbs_m/');
            
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 500;
            $this->my_upload->image_ratio_y    = true;
            $this->my_upload->process('./files/productos/');
            
            if ($this->my_upload->processed == true ) {
                $data['imagen'] = $this->my_upload->file_dst_name;
		@unlink("./files/productos_thumbs/".$fotoantg);
		@unlink("./files/productos_thumbs_m/".$fotoantg);
		@unlink("./files/productos/".$fotoantg);
                $data['actualizacion']=  fecha_hoy_Ymd();       
                //$this->my_upload->clean();
            } else {
                $error = $this->my_upload->error;
            }
        }
       
        
        if(isset($error)){
           redirect('mainpanel/catalogo/edit_producto/'.$id_producto.'/error');
        }else{
            $this->Catalogo_model->updateProducto($id_producto, $data);
            
            // grabar actualzacion en tabala
            $dd=array();
            $dd['id_producto']=$id_producto;
            $dd['fecha']=fecha_hoy_Ymd();                
            $this->Catalogo_model->grabarFechaActua($dd);   
            //*****************
            
            for($d=0;$d<count($data3);$d++){
                $current=$data3[$d];
                $envia_dato=array();
                $envia_dato['precio']=$current['precio'];
                $envia_dato['id_unidad']=$current['id_unidad'];
                $envia_dato['moneda']=$current['moneda'];
                $id_precio=$current['id_precio'];                
                $resultado=$this->Catalogo_model->updatePrecio($id_precio,$envia_dato);
            }            
                
            for($d=0;$d<count($data4);$d++){
                $current=$data4[$d];
                $envia_dato=array();
                $envia_dato['precio']=$current['precio'];
                $envia_dato['id_unidad']=$current['id_unidad'];
                $envia_dato['moneda']=$current['moneda'];
                $envia_dato['id_producto']=$id_producto;
                $resultado=$this->Catalogo_model->grabarPrecio($envia_dato);
            }            
            
            $this->Catalogo_model->deleteColor($id_producto);            
            
            for($d=0;$d<count($data5);$d++){
                $current=$data5[$d];
                $envia_dato=array();
                $envia_dato['stock']=$current['stock'];
                $envia_dato['id_color']=$current['id_color'];
                $envia_dato['id_producto']=$id_producto;
                $resultado=$this->Catalogo_model->grabarColor($envia_dato);
            }  
            
            redirect('mainpanel/catalogo/edit_producto/'.$id_producto.'/success');           
        }
        
        
    }
       
    public function nuevo_producto() {
        // LOGUEO*************************************************************************************        
        $this->validacion->validacion_login();
        // GENERAL*************************************************************************************
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/nuevo_view_producto";
        //*************************************************************************************
        //
        //
        // NUEVO PRODUCTO 
        $id_categoria= $this->uri->segment(4);
        $resultado= $this->uri->segment(5);        
        switch ($resultado){
            case "error":
                $error= $this->uri->segment(6);                
                $dataPrincipal["error"]= $error;
            break;
        }
        $dataPrincipal["id_categoria"]= $id_categoria;
        $dataPrincipal["resultado"]= $resultado;

        
        // LISTA CATEGORIAS*********************************       
        $aux = $this->Catalogo_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id_categoria'] = $categoria->id_categoria;
            $aux2['nombre_categoria'] = $categoria->nombre_categoria;
            $categorias[] = $aux2;
        }
        $dataPrincipal["categorias"] = $categorias;   
        
        // LISTA FAMILIA*********************************       
        $dataPrincipal["familias"] = $this->Catalogo_model->getListaFamilia();
        
        // LISTA UNIDADDES*********************************       
        $aux = $this->Catalogo_model->getListaUnidades();
        $unidades = array();
        foreach($aux as $unidad)
        {
            $aux2 = array();
            $aux2['id'] = $unidad->id;
            $aux2['texto'] = $unidad->texto;
            $unidades[] = $aux2;
        }        
        $dataPrincipal["unidades"] = $unidades;
        //*********************************        
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
        
    public function grabar_producto() {
        $this->validacion->validacion_login();
        // GRABAR PRODUCTO
        $id_categoria_padre= $this->input->post('id_categoria_padre');
        $nombre= $this->input->post('nombre');
        $codigo = $this->input->post('codigo');        
        $orden = $this->input->post('orden');
        $precio = $this->input->post('precio');
//        $tipo = $this->input->post('tipo');
        $tipo = "1";
        $oferta = $this->input->post('oferta');
        $novedad = $this->input->post('novedad');
        $elegidos = $this->input->post('elegidos');
        $stock= $this->input->post('stock');
        $show_stock = $this->input->post('show_stock');
        $descripcion = $this->input->post('descripcion');
		$descuento_especial = $this->input->post('descuento_especial'); 
        $material = $this->input->post('material');
        $medidas = $this->input->post('medidas');
        $area_impresion = $this->input->post('area_impresion');
        $metodo_impresion = $this->input->post('metodo_impresion');  
        $descuento= $this->input->post('descuento');          
        
        //PRECIOS
        $num_unidades= $this->input->post('num_unidades');
        $data3=array();
        for($r=0;$r<$num_unidades;$r++){
            $precio= $this->input->post('precio_'.$r);            
            $moneda= $this->input->post('moneda_'.$r);
            $unidad= $this->input->post('unidad_'.$r);            
            if($unidad<>'0' and $moneda<>'0' and $precio<>''){
                $data2=array();
                $data2['precio']=$precio;
                $data2['id_unidad']=$unidad;
                $data2['moneda']=$moneda;                            
                $data3[]=$data2;
            }
        }    
        
        //COLORES
        $id_concatenados= $this->input->post('id_concatenados');
        $cad=explode("##",$id_concatenados);
        $data4=array();
        for ($r=0;$r<count($cad);$r++) {
            $id=$cad[$r];
            $stock= $this->input->post('stock_c_'.$id);
            $id_color= $this->input->post('idcolor_'.$id);            
            
            if($id_color<>'' and $stock<>''){
                $data2=array();
                $data2['stock']=$stock;
                $data2['id_color']=$id_color;
                $data4[]=$data2;
            }
        }

        
        $data = array();
        $data['id_categoria_padre']=$id_categoria_padre;        
        $data['nombre']=$nombre;
        $data['codigo']=$codigo;
        $data['orden']=$orden;
        $data['precio']=$precio;
        $data['tipo']=$tipo;
        $data['oferta']=$oferta;
        $data['novedad']=$novedad;
        $data['colores']=$elegidos;
        $data['stock']=$stock;
        $data['show_stock']=$show_stock;
        $data['descripcion']=$descripcion;
		$data['descuento_especial'] = $descuento_especial;
        $data['material']=$material;
        $data['medidas']=$medidas;
        $data['area_impresion']=$area_impresion;
        $data['metodo_impresion']=$metodo_impresion;
        $data['descuento']=$descuento;        
        $data['fecha_ingreso']= fecha_hoy_Ymd();
        $this->my_upload->upload($_FILES["foto"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 125;
            $this->my_upload->image_ratio_y    = true;            
            $this->my_upload->process('./files/productos_thumbs/');
            
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 250;
            $this->my_upload->image_ratio_y    = true;
            $this->my_upload->process('./files/productos_thumbs_m/');
            
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 500;
            $this->my_upload->image_ratio_y    = true;
            $this->my_upload->process('./files/productos/');
            
            if ( $this->my_upload->processed == true )
            {
                $data['imagen'] = $this->my_upload->file_dst_name;
                $data['actualizacion']=  fecha_hoy_Ymd(); 
                $this->my_upload->clean();
                $id_producto = $this->Catalogo_model->grabarProducto($data);
                
                $dd=array();
                $dd['id_producto']=$id_producto;
                $dd['fecha']=fecha_hoy_Ymd();                
                $this->Catalogo_model->grabarFechaActua($dd);                
                
                for($d=0;$d<count($data3);$d++){
                    $current=$data3[$d];
                    $envia_dato=array();
                    $envia_dato['precio']=$current['precio'];
                    $envia_dato['id_unidad']=$current['id_unidad'];
                    $envia_dato['moneda']=$current['moneda'];
                    $envia_dato['id_producto']=$id_producto;
                    $resultado=$this->Catalogo_model->grabarPrecio($envia_dato);
                }
                
                for($d=0;$d<count($data4);$d++){
                    $current=$data4[$d];
                    $envia_dato=array();
                    $envia_dato['stock']=$current['stock'];
                    $envia_dato['id_color']=$current['id_color'];
                    $envia_dato['id_producto']=$id_producto;
                    $resultado=$this->Catalogo_model->grabarColor($envia_dato);
                }                
                
                if($resultado==1)
                {
                    redirect('mainpanel/catalogo/listado_productos/'.$id_categoria_padre.$precio.'/success');
                }
                else
                {
                    redirect('mainpanel/catalogo/nuevo_producto/'.$id_categoria_padre.$precio.'/error/bd');
                }
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                redirect('mainpanel/catalogo/nuevo_producto/'.$id_categoria_padre.'/error/'.$error);
            }
        }
        else
        {
            $error = formateaCadena($this->my_upload->error);
            redirect('mainpanel/catalogo/nuevo_producto/'.$id_categoria_padre.'/error/'.$error);
        }
    }
    
    public function delete_producto() {
        $this->validacion->validacion_login();
        $id_producto = $this->uri->segment(4);
        $this->Catalogo_model->deleteColor($id_producto);
        $this->Catalogo_model->deletePrecio($id_producto);
        $producto = $this->Catalogo_model->getProducto($id_producto);
        $imagen=$producto->imagen;
        $id_categoria_padre=$producto->id_categoria_padre;        
        @unlink('files/productos/'.$imagen);
        @unlink('files/productos_thumbs_m/'.$imagen);
        @unlink('files/productos_thumbs/'.$imagen);        
        
        // Borramos las fotos de la galeria de fotos
        $fotos = $this->Catalogo_model->getFotosProductos($id_producto);
        foreach($fotos as $pic) {
            $current = $pic->foto;
            $id = $pic->id;
            @unlink('files/fotografias/'.$current);
            @unlink('files/thumbnails_fotografias/'.$current);
            $this->Catalogo_model->deleteFoto($id);            
        }
        $this->Catalogo_model->deleteProducto($id_producto);
        
        redirect('mainpanel/catalogo/listado_productos/'.$id_categoria_padre.'/success');
    }
    
    public function ordenar_producto() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/order_producto";
		
        $id_categoria= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA CATEOGRIA		
        $fila_categoria= $this->Catalogo_model->getCategoria($id_categoria);
	$nombre_categoria=$fila_categoria->nombre_categoria;
        $dataPrincipal["nombre_categoria"] = $nombre_categoria;
        // LISTA PRODUCTOS CATALOGO
        $aux = $this->Catalogo_model->getListaProductos($id_categoria);
        $productos = array();
        foreach($aux as $producto)
        {
            $aux2 = array();
            $aux2['id_producto'] = $producto->id_producto;
            $aux2['nombre'] = $producto->nombre;
            $aux2['imagen'] = $producto->imagen;

            $productos[] = $aux2;
        }

        $dataPrincipal["productos"] = $productos;
        $dataPrincipal["id_categoria"] = $id_categoria;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    
    
    public function ordenar_productos() {
        
        $ordenes= $this->uri->segment(4);	
        $cad1=explode("&",$ordenes);
        $num=count($cad1);
        $orden=0;
	for($o=0;$o<$num;$o++){
            $str=explode("=",$cad1[$o]);
            $id=$str[1];
            $orden +=1;
            $data=array();
            $data['orden']=$orden;
            $this->Catalogo_model->ordProd($id,$data);        
            //$aux = "update productos set orden='$pos' where id_producto='$id'";
            //$sql[] = $aux;
            //$query = mysql_query($aux);	
        }
    } 
    
    public function fotos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/lista_fotos";
		
        $id_producto= $this->uri->segment(4);
        
        // SOLICITO EL NOMBRE DEL PRODUCTO	
        $fila_producto= $this->Catalogo_model->getProducto($id_producto);
	$nombre_producto=$fila_producto->nombre;
	$id_categoria_padre=$fila_producto->id_categoria_padre;        
        $dataPrincipal['nombre_producto'] = $nombre_producto;
        $dataPrincipal['id_categoria_padre'] = $id_categoria_padre;        
        // ENVIA LISTA DE FOTOGRAFIAS
        $aux = $this->Catalogo_model->getFotosProductos($id_producto);
        $fotos = array();
        foreach($aux as $fot)
        {
            $aux2 = array();
            $aux2['id_fp'] = $fot->id_fp;
            $aux2['nombre'] = $fot->nombre;
            $aux2['foto'] = $fot->foto;
            $aux2['orden'] = $fot->orden;            
            $fotos[] = $aux2;
        }
        $dataPrincipal["fotos"] = $fotos;

        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["id_producto"] = $id_producto;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }   
    
    
    public function nueva_foto() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/nuevo_view_foto";
        
        // NUEVA FOTOGRAFIA
        $id_producto= $this->uri->segment(4);   
        // SOLICITO EL NOMBRE DEL PRODUCTO
        $fila_producto= $this->Catalogo_model->getProducto($id_producto);
	$nombre_producto=$fila_producto->nombre;
        $dataPrincipal['nombre_producto'] = $nombre_producto;
        
        $resultado = $this->uri->segment(5);
        if($resultado=="error")
        {
            $error = $this->uri ->segment(6);
        }
        else
        {
            $error = '';
        }
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
        $dataPrincipal["id_producto"]= $id_producto;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function grabar_foto() {
        $this->validacion->validacion_login();
        // GRABAR CATEGORIA
        $id_prod= $this->input->post('id_producto');
        $nombre= $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $data = array('nombre'=>$nombre, 'orden'=>$orden, 'id_prod'=>$id_prod);
        
        $this->my_upload->upload($_FILES["foto"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 50;
            $this->my_upload->image_y          = 50;
            $this->my_upload->process('./files/thumbnails_fotografias/');
            
            $this->my_upload->allowed= array('image/*');
            $this->my_upload->image_resize           = true;
            $this->my_upload->image_x                = 600;
            $this->my_upload->image_ratio_y          = true;
            $this->my_upload->process('./files/fotografias/');
            
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 260;
            $this->my_upload->image_y          = 260;
            $this->my_upload->process('./files/fotografias_medianas/');            
            
            if ( $this->my_upload->processed == true )
            {
                $data['foto'] = $this->my_upload->file_dst_name;
                $this->my_upload->clean();
                $resultado = $this->Catalogo_model->grabarFoto($data);
                if($resultado==1)
                {
                    redirect('mainpanel/catalogo/fotos/'.$id_prod.'/success');
                }
                else
                {
                    redirect('mainpanel/catalogo/fotos/'.$id_prod.'/error/bd');
                }
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                redirect('mainpanel/catalogo/fotos/'.$id_prod.'/error/'.$error);
            }
        }
        else
        {
            $error = formateaCadena($this->my_upload->error);
            redirect('mainpanel/catalogo/fotos/'.$id_prod.'/error/'.$error);
        }
    }

    public function editar_foto() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/edit_view_foto";
        
        // NUEVA FOTOGRAFIA
        $id_foto= $this->uri->segment(4);   
        // SOLICITO EL NOMBRE DEL PRODUCTO
        $foto= $this->Catalogo_model->getfoto($id_foto);
        $dataPrincipal['foto'] = $foto;
        $resultado = $this->uri->segment(5);
        if($resultado=="error")
        {
            $error = $this->uri ->segment(6);
        }
        else
        {
            $error = '';
        }
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
        $dataPrincipal["id_foto"]= $id_foto;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }

    public function actualizar_foto() {
        $this->validacion->validacion_login();
        // RECEPCIONO LOS VALORES
        $id_fp = $this->input->post('id_fp');        
        $nombre = $this->input->post('nombre');
        $orden= $this->input->post('orden');
        $fotoantg = $this->input->post('fotoantg');
        $data = array();
        $data['nombre']=$nombre;
        $data['orden']=$orden;
        
        $this->my_upload->upload($_FILES["foto"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 260;
            $this->my_upload->image_y          = 260;
            $this->my_upload->process('./files/fotografias_medianas/');  
            
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 50;
            $this->my_upload->image_y          = 50;
            $this->my_upload->process('./files/thumbnails_fotografias/');
            
            $this->my_upload->allowed= array('image/*');
            $this->my_upload->image_resize           = true;
            $this->my_upload->image_x                = 600;
            $this->my_upload->image_ratio_y          = true;
            $this->my_upload->process('./files/fotografias/');
            
            
            if ($this->my_upload->processed == true ) {
                $data['foto'] = $this->my_upload->file_dst_name;
		@unlink("./files/thumbnails_fotografias/".$fotoantg);
		@unlink("./files/fotografias/".$fotoantg);
		@unlink("./files/fotografias_medianas/".$fotoantg);                
                //$this->my_upload->clean();
            } else {
                $error = $this->my_upload->error;
            }
        }
        
        if(isset($error)){
           redirect('mainpanel/catalogo/editar_foto/'.$id_fp.'/error');
        }else{
            $this->Catalogo_model->updateFoto($id_fp, $data);
            redirect('mainpanel/catalogo/editar_foto/'.$id_fp.'/success');           
        }
    }
           
    public function delete_foto() {
        $this->validacion->validacion_login();
        $id_fp = $this->uri->segment(4);
        $producto = $this->Catalogo_model->getfoto($id_fp);
        $foto=$producto->foto;
        $id_prod=$producto->id_prod;        
        @unlink('files/thumbnails_fotografias/'.$foto);
        @unlink('files/fotografias/'.$foto);
        $this->Catalogo_model->deleteFoto($id_fp);
        redirect('mainpanel/catalogo/fotos/'.$id_prod.'/success');
    }

    
}
?>
