<!DOCTYPE html>
<html>
	<head>
		<title>Paginas2Go - Zona de Administración</title>
		<base href="<?php echo base_url(); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Gestor de Contenidos Páginas2Go">
		<meta name="author" content="Eduardo Rosadio">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/login.css" rel="stylesheet">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<!-- jQuery -->
		<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery-1.7.2.min.js"></script>

		<!-- The fav icon -->
		<link rel="shortcut icon" href="<?php echo 'assets/admin/'.$theme.'/'; ?>img/favicon.ico">
	</head>
	<body>
		<div class="wrapper fadeInDown">

			<div id="formContent">
				<div class="row-fluid">
				    <div class="span12 center login-header">
				        <h2>Páginas2Go - Zona de Administración</h2>
				    </div><!--/span-->
				</div><!--/row-->
				<!-- Tabs Titles -->
				<!-- Icon -->
				<div class="fadeIn first">
					<img src="<?php echo 'assets/admin/'.$theme.'/'; ?>img/user_login.svg" id="icon" alt="User Icon" />
				</div>
				<!-- Login Form -->
				<div class="container">
					<?php
						$message = $this->session->flashdata('message');
						if(!isset($message)) {
							echo '<div class="alert alert-info">Ingrese sus datos de acceso</div>';
						}else{
							echo $message;
						}
					?>
				</div>
				
				<form action="mainpanel/validar" method="post">
					<input type="text" autofocus class="fadeIn second" name="username" id="username" placeholder="Usuario">
					<input type="password" class="fadeIn third" name="password" id="password" placeholder="Contraseña">
					<div class="clearfix"></div>
						<?= $recaptcha?>
					<div class="clearfix"></div>
					<input type="submit" class="fadeIn fourth" value="INGRESAR">
				</form>
				<!-- Remind Passowrd -->
				<!-- <div id="formFooter">
					<a class="underlineHover" href="#">Forgot Password?</a>
				</div> -->
			</div>
		</div>
	</body>
</html>


<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->

