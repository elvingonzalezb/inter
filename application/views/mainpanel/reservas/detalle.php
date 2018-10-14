<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Detalle de Reserva</h2>
            <div class="box-icon">
                <a href="mainpanel/pedidos/listado" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
                <fieldset>
                    <?php
                        if(isset($resultado) && ($resultado=="success"))
                        {
                            echo '<div class="alert alert-success">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                            echo '</div>';
                        }
                    ?>
                    <h3>DATOS DEL PEDIDO</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><h4>Nro de Reserva:</h4></td>
                                <td>
                                <?php
                                    $nro = $orden->id_orden + 10000;
                                    echo $nro; 
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Fecha y hora de Ingreso:</h4></td>
                                <td>
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
                                <td><h4>Fecha y hora de Caducidad:</h4></td>
                                <td>
                                <?php
                                    $caducidad = Ymd_2_dmYHora($orden->caducidad);
                                    echo $caducidad; 
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Tiempo Restante:</h4></td>
                                <td>
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
                    <h3>Datos del Cliente</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><h4>Raz&oacute;n Social:</h4></td>
                                <td>
                                    <?php echo $cliente->razon_social; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Nombre:</h4></td>
                                <td>
                                    <?php echo $cliente->nombre; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>RUC:</h4></td>
                                <td>
                                    <?php echo $cliente->ruc; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Domicilio:</h4></td>
                                <td>
                                    <?php echo $cliente->domicilio; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Ubicaci&oacute;n:</h4></td>
                                <td>
                                    <?php echo $cliente->ciudad.'-'.$cliente->provincia.'-'.$cliente->departamento; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>C&oacute;digo Postal:</h4></td>
                                <td>
                                    <?php echo $cliente->zip; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Tel&eacute;fono:</h4></td>
                                <td>
                                    <?php echo $cliente->telefono; ?>
                                </td>
                            </tr> 
                            <tr>
                                <td><h4>Fax:</h4></td>
                                <td>
                                    <?php echo $cliente->fax; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Tipo de Cliente:</h4></td>
                                <td>
                                    <?php echo $cliente->tipo_cliente;?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Email:</h4></td>
                                <td>
                                    <?php echo $cliente->email; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Comentario del Cliente:</h4></td>
                                <td>
                                    <?php echo $orden->mensaje;?>
                                </td>
                            </tr>                                 
                        </tbody>
                    </table>                    

                   
                    <h3>Contenido</h3>
                    <div class="tooltip-demo well">
                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable">
                                <thead>
                                    <tr>
                                        <th width="5%">C&oacute;digo</th>
                                        <th width="20%">Nombre del Producto</th>
                                        <th width="10%">Color</th>
                                        <th width="15%">Nombre Color</th>
                                        <th width="15%">Precio</th>
                                        <th width="15%">Cantidad</th>
                                        <th width="20%">Subtotal</th>
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
                                    echo '<td class="center">'.$detalle->codigo_producto.'</td>';                        
                                    echo '<td class="center">'.$detalle->nombre_producto.'</td>';
                                    echo '<td class="center"><div style="background:'.$detalle->codigo_color.';margen:15px;width:50px;height:50px;border:#000 solid 1px;"></td>';
                                    echo '<td class="center">'.$detalle->nombre_color.'</td>';
                                    echo '<td class="center">'.$simbolo.' '.$precio.'</td>';
                                    echo '<td class="center">'.$detalle->cantidad.'</td>';
                                    echo '<td class="center">'.$simbolo.' '.$subtotal.'</td>';
                                    echo '</tr>';
                                    $total=$total + $subtotal;
                                }
                              
                                ?>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td><strong>SUBTOTAL</strong></td>
                                        <td><strong><?php echo $simbolo.' '.$total; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table> 
                            <?php
                                if(count($cargos)>0)
                                {
                            ?>
                            <h3>CARGOS ADICIONALES</h3>
                            <table class="table table-striped table-bordered bootstrap-datatable">
                                <thead>
                                    <tr>
                                        <th width="65%">CONCEPTO</th>
                                        <th width="15%"></th>
                                        <th width="20%">MONTO</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                    foreach($cargos as $cargo)
                                    {
                                        $concepto = $cargo->concepto;
                                        $monto = $cargo->monto;
                                        $total += $monto;
                                        echo '<tr>';
                                        echo '<td colspan="2">'.$concepto.'</td>';
                                        echo '<td>'.$simbolo.' '.$monto.'</td>';
                                        echo '<tr>';
                                    }
                                ?>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL</strong></td>
                                        <td><strong><?php echo $simbolo.' '.$total; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                                }
                            ?>
                        </div>                                                                       
                   </div><!-- tooltip-demo well-->  
                   <a class="btn btn-danger" href="mainpanel/reservas/listadoActivas/1">VOLVER</a>

                </fieldset>


        </div>
    </div><!--/span-->

</div><!--/row-->