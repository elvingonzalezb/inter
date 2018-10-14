<?php
class Mensajes extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Mensajes_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function recibidos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="mensajes/index_view";
        // LISTA MENSAJES RECIBIDOS
        $aux = $this->Mensajes_model->getListaRecibidos();
        $mensajes = array();
        foreach($aux as $mensaje)
        {
            $aux2 = array();
            $aux2['id'] = $mensaje->id;
            $aux2['nombre'] = $mensaje->nombre;
            $aux2['fecha_ingreso'] = $mensaje->fecha_ingreso;
            $aux2['estatus'] = $mensaje->estatus;
            $mensajes[] = $aux2;
        }
        $dataPrincipal['mensajes'] = $mensajes;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    public function ajaxListaRecibidos()
    {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'nombre', 1 => 'fecha_ingreso');

        $totalData = $this->Datatable->numRecibidos();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR fecha_ingreso LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchRecibidos($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchRecibidos($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["nombre"];
            $nestedData[] = substr($value['fecha_ingreso'],0,10);
            $nestedData[] = $value['estatus'];
            $nestedData[] = '<a class="btn btn-small btn-success" href="mainpanel/mensajes/detalle_recibido/'.$value['id'].'"><i class="icon-file icon-white"></i>  Ver Datos</a> 
                <a class="btn btn-danger" href="javascript:deleteMsgRecibido(\''.$value['id'].'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
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

    public function mostrados() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="mensajes/list_mostrados";
        // LISTA MENSAJES MOSTRADOS
        $aux = $this->Mensajes_model->getListaMostrados();
        $mensajes = array();
        foreach($aux as $mensaje)
        {
            $aux2 = array();
            $aux2['id_mensaje'] = $mensaje->id_mensaje;
            $aux2['titulo'] = $mensaje->titulo;
            $aux2['explicacion'] = $mensaje->explicacion;
            $mensajes[] = $aux2;
        }
        $dataPrincipal['mensajes'] = $mensajes;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    } 

    public function ajaxListaMostrados()
    {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'titulo', 1 => 'explicacion');

        $totalData = $this->Datatable->numMostrados();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( titulo LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR explicacion LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchMostrados($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchMostrados($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["titulo"];
            $nestedData[] = $value["explicacion"];
            $nestedData[] = '<a class="btn btn-small btn-success" href="mainpanel/mensajes/detalle_mostrado/'.$id_mensaje.'"><i class="icon-file icon-white"></i>  Ver Datos</a>  
                <a class="btn btn-danger" href="javascript:deleteMsgMostrado(\''.$id_mensaje.'\')"><i class="icon-trash icon-white"></i>Borrar</a>';
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
    
    public function detalle_recibido() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal['cuerpo']="mensajes/detalle_recibido";
        // DETALLE DE MENSAJE
        $id_mensaje = $this->uri->segment(4);
        $dat['estatus']='Leido';
        $this->Mensajes_model->leidoMensaje($id_mensaje,$dat);        
        $mensaje= $this->Mensajes_model->getMsgRecibido($id_mensaje);
        $dataPrincipal['messagee'] = $mensaje;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    
    
    public function detalle_mostrado() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal['cuerpo']="mensajes/detalle_mostrados";
        // DETALLE DE MENSAJE
        $id_mensaje = $this->uri->segment(4);
        $mensaje= $this->Mensajes_model->getMsgMostrado($id_mensaje);
        $dataPrincipal['messagee'] = $mensaje;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }       

    public function delete_mensaje() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $this->Mensajes_model->deleteMensaje($id_registro);
        redirect('mainpanel/mensajes/recibidos/success');
    }
    
    public function delete_mensaje_mostrado() {
        $this->validacion->validacion_login();
        $id_registro = $this->uri->segment(4);
        $this->Mensajes_model->deleteMensajeMostrado($id_registro);
        redirect('mainpanel/mensajes/mostrados/success');
    }    

}
?>
