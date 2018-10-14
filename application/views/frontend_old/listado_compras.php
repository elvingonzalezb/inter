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
              <h1 class="nice-title">Listado de Compras</h1>
            </div>
            <div class="contenido">
            <?php
                $moneda = $this->session->userdata('moneda');                
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
                if(count($ordenes)>0)
                {
            ?>
            <h2>Listado de Compras</h2>
            <p>Viendo <?php echo count($ordenes); ?> compras de un total de <?php echo $num_pedidos; ?></p>
            <table width="100%" cellspacing="1">
                <thead>
                    <tr>
                        <th width="5%" class="encabezado_reserva">NRO</th>
                        <th width="10%" class="encabezado_reserva">CODIGO</th>
                        <!--<th width="15%" class="encabezado_reserva">PRODUCTOS</th>-->
                        <th width="10%" class="encabezado_reserva">MONTO</th>
                        <th width="10%" class="encabezado_reserva">ESTADO</th>
                        <th width="13%" class="encabezado_reserva">FECHA</th>
                        <th width="22%" class="encabezado_reserva">DATOS PAGO</th>
                        <th width="15%" class="encabezado_reserva">ACCION</th>
                    </tr>
                </thead> 
                <tbody>
                <?php
                    $indice_inicial = $pedidos_x_pagina*($pagina - 1);
                    $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                    
                    $mes_current = 0;
                    $agno_current = 0;
                    $i = 0;
                    foreach($ordenes as $compra)
                    {
                        $id_orden = $compra->id_orden;
			$total = totalCompra($id_orden, $moneda);
                        $estado = $compra->estado;                        
                        $codigo_orden = 10000 + $compra->id_orden; 
                        $codigos_productos = codigosProductosCompras($compra->id_orden);
                        $fecha_ingreso = $compra->fecha_ingreso; 
                        $aux_x = explode(" ", $fecha_ingreso);
                        $aux_y = explode("-", $aux_x[0]);
                        $mes = (int)($aux_y[1]);
                        $agno = $aux_y[0];
                        $indice_current = $indice_inicial + $i + 1;
                        if($mes!=$mes_current)
                        {
                            // Cambio de mes, ponemos titulo
                            echo '<tr>';
                            echo '<td colspan="8" align="center" height="20" class="encabezado_reserva_2">'.$meses[$mes].' del '.$agno.'</td>';
                            echo '</tr>';
                            $mes_current = $mes;
                            $agno_current = $agno;
                        }
                        $forma_pago = $compra->forma_pago;
                        $banco = $compra->banco;
                        $numero_operacion = $compra->numero_operacion;
                        $fecha_pago = Ymd_2_dmY($compra->fecha_pago);
                        $estado_pago = $compra->estado_pago;
                        switch($estado_pago)
                        {
                            case "Pendiente":
                               $estatusPago = '<span class="pagoPendiente">PENDIENTE</span>';
                            break;
                        
                            case "Pagado":
                               $estatusPago = '<span class="pagoPagado">PAGADO</span>';
                            break;
                        
                            case "Vencido":
                               $estatusPago = '<span class="pagoVencido">VENCIDO</span>';
                            break;
                        }
                        switch($forma_pago)
                        {
                            case "transferencia":
                            case "deposito":
                                $datos_pago = $estatusPago.'<br>';
                                $datos_pago .= '<strong>Forma:</strong> '.$forma_pago.'<br>';
                                $datos_pago .= '<strong>Banco:</strong> '.$banco.'<br>';
                                $datos_pago .= '<strong>Num. Op.:</strong> '.$numero_operacion.'<br>';
                                $datos_pago .= '<strong>Fecha Pago:</strong> '.$fecha_pago;
                            break;
                        
                            case "credito":
                            case "efectivo":
                                $datos_pago = $estatusPago.'<br>';
                                $datos_pago .= 'Forma de Pago: '.$forma_pago;
                            break;
                                
                            default:
                                $datos_pago = '-------';
                            break;
                        }
                        echo '<tr>';
                        echo '<td align="center" class="datoReserva">'.$indice_current.'</td>';
			echo '<td align="center" class="datoReserva">'.$codigo_orden.'</td>';       
                        //echo '<td align="center" class="datoReserva">'.$codigos_productos.'</td>';
                        echo '<td align="center" class="datoReserva">'.$simbolo.' '.$total.'</td>';
                        echo '<td align="center" class="datoReserva">'.$estado.'</td>';
                        echo '<td align="center" class="datoReserva">'.$fecha_ingreso.'</td>';
                        echo '<td align="left" class="datoReserva" style="padding-left:5px;">'.$datos_pago.'</td>';
                        echo '<td align="center" class="datoReserva">';
                        echo '<a class="btnVerde" href="compras/detalle/'.$id_orden.'">DETALLE</a><br />';
                        echo '</td>';
                        echo '</tr>';
                        $i++;
                    }                
                ?>
                </tbody>
            </table>
            <div class="paginacion clearfix">
            <ul>
            <?php
            echo '<li class="titulo">Páginas : </li>';
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
            for($w=$indice_ini; $w<=$indice_fin; $w++)
            //for($w=1; $w<=$num_paginas; $w++)
            {
               if($w==$pagina)
                {
                    echo '<li><a href="compras/listado/'.$w.'" class="actual">'.$w.'</a></li>';
                }
                else
                {
                    echo '<li><a href="compras/listado/'.$w.'" >'.$w.'</a></li>';
                }
            }
            ?>
            </ul>
            </div><!--paginacion-->
            <?php
                } // if(count($ordenes)>0)
                else
                {
                    echo '<h2>Listado de Compras</h2>';
                    echo '<div class="msgAlerta">En este momento no tiene compras registradas</div>';
                }
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>