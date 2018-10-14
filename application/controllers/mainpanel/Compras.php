<?php
class Compras extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Compras_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
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
        $dataPrincipal["cuerpo"]="compras/index_view";
        
        // LISTA COMPRAS
       /* $pagina = $this->uri->segment(4);
        $num_reservas = $this->Compras_model->getNumCompras('Activa');
        $reservas_x_pagina = 20;
        $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
        $reg_inicial = $reservas_x_pagina*($pagina - 1);
        //$ordenes = $this->Compras_model->getListaComprasPagina($reservas_x_pagina, $reg_inicial);
        
        $hace_6_meses = date('Y-m-d', strtotime('-1 month'));
        //$ordenes = $this->Compras_model->getListaCompras();
        $ordenes = $this->Compras_model->getListaComprasUlt6meses($hace_6_meses);

        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_reservas;
        $dataPrincipal['pagina'] = $pagina;*/
        $dataPrincipal['tiempo'] = 1;
        $dataPrincipal['tipo_listado'] = 1;
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function ajaxListaCompras()
    {
        //$id_subcategoria = $this->uri->segment(4);
        $param = $this->uri->segment(4);
        switch ($param) {
            case '1':
                $tiempo = date('Y-m-d', strtotime('-1 month'));
                break;
            case '2':
                $tiempo = date('Y-m-d', strtotime('-3 month'));
                break;
            case '3':
                $tiempo = date('Y-m-d', strtotime('-6 month'));
                break;
            default:
                $tiempo = '2000-01-01 00:00:00';
                break;
        }
        
        $requestData= $_REQUEST;

        $columns = array( 0 => 'c.fecha_ingreso', 1=> 'c.id_orden', 2 => 'i.razon_social');

        $totalData = $this->Datatable->numCompras($tiempo);
        $totalFiltered = $totalData;

        $where = "1=1";
        $where2 = "";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( c.fecha_ingreso LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR c.id_orden LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR d.codigo_producto LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR i.razon_social LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR i.nombre LIKE '%".$requestData['search']['value']."%' )";
        }
        $where2=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchCompras($tiempo, $where, $where2);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            $nestedData[] = $key+1;
            $nestedData[] = 10000 + $value['id_orden'];
            $nestedData[] = $value['codigo_reserva'];
            $nestedData[] = $value['cliente'];
            $nestedData[] = $value['codigo_producto'];
            $moneda = $value['moneda'];
            switch($moneda){
                case "d":
                    $simbolo = 'US$';
                    $tipo_cambio = getConfig("tipo_cambio_dolar");
                break;

                case "s":
                    $simbolo = 'S/';
                    $tipo_cambio = 1;
                break;
            }
            $total = totalCompra($value['id_orden'], $moneda);

            $lista_cargos = explode("@", $value['lista_cargos']);
            $monto_cargos = 0;
            for($j=0; $j<count($lista_cargos); $j++){
                $monto_cargos += $lista_cargos[$j];
            }
            if(count($lista_cargos)>0){
                $total = $total + $monto_cargos;
            }
            $nestedData[] = $simbolo.' '.$total;
            $forma_pago = $value['forma_pago'];
            $banco = $value['banco'];
            $numero_operacion = $value['numero_operacion'];
            $fecha_pago = Ymd_2_dmY($value['fecha_pago']);
            $estado_pago = $value['estado_pago'];
            switch($estado_pago){
                case "Pendiente":
                    $estatusPago = '<span class="pagoPendiente">PENDIENTE</span><br>';
                break;
                        
                case "Pagado":
                    $estatusPago = '<span class="pagoPagado">PAGADO</span><br>';
                break;
                        
                case "Vencido":
                    $estatusPago = '<span class="pagoVencido">VENCIDO</span><br>';
                break;
            }
                        
            if($forma_pago==""){
                $datos_pago = '------';
            }else{
                $datos_pago = $estatusPago.'<br>';
                switch($forma_pago){
                    case "transferencia":
                    case "deposito":
                        $datos_pago .= '<strong>Forma de Pago: </strong>'.strtoupper($forma_pago).'<br>';
                        $datos_pago .= '<strong>Banco: </strong>'.$banco.'<br>';
                        $datos_pago .= '<strong>Num. Op.: </strong>'.$numero_operacion.'<br>';
                        $datos_pago .= '<strong>Fecha Pago: </strong>'.$fecha_pago;
                    break;

                    case "credito":
                    case "efectivo":
                        $datos_pago .= '<strong>Forma de Pago: </strong>'.$forma_pago;
                    break;

                    default:
                        $datos_pago .= '-------';
                    break;
                }//switch
            }

            $nestedData[] = $datos_pago;
            $nestedData[] = YmdHora_2_dmY($value['fecha_ingreso']); 
            $nestedData[] = '<a class="btn btn-info" href="mainpanel/compras/detalle/'.$value['id_orden'].'"><i class="icon-edit icon-white"></i> DETALLE</a><br /><br />
                            <a class="btn btn-danger" href="javascript:anularCompra(\''.$value['id_orden'].'\')"><i class="icon-trash icon-white"></i> ANULAR</a><br /><br />
                            <a class="btn btn-success" href="mainpanel/compras/editarPago/'.$value['id_orden'].'"><i class="icon-edit icon-white"></i> EDITAR PAGO</a>';
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

    public function listado3meses() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="compras/index_view";
        
        // LISTA COMPRAS
        /*$pagina = $this->uri->segment(4);
        $num_reservas = $this->Compras_model->getNumCompras('Activa');
        $reservas_x_pagina = 20;
        $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
        $reg_inicial = $reservas_x_pagina*($pagina - 1);
        //$ordenes = $this->Compras_model->getListaComprasPagina($reservas_x_pagina, $reg_inicial);

        $hace_6_meses = date('Y-m-d', strtotime('-3 month')) ;
        //$ordenes = $this->Compras_model->getListaCompras();
        $ordenes = $this->Compras_model->getListaComprasUlt6meses($hace_6_meses);

        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_reservas;
        $dataPrincipal['pagina'] = $pagina;*/
        $dataPrincipal['tiempo'] = 2;
        $dataPrincipal['tipo_listado'] = 3;
        
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function listado6meses() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="compras/index_view";
        
        // LISTA COMPRAS
        /*$pagina = $this->uri->segment(4);
        $num_reservas = $this->Compras_model->getNumCompras('Activa');
        $reservas_x_pagina = 20;
        $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
        $reg_inicial = $reservas_x_pagina*($pagina - 1);
        //$ordenes = $this->Compras_model->getListaComprasPagina($reservas_x_pagina, $reg_inicial);

        $hace_6_meses = date('Y-m-d', strtotime('-6 month')) ;
        //$ordenes = $this->Compras_model->getListaCompras();
        $ordenes = $this->Compras_model->getListaComprasUlt6meses($hace_6_meses);

        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_reservas;
        $dataPrincipal['pagina'] = $pagina;*/
        $dataPrincipal['tiempo'] = 3;
        $dataPrincipal['tipo_listado'] = 6;
        
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function listado_todas() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="compras/index_view";
        
        // LISTA COMPRAS
        /*$pagina = $this->uri->segment(4);
        $num_reservas = $this->Compras_model->getNumCompras('Activa');
        $reservas_x_pagina = 20;
        $num_paginas = numeroPaginas($num_reservas, $reservas_x_pagina);
        $reg_inicial = $reservas_x_pagina*($pagina - 1);
        //$ordenes = $this->Compras_model->getListaComprasPagina($reservas_x_pagina, $reg_inicial);

        $ordenes = $this->Compras_model->getListaCompras();*/
        $dataPrincipal['tiempo'] = 0;
        /*$dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $reservas_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_reservas;
        $dataPrincipal['pagina'] = $pagina;*/
        $dataPrincipal['tipo_listado'] = 0;
        
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
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
        $dataPrincipal["cuerpo"]="compras/detalle";
        // DETALLE DE COMPRA
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Compras_model->getCompra($id_orden);
        $cliente = $this->Compras_model->getCliente($orden->id_cliente); 
        if(count($cliente)>0)
        {
            $dataPrincipal['existe_cliente'] = 'si';
            $dataPrincipal['cliente'] = $cliente;
        }
        else
        {
            $dataPrincipal['existe_cliente'] = 'no';
            $dataPrincipal['cliente'] = '';
        }
        $dataPrincipal['orden'] = $orden;
        $detalles = $this->Compras_model->getListaDetalles($id_orden);
        $dataPrincipal['detalles'] = $detalles;
        $dataPrincipal["resultado"] = $resultado;
	   //$dataup=array("estado"=>"Revisado");
        //$this->Compras_model->updateEstadoOrden($id_orden,$dataup);		
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
        $aux = $this->Compras_model->doSearchPedidos($fecha_inicio_s, $fecha_fin_s);
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
                $ax = $this->Compras_model->getCliente($dato_orden->id_cliente);                
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
        $orden= $this->Compras_model->getOrden($id_orden);
        $cliente = $this->Compras_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template_popup", $dataPrincipal);        
    }
	
    public function anular() {
        $this->validacion->validacion_login();
        $id_orden = $this->uri->segment(4);
        $orden = $this->Compras_model->getCompra($id_orden);
        
        /********** REACTIVAMOS LA RESERVA ***********/
        $id_reserva = $orden->id_reserva;
        $reserva = $this->Compras_model->getReserva($id_reserva);
        $moneda = $reserva->moneda;
        $ahora = time();
        $horas_adicionales = 72;
        $segundos_adicionales = $horas_adicionales*3600;
        $nuevo_time = $ahora + $segundos_adicionales;
        $nueva_caducidad = date('Y-m-d H:i:s', $nuevo_time);
        $nueva_caducidad_2_show = date('d-m-Y H:i', $nuevo_time);
        $dataUp = array("estado"=>"Activa", "caducidad"=>$nueva_caducidad);
        $this->Compras_model->updateReserva($id_reserva, $dataUp);
        /********** BORRAMOS LA COMPRA ***********/
        $this->Compras_model->deleteCompra($id_orden);
        $this->Compras_model->deleteDetallesCompra($id_orden);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Compras_model->getCliente($orden->id_cliente); 
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
        $mail->Subject =  "Compra Anulada #".($id_orden + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Compra anulada:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE LA COMPRA ANULADA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>NUM COMPRA: </b>".($id_orden + 10000)."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " NUEVA CADUCIDAD DE LA RESERVA REACTIVADA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>NUM RESERVA: </b>".($id_reserva + 10000)."<br />\n";
        $msg .= "<b>NUEVA CADUCIDAD: </b>".$nueva_caducidad_2_show."<br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= " PRODUCTOS<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= $carro;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";		
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();         

        redirect('mainpanel/compras/listado/1/success');
    }
    
    public function editarPago() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="compras/editar_pago";
        // DETALLE DE ORDEN
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Compras_model->getCompra($id_orden);
        $cliente = $this->Compras_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function actualizarPago() {
        $this->validacion->validacion_login();
        // EDITAR PAGO
        $data = array();
        $id_compra = $this->input->post('id');
        $data['forma_pago'] = $this->input->post('forma_pago');
        $data['banco'] = $this->input->post('banco');
        $data['numero_operacion'] = $this->input->post('numero_operacion');
        $data['fecha_pago'] = dmY_2_Ymd($this->input->post('fecha_pago'));
        $data['observaciones'] = $this->input->post('observaciones');
        $data['estado_pago'] = $this->input->post('estado_pago');
        
        $this->Compras_model->updatePago($id_compra, $data);
        redirect('mainpanel/compras/editarPago/'.$id_compra.'/success');
    }

}
?>
