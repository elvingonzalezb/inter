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
						<h1 class="mtext-113"><?php echo $contenido->titulo;?></h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<div class="sub_contenido m-b-20">
		                    <?php echo $contenido->texto; ?>
		                </div>
		              
		                <div class="sub_contenido">
		                    <?php 
		                    echo $this->session->flashdata('msg_captcha');
		                    if(isset($resultado) && $resultado=='usuario'){
		                       echo '<div class="form-group has-feedback"><div class="alert alert-warning">USUARIO INCORRECTO.</div></div>';
		                    }
		                    if(isset($resultado) && $resultado=='bienvenido'){
		                        if(isset($_SESSION['logueadocki'])){
		                            echo '<div class="form-group has-feedback"><div class="alert alert-success">'.$_SESSION['ses_razon'].' su logueo fue satisfactorio.</div></div>';
		                        }
		                    } 
							
		                    if($this->session->userdata('msg_cliente_final')){
		                       $str=$this->session->userdata('msg_cliente_final');
		                       echo '<div class="form-group has-feedback"><div class="alert alert-danger">'.$str.'</div></div>';
		                       $this->session->unset_userdata('msg_cliente_final');
		                    }                     
		                    
		                    if(isset($resultado) && $resultado=='password'){
		                       echo '<div class="form-group has-feedback"><div class="alert alert-danger">PASSWORD INCORRECTO</div></div>';
		                    } 
		                    
		                    if(isset($resultado) && $resultado=='estado'){
		                       echo '<div class="form-group has-feedback"><div class="alert alert-danger">USUARIO INACTIVO</div></div>';
		                    }                    
		                    ?>
		                    <div id="formulario" class="clearfix">
		                        <form action="ingresar/logueo" method="post" onSubmit="return valida_inicio()">
		                        	<h3 class="mtext-113 p-b-20">Ingrese sus datos</h3>
		                        	<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Usuario :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="usuario" id="usuario" size="50" value="<?php if(isset($dat)){echo $dat['razon_social'];}?>"/>
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Password :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="password" name="password" id="password" size="50" value="<?php if(isset($dat)){echo $dat['ruc'];}?>" />
										</div>
									</div>
									
									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<div class="clearfix"></div>
												<?= $recaptcha?>
											<div class="clearfix"></div>
										</div>
										<div class="col-sm-6 p-b-5">
											<a href="recordar-contrasena">Recordar contrase&ntilde;a</a>
										</div>
									</div>
									<button type="submit" class="btn btn-primary" id="btnEnviar" >Ingresar</button>
		                        </form>
		                    </div> 
		                </div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>