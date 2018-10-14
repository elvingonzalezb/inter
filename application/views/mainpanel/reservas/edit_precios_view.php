<?php
    $moneda = $orden->moneda;
    switch($moneda)
    {
        case "s":
            $simbolo = 'S/';
        break;

        case "d":
            $simbolo = 'US$';
        break;
    }
?>
<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Precios de Reserva</h2>
            <div class="box-icon">
                <a href="mainpanel/pedidos/listado" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
                <form class="form-horizontal" action="mainpanel/reservas/updatePreciosReserva" method="post">
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
                    <h3>LISTADO DE PRODUCTOS</h3>
                    
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
                                $i = 0;
                                $total = 0;
                                foreach($detalles as $detalle)
                                {
                                    $id_detalle = $detalle->id;
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
    echo '<td class="center">'.$detalle->codigo_producto.'</td>';                        
    echo '<td class="center">'.$detalle->nombre_producto.'</td>';
    echo '<td class="center"><div style="background:'.$detalle->codigo_color.';margen:15px;width:50px;height:50px;border:#000 solid 1px;"></td>';
    echo '<td class="center">'.$detalle->nombre_color.'</td>';
    echo '<td class="center">';
    echo '<input type="text" name="precio_'.$i.'" class="span6 typeahead" value="'.$precio.'">';
    echo '<input type="hidden" name="id_detalle_'.$i.'" id="id_detalle_'.$i.'" value="'.$detalle->id.'">';
    echo '</td>';
    echo '<td class="center">'.$detalle->cantidad.'</td>';
    echo '<td class="center">'.$simbolo.' '.$subtotal.'</td>';
echo '</tr>';
                                    $total=$total + $subtotal;
                                    $i++;
                                }
                              
                                ?>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td><strong>SUBTOTAL</strong></td>
                                        <td><strong><?php echo $simbolo.' '.$total; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                                                                       
                   </div><!-- tooltip-demo well-->  
                   <div class="form-actions">
                        <input type="hidden" name="id_cliente" value="<?php echo $orden->id_cliente; ?>">
                        <input type="hidden" name="num_items" value="<?php echo $i; ?>">
                        <input type="hidden" name="moneda" value="<?php echo $moneda; ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $orden->id_orden; ?>">
                        <input type="submit" class="btn btn-primary" value="ACTUALIZAR PRECIOS">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/reservas/listadoActivas/1">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
                </form>
        </div>
    </div><!--/span-->

</div><!--/row-->