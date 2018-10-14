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
            <h2><i class="icon-edit"></i> Editar Sub Categor&iacute;a</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/actualizarsubcat" method="post" enctype="multipart/form-data" onsubmit="return valida_categoria()">
                <fieldset>
                    <legend>Ingrese los datos de la Sub Categor&iacute;a</legend>
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
                                echo '<strong>RESULTADO:</strong> '.str_replace("%20", " ", $error);
                                echo '</div>';                                
                            }
                        }
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Categor&iacute;a</label>
                        <div class="controls">
                            <select name="id_categoria" id="id_categoria">
                                <option value="0">Elija...</option>
                                <?php
                                $id_categoria = $subcategoria->id_categoria;
                                for($i=0; $i<count($categorias); $i++)
                                {
                                    $current = $categorias[$i];
                                    $id_categoria_padre = $current['id_categoria'];
                                    $nombre_categoria = $current['nombre_categoria'];
                                    if($id_categoria_padre==$id_categoria)
                                    {
                                        echo '<option value="'.$id_categoria_padre.'" selected>'.$nombre_categoria.'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$id_categoria_padre.'">'.$nombre_categoria.'</option>';
                                    }

                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="nombre" name="nombre" value="<?php echo $subcategoria->nombre; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="orden" name="orden" value="<?php echo $subcategoria->orden; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="estado" id="estado1" value="A"<?php if( ($subcategoria->estado)=="A") echo ' checked="checked"'; ?>>
                                Activo
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="estado" id="estado2" value="I"<?php if( ($subcategoria->estado)=="I") echo ' checked="checked"'; ?>>
                                Inactivo
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="id_subcategoria" id="id_subcategoria" value="<?php echo $subcategoria->id_subcategoria; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/catalogo/listadosubcats/<?php echo $subcategoria->id_categoria; ?>">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->