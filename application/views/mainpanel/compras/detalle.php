<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/compras/listado/1">Listado de Compras</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/compras/buscador">Buscador de Compras</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Detalle de Compra</h2>
            <div class="box-icon">
                <a href="mainpanel/pedidos/listado" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
                <fieldset>
                    <?php
                        switch($orden->moneda)
                        {
                            case "s":
                                $simbolo = 'S/';
                            break;

                            case "d":
                                $simbolo = 'US$';
                            break;
                        }
                        if(isset($resultado) && ($resultado=="success"))
                        {
                            echo '<div class="alert alert-success">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                            echo '</div>';
                        }
                    ?>
                    <h3>FECHA DE LA COMPRA</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><h4>Fecha y hora:</h4></td>
                                <td>
                                <?php
                                    $aux_f = explode(" ", $orden->fecha_ingreso);
                                    $aux_f2 = explode("-", $aux_f[0]);
                                    $fecha_1 = $aux_f2[2]."/".$aux_f2[1]."/".$aux_f2[0];
                                    $fecha_orden = $fecha_1." ".$aux_f[1];
                                    echo $fecha_orden; 
                                ?>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                    <h3>Datos del Cliente</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <?php
                            if($existe_cliente=="no")
                            {
                        ?>
                        <tr>
                            <td><h4>Cliente:</h4></td>
                            <td><strong>--- CLIENTE ELIMINADO ---</strong></td>
                        </tr>
                        <?php
                            }
                            else
                            {
                        ?>
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
                        <?php
                            }
                        ?>                               
                        </tbody>
                    </table>                    

                   
                    <h3>Lista de Productos</h3>
                    <div class="tooltip-demo well">
                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable ">
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
                                </tbody>
                            </table>            
                        </div>                                                                       
                   </div><!-- tooltip-demo well-->  
                   <a class="btn btn-danger" href="mainpanel/compras/listado/1">VOLVER</a>

                </fieldset>


        </div>
    </div><!--/span-->

</div><!--/row-->