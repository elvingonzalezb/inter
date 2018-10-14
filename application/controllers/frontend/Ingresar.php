<?php
class Ingresar extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('My_PHPMailer');
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Ingresar_model'); 
        $this->load->library('session');
        $this->load->helper('captcha');
	}
	function index()
	{
            // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
            $categorias = $this->Inicio_model->getCategorias();
            $listaCategorias = array();
            foreach($categorias as $auxCategoria)
            {
                $auxCats = array();
                $auxCats['id_categoria'] = $auxCategoria->id_categoria;
                $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
                $listaSubcategorias = $this->Inicio_model->getListaSubCategorias($auxCategoria->id_categoria);
                $subcategoriasItem = array();
                foreach($listaSubcategorias as $subcategoria)
                {
                    $auxSubCats = array();
                    $auxSubCats['id_subcategoria'] = $subcategoria->id_subcategoria;
                    $auxSubCats['nombre'] = $subcategoria->nombre;
                    $subcategoriasItem[] = $auxSubCats;
                }
                $auxCats['subcategorias'] = $subcategoriasItem;
                $listaCategorias[] = $auxCats;
            }
            $data2['id_cat_current'] = 0;
            $data2['id_subcat_current'] = 0;
            $data2['categorias'] = $listaCategorias;
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true);  
            
            // GENERAL            
            $data2=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = '';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // CONTACTENOS
            $resultado= $this->uri->segment(2);
            $dataPrincipal['resultado'] = $resultado;            
            $dataPrincipal['contenido'] = getInfo("inciar_sesion");
            $dataPrincipal['cuerpo'] = 'ingresar';
            #captcha
            $dataPrincipal['recaptcha'] = $this->recaptcha->render();
            $this->load->view('frontend/includes/template', $dataPrincipal);
	}
	
	function logueo() {
        // RECIBE DATOS
        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password');
        $existe = $this->Ingresar_model->consultLogueo($usuario,$password);
        #Login
        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if($response['success']){
            if($existe) {     
                $hoy=fecha_hoy_Ymd();
                $data['fecha_ingreso']=$hoy;
                $data['email']=$usuario;
                $resultado = $this->Ingresar_model->grabaIngreso($data);
                
                if($existe->tipo_cliente=='Cliente Final') {
                    $str = 'ACCESO NO DISPONIBLE / LA PAGINA ES PARA USO EXCLUSIVO DE DISTRIBUIDORES AUTORIZADOS';
                    $this->session->set_userdata('msg_cliente_final', $str);
                    redirect('ingresar');
                } else {
                    $this->session->set_userdata('logueadocki', true);
                    $this->session->set_userdata('ses_razon', $existe->razon_social);
                    $this->session->set_userdata('ver_precio', $existe->ver_precio);
                    $this->session->set_userdata('ver_inventario', $existe->ver_inventario);
                    $this->session->set_userdata('id_cliente_logueado', $existe->id);
                    $this->session->set_userdata('email', $existe->email);
                    $this->session->set_userdata('moneda', $existe->moneda);
                    $this->session->set_userdata('descuento_cambio_moneda', $existe->descuento);
                    $this->session->set_userdata('descuento_especial', $existe->descuento_especial);
                    $this->session->set_userdata('categorias_especiales', $existe->categorias_especiales);
                    $this->session->set_userdata('mostro_modal_import', "no");
                    $this->session->set_userdata('nivel', $existe->nivel);
                    $this->session->set_userdata('id_padre', $existe->id_padre);
                    $this->session->set_userdata('tiene_cargos', $existe->tiene_cargos);
                    $this->session->set_userdata('procedencia', $existe->procedencia);

                    $destinatarios =  explode(",", getConfig("notificaciones_ingresos"));
                    $correo_notificaciones = getConfig("correo_notificaciones");
                    
                    $mail = new PHPMailer();
                    $mail->From = $correo_notificaciones; // direccion de quien envia
                    $mail->FromName = "CKI Internacional"; // nombre de quien envia
                    for($j=0; $j<count($destinatarios); $j++) {
                        $currentDest = trim($destinatarios[$j]);
                        $mail->AddAddress($currentDest);
                    }
                    $mail->Subject = "Un Cliente ha ingresado al catalogo de CKI"; 
                    $msg = "Un cliente ha ingresado al catalogo virtual de CKI:<br /><br />\n";
                    $msg .= "===============================================================<br>\n";
                    $msg .= " INFORMACION DE CLIENTE <br />\n";
                    $msg .= "===============================================================<br>\n";
                    $msg .= "<b>EMPRESA : </b>".$existe->razon_social."<br />\n";
                    $msg .= "<b>NOMBRE : </b>".$existe->nombre."<br />\n";
                    $msg .= "<b>TEL&Eacute;FONO : </b>".$existe->telefono."<br />\n";
                    $msg .= "<b>EMAIL : </b>".$existe->email."<br />\n";
                    $msg .= "===============================================================<br />\n";		
                    $mail->Body = $msg;
                    $mail->IsHTML(true);
                    @$mail->Send();
                    
                    $url=  base_url();
                    redirect($url);
                }        
            } else {
                $resultado = $this->Ingresar_model->usu_y_pass($usuario,$password);
                if($resultado){
                    redirect('ingresar/estado');
                }else{
                    $resultado = $this->Ingresar_model->pass($password);
                    if($resultado){
                        redirect('ingresar/usuario');
                    }else{
                        redirect('ingresar/password');
                    }
                }
            }
        }else{
            $this->session->set_flashdata('msg_captcha', '<div class="form-group has-feedback"><div class="alert alert-warning">Re-captcha incorrecto.</div></div>');
            redirect('ingresar');
        }
	}

    function logout() {
        $this->session->unset_userdata('logueadocki');
        $this->session->unset_userdata('ses_razon');
        $this->session->unset_userdata('ver_precio');
        $this->session->unset_userdata('ver_inventario');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('moneda');
        $this->session->unset_userdata('descuento_cambio_moneda');
        $this->session->unset_userdata('descuento_especial');
        $this->session->unset_userdata('msg_cliente_final');
        $this->session->unset_userdata('carrito');
        $this->session->unset_userdata('tipoReserva');
        $this->session->unset_userdata('nivel');
        $this->session->unset_userdata('id_padre');
        
        $url= base_url();
        redirect($url);
    }        

}
?>
