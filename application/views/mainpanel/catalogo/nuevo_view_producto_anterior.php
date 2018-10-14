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
            <h2><i class="icon-edit"></i> Agregar Nuevo Producto</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/grabar_producto" method="post" enctype="multipart/form-data" onsubmit="return valida_producto2()">
                <fieldset>
                    <legend>Nuevo Producto</legend>
                    <?php
                        if( isset($resultado) )
                        {
                            if($resultado=="success")
                            {
                                echo '<div class="alert alert-success">';
                                echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                                echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                                echo '</div>';
                            }
                            if($resultado=="error")
                            {
                                echo '<div class="alert alert-error">';
                                echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                                echo '<strong>RESULTADO:</strong> '.str_replace("%20", " ", str_replace("-", " ", $error));
                                echo '</div>';                                
                            }
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
                                    if(isset($id_categoria) && $id_categoria==$id_categoria_padre){
                                        echo '<option value="'.$id_categoria_padre.'" selected>'.$nombre_categoria.'</option>';
                                    }else {
                                        echo '<option value="'.$id_categoria_padre.'">'.$nombre_categoria.'</option>';
                                    }

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
                                    
                                </tbody>
                                </table>
                                </div>
                                <input type="hidden" id="subcats_elegidas" name="subcats_elegidas">
                            </div>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="nombre" name="nombre" value="" >
                        </div>
                    </div>
                    <div class="control-group error">
                        <div class="controls">                    
                            <span class="help-inline">La imagen debe tener como m&iacute;nimo 500 pixeles de ancho.</span>
                        </div>
                    </div>
                    <div class="control-group">
	                    <label class="control-label">Subir Foto</label>                    
                        <div class="controls">
                          <input type="file" name="foto" id="foto">
                        </div>
                    </div><!--control-group-->
                    <div class="control-group">
                        <label class="control-label" for="typeahead">C&oacute;digo</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="codigo" name="codigo">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden" name="orden">
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Precio</label>
                        <input type="hidden" name="num_unidades" value="<?php echo count($unidades);?>" />
                        
                        <?php 

                        for($f=0;$f<count($unidades);$f++){
                            ?>
                            <div class="controls fila_precio">
                                S/. 
                                <input type="text" class="span2 typeahead" id="precio_<?php echo $f;?>" name="precio_<?php echo $f;?>" value="" style="display: inline">
                                <input type="hidden" name="moneda_<?php echo $f;?>" id="moneda_<?php echo $f;?>" value="s" />
                                <select name="unidad_<?php echo $f;?>" id="unidad_<?php echo $f;?>">
                                <option value="0">Elija...</option>
                                <?php
                                for($i=0; $i<count($unidades); $i++)
                                {
                                    $current = $unidades[$i];
                                    $id = $current['id'];
                                    $texto = $current['texto'];
                                    echo '<option value="'.$id.'">'.$texto.'</option>';
                                }
                                ?>
                                </select>
                                <?php 
                                echo '<a href="javascript:muestra_precio('.($f+1).')">Otro Precio</a>';
                                
                                ?>
                            </div>                                
                        <?php
                        }
                        ?>
                       
                        
                    </div>                    
<!--                    <div class="control-group">
                        <label class="control-label" for="typeahead">Stock</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="stock" name="stock" value="" >
                        </div>
                    </div>                    -->

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Aplica Descuento por cambio de moneda(<?php echo getConfig("descuento");?>)</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="descuento" value="si" />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="descuento" value="no" checked />No                            
                         </label>
                        </div>
                    </div> 

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Mostrar Stock</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="show_stock" value="1" />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="show_stock" value="0" checked />No                            
                         </label>
                        </div>
                    </div>                     
<!--                    <div class="control-group">
                        <label class="control-label" for="typeahead">Tipo </label>
                        <div class="controls">
                        <select name="tipo">
                            <option value="0" selected>de Acceso Público</option>
                            <option value="1">para Clientes VIP</option>
                        </select>                        
                        </div>
                    </div>-->
                   
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Color</label>
                        <div class="controls">
                            <select onChange="muestra_color(this.value)">
                                <option value='0'>:: Elija ::</option>
                                <?php
                                foreach ($familias as $value) {
                                    $nombre=$value->nombre;
                                    $id_familia=$value->id;
                                    echo '<option value="'.$id_familia.'">'.$nombre.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div id="cont_colores" class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div id="elejidos_colores" >
                                <h5>Colores Elejidos con Stock</h5>
                                <div id="cont_elejidos" class="clearfix"></div>
                                <input type="hidden" id="id_concatenados" name="id_concatenados">
                            </div>
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Proximamente?</label>
                        <div class="controls">
                         <label class="radio">
                            <input type="radio" name="oferta" value="1" />Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="oferta" value="0" checked />No                            
                         </label>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden Proximamente</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden_proximamente" name="orden_proximamente" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nuevo Ingreso?</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="novedad" value="1"/>Si
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="novedad" value="0" checked />No                            
                         </label>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden Nuevo Ingreso</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden_novedad" name="orden_novedad" />
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">% de descuento (aplica para clientes elegidos)</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="descuento_especial" name="descuento_especial" />
                        </div>
                    </div>                     
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Descripci&oacute;n</label>
                        <div class="controls">
                            <textarea id="texto" name="descripcion" rows="3"></textarea>
                            <script type="text/javascript">
/*                                window.onload = function()
                                {
                                    var oFCKeditor = new FCKeditor( 'descripcion' ) ;
                                    oFCKeditor.BasePath = "<?php echo base_url();?>assets/fckeditor/";
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
                            <input type="text" class="span2 typeahead" id="material" name="material">
                        </div>
                    </div>                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Medidas del Producto</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="medidas" name="medidas">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Medidas de la Caja</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="medidas_caja" name="medidas_caja">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Area de Impresi&oacute;n</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="area_impresion" name="area_impresion">
                        </div>
                    </div>                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">M&eacute;todo de Impresi&oacute;n</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="metodo_impresion" name="metodo_impresion">
                        </div>
                    </div>                    
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        <input type="hidden" name="num_colores" id="num_colores" value="" />                        
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->