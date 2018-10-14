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
            <h2><i class="icon-user"></i> Productos de la Categor&iacute;a: <?php echo $nombre_subcategoria;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="10%">Imagen</th>
                        <th width="20%">Nombre</th>
                        <th width="10%">C&oacute;digo</th>
                        <th width="30%">Precios</th>
                        <th width="25%">Stock</th>                        
                    </tr>
                </thead>   
                <tbody>
                <?php
                    $orden = 1;
					$cad_id_precios=array();
					$cad_id_stocks=array();
                    //var_dump($categorias);
                    for($i=0; $i<count($productos); $i++)
                    {
                        $current = $productos[$i];
                        $foto = $current['imagen'];
                        $id_producto = $current['id_producto'];
                        $nombre2= $current['nombre'];						
                        $codigo= $current['codigo'];
                        $precios= $current['precios'];
                        $stock= $current['stock'];
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
                        
                        
                        $sr='';
						
                        for($r=0;$r<count($precios);$r++){
                            $cur=$precios[$r];
                            $precio=$cur['precio'];
                            $unidad=$cur['unidad'];
                            $id_precio=$cur['id_precio'];
							$cad_id_precios[]=$id_precio;
                            $sr .='<input type="text" style="display:inline" id="precio_'.$id_precio.'" name="precio_'.$id_precio.'" class="span4 typeahead" value="'.$precio.'">';
                            $sr .=' <span>'.$unidad.'</span><br>';
                        }
                        
                        
                        $sk='';
						
                        for($e=0;$e<count($stock);$e++){
                            $cur=$stock[$e];
                            $color=$cur['color'];
                            $nombre=$cur['nombre'];
                            $stock2=$cur['stock'];
                            $id_stock=$cur['id_stock'];
							$cad_id_stocks[]=$id_stock;
                            $sk .='<div class="env_col_mant">';
                            $sk .='<input type="text" style="display:inline" id="stock_'.$id_stock.'" name="stock_'.$id_stock.'" class="span7 typeahead" value="'.$stock2.'">';                            
                            $sk .='<div style="background:'.$color.'" class="cu_col_mant" title="'.$color.' - '.$nombre.'"></div>';
                            $sk .='</div>';
                        }                        
                        
                        
                        echo '<tr>';
                        echo '<td>'.($i+1).'</td>';												
                        echo '<td>'.$pic.'</td>';						
                        echo '<td class="left">'.$nombre2.'</td>';						
                        echo '<td class="center">'.$codigo.'</td>';
                        echo '<td class="center">'.$sr.'</td>';
                        echo '<td class="center">'.$sk.'</td>';   
                        echo '</tr>';

                    }
					
					$cad_id_precios=implode("&&",$cad_id_precios);
					$cad_id_stocks=implode("&&",$cad_id_stocks);					
                ?>
                  

                </tbody>
            </table>  
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="20%">
                            <a class="btn btn-small btn-success" style="margin:0px;" href="javascript:grabarModfTodo(<?php echo $id_subcategoria;?>)"><i class="icon-refresh icon-white"></i> Grabar Modificaci&oacute;n</a>
                            <input type="hidden" value="<?php echo $cad_id_precios;?>" id="cad_id_precios">
                            <input type="hidden" value="<?php echo $cad_id_stocks;?>" id="cad_id_stocks">                            
                        </td>
                        <td width="80%" id="loadjulio">
	                        
                        </td>
                    </tr>
                </tbody>
            </table>  
            </div>              
        </div>
     </div><!--/span-->
</div><!--/row-->