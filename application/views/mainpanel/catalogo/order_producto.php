<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/catalogo/listado">Lista de Categorias</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevo">Agregar Categoria</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevasubcat">Agregar Sub Categoria</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevo_producto">Nuevo Producto</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/listaProximos">Proximos Ingresos</a> </li>
    </ul>
</div>
<div class="row-fluid sortable">
   
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Ordenar Productos, Categor&iacute;a: <?php echo $nombre_subcategoria;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form method="post">
            <div id="capa_ordenamiento_productos">
                <div id="turn_result"></div>
                <?php
                    $orden = 1;
                    //var_dump($categorias);
                    for($i=0; $i<count($productos); $i++)
                    {
                        $current = $productos[$i];
                        $foto = $current['imagen'];
                        $id_producto = $current['id_producto'];
                        $nombre= $current['nombre'];						
                        if(is_file('files/productos_thumbs/'.$foto))
                        {
                            $pic = '<img src="files/productos_thumbs/'.$foto.'" height="60" />';
                        }
                        else
                        {
                            $pic = '<img src="assets/frontend/confeccionesrials/imagenes/img125x150.png" height="60" />';
                        }
                        //echo $id_producto;
                        echo '<div id="item_'.$id_producto.'" class="capa_orden" style="height:150px;margin:10px;">';
                        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="handle">';
                        echo '<tr>';
                        echo '<td height="100" align="center" valign="middle">'.$pic.'</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td height="25" align="center" valign="middle"><h6>'.$nombre.'</h6></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                        
                      
                    }
                ?>
                       
            </div> <!--           capa_ordenamiento_productos             -->
            <input type="hidden" name="id_subcategoria" id="id_subcategoria" value="<?php echo $id_subcategoria; ?>">
            </form>
        </div>
     </div><!--/span-->
</div><!--/row-->