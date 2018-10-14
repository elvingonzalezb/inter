<?php
class Pedidos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Pedido_model');
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
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/index_view";

        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function dolistado() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/lista_view";


        // LISTA ORDENES
        $fecha_inicio = dmY_2_Ymd($this->input->post('fecha_inicio'));
        $fecha_fin = dmY_2_Ymd($this->input->post('fecha_fin'));

        $aux = $this->Pedido_model->getListaPedidosFechas($fecha_inicio, $fecha_fin);
        $ordenes = array();
        foreach($aux as $dato_orden)
        {
            $aux2 = array();
            $aux2['id_orden'] = $dato_orden->id_orden;
            $auxiliar = $dato_orden->id_orden;
            $aux2['codigo_orden'] = 10000 + $auxiliar;
            $aux2['id_cliente'] = $dato_orden->id_cliente;
            if($dato_orden->id_cliente ===0)
            {
                $nombre='No se tiene asignado un cliente';
            }
            else
            {
                $ax = $this->Pedido_model->getCliente($dato_orden->id_cliente);                
                $num_ax=count($ax);
                if($num_ax>0){
                    $nombre = $ax->nombre;  
                    $ruc = $ax->ruc;
                    $razon_social = $ax->razon_social;        
                }else{
                   $nombre='El cliente no existe en la Base de Datos';
                   $ruc = '---';
                   $razon_social = '---';
                }
            }
            $aux2['nombre_cliente'] = $nombre;
            $aux2['ruc_cliente'] = $ruc;
            $aux2['razon_social_cliente'] = $razon_social;
            $aux2['total'] = $dato_orden->total;
            $aux2['fecha_ingreso'] = $dato_orden->fecha_ingreso;
            $aux2['estado'] = $dato_orden->estado;
            // CODIGOS DE PRODUCTOS
            $aux_prods_1 = explode("~",$dato_orden->pedidos);
            $numero_productos = $aux_prods_1[0];
            $codigos_productos = array();
            for($i=1; $i<=$numero_productos; $i++)
            {
                $da1 = $aux_prods_1[$i];
                $da2 = explode("@",$da1);
                $codigoProducto = $da2[4];
                $codigos_productos[] = $codigoProducto;
            }
            $aux2['codigos_productos'] = implode("<br>", $codigos_productos); 
            $ordenes[] = $aux2;
        }
        $dataPrincipal['ordenes'] = $ordenes;
        $resultado = $this->uri->segment(4);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function listado_old() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/index_view";
        
        // LISTA ORDENES
        if($this->uri->segment(4))
        {
            $pagina = $this->uri->segment(4);
        }
        else
        {
            $pagina = 1;
        }        
        $num_pedidos = $this->Pedido_model->getNumPedidos();
        $pedidos_x_pagina = 100;
        if($num_pedidos % $pedidos_x_pagina==0)
        {
            $num_paginas = $num_pedidos / $pedidos_x_pagina;
        }
        else
        {
            $num_paginas = (int)($num_pedidos/$pedidos_x_pagina) + 1;
        }
        $reg_inicial = $pedidos_x_pagina*($pagina - 1);
        $aux = $this->Pedido_model->getListaPedidosPagina($pedidos_x_pagina, $reg_inicial);
        $ordenes = array();
        
        foreach($aux as $dato_orden)
        {
            $aux2 = array();
            $aux2['id_orden'] = $dato_orden->id_orden;
            $auxiliar = $dato_orden->id_orden;
            $aux2['codigo_orden'] = 10000 + $auxiliar;
            $aux2['id_cliente'] = $dato_orden->id_cliente;
            if($dato_orden->id_cliente ===0)
            {
                $nombre='No se tiene asignado un cliente';
            }
            else
            {
                $ax = $this->Pedido_model->getCliente($dato_orden->id_cliente);                
                $num_ax=count($ax);
                if($num_ax>0){
                    $nombre = $ax->nombre;  
                    $ruc = $ax->ruc;
                    $razon_social = $ax->razon_social;        
                }
                else
                {
                    $nombre='El cliente no existe en la Base de Datos';
                    $ruc = '---';
                    $razon_social = '---';
                }
            }
            $aux2['nombre_cliente'] = $nombre;
            $aux2['ruc_cliente'] = $ruc;
            $aux2['razon_social_cliente'] = $razon_social;
            $aux2['total'] = $dato_orden->total;
            $aux2['fecha_ingreso'] = dmYHora_2_Ymd($dato_orden->fecha_ingreso);
            $aux2['estado'] = $dato_orden->estado;
            // CODIGOS DE PRODUCTOS
            $aux_prods_1 = explode("~",$dato_orden->pedidos);
            $numero_productos = $aux_prods_1[0];
            $codigos_productos = array();
            for($i=1; $i<=$numero_productos; $i++)
            {
                $da1 = $aux_prods_1[$i];
                $da2 = explode("@",$da1);
                $codigoProducto = $da2[4];
                $codigos_productos[] = $codigoProducto;
            }
            $aux2['codigos_productos'] = implode("<br>", $codigos_productos); 
            $ordenes[] = $aux2;
        }
        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $pedidos_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_pedidos;
        $dataPrincipal['pagina'] = $pagina;
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
        
        //$dataPrincipal["resultados"] = $aux;
        //$this->load->view("mainpanel/vista_prueba", $dataPrincipal);
    }
    
    public function buscador() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/buscador_view";
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function detalle() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/detalle";
        // DETALLE DE ORDEN
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Pedido_model->getOrden($id_orden);
        $cliente = $this->Pedido_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;
	$dataup=array("estado"=>"Revisado");
        $this->Pedido_model->updateEstadoOrden($id_orden,$dataup);		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function search_pedidos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/busqueda_view";
        
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
        
        if($fecha_inicio<>'')
        {
            $fecha_inicio_s = dmY_2_Ymd(str_replace("/","-",$fecha_inicio));
        }
        else
        {
            $fecha_inicio_s = '';
        }
        if($fecha_fin<>'')
        {
            $fecha_fin_s = dmY_2_Ymd(str_replace("/","-",$fecha_fin));
        }
        else
        {
            $fecha_fin_s = '';
        } 
        // LISTA ORDENES
        $aux = $this->Pedido_model->doSearchPedidos($fecha_inicio_s, $fecha_fin_s);
        $ordenes = array();
        foreach($aux as $dato_orden)
        {
            $aux2 = array();
            $aux2['id_orden'] = $dato_orden->id_orden;
            $auxiliar = $dato_orden->id_orden;
            $aux2['codigo_orden'] = 10000 + $auxiliar;
            $aux2['id_cliente'] = $dato_orden->id_cliente;
            if($dato_orden->id_cliente ===0)
            {
                $nombre='No se tiene asignado un cliente';
            }
            else
            {
                $ax = $this->Pedido_model->getCliente($dato_orden->id_cliente);                
                $num_ax=count($ax);
                if($num_ax>0){
                    $nombre = $ax->nombre;  
                    $ruc = $ax->ruc;
                    $razon_social = $ax->razon_social;        
                }
                else
                {
                    $nombre='El cliente no existe en la Base de Datos';
                    $ruc = '---';
                    $razon_social = '---';
                }
            }
            $aux2['nombre_cliente'] = $nombre;
            $aux2['ruc_cliente'] = $ruc;
            $aux2['razon_social_cliente'] = $razon_social;
            $aux2['total'] = $dato_orden->total;
            $aux2['fecha_ingreso'] = dmYHora_2_Ymd($dato_orden->fecha_ingreso);
            $aux2['estado'] = $dato_orden->estado;
            // CODIGOS DE PRODUCTOS
            $aux_prods_1 = explode("~",$dato_orden->pedidos);
            $numero_productos = $aux_prods_1[0];
            $codigos_productos = array();
            for($i=1; $i<=$numero_productos; $i++)
            {
                $da1 = $aux_prods_1[$i];
                $da2 = explode("@",$da1);
                $codigoProducto = $da2[4];
                $codigos_productos[] = $codigoProducto;
            }
            $aux2['codigos_productos'] = implode("<br>", $codigos_productos); 
            $ordenes[] = $aux2;
        }
        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['fecha_inicio'] = $fecha_inicio;
        $dataPrincipal['fecha_fin'] = $fecha_fin;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
        //$dataPrincipal["resultados"] = $fecha_inicio;
        //$this->load->view("mainpanel/vista_prueba", $dataPrincipal);
    }
    
    public function impresion() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="pedidos/impresion";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Pedido_model->getOrden($id_orden);
        $cliente = $this->Pedido_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template_popup", $dataPrincipal);        
    }
	    
    public function delete() {
        $this->validacion->validacion_login();
        $id_orden = $this->uri->segment(4);
        $orden = $this->Pedido_model->getOrden($id_orden);
        $da=explode("~",$orden->pedidos);
        $num_ped=$da[0];
        for($i=1; $i<=$num_ped; $i++)
        {
            $current = explode("@",$da[$i]);
            $id_producto = $current[0];
            $cantidad = $current[1];
            if(isset($current[8]))
            {
                $id_color = $current[8];
                if(!empty($id_color))
                {
                    $aux_stock = $this->Pedido_model->stockProducto($id_producto, $id_color);
                    $stock_actual = $aux_stock->stock;
                    $nuevo_stock = $stock_actual + $cantidad;
                    $dataStock = array('stock'=>$nuevo_stock);
                    $this->Pedido_model->actualizaStock($id_producto, $id_color, $dataStock);
                }
            }
        }
        $this->Pedido_model->deletePedido($id_orden);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Pedido_model->getCliente($orden->id_cliente); 
        
        $encabezado_carro='style="padding:5px;text-align: center;color:#007dce;font-weight: bold;height: 31px;border: #EFEFEF solid 1px;background: #EBEBEB;"';
        $contenido_carro='color: #696767;border: solid 1px #C2C2C2;padding: 5px;';
        //creamos el carrito
        $car ='';
        $car .='<table width="100%" cellspacing="2">';
        $car .='<tr>';
        $car .='<td '.$encabezado_carro.' width="5%">N</td>';
        $car .='<td '.$encabezado_carro.' width="10%">C&oacute;digo</td>';
        $car .='<td '.$encabezado_carro.' width="25%">Producto</td>';
        $car .='<td '.$encabezado_carro.' width="10%">Color</td>';
        $car .='<td '.$encabezado_carro.' width="15%">Cod. Color</td>';
        $car .='<td '.$encabezado_carro.' width="10%">Cantidad</td>';
        $car .='<td '.$encabezado_carro.' width="10%">Precio</td>';
        $car .='<td '.$encabezado_carro.' width="15%">Subtotal</td>';
        $car .='</tr>';
        
        $total='';
        for($i=1; $i<=$num_ped; $i++)
        {
            $da1=$da[$i];
            $da2=explode("@",$da1);
            $cantidad= $da2[1];
            $codigo= $da2[4];
            $nombre= $da2[5];
            $color= $da2[2];
            $precio= $da2[3];
            $subtotal= $da2[6];                    
            $unid= $da2[7];
            if(!empty($da2[8]))
            {
                $id_color = $da2[8];
                $aux_nombre_color = $this->Pedido_model->nombreColor($id_color);
                $nombre_color = $aux_nombre_color->nombre;
            }
            else
            {
                $nombre_color = '--------';
            }
            $subTot = $precio*$cantidad;
            $subTot_2_show = number_format(($precio * $cantidad), 3, '.', '');
            $car .='<tr>';
            $car .='<td '.$contenido_carro.' align="center">'.$i.'</td>';
            $car .='<td '.$contenido_carro.'>'.$codigo.'</td>';
            $car .='<td '.$contenido_carro.' align="left">'.$nombre.'</td>';
            $car .='<td '.$contenido_carro.' align="center" style="background:'.$color.'"></td>';
            $car .='<td '.$contenido_carro.' align="center">'.$nombre_color.'</td>';
            $car .='<td '.$contenido_carro.' align="right">'.$cantidad.'</td>';
            $car .='<td '.$contenido_carro.' align="right">'.$precio.'</td>';
            $car .='<td '.$contenido_carro.' align="right">'.$subTot_2_show.'</td>';
            $car .='</tr>';
            $total = $total + $subTot;
        } // for $i
        $car .='<tr>';
        $car .='<td colspan="5" '.$contenido_carro.'>';
        $car .='</td>';
        $car .='<td '.$contenido_carro.'><strong>TOTAL</strong></td>';
        $car .='<td '.$contenido_carro.'><strong>S/. '.number_format($total, 2, '.', ',').'</strong></td>';
        $car .='</tr>';
        $car .='</table>';
        //****************  FIN DE CREACION DE CARRITO *******************
        $correo_notificaciones = getConfig('correo_notificaciones');
        $correo_notificaciones_alterno = getConfig('correo_notificaciones_alterno');
        //********** INFORMACION PARA CKI *************/
        $mail = new PHPMailer();
        $mail->From = $correo_notificaciones; // direccion de quien envia
        $mail->FromName = "CKI INTERNACIONAL";				
        $mail->AddAddress($correo_notificaciones);
        $mail->AddAddress($correo_notificaciones_alterno);
        $mail->AddAddress($datosCliente->email);
        $mail->AddBCC("erosadio@ajaxperu.com");
        $mail->Subject =  "Pedido Anulado #".($id_orden + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos del Pedido anulado:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE PEDIDO ANULADO<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>NUM PEDIDO: </b>".($id_orden + 10000)."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= $car;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";		
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();         

        redirect('mainpanel/pedidos/listado/success');
    }	

}
?>
