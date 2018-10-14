<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/pedidos/listado">Pedidos</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Detalle de Orden</h2>
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
                    <h3>FECHA DEL PEDIDO</h3>
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

                   
                    <h3>Lista de Productos</h3>
                    <div class="tooltip-demo well">
                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
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
                                    //var_dump($categorias);
                                $da=explode("~",$orden->pedidos);
                                $num_ped=$da[0];
                                $total='';
                                for($i=1; $i<=$num_ped; $i++)
                                {
                                    $da1=$da[$i];
                                    $da2=explode("@",$da1);
                                    $cantidad= $da2[1];
                                    $codigo= $da2[4];
                                    $nombre= $da2[5];
                                    $color= $da2[2];
                                    $precio= $da2[3];
                                    $subtotal= $da2[6];                                    
                                    $unid= $da2[7];
                                    if(!empty($da2[8]))
                                    {
                                        $id_color = $da2[8];
                                        $ci = &get_instance();
                                        $ci->load->model("mainpanel/Pedido_model");
                                        $aux_nombre_color = $ci->Pedido_model->nombreColor($id_color);
                                        $nombre_color = $aux_nombre_color->nombre;
                                    }
                                    else
                                    {
                                        $nombre_color = '--------';
                                    }
                                    //$nombre_color = $da2[8]; 
                                    echo '<tr>';
                                    echo '<td class="center">'.$codigo.'</td>';                        
                                    echo '<td class="center">'.$nombre.'</td>';
                                    echo '<td class="center"><div style="background:'.$color.';margen:15px;width:50px;height:50px;border:#000 solid 1px;"></td>';
                                    echo '<td class="center">'.$nombre_color.'</td>';
                                    echo '<td class="center">'.$precio.'</td>';
                                    echo '<td class="center">'.$cantidad.' ('.$unid.') </td>';
                                    echo '<td class="center">'.$subtotal.'</td>';
                                    echo '</tr>';
                                    $total=$total + $subtotal;
                                }
                              
                                ?>
                                </tbody>
                            </table>            
                        </div>                                                                       
                   </div><!-- tooltip-demo well-->  
                   <a class="btn btn-danger" href="mainpanel/pedidos/listado">VOLVER</a>

                </fieldset>


        </div>
    </div><!--/span-->

</div><!--/row-->