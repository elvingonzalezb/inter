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
						<h1 class="mtext-113"><?php echo $getInfo->titulo; ?></h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<div class="sub_contenido">
		                    <?php echo $getInfo->texto; ?>
		                </div><!--texto-->
		                <div class="row isotope-grid">
		                    <?php
		                    $num_prod=count($productos);
		                    for($e=0;$e<$num_prod;$e++) {
		                      $current=$productos[$e];
		                      //$id_producto=$current['id_producto'];                        
		                      //$nombre=$current['nombre'];
		                      
		                      //$codigo=$current['codigo'];					  
		                      //$url_nom=$current['url_nom'];
		                        ?>
		                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
									<div class="block2">
		                              	<div class="block2-pic hov-img0">
		                              		<a href="detalle-producto/<?php echo $current['id_producto'];?>/<?php echo $current['url_nom'];?>">
		                                      <?php
		                                      	$imagen=$current['imagen'];
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
		                                	<a class="font-weight-bold stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" href="detalle-producto/<?php echo $current['id_producto'];?>/<?php echo $current['url_nom'];?>"><?php echo $current['codigo'];?></a>
		                              	</div>  
		                            </div>
		                              <!--tit_prodt_info-->
		                              <!-- <a href="detalle-producto/<?php echo $current['id_producto'];?>/<?php echo $current['url_nom'];?>">Detalle</a> -->
		                        </div>
		                    <?php } ?>        
		                </div>
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
		                    
		                </div><!--paginacion-->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>