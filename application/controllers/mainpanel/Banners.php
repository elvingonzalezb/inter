<?php
class Banners extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Banners_model');
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
        $data['modal'] = $this->load->view('mainpanel/banners/modal_delete_banner', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="banners/index_view";
        // LISTA BANNERS
        $dataPrincipal['banners'] = $this->Banners_model->getListaBanners();
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaBanners(){
        $requestData= $_REQUEST;

        $columns = array( 0 => 'titulo');

        $totalData = $this->Datatable->numBanners();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( titulo LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchBanners($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchBanners($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = '<img src="files/banner/'.$value['imagen'].'" />';
            $nestedData[] = $value["titulo"];
            $nestedData[] = $value["orden"];
            $nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>':'<span class="label label-important">INACTIVO</span>';
            
            $nestedData[] = '<a class="btn btn-success" href="javascript:showBanner(\''.$value['imagen'].'\', \''.$value['titulo'].'\')"><i class="icon-zoom-in icon-white"></i>  Ver</a> 
                            <a class="btn btn-info" href="mainpanel/banners/edit/'.$value['id_banner'].'"><i class="icon-edit icon-white"></i>  Editar</a> 
                            <a class="btn btn-danger" href="javascript:deleteBanner(\''.$value['id_banner'].'\')"><i class="icon-trash icon-white"></i>Borrar</a>';
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
        $dataPrincipal["cuerpo"]="banners/edit_view";
        // EDIT BANNER
        $id_banner = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $banner = $this->Banners_model->getBanner($id_banner);
        $dataPrincipal['banner'] = $banner;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // EDITAR BANNER
        $id_banner = $this->input->post('id_banner');
        $titulo = $this->input->post('titulo');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('titulo'=>$titulo, 'orden'=>$orden, 'estado'=>$estado);
        
        $this->my_upload->upload($_FILES["banner"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 720;
            $this->my_upload->image_y          = 300;
            $this->my_upload->process('./files/banner/');
            if ( $this->my_upload->processed == true ) {
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
        $this->Banners_model->updateBanner($id_banner, $data);
        redirect('mainpanel/banners/edit/'.$id_banner.'/success');
    }
    
    public function delete() {
        $this->validacion->validacion_login();
        $id_banner = $this->uri->segment(4);
        $banner = $this->Banners_model->getBanner($id_banner);
        $imagen=$banner->imagen;
        unlink('files/banner/'.$imagen);
        $this->Banners_model->deleteBanner($id_banner);
        redirect('mainpanel/banners/listado/success');
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
        $dataPrincipal["cuerpo"]="banners/nuevo_view";
        // NUEVO BANNER
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
        // GRABAR BANNER
        $titulo = $this->input->post('titulo');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('titulo'=>$titulo, 'orden'=>$orden, 'estado'=>$estado);
        
        $this->my_upload->upload($_FILES["banner"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 720;
            $this->my_upload->image_y          = 300;
            $this->my_upload->process('./files/banner/');
            if ( $this->my_upload->processed == true )
            {
                $data['imagen'] = $this->my_upload->file_dst_name;
                $this->my_upload->clean();
                $resultado = $this->Banners_model->grabarBanner($data);
                if($resultado==1)
                {
                    redirect('mainpanel/banners/listado/success');
                }
                else
                {
                    redirect('mainpanel/banners/nuevo/error/bd');
                }
            }
            else
            {
                $error = $this->my_upload->error;
                redirect('mainpanel/banners/nuevo/error/'.$error);
            }
        }
        else
        {
            $error = $this->my_upload->error;
            redirect('mainpanel/banners/nuevo/error/'.$error);
        }
    }
    
    // LISTADO DE BANNERS DE CLIENTES
    public function listadoc() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/banners/modal_delete_banner', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="banners/listado_clientes_view";
        // LISTA BANNERS
        //$dataPrincipal['banners'] = $this->Banners_model->getListaBannersClientes();
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaBannersClientes(){
        $requestData= $_REQUEST;

        $columns = array( 0 => 'titulo');

        $totalData = $this->Datatable->numBannerscliente();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( titulo LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchBannersCliente($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchBannersCliente($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = '<img src="files/banner_clientes/'.$value['imagen'].'" />';
            $nestedData[] = $value["titulo"];
            $nestedData[] = $value["orden"];
            $nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>':'<span class="label label-important">INACTIVO</span>';
            
            $nestedData[] = '<a class="btn btn-success" href="javascript:showBannerCliente(\''.$value['imagen'].'\', \''.$value['titulo'].'\')"><i class="icon-zoom-in icon-white"></i>  Ver</a> 
                            <a class="btn btn-info" href="mainpanel/banners/editc/'.$value['id_banner'].'"><i class="icon-edit icon-white"></i>  Editar</a> 
                            <a class="btn btn-danger" href="javascript:deleteBannerCliente(\''.$value['id_banner'].'\')"><i class="icon-trash icon-white"></i>Borrar</a>';
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

    public function editc() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="banners/edit_bcliente_view";
        // EDIT BANNER
        $id_banner = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $banner = $this->Banners_model->getBannerClientes($id_banner);
        $dataPrincipal['banner'] = $banner;
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function actualizarc() {
        $this->validacion->validacion_login();
        // EDITAR BANNER
        $id_banner = $this->input->post('id_banner');
        $titulo = $this->input->post('titulo');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('titulo'=>$titulo, 'orden'=>$orden, 'estado'=>$estado);
        
        $this->my_upload->upload($_FILES["banner"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 720;
            $this->my_upload->image_y          = 180;
            $this->my_upload->process('./files/banner_clientes/');
            if ( $this->my_upload->processed == true ) {
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
        $this->Banners_model->updateBannerClientes($id_banner, $data);
        redirect('mainpanel/banners/editc/'.$id_banner.'/success');
    }
    
    public function deletec() {
        $this->validacion->validacion_login();
        $id_banner = $this->uri->segment(4);
        $banner = $this->Banners_model->getBannerClientes($id_banner);
        $imagen = $banner->imagen;
        unlink('files/banner_clientes/'.$imagen);
        $this->Banners_model->deleteBannerClientes($id_banner);
        redirect('mainpanel/banners/listadoc/success');
    }
    
    public function nuevoc() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="banners/nuevo_bcliente_view";
        // NUEVO BANNER
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
    
    public function grabarc() {
        $this->validacion->validacion_login();
        // GRABAR BANNER
        $titulo = $this->input->post('titulo');
        $orden = $this->input->post('orden');
        $estado = $this->input->post('estado');
        $data = array('titulo'=>$titulo, 'orden'=>$orden, 'estado'=>$estado);
        
        $this->my_upload->upload($_FILES["banner"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_x          = 720;
            $this->my_upload->image_y          = 180;
            $this->my_upload->process('./files/banner_clientes/');
            if ( $this->my_upload->processed == true )
            {
                $data['imagen'] = $this->my_upload->file_dst_name;
                $this->my_upload->clean();
                $resultado = $this->Banners_model->grabarBannerClientes($data);
                if($resultado==1)
                {
                    redirect('mainpanel/banners/listadoc/success');
                }
                else
                {
                    redirect('mainpanel/banners/nuevoc/error/bd');
                }
            }
            else
            {
                $error = $this->my_upload->error;
                redirect('mainpanel/banners/nuevoc/error/'.$error);
            }
        }
        else
        {
            $error = $this->my_upload->error;
            redirect('mainpanel/banners/nuevoc/error/'.$error);
        }
    }
}
?>
