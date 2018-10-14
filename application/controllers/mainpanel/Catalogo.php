<?php
class Catalogo extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Catalogo_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
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
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaCategorias() {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre_categoria', 1 => 'orden');

        $totalData = $this->Datatable->numCategorias();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( nombre_categoria LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR orden LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchCategorias($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchCategorias($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $foto = $value["imagen"];
            if(is_file('files/categorias/'.$foto)){
                $pic = '<img src="files/categorias/'.$foto.'" />';
            }else{
                $pic = '<img src="assets/frontend/confeccionesrials/imagenes/img300x200.png" />';
            }
            $nestedData[] = $pic;
            $nestedData[] = $value["nombre_categoria"];
            $numero_subcategorias = $this->Catalogo_model->numeroSubcategorias($value["id_categoria"]);
            $nestedData[] = $numero_subcategorias;
            $nestedData[] = $value["orden"];
            $nestedData[] = ($value['tipo']==0)?'Publica':'Privada';
            $nestedData[] = ($value['incluir_en_inventario']==1)?'SI':'NO';
            $nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>': '<span class="label label-important">INACTIVO</span>';
            $acciones = '<a class="btn btn-info" href="mainpanel/catalogo/edit/'.$value["id_categoria"].'"><i class="icon-edit icon-white"></i>  Editar</a> ';
            $acciones .= '<a class="btn btn-danger" href="javascript:deleteCategoria(\''.$value["id_categoria"].'\', \''.$numero_subcategorias.'\')"><i class="icon-trash icon-white"></i>Borrar</a><br /><br />';
            $acciones .= '<a class="btn btn-small btn-success" href="mainpanel/catalogo/listadosubcats/'.$value["id_categoria"].'"><i class="icon-th-list icon-white"></i>  Subcategorias</a><br /><br />';                      
            $acciones .= '<a class="btn btn-small btn-success" href="mainpanel/catalogo/nuevasubcat/'.$value["id_categoria"].'"><i class="icon-file icon-white"></i>  Nueva Subcategoria</a>';
            $nestedData[] = $acciones;
            $data[] = $nestedData;
        }
        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),
                    "recordsTotal"    => intval( $totalData ),
                    "recordsFiltered" => intval( $totalFiltered ),
                    "data"            => $data
                    );
        echo json_encode($json_data);
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
        $incluir_en_inventario = $this->input->post('incluir_en_inventario');
        $data = array('nombre_categoria'=>$nombre_categoria, 'orden'=>$orden, 'estado'=>$estado, 'tipo'=>$tipo, 'incluir_en_inventario'=>$incluir_en_inventario);
        
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
        $id_categoria = $this->uri->segment(4);
        // HALLAMOS PRIMERO LA LISTA DE SUBCATEGORIAS DE ESTA CATEGORIA     
        $aux = $this->Catalogo_model->getListaSubCategorias($id_categoria);
        foreach($aux as $subcategoria)
        {
            // RECORREMOS LAS SUBCATEGORIAS
            $id_subcategoria = $subcategoria->id_subcategoria;
            // BORRAMOS EN TABLA productos_x_subcategoria TODOS LOS REGISTROS RELACIONADOS A ESTA SUBCATEGORIA
            $this->Catalogo_model->deleteProductoxSubCats2($id_subcategoria);
            // BORRAMOS LA SUBCATEGORIA
            $this->Catalogo_model->deleteSubCategoria($id_subcategoria);
        } // foreach subcategorias
        // Borramos la imagen de las categoria
        $categoria = $this->Catalogo_model->getCategoria($id_categoria);
	   $imagen = $categoria->imagen;
        @unlink('files/categorias/'.$imagen);
        //Borramos la categoria
        $this->Catalogo_model->deleteCategoria($id_categoria);
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
        $incluir_en_inventario = $this->input->post('incluir_en_inventario');
        $data = array('nombre_categoria'=>$nombre, 'orden'=>$orden, 'estado'=>$estado, 'tipo'=>$tipo, 'incluir_en_inventario'=>$incluir_en_inventario);
        
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
    
    public function listadosubcats() {
        $this->validacion->validacion_login();
        //GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/lista_subcategorias";
        // LISTA SUB CATEGORIAS CATALOGO
        $id_categoria = $this->uri->segment(4);
        $aux2 = $this->Catalogo_model->getNombreCategoria($id_categoria);
        $nombre_categoria = $aux2->nombre_categoria;

        $dataPrincipal["idCategoria"] = $id_categoria;
        $dataPrincipal["nombre_categoria"] = $nombre_categoria;
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    public function ajaxListaSubcat() {
        $id_categoria = $this->uri->segment(4);
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre', 1 => 'orden');

        $totalData = $this->Datatable->numSubCategorias($id_categoria);
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR orden LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchSubCategorias($id_categoria, $where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchSubCategorias($id_categoria, $where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["nombre"];
            $numero_productos  = $this->Catalogo_model->numeroProductos($value['id_subcategoria']);
            $nestedData[] = $numero_productos;
            $nestedData[] = $value["orden"];
            $nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>':'<span class="label label-important">INACTIVO</span>';
            $acciones = '<a class="btn btn-info" href="mainpanel/catalogo/editsubcat/'.$value["id_subcategoria"].'"><i class="icon-edit icon-white"></i>  Editar</a>&nbsp;&nbsp;';
            $acciones .= '<a class="btn btn-danger" href="javascript:deleteSubCategoria(\''.$value["id_subcategoria"].'\', \''.$numero_productos.'\')"><i class="icon-trash icon-white"></i>Borrar</a>&nbsp;&nbsp;';
            $acciones .= '<a class="btn btn-small btn-success" href="mainpanel/catalogo/listado_productos/'.$value["id_subcategoria"].'"><i class="icon-th-list icon-white"></i>  Productos</a><br>';
            $acciones .= ($numero_productos>0)? '<a class="btn btn-small btn-info" href="mainpanel/catalogo/ordenar_producto/'.$value["id_subcategoria"].'"><i class="icon-th icon-white"></i>  Ordenar Producto</a>&nbsp;&nbsp;':'';
            $acciones .= '<a class="btn btn-small btn-success" href="mainpanel/catalogo/mantto/'.$value["id_subcategoria"].'"><i class="icon-th icon-white"></i>  Actualizar Precios / Stock</a>';
            $nestedData[] = $acciones;
            $data[] = $nestedData;
        }
        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),
                    "recordsTotal"    => intval( $totalData ),
                    "recordsFiltered" => intval( $totalFiltered ),
                    "data"            => $data
                    );
        echo json_encode($json_data);
    }

    public function deleteSubCat() {
        $id_subcategoria = $this->uri->segment(4);
        // OBTENEMOS LOS DATOS DE LA SUBCATEGORIA
        $subcategoria = $this->Catalogo_model->getSubCategoria($id_subcategoria);
        $id_categoria = $subcategoria->id_categoria;
        // BORRAMOS EN TABLA productos_x_subcategoria TODOS LOS REGISTROS RELACIONADOS A ESTA SUBCATEGORIA
        $this->Catalogo_model->deleteProductoxSubCats2($id_subcategoria);
        // BORRAMOS LA SUBCATEGORIA
        $this->Catalogo_model->deleteSubCategoria($id_subcategoria);
        redirect('mainpanel/catalogo/listadosubcats/'.$id_categoria.'/success');        
    }
    
    public function nuevasubcat() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/nuevo_view_subcat";
        // NUEVA SUB CATEGORIA
        $id_categoria= $this->uri->segment(4);
        $resultado= $this->uri->segment(5);        
        switch ($resultado){
            case "error":
                $error= $this->uri->segment(6);                
                $dataPrincipal["error"]= $error;
            break;
        
            default:
                $error = '';
        }
        $dataPrincipal["id_categoria"]= $id_categoria;
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
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
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function editsubcat() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/edit_view_subcat";
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
        // EDIT CSUBCATEGORIA
        $id_subcategoria = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $subcategoria = $this->Catalogo_model->getSubCategoria($id_subcategoria);
        $dataPrincipal['subcategoria'] = $subcategoria;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function grabarsubcat() {
        $this->validacion->validacion_login();
        // GRABAR SUBCATEGORIA
        $id_categoria = $this->input->post('id_categoria');
        $nombre = $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('id_categoria'=>$id_categoria, 'nombre'=>$nombre, 'orden'=>$orden, 'estado'=>$estado);
        $resultado = $this->Catalogo_model->grabarSubCategoria($data);
        if($resultado==1)
        {
            redirect('mainpanel/catalogo/listadosubcats/'.$id_categoria.'/success');
        }
        else
        {
            redirect('mainpanel/catalogo/nuevasubcat/error/bd');
        }
    }
    
    public function actualizarsubcat() {
        $this->validacion->validacion_login();
        // GRABAR SUBCATEGORIA
        $id_subcategoria = $this->input->post('id_subcategoria');
        $id_categoria = $this->input->post('id_categoria');
        $nombre = $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('id_categoria'=>$id_categoria, 'nombre'=>$nombre, 'orden'=>$orden, 'estado'=>$estado);
        $this->Catalogo_model->actualizarSubCategoria($id_subcategoria, $data);
        redirect('mainpanel/catalogo/editsubcat/'.$id_subcategoria.'/success');
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
        $dataPrincipal["cuerpo"] = "catalogo/index_view_producto";
		
        $id_subcategoria = $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA CATEOGRIA		
        $fila_categoria= $this->Catalogo_model->getSubCategoria($id_subcategoria);
	    $nombre_categoria=$fila_categoria->nombre;
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

        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["id_subcategoria"] = $id_subcategoria;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function ajaxListaProductos() {
        $id_subcategoria = $this->uri->segment(4);
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre', 1 => 'codigo', 2 => 'actualizacion');

        $totalData = $this->Datatable->numProductos($id_subcategoria);
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR codigo LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR actualizacion LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchProducto($id_subcategoria, $where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchProducto($id_subcategoria, $where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $foto = $value["imagen"];
            if(is_file('files/productos_thumbs/'.$foto)){
                $pic = '<img src="files/productos_thumbs/'.$foto.'" width="72" />';
            }else{
                $pic = '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="72" />';
            }
            if($value['tipo']==0){$tipo='Publico';}else{$tipo='VIP';}
            $nestedData[] = $pic;
            $nestedData[] = $value["nombre"];
            $nestedData[] = $value["codigo"];
            $nestedData[] = $tipo;
            $nestedData[] = $value["orden"];
            $nestedData[] = '<input type="checkbox" name="del" value="'.$value["id_producto"].'" id="'.$value["id_producto"].'" onclick="concatena('.$value["id_producto"].')">';
            $nestedData[] = '<a class="btn btn-mini btn-inverse" href="mainpanel/catalogo/edit_producto/'.$value["id_producto"].'"><i class="icon-edit icon-white"></i>  Editar</a>
                <a class="btn btn-mini btn-danger" href="javascript:deleteProducto(\''.$value["id_producto"].'\', \''.$id_subcategoria.'\')"><i class="icon-trash icon-white"></i>Borrar</a>
                
                <a class="btn btn-mini btn-success" href="mainpanel/catalogo/colores/'.$value["id_producto"].'"><i class="icon-picture icon-white"></i>Colores</a>';
                //<a class="btn btn-mini btn-primary" href="mainpanel/catalogo/fotos/'.$value["id_producto"].'"><i class="icon-picture icon-white"></i>Fotos</a>
            $nestedData[] = $value["actualizacion"];
            $data[] = $nestedData;
        }
        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),
                    "recordsTotal"    => intval( $totalData ),
                    "recordsFiltered" => intval( $totalFiltered ),
                    "data"            => $data
                    );
        echo json_encode($json_data);
    }

    public function listaProximos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/index_proximos";
		
        $id_subcategoria= $this->uri->segment(4);
        // CONTENIDO SECCION
        $proximos = $this->Catalogo_model->getListaProximos();
        $dataPrincipal["proximos"] = $proximos;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizaProximos() {
        $num_proximos = $this->input->post('num_items');
        for($i=0; $i<$num_proximos; $i++)
        {
            $data = array();
            $id_registro = $this->input->post('id_registro_'.$i);
            $data['stock_proximamente'] = $this->input->post('stock_prox_'.$i);
            $fecha_llegada = $this->input->post('fecha_'.$i);
            if($fecha_llegada!="")
            {
                $data['fecha_llegada'] = dmY_2_Ymd($this->input->post('fecha_'.$i));
            }
            else
            {
                $data['fecha_llegada'] = '';
            }            
            $data['precio_proximamente'] = $this->input->post('precio_'.$i);
            $data['orden_proximamente'] = $this->input->post('orden_'.$i);
            $this->Catalogo_model->updateStockColor($id_registro, $data);
        }
        $this->session->set_flashdata('resultado', 'Los datos se actualizaron correctamente!');
        redirect('mainpanel/catalogo/listaProximos'); 
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
		
        $id_subcategoria= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA SUB CATEOGRIA		
        $fila_subcategoria = $this->Catalogo_model->getSubCategoria($id_subcategoria);
	   $nombre_subcategoria = $fila_subcategoria->nombre;
        $dataPrincipal["nombre_subcategoria"] = $nombre_subcategoria;

        // LISTA PRODUCTOS CATALOGO
        $aux = $this->Catalogo_model->getListaProductos($id_subcategoria);
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

        $dataPrincipal["id_subcategoria"] = $id_subcategoria;
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
        $dataPrincipal["cuerpo"]="catalogo/edit_view_producto_nuevo";
        
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
        
        // ENVIA LISTA DE SUBCATEGORIAS
        $aux_sc = $this->Catalogo_model->getListaSubCategorias_x_Prod($id_producto);
        $subcats_x_prod = array();
        $concatenado = array();
        foreach($aux_sc as $registro)
        {
            $aux2 = array();
            $id_subcategoria = $registro->id_subcategoria;
            $subcategoria = $this->Catalogo_model->getSubCategoria($id_subcategoria);
            $id_categoria = $subcategoria->id_categoria;
            $categoria = $this->Catalogo_model->getCategoria($id_categoria);
            $aux2['id_subcategoria'] = $id_subcategoria;
            $aux2['nombre_categoria'] = $categoria->nombre_categoria;
            $aux2['nombre_subcategoria'] = $subcategoria->nombre;
            $subcats_x_prod[] = $aux2;
            $concatenado[] = $id_subcategoria;
        }
        $dataPrincipal["subcats_x_prod"] = $subcats_x_prod;
        $dataPrincipal["concatenado"] = implode("#", $concatenado);
        
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
        /*$aux = $this->Catalogo_model->getColores($id_producto);
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
            $aux2['stock_proximamente'] = $col->stock_proximamente;
            $aux2['fecha_llegada'] = Ymd_2_dmY($col->fecha_llegada);
            $aux2['precio_proximamente'] = $col->precio_proximamente;
            $aux2['orden_proximamente'] = $col->orden_proximamente;
            $colores[] = $aux2;
        }
        $dataPrincipal["colores"] = $colores;*/
        
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
        $selectCat = $this->Catalogo_model->getSubCategoria($producto->id_categoria);
        $subcategorias = (!empty($selectCat))? $this->Catalogo_model->getListaSubCategorias($selectCat->id_categoria) : array();
        $dataPrincipal['producto'] = $producto;
        $dataPrincipal['selectCat'] = $selectCat;
        $dataPrincipal['subcategorias'] = $subcategorias;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar_producto() {
        $this->validacion->validacion_login();
        // RECEPCIONO LOS VALORES
        //$id_categoria_padre = $this->input->post('id_categoria_padre'); 
        $id_categoria = $this->input->post('id_categoria');       
        $id_categoria_padre = '';
        $subcats_elegidas = $this->input->post('subcats_elegidas');
        $id_producto = $this->input->post('id_producto');
        $nombre = $this->input->post('nombre');
        $codigo = $this->input->post('codigo');
        //$precio= $this->input->post('precio');
        $precio = '';
        $orden= $this->input->post('orden');
        //$tipo = $this->input->post('tipo');
        $tipo = "1";
        //$colores = $this->input->post('elegidos');
        $colores = '';
        //$oferta = $this->input->post('oferta');
        $oferta = '0';
	   //$orden_proximamente = $this->input->post('orden_proximamente');
        $novedad = $this->input->post('novedad');
	   $orden_novedad = $this->input->post('orden_novedad');
        $fotoantg= $this->input->post('fotoantg');
        //$stock = $this->input->post('stock');
        $show_stock = $this->input->post('show_stock'); 
	   $descuento_especial = $this->input->post('descuento_especial'); 
        $descripcion = $this->input->post('descripcion');
        $material = $this->input->post('material');
        $medidas = $this->input->post('medidas');
        $medidas_caja = $this->input->post('medidas_caja');
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
        /*$id_concatenados= $this->input->post('id_concatenados');
        $cad = explode("@",$id_concatenados);
        $data5 = array();
        for ($r=0;$r<count($cad);$r++)
        {
            $curr = explode("#", $cad[$r]);
            $id_color = $curr[0];
            $stock = $curr[1];
            $stock_prox = $curr[2];
            $fecha_llegada = $curr[3];
            $precio_prox = $curr[4];
            $orden_prox = $curr[5];
            $nombreColor = $curr[6];
            $codigoColor = $curr[8];
            $data2=array();
            $data2['stock']=$stock;
            $data2['stock_proximamente'] = $stock_prox;
            $data2['fecha_llegada'] = $fecha_llegada;
            $data2['precio_proximamente'] = $precio_prox;
            $data2['orden_proximamente'] = $orden_prox;
            $data2['id_color'] = $id_color;
            $data5[] = $data2;
        }*/
        //***********************
        
        $data = array();
        $data['id_categoria']=$id_categoria;
        $data['nombre']=$nombre;
        $data['codigo']=$codigo;
        $data['precio']=$precio;
        $data['orden']=$orden;
        $data['nivel']='1';        
        $data['tipo']=$tipo;
        $data['colores']=$colores;        
        $data['oferta']=$oferta; 
            //$data['orden_proximamente']=$orden_proximamente;       
        $data['novedad']=$novedad;
	   $data['orden_novedad']=$orden_novedad;
            //$data['id_categoria_padre']=$id_categoria_padre;
            //$data['stock']=$stock;
        $data['show_stock']=$show_stock; 
        $data['descripcion']=$descripcion;
	   $data['descuento_especial'] = $descuento_especial;
        $data['material']=$material;
        $data['medidas']=$medidas;
        $data['medidas_caja']=$medidas_caja;
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
            // GRABAR SUBCATEGORIAS ELEGIDAS
            $this->Catalogo_model->actualizarSubCatsElegidas($id_producto, $subcats_elegidas);
            
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
            
            /*$this->Catalogo_model->deleteColor($id_producto);            
            
            for($d=0;$d<count($data5);$d++)
            {
                $current=$data5[$d];
                $envia_dato=array();
                $envia_dato['stock'] = $current['stock'];
                $envia_dato['stock_proximamente'] = $current['stock_proximamente'];
                if($current['fecha_llegada']!="")
                {
                    $envia_dato['fecha_llegada'] = dmY_2_Ymd($current['fecha_llegada']);
                }
                else
                {
                    $envia_dato['fecha_llegada'] = '';
                }                
                $envia_dato['precio_proximamente'] = $current['precio_proximamente'];
                $envia_dato['orden_proximamente'] = $current['orden_proximamente'];
                $envia_dato['id_color'] = $current['id_color'];
                $envia_dato['id_producto'] = $id_producto;
                $resultado=$this->Catalogo_model->grabarColor($envia_dato);
            } */           
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
        // NUEVO PRODUCTO 
        //$id_categoria= $this->uri->segment(4);
        $resultado = $this->uri->segment(4);        
        switch ($resultado){
            case "error":
                $error= $this->uri->segment(5);                
                $dataPrincipal["error"]= $error;
            break;
        }
        //$dataPrincipal["id_categoria"]= $id_categoria;
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
        $id_categoria = $this->input->post('id_categoria');
        $id_categoria_padre= '';
        $subcats_elegidas = $this->input->post('subcats_elegidas');
        $nombre= $this->input->post('nombre');
        $codigo = $this->input->post('codigo');        
        $orden = $this->input->post('orden');
        //$precio = $this->input->post('precio');
        $precio = '';
        //$tipo = $this->input->post('tipo');
        $tipo = "1";
        //$oferta = $this->input->post('oferta');
        $oferta = '0';
        $novedad = $this->input->post('novedad');
        //$elegidos = $this->input->post('elegidos');
        $elegidos = '0';
        //$stock= $this->input->post('stock');
        $stock= '0';
        $show_stock = $this->input->post('show_stock');
        $descripcion = $this->input->post('descripcion');
	   $descuento_especial = $this->input->post('descuento_especial'); 
        $material = $this->input->post('material');
        $medidas = $this->input->post('medidas');
        $medidas_caja = $this->input->post('medidas_caja');
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
        /*$id_concatenados= $this->input->post('id_concatenados');
        $cad = explode("@",$id_concatenados);
        $data4 = array();
        for ($r=0;$r<count($cad);$r++)
        {
            $curr = explode("#", $cad[$r]);
            $id_color = $curr[0];
            $stock = $curr[1];
            $stock_prox = $curr[2];
            $fecha_llegada = $curr[3];
            $precio_prox = $curr[4];
            $orden_prox = $curr[5];
            $nombreColor = $curr[6];
            $codigoColor = $curr[8];
            $data2=array();
            $data2['stock']=$stock;
            $data2['stock_proximamente'] = $stock_prox;
            $data2['fecha_llegada'] = $fecha_llegada;
            $data2['precio_proximamente'] = $precio_prox;
            $data2['orden_proximamente'] = $orden_prox;
            $data2['id_color'] = $id_color;
            $data4[] = $data2;
        }*/
        
        /*
        $cad=explode("##",$id_concatenados);
        $data4=array();
        for ($r=0;$r<count($cad);$r++) {
            $id=$cad[$r];
            $stock= $this->input->post('stock_c_'.$id);
            $stock_proximamente = $this->input->post('cant_c_'.$id);
            $precio_proximamente = $this->input->post('precio_c_'.$id);
            $orden_proximamente = $this->input->post('orden_c_'.$id);
            $fecha_llegada = $this->input->post('fecha_c_'.$id);
            $id_color= $this->input->post('idcolor_'.$id);            
            
            if($id_color<>'' and $stock<>''){
                $data2=array();
                $data2['stock']=$stock;
                $data2['stock_proximamente'] = $stock_proximamente;
                $data2['fecha_llegada'] = $fecha_llegada;
                $data2['precio_proximamente'] = $precio_proximamente;
                $data2['orden_proximamente'] = $orden_proximamente;
                $data2['id_color']=$id_color;
                $data4[]=$data2;
            }
        }
        */
        
        $data = array();
        $data['id_categoria'] = $id_categoria;
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
        $data['medidas_caja']=$medidas_caja;
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
                
                // GRABAR SUBCATEGORIAS ELEGIDAS
                $this->Catalogo_model->grabarSubCatsElegidas($id_producto, $subcats_elegidas);
                
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
                
                /*for($d=0;$d<count($data4);$d++){
                    $current=$data4[$d];
                    $envia_dato=array();
                    $envia_dato['stock'] = $current['stock'];
                    $envia_dato['stock_proximamente'] = $current['stock_proximamente'];
                    if($current['fecha_llegada']!="")
                    {
                        $envia_dato['fecha_llegada'] = dmY_2_Ymd($current['fecha_llegada']);
                    }
                    else
                    {
                        $envia_dato['fecha_llegada'] = '0000-00-00';
                    }
                    
                    $envia_dato['precio_proximamente'] = $current['precio_proximamente'];
                    $envia_dato['orden_proximamente'] = $current['orden_proximamente'];
                    $envia_dato['id_color'] = $current['id_color'];
                    $envia_dato['id_producto'] = $id_producto;
                    $resultado=$this->Catalogo_model->grabarColor($envia_dato);
                } */               
                
                if($resultado==1)
                {
                    $aux_sc = explode("#", $subcats_elegidas);
                    //redirect('mainpanel/catalogo/listado_productos/'.$id_categoria_padre.$precio.'/success');
                    redirect('mainpanel/catalogo/listado_productos/'.$aux_sc[0].'/success');
                }
                else
                {
                    //redirect('mainpanel/catalogo/nuevo_producto/'.$id_categoria_padre.$precio.'/error/bd');
                    redirect('mainpanel/catalogo/nuevo_producto/error/bd');
                }
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                //redirect('mainpanel/catalogo/nuevo_producto/'.$id_categoria_padre.'/error/'.$error);
                redirect('mainpanel/catalogo/nuevo_producto/error/'.$error);
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
        $id_subcategoria = $this->uri->segment(5);
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
        $this->Catalogo_model->deleteProductoxSubCats($id_producto);
        redirect('mainpanel/catalogo/listado_productos/'.$id_subcategoria.'/success');
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
		
        $id_subcategoria= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA SUB CATEOGRIA		
        $fila_subcategoria= $this->Catalogo_model->getSubCategoria($id_subcategoria);
	   $nombre_subcategoria=$fila_subcategoria->nombre;
        $dataPrincipal["nombre_subcategoria"] = $nombre_subcategoria;
        // LISTA PRODUCTOS CATALOGO
        $aux = $this->Catalogo_model->getListaProductos($id_subcategoria);
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
        $dataPrincipal["id_subcategoria"] = $id_subcategoria;
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
            $aux2['foto_empaque'] = $fot->foto_empaque;
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
                
                $this->my_upload->upload($_FILES["foto2"]);
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
                        $data['foto_empaque'] = $this->my_upload->file_dst_name;
                    }
                }
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
        $fotos = $this->Catalogo_model->getfoto($id_foto);
        $dataPrincipal['fotos'] = $fotos;
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
                //$this->my_upload->clean();
            } else {
                $error = $this->my_upload->error;
            }
        }
        
        /*********** FOTO EMPAQUE **************/
        $this->my_upload->upload($_FILES["foto2"]);
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
                $data['foto_empaque'] = $this->my_upload->file_dst_name;               
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
        
        $foto_empaque =$producto->foto_empaque;
        @unlink('files/thumbnails_fotografias/'.$foto_empaque);
        @unlink('files/fotografias/'.$foto_empaque);
        
        $this->Catalogo_model->deleteFoto($id_fp);
        redirect('mainpanel/catalogo/fotos/'.$id_prod.'/success');
    }

    #COLOR FOTOS
    /***********************************************/
    public function colores() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/lista_color_fotos";
        
        $id_producto= $this->uri->segment(4);
        $fila_producto= $this->Catalogo_model->getProducto($id_producto);
        $dataPrincipal['nombre_producto'] = $fila_producto->nombre;
        $dataPrincipal['id_categoria_padre'] = $fila_producto->id_categoria_padre; 
        $dataPrincipal["id_producto"] = $id_producto;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    public function ajaxListaColores() {
        $id_producto = $this->uri->segment(4);
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre', 1 => 'color');

        $totalData = $this->Datatable->numFotosColores($id_producto);

        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( c.color LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR c.nombre LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->SearchFotosColores($id_producto, $where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->SearchFotosColores($id_producto, $where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = '<span class="colorList" style="background-color:'.$value["color"].';"></span>&nbsp;&nbsp;'.$value["nombre"];

            $nestedData[] = '<a class="btn btn-mini btn-inverse" href="mainpanel/catalogo/edit_color_foto/'.$value["id"].'/'.$value["id_producto"].'"><i class="icon-edit icon-white"></i>  Editar</a>
                <a class="btn btn-mini btn-danger" href="javascript:deleteColorFoto(\''.$value["id"].'\', \''.$id_producto.'\')"><i class="icon-trash icon-white"></i>Borrar</a>';
            $data[] = $nestedData;
        }
        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),
                    "recordsTotal"    => intval( $totalData ),
                    "recordsFiltered" => intval( $totalFiltered ),
                    "data"            => $data
                    );
        echo json_encode($json_data);
    }

    public function nuevo_color_foto() {
        $this->validacion->validacion_login();
        
        if ($_POST) {
            $data = $_POST;
            // GRABAR
            $data['imagen1'] = ($_FILES["imagen1"])? uploadImagen($_FILES["imagen1"]): '';
            $data['imagen2'] = ($_FILES["imagen2"])? uploadImagen($_FILES["imagen2"]): '';
            $data['imagen3'] = ($_FILES["imagen3"])? uploadImagen($_FILES["imagen3"]): '';
            $data['imagen4'] = ($_FILES["imagen4"])? uploadImagen($_FILES["imagen4"]): '';
            if($data['fecha_llegada']!="") {
                $data['fecha_llegada'] = dmY_2_Ymd($data['fecha_llegada']);
            } else {
                $data['fecha_llegada'] = '0000-00-00';
            }
            unset($data['cat_color']);
            //echo '<pre>';print_r($data);echo '</pre>';die;
            $resultado = $this->Catalogo_model->grabarColor($data);
            if($resultado==1) {
                $this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>RESULTADO:</strong> La operación se realizó con éxito.</div>');
                redirect('mainpanel/catalogo/colores/'.$data['id_producto']);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>RESULTADO:</strong> Ocurrio un error al actualizar los datos.</div>');
                redirect('mainpanel/catalogo/nuevo_color_foto/'.$data['id_producto']);
            }
            
        }
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/nuevo_color_foto";

        // NUEVA FOTOGRAFIA
        $id_producto= $this->uri->segment(4);
        $dataPrincipal["familias"] = $this->Catalogo_model->getListaFamilia();
        $dataPrincipal["id_producto"]= $id_producto;
        $this->load->view("mainpanel/includes/template", $dataPrincipal); 
        
    }

    public function edit_color_foto() {
        $this->validacion->validacion_login();
        $id_color = $this->uri->segment(4);
        //$id_producto = $this->uri->segment(5);

        if ($_POST) {
            $data = $_POST;
            // GRABAR
            
            $data['imagen1'] = (!empty($_FILES['imagen1'])&&($_FILES["imagen1"]['error']=='0'))? uploadImagen($_FILES["imagen1"]): $data['img1'];
            $data['imagen2'] = (!empty($_FILES['imagen2'])&&($_FILES["imagen2"]['error']=='0'))? uploadImagen($_FILES["imagen2"]): $data['img2'];
            $data['imagen3'] = (!empty($_FILES['imagen3'])&&($_FILES["imagen3"]['error']=='0'))? uploadImagen($_FILES["imagen3"]): $data['img3'];
            $data['imagen4'] = (!empty($_FILES['imagen4'])&&($_FILES["imagen4"]['error']=='0'))? uploadImagen($_FILES["imagen4"]): $data['img4'];
            unset($data['cat_color']);
            unset($data['img1']);
            unset($data['img2']);
            unset($data['img3']);
            unset($data['img4']);
            if($data['fecha_llegada']!="") {
                $data['fecha_llegada'] = dmY_2_Ymd($data['fecha_llegada']);
            } else {
                $data['fecha_llegada'] = '0000-00-00';
            }
            //print_r($data);die;
            $update = $this->Catalogo_model->updateStockColor($id_color, $data);
            if($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>RESULTADO:</strong> La operación se realizó con éxito.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>RESULTADO:</strong> Ocurrio un error al actualizar los datos.</div>');
            }
            redirect('mainpanel/catalogo/edit_color_foto/'.$id_color);
        }
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="catalogo/edit_color_foto";

        // NUEVA FOTOGRAFIA
        
        $dataPrincipal["familias"] = $this->Catalogo_model->getListaFamilia();
        $dataColor = $this->Catalogo_model->getColorById($id_color);
        
        $dataPrincipal["data"] = $dataColor;
        $dataPrincipal["colores"] = $this->Catalogo_model->muestraColor($dataColor['id_cat']);
        //echo '<pre>';print_r($dataPrincipal["colores"]);echo '</pre>';die;
        $dataPrincipal["id_color"]= $id_color;
        $this->load->view("mainpanel/includes/template", $dataPrincipal); 
    }

    public function delete_color_foto() {
        $this->validacion->validacion_login();
        $id_fp = $this->uri->segment(4);
        $color = $this->Catalogo_model->getColorById($id_fp);
        $id_color=$color['id'];
        $id_producto=$color['id_producto'];
        for ($i=1; $i < 4; $i++) { 
            @unlink('files/thumbnails_fotografias/'.$color['imagen'.$i]);
            @unlink('files/fotografias/'.$color['imagen'.$i]);
            @unlink('files/fotografias_medianas/'.$color['imagen'.$i]);
        }
        
        $delete = $this->Catalogo_model->deleteColorFoto($id_color);
        if($delete) {
            $this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>RESULTADO:</strong> La operación se realizó con éxito.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>RESULTADO:</strong> Ocurrio un error al actualizar los datos.</div>');
        }
        redirect('mainpanel/catalogo/colores/'.$id_producto);
    }
    
}
?>