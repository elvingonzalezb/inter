<div id="wrap-content">
  <div id="breadcrumb">
<!--    <a href="#" class="breadcrumbHome">Homepage</a><span class="seperator"> &nbsp; </span><a href="#">Computers</a><span class="seperator"> &nbsp; </span><a href="#">Laptops</a><span class="seperator"> &nbsp; </span><span>Dell</span>-->
  </div>
  <div id="main-content">
    <div id="left-column">
      <?php echo $izquierda;?>
    </div> 
    <div id="right-column">
        

        
      <div id="promo-banners">
        <?php
            echo $banners;
        ?>
      </div>
      
      
        <?php
            if($this->session->userdata('logueadocki')){
              echo '<div class="welcomemsg">Bienvenido: '.$this->session->userdata('ses_razon').'. Use el menu superior para descargar el inventario actualizado o cerrar sesión.</div>';
            }
            else
            {
        ?>
        <div id="ini_reg" class="clearfix">
          <div class="seg_ini_reg clearfix">
            <div id="logu">
                <h2 class="nice-title2">Ingreso de Usuarios</h2>
                <form action="ingresar/logueo" method="post" onSubmit="return valida_log()" >
                    <table border="0">
                        <tr>
                            <td width="39%" class="etiqueta">Usuario</td>
                            <td width="2%" ></td>
                            <td width="39%"  class="etiqueta">Password</td>
                            <td width="20%" ></td>
                        </tr>
                        <tr>
                            <td><input id="usuario_ini" class="nice-i" type="text" name="usuario" size="15" /></td>
                            <td></td>
                            <td><input id="password_ini" class="nice-i" type="password" name="password" size="15"  /></td>
                            <td><input class="nice-s" id="btnEnviar" type="submit" name="newsletter-submit" value="Enviar" /></td>                          
                        </tr>                      
                    </table>
                </form>
            </div><!--logu-->
            <div id="reg">
                <h2 class="nice-title2">Nuevos Usuarios</h2>
                <table border="0">
                    <tr height="15"><td></td></tr>
                    <tr><td>
                            <a href="registrese" class="nice-a" name="newsletter-submit" >Registrarse</a></td></tr>
                </table>
            </div><!--reg-->
          </div><!--seg_ini_reg-->
          <div class="seg_ini_reg">
              <a href="recordar-contrasena">Recordar contraseña</a>
          </div><!--seg_ini_reg-->
        </div><!--ini_reg-->            
        <?php
        }
        ?>

      
      <div id="content">
        <div class="wrap-featured-products">
          <div class="wrap-title-black">
            <h1 class="nice-title"><?php echo getConfig("nombre_menu_1")?></h1>
            <!--<div class="list-type"><p>View as:</p><p><a href="1_homepage.html"><img src="assets/frontend/cki/imagenes/list-type-row.png" alt="" /></a><a href="2_homepage.html"><img src="assets/frontend/cki/imagenes/list-type-block.png" alt="" /></a></p></div>-->
          </div>
          <ul id="inline-product-list">
              <?php
              for ($f=0;$f<count($productos);$f++) {
                $current=$productos[$f];
                $nombre=$current['nombre'];
                $codigo=$current['codigo'];
                $stock=$current['stock'];
                $colores=$current['colores'];
                $precio=$current['precio'];
                $imagen=$current['imagen'];
                $id_producto=$current['id_producto'];                
                $url_nom=formateaCadena($nombre);
                if(count($colores)>0){
                    ?>
                    <li class="prodNove">
                      <div class="product-photo">
                          <a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>">
                          <?php
                            if( (isset($imagen)) && (is_file('files/productos_thumbs/'.$imagen)) )
                            {
                                $img = getimagesize('files/productos_thumbs/'.$imagen);
                                $ancho = (int)($img[0]/1);
                                $alto = (int)($img[1]/1);
                                echo '<img src="files/productos_thumbs/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'"/>';
                            }
                            else
                            {
                                $img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
                                $ancho = (int)($img[0]/1);
                                $alto = (int)($img[1]/1);							
                                echo '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'"/>';								
                            }
                            ?>
                           </a>
                      </div>
                      <div class="product-info">
                        <h3><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>"><?php echo $nombre;?></a></h3>
                        <p>C&oacute;digo: <?php echo $codigo;?> | Stock: <?php echo $stock;?><br/><br/><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>">Detalle</a></p>
                      </div>
                      <div class="product-reviews">
                        <p>Colores disponibles:</p>
                        <div class="wrap-rating">
    <!--                      <ul class="star-rating">-->

                            <ul id="li_colores">        
                              <?php 
                                                      //var_dump($colores);
                              for($y=0;$y<count($colores);$y++) {
                                  $curre=$colores[$y];
                                  $color=$curre['color'];
                                  $stock=$curre['stock'];
                                  $nombre=$curre['nombre'];                              
                                  echo '<li><div title="Stock: '.$stock.' Und." style="width:15px;height:15px;background:'.$color.';border:solid 1px #d1d1d1;"></div>';
                                  echo '</li>';
                              }
                              ?>
                          </ul>
    <!--                      <div class="rating-summary">3.0</div>-->
                        </div>

                      </div>
                      <div class="product-price"> 
    <!--                    <p>S/. <?php //echo $precio;?></p>-->
                        <p><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>" class="nice-a addcart">Ver mas</a></p>
                      </div>
                    </li>              
                    <?php
                }
              } 
              ?>
          </ul>
          <?php
            if ( $num_reg % $novedades_inicio==0 ){
                $numero_paginas = $num_reg/$novedades_inicio;
            }else{
                $numero_paginas = (int) ( $num_reg/$novedades_inicio) + 1;
            } 
          ?>
          <div class="wrap-pages">
            <div class="left">Page 1 of <?php echo $numero_paginas;?></div>
            <div class="right">
              <a href="javascript:muestra_novedad('1','<?php echo $novedades_inicio;?>')"  class="previous-button"></a> 
            <?php
           
                for($i=1; $i<=$numero_paginas; $i++)
                {
                    if($i==1)
                    {
                        if($i==$numero_paginas){
                           echo '<a href="javascript:muestra_novedad(\''.$i.'\',\''.$novedades_inicio.'\')" class="active" id="pagi_'.$i.'" style="border: 0px;">'.$i.'</a>' ;                            
                        }else{
                           echo '<a href="javascript:muestra_novedad(\''.$i.'\',\''.$novedades_inicio.'\')" class="active paginas" id="pagi_'.$i.'">'.$i.'</a>' ;
                        }
                    }
                    else
                    {
                        if($i==$numero_paginas){
                            echo '<a href="javascript:muestra_novedad(\''.$i.'\',\''.$novedades_inicio.'\')" style="border: 0px;" class="paginas" id="pagi_'.$i.'">'.$i.'</a>' ;                            
                        }else{
                           echo '<a href="javascript:muestra_novedad(\''.$i.'\',\''.$novedades_inicio.'\')" class="paginas" id="pagi_'.$i.'">'.$i.'</a>' ;
                        }
                    }
                }
            ?>              
              <a href="" class="next-button"></a> 
              <input type='hidden' value='<?php echo $novedades_inicio;?>' id='novedades_inicio' />
              <input type='hidden' value='<?php echo $numero_paginas;?>' id='numero_paginas' />
            </div>
          </div>
        </div><!--wrap-featured-products-->
        
        
        <div class="wrap-featured-products">
          <div class="wrap-title-black">
            <h1 class="nice-title"><?php echo getConfig("nombre_menu_2")?></h1>
