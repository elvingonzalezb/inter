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
						<h1 class="mtext-113">Recordar Contraseña</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php 
	                    if(isset($resultado) && $resultado=='email-incorrecto'){
	                       echo '<div class="errormsg">EMAIL INCORRECTO.</div>';
	                    }
	                    if(isset($resultado) && $resultado=='success'){
	                        echo '<div class="succesmsg">Le hemos enviado su contraseña a su Correo Electrónico</div>';
	                    } 
	                    ?>
	                    <div id="formulario" class="clearfix">
	                        <form action="recordar-contrasena/buscar" method="post" onSubmit="return valida_recordar()">
	                        	<div class="row p-b-25">
		                        	<div class="col-sm-8 p-b-5">
										<label class="font-weight-bold stext-102 cl3" for="">Ingrese el Correo Electronico</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="email" id="email" size="70" class="campo" value="<?php if(isset($dat)){echo $dat['razon_social'];}?>"/>
									</div>

									<div class="col-sm-4 p-b-5">
										<label class="stext-102 cl3">&nbsp;&nbsp;</label>
										<button class="btn btn-primary">Enviar</button>
									</div>
	                        	</div>
	                        	
	                        </form>
	                    </div><!-- formulario -->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>