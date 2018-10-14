<?php
class Mis_datos extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('My_PHPMailer');
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Mis_datos_model');  
                $this->load->library('Validacion');
	}
	function form_actualizacion()
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
            
            // FORM ACTUALIZAR
                
            $resultado= $this->uri->segment(3);
            $dataPrincipal['paises']= $this->Mis_datos_model->ListPaises();
            $id=$this->session->userdata('id_cliente_logueado');
            $dataPrincipal['cliente']= $this->Mis_datos_model->getCliente($id);
            $dataPrincipal['resultado'] = $resultado; 
            $dataPrincipal['categorias'] = $categorias; 
            $dataPrincipal['cuerpo'] = 'form_actualizacion';
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
            $datos["cargo"] = $this->input->post('cargo');
            $datos["domicilio"] = $this->input->post('domicilio');
            $datos["ciudad"] = $this->input->post('ciudad');
            $datos["provincia"] = $this->input->post('provincia');
            $datos["departamento"] = $this->input->post('departamento');            
            $datos["distrito"] = $this->input->post('distrito');            			
            $datos["pais"] = $this->input->post('pais');            
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

            $email=$this->session->userdata('email');
            $id=$this->session->userdata('id_cliente_logueado');
            $resultRuc = true;
            //$resultRuc=ValidRucPeru($ruc);
            if($resultRuc){
                $this->Mis_datos_model->actualizarRegistro($datos,$id);
                $correo_notificaciones = getConfig('correo_notificaciones');
                $mail = new PHPMailer();
                $mail->From = $email;
                $mail->FromName = "Actualización de datos CKI Internacional";
                $mail->AddAddress($correo_notificaciones);
                $mail->Subject = "Un Cliente acaba de actualizar sus datos en la web de CKI"; 
                $msg = "Aqui le mostramos los datos generales del cliente:<br /><br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= " INFORMACION DE CLIENTE <br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= "<b>EMPRESA : </b>".$razon_social."<br />\n";
                $msg .= "<b>NOMBRE : </b>".$nombre."<br />\n";
                $msg .= "<b>TEL&Eacute;FONO : </b>".$telefono."<br />\n";
                $msg .= "<b>EMAIL : </b>".$email."<br />\n";
                $msg .= "===============================================================<br>\n";
                $mail->Body = $msg;
                $mail->IsHTML(true);
                @$mail->Send();
                // FIN DE ENVIO CON EL PHP MAILER
                $this->session->set_userdata('ses_razon',$razon_social);
                $this->session->set_userdata('nombre',$nombre);
                redirect('mis-datos/actualizacion/success');
            }else{
                redirect('mis-datos/actualizacion/error-ruc');
            }
	}
}
?>