<!--            <div class="list-type"><p>View as:</p><p><a href="1_homepage.html"><img src="assets/frontend/cki/imagenes/list-type-row.png" alt="" /></a><a href="2_homepage.html"><img src="assets/frontend/cki/imagenes/list-type-block.png" alt="" /></a></p></div>-->
          </div>
          <ul id="inline-product-list">
              <?php
              for ($f=0;$f<count($ofertas);$f++) {
                $current=$ofertas[$f];
                $nombre=$current['nombre'];
                $codigo=$current['codigo'];
                $stock=$current['stock'];
                $colores=$current['colores'];
                $precio=$current['precio'];
                $imagen=$current['imagen'];
                $id_producto=$current['id_producto'];
                $url_nom=formateaCadena($nombre);
                if(count($colores)>0){
                    ?>
                    <li class="prodOfer">
                      <div class="product-photo">
                          <a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>">
                            <?php
                            if( (isset($imagen)) && (is_file('files/productos_thumbs/'.$imagen)) )
                            {
                              $img = getimagesize('files/productos_thumbs/'.$imagen);
                              $ancho = (int)($img[0]/1);
                              $alto = (int)($img[1]/1);
                              echo '<img src="files/productos_thumbs/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'"/>';
                            }
                            else
                            {
                              $img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
                              $ancho = (int)($img[0]/1);
                              $alto = (int)($img[1]/1);							
                              echo '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'"/>';								
                            }
                            ?>
                         </a>
                      </div>
                      <div class="product-info">
                        <h3><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>"><?php echo $nombre;?></a></h3>
                        <p>C&oacute;digo: <?php echo $codigo;?> | Stock: <?php echo $stock;?><br/><br/><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>">Detalle</a></p>
                      </div>
                      <div class="product-reviews">
                        <p>Colores disponibles:</p>
                        <div class="wrap-rating">
    <!--                      <ul class="star-rating">-->
                            <ul id="li_colores">        
                              <?php 
                                                      //var_dump($colores);
                              for($y=0;$y<count($colores);$y++) {
                                  $curre=$colores[$y];
                                  $color=$curre['color'];
                                  $stock=$curre['stock'];
                                  $nombre=$curre['nombre'];                              
                                  echo '<li><div title="Stock: '.$stock.' Und." style="width:15px;height:15px;background:'.$color.';border:solid 1px #d1d1d1;"></div>';
                                  echo '</li>';
                              }

                              ?>
                          </ul>
    <!--                      <div class="rating-summary">3.0</div>-->
                        </div>

                      </div>
                      <div class="product-price"> 
    <!--                    <p>S/. <?php //echo $precio;?></p>-->
                        <p><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>" class="nice-a addcart">VER MAS</a></p>
                      </div>
                    </li>              
                    <?php
                }
              } 
              ?>
          </ul>
          <?php
            if ( $num_reg2 % $ofertas_inicio==0 ){
                $numero_paginas = $num_reg2/$ofertas_inicio;
            }else{
                $numero_paginas = (int) ( $num_reg2/$ofertas_inicio) + 1;
            } 
          ?>
          <div class="wrap-pages-oferta">
            <div class="left">Page 1 of <?php echo $numero_paginas;?></div>
            <div class="right">
              <a href="javascript:muestra_oferta('1','<?php echo $ofertas_inicio;?>')"  class="previous-button-oferta"></a> 
            <?php
           
                for($i=1; $i<=$numero_paginas; $i++)
                {
                    if($i==1)
                    {
                        if($i==$numero_paginas){
                           echo '<a href="javascript:muestra_oferta(\''.$i.'\',\''.$ofertas_inicio.'\')" class="active" id="pagi_ofer_'.$i.'" style="border: 0px;">'.$i.'</a>' ;                            
                        }else{
                           echo '<a href="javascript:muestra_oferta(\''.$i.'\',\''.$ofertas_inicio.'\')" class="active paginas" id="pagi_ofer_'.$i.'">'.$i.'</a>' ;
                        }
                    }
                    else
                    {
                        if($i==$numero_paginas){
                            echo '<a href="javascript:muestra_oferta(\''.$i.'\',\''.$ofertas_inicio.'\')" style="border: 0px;" class="paginas" id="pagi_ofer_'.$i.'">'.$i.'</a>' ;                            
                        }else{
                           echo '<a href="javascript:muestra_oferta(\''.$i.'\',\''.$ofertas_inicio.'\')" class="paginas" id="pagi_ofer_'.$i.'">'.$i.'</a>' ;
                        }
                    }
                }
            ?>              
              <a href="javascript:muestra_oferta('<?php echo $numero_paginas;?>','<?php echo $numero_paginas;?>')" class="next-button-oferta"></a> 
              <input type='hidden' value='<?php echo $ofertas_inicio;?>' id='ofertas_inicio' />
              <input type='hidden' value='<?php echo $numero_paginas;?>' id='numero_paginas_oferta' />
            </div>
          </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>