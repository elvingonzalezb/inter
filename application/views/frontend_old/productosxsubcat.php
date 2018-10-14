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
                <h1 class="nice-title">Categoría:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nombre_categoria; ?> <?php //echo $id_categoria;?></h1>
            </div>
            <div class="contenido">
            <?php
                echo '<div><h2>'.$nombre_subcategoria.'</h2></div>';
                if(count($productos)>0)
                { 
            ?>
                <div class="sub_contenido clearfix">
            <?php
                    $num_prod=count($productos);
                    for($e=0;$e<$num_prod;$e++) 
                    {
                      $current=$productos[$e];
                      $id_producto=$current['id_producto'];                        
                      $nombre=$current['nombre'];
                      $imagen=$current['imagen'];
                      $codigo=$current['codigo'];					  
                      $url_nom=$current['url_nom'];   
                        ?>
                        <div class="prodt_list">
                            <div class="prodt-photo">
                                <a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $id_categoria; ?>/<?php echo $url_nom;?>">
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
                                <h3><a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $id_categoria; ?>/<?php echo $url_nom;?>"><?php echo $codigo;?></a></h3>
                            </div><!--tit_prodt_info-->
                            <a href="detalle-producto/<?php echo $id_producto;?>/<?php echo $id_categoria; ?>/<?php echo $url_nom;?>">Detalle</a>
                        </div>
                        <?php
                    }
                }
                else
                {
                        echo 'No tenemos productos disponibles para esta Categoría.';
                }
                ?>          
                </div>
                <div class="paginacion clearfix">
                <ul>
                <?php
                for($w=1;$w<=$numero_paginas;$w++){
                if($w==$pagina_actual){
                echo '<li><a href="subcategoria/'.$id_subcategoria.'/'.$url_nombre.'/'.$w.'" class="actual">'.$w.'</a></li>';
                }else{
                echo '<li><a href="subcategoria/'.$id_subcategoria.'/'.$url_nombre.'/'.$w.'" >'.$w.'</a></li>';
                }
                }?>
                </ul>
                </div><!--paginacion-->
            </div>
        </div><!--wrap-featured-products-->        
      </div>
    </div>
  </div>
</div>