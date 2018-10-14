<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/compras/listado/1">Listado de Compras</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/compras/buscador">Buscador de Compras</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Datos de Pago</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/compras/actualizarPago" method="post" onsubmit="return valida_pago()">
                <fieldset>
                    <legend>Ingrese los datos</legend>
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
                        <label class="control-label" for="typeahead">Codigo Compra</label>
                        <div class="controls">
                            <?php echo ($orden->id_orden+10000); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Forma de Pago</label>
                        <div class="controls">
                        <select name="forma_pago" id="forma_pago" onchange="showOpcionesCompra(this.value)">
                            <option value="0">Elija...</option>
                            <option value="transferencia"<?php if($orden->forma_pago=="transferencia") echo ' selected'; ?>>Transferencia Bancaria</option>
                            <option value="deposito"<?php if($orden->forma_pago=="deposito") echo ' selected'; ?>>Deposito Bancario</option>
                            <option value="efectivo"<?php if($orden->forma_pago=="efectivo") echo ' selected'; ?>>Efectivo</option>
                            <?php
                                if($cliente->tiene_credito=="Si")
                                {
                                    if($orden->forma_pago=="credito")
                                    {
                                        echo '<option value="credito" selected>Credito ('.$cliente->plazo_credito.' dias)</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="credito">Credito ('.$cliente->plazo_credito.' dias)</option>';
                                    }                                    
                                }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Banco</label>
                        <div class="controls">
                        <select name="banco" id="banco">
                            <option value="0">Elija...</option>
                            <option value="BCP"<?php if($orden->banco=="BCP") echo ' selected'; ?>>Banco BCP  del Peru</option>
                            <option value="BANBIF"<?php if($orden->banco=="BANBIF") echo ' selected'; ?>>Banco Banbif</option>
                            <option value="BBVA"<?php if($orden->banco=="BBVA") echo ' selected'; ?>>Banco Continental  del Peru</option>
                            <option value="SCOTIA"<?php if($orden->banco=="SCOTIA") echo ' selected'; ?>>Banco Scotiabank del Peru</option>
                        </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Num. Operación</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="numero_operacion" name="numero_operacion" value="<?php echo $orden->numero_operacion; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Fecha de Pago</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge datepicker span2" id="fecha_pago" name="fecha_pago" value="<?php echo Ymd_2_dmY($orden->fecha_pago); ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Observaciones</label>
                        <div class="controls">
                        <textarea name="observaciones" rows="4" cols="50" id="observaciones"><?php echo $orden->observaciones; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Estado</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="estado_pago" value="Pendiente"<?php if($orden->estado_pago=="Pendiente") echo ' checked'; ?>> PENDIENTE
                            </label>
                            <label class="radio">
                                <input type="radio" name="estado_pago" value="Pagado"<?php if($orden->estado_pago=="Pagado") echo ' checked'; ?>> PAGADO
                            </label>
                            <label class="radio">
                                <input type="radio" name="estado_pago" value="Vencido"<?php if($orden->estado_pago=="Vencido") echo ' checked'; ?>> VENCIDO
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="id" id="id" value="<?php echo $orden->id_orden; ?>">
                        <input type="submit" class="btn btn-primary" value="ACTUALIZAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/compras/listado/1">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->