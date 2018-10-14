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
    <?php
    if (isset($resultado) && ($resultado == "success")) {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La operación se realizó con éxito';
        echo '</div>';
    }
    ?>    
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Productos de la Categor&iacute;a: <?php echo $nombre_categoria;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>

            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="10%">Imagen</th>
                        <th width="30%">Nombre</th>
                        <th width="10%">C&oacute;digo</th>
                        <th width="10%">Tipo</th>
                        <th width="10%">Orden</th>                        
                        <th width="5%">Seleccione</th>                        
                        <th width="10%">Acción</th>
                        <th width="10%">Actualizaci&oacute;n</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    $orden = 1;
                    //var_dump($categorias);
                    for($i=0; $i<count($productos); $i++)
                    {
                        $current = $productos[$i];
                        $foto = $current['imagen'];
                        $id_producto = $current['id_producto'];
                        $nombre= $current['nombre'];						
                        $codigo= $current['codigo'];
                        $actualizacion= $current['actualizacion'];                        
                        if($current['tipo']==0){$tipo='Publico';}else{$tipo='VIP';}
                        $orden= $current['orden'];
                        if(is_file('files/productos_thumbs/'.$foto))
                        {
                            $img = getimagesize('files/productos_thumbs/'.$foto);
                            $ancho = (int)($img[0]/2);
                            $alto = (int)($img[1]/2);                            
                            $pic = '<img src="files/productos_thumbs/'.$foto.'" width="'.$ancho.'" height="'.$alto.'" />';
                        }
                        else
                        {
                            $img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
                            $ancho = (int)($img[0]/2);
                            $alto = (int)($img[1]/2);                              
                            $pic = '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" />';
                        }
                        echo '<tr>';
                        echo '<td>'.($i+1).'</td>';												
                        echo '<td>'.$pic.'</td>';						
                        echo '<td class="left">'.$nombre.'</td>';						
                        echo '<td class="center">'.$codigo.'</td>';
                        echo '<td class="center">'.$tipo.'</td>';
                        echo '<td class="center">'.$orden.'</td>';   
                        echo '<td><input type="checkbox" name="del" value="'.$id_producto.'" id="'.$id_producto.'" onclick="concatena('.$id_producto.')"></td>';
                        echo '<td>';
                        echo '<a class="btn btn-mini btn-inverse" href="mainpanel/catalogo/edit_producto/'.$id_producto.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-mini btn-danger" href="javascript:deleteProducto(\''.$id_producto.'\', \''.$id_subcategoria.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
                        echo '<a class="btn btn-mini btn-primary" href="mainpanel/catalogo/fotos/'.$id_producto.'"><i class="icon-picture icon-white"></i>Fotos</a>';
                        echo '<td class="center">'.$actualizacion.'</td>';   
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
                  
                </tbody>
            </table>  
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="20%">
                            <a class="btn btn-danger" href="javascript:deleteMultiProd()"><i class="icon-trash icon-white"></i>Borrar Seleccionados</a>
                            <input type="hidden" id="id_eliminar">
                        </td>
                        <td width="80%">
                            <!--
                            <select name="id_categoria_padre" id="id_categoria_padre">
                            <option value="0">ELija...</option>
                            <?php
                            for($i=0; $i<count($categorias); $i++)
                            {
                                $current = $categorias[$i];
                                $id_categoria_padre = $current['id_categoria'];
                                $nombre_categoria = $current['nombre_categoria'];
                                if($producto->id_categoria_padre==$id_categoria_padre){
                                    echo '<option value="'.$id_categoria_padre.'" selected>'.$nombre_categoria.'</option>';
                                }else {
                                    echo '<option value="'.$id_categoria_padre.'">'.$nombre_categoria.'</option>';
                                }

                            }
                            ?>
                            </select>
                            <a class="btn btn-small btn-success" style="margin:0px;" href="javascript:trasladaProd()"><i class="icon-refresh icon-white"></i> Trasladar Producto</a>
                            -->
                        </td>
                    </tr>
                </tbody>
            </table>  
            </div>              
        </div>
     </div><!--/span-->
</div><!--/row-->