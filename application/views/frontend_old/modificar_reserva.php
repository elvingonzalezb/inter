<div id="wrap-content">
  <div id="breadcrumb">
<!--    <a href="#" class="breadcrumbHome">Homepage</a><span class="seperator"> &nbsp; </span><a href="#">Computers</a><span class="seperator"> &nbsp; </span><a href="#">Laptops</a><span class="seperator"> &nbsp; </span><span>Dell</span>-->
  </div>
  <div id="main-content">
    <div id="left-column">
      <?php echo $izquierda;?>
    </div> 
    <div id="right-column">
      <div id="content">
        <div class="wrap-featured-products">
            <div class="wrap-title-black">
              <h1 class="nice-title">Modificar Reserva <?php //echo $resultado; ?></h1>
            </div>
            <div class="contenido">
            <?php
                if($resultado=="error-propietario")
                {
                    echo '<div class="msgAlerta">';
                    echo '<p>No puede modificar esta reserva porque le pertenece a otro cliente.</p>';
                    echo '<a href="javascript:history.back(-1)">VOLVER</a>';
                    echo '</div>';
                }
                else if($resultado=="error-stock")
                {
                    echo '<div class="msgAlerta">';
                    echo '<p>Uno de los productos en su reserva excede el stock para dicho item.</p>';
                    echo '<a href="javascript:history.back(-1)">VOLVER</a>';
                    echo '</div>';
                }
                else 
                {
            ?>
                <h3 class="h3Reserv">DATOS GENERALES</h3>
                <table width="100%" cellpadding="0" cellspacing="1">
                    <tbody>
                        <tr>
                            <td align="left" valign="middle" class="cell_1">Nro. de Reserva:</td>
                            <td align="left" valign="middle" class="cell_2">
                            <?php
                                $nro_reserva = $orden->id_orden + 10000;
                                echo $nro_reserva; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%" align="left" valign="middle" class="cell_1">Fecha y hora de Ingreso:</td>
                            <td width="75%" align="left" valign="middle" class="cell_2">
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
                            <td align="left" valign="middle" class="cell_1">Fecha y hora de Caducidad:</td>
                            <td align="left" valign="middle" class="cell_2">
                            <?php
                                $caducidad = Ymd_2_dmYHora($orden->caducidad);
                                echo $caducidad; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" class="cell_1">Tiempo Restante:</td>
                            <td align="left" valign="middle" class="cell_2">
                            <?php
                                $aux_hc = explode(" ", $orden->caducidad);
                                $aux_hc_2 = explode("-", $aux_hc[0]);
                                $aux_hc_3 = explode(":", $aux_hc[1]);
                                $time_caducidad = mktime($aux_hc_3[0], $aux_hc_3[1], $aux_hc_3[2], $aux_hc_2[1], $aux_hc_2[2], $aux_hc_2[0]);
                                $ahora = time();
                                $diferencia = conversorSegundosHoras($time_caducidad - $ahora);
                                echo $diferencia; 
                            ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="h3Reserv">PRODUCTOS RESERVADOS</h3>
                <p>Si desea eliminar uno te los items de su reserva cambie la cantidad de ese item a 0.<br>Recuerde que la cantidad máxima que puede reservar de cada item está indicada en la columna Stock Actual.</p>
                <form id="formPedido" action="frontend/reservas/actualizaReserva" method="post" onsubmit="return validaUpdateReserva()">
                <div class="tooltip-demo well">
                    <div class="box-content">
                        <table width="100%" cellspacing="1">
                            <thead>
                                <tr>
                                    <th width="9%" class="encabezado_reserva">C&oacute;digo</th>
                                    <th width="21%" class="encabezado_reserva">Nombre del Producto</th>
                                    <th width="9%" class="encabezado_reserva">Color</th>
                                    <th width="15%" class="encabezado_reserva">Nombre Color</th>
                                    <th width="10%" class="encabezado_reserva">Cantidad</th>
                                    <th width="12%" class="encabezado_reserva">Stock Actual</th>
                                    <th width="12%" class="encabezado_reserva">Precio</th>                                    
                                    <th width="12%" class="encabezado_reserva">Subtotal</th>
                                </tr>
                            </thead>   
                            <tbody>
                            <?php
                            $total = '';
                            $tipo_reserva = $orden->tipo_reserva;
                            $i=0;
                            foreach($detalles as $detalle)
                            {
                                switch($orden->moneda)
                                {
                                    case "s":
                                        $precio = $detalle->precio_soles;
                                        $simbolo = 'S/';
                                    break;
                                
                                    case "d":
                                        $precio = $detalle->precio_dolares;
                                        $simbolo = 'US$';
                                    break;
                                }
                                $ci =& get_instance();
                                $aux_stock = $ci->Reservas_model->stockProducto($detalle->id_producto, $detalle->id_color);
                                switch($tipo_reserva)
                                {
                                    case "stock":
                                        $stock = $aux_stock->stock;
                                    break;

                                    case "proximamente":
                                       $stock = $aux_stock->stock_proximamente;
                                    break;
                                } 
                                $id_registro = $aux_stock->id;
                                $st = $precio*($detalle->cantidad);
                                $subtotal = redondeado($st, 3);
                                $subtotal = number_format($subtotal, 3, '.', '');                             
                                echo '<tr id="fila_'.$id_registro.'">';
                                echo '<td align="center" class="datoReserva">'.$detalle->codigo_producto.'</td>';                        
                                echo '<td align="center" class="datoReserva" id="nombre_'.$id_registro.'">'.$detalle->nombre_producto.'</td>';
                                echo '<td align="center" class="datoReserva"><div style="background:'.$detalle->codigo_color.';margen:15px;width:30px;height:30px;border:#000 solid 1px;"></td>';
                                echo '<td align="center" class="datoReserva" id="color_'.$id_registro.'">'.$detalle->nombre_color.'</td>';                                
                                echo '<td align="center" class="datoReserva">';
                                ?>
<input type="text" onKeyPress="return checkIt(event)" class="campo" name="cant_<?php echo $i;?>" id="cant_<?php echo $i;?>" size="5" value="<?php echo $detalle->cantidad; ?>" />

<input type="hidden" name="id_detalle_<?php echo $i; ?>" id="id_detalle_<?php echo $i; ?>" value="<?php echo $detalle->id; ?>">
<input type="hidden" name="stock_<?php echo $i; ?>" id="stock_<?php echo $i; ?>" value="<?php echo $stock; ?>">                                
<input type="hidden" name="cant_actual_<?php echo $i; ?>" id="cant_actual_<?php echo $i; ?>" value="<?php echo $detalle->cantidad; ?>">  
<input type="hidden" name="id_<?php echo $i; ?>" id="id_<?php echo $i; ?>" value="<?php echo $id_registro; ?>">
<input type="hidden" name="id_producto_<?php echo $i; ?>" id="id_producto_<?php echo $i; ?>" value="<?php echo $detalle->id_producto; ?>">
<input type="hidden" name="color_<?php echo $i; ?>" id="color_<?php echo $i; ?>" value="<?php echo $detalle->codigo_color; ?>">
<input type="hidden" name="precio_<?php echo $i; ?>" id="precio_<?php echo $i; ?>" value="<?php echo $precio; ?>">
<input type="hidden" name="codigo_<?php echo $i; ?>" id="codigo_<?php echo $i; ?>" value="<?php echo $detalle->codigo_producto; ?>">
<input type="hidden" name="nombre_<?php echo $i; ?>" id="nombre_<?php echo $i; ?>" value="<?php echo $detalle->nombre_producto; ?>">
<input type="hidden" name="subtot_<?php echo $i; ?>" id="subtot_<?php echo $i; ?>" value="<?php echo $subtotal; ?>">
<input type="hidden" name="uni_<?php echo $i; ?>" id="uni_<?php echo $i; ?>" value="<?php echo $detalle->unidad; ?>">
<input type="hidden" name="id_color_<?php echo $i; ?>" id="id_color_<?php echo $i; ?>" value="<?php echo $detalle->id_color; ?>">
                                <?php
                                echo '</td>';
                                echo '<td align="center" class="datoReserva">'.$stock.'</td>'; 
                                echo '<td align="center" class="datoReserva">'.$simbolo.' '.$precio.'</td>';
                                echo '<td align="center" class="datoReserva">'.$simbolo.' '.$subtotal.'</td>';
                                echo '</tr>';
                                $total=$total + $subtotal;
                                $i++;
                            }
                            $total = number_format($total, 3, '.', '');
                            ?>
                            <tr>
                                <td colspan="6" style="background:#eee; color:#000; font-weight:700;"></td>
                                <td class="encabezado_reserva" style="font-size:12px;">SUBTOTAL</td>
                                <td class="encabezado_reserva" style="font-size:12px;"><?php echo $simbolo.' '.$total; ?></td>
                            </tr>
                            </tbody>
                        </table> 
                        <?php
                            if( ($orden->lleva_cargos==1) && ($orden->tiene_cargos==1) )
                            {
                        ?>
                        <h3 class="h3Reserv">CARGOS ADICIONALES</h3>
                        <table width="100%" cellspacing="1">
                            <thead>
                                <tr>
                                    <th width="10%" class="encabezado_reserva">N</th>
                                    <th width="70%" class="encabezado_reserva">CONCEPTO</th>
                                    <th width="20%" class="encabezado_reserva">MONTO</th>
                                </tr>
                            </thead>   
                            <tbody>
                            <?php
                                $j = 0;
                                $total = $orden->total;
                                $total_cargos = 0;
                                foreach($cargos as $cargo)
                                {
                                    echo '<tr>';
                                    echo '<td align="center" class="datoReserva">'.($i+1).'</td>';
                                    echo '<td align="left" class="datoReserva" style="padding-left:20px;">'.$cargo->concepto.'</td>';
                                    echo '<td align="center" class="datoReserva">'.$simbolo.' '.$cargo->monto.'</td>';
                                    echo '<tr>';
                                    $j++;
                                    $total_cargos += $cargo->monto;
                                    $total += $cargo->monto;
                                }
                            ?>
                                <tr>
                                    <td class="datoReserva"></td>
                                    <td class="datoReserva" align="right" style="padding-right:20px; font-weight:700;">SUBTOTAL</td>
                                    <td class="datoReserva" align="center"><?php echo $simbolo.' '.$total_cargos; ?></td>
                                </tr>
                                <tr>
                                    <td class="encabezado_reserva"></td>
                                    <td align="center" class="encabezado_reserva" style="font-size:16px;">TOTAL</td>
                                    <td class="encabezado_reserva" style="font-size:16px;"><?php echo $simbolo.' '.number_format($total, 3, '.', ''); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                            } // if lleva_cargos
                        ?>
                    </div>                                                                       
               </div><!-- tooltip-demo well--> 
               <div id="botoneraDetalleCompra">
                   <div id="btnsIzq"><a href="javascript:history.back(-1)" class="btnRojo">VOLVER AL LISTADO</a></div>
                   <div id="btnsDer">
                       <!--<a href="reservas/comprar/<?php echo $orden->id_orden; ?>" class="btnRojo">COMPRAR</a>-->
                       <input type="hidden" name="num_items" id="num_items" value="<?php echo $i; ?>">
                       <input type="hidden" name="id_reserva" id="id_reserva" value="<?php echo $orden->id_orden; ?>">
                       <input type="submit" value="ACTUALIZAR RESERVA" class="btnAzul">
                   </div>
               </div><!-- botoneraDetalleCompra --> 
                </form>
            <?php
                } // else
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>