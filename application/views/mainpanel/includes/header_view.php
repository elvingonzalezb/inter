<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	<meta charset="utf-8">
	<title>Paginas2Go - Zona de Administración</title>
    <base href="<?php echo base_url(); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Gestor de Contenidos Páginas2Go">
	<meta name="author" content="Eduardo Rosadio">
    <link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/font-awesome.min.css" rel="stylesheet">
	<!-- The styles -->
	<link id="bs-css" href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/bootstrap-spacelab.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>     
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/charisma-app.css" rel="stylesheet">
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/fullcalendar.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/chosen.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/uniform.default.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/colorbox.css' rel='stylesheet'>

	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery.noty.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/noty_theme_default.css' rel='stylesheet'>

	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/elfinder.min.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/elfinder.theme.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/opa-icons.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/uploadify.css' rel='stylesheet'>
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/js_color_picker_v2.css" rel="stylesheet"> 
	   
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/custom_css.css" rel="stylesheet">   
    <link type="text/css" href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/JSCal2/jscal2.css" rel="stylesheet"/>
    <link type="text/css" href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/JSCal2/border-radius.css" rel="stylesheet"/>  

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?php echo 'assets/admin/'.$theme.'/'; ?>img/favicon.ico">
    <!--<script type="text/javascript" src="assets/fckeditor/fckeditor.js"></script>-->
    <script src="assets/ckeditor/ckeditor.js"></script>
        <!-- jQuery -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery-1.7.2.min.js"></script>
</head>

<body>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="./"> 
                                    <!--<img alt="Charisma Logo" src="img/logo20.png" />--> <span>CKI</span></a>
				
				<!-- theme selector starts -->
				<!-- <div class="btn-group pull-right theme-container" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-tint"></i><span class="hidden-phone"> Cambiar Tema</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div> -->
				<!-- theme selector ends -->
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user"></i><span class="hidden-phone"> admin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					<!--<li><a href="#">PERFIL</a></li>-->
						<li class="divider"></li>
						<li><a href="mainpanel/logout">SALIR</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
				
				<div class="top-nav nav-collapse">
					<ul class="nav">
						<li><a href="<?php echo base_url(); ?>" target="_blank">Cargar Web</a></li>
                        <li><a href="javascript:void(0)">Bienvenido: <?php echo $this->session->userdata('nombre_admin'); ?></a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<div class="container-fluid">
		<div class="row-fluid marginTop30">
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
                                <?php echo $menu; ?>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
			<!-- content starts -->