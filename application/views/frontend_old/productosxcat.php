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
                <h1 class="nice-title">Categoría:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nombre_categoria; ?><?php //echo $acerca_nosotros->titulo;?></h1>
            </div>
            <div class="contenido">
            <?php
                for($i=0; $i<count($subcategorias); $i++)
                {
                    $current = $subcategorias[$i];                     
                    $nombre_subcategoria = $current['nombre'];
                    $numero_productos = $current['numero_productos'];
                    $productos = $current['productos'];
                    if($numero_productos>0)
                    {
                       echo '<div><h2>'.$nombre_subcategoria.'</h2></div>';
                       echo '<div class="lista_productos_x_subcat clearfix">';
                       for($e=0;$e<$numero_productos;$e++) 
                       {
                            $prod = $productos[$e];
                            $id_producto = $prod['id_producto'];                        
                            $nombre = $prod['nombre'];
                            $imagen = $prod['imagen'];
                            $codigo = $prod['codigo'];					  
                            $url_nom = $prod['url_nom'];
             ?>
            <div class="prodt_list">
                <div class="prodt-photo">
                    <a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>">
                        <?php
                          if( (isset($imagen)) && (is_file('files/productos_thumbs/'.$imagen)) )
                          {
                              $img = getimagesize('files/productos_thumbs/'.$imagen);
                              $ancho = (int)($img[0]/1);
                              $alto = (int)($img[1]/1);
                              echo '<img src="files/productos_thumbs/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
                          }
                          else
                          {
                              $img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
                              $ancho = (int)($img[0]/1);
                              $alto = (int)($img[1]/1);							
                              echo '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
                          }
                          ?>
                    </a>
                </div>
                <div class="tit_prodt_info">
                    <h3><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>"><?php echo $codigo;?></a></h3>
                </div><!--tit_prodt_info-->
                <a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $url_nom;?>">Detalle</a>
            </div>
            <?php
                        } // for $e                       
                       echo '</div>'; // lista_productos_x_subcat
                    } // if
                } // for $i
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->        
      </div>
    </div>
  </div>
</div>