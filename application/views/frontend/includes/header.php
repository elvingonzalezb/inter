<?php $carrito=$this->session->userdata('carrito');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo getConfig("titulo_web")?></title>
		<base href="<?php echo base_url(); ?>" />
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--===============================================================================================-->  
		<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/bootstrap/css/bootstrap.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/fonts/iconic/css/material-design-iconic-font.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/fonts/linearicons-v1.0.0/icon-font.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/animate/animate.css">
		<!--===============================================================================================-->  
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/css-hamburgers/hamburgers.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/animsition/css/animsition.min.css">
		<!--===============================================================================================-->
		<!-- <link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/select2/select2.min.css"> -->
		<!--===============================================================================================-->  
		<!-- <link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/daterangepicker/daterangepicker.css"> -->
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/slick/slick.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" href="assets/frontend/cki/css/jquery.fancybox.min.css" />
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/vendor/perfect-scrollbar/perfect-scrollbar.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/css/util.css">
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/css/main.css">
		<link rel="stylesheet" href="assets/frontend/cki/css/jquery-ui.css">
    	<link rel="stylesheet" href="assets/frontend/cki/css/jquery-ui.theme.css">
		<link rel="stylesheet" type="text/css" href="assets/frontend/cki/css/custom.css">

		<!--===============================================================================================-->
		<!--===============================================================================================-->	
		<script src="assets/frontend/cki/vendor/jquery/jquery-3.2.1.min.js"></script>
	</head>
	<body class="animsition">
		<!-- Header -->
		<header>
			<?php $carSession = $this->session->userdata('carrito'); ?>
			<!-- Header desktop -->
			<div class="container-menu-desktop">
				<div class="top-bar datosTienda">
					<div class="content-topbar flex-sb-m h-full container">
							<div class="col-sm-6 col-lg-3">
								<a href="#" class="logo">
									<img src="assets/frontend/cki/imagenes/logo_cki.png" alt="LOGO CKI">
								</a>
							</div>
							<div class="col-sm-6 col-lg-3">
								<div class="white-line">Llámenos al <strong><?php echo $telefono;?></strong></div>
								<div class="pink-line">Horario: <?php echo $horario;?></div>
							</div>
							<div class="col-sm-6 col-lg-3">
								<?php echo getConfig("direccion"); ?>
							</div>
							<div class="col-sm-6 col-lg-3">
								<div id="cart" class="zmdi zmdi-shopping-cart flex-w h-full">
									<div id="cart-text">SU PEDIDO <br>
									Total: <a href="pedido/carro" class="items" id="a_de_carrito"><?= count($carSession) ?> items</a>
									</div>
								</div>
							</div>
					</div>
				</div>
				<div class="wrap-menu-desktop">
					
					<nav class="limiter-menu-desktop container">
						<!-- Logo desktop -->   
						<!-- <a href="#" class="logo">
						<img src="assets/frontend/cki/imagenes/logo_cki.png" alt="LOGO CKI">
						</a> -->
						<!-- Menu desktop -->
						<div class="menu-desktop">
							<ul class="main-menu">
								<?php echo $menu;?>
							</ul>
						</div>
						<!-- Icon header -->
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" id="cart-icon" data-notify="<?= count($carSession) ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
					</nav>
					<div class="menuUsuario">
						<div class="container">
							<?php if ($this->session->userdata('logueadocki')): ?>
								<div class="right-top-bar flex-w h-full">
								<a href="javascript:void();" class="flex-c-m trans-04 p-tb-5 p-lr-25" style="cursor: default;text-decoration: none;">
									Bienvenido: <?=$this->session->userdata('ses_razon')?>
								</a>
								<a href="reservas/listado/1" class="flex-c-m trans-04 p-tb-5 p-lr-25">
									RESERVAS
								</a>
								<a href="compras/listado/1" class="flex-c-m trans-04 p-tb-5 p-lr-25">
									HISTORIAL
								</a>
								<?php if ($this->session->userdata('nivel')=="administrador"): ?>
									<a href="vendedores/listado" class="flex-c-m trans-04 p-tb-5 p-lr-25">VENDEDORES</a>
								<?php endif ?>
								<a href="mis-datos/actualizacion" class="flex-c-m trans-04 p-tb-5 p-lr-25">
									MIS DATOS
								</a>
								<a href="ingresar/logout" class="flex-c-m trans-04 p-tb-5 p-lr-25">
									SALIR
								</a>
							</div>
							<?php else: ?>
								<div class="right-top-bar flex-w h-full"></div>
							<?php endif ?>
						</div>
					</div>
					
				</div>
			</div>
			<!-- Header Mobile -->
			<div class="wrap-header-mobile">
				<!-- Logo moblie -->    
				<div class="logo-mobile">
					<a href="./"><img src="assets/frontend/cki/imagenes/logo_cki.png" alt="LOGO CKI"></a>
				</div>
				<!-- Icon header -->
				<div class="wrap-icon-header flex-w flex-r-m m-r-15">
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="<?=count($carrito);?>">
						<?php if ($carrito): ?>
						<a href="pedido/carro" class="items" id="a_de_carrito">
						<i class="zmdi zmdi-shopping-cart"></i>
						</a>
						<?php else: ?>
						<i class="zmdi zmdi-shopping-cart"></i>
						<?php endif ?>
					</div>
				</div>
				<!-- Button show menu -->
				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
					<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
			<!-- Menu Mobile -->
			<div class="menu-mobile">
				<div class="menuUsuario">
					<div class="container">
						<?php if ($this->session->userdata('logueadocki')): ?>
						<div class="right-top-bar flex-w h-full">
							<a class="flex-c-m trans-04 p-lr-25">Bienvenido: <?=$this->session->userdata('ses_razon')?></a>
							<a href="reservas/listado/1" class="flex-c-m trans-04 p-lr-25">RESERVAS</a>
							<a href="compras/listado/1" class="flex-c-m trans-04 p-lr-25">HISTORIAL</a>
							<?php if ($this->session->userdata('nivel')=="administrador"): ?>
								<a href="vendedores/listado" class="flex-c-m trans-04 p-lr-25">VENDEDORES</a>
							<?php endif ?>
							<a href="mis-datos/actualizacion" class="flex-c-m trans-04 p-lr-25">MIS DATOS</a>
							<a href="ingresar/logout" class="flex-c-m trans-04 p-lr-25">SALIR</a>
						</div>
						<?php else: ?>
							<div class="right-top-bar flex-w h-full"></div>
						<?php endif ?>
					</div>
				</div>
				<ul class="main-menu-m">
					<?php echo $menu;?>
				</ul>
			</div>
		</header>