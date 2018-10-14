<?php
class Configuracion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Configuracion_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
    }
    
    public function index() {
        $this->validacion->validacion_login();
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
        $dataPrincipal["cuerpo"]="configuracion/index_view";
        // LISTA PARAMETROS
        $aux = $this->Configuracion_model->getListaParametros();
        $configuraciones = array();
        foreach($aux as $configuracion)
        {
            $aux2 = array();
            $aux2['id'] = $configuracion->id;
            $aux2['llave'] = $configuracion->llave;
            $aux2['valor'] = $configuracion->valor;
            $aux2['descripcion'] = $configuracion->descripcion;
            $configuraciones[] = $aux2;
        }
        $dataPrincipal['configuraciones'] = $configuraciones;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function ajaxListaConfiguraciones()
    {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'llave', 1 => 'valor', 2 => 'descripcion');

        $totalData = $this->Datatable->numConfiguraciones();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( llave LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR valor LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR descripcion LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchConfiguraciones($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchConfiguraciones($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["llave"];
            $nestedData[] = $value["valor"];
            $nestedData[] = $value["descripcion"];
            $nestedData[] = '<a class="btn btn-info" href="mainpanel/configuracion/edit/'.$value["id"].'"><i class="icon-edit icon-white"></i>  Editar</a> ';
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
        $dataPrincipal["cuerpo"]="configuracion/edit_view";
        // EDIT CLIENTE
        $id_configuracion = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $configuracion = $this->Configuracion_model->getConfiguracion($id_configuracion);
        echo '<pre>';print_r($configuracion);echo '</pre>';die;
        $dataPrincipal['configuracion'] = $configuracion;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR CLIENTE
        $id_configuracion = $this->input->post('id_configuracion');
        $llave = $this->input->post('llave');        
        $valor = $this->input->post('valor');        
        $descripcion= $this->input->post('descripcion');
        $data = array();
        $data['llave']=$llave;
        $data['valor']=$valor;
        $data['descripcion']=$descripcion;
        $this->Configuracion_model->updateConfiguracion($id_configuracion, $data);
        redirect('mainpanel/configuracion/edit/'.$id_configuracion.'/success');
    }
    
    public function delete_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $this->Configuracion_model->deleteCliente($id_registro);
        redirect('mainpanel/configuraciones/listado/success');
    }
    public function anular_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $data['estado']='Anulado';
        $this->Configuracion_model->anularCliente($id_registro,$data);
        redirect('mainpanel/configuraciones/listado/success');
    }    

    public function desactivar_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $data['estado']='Inactivo';
        $this->Configuracion_model->anularCliente($id_registro,$data);
        redirect('mainpanel/configuraciones/listado/success');
    }        
    
    public function reactivar_cliente() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $data['estado']='Activo';
        $this->Configuracion_model->reactivarCliente($id_registro,$data);
        redirect('mainpanel/configuraciones/listado/success');
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
                $resultado = $this->Configuracion_model->grabarCategoria($data);
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
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal['cuerpo']="configuraciones/detalle";
        // DETALLE DE CLIENTE
        $id_configuracion = $this->uri->segment(4);
        $configuracion= $this->Configuracion_model->getCliente($id_configuracion);
        $dataPrincipal['cliente'] = $configuracion;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    

}
?>
