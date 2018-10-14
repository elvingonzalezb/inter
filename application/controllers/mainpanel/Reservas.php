<?php
class Reservas extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Reservas_model');
        $this->load->model('mainpanel/Ajax_datatable_model','Datatable');
        $this->load->library('My_upload');
        $this->load->library('My_PHPMailer');
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function listadoActivas() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/index_view";
        
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }

    public function ajaxListaReservasActivas()
    {
        //$estado = $this->uri->segment(4);
        $estado = 'Activa';
        $requestData= $_REQUEST;

        $columns = array( 0 => 'i.nombre', 1 => 'i.razon_social');

        $totalData = $this->Datatable->numReservas($estado);
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( i.nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR i.razon_social LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchReservas($estado, $where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchReservas($estado, $where);

        $data = array();
        foreach ($query as $key => $value) {
            $nestedData=array();
            switch($value['moneda'])
            {
                case "d":
                    $simbolo = 'US$';
                break;
                        
                case "s":
                    $simbolo = 'S/';
                break;
            }
            $nestedData[] = $key+1;
            $nestedData[] = 10000 + $value['id_orden'];
            $nestedData[] = '<strong>'.$value['razonsocial'].'</strong><br>Persona contacto: '.$value['nombrecliente'];
            $nestedData[] =  codigosProductosReserva($value['id_orden']); 
            $nestedData[] = $simbolo.' '.totalReserva($value['id_orden'], $value['moneda']);
            $nestedData[] = $value['estado'];
            
            $aux_hc = explode(" ", $value['caducidad']);
            $aux_hc_2 = explode("-", $aux_hc[0]);
            $aux_hc_3 = explode(":", $aux_hc[1]);
            $time_caducidad = mktime($aux_hc_3[0], $aux_hc_3[1], $aux_hc_3[2], $aux_hc_2[1], $aux_hc_2[2], $aux_hc_2[0]);
            $ahora = time();
            $diferencia = conversorSegundosHoras($time_caducidad - $ahora);

            $vigencia = '<strong>Ingreso:</strong><br>'.formatoFechaHora($value['fecha_ingreso']).'<br><br>';
            $vigencia .= '<strong>Caducidad:</strong><br>'.formatoFechaHora($value['caducidad']).'<br><br>';
            $vigencia .= $diferencia;
            $nestedData[] = $vigencia;
            switch($value['lleva_cargos']){
                case 0:
                    $lleva_cargos = 'NO';
                break;
                            
                case 1:
                    $lleva_cargos = 'SI';
                break;
                            
                case 2:
                    $lleva_cargos = 'A VECES';
                break;
            }
            $nestedData[] = $lleva_cargos;
            $nestedData[] = ($value['tiene_cargos']==1)?'SI':'NO';

            //$nestedData[] = ($value['estado']=="A")? '<span class="label label-success">ACTIVO</span>':'<span class="label label-important">INACTIVO</span>';
            $acciones = '<a class="btn btn-info" href="mainpanel/reservas/detalle/'.$value['id_orden'].'"><i class="icon-edit icon-white"></i> DETALLE</a><br /><br />
                        <a class="btn btn-info" href="javascript:printReserva(\''.$value['id_orden'].'\', \'800\', \'600\')"><i class="icon-edit icon-white"></i> IMPRIMIR</a><br /><br />
                        <a class="btn btn-danger" href="javascript:anularReserva(\''.$value['id_orden'].'\')"><i class="icon-trash icon-white"></i> &nbsp;&nbsp;ANULAR</a><br /><br />
                        <a class="btn btn-success" href="javascript:extenderReserva(\''.$value['id_orden'].'\', \'800\', \'600\')"><i class="icon-edit icon-white"></i> EXTENDER</a><br /><br />';
            if( ($value['lleva_cargos']>0) ){
                switch($value['tiene_cargos']){
                    case 0:
                    $acciones .= '<a class="btn btn-info" href="mainpanel/reservas/cargos/'.$value['id_orden'].'"><i class="icon-edit icon-plus-sign"></i> CARGOS</a><br /><br />';
                    break;
                            
                    case 1:
                    $acciones .= '<a class="btn btn-info" href="mainpanel/reservas/editarCargos/'.$value['id_orden'].'"><i class="icon-edit icon-plus-sign"></i> EDIT CARGOS</a><br /><br />';
                    break;
                }                            
            }
            $acciones .= '<a class="btn btn-danger" href="mainpanel/reservas/editPrecios/'.$value['id_orden'].'"><i class="icon-trash icon-white"></i> &nbsp;EDIT PRECIOS</a>';
            $nestedData[] = $acciones;
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

    public function listadoAnuladas() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/lista_anuladas_view";
        
        // LISTA ORDENES
        /*$pagina = $this->uri->segment(4);
        $num_pedidos = $this->Reservas_model->getNumReservas('Anulada');
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
        $aux = $this->Reservas_model->getListaReservasPagina($pedidos_x_pagina, $reg_inicial, 'Anulada');
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
                $ax = $this->Reservas_model->getCliente($dato_orden->id_cliente);                
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
            $aux2['fecha_hora_ingreso'] = formatoFechaHora($dato_orden->fecha_ingreso);
            $aux2['caducidad'] = Ymd_2_dmYHora($dato_orden->caducidad);
            $aux2['moneda'] = $dato_orden->moneda;
            // Fecha/hora de anulacion
            $aux_fecha_anulacion = $this->Reservas_model->fechaAnulacion($dato_orden->id_orden);
            $fecha_anulacion = formatoFechaHora($aux_fecha_anulacion->fecha_anulacion);
            $aux2['fecha_anulacion'] = $fecha_anulacion;
            // Mensaje de Anulacion
            $aux_anulacion = $this->Reservas_model->getDatosAnulacion($dato_orden->id_orden);
            $msgAnulacion = $aux_anulacion->mensaje;
            $aux2['mensaje_anulacion'] = $msgAnulacion;
            
            // VEMOS SI LOS PRODUCTOS SIGUEN EN STOCK
            $hay_stock = "NO";
            $listaProductos = $this->Reservas_model->listaProductosReserva($dato_orden->id_orden);
            
            foreach($listaProductos as $producto)
            {
                $id_producto = $producto->id_producto;
                $cantidad = $producto->cantidad;
                $id_color = $producto->id_color;
                if(!empty($id_color))
                {
                    $aux_stock = $this->Reservas_model->stockProducto($id_producto, $id_color);
                    if(count($aux_stock)>0)
                    {
                        $stock_actual = $aux_stock->stock;
                        if($stock_actual>=$cantidad)
                        {
                            $hay_stock = "SI";
                        }
                        else
                        {
                            $hay_stock = "NO";
                        }
                    }
                    else
                    {
                        $stock_actual = 0;
                        $hay_stock = '----';
                    }
                    
                }
            }
            $aux2['en_stock'] = $hay_stock;
            
            // CODIGOS DE PRODUCTOS
            $aux2['codigos_productos'] = codigosProductosReserva($dato_orden->id_orden); 
            $ordenes[] = $aux2;
        }
        $dataPrincipal['ordenes'] = $ordenes;
        $dataPrincipal['num_paginas'] = $num_paginas;
        $dataPrincipal['pedidos_x_pagina'] = $pedidos_x_pagina;
        $dataPrincipal['num_pedidos'] = $num_pedidos;
        $dataPrincipal['pagina'] = $pagina;*/
        $resultado = $this->uri->segment(5);
        $dataPrincipal["resultado"] = $resultado;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
        //$dataPrincipal["resultados"] = $aux;
        //$this->load->view("mainpanel/vista_prueba", $dataPrincipal);
    }

    public function ajaxListaReservasAnuladas()
    {
        //$estado = $this->uri->segment(4);
        $estado = 'Anulada';
        $requestData= $_REQUEST;

        $columns = array( 0 => 'i.nombre', 1 => 'i.razon_social');

        $totalData = $this->Datatable->numReservas($estado);
        $totalFiltered = $totalData;

        $where = "1=1";
        if(!empty($requestData['search']['value'])) {
            $where.=" AND ( i.nombre LIKE '%".$requestData['search']['value']."%' ";
            $where.=" OR i.razon_social LIKE '%".$requestData['search']['value']."%' )";
        }
        $query = $this->Datatable->searchReservas($estado, $where);
        $totalFiltered = count($query);
        $where.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $this->Datatable->searchReservas($estado, $where);

        $data = array();
        foreach ($query as $key => $value) {

            $nestedData=array();
            $nestedData[] = $value['id_orden'];
            $nestedData[] = 10000 + $value['id_orden'];
            $aux2['id_cliente'] = $value['id_cliente'];
            if($value['id_cliente'] ===0){
                $nombre='No se tiene asignado un cliente';
            }else{
                $ax = $this->Reservas_model->getCliente($value['id_cliente']);                
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
            //$aux2['ruc_cliente'] = $ruc;
            $nestedData[] = '<strong>'.$razon_social.'</strong><br>Persona contacto: '.$nombre;
            $nestedData[] = codigosProductosReserva($value['id_orden']);
            switch($value['moneda']){
                case "d":
                    $simbolo = 'US$';                                
                break;
                        
                case "s":
                    $simbolo = 'S/';
                break;
            }
            $nestedData[]  = $simbolo.' '.$value['total'];
            //$aux2['total'] = $value['total'];
            // Mensaje de Anulacion
            $aux_anulacion = $this->Reservas_model->getDatosAnulacion($value['id_orden']);
            $msgAnulacion = $aux_anulacion->mensaje;
            $estado = $value['estado'];
            if($msgAnulacion!=""){
                $estado .= '<br><a href="javascript:motivoAnulacion(\''.$msgAnulacion.'\')">Ver Motivo</a>';
            }
            $nestedData[] = $estado;
            $nestedData[] = formatoFechaHora($value['fecha_ingreso']);
            // Fecha/hora de anulacion
            $aux_fecha_anulacion = $this->Reservas_model->fechaAnulacion($value['id_orden']);
            $nestedData[] = formatoFechaHora($aux_fecha_anulacion->fecha_anulacion);
             // VEMOS SI LOS PRODUCTOS SIGUEN EN STOCK
            $hay_stock = "NO";
            $listaProductos = $this->Reservas_model->listaProductosReserva($value['id_orden']);
            
            foreach($listaProductos as $producto)
            {
                $id_producto = $producto->id_producto;
                $cantidad = $producto->cantidad;
                $id_color = $producto->id_color;
                if(!empty($id_color))
                {
                    $aux_stock = $this->Reservas_model->stockProducto($id_producto, $id_color);
                    if(count($aux_stock)>0)
                    {
                        $stock_actual = $aux_stock->stock;
                        if($stock_actual>=$cantidad)
                        {
                            $hay_stock = "SI";
                        }
                        else
                        {
                            $hay_stock = "NO";
                        }
                    }
                    else
                    {
                        $stock_actual = 0;
                        $hay_stock = '----';
                    }
                    
                }
            }
            $en_stock = $hay_stock;
            $nestedData[] = $en_stock;

            $acciones = '<a class="btn btn-info" href="mainpanel/reservas/detalle/'.$value['id_orden'].'"><i class="icon-edit icon-white"></i> DETALLE</a><br /><br />';
            $acciones .= '<a class="btn btn-danger" href="javascript:borrarReserva(\''.$value['id_orden'].'\')"><i class="icon-trash icon-white"></i> &nbsp;&nbsp;BORRAR</a><br /><br />';
            if($en_stock=="SI")
                        {
                            $acciones .= '<a class="btn btn-success" href="javascript:reactivarReserva(\''.$value['id_orden'].'\', \'800\', \'600\')"><i class="icon-edit icon-white"></i> REACTIVAR</a> ';                      
                        }
            $nestedData[] = $acciones;
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
        $dataPrincipal["cuerpo"]="reservas/detalle";
        // DETALLE DE ORDEN
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;
        $detalles = $this->Reservas_model->getListaDetalles($id_orden);
        $dataPrincipal['detalles'] = $detalles;
        // CARGOS ADICIONALES
        $cargos = $this->Reservas_model->getCargos($id_orden);
        $dataPrincipal['cargos'] = $cargos;
	   //$dataup=array("estado"=>"Revisado");
        //$this->Reservas_model->updateEstadoOrden($id_orden,$dataup);		
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
        $aux = $this->Reservas_model->doSearchPedidos($fecha_inicio_s, $fecha_fin_s);
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
                $ax = $this->Reservas_model->getCliente($dato_orden->id_cliente);                
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
        $dataPrincipal["cuerpo"]="reservas/impresion";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;
        $detalles = $this->Reservas_model->getListaDetalles($id_orden);
        $dataPrincipal['detalles'] = $detalles;
        // CARGOS ADICIONALES
        $cargos = $this->Reservas_model->getCargos($id_orden);
        $dataPrincipal['cargos'] = $cargos;
        $this->load->view("mainpanel/includes/template_popup", $dataPrincipal);        
    }
    
    public function anular() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/anular_view";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function borrar() {
        $this->validacion->validacion_login();
        $id_orden = $this->uri->segment(4);
        // ****** CAMBIAMOS EL ESTADO A BORRADA **********
        $dataup = array("estado"=>"Borrada");
        $this->Reservas_model->updateEstadoOrden($id_orden, $dataup);
        // ******* GUARDAMOS DATOS DEL BORRADO *********
        $ahora = time();
        $fecha_borrado = date('Y:m:d H:i:s', $ahora);
        $data_borrado = array("id_reserva"=>$id_orden, "fecha_borrado"=>$fecha_borrado);
        $this->Reservas_model->guardarBorrado($data_borrado);
        redirect('mainpanel/reservas/listadoAnuladas/1/borrado-success');
    }
    
    public function doAnulacion() {
        $this->validacion->validacion_login();
        $id_orden = $this->input->post('id');        
        $mensaje = $this->input->post('mensaje');
        
        $orden = $this->Reservas_model->getOrden($id_orden);
        $tipo_reserva = $orden->tipo_reserva;
        $moneda = $orden->moneda;
        // ********* REPONEMOS EL STOCK DE LOS PRODUCTOS RESERVADOS **********
        $detalles = $this->Reservas_model->getListaDetalles($id_orden);
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
        $this->Reservas_model->updateEstadoOrden($id_orden, $dataup);
        // ******* GUARDAMOS DATOS DE LA ANULACION *********
        $ahora = time();
        $fecha_anulacion = date('Y-m-d H:i:s', $ahora);
        $data_anulacion = array("id_reserva"=>$id_orden, "mensaje"=>$mensaje, "fecha_anulacion"=>$fecha_anulacion);
        $this->Reservas_model->guardarAnulacion($data_anulacion);
        
        $fechaReserva = Ymd_2_dmY($orden->fecha_ing);
        $horaReserva = $orden->hora_ing;
        $fechaHoraReserva = $fechaReserva.' '.$horaReserva;
        $fechaAnulacion = date('d-m-Y H:i', $ahora);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente); 
        $carro = construyeCarro($id_orden, $moneda);
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
        $mail->Subject =  "Reserva Anulada #".($id_orden + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Reserva anulada:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE RESERVA ANULADA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_orden + 10000)."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "<b>FECHA/HORA DE LA RESERVA: </b>".$fechaHoraReserva."<br />\n";
        $msg .= "<b>FECHA/HORA DE LA ANULACION: </b>".$fechaAnulacion."<br />\n";
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

        redirect('mainpanel/reservas/listadoAnuladas/1/success');
    }	

    public function extender() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/extender_view";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function doExtension() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/extender_view";
        
        // **************** EXTENSION DE LA RESERVA ********************
        $id_orden = $this->input->post('id');
        $dias_adicionales = $this->input->post('dias_adicionales'); 
        $horas_adicionales = $this->input->post('horas_adicionales');  
        $total_horas_adicionales = $dias_adicionales*24 + $horas_adicionales;
        $mensaje = $this->input->post('mensaje');
        $orden = $this->Reservas_model->getOrden($id_orden);
        $aux_hc = explode(" ", $orden->caducidad);
        $aux_hc_2 = explode("-", $aux_hc[0]);
        $aux_hc_3 = explode(":", $aux_hc[1]);
        $time_caducidad_actual = mktime($aux_hc_3[0], $aux_hc_3[1], $aux_hc_3[2], $aux_hc_2[1], $aux_hc_2[2], $aux_hc_2[0]);
        $segundos_adicionales = $total_horas_adicionales*3600;
        $nuevo_time = $time_caducidad_actual + $segundos_adicionales;
        $nueva_caducidad = date('Y:m:d H:i:s', $nuevo_time);
        $nueva_caduc = date('d-m-Y H:i', $nuevo_time);
        $dataup = array("caducidad"=>$nueva_caducidad);
        $this->Reservas_model->updateReserva($id_orden,$dataup);
        $ahora = time();
        $fecha_ingreso = date('Y:m:d H:i:s', $ahora);
        $data_actualizacion = array("id_orden"=>$id_orden, "horas_adicionales"=>$horas_adicionales, "mensaje"=>$mensaje, "fecha_ingreso"=>$fecha_ingreso);
        $this->Reservas_model->guardarExtension($data_actualizacion);
        // *************** MENSAJE AL CLIENTE AVISANDOLE DE LA EXTENSION ***************
        $moneda = $orden->moneda;
        $carro = construyeCarro($id_orden, $moneda);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente);       
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
        $mail->Subject =  "Reserva Extendida #".($id_orden + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Reserva:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE RESERVA EXTENDIDA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_orden + 10000)."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " DATOS DE LA EXTENSION<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>HORAS AMPLIADAS: </b>".$horas_adicionales." horas<br />\n";
        $msg .= "<b>NUEVA FECHA DE CADUCIDAD: </b>".$nueva_caduc."<br />\n";
        $msg .= "<b>MENSAJE DE CKI: </b>".$mensaje."<br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= $carro;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";		
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();         
        // REDIRECCION AL LISTADO CON MENSAJE DE EXITO DE EXTENSION
        redirect('mainpanel/reservas/listadoActivas/1/extension-success');
    }
    
    public function reactivar() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/reactivar_view";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);           
    }
    
    public function doReactivacion() {
        $this->validacion->validacion_login();
        $id_orden = $this->input->post('id');        
        $mensaje = $this->input->post('mensaje');
        $fecha_inicio = $this->input->post('fecha_inicio');
        $hora = $this->input->post('hora');
        if($fecha_inicio<>'')
        {
            $fecha_inicio_s = dmY_2_Ymd(str_replace("/","-",$fecha_inicio));
        }
        // Actualizamos la caducidad y la Activamos
        $nueva_caducidad = $fecha_inicio_s." ".$hora.":00:00";
        $nueva_caducidad_dmY = str_replace("/","-",$fecha_inicio)." ".$hora.":00:00";
        $dataup = array("caducidad"=>$nueva_caducidad);
        $this->Reservas_model->updateReserva($id_orden,$dataup);
        
        // Guardamos los datos de la reactivacion
        $ahora = time();
        $fecha_ingreso = date('Y:m:d H:i:s', $ahora);
        $data_reac = array("id_orden"=>$id_orden, "nueva_caducidad"=>$nueva_caducidad, "fecha_reactivacion"=>$fecha_ingreso);
        $this->Reservas_model->guardarReactivacion($data_reac);
        
        // Volvemos a descontar los productos del Stock
        $orden = $this->Reservas_model->getOrden($id_orden);
        $da=explode("~",$orden->pedidos);
        $num_ped=$da[0];
        $tipo_reserva = $orden->tipo_reserva;
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
                    $aux_stock = $this->Reservas_model->stockProducto($id_producto, $id_color);
                    switch($tipo_reserva)
                    {
                        case "stock":
                            $stock_actual = $aux_stock->stock;
                            $nuevo_stock = $stock_actual - $cantidad;
                            $dataStock = array('stock'=>$nuevo_stock);
                        break;

                        case "proximamente":
                            $stock_actual = $aux_stock->stock_proximamente;
                            $nuevo_stock = $stock_actual - $cantidad;
                            $dataStock = array('stock_proximamente'=>$nuevo_stock);
                        break;
                    }                    
                    $this->Reservas_model->actualizaStock($id_producto, $id_color, $dataStock);
                }
            }
        }
        // ****** CAMBIAMOS EL ESTADO A ACTIVA **********
        $dataup = array("estado"=>"Activa");
        $this->Reservas_model->updateEstadoOrden($id_orden, $dataup);
        /******** ENVIAMOS NOTIFICACION DE LA REACTIVACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente); 
        $moneda = $orden->moneda;
        $carro = construyeCarro($id_orden, $moneda);
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
        $mail->Subject =  "Reserva Reactivada #".($id_orden + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Reserva reactivada:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE RESERVA REACTIVADA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_orden + 10000)."<br />\n";
        $msg .= "<b>NUEVA FECHA DE CADUCIDAD: </b>".$nueva_caducidad_dmY."<br />\n";
        $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
        $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
        $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
        $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " MENSAJE ACERCA DE LA REACTIVACION<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= $mensaje."<br />\n";
        $msg .= "===============================================================<br />\n";
        $msg .= $carro;
        $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
        $msg .= "===============================================================<br />\n";		
        $mail->Body = $msg;
        $mail->IsHTML(true);
        @$mail->Send();         

        redirect('mainpanel/reservas/listadoActivas/1/reactivacion-success');        
    }
    
    public function cargos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/cargos_view";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;		
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function saveCargos() {
        $this->validacion->validacion_login();
        $ahora = time();
        $fecha_ingreso = date('Y:m:d H:i:s', $ahora);
        $id_reserva = $this->input->post('id');  
        
        $concepto_cargo_1 = $this->input->post('concepto_cargo_1');
        $monto_cargo_1 = $this->input->post('monto_cargo_1');
        $tiene_cargos = 0;
        if( ($concepto_cargo_1!="") && ($monto_cargo_1!="") && ($monto_cargo_1>=0) )
        {
            $datos = array("id_reserva"=>$id_reserva, "concepto"=>$concepto_cargo_1, "monto"=>$monto_cargo_1, "fecha_ingreso"=>$fecha_ingreso);
            $this->Reservas_model->guardarCargoAdicional($datos);
            $tiene_cargos = 1;
        }
        
        $concepto_cargo_2 = $this->input->post('concepto_cargo_2');
        $monto_cargo_2 = $this->input->post('monto_cargo_2');
        if( ($concepto_cargo_2!="") && ($monto_cargo_2!="") && ($monto_cargo_2>=0) )
        {
            $datos = array("id_reserva"=>$id_reserva, "concepto"=>$concepto_cargo_2, "monto"=>$monto_cargo_2, "fecha_ingreso"=>$fecha_ingreso);
            $this->Reservas_model->guardarCargoAdicional($datos);
            $tiene_cargos = 1;
        }
        
        $concepto_cargo_3 = $this->input->post('concepto_cargo_3');
        $monto_cargo_3 = $this->input->post('monto_cargo_3');
        if( ($concepto_cargo_3!="") && ($monto_cargo_3!="") && ($monto_cargo_3>=0) )
        {
            $datos = array("id_reserva"=>$id_reserva, "concepto"=>$concepto_cargo_3, "monto"=>$monto_cargo_3, "fecha_ingreso"=>$fecha_ingreso);
            $this->Reservas_model->guardarCargoAdicional($datos);
            $tiene_cargos = 1;
        }
        if($tiene_cargos==1)
        {
            $data = array("tiene_cargos"=>1);
            $this->Reservas_model->updateReserva($id_reserva, $data);
        }        
        $orden = $this->Reservas_model->getOrden($id_reserva);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente); 
        $moneda = $orden->moneda;
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
        $mail->Subject =  "Reserva Generada #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Reserva:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE RESERVA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_reserva + 10000)."<br />\n";
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
        
        redirect('mainpanel/reservas/listadoActivas/1/cargos-guardados');
    }
    
    public function editarCargos() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/edit_cargos_view";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;
        // CARGOS ADICIONALES
        $cargos = $this->Reservas_model->getCargos($id_orden);
        $dataPrincipal['cargos'] = $cargos;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function updateCargos() {
        $this->validacion->validacion_login();
        $ahora = time();
        $fecha_ingreso = date('Y-m-d H:i:s', $ahora);
        $id_reserva = $this->input->post('id');
        $tiene_cargos = 0;
        for($i=1; $i<=3; $i++)
        {
            $id_cargo_current = $this->input->post('id_cargo_'.$i);
            $concepto_cargo = $this->input->post('concepto_cargo_'.$i);
            $monto_cargo = $this->input->post('monto_cargo_'.$i);
            if($id_cargo_current>0)
            {
                // Ya existe este cargo
                $accion_cargo = $this->input->post('accion_'.$i);
                switch($accion_cargo)
                {
                    case "editar":
                        if( ($concepto_cargo!="") && ($monto_cargo!="") && ($monto_cargo>=0) )
                        {
                            $datos = array("concepto"=>$concepto_cargo, "monto"=>$monto_cargo);
                            $this->Reservas_model->updateCargoAdicional($id_cargo_current, $datos);
                            $tiene_cargos = 1;
                        }
                    break;
                
                    case "borrar":
                        $this->Reservas_model->deleteCargoAdicional($id_cargo_current);
                    break;
                }
            }
            else
            {
                // Es un cargo nuevo
                if( ($concepto_cargo!="") && ($monto_cargo!="") && ($monto_cargo>=0) )
                {
                    $datos = array("id_reserva"=>$id_reserva, "concepto"=>$concepto_cargo, "monto"=>$monto_cargo, "fecha_ingreso"=>$fecha_ingreso);
                    $this->Reservas_model->guardarCargoAdicional($datos);
                    $tiene_cargos = 1;
                }
            } // else
        } // for
        
        if($tiene_cargos==1)
        {
            $data = array("tiene_cargos"=>1);
            $this->Reservas_model->updateReserva($id_reserva, $data);
        }
        
        $orden = $this->Reservas_model->getOrden($id_reserva);
        // *************** MENSAJE AL CLIENTE AVISANDOLE DE LA EXTENSION ***************
        $moneda = $orden->moneda;
        $carro = construyeCarro($id_reserva, $moneda);
        /******** ENVIAMOS NOTIFICACION DE LA ANULACION A CLIENTE Y A CKI **********/
        $datosCliente = $this->Reservas_model->getCliente($orden->id_cliente);
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
        $mail->Subject =  "Reserva Generada #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
        $msg = "Aqui le mostramos los datos de la Reserva:<br /><br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= " INFORMACION DE RESERVA<br />\n";
        $msg .= "===============================================================<br>\n";
        $msg .= "<b>CODIGO RESERVA: </b>".($id_reserva + 10000)."<br />\n";
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
        
        redirect('mainpanel/reservas/listadoActivas/1/cargos-guardados');
    }
    
    public function editPrecios() {
        $this->validacion->validacion_login();
        // GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = '';
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="reservas/edit_precios_view";
        // DATOS PEDIDO
        $id_orden = $this->uri->segment(4);
        $resultado = $this->uri->segment(5);
        $orden= $this->Reservas_model->getOrden($id_orden);
        $cliente = $this->Reservas_model->getCliente($orden->id_cliente);     
        $dataPrincipal['cliente'] = $cliente;
        $dataPrincipal['orden'] = $orden;
        $dataPrincipal["resultado"] = $resultado;
        $detalles = $this->Reservas_model->getListaDetalles($id_orden);
        $dataPrincipal['detalles'] = $detalles;
        $this->load->view("mainpanel/includes/template", $dataPrincipal);        
    }
    
    public function updatePreciosReserva() {
        $this->validacion->validacion_login();
        $id_reserva = $this->input->post('id'); 
        $num_items = $this->input->post('num_items');
        $id_cliente = $this->input->post('id_cliente');
        $moneda = $this->input->post('moneda');
        $tipo_cambio = getConfig("tipo_cambio_dolar");
        for($i=0; $i<$num_items; $i++)
        {
            $id_detalle = $this->input->post('id_detalle_'.$i);
            $precio = $this->input->post('precio_'.$i);
            switch($moneda)
            {
                case "d":                    
                    $precio_dolares = $precio;
                    $precio_soles = $precio*$tipo_cambio;
                break;
            
                case "s":                    
                    $precio_dolares = redondeado(($precio/$tipo_cambio),3);
                    $precio_soles = $precio;
                break;
            }
            $data = array("precio_soles"=>$precio_soles, "precio_dolares"=>$precio_dolares);
            $this->Reservas_model->updatePreciosReserva($id_detalle, $data);
        } // for
        $datosCliente = $this->Reservas_model->getCliente($id_cliente);
        $carro = construyeCarro($id_reserva, $moneda);
        //**************  FIN DE CREACION DE CARRITO *********************        
        $reserva = $this->Reservas_model->getOrden($id_reserva);
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
        $msg = "Se acaban de modificar los precios de una reserva.<br />\n";
        $msg .= "Le mostramos a continuacion los datos de la reserva modificada<br /><br />\n";
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
        $mail2->Subject =  "Reserva modificada #".($id_reserva + 10000)." por ".$datosCliente->razon_social;
        $msg2 = "Acabamos de modificar los precios de su reserva.<br />\n";
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
        redirect('mainpanel/reservas/editPrecios/'.$id_reserva.'/success');        
        
    }
}
?>