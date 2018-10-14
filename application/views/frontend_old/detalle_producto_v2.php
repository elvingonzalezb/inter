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
              <h1 class="nice-title"><?php echo $producto->nombre;?></h1>
            </div>
            <div class="contenido">
                <div class="sub_contenido clearfix">
                    <div id="foto_detalle">
                    <?php 
                        $num_fotos = count($fotos);
                        if($num_fotos>0)
                        {
                            foreach ($fotos as $value)
                            {
                                $pic_1 = $value->foto;
                                if($value->foto_empaque!="")
                                {
                                    $pic_2 = $value->foto_empaque;
                                }
                                else
                                {
                                    $pic_2 = '';
                                }
                                echo '<div class="filaFotos">';
                                if( ($value->foto!="") && (is_file('files/thumbnails_fotografias/'.$value->foto)) )
                                {
                                    echo '<div class="fotoDetalle">';
                                    echo '<a href="javascript:ver_foto_principal(\''.$value->foto.'\',\''.$value->foto_empaque.'\',\''.$producto->nombre.'\')">';
                                    echo '<img src="files/fotografias_medianas/'.$value->foto.'" width="90" height="90">';
                                    echo '</a>';
                                    echo '</div>';
                                }
                                if( ($value->foto_empaque!="") && (is_file('files/thumbnails_fotografias/'.$value->foto_empaque)) )
                                {
                                    echo '<div class="fotoDetalle">';
                                    echo '<a href="javascript:ver_foto_empaque(\''.$value->foto.'\',\''.$value->foto_empaque.'\',\''.$producto->nombre.'\')">';
                                    echo '<img src="files/fotografias_medianas/'.$value->foto_empaque.'" width="90" height="90">';
                                    echo '</a>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            } // for
                        }
                    ?>
                        <div id="descripcionProducto">
                            <h3>Descripci&oacute;n</h3>
                            <div class="sub_contenido">
                            <?php echo $producto->descripcion;?>
                            </div><!--sub_contenido-->
                        </div><!-- descripcionProducto -->
                    </div><!--foto_detalle-->
                    <div id="info_detalle">
			<div id="top_info">
                            <h2><?php echo $producto->nombre;?></h2>
                            
                            <div class="div_cod_pre clearfix">
                                <div class="etq_info_de">C&oacute;digo: 
                                <?php echo $producto->codigo;?></div>
                            </div><!--div_cod_pre-->
                            
                            <?php
                            // vemos si es en SOLES o DOLARES
                            if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='s')
                            {
                               $t_c=1;
                               $uni='S/.';
                               $dscto=1;
                            }
                            else if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='d')
                            {
                                $t_c= getConfig("tipo_cambio_dolar");
                                $uni='US$ ';
                                // vemos si tiene descuento
                                if($producto->descuento=='si')
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
                            // lista los precios
                            if($this->session->userdata('logueadocki'))
                            {
                                if($this->session->userdata('ver_precio')=='si')
                                {
                                    for($g=0;$g<count($precios);$g++)
                                    {
                                        $current=$precios[$g];
                                        $precio=$current['precio'];
                                        $unidad=$current['unidad'];
                                        $moneda=$current['moneda'];                                    
                                        ?>
                                        <div class="div_cod_pre clearfix">
                                            <div class="etq_info_de">Precio: 
                                            <?php echo $uni.' '.number_format(($precio/$t_c/$dscto), 3, '.', ',').' '.$unidad;?></div>
                                            <span class="igv">PRECIOS INCLUYEN IGV</span>
                                        </div><!--div_cod_pre-->
                                       
                                        <?php 
                                    }
                                }
                            }
                            ?>
                            <!--<br />-->
                        </div><!--top_info-->
                        <?php
                            if($resultado)
                            {
                                switch($resultado)
                                {
                                    case "errorTipo":
                                       echo '<div class="msgCarrito2 msgRojo clearfix">';
                                        echo '<span><i class="fa fa-exclamation-triangle fa-5x"></i></span>';
                                        echo '<p>No puede agregar ese producto a su reserva!.<br>';
                                       echo 'Recuerde que solo puede agregar o productos en stock o productos que llegaran proximamente<br>pero no puede mezclarlos.</p></div>'; 
                                    break;
                                }                                
                            }
                        ?>
                        <h3>Colores disponibles</h3>
                        <div id="cabec_det" class="clearfix">
                            <div id="cab_color">Color</div><!--cab_color-->
                            <?php
                            if($producto->show_stock=='1')
                            {
                            ?>
                            <div id="cab_stock">Stock</div><!--cab_stock-->
                            <?php
                            }
                            ?>
                            <div id="cab_pedido">Pedido</div><!--cab_pedido-->
                        </div>
                        <form action="pedido/agregar" method="post" onSubmit="return validaAgregado()">
                        <div id="cont_colores" class='clearfix'>
                            <div class="clearfix">
                            <?php 
                            //var_dump($colores);
                            $cont=0;
                            $lista_ids = array();
                            for($y=0;$y<count($colores);$y++) 
                            {
                                $curr = $colores[$y];
                                $color = $curr['color'];
                                $stock = $curr['stock'];
                                $nombre = $curr['nombre'];                                    
                                $id = $curr['id']; // ID de tabla stock_color (UNICO)
                                $id_color = $curr['id_color'];
                                $lista_ids[] = $id;
                                echo '<div class="cont_col clearfix">';
                                echo '<div class="div_colores" style="background:'.$color.';" title="'.$nombre.'"></div>';
                                if($producto->show_stock=='1')
                                {
                                    echo '<div class="div_stock"><p>'.number_format($stock,0, '.', ',').'</p></div>';
                                }
                                echo '<div class="cont_cant">';
                                echo '<p><input type="text" name="cant_'.$id.'" id="cant_'.$id.'" onKeyPress="return checkIt(event)" class="campo_rojo" size="2"/></p>';
                                echo '</div><!--cont_cant-->';
                                echo '<div class="cont_unidd">';
                                echo '<select id="uni_'.$id.'" name="uni_'.$id.'" class="campo">';
                                for($g=0;$g<count($precios);$g++)
                                {
                                    $current=$precios[$g];
                                    $unidad=$current['unidad'];
                                    $id_unidad=$current['id_unidad'];                                            
                                    echo '<option value="'.$unidad.'()'.$id_unidad.'">'.$unidad.'</option>';
                                }

                                echo '</select>';
                                echo '</div><!--cont_unidd-->';
                                if( ($this->session->userdata('ver_precio')) && ($this->session->userdata('ver_precio') =='si') && ($id_categoria!=26) )
                                {
                                    echo '<div class="cont_bt_carro">';
                                    //echo '<a href="javascript:agregar_carrito('.$id.')"><img src="assets/frontend/cki/imagenes/boton_agrega.png" border="0" width="25" class="cursor"title="Agregar a Carrito"/></a>';
                                    echo '<input type="image" src="assets/frontend/cki/imagenes/boton_agrega_25.png">';
                                    echo '</div><!--cont_bt_carro-->';
                                }
                                echo '<input type="hidden" id="stock_'.$id.'" name="stock_'.$id.'" value="'.$stock.'"/>';
                                echo '<input type="hidden" id="nombre_color_'.$id.'" name="nombre_color_'.$id.'" value="'.$nombre.'"/>';
                                echo '<input type="hidden" id="color_'.$id.'" name="color_'.$id.'" value="'.$color.'"/>';
                                echo '<input type="hidden" id="idColor_'.$id.'" name="idColor_'.$id.'" value="'.$id_color.'"/>';
                                echo '</div>';
                                $cont +=1;
                            } // for
                            ?>
                            </div>
                            <div>
                                <input type="hidden" name="lista_ids" id="lista_ids" value="<?php echo implode("#", $lista_ids); ?>" />
                                <input type="hidden" name="codigo" id="codigo" value="<?php echo $producto->codigo;?>" />
                                <input type="hidden" name="nombre" id="nombre" value="<?php echo $producto->nombre;?>" />
                                <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $producto->id_producto;?>" />
                                <input type="hidden" name="dscto" id="dscto" value="<?php echo $producto->descuento;?>" />
                                <input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo $id_categoria; ?>">
                            </div>
                        </div><!--cont_colores-->
                        </form>

                        <h3>Especificaciones</h3>           
                        <div id="cont_info_de">
                            <!--<span><strong>Categor&iacute;a: </strong><?php echo $nombre_categoria;?></span><br>-->
                            <?php if(!empty($producto->material)){?>                        
                            <span><strong>Material: </strong><?php echo $producto->material;?></span><br><?php } ?>
                            <?php if(!empty($producto->medidas)){?>
                            <span><strong>Medidas Producto: </strong> <?php echo $producto->medidas;?></span><br><?php } ?>
                            <?php if(!empty($producto->medidas_caja)){?>
                            <span><strong>Medidas Caja: </strong> <?php echo $producto->medidas_caja;?></span><br><?php } ?>
                            <?php if(!empty($producto->area_impresion)){?>
                            <span><strong>Area de Impresi&oacute;n: </strong><?php echo $producto->area_impresion;?></span><br><?php } ?>
                            <?php if(!empty($producto->metodo_impresion)){?>                        
                            <span><strong>M&eacute;todo de Impresi&oacute;n: </strong><?php echo $producto->metodo_impresion;?></span><br><?php } ?>
                        </div><!--cont_info_de-->
                        <?php
                            $proximos = count($colores_prox);
                            if($proximos>0)
                            {
                        ?>
                        <h3>Proximamente</h3>
                        <p class="noMargin">Los precios son referenciales y podrian variar por el tipo de cambio</p>
                        <div id="divProximos" class="clearfix">
                        <form action="pedido/agregarProximamente" method="post" onSubmit="return validaAgregadoProx()">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="15%" height="20" class="headerPedido" align="center" valign="middle">Color</td>
                                <?php
                                    if($producto->show_stock=='1')
                                    {
                                ?>
                                <td width="15%" class="headerPedido" align="center" valign="middle">Stock</td>
                                <?php
                                    }
                                ?>
                                <td width="20%" class="headerPedido" align="center" valign="middle">Precio</td>
                                <td width="20%" class="headerPedido" align="center" valign="middle">Llegada</td>
                                <td width="15%" class="headerPedido" align="center" valign="middle">Pedido</td>
                                <td width="15%" class="headerPedido" align="center" valign="middle"></td>
                            </tr>
                            <?php
                                $cont=0;
                                $lista_ids_p = array();
                                for($y=0;$y<count($colores_prox);$y++) 
                                {
                                    $curr = $colores_prox[$y];
                                    $color = $curr['color'];
                                    $stock = $curr['stock_proximamente'];
                                    $nombre = $curr['nombre']; 
                                    $fecha_llegada = $curr['fecha_llegada'];
                                    $precio_proximamente = $curr['precio_proximamente'];
                                    $id = $curr['id']; // ID de tabla stock_color (UNICO)
                                    $id_color = $curr['id_color'];
                                    $lista_ids_p[] = $id;
                                    if($precio>0)
                                    {
                                        echo '<tr class="filaBlanca">';
                                            echo '<td height="25" align="center" valign="middle" style="padding-left:13px;"><div style="background:'.$color.';" class="divColor"></div></td>';
                                            if($producto->show_stock=='1')
                                            {
                                                echo '<td align="center" valign="middle"><span class="celdaCantidad">'.number_format($stock,0, '.', ',').'</span></td>';
                                            }
                                            if( ($this->session->userdata('ver_precio')) && ($this->session->userdata('ver_precio') =='si') && ($id_categoria!=26) )
                                            {
                                                echo '<td align="center" valign="middle">';
                                                echo '<strong>S/ '.$precio_proximamente.'</strong>';
                                                echo '</td><!--celdaDatoPedido-->';

                                                echo '<td align="center" valign="middle">';
                                                    echo $fecha_llegada;
                                                echo '</td><!--celdaDatoPedido-->';
                                            
                                                echo '<td align="center" valign="middle">';
                                                    echo '<input type="text" name="cant_p_'.$id.'" id="cant_p_'.$id.'" onKeyPress="return checkIt(event)" class="campoCant" size="2"/>';
                                                echo '</td><!--cont_bt_carro-->';
                                                
                                                echo '<td align="center" valign="middle" style="padding-top:6px;">';
                                                    echo '<input type="image" src="assets/frontend/cki/imagenes/boton_agrega_25.png">';
                                                echo '</td><!--cont_bt_carro-->';
                                            }
                                            echo '<input type="hidden" name="uni_p_'.$id.'" id="uni_p_'.$id.'" value="Unidad()3">';
                                            echo '<input type="hidden" id="stock_p_'.$id.'" name="stock_p_'.$id.'" value="'.$stock.'"/>';
                                            echo '<input type="hidden" id="precio_p_'.$id.'" name="precio_p_'.$id.'" value="'.$precio_proximamente.'"/>';
                                            echo '<input type="hidden" id="nombre_color_p_'.$id.'" name="nombre_color_p_'.$id.'" value="'.$nombre.'"/>';
                                            echo '<input type="hidden" id="color_p_'.$id.'" name="color_p_'.$id.'" value="'.$color.'"/>';
                                            echo '<input type="hidden" id="idColor_p_'.$id.'" name="idColor_p_'.$id.'" value="'.$id_color.'"/>';
                                        echo '</tr>';
                                        $cont +=1;
                                    }
                                } // for
                            ?>
                        </table>
                        <input type="hidden" name="lista_ids_prox" id="lista_ids_prox" value="<?php echo implode("#", $lista_ids_p); ?>" />
                        <input type="hidden" name="codigo_p" id="codigo_p" value="<?php echo $producto->codigo;?>" />
                        <input type="hidden" name="nombre_p" id="nombre_p" value="<?php echo $producto->nombre;?>" />
                        <input type="hidden" name="id_producto_p" id="id_producto_p" value="<?php echo $producto->id_producto;?>" />
                        <input type="hidden" name="dscto_p" id="dscto_p" value="<?php echo $producto->descuento;?>" />
                        <input type="hidden" name="id_categoria_p" id="id_categoria" value="<?php echo $id_categoria; ?>">
                        </form>
                        </div>
                        <?php
                            } //if
                        ?>
                        
                        
                        
                        
                        
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script> 
                        <div class="fb-like" data-href="<?php echo $base_url;?>detalle-producto/<?php echo $producto->id_producto;?>/<?php echo $url_nombre; ?>" data-send="false" data-width="150" data-show-faces="false"></div>                        
                    </div><!--info_detalle-->
                </div><!--sub_contenido-->
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>