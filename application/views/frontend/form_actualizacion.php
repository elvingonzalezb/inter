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
			<div class="col-md-9">
				<div class="p-t-25 p-b-20 p-l-10 p-r-20">
					<div class="wrap-title-black">
						<h1 class="mtext-113">Actualización de Datos</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
					<?php 
					if(isset($resultado) && $resultado=='success'){
						echo '<div class="succesmsg">Actualización Exitosa</div>';
					}
					if(isset($resultado) && $resultado=='error-bd'){
						echo '<div class="errormsg">Ocurrió un error al actualizar su información.</div>';
					}
					if(isset($resultado) && $resultado=='error-ruc'){
						echo '<div class="errormsg">El RUC ingresado es Incorrecto.</div>';
					} ?>
						<div id="formulario" class="clearfix">
	                        <form action="mis-datos/actualizacion/grabar" method="post" onSubmit="return valida_actualizacion()">
	                        	<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="nombre">Nombre o Razón Social*:</label>
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20"><?php echo $cliente->razon_social;?></span>
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="cargo">Ruc *:</label>
										<span class="span-input size-111 bor8 stext-102 cl2 p-lr-20"><?php echo $cliente->ruc;?></span>
									</div>
									<input type="hidden" name="razon_social" id="razon_social" size="50" class="campo" value="<?php echo $cliente->razon_social;?>"/>
									<input type="hidden" name="ruc" id="ruc" size="50" class="campo" value="<?php echo $cliente->ruc;?>" />
								</div>
								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="nombre">Nombre *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="nombre" type="text" name="nombre" size="50" value="<?php echo $cliente->nombre;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="cargo">Cargo *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="cargo" type="text" name="cargo" size="50" value="<?php echo $cliente->cargo;?>">
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="domicilio">Domicilio *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="domicilio" type="text" name="domicilio" size="50" value="<?php echo $cliente->domicilio;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="distrito">Distrito *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="distrito" type="text" name="distrito" size="50" value="<?php echo $cliente->distrito;?>">
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="ciudad">Ciudad *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="ciudad" type="text" name="ciudad" size="50" value="<?php echo $cliente->ciudad;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="provincia">Provincia *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="provincia" type="text" name="provincia" size="50" value="<?php echo $cliente->provincia;?>">
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="departamento">Departamento *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="departamento" type="text" name="departamento" size="50" value="<?php echo $cliente->departamento;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="provincia">País *:</label>
										<select name="pais" id="pais" class="size-111 bor8 stext-102 cl2 p-lr-20">
											<option value="0">:: Seleccione ::</option>
											<?php 
											foreach ($paises as $value) {
												$PAI_ISO2=$value->PAI_ISO2;
												$nombre=$value->nombre;   
												if($cliente->pais==$PAI_ISO2){
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
										<label class="stext-102 cl3" for="telefono">T&eacute;lefono *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="telefono" type="text" name="telefono" size="50" value="<?php echo $cliente->telefono;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="telefono2">T&eacute;lefono2 :</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="telefono2" type="text" name="telefono2" size="50" value="<?php echo $cliente->telefono2;?>">
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="fax">Facebook Empresarial (de Preferencia) :</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="fax" type="text" name="fax" size="50" value="<?php echo $cliente->fax;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="telefono2">Tipo de Cliente *:</label>
										<select name="tipo_cliente" class="size-111 bor8 stext-102 cl2 p-lr-20">
											<option value="0">:: Seleccione ::</option>
											<option value="Cliente Final" <?php if($cliente->tipo_cliente=='Cliente Final'){echo 'selected';}?>>Cliente Final</option>
											<option value="Publicistas" <?php if($cliente->tipo_cliente=='Publicistas'){echo 'selected';}?>>Publicistas</option>
											<option value="Distribuidor" <?php if($cliente->tipo_cliente=='Distribuidor'){echo 'selected';}?>>Distribuidor</option>
										</select>
									</div>
								</div>
								<div class="row p-b-25">
									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="zip">Código Postal *:</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="zip" type="text" name="zip" size="50" value="<?php echo $cliente->zip;?>">
									</div>

									<div class="col-sm-6 p-b-5">
										<label class="stext-102 cl3" for="web">Web (de Preferencia) :</label>
										<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="web" type="text" name="web" size="50" value="<?php echo $cliente->web;?>">
									</div>
								</div>
								<button class="btn btn-primary font-weight-bold"> Actualizar </button>
	                        </form>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>