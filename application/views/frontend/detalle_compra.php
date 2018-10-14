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
				<div class="m-t-25 m-b-20 m-l-10 m-r-20 p-b-20">
					<div class="wrap-title-black">
						<h1 class="mtext-113">Detalle de Compra</h1>
					</div>
					<div id="contentCat" class="container m-t-20 p-t-25">
						<?php
			                switch($orden->moneda) {
			                    case "s":
			                        $simbolo = 'S/';
			                    break;

			                    case "d":
			                        $simbolo = 'US$';
			                    break;
			                }
			                if($resultado==0) {
			                    echo '<div class="msgAlerta">';
			                    echo '<p>No puede ver los detalles de esa reserva porque le pertenece a otro cliente.</p>';
			                    echo '<a href="javascript:history.back(-1)">VOLVER</a>';
			                    echo '</div>';
			                } else  {     
			            ?>
			                <h3 class="h3Reserv mtext-113">DATOS DE LA COMPRA</h3>
			                <table class="table" cellpadding="0" cellspacing="1">
				                <tbody>
				                    <tr>
				                        <td width="25%" align="left" valign="middle" class="cell_1">Nro de Compra:</td>
				                        <td width="75%" align="left" valign="middle" class="cell_1"><?php echo ($orden->id_orden + 10000); ?></td>
				                    </tr>
				                    <tr>
				                        <td align="left" valign="middle" class="cell_1">Nro de Reserva:</td>
				                        <td align="left" valign="middle" class="cell_1"><?php echo $orden->codigo_reserva; ?></td>
				                    </tr>
				                    <tr>
				                        <td align="left" valign="middle" class="cell_1">Fecha y hora de Ingreso:</td>
				                        <td align="left" valign="middle" class="cell_2">
				                        <?php
				                            $aux_f = explode(" ", $orden->fecha_ingreso);
				                            $aux_f2 = explode("-", $aux_f[0]);
				                            $fecha_1 = $aux_f2[2]."-".$aux_f2[1]."-".$aux_f2[0];
				                            $fecha_orden = $fecha_1." ".$aux_f[1];
				                            echo $fecha_orden; 
				                        ?>
				                        </td>
				                    </tr>
				                    <tr>
				                        <td align="left" valign="middle" class="cell_1">Forma de Pago:</td>
				                        <td align="left" valign="middle" class="cell_1"><?php echo $orden->forma_pago; ?></td>
				                    </tr>
				                    <?php
				                        if($orden->forma_pago=="transferencia")
				                        {
				                    ?>
				                    <tr>
				                        <td align="left" valign="middle" class="cell_1">Banco:</td>
				                        <td align="left" valign="middle" class="cell_1"><?php echo $orden->banco; ?></td>
				                    </tr>
				                    <tr>
				                        <td align="left" valign="middle" class="cell_1">Nro Operacion:</td>
				                        <td align="left" valign="middle" class="cell_1"><?php echo $orden->numero_operacion; ?></td>
				                    </tr>
				                    <?php
				                        }
				                    ?>
				                </tbody>
			                </table>
			                <h3 class="h3Reserv mtext-113">PRODUCTOS</h3>
			                <div class="tooltip-demo well">
			                    <div class="table-responsive">
			                        <table class="table" cellspacing="1">
			                            <thead>
			                                <tr>
			                                    <th width="5%" class="encabezado_reserva">C&oacute;digo</th>
			                                    <th width="20%" class="encabezado_reserva">Nombre del Producto</th>
			                                    <th width="10%" class="encabezado_reserva">Color</th>
			                                    <th width="15%" class="encabezado_reserva">Nombre Color</th>
			                                    <th width="15%" class="encabezado_reserva">Precio</th>
			                                    <th width="15%" class="encabezado_reserva">Cantidad</th>
			                                    <th width="20%" class="encabezado_reserva">Subtotal</th>
			                                </tr>
			                            </thead>   
			                            <tbody>
			                            <?php
			                            $total='';
			                            foreach($detalles as $detalle)
			                            {
			                                switch($orden->moneda)
			                                {
			                                    case "s":
			                                        $precio = $detalle->precio_soles;
			                                    break;
			                                
			                                    case "d":
			                                        $precio = $detalle->precio_dolares;
			                                    break;
			                                }
			                                $st = $precio*($detalle->cantidad);
			                                $subtotal = redondeado($st, 3);
			                                $subtotal = number_format($subtotal, 3, '.', '');
			                                echo '<tr>';
			                                echo '<td align="center" class="datoReserva">'.$detalle->codigo_producto.'</td>';                        
			                                echo '<td align="center" class="datoReserva">'.$detalle->nombre_producto.'</td>';
			                                echo '<td align="center" class="datoReserva"><div style="background:'.$detalle->codigo_color.';margen:15px;width:30px;height:30px;border:#000 solid 1px;"></td>';
			                                echo '<td align="center" class="datoReserva">'.$detalle->nombre_color.'</td>';
			                                echo '<td align="center" class="datoReserva">'.$simbolo.' '.$precio.'</td>';
			                                echo '<td align="center" class="datoReserva">'.$detalle->cantidad.'</td>';
			                                echo '<td align="center" class="datoReserva">'.$simbolo.' '.$subtotal.'</td>';
			                                echo '</tr>';
			                                $total=$total + $subtotal;
			                            }

			                            ?>
			                                <tr>
			                                    <td class="encabezado_reserva" colspan="5"></td>
			                                    <td class="encabezado_reserva" style="font-size:14px;">SUBTOTAL</td>
			                                    <td class="encabezado_reserva" style="font-size:14px;"><?php echo $simbolo.' '.$total; ?></td>
			                                </tr>
			                            </tbody>
			                        </table> 
			                    </div>
			                        <?php
			                            if($orden->numero_cargos>0)
			                            {
			                        ?>
			                        <h3 class="mtext-113">CARGOS ADICIONALES</h3>
			                        <div class="table-responsive">
				                        <table class="table" cellspacing="1">
				                            <thead>
				                                <tr>
				                                    <th width="10%" class="encabezado_reserva">N</th>
				                                    <th width="70%" class="encabezado_reserva">CONCEPTO</th>
				                                    <th width="20%" class="encabezado_reserva">MONTO</th>
				                                </tr>
				                            </thead>   
				                            <tbody>
				                            <?php
				                                $aux_ca = $orden->lista_cargos;
				                                $aux_ca_2 = explode("@", $aux_ca);
				                                for($i=0; $i<count($aux_ca_2); $i++)
				                                {
				                                    $aux_ca_3 = explode("#", $aux_ca_2[$i]);
				                                    $total += $aux_ca_3[1];
				                                    echo '<tr>';
				                                    echo '<td align="center" class="datoReserva">'.($i+1).'</td>';
				                                    echo '<td align="center" class="datoReserva">'.$aux_ca_3[0].'</td>';
				                                    echo '<td align="center" class="datoReserva">'.$simbolo.' '.$aux_ca_3[1].'</td>';
				                                    echo '<tr>';
				                                }
				                            ?>
				                                <tr>
				                                    <td class="encabezado_reserva"></td>
				                                    <td class="encabezado_reserva" style="font-size:16px;">TOTAL</td>
				                                    <td class="encabezado_reserva" style="font-size:16px;"><?php echo $simbolo.' '.number_format($total, 3, '.', ''); ?></td>
				                                </tr>
				                            </tbody>
				                        </table>
				                    </div>
			                        <?php
			                            }
			                        ?>
			                    
			               </div><!-- tooltip-demo well--> 
			               <div id="botoneraDetalleCompra">
								<a href="javascript:history.back(-1)" class="btnRojo">VOLVER AL LISTADO</a>
								<a href="javascript:printCompra(<?php echo $orden->id_orden; ?>)" class="btnRojo">IMPRIMIR</a>
							</div>
			            <?php
			                } // else
			            ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>