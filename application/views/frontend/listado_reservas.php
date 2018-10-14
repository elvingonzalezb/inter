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
						<h1 class="mtext-113">Listado de Reservas Activas</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php
			                $moneda = $this->session->userdata('moneda');
			                switch($moneda) {
			                    case "d":
			                        $simbolo = 'US$';
			                        $tipo_cambio = getConfig("tipo_cambio_dolar");
			                    break;
			                
			                    case "s":
			                        $simbolo = 'S/';
			                        $tipo_cambio = 1;
			                    break;
			                }
			                if(count($ordenes)>0) {
			            ?>
			            <h2 class="mtext-111">Listado de Reservas</h2>
			            <form method="post" action="reservas/compraMultiple" onsubmit="return validaMultiple()">
			            	<div class="table-responsive">
					            <table class="table" cellspacing="1">
					                <thead>
					                    <tr>
					                        <th width="5%" class="encabezado_reserva">NRO</th>
					                        <th width="10%" class="encabezado_reserva">CODIGO</th>                        
					                        <th width="15%" class="encabezado_reserva">INGRESO</th>
					                        <th width="15%" class="encabezado_reserva">CADUCIDAD</th>
					                        <th width="16%" class="encabezado_reserva">TIEMPO</th>
					                        <th width="15%" class="encabezado_reserva">MONTO</th>
					                        <th width="15%" class="encabezado_reserva">ACCION</th>
					                        <th width="10%" class="encabezado_reserva">ELEGIR</th>
					                    </tr>
					                </thead> 
					                <tbody>
					                <?php
					                    $indice_inicial = $pedidos_x_pagina*($pagina - 1);
					                    $total_gnral = 0;
					                    $i = 0;
					                    foreach($ordenes as $reserva) {
					                        $indice_current = $indice_inicial + $i + 1;
					                        $id_orden = $reserva->id_orden;
					                        $codigo_orden = 10000 + $reserva->id_orden;
					                        $fecha_ingreso = YmdHora_2_dmYHora($reserva->fecha_ingreso);
					                        $caducidad = YmdHora_2_dmYHora($reserva->caducidad);
					                        $tiempo_restante = tiempoRestante($reserva->fecha_ingreso, $reserva->caducidad);
					                        $estado = $reserva->estado;
					                        $lleva_cargos = $reserva->lleva_cargos;
					                        $tiene_cargos = $reserva->tiene_cargos;
					                        $total = totalReserva($id_orden, $moneda);
					                        $total_cargos = totalCargos($id_orden);
					                        $monto_2show = $total + $total_cargos;
					                        $total_gnral += $monto_2show;
					                        echo '<tr>';
					                        echo '<td align="center" class="datoReserva">'.$indice_current.'</td>';
								            echo '<td align="center" class="datoReserva">'.$codigo_orden.'</td>';                          
					                        echo '<td align="center" class="datoReserva">'.$fecha_ingreso.'</td>';
					                        echo '<td align="center" class="datoReserva">'.$caducidad.'</td>';
					                        echo '<td align="center" class="datoReserva">'.$tiempo_restante.'</td>';
					                        echo '<td align="center" class="datoReserva">'.$simbolo.' '.$monto_2show.'</td>';
					                        echo '<td align="center" class="datoReserva">';
					                        echo '<a class="btnVerde" href="reservas/detalle/'.$id_orden.'">DETALLE</a><br />';
					                        
					                        if($estado==="Activa") {
					                            switch($lleva_cargos) {
					                                case 0:
					                                    // No lleva cargos
					                                    echo '<a class="btnRojo" href="reservas/comprar/'.$id_orden.'">COMPRAR</a><br>';
					                                break;
					                            
					                                case 1:
					                                   // Esta obligado a tener cargos y si los tiene agregados
					                                   if($tiene_cargos==1) {
					                                       echo '<a class="btnRojo" href="reservas/comprar/'.$id_orden.'">COMPRAR</a><br>';
					                                   }
					                                break;
					                            
					                                case 2:
					                                    // Puede o no llevar cargos extra
					                                    if($tiene_cargos==1) {
					                                        echo '<a class="btnRojo" href="reservas/comprar/'.$id_orden.'">COMPRAR</a><br>';
					                                    }
					                                break;
					                            } // switch                            
					                        }
					                        echo '<a class="btnNaranja" href="reservas/anular/'.$id_orden.'">ANULAR</a><br />';
					                        echo '<a class="btnAzul" href="javascript:modificarReserva(\''.$id_orden.'\')">MODIFICAR</a>';
					                        echo '</td>';
					                        echo '<td align="center" valign="middle" class="datoReserva">';
					                        if($estado==="Activa") {
					                            switch($lleva_cargos) {
					                                case 0:
					                                    // No lleva cargos
					                                    echo '<input type="checkbox" class="chk_size" name="item_'.$id_orden.'" value="'.$id_orden.'" id="'.$id_orden.'" onclick="concatena(\''.$id_orden.'\')"></td>';
					                                break;
					                            
					                                case 1:
					                                   // Esta obligado a tener cargos y si los tiene agregados
					                                   if($tiene_cargos==1) {
					                                       echo '<input type="checkbox" class="chk_size" name="item_'.$id_orden.'" value="'.$id_orden.'" id="'.$id_orden.'" onclick="concatena(\''.$id_orden.'\')"></td>';
					                                   } else {
					                                    	echo '---';
					                                   }
					                                break;
					                            
					                                case 2:
					                                    // Puede o no llevar cargos extra
					                                    if($tiene_cargos==1) {
					                                        echo '<input type="checkbox" class="chk_size" name="item_'.$id_orden.'" value="'.$id_orden.'" id="'.$id_orden.'" onclick="concatena(\''.$id_orden.'\')"></td>';
					                                    } else {
					                                        echo '---';
					                                    }
					                                break;
					                                
					                                default:
					                                    echo '---';
					                                break;
					                            } // switch
					                        }                        
					                        echo '</tr>';
					                        $i++;
					                    }                
					                ?>
					                </tbody>
					                <tfoot>
					                    <?php
					                        $total_2show = number_format(redondeado($total_gnral,3), 3, '.', '');
					                    ?>
					                    <tr>
					                        <td class="encabezado_reserva" colspan="4"><input type="hidden" name="elegidos" id="elegidos"></td>
					                        <td class="encabezado_reserva" style="font-size:14px;">TOTAL</td>
					                        <td class="encabezado_reserva" style="font-size:14px;"><?php echo $simbolo.' '.$total_2show; ?></td>
					                        <td class="encabezado_reserva" colspan="2"></td>
					                    </tr>
					                    <tr>
					                        <td colspan="9" height="10"></td>
					                    </tr>
					                    <tr>
					                        <td colspan="9" align="center" valign="middle">
					                            <input type="submit" class="btnRojo" value="COMPRAR LOS ELEGIDOS"></td>
					                    </tr>
					                </tfoot>
					            </table>
			            	</div>
			            
			            </form>
			            <nav aria-label="pagination example" class="paginacion clearfix">
				            <ul class="pagination pg-blue">
				            <?php
				            //echo '<li class="titulo">Páginas : </li>';
				            for($w=1;$w<=$num_paginas;$w++) {
				                if($w==$pagina) {
				                    echo '<li class="page-item"><a href="reservas/listado/'.$w.'"  class="page-link active">'.$w.'</a></li>';
				                } else {
				                    echo '<li class="page-item"><a href="reservas/listado/'.$w.'" class="page-link">'.$w.'</a></li>';
				                }
				            }
				            ?>
				            </ul>
			            </nav><!--paginacion-->
			            <?php } else {
			                    echo '<div class="msgAlerta">En este momento no tiene reservas registradas</div>';
			                } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>