<?php
	$moneda = $this->session->userdata('moneda');
	switch($moneda) {
		case "d":
			$simbolo = 'US$';
			$tipo_cambio = getConfig("tipo_cambio_dolar");
		break;

		case "s":
			$simbolo = 'S/';
			$tipo_cambio = 1;
		break;
	}
?>
<section class="bg0 p-b-120" id="cuerpoSeccion">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="m-t-25 m-b-20 m-l-10 m-r-20 p-b-20">
					<div class="wrap-title-black">
						<h1 class="mtext-113"><?php echo $producto->nombre;?></h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<div class="row">
							<div class="col-md-6 col-lg-6 p-b-30">
								<div class="p-l-25 p-r-30 p-lr-0-lg" id="galeriaxColor">
									<div class="wrap-slick3 flex-sb flex-w">
										<div class="wrap-slick3-dots"></div>
										<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
										<div class="slick3 gallery-lb">
											<div class="item-slick3" data-thumb="files/productos/<?= $producto->imagen ?>">
												<div class="wrap-pic-w pos-relative">
													<img  src="files/productos/<?= $producto->imagen ?>" alt="<?= $producto->nombre ?>">
													<a data-fancybox class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="files/productos/<?= $producto->imagen ?>">
														<i class="fa fa-expand"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="p-l-25 p-r-30 p-lr-0-lg">
									<h3 class="mtext-113 m-t-20 m-b-10">Descripci&oacute;n</h3>
                                    <div class="sub_contenido"><?php echo $producto->descripcion;?></div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 p-b-30">
								<div class="p-l-25 p-r-30 p-lr-0-lg">
									<div id="top_info">
										<h3 class="mtext-113"><?php echo $producto->nombre;?></h3>
										<ul class="p-lr-28 p-lr-15-sm">
											<li class="flex-w flex-t p-b-7">
												<span class="stext-102 cl3 size-205">Código</span>
												<span class="stext-102 cl6 size-206"><?= $producto->codigo ?></span>
											</li>
											<?php if ($this->session->userdata('logueadocki')): ?>
												<?php if ($this->session->userdata('ver_precio')=='si'): ?>
													<?php foreach ($precios as $key => $value): ?>
														<?php 
															$precio = $value['precio'];
															$unidad = $value['unidad'];
															$precio_normal = $value['precio_normal'];
															switch($moneda) {
															    case "d":
															        $p2show = number_format(redondeado(($precio/$tipo_cambio), 3), 3, '.', '');
															    break;
									
															    case "s":
															        $p2show = number_format(redondeado($precio, 3), 3, '.', '');
															    break;
															} 
														?>
														<?php if ($value['tiene_descuento']=="si"): ?>
														<?php $precio_normal_2show = number_format(redondeado($precio_normal, 3), 3, '.', ''); ?>
														<li class="flex-w flex-t p-b-7">
															<span class="stext-102 cl3 size-205">Precio</span>
															<span class="stext-102 cl6 size-206"> <?= $simbolo.' '.$precio_normal_2show.' '.$unidad ?> </span>
														</li>
														<li class="flex-w flex-t p-b-7">
															<span class="stext-102 cl3 size-205"> Precio Dscto. </span>
															<span class="stext-102 cl6 size-206"> <?= $simbolo.' '.$p2show.' '.$unidad ?> </span>
														</li>
														<li class="flex-w flex-t p-b-7">
															<span class="burbujaIgv">PRECIOS INCLUYEN IGV</span>
														</li>
														<?php else: ?>
														<li class="flex-w flex-t p-b-7">
															<span class="stext-102 cl3 size-205"> Precio </span>
															<span class="stext-102 cl6 size-206"> <?= $simbolo.' '.$p2show.' '.$unidad ?> </span>
														</li>
														<li class="flex-w flex-t p-b-7">
															<span class="burbujaIgv">PRECIOS INCLUYEN IGV</span>
														</li>
														<?php endif ?>
													<?php endforeach ?>
												<?php endif ?>
											<?php endif ?>
										</ul>
										<!--<br />-->
									</div>
									<!--top_info-->
									<?php
									    if($resultado) {
									        switch($resultado) {
									            case "errorTipo":
									               echo '<div class="msgCarrito2 msgRojo clearfix">';
									                echo '<span><i class="fa fa-exclamation-triangle fa-5x"></i></span>';
									                echo '<p>No puede agregar ese producto a su reserva!.<br>';
									               echo 'Recuerde que solo puede agregar o productos en stock o productos que llegaran proximamente<br>pero no puede mezclarlos.</p></div>'; 
									            break;
									        }                                
									    }
									    ?>
									<h3 class="mtext-113 m-b-15 m-t-15">Colores disponibles</h3>
									<div class="colores-disponibles">
										<?php foreach ($colores as $key => $value): ?>
										<div class="div_colores" onclick="galeria_x_color('<?= $value['id'] ?>')" style="cursor:pointer;background:<?= $value['color'] ?>;" title="<?= $value['nombre'] ?>"></div>	
										<?php endforeach ?>
										<div class="clearfix"></div>
									</div>
									<h3 class="mtext-113 m-b-15 m-t-15">Agregar a carrito</h3>
									<div id="cabec_det" class="clearfix">
									    <div id="cab_color" style="width: 50px;">Color</div>
									    <!--cab_color-->
									    <?php if($producto->show_stock=='1') { ?>
									    <div id="cab_stock" style="width: 75px;">Stock</div>
									    <!--cab_stock-->
									    <?php } ?>
									    <div id="cab_pedido" style="width: 60px;">Pedido</div>
									    <!--cab_pedido-->
									</div>
									<form action="pedido/agregar" method="post" onSubmit="return validaAgregado()">
									    <div id="cont_colores" class='clearfix'>
									        <div class="clearfix">
									            <?php
									            //echo '<pre>';print_r($colores);echo '</pre>';
									                $cont=0;
									                $lista_ids = array();
									                for($y=0;$y<count($colores);$y++) {
														$curr = $colores[$y];
														$color = $curr['color'];
														$stock = $curr['stock'];
														$nombre = $curr['nombre'];                                    
														$id = $curr['id']; // ID de tabla stock_color (UNICO)
														$id_color = $curr['id_color'];
														$lista_ids[] = $id;
														echo '<div class="cont_col clearfix">';
														echo '<div class="div_colores" style="background:'.$color.';" title="'.$nombre.'"></div>';
														if($producto->show_stock=='1') {
															echo '<div class="div_stock"><p>'.number_format($stock,0, '.', ',').'</p></div>';
														}
														echo '<div class="cont_cant">';
														echo '<p><input type="text" name="cant_'.$id.'" id="cant_'.$id.'" onKeyPress="return checkIt(event)" class="campo_rojo" size="2"/></p>';
														echo '</div><!--cont_cant-->';
														echo '<div class="cont_unidd">';
														echo '<select id="uni_'.$id.'" name="uni_'.$id.'" class="campo">';
														for($g=0;$g<count($precios);$g++) {
															$current = $precios[$g];
															$unidad = $current['unidad'];
															$id_unidad = $current['id_unidad'];   
															$precio = $current['precio'];
															echo '<option value="'.$unidad.'()'.$id_unidad.'()'.$precio.'">'.$unidad.'</option>';
														}

														echo '</select>';
														echo '</div><!--cont_unidd-->';
														if( ($this->session->userdata('ver_precio')) && ($this->session->userdata('ver_precio') =='si') && ($id_categoria!=26) ) {
															echo '<div class="cont_bt_carro">';
															//echo '<a href="javascript:agregar_carrito('.$id.')"><img src="assets/frontend/cki/imagenes/boton_agrega.png" border="0" width="25" class="cursor"title="Agregar a Carrito"/></a>';
															echo '<input type="image" src="assets/frontend/cki/imagenes/boton_agrega_25.png">';
															echo '</div><!--cont_bt_carro-->';
														}
														echo '<input type="hidden" id="stock_'.$id.'" name="stock_'.$id.'" value="'.$stock.'"/>';
														echo '<input type="hidden" id="nombre_color_'.$id.'" name="nombre_color_'.$id.'" value="'.$nombre.'"/>';
														echo '<input type="hidden" id="color_'.$id.'" name="color_'.$id.'" value="'.$color.'"/>';
														echo '<input type="hidden" id="idColor_'.$id.'" name="idColor_'.$id.'" value="'.$id_color.'"/>';
														echo '</div>';
														$cont +=1;
									                } // for
									                ?>
									        </div>
									        <div>
												<input type="hidden" name="lista_ids" id="lista_ids" value="<?php echo implode("#", $lista_ids); ?>" />
												<input type="hidden" name="codigo" id="codigo" value="<?php echo $producto->codigo;?>" />
												<input type="hidden" name="nombre" id="nombre" value="<?php echo $producto->nombre;?>" />
												<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $producto->id_producto;?>" />
												<input type="hidden" name="dscto" id="dscto" value="<?php echo $producto->descuento;?>" />
												<input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo $id_categoria; ?>">
									        </div>
									    </div>
									    <!--cont_colores-->
									</form>
									<?php if(count($colores_prox)>0) { ?>
									<h3 class="mtext-113 m-t-15 m-b-15">Proximamente</h3>
									<p class="m-b-10">Los precios son referenciales y podrian variar por el tipo de cambio</p>
									<div id="divProximos" class="clearfix">
									    <form action="pedido/agregarProximamente" method="post" onSubmit="return validaAgregadoProx()">
									        <table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td width="15%" height="20" class="headerPedido" align="center" valign="middle">Color</td>
													<?php if($producto->show_stock=='1') { ?>
													<td width="15%" class="headerPedido" align="center" valign="middle">Stock</td>
													<?php } ?>
													<td width="20%" class="headerPedido" align="center" valign="middle">Precio</td>
													<td width="20%" class="headerPedido" align="center" valign="middle">Llegada</td>
													<td width="15%" class="headerPedido" align="center" valign="middle">Pedido</td>
													<td width="15%" class="headerPedido" align="center" valign="middle"></td>
												</tr>
												<?php
													$cont=0;
													$lista_ids_p = array();
													//var_dump($colores_prox);
													for($y=0;$y<count($colores_prox);$y++) {
														$curr = $colores_prox[$y];
														$color = $curr['color'];
														$stock_proximamente = $curr['stock_proximamente'];
														$nombre = $curr['nombre']; 
														$fecha_llegada = $curr['fecha_llegada'];
														$precio_proximamente = $curr['precio_proximamente'];
														if($this->session->userdata('moneda')=='d') {
															$t_c= getConfig("tipo_cambio_dolar");
															$precio_proximamente_2show = number_format(($precio_proximamente/$t_c), 3, '.', ',');
															$simbolo = 'US$';
														} else {
															$simbolo = 'S/';
															$precio_proximamente_2show = number_format($precio_proximamente, 3, '.', ',');
														}
														$id = $curr['id']; // ID de tabla stock_color (UNICO)
														$id_color = $curr['id_color'];
														$lista_ids_p[] = $id;
														if($stock_proximamente>0) {
															echo '<tr class="filaBlanca">';
									                            echo '<td height="25" align="center" valign="middle" style="padding-left:13px;"><div style="background:'.$color.'; border:1px solid #000;" title="'.$nombre.'" class="divColor"></div></td>';
									                            if($producto->show_stock=='1') {
									                                echo '<td align="center" valign="middle"><span class="celdaCantidad">'.number_format($stock_proximamente,0, '.', ',').'</span></td>';
									                            }
									                            if( ($this->session->userdata('ver_precio')) && ($this->session->userdata('ver_precio') =='si') && ($id_categoria!=26) ) {
									                                echo '<td align="center" valign="middle">';
									                                echo '<strong>'.$simbolo.' '.$precio_proximamente_2show.'</strong>';
									                                echo '</td><!--celdaDatoPedido-->';
									                
									                                echo '<td align="center" valign="middle">';
									                                    echo $fecha_llegada;
									                                echo '</td><!--celdaDatoPedido-->';
									                            
									                                
									                                if($precio_proximamente>0) {
									                                    echo '<td align="center" valign="middle">';
															echo '<input type="text" name="cant_p_'.$id.'" id="cant_p_'.$id.'" onKeyPress="return checkIt(event)" class="campoCant" size="2"/>';
									                                    echo '</td><!--cont_bt_carro-->';
									                                
									                                    echo '<td align="center" valign="middle" style="padding-top:6px;">';
															echo '<input type="image" src="assets/frontend/cki/imagenes/boton_agrega_25.png">';
									                                    echo '</td><!--cont_bt_carro-->'; 
									                                } else {
									                                    echo '<td></td>';
									                                    echo '<td></td>';
									                                }
																}
																echo '<input type="hidden" name="uni_p_'.$id.'" id="uni_p_'.$id.'" value="Unidad()3">';
																echo '<input type="hidden" id="stock_p_'.$id.'" name="stock_p_'.$id.'" value="'.$stock_proximamente.'"/>';
																echo '<input type="hidden" id="precio_p_'.$id.'" name="precio_p_'.$id.'" value="'.$precio_proximamente.'"/>';
																echo '<input type="hidden" id="nombre_color_p_'.$id.'" name="nombre_color_p_'.$id.'" value="'.$nombre.'"/>';
																echo '<input type="hidden" id="color_p_'.$id.'" name="color_p_'.$id.'" value="'.$color.'"/>';
																echo '<input type="hidden" id="idColor_p_'.$id.'" name="idColor_p_'.$id.'" value="'.$id_color.'"/>';
															echo '</tr>';
															
															echo '<tr>';
															    echo '<td colspan="6" height="8"></td>';
															echo '</tr>';
															$cont +=1;
														}
													} // for
												?>
											</table>
											<input type="hidden" name="lista_ids_prox" id="lista_ids_prox" value="<?php echo implode("#", $lista_ids_p); ?>" />
											<input type="hidden" name="codigo_p" id="codigo_p" value="<?php echo $producto->codigo;?>" />
											<input type="hidden" name="nombre_p" id="nombre_p" value="<?php echo $producto->nombre;?>" />
											<input type="hidden" name="id_producto_p" id="id_producto_p" value="<?php echo $producto->id_producto;?>" />
											<input type="hidden" name="dscto_p" id="dscto_p" value="<?php echo $producto->descuento;?>" />
											<input type="hidden" name="id_categoria_p" id="id_categoria" value="<?php echo $id_categoria; ?>">
										</form>
									</div>
									<?php } //if ?>
									<h3 class="mtext-113 m-t-15 m-b-15">Especificaciones</h3>
									<div id="cont_info_de">
										<ul>
											<?php if(!empty($producto->material)){?> 
												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205"> Material: </span>
													<span class="stext-102 cl6 size-206"><?php echo $producto->material;?></span>
												</li>
											<?php } ?>
											<!--<span><strong>Categor&iacute;a: </strong><?php echo $nombre_categoria;?></span><br>-->
											<?php if(!empty($producto->medidas)){?>
												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">Medidas Producto: </span>
													<span class="stext-102 cl6 size-206"><?php echo $producto->medidas;?></span>
												</li>
											<?php } ?>
											<?php if(!empty($producto->medidas_caja)){?>
												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">Medidas Caja: </span>
													<span class="stext-102 cl6 size-206"><?php echo $producto->medidas_caja;?></span>
												</li>
											<?php } ?>
											<?php if(!empty($producto->area_impresion)){?>
												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">Area de Impresi&oacute;n: </span>
													<span class="stext-102 cl6 size-206"><?php echo $producto->area_impresion;?></span>
												</li>
											<?php } ?>
											<?php if(!empty($producto->metodo_impresion)){?> 
												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">M&eacute;todo de Impresi&oacute;n: </span>
													<span class="stext-102 cl6 size-206"><?php echo $producto->metodo_impresion;?></span>
												</li>
											<?php } ?>
										</ul>
									</div>
									<!--cont_info_de-->
									<div id="fb-root"></div>
									<script>(function(d, s, id) {
										var js, fjs = d.getElementsByTagName(s)[0];
										if (d.getElementById(id)) return;
										js = d.createElement(s); js.id = id;
										js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
										fjs.parentNode.insertBefore(js, fjs);
										}(document, 'script', 'facebook-jssdk'));
									</script> 
									<div class="fb-like" data-href="<?php echo $base_url;?>detalle-producto/<?php echo $producto->id_producto;?>/<?php echo $url_nombre; ?>" data-send="false" data-width="150" data-show-faces="false"></div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="sec-relate-product bg0 p-t-45 p-b-105">
	<div class="container">
		<div class="p-b-45">
			<h3 class="ltext-106 cl5 txt-center">
				Productos Relacionados
			</h3>
		</div>
		<!-- Slide2 -->
		<div class="wrap-slick2">
			<div class="slick2">

				<?php foreach ($relacionados as $key => $value): ?>
				<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							<a href="detalle-producto/<?= $value['id_producto'];?>/<?= formateaCadena($value['nombre']);?>">
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
							<div class="block2-txt-child1 flex-col-l ">
								<a href="detalle-producto/<?= $value['id_producto'];?>/<?= formateaCadena($value['nombre']);?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
								<?= $value['nombre'] ?>
								</a>
							</div>
						</div>
					</div>
				</div>	
				<?php endforeach ?>

			</div>
		</div>
	</div>
</section>