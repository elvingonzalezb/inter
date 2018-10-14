<?php
class Boletin extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Boletin_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
        $this->load->library('My_PHPMailer');
        //$this->load->library('My_Mandrill');
        $this->load->library('My_SendGrid');
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
        $dataPrincipal["cuerpo"]="boletin/index_view";
        // LISTA BOLETINES
        /*$aux = $this->Boletin_model->getListaBoletines();
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
        $dataPrincipal['boletines'] = $boletines;*/
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaBoletines()
    {
        $requestData= $_REQUEST;

        $columns = array( 0 => 'titulo');

        $totalData = $this->Datatable->numBoletines();
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( titulo LIKE '%".$requestData['search']['value']."%' )";
            //$where.=" OR codigo LIKE '%".$requestData['search']['value']."%' ";
            //$where.=" OR actualizacion LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchBoletines($where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchBoletines($where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = $value["titulo"];
            $nestedData[] = Ymd_2_dmY($value["fecha_registro"]);
            $nestedData[] =Ymd_2_dmY($value["fecha_envio"]);
            $nestedData[] = $value["estado"];
            $nestedData[] = '<a class="btn btn-success" href="mainpanel/boletin/probar/'.$value["id"].'"><i class="icon-edit icon-white"></i> ENVIAR PRUEBA</a> 
                            <a class="btn btn-success" href="mainpanel/boletin/preview/'.$value["id"].'"><i class="icon-edit icon-white"></i> PREVIEW</a> 
                            <a class="btn btn-info" href="mainpanel/boletin/enviar/'.$value["id"].'"><i class="icon-edit icon-white"></i> ENVIAR</a> 
                            <br><br>
                            <a class="btn btn-warning" href="mainpanel/boletin/editar/'.$value["id"].'"><i class="icon-edit icon-white"></i> EDITAR</a> 
                            <a class="btn btn-danger" href="javascript:deleteBoletin(\''.$value["id"].'\')"><i class="icon-trash icon-white"></i>BORRAR</a> 
                            ';
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
        $dataPrincipal["cuerpo"]="boletin/nuevo_view";        
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
        $dataPrincipal["resultado"]= $resultado;
        $dataPrincipal["error"]= $error;
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
        $dataPrincipal["cuerpo"]="boletin/edit_view";        
        // EDITAR BOLETIN
        $id_boletin = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $boletin = $this->Boletin_model->getBoletin($id_boletin);
        $productos = $boletin->productos;

        if($productos=="")
        {
            $hay_productos = false;
            $listaProductos = '';
            $productos_elegidos = '';
        }
        else
        {
            $hay_productos = true;
            $aux_productos = explode("#", $productos);
            $listaProductos = array();
            $productos_elegidos = array();
            for($i=0; $i<count($aux_productos); $i++)
            {
                $id_producto = trim($aux_productos[$i]);
                if($id_producto!="")
                {
                    $aux = $this->Boletin_model->getProducto($id_producto);
                    if(count($aux)>0)
                    {
                        $aux_pr = array();
                        $aux_pr['id_producto'] = $aux->id_producto;
                        $aux_pr['nombre_producto'] = $aux->nombre;
                        $aux_pr['codigo_producto'] = $aux->codigo;
                        $aux_pr['imagen_producto'] = $aux->imagen;
                        $listaProductos[] = $aux_pr;
                        //$productos_elegidos[] = $aux->id_producto;
                        //$productos_elegidos = implode("#", $productos_elegidos);
                    }
                }
            }
        }
        $dataPrincipal["productos_elegidos"] = $productos;
        $dataPrincipal["id_boletin"] = $id_boletin;
        $dataPrincipal["boletin"] = $boletin;
        $dataPrincipal["hay_productos"] = $hay_productos;
        $dataPrincipal["productos"] = $listaProductos;
        $dataPrincipal["resultado"] = $resultado;
        //$dataPrincipal["error"]= $error;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);         
    }
    
    public function grabar() {
        $this->validacion->validacion_login();
        // GRABAR BOLETIN
        $titulo = $this->input->post('titulo');
        $asunto = $this->input->post('asunto');
        $contenido = $this->input->post('contenido');
        $emails_prueba = $this->input->post('emails_prueba');
        $estado = 'Pendiente de Envio';
        $productos_elegidos = $this->input->post('productos_elegidos');
        $data = array();
        $data['titulo'] = $titulo;  
        $data['asunto'] = $asunto;  
        $data['contenido'] = $contenido;
        $data['emails_prueba'] = $emails_prueba;
        $data['estado'] = $estado;
        $data['productos'] = $productos_elegidos;
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
                $id_producto = $this->Boletin_model->grabarBoletin($data);
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
            $id_producto = $this->Boletin_model->grabarBoletin($data);
            redirect('mainpanel/boletin/listado/success');
        }
    }
    
    public function actualizar() {
        $this->validacion->validacion_login();
        // GRABAR BOLETIN
        $id_boletin = $this->input->post('id_boletin');
        $titulo = $this->input->post('titulo');
        $asunto = $this->input->post('asunto');
        $contenido = $this->input->post('contenido');
        $emails_prueba = $this->input->post('emails_prueba');
        $estado = 'Pendiente de Envio';
        $productos_elegidos = $this->input->post('productos_elegidos');
        $data = array();
        $data['titulo'] = $titulo;  
        $data['asunto'] = $asunto;  
        $data['contenido'] = $contenido;
        $data['emails_prueba'] = $emails_prueba;
        $data['estado'] = $estado;
        $data['productos'] = $productos_elegidos;
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
                $this->Boletin_model->actualizarBoletin($id_boletin, $data);
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
            $this->Boletin_model->actualizarBoletin($id_boletin, $data);
            redirect('mainpanel/boletin/listado/success');
        }
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
        $dataPrincipal["cuerpo"]="boletin/detalle";
        // PREVIEW DE BOLETIN
        $id_boletin = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $boletin = $this->Boletin_model->getBoletin($id_boletin);
        $dataPrincipal['boletin'] = $boletin;
        
        // LISTA PRODUCTOS
        if($boletin->productos!="")
        {
            $hay_productos = true;
            $elegidos = explode("#", $boletin->productos);
            $productos = array();
            for($i=0; $i<count($elegidos); $i++)
            {
                $id_producto = $elegidos[$i];
                $producto = $this->Boletin_model->getProducto($id_producto);
                $aux2 = array();
                $aux2['id_producto'] = $producto->id_producto;
                $aux2['nombre'] = $producto->nombre;
                $aux2['imagen'] = $producto->imagen;
                $aux2['codigo'] = $producto->codigo;
                $productos[] = $aux2;
            }
        }
        else
        {
            $hay_productos = false;
            $productos = '';
        }
        $dataPrincipal["hay_productos"] = $hay_productos;
        $dataPrincipal["productos"] = $productos;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
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
        $boletin = $this->Boletin_model->getBoletin($id_boletin);
        
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
        if($boletin->productos=="")
        {
            $hay_productos = false;
        }
        else
        {
            $hay_productos = true;
            $productos = explode('#', $boletin->productos);
            $num_productos  = count($productos);
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
            $msg .= '<td colspan="3" class="cabecera"><img src="http://www.ckiinternacional.net/files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
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
        
        if($hay_productos===true)
        {
            if($num_productos%3==0)
            {
                $num_filas = $num_productos/3;
            }
            else
            {
                $num_filas = (int)($num_productos/3) + 1;
            }
            $indice = 0;
            $msg .= '<tr>';
            $msg .= '<td></td>';
            $msg .= '<td>';
            $msg .= '<table width="100%" cellspacing="5" cellpadding="0">';
            for($i=0; $i<$num_filas; $i++)
            {
                $msg .= '<tr>';
                for($j=0; $j<3; $j++)
                {
                    $indice_current = 3*($i) + $j;
                    if($indice_current<$num_productos)
                    {
                        $id_current = $productos[$indice_current];
                        $current = $this->Boletin_model->getProducto($id_current);
                        $foto = $current->imagen;
                        $id_producto = $current->id_producto;
                        $nombre= $current->nombre;						
                        $codigo= $current->codigo;
                        $pic = '<img src="http://www.ckiinternacional.net/files/productos_thumbs_m/'.$foto.'" width="200" height="200" style="border:1px solid #000;" />';
                        $msg .= '<td width="200">';
                        $msg .= '<table width="100%">';
                        $msg .= '<tr>';												
                            $msg .= '<td align="center" valign="middle">'.$pic.'</td>';
                        $msg .= '</tr>';

                        $msg .= '<tr>';
                            $msg .= '<td height="23" align="center" valign="middle" class="nombreProducto">'.$nombre.'</td>';
                        $msg .= '</tr>';

                        $msg .= '<tr>';
                            $msg .= '<td height="23" align="center" valign="middle" class="codigoProducto">'.$codigo.'</td>';
                        $msg .= '</tr>';
                        $msg .= '</table>';
                        $msg .= '</td>';
                    }
                    else
                    {
                        $msg .= '<td width="200"></td>';
                    }
                }
                $msg .= '</tr>';
            }
            $msg .= '</table>';
            $msg .= '</td>';
            $msg .= '<td></td>';
            $msg .= '</tr>';
        }
        $msg .= '<tr>';
        $msg .= '<td colspan="3" height="10"></td>';
        $msg .= '</tr>';
        
        $msg .= '</body>';
        $msg .= '</html>';
        
        $correo_notificaciones = getConfig('correo_notificaciones');
        
        //************* ENVIO CON MANDRILL
        for($i=0; $i<count($destinatarios); $i++)
        {
            /*
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
            */
            $destinatario = $destinatarios[$i];

            /***************** ENVIO CON SENDGRID **************/
            /*
            $sendgrid = new SendGrid('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');
            $email = new SendGrid\Email();
            $email
                ->addTo($destinatario)
                ->setFrom($correo_notificaciones)
                ->setFromName("CKI INTERNACIONAL")
                ->setSubject($asunto)
                ->setHtml($msg)
            ;
            $res = $sendgrid->send($email);
            $respuesta = $res->getCode();
            if($respuesta==200)
            {
                $resultado = 'success';
            }
            else
            {
                $resultado = 'error';
            }
            */
            /***************** FIN DE ENVIO CON SENDGRID **************/


            $mail = new PHPMailer();
            $mail->From = $correo_notificaciones; // direccion de quien envi
            $mail->FromName = "CKI INTERNACIONAL"; // nombre de quien envia
            $mail->AddAddress($destinatario);
            $mail->Subject = $asunto; 
            $mail->Body = $msg;
            $mail->IsHTML(true);
            @$mail->Send();
            $resultado = 'success';

        }        
        redirect('mainpanel/boletin/listado/'.$resultado);
    }

    public function prueba() {
        $clientes = $this->Boletin_model->getListaClientesActivos();
        //echo count($clientes); die();
        $i=0;
        foreach ($clientes as $cliente) {
            if($i<1000)
            {
                echo $cliente->email.'<br>';  
            }
            $i++;
        }
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
        $boletin = $this->Boletin_model->getBoletin($id_boletin);
        
        $asunto = $boletin->asunto;
        $contenido = $boletin->contenido;
        $titulo = $boletin->titulo;

        
        if($boletin->productos=="")
        {
            $hay_productos = false;
        }
        else
        {
            $hay_productos = true;
            $productos = explode('#', $boletin->productos);
            $num_productos  = count($productos);
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
            $msg .= '<td colspan="3" class="cabecera"><img src="http://www.ckiinternacional.net/files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
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
        
        if($hay_productos===true)
        {
            $msg .= '<tr>';
            $msg .= '<td colspan="3" height="10"></td>';
            $msg .= '</tr>';

            $msg .= '<tr>';
            $msg .= '<td></td>';
            $msg .= '<td>';
            $msg .= '<table width="100%" cellspacing="5" cellpadding="0">';
            if($num_productos%3==0)
            {
                $num_filas = $num_productos/3;
            }
            else
            {
                $num_filas = $num_productos/3 + 1;
            }
            $indice = 0;        
            for($i=0; $i<$num_filas; $i++)
            {
                $msg .= '<tr>';
                for($j=0; $j<3; $j++)
                {
                    $indice_current = 3*($i) + $j;
                    if($indice_current<$num_productos)
                    {
                        $id_current = $productos[$indice_current];
                        $current = $this->Boletin_model->getProducto($id_current);
                        $foto = $current->imagen;
                        $id_producto = $current->id_producto;
                        $nombre= $current->nombre;						
                        $codigo= $current->codigo;
                        $pic = '<img src="http://www.ckiinternacional.net/files/productos_thumbs_m/'.$foto.'" width="200" height="200" style="border:1px solid #000;" />';
                        $msg .= '<td width="200">';
                        $msg .= '<table width="100%">';
                        $msg .= '<tr>';												
                            $msg .= '<td align="center" valign="middle">'.$pic.'</td>';
                        $msg .= '</tr>';

                        $msg .= '<tr>';
                            $msg .= '<td height="23" align="center" valign="middle" class="nombreProducto">'.$nombre.'</td>';
                        $msg .= '</tr>';

                        $msg .= '<tr>';
                            $msg .= '<td height="23" align="center" valign="middle" class="codigoProducto">'.$codigo.'</td>';
                        $msg .= '</tr>';
                        $msg .= '</table>';
                        $msg .= '</td>';
                    }
                    else
                    {
                        $msg .= '<td width="200"></td>';
                    }
                }
                $msg .= '</tr>';
            }
            $msg .= '</table>';
            $msg .= '</td>';
            $msg .= '<td></td>';
            $msg .= '</tr>';
        }
        $msg .= '</table>';
        $msg .= '</body>';
        $msg .= '</html>';
        
        $correo_notificaciones = getConfig('correo_notificaciones');

        //echo count($destinatarios); die();
        //************* ENVIO CON MANDRILL
        //$clientes = $this->Boletin_model->getListaClientesActivos_prueba();
        $clientes = $this->Boletin_model->getListaClientesActivos();

        foreach ($clientes as $cliente)
        {
            $destinatario = $cliente->email;

            $mail = new PHPMailer();
            $mail->From = $correo_notificaciones; // direccion de quien envi
            $mail->FromName = "CKI INTERNACIONAL"; // nombre de quien envia
            $mail->AddAddress($destinatario);
            $mail->Subject = $asunto; 
            $mail->Body = $msg;
            $mail->IsHTML(true);
            @$mail->Send();
            $resultado = 'success';           
        }
        $datos['estado'] = 'Enviado';
		$datos['fecha_envio'] = fecha_hoy_Ymd();
        $this->Boletin_model->updateEstadoBoletin($id_boletin, $datos);
        redirect('mainpanel/boletin/listado/'.$resultado);
    }
    
    public function delete() {
        $this->validacion->validacion_login();
        $id_boletin = $this->uri->segment(4);
        $this->Boletin_model->deleteBoletin($id_boletin);
        redirect('mainpanel/boletin/listado/success');
    }	

}
?>
