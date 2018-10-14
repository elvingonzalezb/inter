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
						<div class="sub_contenido">
		                    <?php echo $contenido->texto; ?>
		                </div>
		              
		                <div class="sub_contenido">
		                    <?php 
		                    if($this->session->userdata('msg_registro')){
		                       $msg=$this->session->userdata('msg_registro');
		                       $this->session->unset_userdata('msg_registro');
		                       echo '<div class="form-group has-feedback"><div class="alert alert-success">'.$msg.'</div></div>';
		                    }
		                    
		                    if($this->session->userdata("errorRegistro")){
		                       echo '<div class="form-group has-feedback"><div class="alert alert-warning">'.$this->session->userdata("errorRegistro").'</div></div>';
		                       $this->session->unset_userdata('errorRegistro');
		                    }                    

		                    // estos son los datos que ya se habia enviado se los guarda en un arrat dentro de una session
		                    if($this->session->userdata('arreglo')){
		                        $dat=$this->session->userdata('arreglo');
		                    }
		                    
		                    ?>
		                    <div id="formulario" class="clearfix">
		                        <form action="registrese/grabar" method="post" onSubmit="return valida_registro()">
		                        	<h3 class="mtext-113 p-b-20">Informaci&oacute;n Personal</h3>
		                        	<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<label class="stext-102 cl3" for="nombre">Raz&oacute;n Social *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="razon_social" id="razon_social" size="50" value="<?php if(isset($dat)){echo $dat['razon_social'];}?>"/>
										</div>
									</div>
									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Ruc :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="ruc" id="ruc" size="50" value="<?php if(isset($dat)){echo $dat['ruc'];}?>" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Cargo *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="cargo" id="cargo" size="50" value="<?php if(isset($dat)){echo $dat['cargo'];}?>" />
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Nombres *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="nombre" id="nombre" size="50" value="<?php if(isset($dat)){echo $dat['nombre'];}?>" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="apellido">Apellidos *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="apellido" id="apellido" size="50" value="<?php if(isset($dat)){echo $dat['apellido'];}?>" />
										</div>
									</div>
									
									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Domicilio :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="domicilio" id="domicilio" size="50" value="<?php if(isset($dat)){echo $dat['domicilio'];}?>" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Distrito *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="distrito" id="distrito" size="50" value="<?php if(isset($dat)){echo $dat['distrito'];}?>"/>
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Ciudad :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="ciudad" id="ciudad" size="50" value="<?php if(isset($dat)){echo $dat['ciudad'];}?>" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Provincia :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="provincia" id="provincia" size="50" value="<?php if(isset($dat)){echo $dat['provincia'];}?>" />
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Departamento :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="departamento" id="departamento" size="50" value="<?php if(isset($dat)){echo $dat['departamento'];}?>" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Pais *:</label>
											<select class="size-111 bor8 stext-102 cl2 p-lr-20" name="pais" id="pais">
												<option value="0">:: Seleccione ::</option>
												<?php 
												foreach ($paises as $value) {
													$PAI_ISO2=$value->PAI_ISO2;
													$nombre=$value->nombre;   
													if(isset($dat['pais'])==$PAI_ISO2){
													    echo '<option value="'.$PAI_ISO2.'" selected>'.$nombre.'</option>';
													}else{
													    echo '<option value="'.$PAI_ISO2.'">'.$nombre.'</option>';                                                    
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">T&eacute;lefono * :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="telefono" id="telefono" size="50" value="<?php if(isset($dat)){echo $dat['telefono'];}?>"/>
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">T&eacute;lefono2 :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="telefono2" id="telefono2" size="50" value="<?php if(isset($dat)){echo $dat['telefono2'];}?>"/>
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Facebook Empresarial (de Preferencia) :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="fax" id="fax" size="50" value="<?php if(isset($dat)){echo $dat['fax'];}?>"/>
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Tipo de Cliente *:</label>
											<select class="size-111 bor8 stext-102 cl2 p-lr-20" name="tipo_cliente">
			                                    <option value="0">:: Seleccione ::</option>
			                                    <option value="Cliente Final" <?php if(isset($dat) && $dat['tipo_cliente']=='Cliente Final'){echo 'selected';}?>>Cliente Final</option>
			                                    <option value="Publicistas" <?php if(isset($dat) && $dat['tipo_cliente']=='Publicistas'){echo 'selected';}?>>Publicistas</option>
			                                    <option value="Distribuidor" <?php if(isset($dat) && $dat['tipo_cliente']=='Distribuidor'){echo 'selected';}?>>Distribuidor</option>
		                                    </select>
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">C&oacute;digo Postal * :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="zip" id="zip" size="50" value="<?php if(isset($dat)){echo $dat['zip'];}?>"/>
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Web (de Preferencia) :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="web" id="web" size="50" value="<?php if(isset($dat)){echo $dat['web'];}?>"/>
										</div>
									</div>
									<h3 class="mtext-113 p-b-20">Informaci&oacute;n de Acceso</h3>
									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Email * :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="email" id="email" size="50" value="<?php if(isset($dat)){echo $dat['email'];}?>"/>
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Password *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="password" name="password" id="password" size="50" value="<?php if(isset($dat)){echo $dat['clave'];}?>" />
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Repetir el Email  * :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="email_rep" id="email_rep" size="50" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">Repetir el Password *:</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="password" name="password_rep" id="password_rep" size="50" />
										</div>
									</div>
									<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<div class="clearfix"></div>
												<?= $recaptcha?>
											<div class="clearfix"></div>
										</div>
									</div>
									<!-- <div class="row p-b-25">
										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="nombre">Ingresar el codigo de la imagen  * :</label>
											<input class="size-111 bor8 stext-102 cl2 p-lr-20" type="text" name="codigo" id="codigo" size="20" />
										</div>

										<div class="col-sm-6 p-b-5">
											<label class="stext-102 cl3" for="cargo">&nbsp;&nbsp;</label>
											<?php //echo $cap_img; ?>
										</div>
									</div> -->
									<button class="btn btn-primary">Registrarse</button>
		                        </form>
		                    </div><!-- formulario --> 
		                </div><!--sub_contenido-->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>