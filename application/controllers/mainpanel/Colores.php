<?php
class Colores extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Colores_model');
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
        $data['modal'] = $this->load->view('mainpanel/colores/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="colores/index_view";
        
        // LISTA CATEGORIAS colores
        /*$aux = $this->Colores_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id'] = $categoria->id;
            $aux2['nombre'] = $categoria->nombre;
            $aux2['numero_colores'] = $this->Colores_model->numeroColores($categoria->id);
            $aux2['orden'] = $categoria->orden;
            $aux2['estado'] = $categoria->estado;
            $categorias[] = $aux2;
        }

        $dataPrincipal["categorias"] = $categorias;*/
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaCatColores()
    {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre');

        $totalData = $this->Datatable->numCatColores();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( nombre LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchCatColores($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchCatColores($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["nombre"];
            $numero_colores = $this->Colores_model->numeroColores($value["id"]);
            $nestedData[] = $numero_colores;
            $nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>':'<span class="label label-important">INACTIVO</span>';
            $nestedData[] = $value["orden"];
            $nestedData[] = '<a class="btn btn-info" href="mainpanel/colores/edit/'.$value["id"].'"><i class="icon-edit icon-white"></i>  Editar</a> 
                            <a class="btn btn-danger" href="javascript:deleteCategoriaColor(\''.$value["id"].'\', \''.$numero_colores.'\')"><i class="icon-trash icon-white"></i>Borrar</a><br /><br />
                            <a class="btn btn-small btn-success" href="mainpanel/colores/listado_colores/'.$value["id"].'"><i class="icon-th-list icon-white"></i>  Colores</a> 
                            <a class="btn btn-small btn-success" href="mainpanel/colores/nuevo_color/'.$value["id"].'"><i class="icon-file icon-white"></i>  Nuevo Color</a><br /><br />';
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
        $dataPrincipal["cuerpo"]="colores/edit_view";
        // EDIT colores
        $id= $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $categoria = $this->Colores_model->getCategoria($id);
        $dataPrincipal['categoria'] = $categoria;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR CATEGORIA
        $id= $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('nombre'=>$nombre, 'orden'=>$orden, 'estado'=>$estado);

        $this->Colores_model->updateCategoria($id, $data);
        redirect('mainpanel/colores/edit/'.$id.'/success');
    }
    
    public function delete() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $this->Colores_model->deleteColores($id_registro);
        $this->Colores_model->deleteCategoria($id_registro);
        redirect('mainpanel/colores/listado/success');
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
        $dataPrincipal["cuerpo"]="colores/nuevo_view";
        
        
        // NUEVA FAMILIA
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
        $data = array('nombre'=>$nombre, 'orden'=>$orden, 'estado'=>$estado);
        $resultado = $this->Colores_model->grabarCategoria($data);
        if($resultado==1)
        {
            redirect('mainpanel/colores/listado/success');
        }
        else
        {
            redirect('mainpanel/colores/nuevo/error/bd');
        }

    }
	
    
    public function listado_colores() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/colores/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="colores/index_view_color";
		
        $id= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA FAMILIA		
        $fila_categoria= $this->Colores_model->getCategoria($id);
	    $nombre=$fila_categoria->nombre;
        $dataPrincipal["nombre"] = $nombre;
        // ENVIA LISTA DE CATEGORIAS
        $aux = $this->Colores_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id'] = $categoria->id;
            $aux2['nombre'] = $categoria->nombre;
            $categorias[] = $aux2;
        }
        $dataPrincipal["categorias"] = $categorias;           

        // LISTA colores
        /*$aux = $this->Colores_model->getListaColores($id);
        $colores = array();
        foreach($aux as $color)
        {
            $aux2 = array();
            $aux2['id'] = $color->id;
            $aux2['nombre'] = $color->nombre;            
            $aux2['orden'] = $color->orden;
            $aux2['estado'] = $color->estado; 
            $aux2['color'] = $color->color;
            $colores[] = $aux2;
        }
        $dataPrincipal["colores"] = $colores;*/

        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["id_categoria"] = $id;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    public function ajaxListaColores()
    {
        $categoria_id = $this->uri->segment(4);
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre',1 => 'color');

        $totalData = $this->Datatable->numColores($categoria_id);
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR color LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchColores($categoria_id, $where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchColores($categoria_id, $where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = '<div style="background:'.$value["color"].'; width:50px;height:50px;border:#000 solid 1px;"</div>';
            $nestedData[] = $value["nombre"];
            $nestedData[] = $value["orden"];
            $nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>':'<span class="label label-important">INACTIVO</span>';
            $nestedData[] = '<a class="btn btn-mini btn-inverse" href="mainpanel/colores/edit_color/'.$value["id"].'"><i class="icon-edit icon-white"></i>  Editar</a> 
                            <a class="btn btn-mini btn-danger" href="javascript:deleteColor(\''.$value["id"].'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
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
    
    public function edit_color() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/colores/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="colores/edit_view_color";
        
        // EDIT PRODUCTO
        $id_color = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        
        // ENVIA LISTA DE CATEGORIAS
        $aux = $this->Colores_model->getListaCategorias();
        $categorias = array();
        foreach($aux as $categoria)
        {
            $aux2 = array();
            $aux2['id'] = $categoria->id;
            $aux2['nombre'] = $categoria->nombre;
            $categorias[] = $aux2;
        }
        $dataPrincipal["categorias"] = $categorias;           
        
        $color = $this->Colores_model->getColor($id_color);
        $dataPrincipal['color'] = $color;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar_color() {
        $this->validacion->validacion_login();
        // RECEPCIONO LOS VALORES
        $id_categoria = $this->input->post('id_categoria');        
        $id_color = $this->input->post('id_color');
        $nombre = $this->input->post('nombre');
        $estado= $this->input->post('estado');
        $orden= $this->input->post('orden');
        $color= $this->input->post('rgb2');        
        
        $data = array();
        $data['nombre']=$nombre;
        $data['orden']=$orden;
        $data['estado']=$estado;
        $data['color']=$color;
        $data['id_categoria']=$id_categoria;    
        
        $this->Colores_model->updateColor($id_color,$data);
        redirect('mainpanel/colores/edit_color/'.$id_color.'/success');
        
    }
       
    public function nuevo_color() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="colores/nuevo_view_color";
        
        
        // NUEVO COLOR
        $id= $this->uri->segment(4);
        $aux=$this->Colores_model->getCategoria($id);
        $dataPrincipal["nombre_categoria"]=$aux->nombre;
        $dataPrincipal["id"]= $id;
        $resultado= $this->uri->segment(5);        
        switch ($resultado){
            case "error":
                $error= $this->uri->segment(6);                
                $dataPrincipal["error"]= $error;
            break;
        }        
        $dataPrincipal["resultado"]= $resultado;

        //*********************************        
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
        
    public function grabar_color() {
        $this->validacion->validacion_login();
        // GRABAR PRODUCTO
        $id_categoria= $this->input->post('id_categoria');
        $nombre= $this->input->post('nombre');
        $orden = $this->input->post('orden');
        $rgb2 = $this->input->post('rgb2');
        $estado = $this->input->post('estado');        
        

        $data = array();
        $data['id_categoria']=$id_categoria;        
        $data['nombre']=$nombre;
        $data['orden']=$orden;
        $data['color']=$rgb2;
        $data['estado']= $estado;
        $resultado = $this->Colores_model->grabarColor($data);
                 
        if($resultado==1)
        {
            redirect('mainpanel/colores/listado_colores/'.$id_categoria.'/success');
        }
        else
        {
            redirect('mainpanel/colores/nuevo_color/'.$id_categoria.'/error/bd');
        }

    }
    
    public function delete_color() {
        $this->validacion->validacion_login();
        $id_color = $this->uri->segment(4);
        $color = $this->Colores_model->getColor($id_color);
        $id_categoria=$color->id_categoria;        
        $this->Colores_model->deleteColor($id_color);

        redirect('mainpanel/colores/listado_colores/'.$id_categoria.'/success');
    }
    
    public function ordener_producto() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/colores/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="colores/order_producto";
		
        $id= $this->uri->segment(4);		
        // SOLICITO EL NOMBRE DE LA CATEOGRIA		
        $fila_categoria= $this->Colores_model->getCategoria($id);
	$nombre=$fila_categoria->nombre;
        $dataPrincipal["nombre"] = $nombre;
        // LISTA PRODUCTOS colores
        $aux = $this->Colores_model->getListaColores($id);
        $productos = array();
        foreach($aux as $producto)
        {
            $aux2 = array();
            $aux2['id_color'] = $producto->id_color;
            $aux2['nombre'] = $producto->nombre;
            $aux2['imagen'] = $producto->imagen;

            $productos[] = $aux2;
        }

        $dataPrincipal["productos"] = $productos;
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $dataPrincipal["id"] = $id;
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
            $this->Colores_model->ordProd($id,$data);        
            //$aux = "update productos set orden='$pos' where id_color='$id'";
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
        $data['modal'] = $this->load->view('mainpanel/colores/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="colores/lista_fotos";
		
        $id_color= $this->uri->segment(4);
        
        // SOLICITO EL NOMBRE DEL PRODUCTO	
        $fila_producto= $this->Colores_model->getProducto($id_color);
	$nombre_producto=$fila_producto->nombre;
	$id_padre=$fila_producto->id_padre;        
        $dataPrincipal['nombre_producto'] = $nombre_producto;
        $dataPrincipal['id_padre'] = $id_padre;        
        // ENVIA LISTA DE FOTOGRAFIAS
        $aux = $this->Colores_model->getFotosProductos($id_color);
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
        $dataPrincipal["id_color"] = $id_color;
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
        $dataPrincipal["cuerpo"]="colores/nuevo_view_foto";
        
        // NUEVA FOTOGRAFIA
        $id_color= $this->uri->segment(4);   
        // SOLICITO EL NOMBRE DEL PRODUCTO
        $fila_producto= $this->Colores_model->getProducto($id_color);
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
        $dataPrincipal["id_color"]= $id_color;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function grabar_foto() {
        $this->validacion->validacion_login();
        // GRABAR CATEGORIA
        $id_prod= $this->input->post('id_color');
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
                $resultado = $this->Colores_model->grabarFoto($data);
                if($resultado==1)
                {
                    redirect('mainpanel/colores/fotos/'.$id_prod.'/success');
                }
                else
                {
                    redirect('mainpanel/colores/fotos/'.$id_prod.'/error/bd');
                }
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                redirect('mainpanel/colores/fotos/'.$id_prod.'/error/'.$error);
            }
        }
        else
        {
            $error = formateaCadena($this->my_upload->error);
            redirect('mainpanel/colores/fotos/'.$id_prod.'/error/'.$error);
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
        $dataPrincipal["cuerpo"]="colores/edit_view_foto";
        
        // NUEVA FOTOGRAFIA
        $id_foto= $this->uri->segment(4);   
        // SOLICITO EL NOMBRE DEL PRODUCTO
        $foto= $this->Colores_model->getfoto($id_foto);
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
           redirect('mainpanel/colores/editar_foto/'.$id_fp.'/error');
        }else{
            $this->Colores_model->updateFoto($id_fp, $data);
            redirect('mainpanel/colores/editar_foto/'.$id_fp.'/success');           
        }
    }
           
    public function delete_foto() {
        $this->validacion->validacion_login();
        $id_fp = $this->uri->segment(4);
        $producto = $this->Colores_model->getfoto($id_fp);
        $foto=$producto->foto;
        $id_prod=$producto->id_prod;        
        @unlink('files/thumbnails_fotografias/'.$foto);
        @unlink('files/fotografias/'.$foto);
        $this->Colores_model->deleteFoto($id_fp);
        redirect('mainpanel/colores/fotos/'.$id_prod.'/success');
    }

    
}
?>
