      <div id="wrap-categories">
        <div class="wrap-title-black">
          <h2 class="nice-title">CATEGORIAS</h2>
          <div class="expanded"></div>
        </div>
        <ul id="category-menu">
            <?php
                /************* NUEVOS INGRESOS **********/
                $current = $categorias[0];                     
                $id_categoria = $current['id_categoria'];
                $nombre_categoria = $current['nombre_categoria'];
                $url_nombre = formateaCadena($nombre_categoria);
                if( (isset($id_cat_current)) && ($id_cat_current==$id_categoria) )
                {
                    $clase = '';
                    $clase2 = 'visible';
                }
                else 
                {
                    $clase = 'hasSubmenu';
                    $clase2 = 'oculto';
                }
                echo '<li class="'.$clase.'"><a href="categoria/'.$id_categoria.'/'.$url_nombre.'/1">'.$nombre_categoria.'</a>';
                //echo '<li class="'.$clase.'"><a href="javascript:void(0)">'.$nombre_categoria.'</a>';
                echo '<ul class="subMenu '.$clase2.'">';
                $subcategorias = $current['subcategorias'];
                for($j=0; $j<count($subcategorias); $j++)
                {
                    $subcatCurrent = $subcategorias[$j];
                    $id_subcategoria = $subcatCurrent["id_subcategoria"];
                    $nombreSubcat = $subcatCurrent["nombre"];
                    $url_subcat = formateaCadena($nombreSubcat);
                    if( (isset($id_subcat_current)) && ($id_subcat_current==$id_subcategoria) )
                    {
                        echo '<li><a class="subOpcionActiva" href="subcategoria/'.$id_subcategoria.'/'.$url_subcat.'/1">'.$nombreSubcat.'</a></li>';
                    }
                    else
                    {
                        echo '<li><a href="subcategoria/'.$id_subcategoria.'/'.$url_subcat.'/1">'.$nombreSubcat.'</a></li>';
                    }
                }
                echo '</ul>';
                echo '</li>';            
            
            /*************** PROXIMAMENTE ***************/
            $listaFechas = fechasProximamente();
            if(count(fechasProximamente())>0)
            {
                echo '<li class="hasSubmenu"><a href="proximosIngresos/1">PROXIMOS INGRESOS</a>';
                echo '<ul class="subMenu oculto">';
                foreach($listaFechas as $fecha)
                {
                    $currentFecha = formatoFechaProximamente($fecha->fecha_llegada);
                    echo '<li><a href="proximos-ingresos/'.Ymd_2_dmY($fecha->fecha_llegada).'/1">'.$currentFecha.'</a></li>';
                }
                echo '</ul>';
                echo '</li>';
            }
            /*************** LAS DEMAS CATEGORIAS ************/
            for($i=1; $i<count($categorias); $i++)
            {
                $current = $categorias[$i];                     
                $id_categoria = $current['id_categoria'];
                $nombre_categoria = $current['nombre_categoria'];
                $url_nombre = formateaCadena($nombre_categoria);
                if( (isset($id_cat_current)) && ($id_cat_current==$id_categoria) )
                {
                    $clase = '';
                    $clase2 = 'visible';
                }
                else 
                {
                    $clase = 'hasSubmenu';
                    $clase2 = 'oculto';
                }
                echo '<li class="'.$clase.'"><a href="categoria/'.$id_categoria.'/'.$url_nombre.'/1">'.$nombre_categoria.'</a>';
                //echo '<li class="'.$clase.'"><a href="javascript:void(0)">'.$nombre_categoria.'</a>';
                echo '<ul class="subMenu '.$clase2.'">';
                $subcategorias = $current['subcategorias'];
                for($j=0; $j<count($subcategorias); $j++)
                {
                    $subcatCurrent = $subcategorias[$j];
                    $id_subcategoria = $subcatCurrent["id_subcategoria"];
                    $nombreSubcat = $subcatCurrent["nombre"];
                    $url_subcat = formateaCadena($nombreSubcat);
                    if( (isset($id_subcat_current)) && ($id_subcat_current==$id_subcategoria) )
                    {
                        echo '<li><a class="subOpcionActiva" href="subcategoria/'.$id_subcategoria.'/'.$url_subcat.'/1">'.$nombreSubcat.'</a></li>';
                    }
                    else
                    {
                        echo '<li><a href="subcategoria/'.$id_subcategoria.'/'.$url_subcat.'/1">'.$nombreSubcat.'</a></li>';
                    }
                }
                echo '</ul>';
                echo '</li>';
            }
            ?>
        </ul>
      </div>
<!--      <div class="left-block">
        <h2 class="nice-title2"><?php //echo $newsletter->titulo;?></h2>
        <div class="block-content">
          <form id="newsletter-form" action="" method="post">
            <p class="info"><?php //echo $newsletter->texto;?></p>
            <p><input id="newsletter-value" class="nice-i" type="text" name="newsletter-email" value="Enter your email" /></p>
            <p><input class="nice-s" type="submit" name="newsletter-submit" value="SUBMIT" /></p>
          </form>
        </div>
      </div>-->
<!--      <div class="left-block">
        <h2 class="nice-title2">CUSTOMER SUPPORT</h2>
        <div class="block-content" style="padding: 0px; width: 230px;">
          <p class="support"><a href="#">Email Asisstance</a></p>
          <p class="support"><a href="#">FAQs</a></p>
          <p class="support" style="border-bottom: 0px;"><span>Call 1-800-123-4567</span></p>
        </div>
      </div>-->
<!--      <div class="left-block">
        <div class="block-content2">
          <img src="assets/frontend/cki/imagenes/paypal-cards.jpg" alt="paypal cards" />
        </div>
      </div>-->