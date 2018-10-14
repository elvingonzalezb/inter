<?php
class Unidades extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Unidad_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
        $this->load->library('My_PHPMailer');        
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
        $data['modal'] = $this->load->view('mainpanel/unidades/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="unidades/index_view";
        // LISTA UNIDADES
        /*$aux = $this->Unidad_model->getListaUnidades();
        $unidades = array();
        foreach($aux as $unidad)
        {
            $aux2 = array();
            $aux2['id'] = $unidad->id;
            $aux2['texto'] = $unidad->texto;
            $aux2['estado'] = $unidad->estado;
            $unidades[] = $aux2;
        }
        $dataPrincipal['unidades'] = $unidades;*/
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function ajaxListaUnidades()
    {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'texto');

        $totalData = $this->Datatable->numUnidades();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( texto LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchUnidades($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchUnidades($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["texto"];
            $nestedData[] = $value["estado"];
            $nestedData[] = '<a class="btn btn-info" href="mainpanel/unidades/edit/'.$value['id'].'"><i class="icon-edit icon-white"></i>  Editar</a> 
                <a class="btn btn-danger" href="javascript:deleteUnidad(\''.$value['id'].'\', \''.$value['texto'].'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
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
        $dataPrincipal["cuerpo"]="unidades/edit_view";
        // EDIT CLIENTE
        $id_unidad = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $unidad = $this->Unidad_model->getUnidad($id_unidad);
        $dataPrincipal['unidad'] = $unidad;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR CLIENTE
        $id_unidad = $this->input->post('id_unidad');
        $texto = $this->input->post('texto');        
        $estado= $this->input->post('estado');
        $data = array();
        $data['texto']=$texto;
        $data['estado']=$estado;
        $this->Unidad_model->updateUnidad($id_unidad, $data);
        redirect('mainpanel/unidades/edit/'.$id_unidad.'/success');
    }
    
    public function delete_unidad() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $this->Unidad_model->deleteUnidad($id_registro);
        redirect('mainpanel/unidades/listado/success');
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
        $dataPrincipal["cuerpo"]="unidades/nuevo_view";
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
        $texto= $this->input->post('texto');
        $estado = $this->input->post('estado');
        $data = array('texto'=>$texto, 'estado'=>$estado);

        $resultado = $this->Unidad_model->grabarUnidad($data);
        if($resultado==1)
        {
            redirect('mainpanel/unidades/listado/success');
        }
        else
        {
            redirect('mainpanel/unidades/nuevo/error/bd');
        }

    }
    
}
?>
