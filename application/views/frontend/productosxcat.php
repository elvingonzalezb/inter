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
				<div class="p-t-15 p-b-20 p-l-10 p-r-20">
					<div class="wrap-title-black">
						<h1 class="mtext-113">Categoría:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nombre_categoria; ?></h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php foreach ($subcategorias as $key => $value): ?>
						<?php 
							$numero_productos = $value['numero_productos'];
							$productos = $value['productos'];
						if ($numero_productos>0): ?>
						<div><h2 class="mtext-113"><?=$value['nombre'] ?></h2></div>
						<div class="row isotope-grid">
							<?php foreach ($productos as $key2 => $value2): ?>
							<?php $url = 'detalle-producto/'.$value2['id_producto'].'/'.$value2['url_nom']; ?>
							<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
								<div class="block2">
									<div class="block2-pic hov-img0">
										<a href="<?=$url?>">
											<?php
												$imagen = $value2['imagen'];
												if( (isset($imagen)) && (is_file('files/productos_thumbs/'.$imagen)) ) {
													$img = getimagesize('files/productos_thumbs/'.$imagen);
													$ancho = (int)($img[0]/1);
													$alto = (int)($img[1]/1);
													echo '<img src="files/productos_thumbs/'.$imagen.'" width="'.$ancho.'" alt="'.$value['nombre'].'" height="'.$alto.'" border="1"/>';
												} else {
													$img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
													$ancho = (int)($img[0]/1);
													$alto = (int)($img[1]/1);             
													echo '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
												}
												?>
											<!-- <img src="files/categorias/" alt="<?//= $value['nombre'] ?>"> -->
										</a>
									</div>
									<div class="block2-txt flex-w flex-t p-t-14">
										<a href="<?=$url?>" class="font-weight-bold stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"><?= $value2['nombre'] ?></a>
									</div>
								</div>
							</div>
							<?php endforeach ?>
						</div>
						<?php else: ?>
							<div><p>No se encontró resultados, para esta categoria.</p></div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>