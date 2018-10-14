<?php
    switch($moneda)
    {
        case "s":
            $simbolo = 'S/';
        break;
    
        case "d":
            $simbolo = 'US$';
        break;
    }
    $procedencia = $this->session->userdata('procedencia');
?>
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
						<h1 class="mtext-113">FORMULARIO DE COMPRA</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php
							if($resultado==0) {
								echo '<div class="msgAlerta">';
								echo '<p>No puede realizar la compra porque una de las reservas le pertenece a otro cliente.</p>';
								echo '<a href="javascript:history.back(-1)">VOLVER</a>';
								echo '</div>';
							} else {
						?>
						<div id="formularioCompra">
							<!-- <h2>Formulario de Compra </h2> -->
							<form method="post" action="reservas/doCompraMultiple" onsubmit="return valida_compra()">
								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="nombre">CODIGOS DE RESERVAS</label>
									</div>
									<div class="col-sm-8 p-b-5">
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20"><?php echo $codigos; ?></span>
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="cargo">MONTO TOTAL A PAGAR</label>
									</div>

									<div class="col-sm-8 p-b-5">
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20"><?php echo $simbolo.' '.$monto_total; ?></span>
									</div>
								</div>

								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="forma_pago">FORMA DE PAGO</label>
									</div>
							
									<div class="col-sm-8 p-b-5">
										<select class="size-111 bor8 stext-102 cl2 p-lr-20" name="forma_pago" id="forma_pago" onchange="showOpcionesCompra(this.value)">
											<option value="0">Elija...</option>
											<option value="transferencia">Transferencia Bancaria</option>
											<option value="deposito">Deposito Bancario</option>
											<?php 
												if($datosCliente->tiene_credito=="Si") {
													echo '<option value="credito">Credito ('.$datosCliente->plazo_credito.' dias)</option>';
												}
												if($orden->total<=300) {
													echo '<option value="efectivo">Pago en Efectivo</option>';
												}
												if($procedencia=="Extranjero") {
													echo '<option value="JETPERU">JETPERU</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="filaOculta grp_1 p-b-25">
									<div class="row">
										<div class="col-sm-4 p-b-5">
											<label class="stext-102 cl3" for="banco">BANCO</label>
										</div>
								
										<div class="col-sm-8 p-b-5">
											<select class="size-111 bor8 stext-102 cl2 p-lr-20" name="banco" id="banco">
												<option value="0">Elija...</option>
												<option value="BCP">Banco BCP  del Peru (Cuenta en Soles 193-1611195096)</option>
												<option value="BANBIF">Banco BANBIF (Cuenta en Soles 7000469684)</option>
												<option value="BBVA">Banco Continental  del Peru (Cuenta en Soles 0140-0100029016)</option>
											</select>
										</div>
									</div>
								</div>


								<div class="filaOculta grp_2 p-b-25">
									<div class="row">
										<div class="col-sm-4 p-b-5">
											<label class="stext-102 cl3" for="numero_operacion">NUM. OPERACION</label>
										</div>

										<div class="col-sm-8 p-b-5">
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="numero_operacion" type="text" name="numero_operacion">
										</div>
									</div>
									
								</div>

								<div class="filaOculta grp_3 p-b-25">
									<div class="row">
										<div class="col-sm-4 p-b-5">
											<label class="stext-102 cl3" for="fecha_pago">FECHA DE PAGO</label>
										</div>

										<div class="col-sm-8 p-b-5">
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="fecha_pago" onkeypress="return false;" size="10" placeholder="dd/mm/aaaa" id="fecha_pago" autocomplete="off">
										</div>
									</div>
									
								</div>


								<div class="row p-b-25">
									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3" for="observaciones">OBSERVACIONES</label>
									</div>
									<div class="col-sm-8 p-b-5">
										<textarea class="size-111 bor8 stext-102 cl2 p-lr-20" name="observaciones" rows="4" cols="40" id="observaciones"></textarea>
									</div>
								</div>
								<input type="hidden" name="id_reserva" id="id_reserva" value="<?php echo $ids_reservas; ?>">
							    <a href="reservas/listado/1" class="btn btn-primary btn-sm">VOLVER AL LISTADO</a>&nbsp;&nbsp;&nbsp;&nbsp;
							    <!-- // EDITADO PARA DESACTIVAR OPERACIONES EN AÑO NUEVO -->
							    <!-- <input type="submit" value="COMPRAR" class="btn btn-danger btn-sm"> -->
							    <button class="btn btn-danger btn-sm">COMPRAR</button>

							</form>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>