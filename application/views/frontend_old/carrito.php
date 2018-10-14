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
              <h1 class="nice-title">Carrito de Pedidos</h1>
            </div>
            <div class="contenido">

                <div class="sub_contenido">
                <?php
                    if(isset($resultado))
                    {
                        switch($resultado)
                        {
                            default:
                            case "carro":			
                                if($this->session->userdata('carrito'))
                                {                                                                       
                                    if( (isset($resultado2)) && ($resultado2=="limite") )
                                    {
                                        echo '<div class="msgCarrito msgRojo">';
                                         echo '<span><i class="fa fa-exclamation-triangle fa-5x"></i></span>';
                                         echo '<p class="limMax">MAXIMO 14 ARTICULOS POR PEDIDO</p>';
                                         echo '</div>';
                                    }
                                    else
                                    {                                        
                                         echo '<div class="msgCarrito msgAzul">';
                                         echo '<span><i class="fa fa-exclamation-triangle fa-5x"></i></span>';
                                         echo '<p>Los productos elegidos han sido agregados a su pedido. Recuerde que no serán descontados del stock hasta que haya culminado con su reserva.</p>';
                                         echo '</div>';
                                        /*
                                        echo '<div class="msgCarrito msgRojo">';
                                        echo '<span><i class="fa fa-exclamation-triangle fa-5x"></i></span>';
                                        echo '<p style="font-size:16px;">Por motivos de inventario, los pedidos y compras estan restringidos hasta el dia Sabado 2 de Enero a las 6pm</p>';
                                        echo '</div>'; 
                                        //*/
                                    }
                 ?>
                <form id="formPedido" action="frontend/ajax/enviarReserva" method="post" onsubmit="return preguntaReserva('<?php echo getConfig("horas_duracion_reserva"); ?>')">
                <table width="100%" cellspacing="1">
                    <tr>
                        <td class="encabezado_carro" width="5%">N</td>                        
                        <td class="encabezado_carro" width="30%">Producto</td>
                        <!--<td class="encabezado_carro" width="8%">C&oacute;digo</td>-->
                        <td class="encabezado_carro" width="5%">Color</td>
                        <td class="encabezado_carro" width="11%">Color</td>
                        <td class="encabezado_carro" width="20%">Cantidad</td>
                        <td class="encabezado_carro" width="12%">Precio</td>
                        <td class="encabezado_carro" width="12%">Subtotal</td>
                        <!--<td class="encabezado_carro" width="10%">Disponibilidad</td>-->
                    </tr>
                 <?php
                    $carrito=$this->session->userdata('carrito');
                    $cont=0;
                    $total=0;
                    $moneda = $this->session->userdata('moneda');
                    switch($moneda)
                    {
                        case "d":
                            $simbolo = 'US$';
                        break;
                    
                        case "s":
                            $simbolo = 'S/';
                        break;
                    }
                    foreach ($carrito as $value=>$key) 
                    {
                        $cont +=1;
                        $id = $key['id'];                            
                        $codigo = $key['codigo'];
                        $nombre = $key['nombre']; 
                        $id_producto = $key['id_producto'];
                        $cadena = formateaCadena($nombre);
                        $link_prod = '<a href="detalle-producto/'.$id_producto.'/'.$cadena.'">'.$nombre.' - COD.: '.$codigo.'</a>';
                        $color = $key['color'];                            
                        $cantidad = $key['cantidad'];
                        $id_color = $key['id_color'];
                        $stock = $key['stock'];
                        $nombre_color = getColorName($id_color);
                        $uni = $key['uni'];					
                        // vemos si es en SOLES o DOLARES
                        if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='s')
                        {
                           $t_c = 1;
                           $uni = 'S/.';
                           $dscto = 1;
                        }
                        else if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='d')
                        {
                            $t_c = getConfig("tipo_cambio_dolar");
                            $uni = 'US$ ';
                            // vemos si tiene descuento
                            if($key['dscto']=='si')
                            {
                                $dscto=getConfig("descuento");
                            }
                            else
                            {
                                $dscto=1;
                            }                          
                        }
                        else
                        {
                            $t_c=1;$dscto=1;
                        }
                        $precio = ($key['precio'])/$t_c/$dscto;
                        $precio = number_format($precio, 3, '.', ',');
                        $subtot = number_format(($precio * $cantidad), 3, '.', '');
                        $total = $total + $subtot;
		?>
                <tr>
                    <td class="contenido_carro" align="center"><?php echo $cont; ?></td>                    
                    <td class="contenido_carro"><?php echo $link_prod; ?></td>
                    <!--<td class="contenido_carro"><?php echo $codigo; ?></td>-->
                    <td class="contenido_carro" align="center"><div class="cuadr" style="background: <?php echo $color; ?>"></div></td>
                    <td class="contenido_carro"><?php echo $nombre_color; ?></td>
                    <td class="contenido_carro">
                        <input type="text" onKeyPress="return checkIt(event)" class="campo" id="cant_<?php echo $id;?>" size="5" value="<?php echo $cantidad; ?>" />
                        &nbsp;&nbsp;
                        <a href="javascript:actualiza_carrito(<?php echo $id?>)"><img src="assets/frontend/cki/imagenes/update.png" title="Actualizar" align="absmiddle"/></a>  
                        &nbsp;&nbsp;
                        <a href="javascript:elimina_item_carrito(<?php echo $id?>)"><img src="assets/frontend/cki/imagenes/del.png" title="Eliminar Item" align="absmiddle"/></a>
                        <input type="hidden" name="stock_<?php echo $id; ?>" id="stock_<?php echo $id; ?>" value="<?php echo $stock; ?>">
                    </td>
                    <td class="contenido_carro" align="center"><?php echo $simbolo.' '.$precio; ?></td>
                    <td class="contenido_carro" align="center"><?php echo $simbolo.' '.$subtot; ?></td>                                
                    <!--<td class="contenido_carro" align="center">Inmediata</td>-->
                </tr>
                <?php
                    } // for each
                ?>
                <tr>
                    <td colspan="5"  class="encabezado_carro"></td>
                    <td class="encabezado_carro"><strong>TOTAL</strong></td>
                    <td class="encabezado_carro"><strong><?php echo $uni.number_format($total, 3, '.', ',');?></strong></td>
                    <!--<td class="encabezado_carro"></td>-->
                </tr>
                <tr>
                    <td colspan="8" height="5"></td>
                </tr>
                <tr>
                    <td colspan="8" class="nota" align="left"><strong>NOTA.-</strong> Los precios incluyen IGV</td>
                </tr>
                </table>
                <?php
                    // ********** CARGOS ADICIONALES ************
                    switch($tiene_cargos)
                    {
                        case 0:
                            
                        break;
                    
                        case 1:
                            echo '<h2>CARGOS ADICIONALES</h2>';
                            echo '<div class="msgCarrito msgRojo">';
                            echo '<span><i class="fa fa-money fa-5x"></i></span>';
                            echo '<p>Su pedido tendra cargos adicionales. Una vez que estos se agreguen usted podra concretar su compra.</p>';
                            echo '</div>';
                        break;
                    
                        case 2:
                            echo '<h2>CARGOS ADICIONALES</h2>';
                            echo '<div class="msgCarrito msgNaranja">';
                            echo '<span><i class="fa fa-calculator fa-5x"></i></span>';
                            echo '<p>Su pedido tendra cargos adicionales. Una vez que estos se agreguen usted podra concretar su compra.</p>';
                            echo '</div>';                            
                        break;
                    } // switch

                ?>
                <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="5%" height="5"></td>
                    <td width="20%"></td>
                    <td width="70%"></td>
                    <td width="5%"></td>
                </tr>
                <tr>
                    <td height="20"></td>
                    <td align="left" class="subtituloCarro2">MENSAJE</td>
                    <td align="left"><input type="text" id="mensaje_reserva" size="60" name="mensaje_reserva" class="campo"></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" height="5"></td>
                </tr>
                </table>                    
                <table width="100%" cellspacing="2">  
                <tr>
                    <td colspan="8">
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="50%" align="left">
                                    <input type="button" onclick="elimina_todo_carrito()" value="ELIMINAR PEDIDO" class="btnElimina"></td>
                                <td width="50%" align="center">
                                    <input type="hidden" name="operacion" id="operacion" value="">
                                    <input type="button" onclick="goProductos()" value="SEGUIR AGREGANDO (Max. 14 productos por pedido)" class="btnSeguirAgregando"></td>
                            </tr>
                            <tr>
                                <td colspan="2" height="25"></td>
                            </tr>
                                <?php
                    // ********** CARGOS ADICIONALES ************
                    switch($tiene_cargos)
                    {
                        case 0:
                            // No lleva cargos, puede comprar o reservar
                ?>
                <tr>
                    <td align="right">
                        <input type="button" onclick="submitFormulario('reserva')" value="GENERAR RESERVA" class="btnReservar">
                    </td>
                    <td align="right">
                        <input type="button" onclick="submitFormulario('compra')" value="COMPRAR" class="btnComprar">
                    </td>                                
                </tr>
                <?php
                        break;
                    
                        case 1:
                        case 2:
                            // Si lleva cargos o lleva a veces, solo se le muestra el boton de reservar
                ?>
                <tr>
                    <td align="center"></td>
                    <td align="center">
                        <!-- // EDITADO PARA DESACTIVAR OPERACIONES EN AÑO NUEVO -->
                        <input type="button" onclick="submitFormulario('reserva')" value="GENERAR RESERVA" class="btnReservar">
                    </td> 
                </tr>          
                <?php
                        break;
                    
                        default:
                            echo '<tr>';
                            echo '<td align="center"></td>';
                            echo '<td align="center"></td>';
                            echo '</tr>';
                        break;
                    } // switch

                ?>
                        </table>
                    </td>
                </tr>
                </table>
                </form>		
               <?php
                    }
                    else
                    {
                        echo '<h2>SU PEDIDO</h2>';
                        echo '<div class="msgCarrito msgRojo">';
                        echo '<span><i class="fa fa-cart-arrow-down fa-3x"></i></span>';
                        echo '<p>Su pedido esta vacio.</p>';
                        echo '</div>';
                    }
                    break;
                    
                    case "success-envio":
                ?>
                <div id="for_hecho">
                    <div id="div_cuenta">
                        <h3>Gracias por enviar su pedido. Lo invitamos a revisar su Correo Electr&oacute;nico</h3>
                        <?php
                        echo getConfig("cuentas_bancarias");
                        ?>
                    </div>

                </div>
                <?php                                
                    break;
                        
                    case "error-envio":
                ?>
                <div id="for_error">
                    Ocurrio un error al enviar su pedido, intentelo de nuevo click <a href="pedido/carro">Aqui</a>
                </div>
                <?php                                
                    break;
                
                    case "reserva-enviada":
                ?>
                <div id="for_hecho">
                    <div id="div_cuenta">
                        <h3>Se ha registrado la reserva de los productos elegidos</h3>
                        <p>Recuerde que esto es una reserva, no una compra. Luego de realizado el pago ingrese a su listado de reservas y registre su compra ingresando los datos del pago</p>
                        <p>Recuerde que tiene <?php echo getConfig("horas_duracion_reserva"); ?> horas para concretar su compra o su reserva se anulara.</p>
                    </div>

                </div>
                <?php  
                    break;
                
                    case "error-reserva":
                ?>
                <div id="for_error">
                    Ocurrio un error al enviar su reserva y esta no pudo concretarse, intentelo de nuevo click <a href="pedido/carro">Aqui</a>
                </div>
                <?php                                
                    break;
                
                
                    }
                }
                ?>

                </div>
            </div>
        </div><!--wrap-featured-products-->        
        
      </div>
    </div>
  </div>
</div>