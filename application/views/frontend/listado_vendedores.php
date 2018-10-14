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
					<!-- <div class="welcomemsg border border-secondary rounded m-b-20"> Bienvenido: <?=$this->session->userdata('ses_razon'); ?>. Use el menu superior para descargar el inventario actualizado o cerrar sesión.</div> -->
					<h1 class="mtext-113" id="abcdefg">Listado de vendedores</h1>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<p>Si desea registrar un nuevo vendedor haga <a href="vendedores/nuevo">CLICK AQUI</a></p>
						<?php if(isset($resultado)) {
								switch($resultado) {
									case "agregado":
										echo '<div class="exitomsg">Se agrego correctamente al vendedor</div>';
									break;
								
									case "eliminado":
										echo '<div class="exitomsg">El vendedor fue eliminado</div>';
									break;
								
									case "nodetalle":
									   echo '<div class="errormsg">No puede ver los detalles de ese vendedor porque no es uno de sus vendedores.</div>'; 
									break;
								
									case "noedit":
										echo '<div class="errormsg">No puede editar los datos de ese vendedor porque no es uno de sus vendedores.</div>'; 
									break;
								
									case "nodelete":
										echo '<div class="errormsg">No puede borrar a este vendedor porque no es uno de sus vendedores.</div>'; 
									break;
								
									case "nocompras":
										echo '<div class="errormsg">No puede ver la lista de compras de este vendedor porque no es uno de sus vendedores.</div>'; 
									break;
								
									case "noreservas":
										echo '<div class="errormsg">No puede ver la lista de reservas de este vendedor porque no es uno de sus vendedores.</div>'; 
									break;
								}
							}
						if(count($vendedores)>0) { ?>
						<div class="table-responsive">
							<table width="100%" cellspacing="1" class="table">
								<thead>
									<tr>
										<th width="5%" class="encabezado_reserva">NRO</th>
										<th width="20%" class="encabezado_reserva">NOMBRE</th>  
										<th width="20%" class="encabezado_reserva">EMAIL</th>
										<th width="15%" class="encabezado_reserva">ULTIMO INGRESO</th>
										<th width="15%" class="encabezado_reserva">VE PRECIOS?</th>
										<th width="10%" class="encabezado_reserva">ESTADO</th>
										<th width="20%" class="encabezado_reserva">ACCION</th>
									</tr>
								</thead> 
								<tbody>
								<?php
									$i = 0;
									foreach($vendedores as $current)
									{
										$id = $current->id;
										$nombre = $current->nombre;
										$cargo = $current->cargo;
										$telefono = $current->telefono;
										$email = $current->email;
										$clave = $current->clave;
										$last_login = $current->last_login;
										$estado = $current->estado;
										$ver_precios = ($current->ver_precio=="si")?'SI':'NO';
										echo '<tr>';
										echo '<td align="center" class="datoReserva">'.($i + 1).'</td>';
										echo '<td align="center" class="datoReserva">'.$nombre.'</td>';  
										echo '<td align="center" class="datoReserva">'.$email.'</td>';
										echo '<td align="center" class="datoReserva">'.$last_login.'</td>';
										echo '<td align="center" class="datoReserva">'.$ver_precios.'</td>';
										echo '<td align="center" class="datoReserva">'.$estado.'</td>';
										echo '<td align="center" class="datoReserva">';
											echo '<a class="btnVerde" href="vendedores/detalle/'.$id.'">DETALLE</a><br />';
											echo '<a class="btnNaranja" href="vendedores/editar/'.$id.'">EDITAR</a><br />';
											echo '<a class="btnAzul" href="vendedores/listaReservas/'.$id.'/1">RESERVAS</a><br />';
											echo '<a class="btnVerde" href="vendedores/listaCompras/'.$id.'/1">COMPRAS</a><br />';
											echo '<a class="btnRojo" href="javascript:eliminarVendedor(\''.$id.'\')">ELIMINAR</a>';
										echo '</td>';
										echo '</tr>';
										$i++;
									}
								?>
								</tbody>
							</table>
						</div>
						
						<?php } else {
							echo '<div class="msgAlerta">En este momento no tiene vendedores registrados</div>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>