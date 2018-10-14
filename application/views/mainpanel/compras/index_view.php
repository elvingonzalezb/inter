<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/compras/listado/1">Compras ultimo mes</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/compras/listado3meses/1">Compras Ultimos 3 meses</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/compras/listado6meses/1">Compras ultimos 6 meses</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/compras/listado_todas/1">Todas las Compras</a></li>
        <!--<li><a href="mainpanel/compras/buscador">Buscador de Compras</a></li>-->
    </ul>
</div>
<div class="row-fluid sortable">
    <?php
    if (isset($resultado) && ($resultado == "success")) {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La operación se realizó con éxito';
        echo '</div>';
    }
    ?>    
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> 
            <?php 
                switch($tipo_listado)
                {
                    case 0:
                        echo 'TODAS LAS COMPRAS';
                    break;

                    case 1:
                        echo 'LISTADO DE COMPRAS DEL ULTIMO MES';
                    break;

                    case 3:
                        echo 'LISTADO DE COMPRAS DE LOS ULTIMOS 3 MES';
                    break;

                    case 6:
                        echo 'LISTADO DE COMPRAS DE LOS ULTIMOS 6 MES';
                    break;
                }
            ?>
            </h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <?php            
            /*if(count($ordenes)>0)
            {*/
        ?>        
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable"data-url="compras/ajaxListaCompras/<?=$tiempo?>">
                <thead>
                    <tr>
                        <th width="5%">NRO</th>
                        <th width="5%">COD. COMPRA</th>
                        <th width="5%">COD. RESERVA</th>
                        <th width="20%">CLIENTE</th>
                        <th width="10%">PRODUCTOS</th>
                        <th width="10%">MONTO</th>
                        <th width="20%">DATOS PAGO</th>
                        <th width="10%">FECHA</th>
                        <th width="10%">ACCION</th>                        
                    </tr>
                </thead>   
                <tbody>
                <?php
                   /* $i=0;
                    foreach($ordenes as $compra)
                    {
                        $id_orden = $compra->id_orden;
                        $moneda = $compra->moneda;
                        switch($moneda)
                        {
                            case "d":
                                $simbolo = 'US$';
                                $tipo_cambio = getConfig("tipo_cambio_dolar");
                            break;

                            case "s":
                                $simbolo = 'S/';
                                $tipo_cambio = 1;
                            break;
                        }  
			            $total = totalCompra($id_orden, $moneda);
                        $estado = $compra->estado;                        
                        $codigo_orden = 10000 + $compra->id_orden; 
                        $codigo_reserva = $compra->codigo_reserva; 
                        $codigos_productos = codigosProductosCompras($compra->id_orden);
                        $fecha_ingreso = YmdHora_2_dmY($compra->fecha_ingreso); 
                        $aux_x = explode(" ", $fecha_ingreso);
                        $aux_y = explode("-", $aux_x[0]);
                        $mes = (int)($aux_y[1]);
                        $agno = $aux_y[0];
                        $forma_pago = $compra->forma_pago;
                        $banco = $compra->banco;
                        $numero_operacion = $compra->numero_operacion;
                        $fecha_pago = Ymd_2_dmY($compra->fecha_pago);
                        $estado_pago = $compra->estado_pago;
                        $id_cliente = $compra->id_cliente;
                        $cliente = datosCliente($id_cliente);
                        switch($estado_pago)
                        {
                            case "Pendiente":
                               $estatusPago = '<span class="pagoPendiente">PENDIENTE</span><br>';
                            break;
                        
                            case "Pagado":
                               $estatusPago = '<span class="pagoPagado">PAGADO</span><br>';
                            break;
                        
                            case "Vencido":
                               $estatusPago = '<span class="pagoVencido">VENCIDO</span><br>';
                            break;
                        }
                        
                        if($forma_pago=="")
                        {
                            $datos_pago = '------';
                        }
                        else
                        {
                            $datos_pago = $estatusPago.'<br>';
                            switch($forma_pago)
                            {
                                case "transferencia":
                                case "deposito":
                                    $datos_pago .= '<strong>Forma de Pago: </strong>'.strtoupper($forma_pago).'<br>';
                                    $datos_pago .= '<strong>Banco: </strong>'.$banco.'<br>';
                                    $datos_pago .= '<strong>Num. Op.: </strong>'.$numero_operacion.'<br>';
                                    $datos_pago .= '<strong>Fecha Pago: </strong>'.$fecha_pago;
                                break;

                                case "credito":
                                case "efectivo":
                                    $datos_pago .= '<strong>Forma de Pago: </strong>'.$forma_pago;
                                break;

                                default:
                                    $datos_pago .= '-------';
                                break;
                            }//switch
                        }
                        $lista_cargos = explode("@", $compra->lista_cargos);
                        $monto_cargos = 0;
                        for($j=0; $j<count($lista_cargos); $j++)
                        {
                            $monto_cargos += $lista_cargos[$j];
                        }
                        if(count($lista_cargos)>0)
                        {
                            $total = $total + $monto_cargos;
                        }
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';
			            echo '<td>'.$codigo_orden.'</td>';                        
                        echo '<td>'.$codigo_reserva.'</td>'; 
                        echo '<td class="center">'.$cliente.'</td>';
			            echo '<td>'.$codigos_productos.'</td>';
                        echo '<td>'.$simbolo.' '.$total.'</td>';
                        echo '<td>'.$datos_pago.'</td>';
                        echo '<td class="center">'.$fecha_ingreso.'</td>';
                        echo '<td>';
                        echo '<a class="btn btn-info" href="mainpanel/compras/detalle/'.$id_orden.'"><i class="icon-edit icon-white"></i> DETALLE</a><br /><br />';
                        echo '<a class="btn btn-danger" href="javascript:anularCompra(\''.$id_orden.'\')"><i class="icon-trash icon-white"></i> ANULAR</a><br /><br />';
                        echo '<a class="btn btn-success" href="mainpanel/compras/editarPago/'.$id_orden.'"><i class="icon-edit icon-white"></i> EDITAR PAGO</a> ';						
                        echo '</td>';
                        echo '</tr>';
                        $i++;
                    }*/
                ?>
                </tbody>
            </table>
        </div>
        <?php
            //}
        ?>
     </div><!--/span-->
</div><!--/row-->