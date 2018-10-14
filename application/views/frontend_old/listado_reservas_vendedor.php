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
              <h1 class="nice-title">Listado de Reservas Activas</h1>
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
            <h2>Listado de Reservas de <?php echo $vendedor['nombre']; ?></h2>
            <table width="100%" cellspacing="1">
                <thead>
                    <tr>
                        <th width="5%" class="encabezado_reserva">NRO</th>
                        <th width="10%" class="encabezado_reserva">CODIGO</th>                        
                        <th width="15%" class="encabezado_reserva">INGRESO</th>
                        <th width="15%" class="encabezado_reserva">CADUCIDAD</th>
                        <th width="16%" class="encabezado_reserva">TIEMPO</th>
                        <th width="15%" class="encabezado_reserva">MONTO</th>
                        <th width="15%" class="encabezado_reserva">ACCION</th>
                    </tr>
                </thead> 
                <tbody>
                <?php
                    $indice_inicial = $pedidos_x_pagina*($pagina - 1);
                    $total_gnral = 0;
                    $i = 0;
                    foreach($ordenes as $reserva)
                    {
                        $indice_current = $indice_inicial + $i + 1;
                        $id_orden = $reserva->id_orden;
                        $codigo_orden = 10000 + $reserva->id_orden;
                        $fecha_ingreso = Ymd_2_dmYHora($reserva->fecha_ingreso);
                        $caducidad = Ymd_2_dmYHora($reserva->caducidad);
                        $tiempo_restante = tiempoRestante($reserva->fecha_ingreso, $reserva->caducidad);
                        $estado = $reserva->estado;
                        $lleva_cargos = $reserva->lleva_cargos;
                        $tiene_cargos = $reserva->tiene_cargos;
                        
                        $moneda_reserva = $reserva->moneda;
                        switch($moneda_reserva)
                        {
                            case "d":
                                $simbolo = 'US$';
                            break;

                            case "s":
                                $simbolo = 'S/';
                            break;
                        }
                        $total = totalReserva($id_orden, $moneda_reserva);
                        $total_cargos = totalCargos($id_orden);
                        $monto_2show = $total + $total_cargos;
                        $total_gnral += $monto_2show;
                        $id_vendedor = $vendedor->id;
                        echo '<tr>';
                        echo '<td align="center" class="datoReserva">'.$indice_current.'</td>';
			echo '<td align="center" class="datoReserva">'.$codigo_orden.'</td>';                          
                        echo '<td align="center" class="datoReserva">'.$fecha_ingreso.'</td>';
                        echo '<td align="center" class="datoReserva">'.$caducidad.'</td>';
                        echo '<td align="center" class="datoReserva">'.$tiempo_restante.'</td>';
                        echo '<td align="center" class="datoReserva">'.$simbolo.' '.$total.'</td>';
                        echo '<td align="center" class="datoReserva">';
                        echo '<a class="btnVerde" href="vendedores/detalleReserva/'.$id_vendedor.'/'.$id_orden.'">DETALLE</a><br />';
                        echo '</td>';                  
                        echo '</tr>';
                    }                
                ?>
                </tbody>
            </table>
            </form>
            <div class="paginacion clearfix">
            <ul>
            <?php
            echo '<li class="titulo">Páginas : </li>';
            for($w=1;$w<=$num_paginas;$w++)
            {
                if($w==$pagina)
                {
                    echo '<li><a href="vendedores/listaReservas/'.$id_vendedor.'/'.$w.'" class="actual">'.$w.'</a></li>';
                }
                else
                {
                    echo '<li><a href="vendedores/listaReservas/'.$id_vendedor.'/'.$w.'" >'.$w.'</a></li>';
                }
            }
            ?>
            </ul>
            </div><!--paginacion-->
            <?php
                } // if(count($ordenes)>0)
                else
                {
                    echo '<h2>Listado de Reservas de '.$vendedor['nombre'].'</h2>';
                    echo '<div class="msgAlerta">En este momento este vendedor no tiene reservas registradas</div>';
                }
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>