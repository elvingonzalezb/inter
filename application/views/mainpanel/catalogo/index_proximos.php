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
            <h2><i class="icon-user"></i> Próximos Ingresos</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <?php
            $resultado = $this->session->flashdata('resultado');
            if($this->session->flashdata('resultado'))
            {
                echo '<div class="alert alert-success">';
                echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                echo $resultado;
                echo '</div>';
            }
        ?>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/actualizaProximos" method="post">
            <table class="table table-striped table-bordered bootstrap-datatable">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="8%">IMAGEN</th>
                        <th width="22%">PRODUCTO</th>
                        <th width="10%">CODIGO</th>
                        <th width="5%">ORDEN</th> 
                        <th width="7%">COLOR</th> 
                        <th width="13%">FECHA LLEGADA</th>
                        <th width="10%">STOCK PROX</th>
                        <th width="10%">PRECIO</th> 
                        <th width="10%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    $i = 0;
                    foreach($proximos as $proximo)
                    {
                        $id_producto = $proximo->id_producto;
                        $ci =& get_instance();                        
                        $producto = $this->Catalogo_model->getProducto($id_producto);
                        $nombre_producto = $producto->nombre;
                        $codigo_producto = $producto->codigo;
                        $foto = $producto->imagen;
                        
                        $id_color = $proximo->id_color;
                        $orden = $proximo->orden_proximamente;
                        $stock_proximamente = $proximo->stock_proximamente;
                        $fecha_llegada = Ymd_2_dmY($proximo->fecha_llegada);
                        $precio = $proximo->precio_proximamente;
                        
                        $color = $this->Catalogo_model->getCol($id_color);
                        
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
                        $divColor = '<div style="background:'.$color->color.'" class="cu_col_mant" title="'.$color->nombre.'"></div>';
                        echo '<tr>';
                            echo '<td>'.($i+1).'</td>';												
                            echo '<td>'.$pic.'</td>';						
                            echo '<td class="left">'.$nombre_producto.'</td>';
                            echo '<td class="left">'.$codigo_producto.'</td>';
                            echo '<td class="center"><input type="text" class="span8" name="orden_'.$i.'" id="orden_'.$i.'" value="'.$orden.'"></td>';
                            echo '<td class="center">'.$divColor.'</td>';
                            echo '<td class="center"><input type="text" class="input-xlarge datepicker span8" name="fecha_'.$i.'" id="fecha_'.$i.'" value="'.$fecha_llegada.'"></td>';
                            echo '<td class="center"><input type="text" class="span8" name="stock_prox_'.$i.'" id="stock_prox_'.$i.'" value="'.$stock_proximamente.'"></td>';
                            echo '<td class="center">';
                            echo '<input type="hidden" name="id_producto_'.$i.'" id="id_producto_'.$i.'" value="'.$id_producto.'">';
                            echo '<input type="hidden" name="id_registro_'.$i.'" id="id_registro_'.$i.'" value="'.$proximo->id.'">';
                            echo '<input type="text" class="span10" name="precio_'.$i.'" id="precio_'.$i.'" value="'.$precio.'">';
                            echo '</td>';  
                            echo '<td>';
                            echo '<a class="btn btn-info" href="mainpanel/catalogo/edit_producto/'.$id_producto.'">EDITAR</a> ';
                            echo '</td>';
                        echo '</tr>';
                        $i++;
                    }
                ?>
                </tbody>
            </table>  
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="40%" id="loadjulio"></td>
                        <td width="60%" align="center" class="center">
                            <input type="hidden" name="num_items" id="num_items" value="<?php echo $i; ?>">
                            <input type="submit" class="btn btn-primary" value="ACTUALIZAR">
                        </td>                        
                    </tr>
                </tbody>
            </table>
            </form>
            </div>              
        </div>
     </div><!--/span-->
</div><!--/row-->