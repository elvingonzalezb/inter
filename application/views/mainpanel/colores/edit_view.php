<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/colores/listado">Lista de Familia</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/colores/nuevo">Agregar Familia</a> </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Familia</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/colores/actualizar" method="post" enctype="multipart/form-data" onsubmit="return valida_categoria()">
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
                            <input type="text" class="span8 typeahead" id="nombre" name="nombre" value="<?php echo $categoria->nombre; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span1 typeahead" id="orden" name="orden" value="<?php echo $categoria->orden; ?>" >
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

                    <div class="form-actions">
                        <input type="hidden" name="id" id="id" value="<?php echo $categoria->id; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/colores/listado">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->