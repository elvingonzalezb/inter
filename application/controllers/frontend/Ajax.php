<?php
class Ajax extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    
        $this->load->model('frontend/Ajax_model');
        $this->load->library('My_PHPMailer'); 
    }

    public function index()	{

    }

    public function modalInicio() {
        $contenido = $this->Ajax_model->getContenidoModal('modal_inicio');
        $ok=array();
        $ok['titulo'] = $contenido->titulo;
        $ok['texto'] = $contenido->texto;        
        echo json_encode($ok);
    }
	
    public function modalImportacion() {
        $ok = array();
        if( $this->session->userdata('mostro_modal_import')==="si" )
        {
            $ok['mostrar'] = "no";
        }
        else
        {
            // Aun no la mostro, la mostramos y grabamos que ya la mostro
            $ok['mostrar'] = "si";
        }
        $valor = "si";
        $this->session->set_userdata('mostro_modal_import', $valor);
        $contenido = $this->Ajax_model->getContenidoModal('pedidos_directos');
        $ok['titulo'] = $contenido->titulo;
        $ok['texto'] = $contenido->texto; 
        echo json_encode($ok);
    }
	
    public function agregaCarro() {
        $uni= $_POST['unidad'];
        $id_unidad=$_POST['id_unidad'];
        $color = $_POST['color'];
        $cant = $_POST['cant'];
        $codigo = $_POST['codigo'];
        $nombre= $_POST['nombre'];
        $id= $_POST['id'];        
        $id_producto= $_POST['id_producto'];
        $dscto= $_POST['dscto'];
        $id_color = $_POST['id_color'];

        $pre= $this->Ajax_model->getPrecio($id_unidad,$id_producto);
        
        if(count($pre)==0)
        {
            $precio = '0';
        }
        else
        {
            if($this->session->userdata('descuento_especial')=="si")
            {
                // A este cliente aplica descuento especial
                $aux_porc = $this->Ajax_model->getPorcentajeDescuento($id_producto);
                $porcentaje_descuento = $aux_porc->descuento_especial;
                if($porcentaje_descuento>0)
                {
                    $porc_con_descuento = 100 - $porcentaje_descuento;
                    $precio_uax = ($porc_con_descuento/100)*($pre->precio);
                    //$precio = round($precio_uax, 3, PHP_ROUND_HALF_UP);
                    $precio = $precio_uax;
                    /*
                    $sumar_un_milesimo = getConfig("sumar_un_milesimo");
                    if($sumar_un_milesimo=="Si")
                    {
                        $precio = round($precio_uax, 3, PHP_ROUND_HALF_UP) + 0.001;
                    }
                    else
                    {
                        $precio = round($precio_uax, 3, PHP_ROUND_HALF_UP);
                    }
                    */
                }
                else
                {
                    $precio=$pre->precio;
                }
            }
            else
            {
                $precio=$pre->precio;
            }
        }
        
        //$aux= $this->Ajax_model->getProducto($id_producto);
        
        if($this->session->userdata('carrito'))
        {
            $carrito=$this->session->userdata('carrito');
            if(isset($carrito[$id]))
            {
                $cantidad_1=$carrito[$id]['cantidad'];
                $carrito[$id]['cantidad']=$cantidad_1 + $cant;
            }
            else
            {
                //$carrito[$id]= array('id' => $id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $uni,'precio' => $precio,'uu' => $id_unidad,'ee' => $id_producto);
                $carrito[$id] = array('id' => $id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $uni,'precio' => $precio,'id_producto' => $id_producto,'dscto' => $dscto, 'id_color' => $id_color);
            }
        }
        else
        {
            $carrito=array();
            //$carrito[$id]= array('id' => $id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $uni,'precio' => $precio,'uu' => $id_unidad,'ee' => $id_producto);
            $carrito[$id]= array('id' => $id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $uni,'precio' => $precio,'id_producto' => $id_producto,'dscto' => $dscto, 'id_color' => $id_color);
        }
        
        $numItem=count($carrito);
        $limite_items_carrito = getConfig("limite_items_carrito");
        if($numItem>$limite_items_carrito)
        {
            $respuesta = array();
            $respuesta['dato'] = 'error';
            $respuesta['num'] = $limite_items_carrito;        
            echo json_encode($respuesta);
        }
        else
        {
            $this->session->set_userdata('carrito',$carrito);
            $respuesta = array();
            $respuesta['dato']='ok';
            $respuesta['num']=$numItem;        
            echo json_encode($respuesta);
        }
    }
    
    public function actualizaCarro() {
        $cant = $_POST['cant'];
        $id= $_POST['id'];        
        
        if($this->session->userdata('carrito'))
        {
            $carrito=$this->session->userdata('carrito');
            if(isset($carrito[$id]))
            {
                //$cargos = $this->Ajax_model->getStockColor();
                $carrito[$id]['cantidad']=$cant;
            }
            
            $this->session->set_userdata('carrito',$carrito);
            $ok=array();
            $ok['dato']='ok';
            echo json_encode($ok);                
        }
    }
    
    public function seguirAgregando() {
        $ok=array();
        $ok['dato']='ok';
        echo json_encode($ok);
    }
    
    public function eliminaItemCarro() {
        $id= $_POST['id'];        
        
        if($this->session->userdata('carrito'))
        {
            $carrito=$this->session->userdata('carrito');
            if(isset($carrito[$id]))
            {
                unset($carrito[$id]);
            }
            $numItem=count($carrito);
            if($numItem==0){
                // El carro se quedo vacio
                $this->session->unset_userdata('tipoReserva');
                $this->session->unset_userdata('carrito');
            }else{
                $this->session->set_userdata('carrito',$carrito);                           
            }

            $ok=array();
            $ok['dato']='ok';
            $ok['num']=$numItem;  
            echo json_encode($ok);                
        }
    }
	 
    public function eliminaCarro() {
        $this->session->unset_userdata('tipoReserva');
        $this->session->unset_userdata('carrito');
        $ok=array();
        $ok['dato']='ok';
        echo json_encode($ok);                
    }      
    
    public function enviarPedido() {
        $mensaje_carro= $_POST['mensaje_carro'];
        if(!$this->session->userdata('carrito')){
            
            $result='error-envio';
        }
        else
        {
            $carrito=$this->session->userdata('carrito');
            $aux=array();
            $cont=0;
            $total=0;
            foreach ($carrito as $value) {
                $cantidad=$value['cantidad'];
                $color=$value['color'];
                $codigo=$value['codigo'];
                $nombre=$value['nombre'];
                $uni=$value['uni'];
                $precio=$value['precio'];
                $id_producto=$value['id_producto'];
                $id_color = $value['id_color'];
                $subtot=$cantidad * $precio;
                $aux[]=$id_producto.'@'.$cantidad.'@'.$color.'@'.number_format($precio, 3, '.', ',').'@'.$codigo.'@'.$nombre.'@'.number_format($subtot, 3, '.', ',').'@'.$uni.'@'.$id_color;
                $total=$total + $subtot;
                $cont +=1;
            }

            $data=array();
            $data['pedidos']=$cont.'~'.implode("~", $aux);
            $data['id_cliente']=$this->session->userdata('id_cliente_logueado');
            $data['total']=$total;               
            $data['estado']='No Revisada';
            $data['mensaje']=$mensaje_carro;
            $data['fecha_ingreso']=date("Y-m-d H:i:s");
            $data['tipo_cambio_dolar']=  getConfig("tipo_cambio_dolar");
            $data['moneda'] = $this->session->userdata('moneda');
            // ***** CAMPOS AGREGADOS ********
            $data['id_reserva'] = '';
            $data['codigo_reserva'] = '';
            $data['forma_pago'] = '';
            $data['banco'] = '';
            $data['numero_operacion'] = '';
            $data['fecha_pago'] = '';
            // Cargos adicionales
            $cargos = $this->Ajax_model->getListaCargos();
            $lista_cargos = array();
            foreach($cargos as $cargo)
            {
                $concepto = $cargo->concepto;
                $monto = $cargo->monto;
                $lista_cargos[] = $concepto."#".$monto;
            }
            $data['cargos_adicionales'] = implode("@", $lista_cargos);
            
            $id_ingresado = $this->Ajax_model->grabaPedido($data);
            if($id_ingresado>0)
            {    
                //css para carro
                $encabezado_carro='style="padding:5px;text-align: center;color:#007dce;font-weight: bold;height: 31px;border: #EFEFEF solid 1px;background: #EBEBEB;"';
                $contenido_carro='color: #696767;border: solid 1px #C2C2C2;padding: 5px;';
                $cuadr=' width: 15px;height: 15px;border: #C2C2C2 solid 1px; ';
                //creamos el carrito
                $car='';
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
                $carrito=$this->session->userdata('carrito');
                $cont=0;
                $total=0;
                foreach ($carrito as $value=>$key) 
                {
                    $cont +=1;
                    $id=$key['id'];                            
                    $codigo=$key['codigo'];
                    $nombre=$key['nombre'];                            
                    $color=$key['color'];                            
                    $cantidad=$key['cantidad'];
                    $uni=$key['uni'];
                    $id_color = $key['id_color'];
                    $aux_nombre_color = $this->Ajax_model->nombreColor($id_color);
                    if($aux_nombre_color===0) {
                        $nombre_color = '------';
                    }
                    else {
                        $nombre_color = $aux_nombre_color->nombre;
                    }                    
                    // Descontamos el stock de este color
                    $id_producto = $key['id_producto'];
                    $aux_stock = $this->Ajax_model->stockProducto($id_producto, $id_color);
                    $stock_actual = $aux_stock->stock;
                    $nuevo_stock = $stock_actual - $cantidad;
                    $dataStock = array('stock'=>$nuevo_stock);
                    $this->Ajax_model->actualizaStock($id_producto, $id_color, $dataStock);
                    // vemos si es en SOLES o DOLARES
                    if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='s')
                    {
                       $t_c=1;$uni='S/.';$dscto=1;
                    }
                    else if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='d')
                    {
                            $t_c= getConfig("tipo_cambio_dolar");$uni='US$ ';
                            // vemos si tiene descuento
                            if($key['dscto']=='si'){
                                    $dscto=getConfig("descuento");
                            }else{$dscto=1;}                          
                    }else{
                            $t_c=1;
                            $dscto=1;
                    }
                    $precio=($key['precio'])/$t_c/$dscto;	
                    $precio=number_format($precio, 3, '.', ',');
                    $subtot=number_format(($precio * $cantidad), 3, '.', '');
                    $total=$total + $subtot;
                    $car .='<tr>';
                    $car .='<td '.$contenido_carro.' align="center">'.$cont.'</td>';
                    $car .='<td '.$contenido_carro.'>'.$codigo.'</td>';
                    $car .='<td '.$contenido_carro.' align="left">'.$nombre.'</td>';
                    $car .='<td '.$contenido_carro.' align="center" style="background:'.$color.'"></td>';
                    $car .='<td '.$contenido_carro.' align="center">'.$nombre_color.'</td>';
                    $car .='<td '.$contenido_carro.' align="right">'.$cantidad.'</td>';
                    $car .='<td '.$contenido_carro.' align="right">'.$precio.'</td>';
                    $car .='<td '.$contenido_carro.' align="right">'.$subtot.'</td>';
                    $car .='</tr>';
                }
                // ***** CARGOS ADICIONALES *******
                if(count($lista_cargos)>0)
                {
                    $car .= '<tr>';
                    $car .= '<td>N</td>';
                    $car .= '<td colspan="6">CONCEPTO</td>';
                    $car .= '<td>MONTO</td>';
                    $car .= '</tr>';
                    for($j=0; $j<count($lista_cargos); $j++)
                    {
                        $cargo_current = explode("#", $lista_cargos[$j]);
                        $concepto_current = $cargo_current[0];
                        $monto_current = $cargo_current[1];
                        $car .= '<tr>';
                        $car .= '<td>'.($j+1).'</td>';
                        $car .= '<td colspan="6" '.$contenido_carro.'>'.$concepto_current.'</td>';
                        $car .= '<td '.$contenido_carro.'>'.$monto_current.'</td>';
                        $car .= '</tr>';
                        $total = $total + $monto_current;
                    }
                }
                
                $car .='<tr>';
                $car .='<td colspan="5" '.$contenido_carro.'>';
                $car .='</td>';
                $car .='<td '.$contenido_carro.'><strong>TOTAL</strong></td>';
                $car .='<td '.$contenido_carro.'><strong>'.$uni.number_format($total, 2, '.', ',').'</strong></td>';
                $car .='</tr>';
                $car .='</table>';
                //**************  FIN DE CREACION DE CARRITO *********************
                $correo_notificaciones = getConfig('correo_notificaciones');
                $correo_notificaciones_alterno = getConfig('correo_notificaciones_alterno');
                // INFORMACION DEL CLIENTE
                $aux_id_cliente = $this->session->userdata('id_cliente_logueado');
                $datosCliente = $this->Ajax_model->getDatosCliente($aux_id_cliente); 
				
                $mail = new PHPMailer();
                //$mail->From = $this->session->userdata('email'); // direccion de quien envia
                $mail->From = $correo_notificaciones;
                //$mail->FromName = "Nuevo Pedido en CKI Internacional"; // nombre de quien envia
                $mail->FromName = "CKI INTERNACIONAL";				
                $mail->AddAddress($correo_notificaciones);
                $mail->AddAddress($correo_notificaciones_alterno);
		$mail->AddBCC("erosadio@ajaxperu.com");
                $mail->Subject =  "Pedido generado #".($id_ingresado + 10000)." por ".$datosCliente->razon_social; 
                $msg = "Aqui le mostramos los datos generales del Pedido:<br /><br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= " INFORMACION DE PEDIDO<br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= "<b>NUM PEDIDO: </b>".($id_ingresado + 10000)."<br />\n";
                $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
                $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
                $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
                $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
                if(!empty($mensaje_carro))
                {
                    $msg .= "===============================================================<br>\n";
                    $msg .= " MENSAJE DEL CLIENTE<br />\n";
                    $msg .= "===============================================================<br>\n"; 
                    $msg .= "<b>MENSAJE: </b>".$mensaje_carro."<br />\n";
                }
                $msg .= "===============================================================<br />\n";
                $msg .= $car;
                $msg .= "<b>NOTA.- Los precios incluyen IGV</b><br />\n";
                $msg .= "===============================================================<br />\n";		
                $mail->Body = $msg;
                $mail->IsHTML(true);
                @$mail->Send();  
                
                //********** INFORMACION DE PEDIDO PARA EL CLIENTE *************/
                $mail2 = new PHPMailer();
                $mail2->From = $correo_notificaciones;
                $mail2->FromName = "CKI INTERNACIONAL";
                $mail2->AddAddress($this->session->userdata('email'));
                //$mail->AddBCC("l14307@hotmail.com");
                $mail2->Subject =  "Pedido generado #".($id_ingresado + 10000)." por ".$datosCliente->razon_social;
                $msg2 = "Aqui le mostramos los datos generales del Pedido:<br /><br />\n";
                $msg2 .= "===============================================================<br>\n";
                $msg2 .= " INFORMACION DE PEDIDO<br />\n";
                $msg2 .= "===============================================================<br>\n";
                $msg2 .= "<b>NUM PEDIDO:</b> ".($id_ingresado + 10000)."<br>\n";
                $msg2 .= "<b>RAZON SOCIAL:</b> ".$datosCliente->razon_social."<br>\n";
                $msg2 .= "<b>RUC:</b> ".$datosCliente->ruc."<br>\n";
                $msg2 .= "<b>PERSONA DE CONTACTO:</b> ".$datosCliente->nombre."<br>\n";
                $msg2 .= "<b>EMAIL:</b> ".$datosCliente->email."<br>\n";
                if(!empty($mensaje_carro))
                {
                    $msg2 .= "===============================================================<br>\n";
                    $msg2 .= " MENSAJE DEL CLIENTE<br />\n";
                    $msg2 .= "===============================================================<br>\n"; 
                    $msg2 .= "<b>MENSAJE: </b>".$mensaje_carro."<br />\n";
                }
                $msg2 .= "===============================================================<br />\n";
                $msg2 .= $car;
                $msg2 .= "===============================================================<br>\n";
                $msg2 .= " INFORMACION DE PAGO<br />\n";
                $msg2 .= "===============================================================<br>\n";		
                $msg2 .= getConfig("cuentas_bancarias");               
                $msg2 .= "===============================================================<br>\n";		                
                $mail2->Body = $msg2;
                $mail2->IsHTML(true);
                @$mail2->Send();  
                
                $this->session->unset_userdata('carrito');
            	$result='success-envio';
             }
             else
             {
		$result='error-envio';
             }
        }
        redirect("pedido/".$result);
    }       

    public function enviarReserva() {
        $mensaje_carro= $_POST['mensaje_reserva'];
        $tipo_cambio = getConfig("tipo_cambio_dolar");
        $moneda = $this->session->userdata('moneda');
        $total = 0;
        $total_dolares = 0;
        if(!$this->session->userdata('carrito'))
        {    
            $result = 'error-envio';
        }
        else
        {
            // ACOPIAMOS LOS DATOS DE LA RESERVA
            $data = array();
            //$data['pedidos'] = $cont.'~'.implode("~", $aux);
            $data['pedidos'] = '';
            $data['id_cliente'] = $this->session->userdata('id_cliente_logueado');
            $data['total'] = $total;               
            $data['estado'] = 'Activa';
            $data['mensaje'] = $mensaje_carro;
            $data['fecha_ingreso'] = date("Y-m-d H:i:s");
            $data['tipo_cambio_dolar'] =  $tipo_cambio;
            $data['moneda'] = $moneda;
            // Vencimiento
            $ahora = time();
            $horas_duracion_reserva = getConfig("horas_duracion_reserva");
            $aux_fin = $ahora + $horas_duracion_reserva*60*60;
            $vencimiento = date('Y-m-d H:i:s', $aux_fin);
            $caducidad = date('d-m-Y H:i', $aux_fin);
            $data['caducidad'] = $vencimiento;
            $data['fecha_ing'] = date("Y-m-d");
            $data['hora_ing'] = date("H:i:s");
            
            $fecha_ingreso_reserva = date('d-m-Y H:i:s', $ahora);
            
            // LLEVA CARGOS ADICIONALES ?
            $id_cliente = $this->session->userdata('id_cliente_logueado');
            $cliente = $this->Ajax_model->getDatosCliente($id_cliente); 
            $lleva_cargos = $cliente->tiene_cargos;
            $data['lleva_cargos'] = $lleva_cargos;
            
            // TIPO DE RESERVA
            $data['tipo_reserva'] = $this->session->userdata('tipoReserva');
            
            // GUARDAMOS RESERVA
            $id_reserva = $this->Ajax_model->grabaReserva($data);
            
            // GUARDAMOS EL DETALLE DE LA RESERVA
            $carrito = $this->session->userdata('carrito');
            $aux = array();
            $cont = 0;
            foreach ($carrito as $value) {
                $datos = array();
                $datos['id_reserva'] = $id_reserva;
                $datos['id_producto'] = $value['id_producto'];
                $datos['codigo_producto'] = $value['codigo'];
                $datos['nombre_producto'] = $value['nombre'];
                $datos['cantidad'] = $value['cantidad'];
                $datos['unidad'] = $value['uni'];
                $datos['precio_soles'] = $value['precio'];
                $precio_dolares = redondeado(($value['precio']/$tipo_cambio), 3);
                $datos['precio_dolares'] = $precio_dolares;
                $datos['id_color'] = $value['id_color'];
                $datos['codigo_color'] = $value['color'];                
                $aux_nombre_color = $this->Ajax_model->nombreColor($value['id_color']);
                if($aux_nombre_color===0)
                {
                    $datos['nombre_color'] = '------';
                }
                else
                {
                    $datos['nombre_color'] = $aux_nombre_color->nombre;
                }
                $subtotal = $value['cantidad']*$value['precio'];
                $subtotal_dolares = $value['cantidad']*$precio_dolares;
                $total += $subtotal;
                $total_dolares += $subtotal_dolares;
                $id_detalle = $this->Ajax_model->grabaDetalleReserva($datos);
                $cont += 1;
                
                /*********** ACTUALIZAMOS EL STOCK ***********/
                $aux_stock = $this->Ajax_model->stockProducto($value['id_producto'], $value['id_color']);    
                // VEMOS QUE TIPO DE RESERVA ES PARA HACER EL DESCUENTO CORRESPONDIENTE DEL STOCK
                $tipoReserva = $this->session->userdata('tipoReserva');
                $cantidad = $value['cantidad'];
                switch($tipoReserva)
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
                $this->Ajax_model->actualizaStock($value['id_producto'], $value['id_color'], $dataStock);
            } // foreach
            // ACTUALIZA MONTO
            $data['total'] = $total;
            $data['total_dolares'] = $total_dolares;
            $this->Ajax_model->actualizaMonto($id_reserva, $data);
            if($id_reserva>0)
            {    
                $carro = construyeCarro($id_reserva, $moneda);
                //echo $carro; die();
                //**************  FIN DE CREACION DE CARRITO *********************
                $correo_notificaciones = getConfig('correo_notificaciones');
                $correo_notificaciones_alterno = getConfig('correo_notificaciones_alterno');
                // INFORMACION DEL CLIENTE
                $aux_id_cliente = $this->session->userdata('id_cliente_logueado');
                $datosCliente = $this->Ajax_model->getDatosCliente($aux_id_cliente); 
		// ************* CORREO PARA LA ADMINISTRACION ****************		
                $mail = new PHPMailer();
                $mail->From = $correo_notificaciones;
                $mail->FromName = "CKI INTERNACIONAL";				
                $mail->AddAddress($correo_notificaciones);
                $mail->AddAddress($correo_notificaciones_alterno);
		$mail->AddBCC("erosadio@ajaxperu.com");
                if($lleva_cargos==1)
                {
                    $mail->Subject =  "Reserva Pendiente de cargos #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
                }
                else
                {
                   $mail->Subject =  "Reserva generada #".($id_reserva+ 10000)." por ".$datosCliente->razon_social;  
                }
                
                $msg = "Aqui le mostramos los datos generales de la reserva:<br /><br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= " INFORMACION DE LA RESERVA<br />\n";
                $msg .= "===============================================================<br>\n";
                $msg .= "<b>NUM RESERVA: </b>".($id_reserva + 10000)."<br />\n";
                $msg .= "<b>FECHA/HORA REGISTRO RESERVA: </b>".$fecha_ingreso_reserva."<br />\n";
                $msg .= "<b>CADUCIDAD DE LA RESERVA: </b>".$caducidad."<br />\n";
                $msg .= "<b>RAZON SOCIAL: </b>".$datosCliente->razon_social."<br />\n";
                $msg .= "<b>RUC: </b>".$datosCliente->ruc."<br />\n";
                $msg .= "<b>PERSONA DE CONTACTO: </b>".$datosCliente->nombre."<br />\n";
                $msg .= "<b>EMAIL: </b>".$datosCliente->email."<br />\n";
                if(!empty($mensaje_carro))
                {
                    $msg .= "===============================================================<br>\n";
                    $msg .= " MENSAJE DEL CLIENTE<br />\n";
                    $msg .= "===============================================================<br>\n"; 
                    $msg .= "<b>MENSAJE: </b>".$mensaje_carro."<br />\n";
                }
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
                
                $nivel_cliente = $this->session->userdata('nivel');
                if($nivel_cliente=="vendedor")
                {
                    $id_gerente = $this->session->userdata('id_padre');
                    if($id_gerente>0)
                    {
                        $email_gerente = $this->Ajax_model->getEmailGerente($id_gerente);
                        $mail2->AddAddress($email_gerente);
                    }                    
                }
                //$mail->AddBCC("l14307@hotmail.com");
                if($lleva_cargos==1)
                {
                    $mail2->Subject =  "Reserva Pendiente de cargos #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
                }
                else
                {
                   $mail2->Subject =  "Reserva generada #".($id_reserva + 10000)." por ".$datosCliente->razon_social; 
                }
                
                $msg2 = "Aqui le mostramos los datos generales de su reserva:<br /><br />\n";
                if($tipoReserva=="proximamente")
                {
                    $msg2 .= "===============================================================<br>\n";
                    $msg2 .= " NOTA<br />\n";
                    $msg2 .= "===============================================================<br>\n";
                    $msg2 .= "Pedido de proximos ingresos. Fecha de llegada por confirmar<br>\n";   
                }
                $msg2 .= "===============================================================<br>\n";
                $msg2 .= " INFORMACION DE LA RESERVA<br />\n";
                $msg2 .= "===============================================================<br>\n";
                $msg2 .= "<b>NUM RESERVA:</b> ".($id_reserva + 10000)."<br>\n";
                $msg2 .= "<b>FECHA/HORA REGISTRO RESERVA: </b>".$fecha_ingreso_reserva."<br />\n";
                $msg2 .= "<b>CADUCIDAD DE SU RESERVA: </b>".$caducidad."<br />\n";
                $msg2 .= "<b>RAZON SOCIAL:</b> ".$datosCliente->razon_social."<br>\n";
                $msg2 .= "<b>RUC:</b> ".$datosCliente->ruc."<br>\n";
                $msg2 .= "<b>PERSONA DE CONTACTO:</b> ".$datosCliente->nombre."<br>\n";
                $msg2 .= "<b>EMAIL:</b> ".$datosCliente->email."<br>\n";
                if(!empty($mensaje_carro))
                {
                    $msg2 .= "===============================================================<br>\n";
                    $msg2 .= " MENSAJE DEL CLIENTE<br />\n";
                    $msg2 .= "===============================================================<br>\n"; 
                    $msg2 .= "<b>MENSAJE: </b>".$mensaje_carro."<br />\n";
                }
                $msg2 .= "===============================================================<br />\n";
                $msg2 .= $carro;
                $msg2 .= "===============================================================<br>\n";
                $msg2 .= " INFORMACION DE PAGO<br />\n";
                $msg2 .= "===============================================================<br>\n";		
                $msg2 .= getConfig("cuentas_bancarias");               
                $msg2 .= "===============================================================<br>\n";		                
                $mail2->Body = $msg2;
                $mail2->IsHTML(true);
                @$mail2->Send();  
                
                $this->session->unset_userdata('carrito');
                $this->session->unset_userdata('tipoReserva');
            	$result = 'reserva-enviada';
             }
            else
            {
		$result = 'error-reserva';
            } // else
        } // else
        $operacion = $this->input->post('operacion');
        switch($operacion)
        {
            case "reserva":
                redirect("pedido/".$result);
            break;
        
            case "compra":
                redirect("reservas/comprar/".$id_reserva);
            break;
        }        
    }
    
    public function verif_exist_email() {
        $email = $_POST['email'];
		$num= $this->Ajax_model->verifEmail($email);
		if($num>0){
			$dato['result']='si';			
		}else{
			$dato['result']='no';			
		}
		$dato['email']=$email;
		echo json_encode($dato);                

    }
	  
    public function getInfoProd() {
        $id = $_POST['id'];
		$aux= $this->Ajax_model->getInfo($id);

		$dato['nombre']=$aux->nombre;
		echo json_encode($dato);                

    }

    public function galeria_x_color()
    {
        if ($_POST) {

            $id_stock = $_POST['id'];
            $fotos = $this->Ajax_model->getStockColorByID($id_stock);
            //echo '<pre>';print_r($fotos);echo '</pre>';die;
            $json['result'] = 'si';
            $imgIsset = 0;
            $json['html'] = '<div class="wrap-slick3 flex-sb flex-w">';
            if (!empty($fotos)) {
                    
                $json['html'] .= '<div class="wrap-slick3-dots"></div><div class="wrap-slick3-arrows flex-sb-m flex-w"></div>';
                
                $json['html'] .= '<div class="slick3 gallery-lb">';
                for ($i=1; $i < 4; $i++) {
                    if (($fotos['imagen'.$i]!="") && (is_file('./files/thumbnails_fotografias/'.$fotos['imagen'.$i]))) {
                        $imgIsset = 1;
                        $json['html'] .= '<div class="item-slick3" data-thumb="files/thumbnails_fotografias/'.$fotos['imagen'.$i].'">';
                        $json['html'] .=     '<div class="wrap-pic-w pos-relative">';
                       // $json['html'] .=         '<a data-fancybox="gallerylb" href="files/fotografias/'.$fotos['imagen'.$i].'">';
                        $json['html'] .=             '<img src="files/fotografias_medianas/'.$fotos['imagen'.$i].'" alt="'.$fotos['nombre'].'">';
                        //$json['html'] .=         '</a>';
                        $json['html'] .=            '<a data-fancybox="gallerylb" class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="files/fotografias/'.$fotos['imagen'.$i].'"><i class="fa fa-expand"></i></a>';
                        $json['html'] .=     '</div>';
                        $json['html'] .= '</div>';
                    }
                }
                if ($imgIsset == 0) {
                    $json['html'] .= '<div class="item-slick3"><div class="wrap-pic-w pos-relative"><img src="assets/frontend/cki/imagenes/noimage.png" alt="No existe imagen"></div></div>';
                }
                $json['html'] .= '</div>';
            }
            $json['html'] .= '</div>';
            
        }else{
            $json = array('result'=>'no','html'=>'');
        }
        echo json_encode($json);
        
    }
	
}
?>