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
                            case "carro":			
                                if($this->session->userdata('carrito'))
                                {
                 ?>
                <form id="formPedido" action="frontend/ajax/enviarPedido" method="post" onsubmit="return pregunta()">
                <table width="100%" cellspacing="2">
                    <tr>
                        <td class="encabezado_carro" width="5%">N</td>                        
                        <td class="encabezado_carro" width="20%">Producto</td>
                        <!--<td class="encabezado_carro" width="8%">C&oacute;digo</td>-->
                        <td class="encabezado_carro" width="5%">Color</td>
                        <td class="encabezado_carro" width="10%">Color</td>
                        <td class="encabezado_carro" width="25%">Cantidad</td>
                        <td class="encabezado_carro" width="10%">Precio</td>
                        <td class="encabezado_carro" width="10%">Subtotal</td>
                        <td class="encabezado_carro" width="10%">Disponibilidad</td>
                    </tr>
                 <?php
                    $carrito=$this->session->userdata('carrito');
                    $cont=0;
                    $total=0;
                    foreach ($carrito as $value=>$key) 
                    {
                        $cont +=1;
                        $id=$key['id'];                            
                        $codigo=$key['codigo'];
                        $nombre=$key['nombre']; 
                        $id_producto = $key['id_producto'];
                        $cadena = formateaCadena($nombre);
                        $link_prod = '<a href="detalle-producto/'.$id_producto.'/'.$cadena.'">'.$nombre.' - COD.: '.$codigo.'</a>';
                        $color=$key['color'];                            
                        $cantidad=$key['cantidad'];
                        $id_color = $key['id_color'];
                        $stock = $key['stock'];
                        $nombre_color = getColorName($id_color);
                        $uni=$key['uni'];					
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
                        <input type="text" onKeyPress="return checkIt(event)" class="campo" id="cant_<?php echo $id;?>" size="5" value="<?php echo $cantidad; ?>" /> <?php echo $uni;?>
                        &nbsp;&nbsp;
                        <a href="javascript:actualiza_carrito(<?php echo $id?>)"><img src="assets/frontend/cki/imagenes/update.png" title="Actualizar" align="absmiddle"/></a>  
                        &nbsp;&nbsp;
                        <a href="javascript:elimina_item_carrito(<?php echo $id?>)"><img src="assets/frontend/cki/imagenes/del.png" title="Eliminar Item" align="absmiddle"/></a>
                        <input type="hidden" name="stock_<?php echo $id; ?>" id="stock_<?php echo $id; ?>" value="<?php echo $stock; ?>">
                    </td>
                    <td class="contenido_carro"><?php echo $precio; ?></td>
                    <td class="contenido_carro"><?php echo $subtot; ?></td>                                
                    <td class="contenido_carro">Inmediata</td>
                </tr>
                <?php
                    }
                ?>
                <?php
                    if(count($cargos)>0)
                    {
                        $ind = 1;
                        echo '<tr>';
                        echo '<td colspan="8" align="left" class="subtituloCarro">CARGOS ADICIONALES</td>';
                        echo '</tr>';
                        foreach($cargos as $cargo)
                        {
                            $monto = $cargo->monto;
                           echo '<tr>';
                           echo '<td align="center" class="contenido_carro">'.$ind.'</td>';
                           echo '<td colspan="5" align="left" class="contenido_carro">'.$cargo->concepto.'</td>';
                           echo '<td align="center" class="contenido_carro">S/ '.$cargo->monto.'</td>';
                           echo '<td align="center" class="contenido_carro"></td>';
                           echo '</tr>';
                           $ind++;
                           $total = $total + $monto;
                        }
                    }
                    //echo '<tr><td colspan="6">Cargos: '.count($cargos).'</td></tr>';
                ?>
                <tr>
                    <td colspan="5" class="contenido_carro"></td>
                    <td class="contenido_carro"><strong>TOTAL</strong></td>
                    <td class="contenido_carro"><strong><?php echo $uni.number_format($total, 3, '.', ',');?></strong></td>
                    <td class="contenido_carro"></td>
                </tr>
                <tr>
                    <td colspan="8" height="10"></td>
                </tr>
                <tr>
                    <td colspan="8" class="nota" align="left"><strong>NOTA.-</strong> Los precios incluyen IGV</td>
                </tr>
                <tr>
                <td colspan="8" align="left" class="subtituloCarro2">MENSAJE</td>
                </tr>
                <tr>
                    <td colspan="8" align="left"><textarea id="mensaje_carro" name="mensaje_carro" rows="5" cols="80" class="campo"></textarea></td>
                </tr>
                <tr>
                    <td colspan="8">
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="32%" align="left"><input type="button" onclick="elimina_todo_carrito()" value="ELIMINAR PEDIDO" class="btnElimina"></td>
                                <td width="30%"><input type="button" onclick="goProductos()" value="SEGUIR AGREGANDO" class="btnAgregar"></td>
                                <td width="19%"><input type="button" onclick="doReserva()" value="RESERVAR" class="btnReservar"></td>
                                <td width="19%"><input type="submit" value="COMPRAR" class="btnComprar"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </table>
		</form>
               <?php
                    }
                    else
                    {
                        echo '<h3>Su carrito de pedidos esta Vacio</h3>';                                    
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
                
                    default:
                        echo 'aqui';
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