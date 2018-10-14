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
			<?php if ($this->session->userdata('logueadocki')): ?>
			<div class="col-md-9">
			<?php else: ?>
			<div class="col-md-7">
			<?php endif ?>
				<?php if($tipo_banner=="clientes"){
					echo $banners;
					} else {
					echo $banners;
					} ?>
				<div class="p-t-25 p-b-20 p-l-10 p-r-20">
					<?php if ($this->session->userdata('logueadocki')): ?>
						<div class="welcomemsg border border-secondary rounded m-b-20"> Bienvenido: <?=$this->session->userdata('ses_razon') ?>. Use el menu superior para descargar el inventario actualizado o cerrar sesión.</div>
						<div class="wrap-title-black">
							<h1 class="mtext-113">Categorias</h1>
						</div>
						<div id="contentCat" class="container m-t-20 p-t-25" style="min-height: 200px;">
						</div>
						<script type="text/javascript">
							$(document).ready(function() {    
							    $('#contentCat').on('click', '.paginateCat' ,function(){

							        $('#contentCat').html('<div style="text-align: center;"><img src="assets/frontend/cki/imagenes/loading.gif" width="70px" height="70px"/></div>');

							        var page = $(this).attr('data');        
							        var dataString = 'page='+page;
							        $.ajax({
							            type: "GET",
							            url: "frontend/inicio/ajax_categorias",
							            data: dataString,
							            success: function(data) {
							            	console.log(data);
							                $('#contentCat').fadeIn(1000).html(data);
							            }
							        });
							    });
							    $( "#contentCat" ).load( "frontend/inicio/ajax_categorias" );
							});    
						</script>
					<?php else: ?>
					<div class="container">
						<form class="form-horizontal" role="form" method="POST" action="ingresar/logueo" onSubmit="return valida_log()">
							<div class="row">
								<div class="col-md-6">
									<h5 class="mtext-113 cl2 p-b-12">
										Ingreso de Usuarios
									</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-lg-6 col-xl-5">
									<div class="form-group has-danger">
										<label class="sr-only" for="usuario_ini">Usuario</label>
										<div class="input-group mb-2 mr-sm-2 mb-sm-0">
										    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
										    <input type="text" name="usuario" class="form-control" id="usuario_ini"
										           placeholder="tu@correo.com" required autofocus>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-lg-6 col-xl-5">
									<div class="form-group">
										<label class="sr-only" for="password">Password</label>
										<div class="input-group mb-2 mr-sm-2 mb-sm-0">
										    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
										    <input type="password" name="password" class="form-control" id="password_ini"
										           placeholder="Password" required>
										</div>
									</div>
								</div>
								<div class="col-2">
									<button type="submit" class="btn btn-success" id="btnEnviar"><i class="fa fa-sign-in"></i> Enviar</button>
								</div>
								<div class="col-sm-10 col-lg-10 col-xl-6">
									<div class="clearfix"></div>
										<?= $recaptcha?>
									<div class="clearfix"></div>
								</div>
								<div class="col-sm-12 col-lg-12 col-xl-6">
									<a class="font-weight-bold" href="recordar-contrasena">Recordar contraseña</a>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<hr>
									<h5 class="mtext-113 cl2 p-b-12">
										Nuevos Usuarios
									</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group has-danger">
										<a href="registrese" class="btn btn-info">Registrarse</a>
									</div>
								</div>
							</div>
						</form>
					</div>
					
					<div class="container border p-t-20">
						<div class="p-b-10">
							<h1 class="nice-title mtext-113"><?php echo $contenido->titulo; ?></h1>
						</div>
						<div class="p-b-35">
							<div class="sub_contenido">
								<?php echo $contenido->texto; ?>
							</div>
						</div>
					</div>
				    <?php endif ?>
				</div>
			</div>
			<?php if (!$this->session->userdata('logueadocki')): ?>
			<div class="col-md-2">
				<div class="sidebar-rigth">
					<h1 class="mtext-113">Próximos</h1>
					<div class="wrap-slick4 ">
						<div class="slick4">

							<?php foreach ($proximos as $key => $proximo): ?>
								<?php $url_prod = 'detalle-producto/'.$proximo['id_producto'].'/'.$proximo['url_nom']; ?>
							<div class="item-slick4 p-l-10 p-r-10 p-t-15 p-b-15">
								<!-- Block2 -->
								<div class="block2">
									
									<div class="block2-pic hov-img0">
										<img src="files/productos_thumbs/<?=$proximo['imagen']?>" alt="<?=$proximo['nombre']?>" border="1"/>

										<a href="<?=$url_prod?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
											Detalle
										</a>
									</div>

									<div class="block2-txt flex-w flex-t p-t-14">
										<div class="block2-txt-child1 flex-col-l ">
											<a href="<?=$url_prod?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
												<?=$proximo['nombre']?>
											</a>
										</div>
									</div>

								</div>
							</div>	
							<?php endforeach ?>

						</div>
					</div>
				</div>
				
			</div>
			<?php endif ?>
		</div>
	</div>
</section>