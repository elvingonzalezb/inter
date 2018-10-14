<?php
class Reservas extends CI_Controller {
    function __construct()
    {
            parent::__construct();
            $this->load->library('My_PHPMailer');
            $this->load->model('frontend/Inicio_model');
            $this->load->model('frontend/Reservas_model');  
            $this->load->library('Validacion');
    }

    function listado() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);
         
        // *********** LISTADO DE RESERVAS DEL CLIENTE ************
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $pagina = $this->uri->segment(3);
        $num_reservas = $this->Reservas_model->getNumReservas($id_cliente);
        $reservas_x_pagina = 20;
        $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
        $reg_inicial = $reservas_x_pagina*($pagina - 1);
        $ordenes = $this->Reservas_model->getListaReservasPagina($reservas_x_pagina, $reg_inicial, $id_cliente);
        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_reservas;
        $dataPrincipal['pagina'] = $pagina;
         
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'listado_reservas';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function detalle() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);
         
        // *********** DATOS DE LA RESERVA ************        
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
            $cargos = $this->Reservas_model->getListaCargos($id_reserva); 
            $dataPrincipal['cargos'] = $cargos;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'detalle_reserva';
        $this->load->view('frontend/includes/template', $dataPrincipal);
    }
    
    function impresion() {
        $this->validacion->validacion_login_frontend();          
        // *********** DATOS DE LA RESERVA ************        
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $cargos = $this->Reservas_model->getListaCargos($id_reserva);
            $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
            $dataPrincipal['cargos'] = $cargos;
            $cliente = $this->Reservas_model->getCliente($id_cliente);
            $dataPrincipal['cliente'] = $cliente;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'impresion_reserva';
        $this->load->view('frontend/impresion_reserva', $dataPrincipal);
    }
    
    function comprar() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);  
        
        // *********** DATOS DE LA RESERVA ************
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        
        $datosCliente = $this->Reservas_model->getCliente($id_owner); 
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $moneda = $orden->moneda;
            $dataPrincipal['moneda'] = $moneda;
            $total_reserva = totalReserva($id_reserva, $moneda);
            $dataPrincipal['total_reserva'] = $total_reserva;
            $dataPrincipal['id_reserva'] = $id_reserva;
            $dataPrincipal['datosCliente'] = $datosCliente;
            $cargos = $this->Reservas_model->getListaCargos($id_reserva); 
            $dataPrincipal['cargos'] = $cargos;
            $monto_cargos = 0;
            foreach($cargos as $cargo)
            {
                $concepto_current = $cargo->concepto;
                $monto_current = $cargo->monto;
                $monto_cargos += $monto_current;
            }
            $dataPrincipal['monto_cargos'] = $monto_cargos;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'compra_view';
        $this->load->view('frontend/includes/template', $dataPrincipal);        
        
    }
    
    function doCompra() {
        $this->validacion->validacion_login_frontend(); 
        
        $forma_pago = $this->input->post('forma_pago'); 
        $banco = $this->input->post('banco'); 
        $numero_operacion = $this->input->post('numero_operacion'); 
        $fecha_pago = $this->input->post('fecha_pago'); 
        $id_reserva = $this->input->post('id_reserva'); 
        $observaciones = $this->input->post('observaciones');
        
        $codigo_reserva = 10000+$id_reserva;
        $datos = array();
        $datos['forma_pago'] = $forma_pago;
        $datos['banco'] = $banco;
        $datos['numero_operacion'] = $numero_operacion;
        if($fecha_pago=="")
        {
            $datos['fecha_pago'] = '';
        }
        else
        {
            $datos['fecha_pago'] = dmY_2_Ymd($fecha_pago);
        }    
        $datosPago = array();
        $datosPago[] = '<strong>Forma de Pago:</strong> '.$forma_pago;
        //if( ($banco!=="") && ($banco!==0) && ($banco!=="0") )
        if($banco!=="0")    
        {
            $datosPago[] = '<strong>Banco:</strong> '.$banco;
        }
        if($numero_operacion!="")
        {
            $datosPago[] = '<strong>Num. Op.:</strong> '.$numero_operacion;
        }
        if($fecha_pago!="")
        {
            $datosPago[] = '<strong>Fecha Pago:</strong> '.$fecha_pago;
        }
        $datos_del_pago = implode(" - ", $datosPago);
        $datos['id_reserva'] = $id_reserva;
        $datos['codigo_reserva'] = $codigo_reserva;
        $datos['observaciones'] = $observaciones;
        
        $orden = $this->Reservas_model->getReserva($id_reserva);
        $datos['id_cliente'] = $orden->id_cliente;
        $datos['estado'] = 'Activa';
        $ahora = time();
        $fecha_ingreso = date('Y:m:d H:i:s', $ahora);
        $datos['fecha_ingreso'] = $fecha_ingreso;
        $datos['mensaje'] = $orden->mensaje;
        $datos['tipo_cambio_dolar'] = $orden->tipo_cambio_dolar;
        $datos['estado_pago'] = 'Pendiente';
        $moneda = $orden->moneda;
        $datos['moneda'] = $moneda;
        
        $cargos = $this->Reservas_model->getListaCargos($id_reserva);
        $listaCargos = array();        
        if(count($cargos)>0)
        {
            $datos['numero_cargos'] = count($cargos);
            $monto_cargos = 0;
            foreach($cargos as $cargo)
            {
                $concepto_current = $cargo->concepto;
                $monto_current = $cargo->monto;
                $listaCargos[] = $concepto_current."#".$monto_current;
                $monto_cargos += $monto_current;
            }
            $datos['monto_cargos'] = $monto_cargos;
            $datos['lista_cargos'] = implode("@", $listaCargos);
        } // if
        else
        {
            $datos['numero_cargos'] = 0;
            $datos['monto_cargos'] = 0;
            $datos['lista_cargos'] = '';
        }
        // GRABAMOS EN LA TABLA DE ORDENES (COMPRAS)
        $id_compra = $this->Reservas_model->guardarCompra($datos);
        
        // ACTUALIZAMOS EL ESTADO DE LA RESERVA A COMPRADO
        $data_x2 = array("estado"=>"Comprada");
        $this->Reservas_model->updateEstadoOrden($id_reserva, $data_x2);
        
        // GUARDAMOS EL DETALLE DE LA COMPRA
        $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
        foreach($detalles as $detalle)
        {
            $data = array();
            $data['id_compra'] = $id_compra;
            $data['id_producto'] = $detalle->id_producto;
            $data['codigo_producto'] = $detalle->codigo_producto;
            $data['nombre_producto'] = $detalle->nombre_producto;
            $data['cantidad'] = $detalle->cantidad;
            $data['unidad'] = $detalle->unidad;
            $data['precio_soles'] = $detalle->precio_soles;
            $data['precio_dolares'] = $detalle->precio_dolares;
            $data['id_color'] = $detalle->id_color;
            $data['codigo_color'] = $detalle->codigo_color;
            $data['nombre_color'] = $detalle->nombre_color;
            $this->Reservas_model->grabaDetalleCompra($data);
        }
        
        /******** ENVIAMOS NOTIFICACION DE LA COMPRA AL CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente);
        $carro = construyeCarro($id_reserva, $moneda);
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
        
        $nivel_cliente = $this->session->userdata('nivel');
        if($nivel_cliente=="vendedor")
        {
            $id_gerente = $this->session->userdata('id_padre');
            if($id_gerente>0)
            {
                $email_gerente = $this->Reservas_model->getEmailGerente($id_gerente);
                $mail->AddAddress($email_gerente);
            }                    
        }
        $mail->Subject =  "Datos de Compra #".($id_compra + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Compra:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE LA COMPRA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO COMPRA: </b>".($id_compra + 10000)."<br />\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_reserva + 10000)."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "<b>DATOS DEL PAGO: </b>".$datos_del_pago."<br />\n";
        if($observaciones!="")
        {
            $msg .= "===============================================================<br>\n";
            $msg .= " <b>OBSERVACIONES</b><br />\n";
            $msg .= "===============================================================<br>\n";
            $msg .= $observaciones."<br />\n";    
        }
        $msg .= "===============================================================<br />\n";
        $msg .= $carro;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";	
        $msg .= " INFORMACION DE PAGO<br />\n";
        $msg .= "===============================================================<br>\n";       
        $msg .= getConfig("cuentas_bancarias");               
        $msg .= "===============================================================<br>\n";

        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();         
        // REDIRECCION AL LISTADO CON MENSAJE DE EXITO DE EXTENSION
        redirect('compras/listado/1');        
    }
    
    function anular() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);  
        
        // *********** DATOS DE LA RESERVA ************
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        
        $datosCliente = $this->Reservas_model->getCliente($id_owner); 
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = 0;
        }
        else
        {
            $dataPrincipal['resultado'] = 1;
            $dataPrincipal['orden'] = $orden;
            $dataPrincipal['id_reserva'] = $id_reserva;
            $dataPrincipal['datosCliente'] = $datosCliente;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'anulacion_view';
        $this->load->view('frontend/includes/template', $dataPrincipal);        
        
    }
    
    function doAnulacion() {
        $this->validacion->validacion_login_frontend(); 
         
        $id_reserva = $this->input->post('id_reserva'); 
        $mensaje = $this->input->post('observaciones');
        
        $orden = $this->Reservas_model->getReserva($id_reserva);
        $tipo_reserva = $orden->tipo_reserva;
        $moneda = $orden->moneda;
        // ********* REPONEMOS EL STOCK DE LOS PRODUCTOS RESERVADOS **********
        $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
        foreach($detalles as $detalle)
        {
            $id_producto = $detalle->id_producto;
            $cantidad = $detalle->cantidad;
            $id_color = $detalle->id_color;
            $aux_stock = $this->Reservas_model->stockProducto($id_producto, $id_color);
            switch($tipo_reserva)
            {
                case "stock":
                    $stock_actual = $aux_stock->stock;
                    $nuevo_stock = $stock_actual + $cantidad;
                    $dataStock = array('stock'=>$nuevo_stock);
                break;

                case "proximamente":
                    $stock_actual = $aux_stock->stock_proximamente;
                    $nuevo_stock = $stock_actual + $cantidad;
                    $dataStock = array('stock_proximamente'=>$nuevo_stock);
                break;
            }                    
            $this->Reservas_model->actualizaStock($id_producto, $id_color, $dataStock);
        }
        // ****** CAMBIAMOS EL ESTADO A ANULADA **********
        $dataup = array("estado"=>"Anulada");
        $this->Reservas_model->updateEstadoOrden($id_reserva, $dataup);
        // ******* GUARDAMOS DATOS DE LA ANULACION *********
        $ahora = time();
        $fecha_anulacion = date('Y-m-d H:i:s', $ahora);
        $fecha_anulacion_2show = date('d-m-Y H:i:s', $ahora);
        $data_anulacion = array("id_reserva"=>$id_reserva, "mensaje"=>$mensaje, "fecha_anulacion"=>$fecha_anulacion);
        $this->Reservas_model->guardarAnulacion($data_anulacion);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente); 
        $carro = construyeCarro($id_reserva, $moneda);
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
        //$mail->AddBCC("erosadio@ajaxperu.com");
        
        $nivel_cliente = $this->session->userdata('nivel');
        if($nivel_cliente=="vendedor")
        {
            $id_gerente = $this->session->userdata('id_padre');
            if($id_gerente>0)
            {
                $email_gerente = $this->Reservas_model->getEmailGerente($id_gerente);
                $mail->AddAddress($email_gerente);
            }                    
        }
        $mail->Subject =  "Reserva Anulada #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Reserva anulada:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE RESERVA ANULADA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_reserva + 10000)."<br />\n";
        $msg .= "<b>FECHA/HORA ANULACION: </b>".$fecha_anulacion_2show."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " MENSAJE ACERCA DE LA ANULACION<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= $mensaje."<br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= $carro;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";		
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();  
        // REDIRECCION AL LISTADO
        redirect('reservas/listado/1'); 
    }
    
    function compraMultiple() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);  
        
        // *********** DATOS DE LA RESERVA ************
        $moneda = $this->session->userdata('moneda');
        $id_reservas = $this->input->post('elegidos');
        $aux_ids = explode("##", $id_reservas);
        $codigos = array();
        $resultado = 1;
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $montoTotalReservas = 0;
        for($i=0; $i<count($aux_ids); $i++)
        {
            $id_current = $aux_ids[$i];
            $current = $this->Reservas_model->getReserva($id_current);
            $id_owner = $current->id_cliente;
            if($id_cliente!=$id_owner)
            {
                $resultado = 0;
            }
            $idOrden = $current->id_orden;
            $codigos[] = 10000 + $idOrden;
            $cargos = $this->Reservas_model->getListaCargos($id_current);
            $monto_cargos = 0;
            foreach($cargos as $cargo)
            {
                $concepto_current = $cargo->concepto;
                $monto_current = $cargo->monto;
                $monto_cargos += $monto_current;
            }
            $total_current = totalReserva($id_current, $moneda);
            $montoTotalReservas += $total_current + $monto_cargos;
            
        }
        $dataPrincipal['moneda'] = $moneda;
        $dataPrincipal['monto_total'] = $montoTotalReservas;
        $dataPrincipal['ids_reservas'] = $id_reservas;
        $dataPrincipal['resultado'] = $resultado;
        $dataPrincipal['codigos'] = implode(" / ", $codigos);
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'compra_multiple_view';
        $this->load->view('frontend/includes/template', $dataPrincipal);        
        
    }
    
    function doCompraMultiple() {
        $this->validacion->validacion_login_frontend(); 
        
        $forma_pago = $this->input->post('forma_pago'); 
        $banco = $this->input->post('banco'); 
        $numero_operacion = $this->input->post('numero_operacion'); 
        $fecha_pago_dmy = $this->input->post('fecha_pago');
        if($fecha_pago_dmy=="")
        {
            $fecha_pago = '';
        }
        else
        {
            $fecha_pago = dmY_2_Ymd($fecha_pago_dmy);
        }
        $observaciones = $this->input->post('observaciones');
        $datosPago = array();
        $datosPago[] = '<strong>Forma de Pago:</strong> '.$forma_pago;
        if($banco!=="0")    
        {
            $datosPago[] = '<strong>Banco:</strong> '.$banco;
        }
        if($numero_operacion!="")
        {
            $datosPago[] = '<strong>Num. Op.:</strong> '.$numero_operacion;
        }
        if($fecha_pago!="")
        {
            $datosPago[] = '<strong>Fecha Pago:</strong> '.$fecha_pago_dmy;
        }
        $datos_del_pago = implode(" - ", $datosPago);
        
        
        $aux_id_reserva = $this->input->post('id_reserva');
        $ids_reservas = explode("##", $aux_id_reserva);
        for($j=0; $j<count($ids_reservas); $j++)
        {
            $id_reserva = $ids_reservas[$j];
            $codigo_reserva = 10000 + $id_reserva;
            $datos = array();
            $datos['forma_pago'] = $forma_pago;
            $datos['banco'] = $banco;
            $datos['numero_operacion'] = $numero_operacion;
            $datos['fecha_pago'] = $fecha_pago;
            $datos['id_reserva'] = $id_reserva;
            $datos['codigo_reserva'] = $codigo_reserva;
            $datos['observaciones'] = $observaciones;

            $orden = $this->Reservas_model->getReserva($id_reserva);
            $datos['id_cliente'] = $orden->id_cliente;
            $datos['estado'] = 'Activa';
            $moneda = $orden->moneda;
            $datos['moneda'] = $moneda;
            
            $cargos = $this->Reservas_model->getListaCargos($id_reserva);
            $listaCargos = array();        
            if(count($cargos)>0)
            {
                $datos['numero_cargos'] = count($cargos);
                $monto_cargos = 0;
                foreach($cargos as $cargo)
                {
                    $concepto_current = $cargo->concepto;
                    $monto_current = $cargo->monto;
                    $listaCargos[] = $concepto_current."#".$monto_current;
                    $monto_cargos += $monto_current;
                }
                $datos['monto_cargos'] = $monto_cargos;
                $datos['lista_cargos'] = implode("@", $listaCargos);
            } // if
            else
            {
                $datos['numero_cargos'] = 0;
                $datos['monto_cargos'] = 0;
                $datos['lista_cargos'] = '';
            }
        
            $ahora = time();
            $fecha_ingreso = date('Y:m:d H:i:s', $ahora);
            $datos['fecha_ingreso'] = $fecha_ingreso;
            $datos['mensaje'] = $orden->mensaje;
            $datos['tipo_cambio_dolar'] = $orden->tipo_cambio_dolar;
            
            // GRABAMOS EN LA TABLA DE COMPRAS
            $id_compra = $this->Reservas_model->guardarCompra($datos);

            // ACTUALIZAMOS EL ESTADO DE LA RESERVA A COMPRADO
            $data_x2 = array("estado"=>"Comprada");
            $this->Reservas_model->updateEstadoReserva($id_reserva, $data_x2);
            
            // GUARDAMOS EL DETALLE DE LA COMPRA
            $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
            foreach($detalles as $detalle)
            {
                $data = array();
                $data['id_compra'] = $id_compra;
                $data['id_producto'] = $detalle->id_producto;
                $data['codigo_producto'] = $detalle->codigo_producto;
                $data['nombre_producto'] = $detalle->nombre_producto;
                $data['cantidad'] = $detalle->cantidad;
                $data['unidad'] = $detalle->unidad;
                $data['precio_soles'] = $detalle->precio_soles;
                $data['precio_dolares'] = $detalle->precio_dolares;
                $data['id_color'] = $detalle->id_color;
                $data['codigo_color'] = $detalle->codigo_color;
                $data['nombre_color'] = $detalle->nombre_color;
                $this->Reservas_model->grabaDetalleCompra($data);
            }

            // ENVIAMOS EL CORREO CON LOS DATOS DE LA COMPRA
            $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente);
            $carro = construyeCarro($id_reserva, $moneda);
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
            $nivel_cliente = $this->session->userdata('nivel');
            if($nivel_cliente=="vendedor")
            {
                $id_gerente = $this->session->userdata('id_padre');
                if($id_gerente>0)
                {
                    $email_gerente = $this->Reservas_model->getEmailGerente($id_gerente);
                    $mail->AddAddress($email_gerente);
                }                    
            }
            $mail->Subject =  "Datos de Compra #".($id_compra + 10000)." por ".$datosCliente->razon_social; 
            $msg = "Aqui le mostramos los datos de la Compra:<br /><br />\n";
            $msg .= "===============================================================<br>\n";
            $msg .= " INFORMACION DE LA COMPRA<br />\n";
            $msg .= "===============================================================<br>\n";
            $msg .= "<b>CODIGO COMPRA: </b>".($id_compra + 10000)."<br />\n";
            $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
            $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
            $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
            $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
            $msg .= "<b>DATOS DEL PAGO: </b>".$datos_del_pago."<br />\n";
            $msg .= "===============================================================<br />\n";
            $msg .= $carro;
            $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
            $msg .= "===============================================================<br />\n";	
            $msg .= " INFORMACION DE PAGO<br />\n";
            $msg .= "===============================================================<br>\n";       
            $msg .= getConfig("cuentas_bancarias");               
            $msg .= "===============================================================<br>\n";	
            $mail->Body = $msg;
            $mail->IsHTML(true);
            @$mail->Send();  
        } // for
        // REDIRECCION AL LISTADO CON MENSAJE DE EXITO DE EXTENSION
        redirect('compras/listado/1');          
    }
    
    function modificar() {
        $this->validacion->validacion_login_frontend(); 
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
        $data['seccion'] = 'reservas';            
        $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
        $this->load->view('frontend/includes/header', $data, true);
        $this->load->view('frontend/includes/footer', $data, true);
         
        // *********** DATOS DE LA RESERVA ************        
        $id_reserva = $this->uri->segment(3);
        $orden= $this->Reservas_model->getReserva($id_reserva);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $id_owner = $orden->id_cliente;
        if($id_cliente!=$id_owner)
        {
            // La reserva le pertenece a otro cliente, choteamos
            $dataPrincipal['resultado'] = "error-propietario";
        }
        else
        {
            $aux_resultado = $this->uri->segment(4);
            if($aux_resultado!="")
            {
                $dataPrincipal['resultado'] = $aux_resultado;
            }
            else
            {
                $dataPrincipal['resultado'] = 1;
            }
            $dataPrincipal['orden'] = $orden;
            $detalles = $this->Reservas_model->getListaDetalles($id_reserva);
            $dataPrincipal['detalles'] = $detalles;
            $cargos = $this->Reservas_model->getListaCargos($id_reserva); 
            $dataPrincipal['cargos'] = $cargos;
        }
        // ****** LLAMAMOS AL CUERPO *********
        $dataPrincipal['cuerpo'] = 'modificar_reserva';
        $this->load->view('frontend/includes/template', $dataPrincipal);        
    }
    
    function actualizaReserva() {
        $num_items = $this->input->post('num_items'); 
        $id_reserva = $this->input->post('id_reserva');
        $reserva = $this->Reservas_model->getReserva($id_reserva);
        $moneda = $reserva->moneda;
        $pedido = array();
        $contador = 0;
        $totalReserva = 0;
        $tipo_reserva = $reserva->tipo_reserva;
        for($i=0; $i<$num_items; $i++)
        {
            $id_detalle = $this->input->post('id_detalle_'.$i); // id de la tabla reservas_detalle
            $id_current = $this->input->post('id_'.$i); // id de la tabla stock_color
            $cantidad_nueva = $this->input->post('cant_'.$i);
            $stock = $this->input->post('stock_'.$i);
            $cantidad_actual = $this->input->post('cant_actual_'.$i);
            $id_producto = $this->input->post('id_producto_'.$i);
            $color = $this->input->post('color_'.$i);
            $precio = $this->input->post('precio_'.$i);
            $codigo = $this->input->post('codigo_'.$i);
            $nombre = $this->input->post('nombre_'.$i);
            $subtot = $this->input->post('subtot_'.$i);
            $uni = $this->input->post('uni_'.$i);
            $id_color = $this->input->post('id_color_'.$i);
            
            switch($tipo_reserva)
            {
                case "stock":
                    $aux_stock_actual = $this->Reservas_model->stockXId($id_current);
                break;

                case "proximamente":
                   $aux_stock_actual = $this->Reservas_model->stockXId_prox($id_current);
                break;
            }
            //$stock_actual = $aux_stock_actual->stock;
            $stock_actual = $aux_stock_actual;
            $variacion = $cantidad_nueva - $cantidad_actual; 
            $numeroItems = 0;          
            
            if($cantidad_nueva==0)
            {
                // Este item se quito de la reserva
                $this->Reservas_model->eliminaDetalleReserva($id_detalle);
                
                // Devolvemos el producto al stock
                $aux_stock = $this->Reservas_model->stockProducto($id_producto, $id_color);
                switch($tipo_reserva)
                {
                    case "stock":
                        $stock_actual = $aux_stock->stock;
                    break;

                    case "proximamente":
                       $stock_actual = $aux_stock->stock_proximamente;
                    break;
                }
                $nuevo_stock = $stock_actual + $cantidad_actual;

                switch($tipo_reserva)
                {
                    case "stock":
                        $dataStock = array('stock'=>$nuevo_stock);
                    break;

                    case "proximamente":
                       $dataStock = array('stock_proximamente'=>$nuevo_stock);
                    break;
                }
                $this->Reservas_model->actualizaStock($id_producto, $id_color, $dataStock);
            }
            else
            {
                $subtot = $cantidad_nueva*$precio;
                $totalReserva = $totalReserva + $subtot;
                $contador++;
                if($variacion==0)
                {
                    $tipo_variacion = 'nada';
                }
                else if($variacion>0)
                {
                    // Se ha agregado unidades de este item
                    // Verificamos si hay stock suficiente
                    if($variacion>$stock_actual)
                    {
                        // Se esta aumentando una cantidad de este item que supera el stock actual
                        // No pasa esta actualizacion de la reserva
                        redirect('reservas/modificar/'.$id_reserva.'/error-stock');
                    }
                    else
                    {
                        // Hay stock, agregamos el item a la reserva
                        $tipo_variacion = 'aumento';
                    }
                }
                else
                {
                    // Se han disminuido unidades de este item
                    $tipo_variacion = 'disminucion';
                    $variacion = $variacion*(-1);
                }
                $aux_stock = $this->Reservas_model->stockProducto($id_producto, $id_color);
                switch($tipo_reserva)
                {
                    case "stock":
                        $stock_actual = $aux_stock->stock;
                    break;

                    case "proximamente":
                       $stock_actual = $aux_stock->stock_proximamente;
                    break;
                }
                // ***** MODIFICAMOS EL STOCK SI CORRESPONDE *******
                switch($tipo_variacion)
                {
                    case "nada":
                        $nuevo_stock = $stock_actual;
                    break;

                    case "aumento":
                        // Si la cantidad pedida aumento entonces el stock tiene q disminuir
                        $nuevo_stock = $stock_actual - $variacion;
                    break;

                    case "disminucion":
                        // Si la cantidad pedida disminuyo, el stock tiene que aumentar
                        $nuevo_stock = $stock_actual + $variacion;
                    break;
                } // switch

                switch($tipo_reserva)
                {
                    case "stock":
                        $dataStock = array('stock'=>$nuevo_stock);
                    break;

                    case "proximamente":
                       $dataStock = array('stock_proximamente'=>$nuevo_stock);
                    break;
                }
                $this->Reservas_model->actualizaStock($id_producto, $id_color, $dataStock);
                // ACTUALIZAMOS ESTE REGISTRO DE LA TABLA reservas_detalle
                $dataDetalle = array('cantidad'=>$cantidad_nueva);
                $this->Reservas_model->updateDetalleReserva($id_detalle, $dataDetalle);
            } // else
        } // for

        $carro = construyeCarro($id_reserva, $moneda);
        $id_cliente = $this->session->userdata('id_cliente_logueado');
        $datosCliente = $this->Reservas_model->getCliente($id_cliente);
        //**************  FIN DE CREACION DE CARRITO *********************
        $correo_notificaciones = getConfig('correo_notificaciones');
        $correo_notificaciones_alterno = getConfig('correo_notificaciones_alterno');
        // ************* CORREO PARA LA ADMINISTRACION ****************		
        $mail = new PHPMailer();
        $mail->From = $correo_notificaciones;
        $mail->FromName = "CKI INTERNACIONAL";				
        $mail->AddAddress($correo_notificaciones);
        $mail->AddAddress($correo_notificaciones_alterno);
        //$mail->AddBCC("erosadio@ajaxperu.com");
        $mail->Subject =  "Reserva modificada #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
        $msg = "El cliente acaba de modificar el contenido de su reserva.<br />\n";
        $msg .= "Le mostramos a continuacionlos datos de la reserva modificada<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE LA RESERVA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>NUM RESERVA: </b>".($id_reserva + 10000)."<br />\n";
        $msg .= "<b>CADUCIDAD DE LA RESERVA: </b>".$reserva->caducidad."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= $carro;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";		
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();  

        //********** INFORMACION DE RESERVA PARA EL CLIENTE *************/
        $mail2 = new PHPMailer();
        $mail2->From = $correo_notificaciones;
        $mail2->FromName = "CKI INTERNACIONAL";
        $mail2->AddAddress($this->session->userdata('email'));
        //$mail->AddBCC("l14307@hotmail.com");
        $nivel_cliente = $this->session->userdata('nivel');
        if($nivel_cliente=="vendedor")
        {
            $id_gerente = $this->session->userdata('id_padre');
            if($id_gerente>0)
            {
                $email_gerente = $this->Reservas_model->getEmailGerente($id_gerente);
                $mail2->AddAddress($email_gerente);
            }                    
        }
        $mail2->Subject =  "Reserva modificada #".($id_reserva + 10000)." por ".$datosCliente->razon_social;
        $msg2 = "Acaba de modificar el contenido de su reserva.<br />\n";
        $msg2 .= "Le mostramos a continuacion los datos de la reserva modificada<br /><br />\n";
        $msg2 .= "===============================================================<br>\n";
        $msg2 .= " INFORMACION DE LA RESERVA<br />\n";
        $msg2 .= "===============================================================<br>\n";
        $msg2 .= "<b>NUM RESERVA:</b> ".($id_reserva + 10000)."<br>\n";
        $msg2 .= "<b>CADUCIDAD DE SU RESERVA: </b>".$reserva->caducidad."<br />\n";
        $msg2 .= "<b>RAZON SOCIAL:</b> ".$datosCliente->razon_social."<br>\n";
        $msg2 .= "<b>RUC:</b> ".$datosCliente->ruc."<br>\n";
        $msg2 .= "<b>PERSONA DE CONTACTO:</b> ".$datosCliente->nombre."<br>\n";
        $msg2 .= "<b>EMAIL:</b> ".$datosCliente->email."<br>\n";
        $msg2 .= "===============================================================<br />\n";
        $msg2 .= $carro;
        $msg2 .= "===============================================================<br>\n";		                
        $mail2->Body = $msg2;
        $mail2->IsHTML(true);
        @$mail2->Send();
        $result = 'reserva-enviada';  
        redirect('reservas/listado/1');
    }
    
    function prueba() {
        $this->Reservas_model->limpiaTablas();
        $dataPrincipal = array();
        $dataPrincipal['mensaje'] = 'Tablas limpiadas';
        $this->load->view('frontend/vista_prueba', $dataPrincipal);
    }
    
}
?>
