<?php
class Clientes extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Cliente_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
        $this->load->library('My_PHPMailer');        
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function excel() {
        $this->validacion->validacion_login();
        $tipo = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $tipo;
        // LISTA CLIENTES
        switch($tipo)
        {
            case "activos":
                $aux = $this->Cliente_model->getListaClientes();
                $dataPrincipal['nombre_archivo'] = 'clientes_activos_'.time(); 
            break;
        
            case "anulados":
                $aux = $this->Cliente_model->getListaClientesAnulados();
                $dataPrincipal['nombre_archivo'] = 'clientes_anulados_'.time(); 
            break;
        
            case "borrados":
                $aux = $this->Cliente_model->getListaClientesBorrados();
                $dataPrincipal['nombre_archivo'] = 'clientes_borrados_'.time(); 
            break;
        
            case "inactivos":
                $aux = $this->Cliente_model->getListaClientesInactivo();
                $dataPrincipal['nombre_archivo'] = 'clientes_inactivos_'.time(); 
            break;
        }
        
        $clientes = array();
        foreach($aux as $cliente)
        {
            $aux2 = array();
            $aux2['id'] = $cliente->id;
            $aux2['razon_social'] = utf8_decode($cliente->razon_social);
            $aux2['fecha_registro'] = $cliente->fecha_registro;
            $aux2['codigo'] = $cliente->codigo_cliente;
            $aux2['estado'] = $cliente->estado;
            $aux2['email'] = $cliente->email;
            $ult=$this->Cliente_model->ultimoIngreso($cliente->email);
            if(count($ult)==0){$ultima='No registra ingresos';}else{$ultima=Ymd_2_dmY($ult->fecha_ingreso);}
            $aux2['ultimo_ingreso'] = $ultima;
            $aux2['ruc'] = $cliente->ruc;
            $aux2['telefono2'] = $cliente->telefono2;
            $aux2['telefono'] = $cliente->telefono;            
            $aux2['nombre'] = utf8_decode($cliente->nombre);
            $aux = $this->Cliente_model->getNumVisitas($cliente->email);
            $aux2['visitas'] =$aux;
            $clientes[] = $aux2;
        }
        $dataPrincipal['clientes'] = $clientes;
        $this->load->view("mainpanel/excel/clientes", $dataPrincipal);
    }
    
    public function listado() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/index_view";
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaClientes()
    {
        $requestData= $_REQUEST;
        $listaUrl = $this->uri->segment(4);
        if ($listaUrl=='activos') {
             $where = " estado='Activo' ";
             $estado = 'activos';
        }else if($listaUrl=='inactivos'){
             $where = " estado='Inactivo' ";
             $estado = 'inactivos';
        }else if($listaUrl=='anulados'){
             $where = " estado='Anulado' ";
             $estado = '';
        }else if($listaUrl=='borrados'){
             $where = " estado='Borrado' ";
             $estado = '';
        }
        $columns = array( 0 => 'razon_social', 1 => 'nombre', 2 => 'codigo_cliente');

        $totalData = $this->Datatable->numClientes($where);
        $totalFiltered = $totalData;
        
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( razon_social LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR codigo_cliente LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchClientes($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
        $query = $this->Datatable->searchClientes($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = '<strong>'.$value["razon_social"].'</strong><br>Persona contacto:'.$value["nombre"];
            $nestedData[] = ($value['nivel']=="administrador")?'ADMINISTRADOR':'VENDEDOR';
            if ($listaUrl=='activos') {
                $nestedData[] = $value['provincia'];
            }
            
            $nestedData[] = $value['codigo_cliente'];
            $nestedData[] = Ymd_2_dmY(substr($value['fecha_registro'],0,10));
            $nestedData[] = ($value['estado']=="Activo")? '<span class="label label-success">ACTIVO</span>': '<span class="label label-important">INACTIVO</span>';
            
            if($value['nivel']=="administrador"){
                $num_vendedores = $this->Cliente_model->numVendedores($value['id']);
            }else{
                $num_vendedores = 0;
            }
            $visitas = $this->Cliente_model->getNumVisitas($value['email']);
            $nestedData[] = $visitas.' <a class="label label-success" href="mainpanel/clientes/visitas/'.$value['id'].'">Ver</a>';
            if ($listaUrl=='activos') {
                $ult=$this->Cliente_model->ultimoIngreso($value['email']);
                $fecha = (count($ult)==0)? 'No registra ingresos' : Ymd_2_dmY($ult->fecha_ingreso);
                
            }else if($listaUrl=='inactivos'){
                $aux_3 = $this->Cliente_model->getFechaDesactivacion($value['id']);
                $fecha = (count($aux_3)==0)? '-----' : Ymd_2_dmY($aux_3->fecha);
            }else if($listaUrl=='anulados'){
                $aux_3 = $this->Cliente_model->getFechaAnulacion($value['id']);
                $fecha = (count($aux_3)==0)? '-----' : Ymd_2_dmY($aux_3->fecha);
            }else if($listaUrl=='borrados'){
                $aux_3 = $this->Cliente_model->getFechaBorrado($value['id']);
                $fecha = (count($aux_3)==0)? '-----' : Ymd_2_dmY($aux_3->fecha);
            }
            
            $nestedData[] = $fecha;
            $nestedData[] = $num_vendedores;
            $acciones = '<a class="btn btn-small btn-success" href="mainpanel/clientes/detalle/'.$value['id'].'"><i class="icon-file icon-white"></i> Ver Datos</a>';
            $acciones .= '<a class="btn btn-info" href="mainpanel/clientes/edit/'.$value['id'].'"><i class="icon-edit icon-white"></i> Editar</a><br><br>';
            /*$acciones .= ($num_vendedores==0)? '<a class="btn btn-danger" href="javascript:deleteCliente(\''.$value['id'].'\', \''.$value['razon_social'].'\', \''.$estado.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ':' ';*/
            $acciones .= ($num_vendedores==0)? '<a class="btn btn-danger" href="javascript:eliminarCliente(\''.$value['id'].'\', \''.$value['razon_social'].'\', \''.$estado.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ':' ';
            if($listaUrl=='borrados'){$acciones .= '<a class="btn btn-small btn-warning" href="javascript:recuperarCliente(\''.$value['id'].'\', \''.$value['razon_social'].'\')"><i class="icon-th-list icon-white"></i> Recuperar</a>';}
            $acciones .= ' <input type="checkbox" name="del" value="'.$value['id'].'" id="'.$value['id'].'" onclick="concatena('.$value['id'].')">';
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

    public function listado_anulados() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/lista_anulados";
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
	
    public function listado_borrados() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/lista_borrados";
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    
    
    public function listado_inactivos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/lista_inactivo";
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
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/edit_view";
        // EDIT CLIENTE
        $id_cliente = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $cliente = $this->Cliente_model->getCliente($id_cliente);
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR CLIENTE
        $id_cliente = $this->input->post('id_cliente');
        $razon_social = $this->input->post('razon_social');        
        $nombre = $this->input->post('nombre');        
        $ruc= $this->input->post('ruc');
        $cargo= $this->input->post('cargo');
        $domicilio= $this->input->post('domicilio');
        $distrito = $this->input->post('distrito');
        $ciudad= $this->input->post('ciudad');
        $provincia= $this->input->post('provincia');
        $departamento= $this->input->post('departamento');
        $pais= $this->input->post('pais');
        $procedencia = $this->input->post('procedencia');
        $zip= $this->input->post('zip');
        $telefono= $this->input->post('telefono');
        $telefono2= $this->input->post('telefono2');
        $fax= $this->input->post('fax');
        $web = $this->input->post('web');
        $tipo_cliente= $this->input->post('tipo_cliente');
        $email= $this->input->post('email');
        $clave= $this->input->post('clave');
        $tipo_cuenta= $this->input->post('tipo_cuenta');
        $ver_precio= $this->input->post('ver_precio');    
        $ver_inventario= $this->input->post('ver_inventario');
        $moneda= $this->input->post('moneda');
        $descuento= $this->input->post('descuento');
	    $descuento_especial = $this->input->post('descuento_especial');
        $categorias_especiales = $this->input->post('categorias_especiales');
        $ver_historico_pedidos = $this->input->post('ver_historico_pedidos');
        $tiene_credito = $this->input->post('tiene_credito');
        $plazo_credito = $this->input->post('plazo_credito');
        $tiene_cargos = $this->input->post('tiene_cargos');
        
        $data = array();
        $data['razon_social']=$razon_social;
        $data['nombre']=$nombre;
        $data['ruc']=$ruc;
        $data['cargo']=$cargo;
        $data['domicilio']=$domicilio;
        $data['distrito'] = $distrito;
        $data['ciudad']=$ciudad;
        $data['provincia']=$provincia;
        $data['departamento']=$departamento;
        $data['pais'] = $pais;
        $data['procedencia'] = $procedencia;
        $data['zip']=$zip;
        $data['telefono']=$telefono;
        $data['telefono2']=$telefono2;
        $data['fax'] = $fax;
        $data['web'] = $web;
        $data['tipo_cliente']=$tipo_cliente;
        $data['email']=$email;
        $data['clave']=$clave;
        $data['tipo_cuenta']=$tipo_cuenta;
        $data['ver_precio']=$ver_precio;  
        $data['ver_inventario']=$ver_inventario;
        $data['moneda']=$moneda;
        $data['descuento']=$descuento;
	    $data['descuento_especial'] = $descuento_especial;
        $data['categorias_especiales'] = $categorias_especiales;
        $data['ver_historico_pedidos'] = $ver_historico_pedidos;
        $data['tiene_credito'] = $tiene_credito;
        $data['plazo_credito'] = $plazo_credito;
        $data['tiene_cargos'] = $tiene_cargos;
        
        $this->Cliente_model->updateCliente($id_cliente, $data);
        redirect('mainpanel/clientes/edit/'.$id_cliente.'/success');
    }
    
    public function delete_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $tipo = $this->uri->segment(5);
        $this->Cliente_model->deleteCliente($id_registro);
        switch($tipo)
        {
            default:
            case "Activo":
            case "activos":
                redirect('mainpanel/clientes/listado/success');
            break;
        
            case "Anulado":
            case "anulados":
                redirect('mainpanel/clientes/listado_anulados/success');
            break;
        
            case "Borrado":
            case "borrados":
                redirect('mainpanel/clientes/listado_borrados/success');
            break;
        
            case "Inactivo":
            case "inactivos":
                redirect('mainpanel/clientes/listado_inactivos/success');
            break;
        }
    }
	
    public function borrado_cliente() {
		// MARCAR CLIENTE COMO BORRADO
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
		$data['estado']='Borrado';
        $this->Cliente_model->borrarCliente($id_registro, $data);
		// Registramos el borrado
		$hoy=fecha_hoy_Ymd();
		$data = array('id_cliente'=>$id_registro, 'razon'=>'Borrado por el administrador', 'fecha'=>$hoy);
        $this->Cliente_model->registrarBorradoCliente($data);
        redirect('mainpanel/clientes/listado/success');
    }
	
    public function anular_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $data['estado']='Anulado';
        $this->Cliente_model->anularCliente($id_registro,$data);
        redirect('mainpanel/clientes/listado/success');
    }    

    public function desactivar_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $data['estado']='Inactivo';
        $this->Cliente_model->anularCliente($id_registro,$data);
        redirect('mainpanel/clientes/listado/success');
    }        
    
    public function envio_correo() {
        $this->validacion->validacion_login();
        $razon_social= $this->input->post('razon_social');
        $email= $this->input->post('email');        
        $msgCli= $this->input->post('msgCli');
        $id_cliente= $this->input->post('id_cliente');
        
        
        $correo_notificaciones = getConfig('correo_notificaciones');
        // ENVIO  DE MAIL DE VERIFICACION CON EL PHP MAILER
        $mail = new PHPMailer();
        $mail->From = $correo_notificaciones; // direccion de quien envi
        $mail->FromName = "CKI INTERNACIONAL"; // nombre de quien envia
        $mail->AddAddress($email);
        $mail->Subject = "Mensaje del Portal CKI INTERNACIONAL";

        $msg = "===============================================================<br>\n";
        $msg .= "<b>EMAIL : </b>".$msgCli."<br /><br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= "Atte. <br>\n";
        $msg .= "La Administracion de CKI INTERNACIONAL<br>\n";	
        
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();
        $result='success';
        redirect('mainpanel/clientes/detalle/'.$id_cliente.'/'.$result);
    } 
        
    public function reactivar_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $dato=$this->Cliente_model->getCliente($id_registro);
        $empresa=$dato->razon_social;
        $telefono=$dato->telefono;
        $email=$dato->email;        
        $nombre=$dato->nombre;
        $clave=$dato->clave;
        
        $data['estado']='Activo';
        $this->Cliente_model->reactivarCliente($id_registro,$data);
        
        $correo_notificaciones = getConfig('correo_notificaciones');
        // ENVIO  DE MAIL DE VERIFICACION CON EL PHP MAILER
        $mail = new PHPMailer();
        $mail->From = $correo_notificaciones; // direccion de quien envi
        $mail->FromName = "CKI INTERNACIONAL"; // nombre de quien envia
        $mail->AddAddress($email);
        $mail->Subject = "CUENTA ACTIVADA : CKI INTERNACIONAL SAC"; 
        //$msg = "Su cuenta de usuario en el website de CKI INTERNACIONAL ha sido ACTIVADA.<br>\n";
        $msg = "Su cuenta ha sido reactivada.<br>\n";
        $msg .= "Ingresar en las próximas 6 horas.<br>\n";
        $msg .= "Evite anulacion de cuenta ingresando por lo menos una vez cada 30 días.<br>\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " DATOS DEL CLIENTE <br>\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>EMPRESA O NEGOCIO : </b>".$empresa."<br />\n";
        $msg .= "<b>NOMBRE : </b>".$nombre."<br />\n";
        $msg .= "<b>TELEFONO : </b>".$telefono."<br />\n";
        $msg .= "<b>EMAIL : </b>".$email."<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE INGRESO <br>\n";
        $msg .= "===============================================================<br>\n";        
        $msg .= "<b>USUARIO: </b>".$email."<br />\n";
        $msg .= "<b>PASSWORD: </b>".$clave."<br />\n";
        $msg .= '<b>Link de Ingreso: <a href="'.base_url().'ingresar">Click Aqui</a></b><br>';
        $msg .= "===============================================================<br /><br />\n";
        $msg .= "Gracias por su preferencia <br>\n";
        $msg .= "Atte. <br>\n";
        $msg .= "La Administracion de CKI INTERNACIONAL<br>\n";	
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();	        
        redirect('mainpanel/clientes/listado/success');
    }
    
    public function recuperar_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $dato=$this->Cliente_model->getCliente($id_registro);
        $empresa=$dato->razon_social;
        $telefono=$dato->telefono;
        $email=$dato->email;        
        $nombre=$dato->nombre;
        $clave=$dato->clave;
        
        $data['estado']='Activo';
        $this->Cliente_model->reactivarCliente($id_registro,$data);    
        redirect('mainpanel/clientes/listado/success');
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
        $data = array('nombre_categoria'=>$nombre, 'orden'=>$orden, 'estado'=>$estado);
        
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
                $resultado = $this->Cliente_model->grabarCategoria($data);
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
    
    public function detalle() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal['cuerpo']="clientes/detalle";
        // DETALLE DE CLIENTE
        $result= $this->uri->segment(5);        
        $dataPrincipal['resultado'] = $result;        
        $id_cliente = $this->uri->segment(4);
        $cliente= $this->Cliente_model->getCliente($id_cliente);
        $dataPrincipal['cliente'] = $cliente;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    

    public function form_buscar() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/form_buscar";
        // EDIT CLIENTE
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function list_search() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/lista_busqueda";
        
        // LISTA CLIENTES        
        $razon_social = $this->input->post('razon_social');
        $nombre = $this->input->post('nombre');
        $ruc = $this->input->post('ruc');
        $telefono = $this->input->post('telefono');        
        $email = $this->input->post('email');	
        
        $aux = $this->Cliente_model->getListaClientesBusqueda($email,$razon_social,$telefono,$ruc,$nombre);
        $clientes = array();
        foreach($aux as $cliente)
        {
            $aux2 = array();
            $aux2['id'] = $cliente->id;
            $aux2['razon_social'] = $cliente->razon_social;
            $aux2['fecha_registro'] = $cliente->fecha_registro;
            $aux2['estado'] = $cliente->estado;
            $aux2['email'] = $cliente->email;
            $aux2['ruc'] = $cliente->ruc;
            $aux2['codigo'] = $cliente->codigo_cliente;
            $aux2['telefono2'] = $cliente->telefono2;
            $aux2['telefono'] = $cliente->telefono; 
            $aux2['nombre'] = $cliente->nombre;			
            $aux = $this->Cliente_model->getNumVisitas($cliente->email);
            $aux2['visitas'] =$aux;
            $aux_v = $this->Cliente_model->ultimoIngreso($cliente->email);
            if(count($aux_v)>0)
            {
                $aux2['ultima_visita'] = $aux_v->fecha_ingreso;
            }
            else
            {
                $aux2['ultima_visita'] = 'No registra ingresos';
            }
            $nivel = $cliente->nivel;
            $aux2['nivel'] = $nivel;
            if($nivel=="administrador")
            {
                $aux2['num_vendedores'] = $this->Cliente_model->numVendedores($cliente->id);
            }
            else
            {
                $aux2['num_vendedores'] = 0;
            }
            $clientes[] = $aux2;
        }
        $dataPrincipal['clientes'] = $clientes;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function search_visitas() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/form_buscar_visita";
        // ENVIAR DATOS
        
        $dataPrincipal["clientes"]= $this->Cliente_model->getListaClientesTotal();
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    

    public function visitas() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/lista_visitas";
        // LISTA VISITAS
        $id_cliente = $this->uri->segment(4);
        $aux = $this->Cliente_model->getCliente($id_cliente);        
        $email=$aux->email;
        $dataPrincipal['razon_social'] = $aux->razon_social;
        $aux = $this->Cliente_model->getListaVisitas($email);
        $clientes = array();
        foreach($aux as $cliente)
        {
            $aux2 = array();
            $aux2['id'] = $id_cliente;
            $aux2['email'] = $email;
            $aux2['fecha_ingreso'] = $cliente->fecha_ingreso;
            $clientes[] = $aux2;
        }
        $dataPrincipal['clientes'] = $clientes;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    } 
    
    public function list_search_visitas() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="clientes/lista_visitas";
        // LISTA VISITAS
        $id_cliente = $this->input->post('id_cliente');
        if($id_cliente==0){
            $email='';
            $dataPrincipal['razon_social']=' Varios Clientes';
        }else{
            $aux = $this->Cliente_model->getCliente($id_cliente);        
            $email=$aux->email;            
            $dataPrincipal['razon_social'] =$aux->razon_social;
        }
        
        $fecha_inicio=$this->input->post('fecha_inicio');
        if($fecha_inicio<>''){
            $fecha_inicio= dmY_2_Ymd(str_replace("/","-",$fecha_inicio));
        }else{$fecha_inicio= '';}
        
        $fecha_fin=$this->input->post('fecha_fin');
        if($fecha_fin<>''){
            $fecha_fin= dmY_2_Ymd(str_replace("/","-",$fecha_fin));
        }else{$fecha_fin= '';}        

        
		
        $aux = $this->Cliente_model->getListaVisitas2($email,$fecha_inicio,$fecha_fin);
        $clientes = array();
        foreach($aux as $cliente)
        {
            $aux2 = array();
            $aux2['id'] = $id_cliente;
            $aux2['email'] = $cliente->email;
            $aux2['fecha_ingreso'] = $cliente->fecha_ingreso;
            $clientes[] = $aux2;
        }
        $dataPrincipal['clientes'] = $clientes;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }     
    
}
?>
