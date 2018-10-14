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
              <h1 class="nice-title">Detalle de Reserva</h1>
            </div>
            <div class="contenido">
            <?php
                if($resultado==0)
                {
                    echo '<div class="msgAlerta">';
                    echo '<p>No puede ver los detalles de esa reserva porque le pertenece a otro cliente.</p>';
                    echo '<a href="javascript:history.back(-1)">VOLVER</a>';
                    echo '</div>';
                }
                else 
                {     
            ?>
                <h3 class="h3Reserv">DATOS DE LA RESERVA</h3>
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
                            <td align="left" valign="middle" class="cell_1">Tipo de Reserva:</td>
                            <td align="left" valign="middle" class="cell_2">
                            <?php
                                switch($orden->tipo_reserva)
                                {
                                    case "stock":
                                        echo '<span class="rojo">Reserva de productos en Stock</span>';
                                    break;
                                
                                    case "proximamente":
                                        echo '<span class="rojo">Reserva de productos proximos a llegar</span>';
                                    break;
                                }
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
                <div class="tooltip-demo well">
                    <div class="box-content">
                        <table width="100%" cellspacing="1">
                            <thead>
                                <tr>
                                <?php
                                switch($orden->tipo_reserva)
                                {
                                    case "stock":
                                ?>
                                <th width="5%" class="encabezado_reserva">C&oacute;digo</th>
                                <th width="20%" class="encabezado_reserva">Nombre del Producto</th>
                                <th width="10%" class="encabezado_reserva">Color</th>
                                <th width="15%" class="encabezado_reserva">Nombre Color</th>
                                <th width="15%" class="encabezado_reserva">Cantidad</th>
                                <th width="15%" class="encabezado_reserva">Precio</th>                                    
                                <th width="20%" class="encabezado_reserva">Subtotal</th>                                    
                                <?php
                                    break;
                                
                                    case "proximamente":
                                ?>
                                <th width="5%" class="encabezado_reserva">C&oacute;digo</th>
                                <th width="20%" class="encabezado_reserva">Nombre del Producto</th>
                                <th width="10%" class="encabezado_reserva">Color</th>
                                <th width="15%" class="encabezado_reserva">Nombre Color</th>
                                <th width="12%" class="encabezado_reserva">Fecha Llegada</th>
                                <th width="12%" class="encabezado_reserva">Cantidad</th>
                                <th width="12%" class="encabezado_reserva">Precio</th>                                    
                                <th width="14%" class="encabezado_reserva">Subtotal</th>                                    
                                <?php
                                    break;
                                }                        
                                ?>
                                </tr>
                            </thead>   
                            <tbody>
                            <?php
                            $total = '';
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
                                $st = $precio*($detalle->cantidad);
                                $subtotal = redondeado($st, 3);
                                $subtotal = number_format($subtotal, 3, '.', '');
                                echo '<tr>';
                                echo '<td align="center" class="datoReserva">'.$detalle->codigo_producto.'</td>';                        
                                echo '<td align="center" class="datoReserva">'.$detalle->nombre_producto.'</td>';
                                echo '<td align="center" class="datoReserva"><div style="background:'.$detalle->codigo_color.';margen:15px;width:30px;height:30px;border:#000 solid 1px;"></td>';
                                echo '<td align="center" class="datoReserva">'.$detalle->nombre_color.'</td>';
                                if($orden->tipo_reserva=="proximamente")
                                {
                                    $ci =& get_instance();
                                    $fecha_llegada = $ci->Reservas_model->getFechaLlegada($detalle->id_producto, $detalle->id_color);
                                    echo '<td align="center" class="datoReserva">'.Ymd_2_dmY($fecha_llegada).'</td>';
                                }
                                echo '<td align="center" class="datoReserva">'.$detalle->cantidad.'</td>';
                                echo '<td align="center" class="datoReserva">'.$simbolo.' '.$precio.'</td>';                                
                                echo '<td align="center" class="datoReserva">'.$simbolo.' '.$subtotal.'</td>';
                                echo '</tr>';
                                $total = $total + $st;
                            }
                            $total = number_format(redondeado($total, 3), 3, '.', '');
                            ?>
                            <tr>
                                <td colspan="<?php if($orden->tipo_reserva=="proximamente") echo '6'; else echo '5'; ?>"></td>
                                <td class="encabezado_reserva" style="font-size:14px;">SUBTOTAL</td>
                                <td class="encabezado_reserva" style="font-size:14px;"><?php echo $simbolo.' '.$total; ?></td>
                            </tr>
                            </tbody>
                        </table> 
                        <?php
                            if( ($orden->lleva_cargos>0) && ($orden->tiene_cargos==1) )
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
                                $i = 0;
                                $total_cargos = 0;
                                foreach($cargos as $cargo)
                                {
                                    echo '<tr>';
                                    echo '<td align="center" class="datoReserva">'.($i+1).'</td>';
                                    echo '<td align="left" class="datoReserva" style="padding-left:20px;">'.$cargo->concepto.'</td>';
                                    echo '<td align="center" class="datoReserva">'.$simbolo.' '.$cargo->monto.'</td>';
                                    echo '</tr>';
                                    $i++;
                                    $total_cargos += $cargo->monto;
                                }
                            ?>
                                <tr>
                                    <td class="datoReserva"></td>
                                    <td class="datoReserva" align="right" style="padding-right:20px; font-weight:700;">SUBTOTAL</td>
                                    <td class="datoReserva" align="center"><?php echo $simbolo.' '.$total_cargos; ?></td>
                                </tr>
                            <?php
                                $total = $total + $total_cargos;
                                $total_general = number_format(redondeado($total,3), 3, '.', '')
                            ?>
                                <tr>
                                    <td class="encabezado_reserva"></td>
                                    <td align="center" class="encabezado_reserva" style="font-size:16px;">TOTAL</td>
                                    <td class="encabezado_reserva" style="font-size:16px;"><?php echo $simbolo.' '.$total_general; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                            } // if lleva_cargos
                        ?>
                    </div>                                                                       
               </div><!-- tooltip-demo well--> 
               <div id="botoneraDetalleCompra">
                   <div id="btnsIzq">
                       <a href="javascript:history.back(-1)" class="btnRojo">VOLVER AL LISTADO</a></div>
                    <div id="btnsIzq2">
                       <a href="javascript:printReserva(<?php echo $orden->id_orden; ?>)" class="btnRojo">IMPRIMIR</a></div>
                   <div id="btnsDer">
                    <?php
                        if($orden->estado==="Activa")
                        {
                            switch($orden->lleva_cargos)
                            {
                                case 0:
                                    // No lleva cargos
                                    echo '<a class="btnRojo" href="reservas/comprar/'.$orden->id_orden.'">COMPRAR</a><br>';
                                break;
                            
                                case 1:
                                   // Esta obligado a tener cargos y si los tiene agregados
                                   if($orden->tiene_cargos==1)
                                   {
                                       echo '<a class="btnRojo" href="reservas/comprar/'.$orden->id_orden.'">COMPRAR</a><br>';
                                   }
                                break;
                            
                                case 2:
                                    // Puede o no llevar cargos extra
                                    if($orden->tiene_cargos==1)
                                    {
                                        echo '<a class="btnRojo" href="reservas/comprar/'.$orden->id_orden.'">COMPRAR</a><br>';
                                    }
                                break;
                            } // switch                            
                        }                
                    ?>
                   </div>
               </div><!-- botoneraDetalleCompra -->               
            <?php
                } // else
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>