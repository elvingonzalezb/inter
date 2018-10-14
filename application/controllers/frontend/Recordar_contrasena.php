<?php
class Recordar_contrasena extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('My_PHPMailer');
		$this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Recordar_contrasena_model'); 
                $this->load->library('session');                    
                
	}
	function index()
	{
            // GENERAL
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
            
            // CONTACTENOS
            $resultado= $this->uri->segment(2);
            $dataPrincipal['resultado'] = $resultado;            
            $dataPrincipal['contenido'] = getInfo("inciar_sesion");
            $dataPrincipal['cuerpo'] = 'recordar_contrasena';
            $this->load->view('frontend/includes/template', $dataPrincipal);
	}
	
	function buscar() {
            // RECIBE DATOS
            $email= $this->input->post('email');            
            $existe = $this->Recordar_contrasena_model->consultEmail($email);            
            
            if($existe)
            {     

                $correo_notificaciones=  getConfig("correo_notificaciones");

                $mail = new PHPMailer();
                $mail->From = $correo_notificaciones; // direccion de quien envia
                $mail->FromName = "CKI Internacional"; // nombre de quien envia
                $mail->AddAddress($email);                
                $mail->AddAddress($correo_notificaciones);
                $mail->Subject = "Recuperacion de Contraseña"; 
                $msg = "Usted acaba de solicitar la recuperacion de su contraseña:<br /><br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= " DATOS SOLICITADOS <br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= "<b>EMPRESA : </b>".$existe->razon_social."<br />\n";
                $msg .= "<b>CLAVE : </b>".$existe->clave."<br />\n";
                $msg .= "===============================================================<br />\n";		
                $mail->Body = $msg;
                $mail->IsHTML(true);
                @$mail->Send(); 

                redirect('recordar-contrasena/success');  
            }else{
                redirect('recordar-contrasena/email-incorrecto');                    
            }
	}
       

}
?>
