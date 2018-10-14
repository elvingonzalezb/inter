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
              <h1 class="nice-title">Listado de Compras de Vendedores</h1>
            </div>
            <div class="contenido">
            <h2>Listado de Vendedores</h2>
            <p>Si desea registrar un nuevo vendedor haga <a href="vendedores/nuevo">CLICK AQUI</a></p>
            <?php
                if(isset($resultado))
                {
                    switch($resultado)
                    {
                        case "agregado":
                            echo '<div class="exito">Se agrego correctamente al vendedor</div>';
                        break;
                    
                        case "eliminado":
                            echo '<div class="exito">El vendedor fue eliminado</div>';
                        break;
                    }
                }
                if(count($vendedores)>0)
                {
            ?>            
            <table width="100%" cellspacing="1">
                <thead>
                    <tr>
                        <th width="5%" class="encabezado_reserva">NRO</th>
                        <th width="20%" class="encabezado_reserva">NOMBRE</th>                        
                        <th width="15%" class="encabezado_reserva">CARGO</th>
                        <th width="20%" class="encabezado_reserva">EMAIL</th>
                        <th width="15%" class="encabezado_reserva">ULTIMO INGRESO</th>
                        <th width="10%" class="encabezado_reserva">ESTADO</th>
                        <th width="20%" class="encabezado_reserva">ACCION</th>
                    </tr>
                </thead> 
                <tbody>
                <?php
                    $i = 0;
                    foreach($vendedores as $current)
                    {
                        $id = $current->id;
                        $nombre = $current->nombre;
                        $cargo = $current->cargo;
                        $telefono = $current->telefono;
                        $email = $current->email;
                        $clave = $current->clave;
                        $last_login = $current->last_login;
                        $estado = $current->estado;
                        echo '<tr>';
                        echo '<td align="center" class="datoReserva">'.($i + 1).'</td>';
			echo '<td align="center" class="datoReserva">'.$nombre.'</td>';                          
                        echo '<td align="center" class="datoReserva">'.$cargo.'</td>';
                        echo '<td align="center" class="datoReserva">'.$email.'</td>';
                        echo '<td align="center" class="datoReserva">'.$last_login.'</td>';
                        echo '<td align="center" class="datoReserva">'.$estado.'</td>';
                        echo '<td align="center" class="datoReserva">';
                            echo '<a class="btnVerde" href="vendedores/detalle/'.$id.'">DETALLE</a><br />';
                            // EDITADO PARA DESACTIVAR OPERACIONES EN AÑO NUEVO
                            echo '<a class="btnNaranja" href="vendedores/editar/'.$id.'">EDITAR</a><br />';
                            echo '<a class="btnAzul" href="javascript:eliminarVendedor(\''.$id.'\')">ELIMINAR</a>';
                        echo '</td>';                
                        echo '</tr>';
                        $i++;
                    }                
                ?>
                </tbody>
            </table>
            <?php
                } // if(count($ordenes)>0)
                else
                {
                    echo '<div class="msgAlerta">En este momento no tiene vendedores registrados</div>';
                }
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>