<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Cargos Adicionales</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/reservas/saveCargos" method="post" onsubmit="return valida_cargos_extra()">
                <fieldset>
                    <legend>Ingrese los datos de los cargos adicionales para esta reserva</legend>
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
                        <label class="control-label" for="typeahead">Concepto Cargo 1</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="concepto_cargo_1" name="concepto_cargo_1" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Monto Cargo 1</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" name="monto_cargo_1" id="monto_cargo_1" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Concepto Cargo 2</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="concepto_cargo_2" name="concepto_cargo_2" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Monto Cargo 2</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" name="monto_cargo_2" id="monto_cargo_2" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Concepto Cargo 3</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="concepto_cargo_3" name="concepto_cargo_3" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Monto Cargo 3</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" name="monto_cargo_3" id="monto_cargo_3" >
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="id" id="id" value="<?php echo $orden->id_orden; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR CARGOS">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/reservas/listadoActivas/1">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->