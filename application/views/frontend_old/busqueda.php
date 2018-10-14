<div id="wrap-content">
  <div id="breadcrumb">
    <a href="#" class="breadcrumbHome">Homepage</a><span class="seperator"> &nbsp; </span><a href="#">Computers</a><span class="seperator"> &nbsp; </span><a href="#">Laptops</a><span class="seperator"> &nbsp; </span><span>Dell</span>
  </div>
  <div id="main-content">
    <div id="left-column">
      <?php echo $izquierda;?>
    </div>

    <div id="right-column">

      <div id="content">
        <div class="wrap-featured-products">
            <div class="wrap-title-black">
              <h1 class="nice-title">B&uacute;squeda de Producto</h1>
            </div>
            <div class="contenido">
                <div class="sub_contenido">
                    <form action="busqueda/buscar/1" method="post" onsubmit="return valida_busqueda()">
                    <table cellpadding="0" cellspacing="0" width="80%" border="0" align="center">
                    <tr>
                    	<td width="25%"><b>Categor&iacute;a</b></td>
                        <td width="25%"><b>Nombre</b></td>
                        <td width="25%"><b>C&oacute;digo</b></td>
                        <td width="25%"></td>
                    </tr>
                    <tr>
                    	<td>
                        	<select name="categoria" id="categoria">
                            <option value="0">Seleccione...</option>
	                        <?php
                            foreach ($categorias as $key => $value) {
                                $nombre_categoria=$value->nombre_categoria;
                                $id_categoria=$value->id_categoria;
                                $url_nombre=formateaCadena($value->nombre_categoria);
								if(($this->session->userdata('categoria'))==$id_categoria){
	                                echo '<option value="'.$id_categoria.'" selected>'.$nombre_categoria.'</option> ';
								}else{
	                                echo '<option value="'.$id_categoria.'" >'.$nombre_categoria.'</option> ';									
								}
                            }?>                        
                        </td>
                        <td><input type="text" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre');?>"/></td>
                        <td><input type="text" name="codigo" id="codigo" value="<?php echo $this->session->userdata('codigo');?>"/>
                        <input type="hidden" name="oculto" value="oculto" /></td>                  
                        <td width="25%"><input type="submit" value="Buscar" class="boton" /></td>
                                                  
                    </tr>                    
                    </table>
                    </form>
                </div><!--sub_contenido-->

				<?php
				if(isset($productos)){
                ?>
                    <div class="paginacion clearfix">
                        <ul>
                            <?php 
                            
                            for($w=1;$w<=$numero_paginas;$w++){
                                if($w==$pagina_actual){
                                    echo '<li><a href="busqueda/buscar/'.$w.'" class="actual">'.$w.'</a></li>';
                                }else{
                                    echo '<li><a href="busqueda/buscar/'.$w.'">'.$w.'</a></li>';
                                }
                            }?>
                        </ul>
                    </div><!--paginacion-->
                    <div class="sub_contenido clearfix">
                        <?php
                        $num_prod=count($productos);
                        for($e=0;$e<$num_prod;$e++) {
                          $current=$productos[$e];
                          $id_producto=$current['id_producto'];                        
                          $nombre=$current['nombre'];
                          $imagen=$current['imagen'];
                          $codigo=$current['codigo'];					  
                          $url_nom=$current['url_nom'];
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
                          }
    
                        ?>
                                    
                    </div>
				<?php
				}
				?>
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>