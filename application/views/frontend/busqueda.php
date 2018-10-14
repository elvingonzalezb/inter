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
						<h1 class="mtext-113">Búsqueda de Producto</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<form action="busqueda/buscar/1" method="post" onsubmit="return valida_busqueda()">
							<div class="row p-b-25">
								<div class="col-sm-3 p-b-5">
									<label class="stext-102 cl3" for="categoria">Categor&iacute;a</label>
									<select class="size-111 bor8 stext-102 cl2 p-lr-20" name="categoria" id="categoria">
										<option value="0">Seleccione...</option>
										<?php foreach ($categorias as $key => $value) {
											$nombre_categoria=$value['nombre_categoria'];
											$id_categoria=$value['id_categoria'];
											$url_nombre=formateaCadena($value['nombre_categoria']);
											if(($this->session->userdata('categoria'))==$id_categoria){
												echo '<option value="'.$id_categoria.'" selected>'.$nombre_categoria.'</option> ';
											}else{
												echo '<option value="'.$id_categoria.'" >'.$nombre_categoria.'</option> ';
											}
										}?>
									</select>
								</div>

								<div class="col-sm-3 p-b-5">
									<label class="stext-102 cl3" for="nombre">Nombre</label>
									<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre');?>"/>
								</div>
								<div class="col-sm-3 p-b-5">
									<label class="stext-102 cl3" for="codigo">C&oacute;digo</label>
									<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="codigo" id="codigo" value="<?php echo $this->session->userdata('codigo');?>"/>
									<input type="hidden" name="oculto" value="oculto" />
								</div>

								<div class="col-sm-3 p-b-5">
									<label class="stext-102 cl3">&nbsp;&nbsp;</label>
									<button class="btn btn-primary">Buscar</button>
								</div>
							</div>
						</form>

						<?php if(isset($productos)){ ?>
						<div class="clearfix">
							<nav aria-label="pagination example" class="paginacion clearfix">
		                		<ul class="pagination pg-blue">
			                        <?php for($w=1;$w<=$numero_paginas;$w++){
			                            if($w==$pagina_actual){
			                                echo '<li class="page-item"><a href="productos/'.$w.'" class="page-link active">'.$w.'<span class="sr-only">(current)</span></a></li>';
			                            }else{
			                                echo '<li class="page-item"><a href="productos/'.$w.'" class="page-link">'.$w.'</a></li>';
			                            }
			                        }?>
			                    </ul>
		                	</nav>
						</div>
						<!--paginacion-->
						<div class="sub_contenido clearfix">
							<div class="row isotope-grid">
								<?php foreach ($productos as $key => $value): ?>
								<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
									<div class="block2">
										<div class="block2-pic hov-img0">
											<a href="detalle-producto/<?= $value['id_producto'];?>/<?= $value['url_nom'];?>">
											<?php
												$imagen=$value['imagen'];
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
										<div class="block2-txt flex-w flex-t p-t-14">
											<a class="font-weight-bold stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" href="detalle-producto/<?= $value['id_producto'];?>/<?= $value['url_nom'];?>"><?= $value['codigo'];?></a>
										</div>  
									</div>
								</div>
								<?php endforeach ?>
							</div>
							

						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>