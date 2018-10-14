<?php
class Correos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Correos_model');
        $this->load->library('My_upload');
        $this->load->library('My_PHPMailer');
        $this->load->library('My_Mandrill');        
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
        $dataPrincipal["cuerpo"]="correos/index_view";
        // LISTA CORREOS
        $aux = $this->Correos_model->getListaCorreos();
        $boletines = array();
        foreach($aux as $dato_boletin)
        {
            $aux2 = array();
            $aux2['id'] = $dato_boletin->id;
            $aux2['titulo'] = $dato_boletin->titulo;
            $aux2['fecha_registro'] = Ymd_2_dmY($dato_boletin->fecha_registro);
            $aux2['fecha_envio'] = Ymd_2_dmY($dato_boletin->fecha_envio);
            $aux2['estado'] = $dato_boletin->estado;
            $boletines[] = $aux2;
        }
        $dataPrincipal['boletines'] = $boletines;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }    
    
    public function nuevo() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="correos/paso1_view";        
        // NUEVO BOLETIN
        $resultado = $this->uri->segment(4);
        if($resultado=="error")
        {
            $error = $this->uri->segment(5);
        }
        else
        {
            $error = '';
        }
        // LISTA CLIENTES
        $aux = $this->Correos_model->getListaClientes();
        $clientes = array();
        foreach($aux as $cliente)
        {
            $aux2 = array();
            $aux2['id'] = $cliente->id;
            $aux2['razon_social'] = $cliente->razon_social;
            $aux2['fecha_registro'] = $cliente->fecha_registro;
            $aux2['estado'] = $cliente->estado;
            $aux2['codigo'] = $cliente->codigo_cliente;
            $aux2['email'] = $cliente->email;
            $aux2['ruc'] = $cliente->ruc;
            $aux2['telefono2'] = $cliente->telefono2;
            $aux2['telefono'] = $cliente->telefono;            
            $aux2['nombre'] = $cliente->nombre;
            $aux2['email'] = $cliente->email;
            $clientes[] = $aux2;
        }
        $dataPrincipal['clientes'] = $clientes;
        
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);         
    }
    
    public function paso2() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="correos/paso2_view";        
        // NUEVO BOLETIN
        $resultado = $this->uri->segment(4);
        if($resultado=="error")
        {
            $error = $this->uri->segment(5);
        }
        else
        {
            $error = '';
        }
        $destinatarios = $this->input->post('id_eliminar');
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
        $dataPrincipal["destinatarios"] = $destinatarios;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);         
    }
    
    public function grabar() {
        $this->validacion->validacion_login();
        // GRABAR BOLETIN
        $titulo = $this->input->post('titulo');
        $asunto = $this->input->post('asunto');
        $aux_contenido = $this->input->post('contenido');
        $base_url = 'http://cki2015.ajxperu.com/assets/ckeditor/elfinder/files/';
        $contenido = str_replace('/assets/ckeditor/elfinder/php/../files/', $base_url, $aux_contenido);
        $emails_prueba = $this->input->post('emails_prueba');
        $estado = 'Pendiente de Envio';
        $destinatarios = $this->input->post('destinatarios');
        $data = array();
        $data['titulo'] = $titulo;  
        $data['asunto'] = $asunto;  
        $data['contenido'] = $contenido;
        $data['emails_prueba'] = $emails_prueba;
        $data['estado'] = $estado;
        $data['destinatarios'] = $destinatarios;
        $this->my_upload->upload($_FILES["cabecera"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 700;
            $this->my_upload->image_y          = 150;
            //$this->my_upload->image_ratio_y    = true;            
            $this->my_upload->process('./files/cabeceras_boletin/');
            if ( $this->my_upload->processed == true )
            {
                $data['cabecera'] = $this->my_upload->file_dst_name;
                $data['fecha_registro']=  fecha_hoy_Ymd(); 
                $data['fecha_envio'] = '0000-00-00';
                $this->my_upload->clean();
                $id_producto = $this->Correos_model->grabarCorreo($data);
                redirect('mainpanel/boletin/listado/success');
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                redirect('mainpanel/boletin/nuevo/error/'.$error);
            }
        }
        else
        {
            //$error = formateaCadena($this->my_upload->error);
            //redirect('mainpanel/boletin/nuevo/error/'.$error);
            $data['cabecera'] = '';
            $data['fecha_registro']=  fecha_hoy_Ymd(); 
            $data['fecha_envio'] = '0000-00-00';
            $id_producto = $this->Correos_model->grabarCorreo($data);
            redirect('mainpanel/correos/listado/success');
        }
    }
    
    public function probar() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="boletin/detalle";
        // PREVIEW DE BOLETIN
        $id_boletin = $this->uri->segment(4);
        $boletin = $this->Correos_model->getCorreo($id_boletin);
        
        $asunto = $boletin->asunto;
        $contenido = $boletin->contenido;
        $titulo = $boletin->titulo;
        $emails_prueba = explode(',', $boletin->emails_prueba);
        $destinatarios = array();
        for($a=0; $a<count($emails_prueba); $a++)
        {
                $em = $emails_prueba[$a];
                $destinatarios[] = $em;
        }
                        
        $msg = '<html>';
        $msg .= '<head>';
        $msg .= '<style>';
        $msg .= 'body { width:700px; margin:0; padding:0; }';
        $msg .= '.cabecera { background:#fff; }';
        $msg .= '.nombreProducto { font-weight:700; font-size:14px; }';
        $msg .= '.codigoProducto { font-weight:700; font-size:12px; }';
        $msg .= '</style>';
        $msg .= '</head>';
        $msg .= '<body>';
        $msg .= '<table width="700" cellspacing="0" cellpadding="0" style="border:1px solid #000;">';
        if($boletin->cabecera!="")
        {
            $msg .= '<tr>';
            //$msg .= '<td colspan="3" class="cabecera"><img src="http://www.ckiinternacional.net/files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
            $msg .= '<td colspan="3" class="cabecera"><img src="http://cki2015.ajaxperu.com/files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
            $msg .= '</tr>';
            
            $msg .= '<tr>';
            $msg .= '<td colspan="3" height="10"></td>';
            $msg .= '</tr>';
        }
        
        $msg .= '<tr>';
        $msg .= '<td></td>';
        $msg .= '<td><h1>'.$boletin->titulo.'</h1></td>';
        $msg .= '<td></td>';
        $msg .= '</tr>';
        
        $msg .= '<tr>';
        $msg .= '<td width="5%" height="10"></td>';
        $msg .= '<td width="90%"></td>';
        $msg .= '<td width="5%"></td>';
        $msg .= '</tr>';
        
        $msg .= '<tr>';
        $msg .= '<td></td>';
        $msg .= '<td>'.$boletin->contenido.'</td>';
        $msg .= '<td></td>';
        $msg .= '</tr>';
        
        $msg .= '<tr>';
        $msg .= '<td colspan="3" height="10"></td>';
        $msg .= '</tr>';
        
        $msg .= '<tr>';
        $msg .= '<td colspan="3" height="10"></td>';
        $msg .= '</tr>';
        
        $msg .= '</body>';
        $msg .= '</html>';
        
        $correo_notificaciones = getConfig('correo_notificaciones');
        
        //************* ENVIO CON MANDRILL
        for($i=0; $i<count($destinatarios); $i++)
        {
            $mandrill = new Mandrill('cRuh80Mt1MxY4f4TLIfaWw');
            $destinatario = array(array("email"=>$destinatarios[$i]));
            $message = array(
                    'html'=> $msg,
                    'subject' => $asunto,
                    'from_email' => $correo_notificaciones,
                    'from_name' => "CKI INTERNACIONAL",
                    'to'=> $destinatario,
                    'important' => true,
                    'track_opens' => true,
                    'track_clicks' => true,
                    'auto_text' => null,
                    'auto_html' => null,
                    'inline_css' => true
            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '';
            $return_path_domain = null;
            $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        }
        $resultado = 'success';
        redirect('mainpanel/correos/listado/'.$resultado);
    }
    
    public function preview() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="correos/detalle";
        // PREVIEW DE BOLETIN
        $id_boletin = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $boletin = $this->Correos_model->getCorreo($id_boletin);
        $dataPrincipal['boletin'] = $boletin;
        
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function editar() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="correos/edit_paso1_view";        
        // EDITAR BOLETIN
        $id_boletin = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $boletin = $this->Correos_model->getCorreo($id_boletin);
        $destinatarios = $boletin->destinatarios;
        // LISTA CLIENTES
        $aux = $this->Correos_model->getListaClientes();
        $clientes = array();
        foreach($aux as $cliente)
        {
            $aux2 = array();
            $aux2['id'] = $cliente->id;
            $aux2['razon_social'] = $cliente->razon_social;
            $aux2['fecha_registro'] = $cliente->fecha_registro;
            $aux2['estado'] = $cliente->estado;
            $aux2['codigo'] = $cliente->codigo_cliente;
            $aux2['email'] = $cliente->email;
            $aux2['ruc'] = $cliente->ruc;
            $aux2['telefono2'] = $cliente->telefono2;
            $aux2['telefono'] = $cliente->telefono;            
            $aux2['nombre'] = $cliente->nombre;
            $aux2['email'] = $cliente->email;
            $clientes[] = $aux2;
        }
        $dataPrincipal['clientes'] = $clientes;
        $dataPrincipal["destinatarios"] = $destinatarios;
        $dataPrincipal["id_boletin"] = $id_boletin;
        $dataPrincipal["boletin"] = $boletin;
        $dataPrincipal["resultado"] = $resultado;
        //$dataPrincipal["error"]= $error;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);         
    }
    
    public function editPaso2() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="correos/edit_paso2_view";        
        // NUEVO BOLETIN
        $destinatarios = $this->input->post('id_eliminar');
        $id_boletin = $this->input->post('id');
        $dataPrincipal["destinatarios"] = $destinatarios;
        $boletin = $this->Correos_model->getCorreo($id_boletin);
        $dataPrincipal['boletin'] = $boletin;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);         
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // GRABAR BOLETIN
        $id_boletin = $this->input->post('id');
        $titulo = $this->input->post('titulo');
        $asunto = $this->input->post('asunto');
        $aux_contenido = $this->input->post('contenido');
        $base_url = 'http://cki2015.ajxperu.com/assets/ckeditor/elfinder/files/';
        $contenido = str_replace('/assets/ckeditor/elfinder/php/../files/', $base_url, $aux_contenido);
        $emails_prueba = $this->input->post('emails_prueba');
        $estado = 'Pendiente de Envio';
        $destinatarios = $this->input->post('destinatarios');
        $data = array();
        $data['titulo'] = $titulo;  
        $data['asunto'] = $asunto;  
        $data['contenido'] = $contenido;
        $data['emails_prueba'] = $emails_prueba;
        $data['estado'] = $estado;
        $data['destinatarios'] = $destinatarios;
        $this->my_upload->upload($_FILES["cabecera"]);
        if ( $this->my_upload->uploaded == true  )
        {
            $this->my_upload->allowed          = array('image/*');
            $this->my_upload->image_resize     = true;
            $this->my_upload->image_x          = 700;
            $this->my_upload->image_y          = 150;
            //$this->my_upload->image_ratio_y    = true;            
            $this->my_upload->process('./files/cabeceras_boletin/');
            if ( $this->my_upload->processed == true )
            {
                $data['cabecera'] = $this->my_upload->file_dst_name;
                $data['fecha_registro']=  fecha_hoy_Ymd(); 
                $data['fecha_envio'] = '0000-00-00';
                $this->my_upload->clean();
                $this->Correos_model->actualizarCorreo($id_boletin, $data);
                redirect('mainpanel/correos/listado/success');
            }
            else
            {
                $error = formateaCadena($this->my_upload->error);
                redirect('mainpanel/correos/nuevo/error/'.$error);
            }
        }
        else
        {
            $this->Correos_model->actualizarCorreo($id_boletin, $data);
            redirect('mainpanel/correos/listado/success');
        }        
    }
    
    public function delete() {
        $this->validacion->validacion_login();
        $id_boletin = $this->uri->segment(4);
        $this->Correos_model->deleteCorreo($id_boletin);
        redirect('mainpanel/correos/listado/success');
    }
    
    public function enviar() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="boletin/detalle";
        // DATOS BOLETIN
        $id_boletin = $this->uri->segment(4);
        $boletin = $this->Correos_model->getCorreo($id_boletin);
        
        $asunto = $boletin->asunto;
        $contenido = $boletin->contenido;
        $titulo = $boletin->titulo;
        $clientes = explode("##", $boletin->destinatarios);
        $destinatarios = array();
        for($i=0; $i<count($clientes); $i++)
        {
            $id_current = $clientes[$i];
            $cliente = $this->Correos_model->getCliente($id_current);
            $destinatarios[] = $cliente->email;
        }
        $destinatarios[] = "erosadio@ajaxperu.com";
                
        $msg = '<html>';
        $msg .= '<head>';
        $msg .= '<style>';
        $msg .= 'body { width:700px; margin:0; padding:0; }';
        $msg .= '.cabecera { background:#fff; }';
        $msg .= '.nombreProducto { font-weight:700; font-size:14px; }';
        $msg .= '.codigoProducto { font-weight:700; font-size:12px; }';
        $msg .= '</style>';
        $msg .= '</head>';
        $msg .= '<body>';
        $msg .= '<table width="700" cellspacing="0" cellpadding="0" style="border:1px solid #000;">';
        
        if($boletin->cabecera!="")
        {
            $msg .= '<tr>';
            //$msg .= '<td colspan="3" class="cabecera"><img src="http://www.ckiinternacional.net/files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
            $msg .= '<td colspan="3" class="cabecera"><img src="http://cki2015.ajaxperu.com/files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
            $msg .= '</tr>';
            
            $msg .= '<tr>';
            $msg .= '<td colspan="3" height="10"></td>';
            $msg .= '</tr>';
        }
        
        $msg .= '<tr>';
        $msg .= '<td></td>';
        $msg .= '<td><h1>'.$boletin->titulo.'</h1></td>';
        $msg .= '<td></td>';
        $msg .= '</tr>';
        
        $msg .= '<tr>';
        $msg .= '<td width="5%" height="10"></td>';
        $msg .= '<td width="90%"></td>';
        $msg .= '<td width="5%"></td>';
        $msg .= '</tr>';
        
        $msg .= '<tr>';
        $msg .= '<td></td>';
        $msg .= '<td>'.$boletin->contenido.'</td>';
        $msg .= '<td></td>';
        $msg .= '</tr>';        

        $msg .= '</table>';
        $msg .= '</body>';
        $msg .= '</html>';
        
        $correo_notificaciones = getConfig('correo_notificaciones');
        //************* ENVIO CON MANDRILL
        for($i=0; $i<count($destinatarios); $i++)
        {
                $mandrill = new Mandrill('cRuh80Mt1MxY4f4TLIfaWw');
                $destinatario = array(array("email"=>$destinatarios[$i]));
                $message = array(
                        'html'=> $msg,
                        'subject' => $asunto,
                        'from_email' => $correo_notificaciones,
                        'from_name' => "CKI INTERNACIONAL",
                        'to'=> $destinatario,
                        'important' => true,
                        'track_opens' => true,
                        'track_clicks' => true,
                        'auto_text' => null,
                        'auto_html' => null,
                        'inline_css' => true
                );
                $async = false;
                $ip_pool = 'Main Pool';
                $send_at = '';
                $return_path_domain = null;
                $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        }
        $resultado = 'success';
        $datos['estado'] = 'Enviado';
	$datos['fecha_envio'] = fecha_hoy_Ymd();
        $this->Correos_model->updateEstadoCorreo($id_boletin, $datos);
        redirect('mainpanel/correos/listado/'.$resultado);
    }
}
?>