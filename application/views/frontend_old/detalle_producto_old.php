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
                        <div id="gallery" class="ad-gallery clearfix">
                        <?php
                        $num=count($fotos);
                        if($num>0)
                        {				
                            ?>            
                            <!--<div class="ad-image-wrapper">				  
                            </div>-->
                        <!--ad-image-wrapper-->	
                            <div class="ad-nav clearfix">
                                <div class="ad-thumbs">
                                <ul class="ad-thumb-list">					
                                <?php
                                $contador=-1;
                                foreach ($fotos as $value) {
                                    
                                    $archivo=$value->foto;
                                    $nom_fotoprod=$value->nombre;
                                    $contador +=1;						
                                    if( (isset($archivo)) && (is_file('files/thumbnails_fotografias/'.$archivo)) )
                                    {							
                                    
                                        $img = getimagesize('files/thumbnails_fotografias/'.$archivo);
                                        $ancho = (int)($img[0]/1);
                                        $alto = (int)($img[1]/1);
                            
                                        echo '<li>';
                                        echo '<a href="files/fotografias_medianas/'.$archivo.'">';
                                        ?>
                                        <img src="files/thumbnails_fotografias/<?php echo $archivo;?>" title="<?php echo $nom_fotoprod;?>" border="0" width="<?php echo $ancho;?>"  height="
                                        <?php echo $alto?>" class="image<?php echo $contador;?>" 
                                        longdesc="javascript:ver_foto_grande('<?php echo $archivo;?>','<?php echo $producto->nombre;?>')" /> 
                                        <?php
                                        echo '</a>';
                                        echo '</li>';//divfotchiq								
                                    }
                                    else
                                    {
                                        $img = getimagesize('assets/frontend/cki/imagenes/sinFoto50x50.png');
                                        $ancho = (int)($img[0]/1);
                                        $alto = (int)($img[1]/1);
                                        echo '<li>';	
                                        echo '<a href="assets/frontend/cki/imagenes/noimg260x260.png">';															
                                        echo '<img src="assets/frontend/cki/imagenes/sinFoto50x50.png" width="'.$ancho.'" height="'.$alto.'" border=0 class="image'.$contador.'"/>'; 												
                                        echo '</a>';									
                                        echo '</li>';//divfotchiq							
                                    } 							
                                }
                                ?>
                                </ul>
                                </div><!--ad-thumbs-->
                            </div>
                        <!--ad-nav-->                        						
                            <?php
                        }
                        else
                        {
                            $img = getimagesize('assets/frontend/cki/imagenes/noimg260x300.png');
                            $ancho = (int)($img[0]/1);
                            $alto = (int)($img[1]/1);
                            echo '<img src="assets/frontend/cki/imagenes/noimg260x300.png" width="'.$ancho.'" height="'.$alto.'" border="0"/>'; 																	
                        }
                        ?>          
                        </div><!--gallery-->                            
                        <?php
                        //echo '<a href="files/productos/'.$producto->imagen.'" title="'.$producto->nombre.'" class="nyroModal" rel="gal">';
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
                            if($this->session->userdata('logueadocki')){
                                if($this->session->userdata('ver_precio')=='si'){
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
                                if($this->session->userdata('ver_precio') && $this->session->userdata('ver_precio') =='si')
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