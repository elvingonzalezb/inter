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
					<!-- <div class="welcomemsg border border-secondary rounded m-b-20"> Bienvenido: <?=$this->session->userdata('ses_razon'); ?>. Use el menu superior para descargar el inventario actualizado o cerrar sesión.</div> -->
					<h1 class="mtext-113" id="abcdefg">Listado de vendedores</h1>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<div id="formularioCompra">
							<h2 class="mtext-109 p-b-10">Nuevo Vendedor</h2>
							<?php if( $this->session->flashdata('errorRegistro') ) {
								$msg = $this->session->flashdata('errorRegistro');
								echo '<div class="msgAlerta">'.$msg.'</div>';
							} ?>
							<form class="w-full" method="post" action="vendedores/grabar" onsubmit="return valida_vendedor()">

								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="nombre">Nombre</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="nombre" type="text" name="nombre" size="60">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="cargo">Cargo</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="cargo" type="text" name="cargo" size="60">
									</div>
								</div>

								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="telefono">Teléfono</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="telefono" type="text" name="telefono">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="cargo">Email</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email" size="60">
									</div>
								</div>

								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="telefono">Clave</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="clave" type="password" name="clave">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="ver_precio">Permitir ver precios?</label>
										<input type="radio" name="ver_precio" value="si" checked> SI
										<input type="radio" name="ver_precio" value="no"> NO
										<!-- <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email" size="60"> -->
									</div>
								</div>
								
								<!-- <input type="submit" value="GRABAR" class="boton_compra flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10"> -->
								<button class="stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10"> GRABAR </button>&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="vendedores/listado" class="btnComprar">VOLVER AL LISTADO</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>