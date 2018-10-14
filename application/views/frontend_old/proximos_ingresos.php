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
                <h1 class="nice-title">PROXIMOS INGRESOS</h1>
            </div>
            <div class="contenido">
            <?php
                if(count($productos)>0)
                {
                    echo '<div class="sub_contenido clearfix">';
                    $fecha_current = '0000-00-00';
                    $num_prod = count($productos);
                    $str = '';
                    for($e=0;$e<$num_prod;$e++) 
                    {
                        $current=$productos[$e];
                        $id_producto =$current['id_producto'];                     
                        $nombre =$current['nombre'];
                        $imagen =$current['imagen'];
                        $codigo =$current['codigo'];					  
                        $url_nom =$current['url_nom'];
                        $fecha_llegada = $current['fecha_llegada'];
                        if($fecha_llegada != $fecha_current)
                        {
                            $fecha_current = $fecha_llegada;
                            $str .= '</div>';
                            $str .= '<h2 class="nice-title" style="color:#333;">'.formatoFechaProximamente($fecha_llegada).'</h2>';
                            $str .= '<div class="lista_productos_x_subcat clearfix">';                        
                        }
                        $str .= '<div class="prodt_list">';
                        $str .= '<div class="prodt-photo">';
                            $str .= '<a href="detalle-producto/'.$id_producto.'/'.$url_nom.'">';
                            if( (isset($imagen)) && (is_file('files/productos_thumbs/'.$imagen)) )
                            {
                                $img = getimagesize('files/productos_thumbs/'.$imagen);
                                $ancho = (int)($img[0]/1);
                                $alto = (int)($img[1]/1);
                                $str .= '<img src="files/productos_thumbs/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
                            }
                            else
                            {
                                $img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
                                $ancho = (int)($img[0]/1);
                                $alto = (int)($img[1]/1);							
                                $str .= '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" border="1"/>';
                            }
                            $str .= '</a>';
                        $str .= '</div>';
                        $str .= '<div class="tit_prodt_info">';
                            $str .= '<h3><a href="detalle-producto/'.$id_producto.'/'.$url_nom.'">'.$codigo.'</a></h3>';
                        $str .= '</div><!--tit_prodt_info-->';
                            $str .= '<a href="detalle-producto/'.$id_producto.'/'.$url_nom.'">Detalle</a>';
                        $str .= '</div>';
                    }// for
                    echo $str;
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
                for($w=1;$w<=$numero_paginas;$w++)
                {
                    if($w==$pagina_actual)
                    {
                        echo '<li><a href="proximosIngresos/'.$w.'" class="actual">'.$w.'</a></li>';
                    }
                    else
                    {
                        echo '<li><a href="proximosIngresos/'.$w.'" >'.$w.'</a></li>';
                    }
                }
                ?>
                </ul>
                </div><!--paginacion-->
            </div>
        </div><!--wrap-featured-products-->        
      </div>
    </div>
  </div>
</div>