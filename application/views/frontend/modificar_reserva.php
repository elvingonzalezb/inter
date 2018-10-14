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
						<h1 class="mtext-113">Modificar Reserva</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php
							if($resultado=="error-propietario") {
								echo '<div class="msgAlerta">';
								echo '<p>No puede modificar esta reserva porque le pertenece a otro cliente.</p>';
								echo '<a href="javascript:history.back(-1)">VOLVER</a>';
								echo '</div>';
							} else if($resultado=="error-stock") {
								echo '<div class="msgAlerta">';
								echo '<p>Uno de los productos en su reserva excede el stock para dicho item.</p>';
								echo '<a href="javascript:history.back(-1)">VOLVER</a>';
								echo '</div>';
							} else  {
						?>
							<h3 class="mtext-113">DATOS GENERALES</h3>
							<div class="">
								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="nombre">Nombre o Razón Social*:</label>
									</div>
									<div class="col-sm-8 p-b-5">
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20">
											<?php
												$nro_reserva = $orden->id_orden + 10000;
												echo $nro_reserva; 
											?>
										</span>
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="nombre">Fecha y hora de Ingreso:</label>
									</div>
									<div class="col-sm-8 p-b-5">
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20">
											<?php
												$aux_f = explode(" ", $orden->fecha_ingreso);
												$aux_f2 = explode("-", $aux_f[0]);
												$fecha_1 = $aux_f2[2]."-".$aux_f2[1]."-".$aux_f2[0];
												$fecha_orden = $fecha_1." ".$aux_f[1];
												echo $fecha_orden; 
											?>
										</span>
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="nombre">Fecha y hora de Caducidad:</label>
									</div>
									<div class="col-sm-8 p-b-5">
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20">
											<?php
												$caducidad = Ymd_2_dmYHora($orden->caducidad);
												echo $caducidad; 
											?>
										</span>
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="nombre">Tiempo Restante:</label>
									</div>
									<div class="col-sm-8 p-b-5">
											<?php
												$aux_hc = explode(" ", $orden->caducidad);
												$aux_hc_2 = explode("-", $aux_hc[0]);
												$aux_hc_3 = explode(":", $aux_hc[1]);
												$time_caducidad = mktime($aux_hc_3[0], $aux_hc_3[1], $aux_hc_3[2], $aux_hc_2[1], $aux_hc_2[2], $aux_hc_2[0]);
												$ahora = time();
												$diferencia = conversorSegundosHoras($time_caducidad - $ahora);
												echo $diferencia;  
											?>
									</div>
								</div>
							</div>
							<h3 class="mtext-113">PRODUCTOS RESERVADOS</h3>
							<p>Si desea eliminar uno te los items de su reserva cambie la cantidad de ese item a 0.<br>Recuerde que la cantidad máxima que puede reservar de cada item está indicada en la columna Stock Actual.</p>
							<form id="formPedido" action="frontend/reservas/actualizaReserva" method="post" onsubmit="return validaUpdateReserva()">
							<div class="tooltip-demo well">
								<div class="table-responsive">
									<table class="table" cellspacing="1">
										<thead>
											<tr>
												<th width="9%" class="encabezado_reserva">C&oacute;digo</th>
												<th width="21%" class="encabezado_reserva">Nombre del Producto</th>
												<th width="9%" class="encabezado_reserva">Color</th>
												<th width="15%" class="encabezado_reserva">Nombre Color</th>
												<th width="10%" class="encabezado_reserva">Cantidad</th>
												<th width="12%" class="encabezado_reserva">Stock Actual</th>
												<th width="12%" class="encabezado_reserva">Precio</th>                                    
												<th width="12%" class="encabezado_reserva">Subtotal</th>
											</tr>
										</thead>   
										<tbody>
										<?php
										$total = '';
										$tipo_reserva = $orden->tipo_reserva;
										$i=0;
										foreach($detalles as $detalle) {
											switch($orden->moneda) {
												case "s":
													$precio = $detalle->precio_soles;
													$simbolo = 'S/';
												break;
											
												case "d":
													$precio = $detalle->precio_dolares;
													$simbolo = 'US$';
												break;
											}
											$ci =& get_instance();
											$aux_stock = $ci->Reservas_model->stockProducto($detalle->id_producto, $detalle->id_color);
											switch($tipo_reserva) {
												case "stock":
													$stock = $aux_stock->stock;
												break;

												case "proximamente":
												   $stock = $aux_stock->stock_proximamente;
												break;
											} 
											$id_registro = $aux_stock->id;
											$st = $precio*($detalle->cantidad);
											$subtotal = redondeado($st, 3);
											$subtotal = number_format($subtotal, 3, '.', '');                             
											echo '<tr id="fila_'.$id_registro.'">';
											echo '<td align="center" class="datoReserva">'.$detalle->codigo_producto.'</td>';                        
											echo '<td align="center" class="datoReserva" id="nombre_'.$id_registro.'">'.$detalle->nombre_producto.'</td>';
											echo '<td align="center" class="datoReserva"><div style="background:'.$detalle->codigo_color.';margen:15px;width:30px;height:30px;border:#000 solid 1px;"></td>';
											echo '<td align="center" class="datoReserva" id="color_'.$id_registro.'">'.$detalle->nombre_color.'</td>';                                
											echo '<td align="center" class="datoReserva">';
											?>
											<input type="text" onKeyPress="return checkIt(event)" class="campo" name="cant_<?php echo $i;?>" id="cant_<?php echo $i;?>" size="5" value="<?php echo $detalle->cantidad; ?>" />

											<input type="hidden" name="id_detalle_<?php echo $i; ?>" id="id_detalle_<?php echo $i; ?>" value="<?php echo $detalle->id; ?>">
											<input type="hidden" name="stock_<?php echo $i; ?>" id="stock_<?php echo $i; ?>" value="<?php echo $stock; ?>">                                
											<input type="hidden" name="cant_actual_<?php echo $i; ?>" id="cant_actual_<?php echo $i; ?>" value="<?php echo $detalle->cantidad; ?>">  
											<input type="hidden" name="id_<?php echo $i; ?>" id="id_<?php echo $i; ?>" value="<?php echo $id_registro; ?>">
											<input type="hidden" name="id_producto_<?php echo $i; ?>" id="id_producto_<?php echo $i; ?>" value="<?php echo $detalle->id_producto; ?>">
											<input type="hidden" name="color_<?php echo $i; ?>" id="color_<?php echo $i; ?>" value="<?php echo $detalle->codigo_color; ?>">
											<input type="hidden" name="precio_<?php echo $i; ?>" id="precio_<?php echo $i; ?>" value="<?php echo $precio; ?>">
											<input type="hidden" name="codigo_<?php echo $i; ?>" id="codigo_<?php echo $i; ?>" value="<?php echo $detalle->codigo_producto; ?>">
											<input type="hidden" name="nombre_<?php echo $i; ?>" id="nombre_<?php echo $i; ?>" value="<?php echo $detalle->nombre_producto; ?>">
											<input type="hidden" name="subtot_<?php echo $i; ?>" id="subtot_<?php echo $i; ?>" value="<?php echo $subtotal; ?>">
											<input type="hidden" name="uni_<?php echo $i; ?>" id="uni_<?php echo $i; ?>" value="<?php echo $detalle->unidad; ?>">
											<input type="hidden" name="id_color_<?php echo $i; ?>" id="id_color_<?php echo $i; ?>" value="<?php echo $detalle->id_color; ?>">
											<?php
											echo '</td>';
											echo '<td align="center" class="datoReserva">'.$stock.'</td>'; 
											echo '<td align="center" class="datoReserva">'.$simbolo.' '.$precio.'</td>';
											echo '<td align="center" class="datoReserva">'.$simbolo.' '.$subtotal.'</td>';
											echo '</tr>';
											$total=$total + $subtotal;
											$i++;
										}
										$total = number_format($total, 3, '.', '');
										?>
										<tr>
											<td colspan="6" style="background:#eee; color:#000; font-weight:700;"></td>
											<td class="encabezado_reserva" style="font-size:12px;">SUBTOTAL</td>
											<td class="encabezado_reserva" style="font-size:12px;"><?php echo $simbolo.' '.$total; ?></td>
										</tr>
										</tbody>
									</table> 
								</div> 	
								<?php if( ($orden->lleva_cargos==1) && ($orden->tiene_cargos==1) ) { ?>
								<h3 class="h3Reserv">CARGOS ADICIONALES</h3>
								<div class="table-responsive">
									<table class="table" cellspacing="1">
											<thead>
												<tr>
													<th width="10%" class="encabezado_reserva">N</th>
													<th width="70%" class="encabezado_reserva">CONCEPTO</th>
													<th width="20%" class="encabezado_reserva">MONTO</th>
												</tr>
											</thead>   
											<tbody>
											<?php
												$j = 0;
												$total = $orden->total;
												$total_cargos = 0;
												foreach($cargos as $cargo) {
													echo '<tr>';
													echo '<td align="center" class="datoReserva">'.($i+1).'</td>';
													echo '<td align="left" class="datoReserva" style="padding-left:20px;">'.$cargo->concepto.'</td>';
													echo '<td align="center" class="datoReserva">'.$simbolo.' '.$cargo->monto.'</td>';
													echo '<tr>';
													$j++;
													$total_cargos += $cargo->monto;
													$total += $cargo->monto;
												}
											?>
												<tr>
													<td class="datoReserva"></td>
													<td class="datoReserva" align="right" style="padding-right:20px; font-weight:700;">SUBTOTAL</td>
													<td class="datoReserva" align="center"><?php echo $simbolo.' '.$total_cargos; ?></td>
												</tr>
												<tr>
													<td class="encabezado_reserva"></td>
													<td align="center" class="encabezado_reserva" style="font-size:16px;">TOTAL</td>
													<td class="encabezado_reserva" style="font-size:16px;"><?php echo $simbolo.' '.number_format($total, 3, '.', ''); ?></td>
												</tr>
											</tbody>
									</table>
								</div>
									
								<?php } ?>
							</div><!-- tooltip-demo well--> 
							<div id="botoneraDetalleCompra">
								<a href="javascript:history.back(-1)" class="btn btn-danger btn-sm">VOLVER AL LISTADO</a>
								<!--<a href="reservas/comprar/<?php echo $orden->id_orden; ?>" class="btnRojo">COMPRAR</a>-->
								   <input type="hidden" name="num_items" id="num_items" value="<?php echo $i; ?>">
								   <input type="hidden" name="id_reserva" id="id_reserva" value="<?php echo $orden->id_orden; ?>">
								   <button class="btn btn-primary btn-sm">ACTUALIZAR RESERVA</button>
							</div><!-- botoneraDetalleCompra --> 
						</form>
						<?php } ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>