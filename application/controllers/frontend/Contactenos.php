<?php
class Contactenos extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('My_PHPMailer');
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Contactenos_model');  
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
            $data['seccion'] = 'contactenos';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // REGISTRO
            $this->load->helper('captcha');
            $vals = array(
               'img_path' => './assets/frontend/cki/captcha/',
               'img_url' => base_url().'/assets/frontend/cki/captcha/',
                //'img_url' => 'http://www.ckiinternacional.net/assets/frontend/cki/captcha/',
                'font_path' => './assets/frontend/cki/fonts/MyriadPro-Bold.ttf',
                'img_width' => '110',
                'img_height' => 40
               );
            $cap = create_captcha($vals);
            $data = array(
               'captcha_time' => $cap['time'],
               'ip_address' => $this->input->ip_address(),
               'word' => $cap['word']
               );
            $this->session->set_userdata($data);
            // store image html code in a variable
            $dataPrincipal['cap_img']= $cap['image'];
            $dataPrincipal['codigo_secreto']= $cap['word'];
            
           // store the captcha word in a session
            $this->session->set_userdata('word', $cap['word']);
            
            // CONTACTENOS
            $resultado= $this->uri->segment(2);
            $dataPrincipal['resultado'] = $resultado;            
            $dataPrincipal['contenido'] = getInfo("contactenos");
            $dataPrincipal['cuerpo'] = 'contactenos';
            $this->load->view('frontend/includes/template', $dataPrincipal);
	}
	
	function enviar_mensaje() {
            // RESULTADO ENVIO
            $datos=Array();
            $datos["nombre"] = $this->input->post('nombre');
            $datos["email"] = $this->input->post('email');
            $datos["telefono"] = $this->input->post('telefono');
            $datos["estatus"] = 'No Leido';
            $datos["empresa"] = $this->input->post('empresa');
            $hoy=fecha_hoy_Ymd();
            $datos["fecha_ingreso"] = $hoy;
            $datos["mensaje"] = $this->input->post('mensaje');
            $codigo = $this->input->post('codigo');
            if($this->session->userdata('word')== $codigo)
            {
                $resultado = $this->Contactenos_model->sendMensaje($datos);
                if($resultado==1)
                {
                    $correo_notificaciones = getConfig('correo_notificaciones');
                    // ENVIO  DE MAIL DE VERIFICACION CON EL PHP MAILER
                    $mail = new PHPMailer();
                    $mail->From = $datos["email"]; // direccion de quien envi
                    $mail->FromName = $datos["nombre"]; // nombre de quien envia
                    $mail->AddAddress($correo_notificaciones);
                    //$mail->AddReplyTo($correo, $destinatario);
                    $mail->Subject = "Mensaje del Portal Web CKI Internacional- Formulario Contáctenos"; 
                    $msg = "Se ha enviado el siguiente mensaje desde su Portal Web - Formulario Contáctenos.<br>\n";
                    $msg .= "===============================================================<br>\n";
                    $msg .= " DATOS DEL REMITENTE <br>\n";
                    $msg .= "===============================================================<br>\n";
                    $msg .= "<b>NOMBRE : </b>".$datos["nombre"]."<br />\n";
                    $msg .= "<b>EMAIL : </b>".$datos["email"]."<br />\n";
                    $msg .= "<b>TELEFONO : </b>".$datos["telefono"]."<br />\n";			
                    $msg .= "<b>EMPRESA: </b>".$datos["empresa"]."<br />\n";						
                    $msg .= "===============================================================<br />\n";
                    $msg .= "<b>MENSAJE</b> <br>\n";
                    $msg .= "===============================================================<br />\n";	
                    $msg .= $datos["mensaje"]."<br />\n";
                    $msg .= "===============================================================<br />\n";
                    $mail->Body = $msg;
                    $mail->IsHTML(true);
                    @$mail->Send();
                    $resultado='ok';
                    redirect('contactenos/success');
                }
                else
                {
                    redirect('contactenos/error');                
                }
            }
            else
            {
                redirect('contactenos/codigo'); 
                //redirect('contactenos/'.$codigo);
            }
            
	}
}
?>