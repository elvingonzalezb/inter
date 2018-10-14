<?php
class Registrese extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('My_PHPMailer');
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Registrese_model');
        $this->load->helper('captcha');
	}
	function index()
	{
            $data2 = array();
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
            $data = array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = '';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // REGISTRO
            /*$this->load->helper('captcha');
            $vals = array(
                'img_path' => './assets/frontend/cki/captcha/',
                //'img_url' => 'http://www.misticadigital.com/py_ckiinter/assets/frontend/cki/captcha/',
                'img_url' => base_url().'assets/frontend/cki/captcha/',
                //'img_url' => 'http://www.inversionesjemal.com/demos/cki2015/assets/frontend/cki/captcha/',
                'font_path' => './assets/frontend/cki/fonts/MyriadPro-Bold.ttf',
                'img_width' => '130',
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
            $this->session->set_userdata('word', $cap['word']);*/
            $dataPrincipal['recaptcha'] = $this->recaptcha->render();

            $resultado= $this->uri->segment(2);
            $dataPrincipal['paises']= $this->Registrese_model->ListPaises();            
            $dataPrincipal['resultado'] = $resultado;            
            $dataPrincipal['contenido'] = getInfo("registro");
            $dataPrincipal['categorias'] = $categorias;
            $dataPrincipal['cuerpo'] = 'registrese';
            $this->load->view('frontend/includes/template', $dataPrincipal);
	}
	
	function grabar() {           
        
            // GRABAR REGISTRO
            $razon_social= $this->input->post('razon_social');   
            $datos["razon_social"] = $razon_social;
            $ruc= $this->input->post('ruc');              
            $datos["ruc"] = $ruc;
            $nombre= $this->input->post('nombre');
            $datos["nombre"] = $nombre;
            $datos["apellido"] = $this->input->post('apellido');
            $datos["cargo"] = $this->input->post('cargo');
            $datos["domicilio"] = $this->input->post('domicilio');
            $datos["ciudad"] = $this->input->post('ciudad');
            $datos["provincia"] = $this->input->post('provincia');
            $datos["departamento"] = $this->input->post('departamento');
            $datos["distrito"] = $this->input->post('distrito');
            $datos["pais"] = $this->input->post('pais'); 
            $datos["procedencia"] = 'Lima'; 
            $datos["zip"] = $this->input->post('zip');            
            $telefono= $this->input->post('telefono');
            $datos["telefono"] = $telefono;
            $datos["telefono2"] = $this->input->post('telefono2');
            $datos["fax"] = $this->input->post('fax');
            $tipo_cliente= $this->input->post('tipo_cliente');
            $datos["tipo_cliente"] = $tipo_cliente;
            //$datos["preferencias"] = $this->input->post('preferencias');
            $datos["preferencias"] = '';
            $datos["web"] = $this->input->post('web');            
            $email= $this->input->post('email');
            $datos["email"] = $email;
            $clave= $this->input->post('password');            
            $datos["clave"] =$clave;
            $datos["estado"] = 'Inactivo';            
            $datos["fecha_registro"] = date("Y-m-d H:i:s");
            $datos["ver_precio"] = 'no';
            $datos["ver_inventario"] = 'no';
            $datos["moneda"] = 's';
            $datos["descuento"] = 'no';  
            $datos["codigo_cliente"] = '';
            $datos["nivel"] = 'administrador';
            //$codigo = $this->input->post('codigo');
            $this->session->set_userdata('arreglo',$datos);  
            $recaptcha = $this->input->post('g-recaptcha-response');
            $response = $this->recaptcha->verifyResponse($recaptcha);

            if($response['success']){           
            //$flag_x = true;
            //if($this->session->userdata('word')== $codigo)
            //if($flag_x==true) // para probar el registro sin el captcha q no sale en local
            //{
                //$resultRuc=ValidRucPeru($ruc);
                $resultEmail = $this->Registrese_model->verfCorreo($email);
                if($resultEmail) {
                    $str='El Email '.$email.' ya esta registrado en nuestra Base de Datos';
                    $this->session->set_userdata("errorRegistro",$str);
                    redirect('registrese');
                }        
                $resultNom = $this->Registrese_model->verfNombre($nombre);
                if($resultNom) {
                    $str='El nombre de contacto '.$nombre.' ya esta registrado en nuestra Base de Datos';
                    $this->session->set_userdata("errorRegistro",$str);
                    redirect('registrese');
                }

                $resultado = $this->Registrese_model->insertRegistro($datos);
                if($resultado>0) {
                    $aux_reg = $this->Registrese_model->getIdCliente($email);
                    $id_registro = $aux_reg->id;
                    $aux_reg2 = str_pad($id_registro, 6, "0", STR_PAD_LEFT);
                    $codigo_cliente = 'CL'.$aux_reg2;
                    $datos_reg = array();
                    $datos_reg['codigo_cliente'] = $codigo_cliente;
                    $resultado2 = $this->Registrese_model->actualizaCodCliente($id_registro, $datos_reg);
                    if($resultado2>0) {
                        $correo_notificaciones = getConfig('correo_notificaciones');

                        $mail = new PHPMailer();
                        $mail->From = $correo_notificaciones; // direccion de quien envia
                        $mail->FromName = "Registro CKI Internacional"; // nombre de quien envia
                        $mail->AddAddress($correo_notificaciones);
                        $mail->Subject = "Se ha realizado un registro en la web de CKI"; 
                        $msg = "Aqui le mostramos los datos generales del cliente:<br /><br />\n";
                        $msg .= "===============================================================<br>\n";
                        $msg .= " INFORMACION DE CLIENTE <br />\n";
                        $msg .= "===============================================================<br>\n";
                        $msg .= "<b>EMPRESA : </b>".$razon_social."<br />\n";
                        $msg .= "<b>NOMBRE : </b>".$nombre."<br />\n";
                        $msg .= "<b>TEL&Eacute;FONO : </b>".$telefono."<br />\n";
                        $msg .= "<b>EMAIL : </b>".$email."<br />\n";
                        $msg .= "===============================================================<br>\n";
                        $msg .= " INFORMACION DE ACCESO: <br />\n";
                        $msg .= "===============================================================<br>\n";
                        $msg .= "<b>USUARIO: </b>".$email."<br />\n";
                        $msg .= "<b>PASSWORD: </b>".$clave."<br />\n";
                        $msg .= "===============================================================<br>\n";
                        $msg .= " ACCESO: <br />\n";
                        $msg .= "===============================================================<br>\n";		
                        $msg .= '<b>ACCESO: </b><a href="'.base_url().'ingresar" target="_blank">Click Aqui para ingresar co su Usuario.</a><br /><br /><br />\n';
                        $msg .= "===============================================================<br>\n";		                    
                        $msg .= "Gracias por su preferencia <br>\n";
                        $msg .= "Atte. <br>\n";
                        $msg .= "CKI INTERNACIONAL<br>\n";	                    
                        $mail->Body = $msg;
                        $mail->IsHTML(true);
                        @$mail->Send();
                        // FIN DE ENVIO CON EL PHP MAILER

                        // ENVIO DE MAIL COPIA
                        /*
                        $mail2 = new PHPMailer();
                        $mail2->From = $correo_notificaciones; // direccion de quien envia
                        $mail2->FromName = "Registro CKI Internacional"; // nombre de quien envia
                        $mail2->AddAddress($email);
                        $mail2->Subject = "Se registró exitosamente en la web de CKI Internacional"; 			
                        $mail2->Body = $msg;
                        $mail2->IsHTML(true);
                        @$mail2->Send();
                        */

                        switch($tipo_cliente){
                            case "Publicistas":
                                $str='Hemos recibido su solicitud de registro. En breves momentos recibira un correo con el resultado del mismo';
                            break;
                            case "Distribuidor":
                                $str='Hemos recibido su solicitud de registro. En breves momentos recibira un correo con el resultado del mismo';                        
                            break;
                            case "Cliente Final":
                                $str='Se registraron sus datos con Exito, solo se tomaran en cuenta los tipos de Cliente Publicistas y Distribuidores.';                            
                            break;                    
                        }
                        $this->session->set_userdata('msg_registro',$str);
                        $this->session->unset_userdata('arreglo');
                        redirect('registrese');
                    } else {
                        $str = 'No se puedo grabar su registro, error de Codigo de Cliente';
                        $this->session->set_userdata("errorRegistro",$str);
                        //redirect('registrese');
                        $dataPrincipal = array();
                        $dataPrincipal['aux_reg'] = $aux_reg;
                        $dataPrincipal['id_registro'] = $id_registro;
                        $this->load->view('frontend/vista_prueba', $dataPrincipal);
                    }
                } else {
                    $str='No se puedo grabar su registro, intentelo de nuevo';
                    $this->session->set_userdata("errorRegistro",$str);
                    redirect('registrese');  
                }
            } else {
                $str='Se requiere el ReCaptcha';
                $this->session->set_userdata("errorRegistro",$str);
                redirect('registrese'); 
            }
	} // end function
}
?>