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
            <h2><i class="icon-edit"></i> Editar Categor&iacute;a</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/actualizar" method="post" enctype="multipart/form-data" onsubmit="return valida_categoria()">
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
                    ?>
                  
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span8 typeahead" id="nombre" name="nombre" value="<?php echo $categoria->nombre_categoria; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span1 typeahead" id="orden" name="orden" value="<?php echo $categoria->orden; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Imagen</label>
                        <div class="controls">
                            <div class="span6"><img src="files/categorias/<?php echo $categoria->imagen; ?>" /></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="estado" id="estado1" value="A"<?php if($categoria->estado=="A") echo ' checked="checked"'; ?>>
                                Activo
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="estado" id="estado2" value="I"<?php if($categoria->estado=="I") echo ' checked="checked"'; ?>>
                                Inactivo
                            </label>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label">Tipo de Categoria</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="tipo" id="tipo1" value="0"<?php if($categoria->tipo=="0") echo ' checked="checked"'; ?>>
                                Publica
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="tipo" id="tipo2" value="1"<?php if($categoria->tipo=="1") echo ' checked="checked"'; ?>>
                                Privada
                            </label>
                        </div>
                    </div> 
                    <div class="control-group error">
                        <div class="controls">                    
                        <span class="help-inline">La imagen que suba será reducida a 150px de ancho por 150px de alto.</span>
                        </div>
                    </div>
                    <div class="control-group">
	                    <label class="control-label">Nueva Foto</label>                    
                        <div class="controls">
                          <input type="file" name="foto" id="foto_e">
                        </div>
                    </div><!--control-group-->
                    <div class="control-group">
                        <label class="control-label">Incluir en Inventario?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="incluir_en_inventario" id="incluir_en_inventario1" value="1"<?php if($categoria->incluir_en_inventario=="1") echo ' checked="checked"'; ?>>
                                SI
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="incluir_en_inventario" id="incluir_en_inventario2" value="0"<?php if($categoria->incluir_en_inventario=="0") echo ' checked="checked"'; ?>>
                                NO
                            </label>
                        </div>
                    </div> 
                    <div class="form-actions">
                        <input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo $categoria->id_categoria; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/catalogo/listado">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->