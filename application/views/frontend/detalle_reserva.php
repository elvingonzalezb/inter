<section class="bg0 p-b-120" id="cuerpoSeccion">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="side-menu">
					<div class="p-t-5">
						<?php //echo $izquierda;?>
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
				<div class="p-t-25 p-b-20 p-l-10 p-r-20">
					<div class="wrap-title-black">
						<h1 class="mtext-113">Detalle de Reserva</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php
						if($resultado==0) {
							echo '<div class="msgAlerta">';
							echo '<p>No puede ver los detalles de esa reserva porque le pertenece a otro cliente.</p>';
							echo '<a href="javascript:history.back(-1)">VOLVER</a>';
							echo '</div>';
						} else  {     
						?>
						<h3 class="mtext-113 p-b-10">DATOS DE LA RESERVA</h3>
						<div class="row p-b-25">
							<div class="col-sm-4 p-b-5">
								<label class="stext-102 cl3" for="nombre">Nro. de Reserva:</label>
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
								<label class="stext-102 cl3" for="nombre">Tipo de Reserva:</label>
							</div>
							<div class="col-sm-8 p-b-5">
								<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20">
									<?php
										switch($orden->tipo_reserva) {
											case "stock":
												echo '<strong>Reserva de productos en Stock</strong>';
											break;
										
											case "proximamente":
												echo '<strong>Reserva de productos proximos a llegar</strong>';
											break;
										}
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
						<h3 class="mtext-113">PRODUCTOS RESERVADOS</h3>
						<div class="tooltip-demo well">
							<div class="table-responsive">
								 <table class="table" cellspacing="1">
									<thead>
										<tr>
										<?php
										switch($orden->tipo_reserva) {
											case "stock":
										?>
										<th width="5%" class="encabezado_reserva">C&oacute;digo</th>
										<th width="20%" class="encabezado_reserva">Nombre del Producto</th>
										<th width="10%" class="encabezado_reserva">Color</th>
										<th width="15%" class="encabezado_reserva">Nombre Color</th>
										<th width="15%" class="encabezado_reserva">Cantidad</th>
										<th width="15%" class="encabezado_reserva">Precio</th>                                    
										<th width="20%" class="encabezado_reserva">Subtotal</th>                                    
										<?php
											break;
										
											case "proximamente":
										?>
										<th width="5%" class="encabezado_reserva">C&oacute;digo</th>
										<th width="20%" class="encabezado_reserva">Nombre del Producto</th>
										<th width="10%" class="encabezado_reserva">Color</th>
										<th width="15%" class="encabezado_reserva">Nombre Color</th>
										<th width="12%" class="encabezado_reserva">Fecha Llegada</th>
										<th width="12%" class="encabezado_reserva">Cantidad</th>
										<th width="12%" class="encabezado_reserva">Precio</th>                                    
										<th width="14%" class="encabezado_reserva">Subtotal</th>                                    
										<?php
											break;
										}                        
										?>
										</tr>
									</thead>   
									<tbody>
									<?php
									$total = '';
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
										$st = $precio*($detalle->cantidad);
										$subtotal = redondeado($st, 3);
										$subtotal = number_format($subtotal, 3, '.', '');
										echo '<tr>';
										echo '<td align="center" class="datoReserva">'.$detalle->codigo_producto.'</td>';                        
										echo '<td align="center" class="datoReserva">'.$detalle->nombre_producto.'</td>';
										echo '<td align="center" class="datoReserva"><div style="background:'.$detalle->codigo_color.';margen:15px;width:30px;height:30px;border:#000 solid 1px;"></td>';
										echo '<td align="center" class="datoReserva">'.$detalle->nombre_color.'</td>';
										if($orden->tipo_reserva=="proximamente") {
											$ci =& get_instance();
											$fecha_llegada = $ci->Reservas_model->getFechaLlegada($detalle->id_producto, $detalle->id_color);
											echo '<td align="center" class="datoReserva">'.Ymd_2_dmY($fecha_llegada).'</td>';
										}
										echo '<td align="center" class="datoReserva">'.$detalle->cantidad.'</td>';
										echo '<td align="center" class="datoReserva">'.$simbolo.' '.$precio.'</td>';                                
										echo '<td align="center" class="datoReserva">'.$simbolo.' '.$subtotal.'</td>';
										echo '</tr>';
										$total = $total + $st;
									}
									$total = number_format(redondeado($total, 3), 3, '.', '');
									?>
									<tr>
										<td colspan="<?php if($orden->tipo_reserva=="proximamente") echo '6'; else echo '5'; ?>"></td>
										<td class="encabezado_reserva" style="font-size:14px;">SUBTOTAL</td>
										<td class="encabezado_reserva" style="font-size:14px;"><?php echo $simbolo.' '.$total; ?></td>
									</tr>
									</tbody>
								 </table>
							</div>  
							<?php if( ($orden->lleva_cargos>0) && ($orden->tiene_cargos==1) ) { ?>
								<h3 class="mtext-113">CARGOS ADICIONALES</h3>
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
											$i = 0;
											$total_cargos = 0;
											foreach($cargos as $cargo) {
												echo '<tr>';
												echo '<td align="center" class="datoReserva">'.($i+1).'</td>';
												echo '<td align="left" class="datoReserva" style="padding-left:20px;">'.$cargo->concepto.'</td>';
												echo '<td align="center" class="datoReserva">'.$simbolo.' '.$cargo->monto.'</td>';
												echo '</tr>';
												$i++;
												$total_cargos += $cargo->monto;
											}
										?>
											<tr>
												<td class="datoReserva"></td>
												<td class="datoReserva" align="right" style="padding-right:20px; font-weight:700;">SUBTOTAL</td>
												<td class="datoReserva" align="center"><?php echo $simbolo.' '.$total_cargos; ?></td>
											</tr>
										<?php
											$total = $total + $total_cargos;
											$total_general = number_format(redondeado($total,3), 3, '.', '')
										?>
											<tr>
												<td class="encabezado_reserva"></td>
												<td align="center" class="encabezado_reserva" style="font-size:16px;">TOTAL</td>
												<td class="encabezado_reserva" style="font-size:16px;"><?php echo $simbolo.' '.$total_general; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							<?php } ?>
						</div><!-- tooltip-demo well--> 
						<div id="botoneraDetalleCompra">
							<a href="javascript:history.back(-1)" class="btnRojo">VOLVER AL LISTADO</a>
							<a href="javascript:printReserva(<?php echo $orden->id_orden; ?>)" class="btnRojo">IMPRIMIR</a>
						<?php
						if($orden->estado==="Activa") {
							switch($orden->lleva_cargos) {
								case 0:
									// No lleva cargos
									echo '<a class="btnRojo" href="reservas/comprar/'.$orden->id_orden.'">COMPRAR</a><br>';
								break;
							
								case 1:
									// Esta obligado a tener cargos y si los tiene agregados
									if($orden->tiene_cargos==1) {
										echo '<a class="btnRojo" href="reservas/comprar/'.$orden->id_orden.'">COMPRAR</a><br>';
									}
								break;
							
								case 2:
									// Puede o no llevar cargos extra
									if($orden->tiene_cargos==1) {
										echo '<a class="btnRojo" href="reservas/comprar/'.$orden->id_orden.'">COMPRAR</a><br>';
									}
								break;
							} // switch
						}
						?>
						</div><!-- botoneraDetalleCompra -->               
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>