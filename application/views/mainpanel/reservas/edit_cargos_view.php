<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Cargos Adicionales</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/reservas/updateCargos" method="post" onsubmit="return valida_cargos_extra()">
                <fieldset>
                    <legend>Actualice los datos de los cargos adicionales para esta reserva</legend>
                    <?php
                        if(isset($resultado) && ($resultado=="success"))
                        {
                            echo '<div class="alert alert-success">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                            echo '</div>';
                        }
                        $indice = 1;
                        foreach($cargos as $cargo)
                        {
                    ?>
                    <div class="control-group">
                        <label class="control-label">Acción con este cargo?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="accion_<?php echo $indice; ?>" value="editar" checked="checked">
                                EDITAR
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="accion_<?php echo $indice; ?>" value="borrar">
                                ELIMINAR
                            </label>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Concepto Cargo <?php echo $indice; ?></label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="concepto_cargo_<?php echo $indice; ?>" name="concepto_cargo_<?php echo $indice; ?>" value="<?php echo $cargo->concepto; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Monto Cargo <?php echo $indice; ?></label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" name="monto_cargo_<?php echo $indice; ?>" id="monto_cargo_<?php echo $indice; ?>" value="<?php echo $cargo->monto; ?>" >
                            <input type="hidden" name="id_cargo_<?php echo $indice; ?>" id="id_cargo_<?php echo $indice; ?>" value="<?php echo $cargo->id; ?>" >
                        </div>
                    </div>
                    <hr>
                    <?php
                            $indice++;
                        }
                        for($i=$indice; $i<=3; $i++)
                        {
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Concepto Cargo <?php echo $i; ?></label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="concepto_cargo_<?php echo $i; ?>" name="concepto_cargo_<?php echo $i; ?>" value="" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Monto Cargo <?php echo $i; ?></label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" name="monto_cargo_<?php echo $i; ?>" id="monto_cargo_<?php echo $i; ?>" value="" >
                            <input type="hidden" name="id_cargo_<?php echo $i; ?>" id="id_cargo_<?php echo $i; ?>" value="0" >
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="form-actions">
                        <input type="hidden" name="id" id="id" value="<?php echo $orden->id_orden; ?>">
                        <input type="submit" class="btn btn-primary" value="ACTUALIZAR CARGOS">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/reservas/listadoActivas/1">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->