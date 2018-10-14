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
						<h1 class="mtext-113">PROXIMOS INGRESOS</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php 
						$fecha_current = '0000-00-00';
						if (count($productos)>0): ?>
						<?php foreach ($productos as $key => $value): ?>
							<?php 
							$fecha_llegada = $value['fecha_llegada'];
							$url_prod = 'detalle-producto/'.$value['id_producto'].'/'.$value['url_nom'];
							if ($fecha_llegada != $fecha_current): ?>
								<div><h2 class="mtext-113 p-b-25"> <?=formatoFechaProximamente($fecha_llegada) ?> </h2></div>
								<div class="row isotope-grid"> 
							<?php endif ?>
							<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
								<div class="block2">
									<div class="block2-pic hov-img0">
										<a href="<?= $url_prod ?>">
										<?php 
											$imagen =$value['imagen'];
											if( (isset($imagen)) && (is_file('files/productos_thumbs/'.$imagen)) ) {
												$img = getimagesize('files/productos_thumbs/'.$imagen);
												$ancho = (int)($img[0]/1);
												$alto = (int)($img[1]/1);
												echo '<img src="files/productos_thumbs/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
											} else {
												$img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
												$ancho = (int)($img[0]/1);
												$alto = (int)($img[1]/1);							
												echo '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
											}
										 ?>
										
										</a>
									</div>
								</div>
								<div class="block2-txt flex-w flex-t p-t-14">
									<a class="font-weight-bold stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" href="<?= $url_prod ?>"> <?= $value['codigo'] ?> </a>
								</div>
								<!-- <a href="<?= $url_prod ?>">Detalle</a> -->
							</div>
							<?php if ($fecha_llegada != $fecha_current): ?>
							</div>
							<?php endif ?>
						<?php endforeach ?>
						<?php else: ?>
							No tenemos productos disponibles para esta Categoría.
						<?php endif ?>

						<div class=" clearfix">
							<nav aria-label="pagination example" class="paginacion clearfix">
				                <ul class="pagination pg-blue">
				                <?php
				                for($w=1;$w<=$numero_paginas;$w++) {
				                    if($w==$pagina_actual) {
				                        echo '<li class="page-item"><a href="proximosIngresos/'.$w.'" class="page-link active" >'.$w.'<span class="sr-only">(current)</span></a></li>';
				                    } else {
				                        echo '<li class="page-item"><a href="proximosIngresos/'.$w.'" class="page-link" >'.$w.'</a></li>';
				                    }
				                }
				                ?>
				                </ul>
			            	</nav>
			            </div><!--paginacion-->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>