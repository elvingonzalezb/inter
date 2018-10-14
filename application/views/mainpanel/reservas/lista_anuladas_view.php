<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
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
    else if (isset($resultado) && ($resultado == "extension-success"))
    {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La reserva se extendio correctamente';
        echo '</div>';        
    }
    else if (isset($resultado) && ($resultado == "borrado-success"))
    {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La reserva se elimino correctamente';
        echo '</div>';         
    }
    ?>    
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Lista de Reservas Anuladas</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="reservas/ajaxListaReservasAnuladas">
                <thead>
                    <tr>
                        <th width="5%">NRO</th>
                        <th width="8%">COD. RESERVA</th>
                        <th width="15%">CLIENTE</th>
                        <th width="10%">CODS PRODS</th>
                        <th width="9%">MONTO</th>
                        <th width="9%">ESTADO</th>
                        <th width="9%">FECHA INGRESO</th>
                        <th width="9%">FECHA ANULACION</th>
                        <th width="9%">EN STOCK?</th>
                        <th width="15%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    //var_dump($categorias);
                    /*$indice_inicial = $pedidos_x_pagina*($pagina - 1);
                    for($i=0; $i<count($ordenes); $i++)
                    {
                        $current = $ordenes[$i];
                        $id_orden = $current['id_orden'];
                        $codigo_orden = $current['codigo_orden'];                        
                        $nombre_cliente = $current['nombre_cliente'];
                        $ruc_cliente = $current['ruc_cliente'];
                        $razon_social_cliente = $current['razon_social_cliente'];
                        $datos_cliente = '<strong>'.$razon_social_cliente.'</strong><br>Persona contacto: '.$nombre_cliente;
                        
                        $estado = $current['estado'];
                        if($current['mensaje_anulacion']!="")
                        {
                            $estado .= '<br><a href="javascript:motivoAnulacion(\''.$current['mensaje_anulacion'].'\')">Ver Motivo</a>';
                        }
                        $codigos_productos = $current['codigos_productos'];
                        $fecha_ingreso = $current['fecha_hora_ingreso']; 
                        $fecha_anulacion = $current['fecha_anulacion'];
                        $en_stock = $current['en_stock'];
                        $total = totalReserva($id_orden, $current['moneda']);
                        $indice_current = $indice_inicial + $i + 1;
                        switch($current['moneda'])
                        {
                            case "d":
                                $simbolo = 'US$';                                
                            break;
                        
                            case "s":
                                $simbolo = 'S/';
                            break;
                        }
                        echo '<tr>';
                        echo '<td class="center">'.$indice_current.'</td>';
                        echo '<td>'.$codigo_orden.'</td>';                        
                        echo '<td class="center">'.$datos_cliente.'</td>';
                        echo '<td>'.$codigos_productos.'</td>';
                        echo '<td>'.$simbolo.' '.$total.'</td>';
                        echo '<td class="center">'.$estado.'</td>';
                        echo '<td class="center">'.$fecha_ingreso.'</td>';
                        echo '<td class="center">'.$fecha_anulacion.'</td>';
                        
                        echo '<td class="center">'.$en_stock.'</td>';
                        echo '<td>';
                        echo '<a class="btn btn-info" href="mainpanel/reservas/detalle/'.$id_orden.'"><i class="icon-edit icon-white"></i> DETALLE</a><br /><br />';
                        echo '<a class="btn btn-danger" href="javascript:borrarReserva(\''.$id_orden.'\')"><i class="icon-trash icon-white"></i> &nbsp;&nbsp;BORRAR</a><br /><br />';
                        if($en_stock=="SI")
                        {
                            echo '<a class="btn btn-success" href="javascript:reactivarReserva(\''.$id_orden.'\', \'800\', \'600\')"><i class="icon-edit icon-white"></i> REACTIVAR</a> ';						
                        }
                        echo '</td>';
                        echo '</tr>';
                    }*/
                ?>
                </tbody>
            </table>
            <!-- <div class="row-fluid">
                <div class="span6">
                    <div class="dataTables_info">Mostrando <?php echo count($ordenes); ?> de un total de <?php echo $num_pedidos; ?></div>
                </div>
                <div class="span6" style="text-align: right; padding-right: 10px;">Numero total de Páginas: <?php echo $num_paginas; ?></div>
            </div>
            <div class="span12 center">
                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                    <?php
                        if( ($pagina-5)<1 )
                        {
                            $indice_ini = 1;
                        }
                        else
                        {
                            $indice_ini = $pagina-5;
                        }
                        if( ($pagina+5)>$num_paginas )
                        {
                            $indice_fin = $num_paginas;
                        }
                        else
                        {
                            $indice_fin = $pagina+5;
                        }
                        for($i=$indice_ini; $i<=$indice_fin; $i++)
                        {
                            if($i==$pagina)
                            {
                                echo '<li class="active"><a href="mainpanel/reservas/listadoActivas/'.$i.'">'.$i.'</a></li>';
                            }
                            else
                            {
                                echo '<li><a href="mainpanel/reservas/listadoActivas/'.$i.'">'.$i.'</a></li>';
                            }                            
                        }
                    ?>
                    </ul>
                </div>
            </div> -->
        </div>
     </div><!--/span-->
</div><!--/row-->