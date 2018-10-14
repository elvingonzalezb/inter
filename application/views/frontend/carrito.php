<section class="bg0 p-b-120" id="cuerpoSeccion">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="side-menu">
					<div class="p-t-5">
						<div class="mtext-103 list-group">
							<a href="novedades/1" class="list-group-item">NUEVOS INGRESOS</a>
							<a href="proximosIngresos/1" class="list-group-item">PROXIMOS INGRESOS</a>
							<a href="#" class="list-group-item">NOVEDADES</a>
							<a href="contactenos" class="list-group-item">CONTACTENOS</a>
							<a href="#" class="list-group-item">NUEVOS REGISTROS</a>
						</div>
					</div>
					<div class="p-t-25 p-l-15 p-r-15">
						<div class="wrap-links p-b-20 stext-111">
							<h5 class="mtext-113 cl2 p-b-12">Horario</h5>
							<?php echo $horario;?>
						</div>
						<div class="wrap-links p-b-20 stext-111">
							<h5 class="mtext-113 cl2 p-b-12">DIRECCION</h5>
							<?php echo $direccion;?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="m-t-25 m-b-20 m-l-10 m-r-20 p-b-20">
					<div class="wrap-title-black">
						<h1 class="mtext-113">Carrito de Pedidos</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<div class="sub_contenido">
							<?php
								if(isset($resultado)) {
								    switch($resultado) {
								        default:
								        case "carro":			
								            if($this->session->userdata('carrito')) {                                                                       
								                if( (isset($resultado2)) && ($resultado2=="limite") ) {
								                    echo '<div class="alert alert-danger" role="alert"><div class="row">';
								                     echo '<div class="text-center col-2 alert-icon-col"><span class="fa fa-exclamation-triangle fa-5x"></span></div>';
								                     echo '<div class="col d-flex align-items-center"><span>MAXIMO 14 ARTICULOS POR PEDIDO</span></div>';
								                     echo '</div></div>';
								                } else {                                        
								                     echo '<div class="alert alert-primary" role="alert"><div class="row">';
								                     echo '<div class="text-center col-2 alert-icon-col"><span class="fa fa-exclamation-triangle fa-5x"></span></div>';
								                     echo '<div class="col d-flex align-items-center"><span>Los productos elegidos han sido agregados a su pedido. Recuerde que no serán descontados del stock hasta que haya culminado con su reserva.</span></div>';
								                     echo '</div></div>';
								                    /*
								                    echo '<div class="msgCarrito msgRojo">';
								                    echo '<span><i class="fa fa-exclamation-triangle fa-5x"></i></span>';
								                    echo '<p style="font-size:16px;">Por motivos de inventario, los pedidos y compras estan restringidos hasta el dia Sabado 2 de Enero a las 6pm</p>';
								                    echo '</div>'; 
								                    //*/
								                }
								?>
							<form id="formPedido" action="frontend/ajax/enviarReserva" method="post" onsubmit="return preguntaReserva('<?php echo getConfig("horas_duracion_reserva"); ?>')">
								<div class="table-responsive">
									<table class="table" cellspacing="1">
										<tr>
											<td class="encabezado_carro" width="5%">N</td>
											<td class="encabezado_carro" width="30%">Producto</td>
											<!--<td class="encabezado_carro" width="8%">C&oacute;digo</td>-->
											<td class="encabezado_carro" width="5%">Color</td>
											<td class="encabezado_carro" width="11%">Color</td>
											<td class="encabezado_carro" width="20%">Cantidad</td>
											<td class="encabezado_carro" width="12%">Precio</td>
											<td class="encabezado_carro" width="12%">Subtotal</td>
											<!--<td class="encabezado_carro" width="10%">Disponibilidad</td>-->
										</tr>
										<?php
											$carrito=$this->session->userdata('carrito');
											$cont=0;
											$total=0;
											$moneda = $this->session->userdata('moneda');
											switch($moneda) {
											    case "d":
											        $simbolo = 'US$';
											    break;
											
											    case "s":
											        $simbolo = 'S/';
											    break;
											}
											foreach ($carrito as $value=>$key) {
											    $cont +=1;
											    $id = $key['id'];                            
											    $codigo = $key['codigo'];
											    $nombre = $key['nombre']; 
											    $id_producto = $key['id_producto'];
											    $cadena = formateaCadena($nombre);
											    $link_prod = '<a href="detalle-producto/'.$id_producto.'/'.$cadena.'">'.$nombre.' - COD.: '.$codigo.'</a>';
											    $color = $key['color'];                            
											    $cantidad = $key['cantidad'];
											    $id_color = $key['id_color'];
											    $stock = $key['stock'];
											    $nombre_color = getColorName($id_color);
											    $uni = $key['uni'];					
											    // vemos si es en SOLES o DOLARES
											    if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='s') {
											       $t_c = 1;
											       $uni = 'S/.';
											       $dscto = 1;
											    } else if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='d') {
											        $t_c = getConfig("tipo_cambio_dolar");
											        $uni = 'US$ ';
											        // vemos si tiene descuento
											        if($key['dscto']=='si') {
											            $dscto=getConfig("descuento");
											        } else {
											            $dscto=1;
											        }                          
											    } else {
											        $t_c=1;$dscto=1;
											    }
											    $precio = ($key['precio'])/$t_c/$dscto;
											    $precio = number_format($precio, 3, '.', ',');
											    $subtot = number_format(($precio * $cantidad), 3, '.', '');
											    $total = $total + $subtot;
											?>
										<tr>
											<td class="contenido_carro" align="center"><?php echo $cont; ?></td>
											<td class="contenido_carro"><?php echo $link_prod; ?></td>
											<!--<td class="contenido_carro"><?php echo $codigo; ?></td>-->
											<td class="contenido_carro" align="center">
												<div class="cuadr" style="background: <?php echo $color; ?>"></div>
											</td>
											<td class="contenido_carro"><?php echo $nombre_color; ?></td>
											<td class="contenido_carro">
												<div class="updateCantidad">
													<input type="text" onKeyPress="return checkIt(event)" class="campo" id="cant_<?php echo $id;?>" size="5" value="<?php echo $cantidad; ?>" />
													&nbsp;&nbsp;
													<a href="javascript:actualiza_carrito(<?php echo $id?>)"><img src="assets/frontend/cki/imagenes/update.png" title="Actualizar" align="absmiddle"/></a>  
													&nbsp;&nbsp;
													<a href="javascript:elimina_item_carrito(<?php echo $id?>)"><img src="assets/frontend/cki/imagenes/del.png" title="Eliminar Item" align="absmiddle"/></a>
													<input type="hidden" name="stock_<?php echo $id; ?>" id="stock_<?php echo $id; ?>" value="<?php echo $stock; ?>">
												</div>
												
											</td>
											<td class="contenido_carro" align="center"><?php echo $simbolo.' '.$precio; ?></td>
											<td class="contenido_carro" align="center"><?php echo $simbolo.' '.$subtot; ?></td>
											<!--<td class="contenido_carro" align="center">Inmediata</td>-->
										</tr>
										<?php } // for each ?>
										<tr>
											<td colspan="5"  class="encabezado_carro"></td>
											<td class="encabezado_carro"><strong>TOTAL</strong></td>
											<td class="encabezado_carro"><strong><?php echo $uni.number_format($total, 3, '.', ',');?></strong></td>
											<!--<td class="encabezado_carro"></td>-->
										</tr>
										<tr>
											<td colspan="8" height="5"></td>
										</tr>
										<tr>
											<td colspan="8" class="notaDanger" align="left"><strong>NOTA.-</strong> Los precios incluyen IGV</td>
										</tr>
									</table>
								</div>
								
								<?php
									// ********** CARGOS ADICIONALES ************
									switch($tiene_cargos) {
									    case 0:
									        
									    break;
									
									    case 1:
									        echo '<h2 class="m-b-15 m-t-15 mtext-113">CARGOS ADICIONALES</h2>';
									        echo '<div class="alert alert-danger" role="alert"><div class="row">';
									        echo '<div class="text-center col-2 alert-icon-col"><span class="fa fa-money fa-5x"></span></div>';
									        echo '<div class="col d-flex align-items-center"><span>Su pedido tendra cargos adicionales. Una vez que estos se agreguen usted podra concretar su compra.</span></div>';
									        echo '</div></div>';
									    break;
									
									    case 2:
									        echo '<h2 class="m-b-15 m-t-15 mtext-113">CARGOS ADICIONALES</h2>';
									        echo '<div class="alert alert-warning" role="alert"><div class="row">';
									        echo '<div class="text-center col-2 alert-icon-col"><span class="fa fa-calculator fa-5x"></span></div>';
									        echo '<div class="col d-flex align-items-center"><span>Su pedido tendra cargos adicionales. Una vez que estos se agreguen usted podra concretar su compra.</span></div>';
									        echo '</div></div>';                            
									    break;
									} // switch
									
									?>
								<div class="row p-b-25">
									<div class="col-sm-3 p-b-5">
										<label class="stext-102 cl3 font-weight-bold" for="mensaje">MENSAJE</label>
									</div>

									<div class="col-sm-9 p-b-5">
										<input class="size-111 bor8 stext-102 cl2 p-lr-20 campo" type="text" id="mensaje_reserva" size="60" name="mensaje_reserva">
									</div>
								</div>

								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<input type="button" onclick="elimina_todo_carrito()" value="ELIMINAR PEDIDO" class="btn btn-danger btnElimina font-weight-bold">
									</div>

									<div class="col-sm-6 p-b-5">
										<input type="hidden" name="operacion" id="operacion" value="">
										<input type="button" onclick="goProductos()" value="SEGUIR AGREGANDO (Max. 14 productos por pedido)" class="btn btn-success font-weight-bold btnSeguirAgregando">
									</div>
								</div>


								<div class="row p-b-25">
									<?php
									// ********** CARGOS ADICIONALES ************
									switch($tiene_cargos) {
									    case 0:
									        // No lleva cargos, puede comprar o reservar
									?>
										<div class="col-sm-6 p-b-5">
											<input type="button" onclick="submitFormulario('reserva')" value="GENERAR RESERVA" class="btn btn-warning font-weight-bold btnReservar">
										</div>
										<div class="col-sm-6 p-b-5">
											<input type="button" onclick="submitFormulario('compra')" value="COMPRAR" class="btn btn-warning font-weight-bold btnComprar">
										</div>
									<?php
									break;
									
									case 1:
									case 2:
									    // Si lleva cargos o lleva a veces, solo se le muestra el boton de reservar
									?>
										<div class="col-sm-6 p-b-5">
										</div>
										<div class="col-sm-6 p-b-5 text-center">
											<!-- // EDITADO PARA DESACTIVAR OPERACIONES EN AÑO NUEVO -->
											<input type="button" onclick="submitFormulario('reserva')" value="GENERAR RESERVA" class="btn btn-warning font-weight-bold btnReservar">
										</div>
									<?php
									break;
									
									default:
									    echo '<div class="col-sm-6 p-b-5"></div>';
									    echo '<div class="col-sm-6 p-b-5"></div>';
									break;
									} // switch
									
									?>
								</div>
							</form>
							<?php } else {
								    echo '<h2 class="mtext-113">SU PEDIDO</h2>';
								    echo '<div class="alert alert-danger" role="alert"><div class="row">';
								    echo '<div class="text-center col-2 alert-icon-col"><span class="fa fa-cart-arrow-down fa-3x"></span></div> <span><i class=""></i></span>';
								    echo '<div class="col d-flex align-items-center"><span>Su pedido esta vacio.</span></div>';
								    echo '</div></div>';
								}
								break;
								
								case "success-envio":
								?>
							<div id="for_hecho">
								<div id="div_cuenta" class="text-center">
									<h3>Gracias por enviar su pedido. Lo invitamos a revisar su Correo Electr&oacute;nico</h3>
									<?php
										echo getConfig("cuentas_bancarias");
										?>
								</div>
							</div>
							<?php                                
								break;
								    
								case "error-envio":
								?>
							<div id="for_error" class="text-center">
								Ocurrio un error al enviar su pedido, intentelo de nuevo click <a href="pedido/carro">Aqui</a>
							</div>
							<?php                                
								break;
								
								case "reserva-enviada":
								?>
							<div id="for_hecho">
								<div id="div_cuenta" class="text-center">
									<h3 class="m-b-15 mtext-113">Se ha registrado la reserva de los productos elegidos</h3>
									<p>Recuerde que esto es una reserva, no una compra. Luego de realizado el pago ingrese a su listado de reservas y registre su compra ingresando los datos del pago</p>
									<p>Recuerde que tiene <?php echo getConfig("horas_duracion_reserva"); ?> horas para concretar su compra o su reserva se anulara.</p>
								</div>
							</div>
							<?php  
								break;
								
								case "error-reserva":
								?>
							<div class="text-center" id="for_error">
								Ocurrio un error al enviar su reserva y esta no pudo concretarse, intentelo de nuevo click <a href="pedido/carro">Aqui</a>
							</div>
							<?php
								break;
								
								}
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>