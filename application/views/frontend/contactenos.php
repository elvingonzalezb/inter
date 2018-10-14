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
						<h1 class="mtext-113">Contáctenos</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<div class="sub_contenido">
							<?php echo $contenido->texto; ?>
		                </div>
		              
		                <div class="sub_contenido">
							<?php 
							if(isset($resultado))
							{
							    switch($resultado)
							    {
							        case "success":
							            echo '<div class="succesmsg">Su mensaje fue enviado correctamente, nos estaremos comunicando a la brevedad.</div>';
							        break;
							    
							        case "error":
							            echo '<div class="errormsg">Ocurrió un error al enviar el mensaje, inténtelo de nuevo.</div>';
							        break;
							    
							        case "codigo":
							            echo '<div class="errormsg">El codigo de la imagen es erroneo.</div>';
							        break;
							        /*
							        default:
							            echo '<div class="errormsg">Resultado:'.$resultado.'.</div>';
							        break;
							        */
							    }                    
							}                   
							?>
							<div id="formulario" class="clearfix">
							    <form action="contactenos/enviar-mensaje" method="post" onSubmit="return validacorreo()">
							    	<strong>(*) Campos Obligatorios</strong>
							    	<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<label class="stext-102 cl3" for="nombre">Nombre *:</label>
											<input type="text" name="nombre" id="nombre" size="70" class="size-111 bor8 stext-102 cl2 p-lr-20" />
										</div>
									</div>
									<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<?php if($this->session->userdata("email")){
												$em=$this->session->userdata("email");
											}else{
												$em='';
											}?>
											<label class="stext-102 cl3" for="email">Email *:</label>
											<input type="text" name="email" id="email" size="70" class="size-111 bor8 stext-102 cl2 p-lr-20" value="<?php echo $em;?>"/>
										</div>
									</div>

									<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<label class="stext-102 cl3" for="telefono">Tel&eacute;fono *:</label>
											<input type="text" name="telefono" id="telefono" size="70" class="size-111 bor8 stext-102 cl2 p-lr-20" />
										</div>
									</div>
									<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<?php
											if($this->session->userdata("ses_razon")){
												$rz=$this->session->userdata("ses_razon");
											}else{
												$rz='';
											}?>
											<label class="stext-102 cl3" for="empresa">Empresa *:</label>
											<input type="text" name="empresa" id="empresa" size="70" class="size-111 bor8 stext-102 cl2 p-lr-20" value="<?php echo $rz;?>"/>
										</div>
									</div>
									<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<label class="stext-102 cl3" for="telefono">Mensaje *:</label>
											<textarea name="mensaje" id="mensaje" class="size-120 bor8 stext-102 cl2 p-lr-20"></textarea>
										</div>
									</div>
									<div class="row p-b-25">
										<div class="col-sm-12 p-b-5">
											<label class="stext-102 cl3" for="codigo">Código *:</label>
											<input type="text" name="codigo" id="codigo" size="70" class="size-111 bor8 stext-102 cl2 p-lr-20" value=""/><?php echo $cap_img; ?>
										</div>
									</div>
									<button class="btn btn-primary boton">Enviar</button>
							    </form>
							</div><!-- formulario --> 
		                </div><!--sub_contenido-->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>