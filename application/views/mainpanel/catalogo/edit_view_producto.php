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
            <h2><i class="icon-edit"></i> Editar Producto</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/actualizar_producto" method="post" enctype="multipart/form-data" onsubmit="return valida_producto2()">
                <fieldset>
                    <legend>Modifique los datos deseados</legend>
                    <?php
                        if(isset($resultado) && ($resultado=="success"))
                        {
                            echo '<div class="alert alert-success">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                            echo '</div>';
                        }
                        if(isset($resultado) && ($resultado=="error"))
                        {
                            echo '<div class="alert alert-error">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Ocurrio un error al actualizar los datos';
                            echo '</div>';
                        }                        
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Categor&iacute;a</label>
                        <div class="controls">
                            <select name="id_categoria_padre" id="id_categoria_padre" onchange="cargaSubcats(this.value)">
                                <option value="0">Elija...</option>
                                <?php
                                for($i=0; $i<count($categorias); $i++)
                                {
                                    $current = $categorias[$i];
                                    $id_categoria_padre = $current['id_categoria'];
                                    $nombre_categoria = $current['nombre_categoria'];
                                    echo '<option value="'.$id_categoria_padre.'">'.$nombre_categoria.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Sub Categor&iacute;a</label>
                        <div class="controls" id="divSubCategorias">
                            <select name="id_subcategoria" id="id_subcategoria">
                                <option value="0">Elija...</option>
                            </select> <input type="button" onclick="agregaSubcategoriaLista()" value="AGREGAR">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div id="elejidos_colores" >
                                <h3>SUBCATEGORIAS ELEGIDAS</h3>
                                <div id="contenedor_elegidos" class="clearfix">
                                <table width="80%" cellpadding="0" border="1" cellspacing="0" id="tablaSubcats">
                                <thead>
                                    <th width="45%">CATEGORIA</th>
                                    <th width="35%">SUB CATEGORIA</th>
                                    <th width="20%">ACCION</th>
                                </thead>
                                <tbody>
                                <?php
                                for($i=0; $i<count($subcats_x_prod); $i++)
                                {
                                    $current = $subcats_x_prod[$i];
                                    $id_subcategoria = $current['id_subcategoria'];
                                    $nombre_categoria = $current['nombre_categoria'];
                                    $nombre_subcategoria = $current['nombre_subcategoria'];
                                    echo '<tr id="fila_'.$id_subcategoria.'">';
                                    echo '<td height="25" align="center" valign="middle">'.$nombre_categoria.'</td>';
                                    echo '<td align="center" valign="middle">'.$nombre_subcategoria.'</td>';
                                    echo '<td align="center" valign="middle"><a href="javascript:quitarSubCatLista(\''.$id_subcategoria.'\')">ELIMINAR</a></td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                                </table>
                                </div>
                                <input type="hidden" id="subcats_elegidas" name="subcats_elegidas" value="<?php echo $concatenado; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span8 typeahead" id="nombre" name="nombre" value="<?php echo $producto->nombre; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Imagen</label>
                        <div class="controls">
                            <div class="span6">
                                <?php
                                if(is_file('files/productos_thumbs/'.$producto->imagen))
                                {
                                    $img = getimagesize('files/productos_thumbs/'.$producto->imagen);
                                    $ancho = (int)($img[0]/1);
                                    $alto = (int)($img[1]/1);                            
                                    $pic = '<img src="files/productos_thumbs/'.$producto->imagen.'" width="'.$ancho.'" height="'.$alto.'" border="0"/>';
                                }
                                else
                                {
                                    $img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
                                    $ancho = (int)($img[0]/1);
                                    $alto = (int)($img[1]/1);                              
                                    $pic = '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" border="0"/>';
                                } 
                                echo $pic;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group warning">
	                    <label class="control-label">Foto actualizada al:</label>                    
                        <div class="controls">
                         <span class="help-inline"><?php echo $producto->actualizacion;?></span>
                        </div>
                    </div><!--control-group-->                  
                    <div class="control-group error">
                        <div class="controls">                    
                            <span class="help-inline">La imagen debe tener como m&iacute;nimo 500 pixeles de ancho.</span>
                        </div>
                    </div>
                    <div class="control-group">
	                    <label class="control-label">Nueva Foto</label>                    
                        <div class="controls">
                          <input type="file" name="foto" id="foto_e">
                        </div>
                    </div><!--control-group-->
                    <div class="control-group">
                        <label class="control-label" for="typeahead">C&oacute;digo</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="codigo" name="codigo" value="<?php echo $producto->codigo;?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden" name="orden" value="<?php echo $producto->orden;?>" >
                        </div>
                    </div>                                                            
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Precio</label>
                        
                        <!--este hidden es para saber cuantos mostrar al hacer document ready-->
                        <input type="hidden" value='<?php echo count($precios);?>' id='num_precios' name='num_precios'/>
                        <input type="hidden" name="num_unidades" value="<?php echo count($unidades);?>" />
                        
                        <?php 
                        for($f=0;$f<count($precios);$f++){
                            $current2=$precios[$f];
                            ?>
                            <div class="controls fila_precio">
                                <input type='hidden' value='<?php echo $current2['id'];?>' name='id_precio_<?php echo $f;?>' />
                                S/.
                                <input type="hidden" name="moneda_<?php echo $f;?>" id="moneda_<?php echo $f;?>" value="s" />                                
                                <input type="text" class="span2 typeahead" id="precio_<?php echo $f;?>" name="precio_<?php echo $f;?>" value="<?php echo $current2['precio'];?>" style="display: inline">
                                <select name="unidad_<?php echo $f;?>" id="unidad_<?php echo $f;?>">
                                <option value="0">Elija...</option>
                                <?php
                                for($i=0; $i<count($unidades); $i++)
                                {
                                    $current = $unidades[$i];
                                    $id = $current['id'];
                                    $texto = $current['texto'];
                                    if($current2['id_unidad']==$id){
                                        echo '<option value="'.$id.'" selected>'.$texto.'</option>';
                                    }else {
                                        echo '<option value="'.$id.'">'.$texto.'</option>';
                                    }

                                }
                                ?>
                                </select>
                                <?php
                                echo '<a href="javascript:muestra_precio('.($f+1).')">Otro Precio</a>';
                                if($f>0){
                                    echo ' | ';
                                    echo '<a href="javascript:eliminarPrecio('.$current2['id'].')"><img src="assets/frontend/cki/imagenes/delete.png" border="0" width="20" title="Eliminar Precio"></a>';                                
                                }
                                ?>
                            </div>                                
                            <?php
                        }
                        
                        for($f=count($precios);$f<count($unidades);$f++){

                            ?>
                            <div class="controls fila_precio">
                                S/. 
                                <input type="text" class="span2 typeahead" id="precio_<?php echo $f;?>" name="precio_<?php echo $f;?>" value="" style="display: inline">
                                <input type="hidden" name="moneda_<?php echo $f;?>" id="moneda_<?php echo $f;?>" value="s" />
                                <select name="unidad_<?php echo $f;?>" id="unidad_<?php echo $f;?>">
                                <option value="0" selected>Elija...</option>
                                <?php
                                for($i=0; $i<count($unidades); $i++)
                                {
                                    $current = $unidades[$i];
                                    $id = $current['id'];
                                    $texto = $current['texto'];
                                    echo '<option value="'.$id.'" >'.$texto.'</option>';
                                }
                                ?>
                                </select>
                                <?php 
                                echo '<a href="javascript:muestra_precio('.($f+1).')">Otro Precio</a>';
                                //echo ' | ';
                                //echo '<a href="javascript:eliminaPrecioNew('.($f).')"><img src="assets/frontend/cki/imagenes/delete.png" border="0" width="20" title="Eliminar Precio"></a>';
                                ?>
                            </div>                                
                        <?php
                        }
                        ?>
                       
                        
                    </div>
                    <!--<div class="control-group">
                        <label class="control-label" for="typeahead">Stock</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="stock" name="stock" value="<?php //echo $producto->stock;?>" >
                        </div>
                    </div>                    -->

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Aplica Descuento por cambio de moneda (<?php echo getConfig("descuento");?>)</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="descuento" value="si" <?php if($producto->descuento=='si'){echo 'checked';};?> />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="descuento" value="no" <?php if($producto->descuento=='no'){echo 'checked';};?> />No                            
                         </label>
                        </div>
                    </div> 

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Mostrar Stock</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="show_stock" value="1" <?php if($producto->show_stock==1){echo 'checked';};?> />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="show_stock" value="0" <?php if($producto->show_stock==0){echo 'checked';};?> />No                            
                         </label>
                        </div>
                    </div> 

                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Proximamente?</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="oferta" value="1" <?php if($producto->oferta==1){echo 'checked';};?> />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="oferta" value="0" <?php if($producto->oferta==0){echo 'checked';};?> />No                            
                         </label>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden Proximamente</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden_proximamente" name="orden_proximamente" value="<?php echo $producto->orden_proximamente; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nuevo Ingreso?</label>
                        <div class="controls">
                        <label class="radio">
							<input type="radio" name="novedad" value="1" <?php if($producto->novedad==1){echo 'checked';};?> />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
							<input type="radio" name="novedad" value="0" <?php if($producto->novedad==0){echo 'checked';};?> />No                            
                         </label>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden Nuevo Ingreso</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden_novedad" name="orden_novedad" value="<?php echo $producto->orden_novedad; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">% de descuento (aplica para clientes elegidos)</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="descuento_especial" name="descuento_especial" value="<?php echo $producto->descuento_especial; ?>">
                        </div>
                    </div>                     
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Descripci&oacute;n</label>
                        <div class="controls">
                            <textarea id="texto" name="descripcion" rows="3"><?php echo $producto->descripcion; ?></textarea>
                            <script type="text/javascript">
                                //window.onload = function()
                                /*{
                                    var oFCKeditor = new FCKeditor( 'descripcion' ) ;
                                    oFCKeditor.BasePath = "<?php //echo base_url();?>assets/fckeditor/";
                                    oFCKeditor.Width  = '700' ;
                                    oFCKeditor.Height = '350' ;
                                    oFCKeditor.ReplaceTextarea();
                                }*/
								CKEDITOR.replace( 'texto' );
                            </script>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Material</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="material" name="material" value="<?php echo $producto->material; ?>">
                        </div>
                    </div>                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Medidas del Producto</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="medidas" name="medidas" value="<?php echo $producto->medidas; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Medidas de la Caja</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="medidas_caja" name="medidas_caja" value="<?php echo $producto->medidas_caja; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Area de Impresi&oacute;n</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="area_impresion" name="area_impresion" value="<?php echo $producto->area_impresion; ?>">
                        </div>
                    </div>                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">M&eacute;todo de Impresi&oacute;n</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="metodo_impresion" name="metodo_impresion" value="<?php echo $producto->metodo_impresion; ?>">
                        </div>
                    </div>                       
                    <div class="form-actions">
                        <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $producto->id_producto; ?>">
                        <input type="hidden" name="fotoantg" id="fotoantg" value="<?php echo $producto->imagen; ?>">                        
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/catalogo/listado_productos/<?php echo $producto->id_categoria_padre;?>">VOLVER AL LISTADO</a>
                        
                    </div>
                </fieldset>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->