<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/pedidos/listado/1">Pedidos</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/pedidos/buscador">Buscador de Pedidos</a></li>
    </ul>
</div>
<div class="row-fluid sortable">    
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Resultados de Busqueda</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row-fluid">
                <div class="span6">
                    <div class="dataTables_info"><strong>FECHA DE INICIO:</strong> <?php echo $fecha_inicio; ?></div>
                </div>
                <div class="span6">
                    <div class="dataTables_info"><strong>FECHA DE FIN:</strong> <?php echo $fecha_fin; ?></div>
                </div>
            </div>
            <table class="table table-striped table-bordered bootstrap-datatable">
                <thead>
                    <tr>
                        <th width="5%">NRO</th>
                        <th width="10%">COD. PEDIDO</th>
                        <th width="15%">CLIENTE</th>
                        <th width="10%">RUC</th>
                        <th width="10%">CODS PRODS</th>
                        <th width="10%">MONTO</th>
                        <th width="10%">ESTADO</th>
                        <th width="10%">FECHA</th>
                        <th width="20%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    //var_dump($categorias);
                    for($i=0; $i<count($ordenes); $i++)
                    {
                        $current = $ordenes[$i];
                        $id_orden = $current['id_orden'];
			$codigo_orden = $current['codigo_orden'];                        
                        $nombre_cliente = $current['nombre_cliente'];
                        $ruc_cliente = $current['ruc_cliente'];
                        $razon_social_cliente = $current['razon_social_cliente'];
                        $datos_cliente = '<strong>'.$razon_social_cliente.'</strong><br>Persona contacto: '.$nombre_cliente;
                        $total = $current['total'];
                        $estado = $current['estado'];
                        $codigos_productos = $current['codigos_productos'];
                        $fecha_ingreso = substr($current['fecha_ingreso'],0,10); 
                        
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';
			echo '<td>'.$codigo_orden.'</td>';                        
                        echo '<td class="center">'.$datos_cliente.'</td>';
                        echo '<td>'.$ruc_cliente.'</td>';
			echo '<td>'.$codigos_productos.'</td>';
                        echo '<td>'.$total.'</td>';
                        echo '<td class="center">'.$estado.'</td>';
                        echo '<td class="center">'.$fecha_ingreso.'</td>';
                        echo '<td>';
                        echo '<a class="btn btn-info" href="mainpanel/pedidos/detalle/'.$id_orden.'"><i class="icon-edit icon-white"></i> DETALLE</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deletePedido(\''.$id_orden.'\')"><i class="icon-trash icon-white"></i> BORRAR</a><br /><br />';
                        echo '<a class="btn btn-success" href="javascript:printPedido(\''.$id_orden.'\', \'800\', \'600\')"><i class="icon-edit icon-white"></i> IMPRIMIR</a> ';						
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>
            <div class="row-fluid">
                <div class="span12">
                    <div class="dataTables_info">Mostrando <?php echo count($ordenes); ?> resultados</div>
                </div>
            </div>
        </div>
     </div><!--/span-->
</div><!--/row-->