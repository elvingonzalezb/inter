<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/cargos/listado">Listado de Cargos</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/cargos/nuevo">Nuevo Cargo Adicional</a> </li> 
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Cargo Adicional</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/cargos/actualizar" method="post" onsubmit="return valida_cargo()">
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
                        <label class="control-label" for="typeahead">Concepto</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="concepto" name="concepto" value="<?php echo $cargo->concepto; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Monto (S/)</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="monto" name="monto" value="<?php echo $cargo->monto; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="estado" value="A" <?php if($cargo->estado=="A") echo ' checked="checked"'; ?>>
                                Activo
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="estado" value="I" <?php if($cargo->estado=="I") echo ' checked="checked"'; ?>>
                                Inactivo
                            </label>
                        </div>
                    </div>                    
                    <div class="form-actions">
                        <input type="hidden" name="id" value="<?php echo $cargo->id; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->