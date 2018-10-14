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
						<h1 class="mtext-113">Inventario</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php if ($this->session->userdata('ver_inventario')): ?>
							<?php if ($this->session->userdata('ver_inventario')=='si'): ?>
								<div class="sub_contenido">
									<h3 class="mtext-113">Descargar Inventario</h3>
									Desde aqui usted podra realizar la descarga de nuestro Inventario.
									<a href='exportar/excel' title='Descargar Inventario'><img style='margin-left:20px;' src='assets/frontend/cki/imagenes/download.png' align='absmiddle'border='0'/></a>
								</div>	
							<?php else: ?>
								Usted no tiene Acceso a la descarga del Inventario, comuniquese con nuestro administrador, click <a href="'.base_url().'contactenos">Aqui</a>
							<?php endif ?>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>