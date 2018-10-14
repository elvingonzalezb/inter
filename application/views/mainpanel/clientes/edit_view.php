<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/clientes/listado">Lista de Clientes</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/clientes/listado_inactivos">Clientes Inactivos</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/clientes/listado_anulados">Clientes Anulados</a> <span class="divider">/</span></li> 
        <li><a href="mainpanel/clientes/listado_borrados">Clientes Borrados</a> <span class="divider">/</span></li>       
        <li><a href="mainpanel/clientes/search_visitas">Buscar Visitas</a> <span class="divider">/</span></li>                        
        <li><a href="mainpanel/clientes/form_buscar">Buscar Clientes</a> </li>       
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar datos de Cliente</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/clientes/actualizar" method="post" enctype="multipart/form-data" onsubmit="return valida_clientes()">
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
                        <label class="control-label" for="typeahead">Razón Social</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="razon_social" name="razon_social" value="<?php echo $cliente->razon_social; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span5 typeahead" id="nombre" name="nombre" value="<?php echo $cliente->nombre; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">RUC</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="ruc" name="ruc" value="<?php echo $cliente->ruc; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Cargo</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="cargo" name="cargo" value="<?php echo $cliente->cargo; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Domicilio</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="domicilio" name="domicilio" value="<?php echo $cliente->domicilio; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Distrito</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="distrito" name="distrito" value="<?php echo $cliente->distrito; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Ciudad</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="ciudad" name="ciudad" value="<?php echo $cliente->ciudad; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Provincia</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="provincia" name="provincia" value="<?php echo $cliente->provincia; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Departamento</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="departamento" name="departamento" value="<?php echo $cliente->departamento; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">País</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="pais" name="pais" value="<?php echo $cliente->pais; ?>" >
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Procedencia</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="procedencia" value="Lima" <?php if($cliente->procedencia=="Lima") echo ' checked="checked"'; ?>>
                                Lima
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="procedencia" value="Provincia" <?php if($cliente->procedencia=="Provincia") echo ' checked="checked"'; ?>>
                                Provincia
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="procedencia" value="Extranjero" <?php if($cliente->procedencia=="Extranjero") echo ' checked="checked"'; ?>>
                                Extranjero
                            </label>
                        </div>
                    </div> 
                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Código Postal</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="zip" name="zip" value="<?php echo $cliente->zip; ?>" >
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Teléfono</label>
                        <div class="controls">
                            <input type="text" class="span4 typeahead" id="telefono" name="telefono" value="<?php echo $cliente->telefono; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Teléfono 2</label>
                        <div class="controls">
                            <input type="text" class="span4 typeahead" id="telefono2" name="telefono2" value="<?php echo $cliente->telefono2; ?>" >
                        </div>
                    </div>                     
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Facebook Empresarial</label>
                        <div class="controls">
                            <input type="text" class="span4 typeahead" id="fax" name="fax" value="<?php echo $cliente->fax; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Web</label>
                        <div class="controls">
                            <input type="text" class="span4 typeahead" id="web" name="web" value="<?php echo $cliente->web; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Tipo de Cliente</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="tipo_cliente" name="tipo_cliente" value="<?php echo $cliente->tipo_cliente; ?>" >
                        </div>
                    </div>                     
                    <div class="control-group">
                        <label class="control-label">Permitir ver Precios</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="ver_precio" value="no" <?php if($cliente->ver_precio=="no") echo ' checked="checked"'; ?>>
                                No
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="ver_precio" value="si" <?php if($cliente->ver_precio=="si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                        </div>
                    </div>                       
                    
                    <div class="control-group">
                        <label class="control-label">Permitir ver Inventario</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="ver_inventario" value="no" <?php if($cliente->ver_inventario=="no") echo ' checked="checked"'; ?>>
                                No
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="ver_inventario" value="si" <?php if($cliente->ver_inventario=="si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                        </div>
                    </div>                       

                    <div class="control-group">
                        <label class="control-label">¿ Verlo en ?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="moneda" value="s" <?php if($cliente->moneda=="s") echo ' checked="checked"'; ?>>
                                Soles
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="moneda" value="d" <?php if($cliente->moneda=="d") echo ' checked="checked"'; ?>>
                                Dolar
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">¿ Descuento por tipo de cambio?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="descuento" value="si" <?php if($cliente->descuento=="si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="descuento" value="no" <?php if($cliente->descuento=="no") echo ' checked="checked"'; ?>>
                                No
                            </label>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label">Aplica descuento especial de producto?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="descuento_especial" value="si" <?php if($cliente->descuento_especial=="si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="descuento_especial" value="no" <?php if($cliente->descuento_especial=="no") echo ' checked="checked"'; ?>>
                                No
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Puede ver categorias privadas?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="categorias_especiales" value="si" <?php if($cliente->categorias_especiales=="si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="categorias_especiales" value="no" <?php if($cliente->categorias_especiales=="no") echo ' checked="checked"'; ?>>
                                No
                            </label>
                        </div>
                    </div>  
                    
                    <div class="control-group">
                        <label class="control-label">Puede ver Histórico de Pedidos?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="ver_historico_pedidos" value="Si" <?php if($cliente->ver_historico_pedidos=="Si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="ver_historico_pedidos" value="No" <?php if($cliente->ver_historico_pedidos=="No") echo ' checked="checked"'; ?>>
                                No
                            </label>
                        </div>
                    </div> 
                    
                    <div class="control-group">
                        <label class="control-label">Tiene Credito?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="tiene_credito" value="Si" <?php if($cliente->tiene_credito=="Si") echo ' checked="checked"'; ?>>
                                Si
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="tiene_credito" value="No" <?php if($cliente->tiene_credito=="No") echo ' checked="checked"'; ?>>
                                No
                            </label>
                        </div>
                    </div> 
                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Dias de credito</label>
                        <div class="controls">
                            <input type="text" class="span3 typeahead" id="plazo_credito" name="plazo_credito" value="<?php echo $cliente->plazo_credito; ?>" >
                        </div>
                    </div> 
                    
                    <div class="control-group">
                        <label class="control-label">Cargos adicionales?</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="tiene_cargos" value="1" <?php if($cliente->tiene_cargos==1) echo ' checked="checked"'; ?>>
                                Si
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="tiene_cargos" value="0" <?php if($cliente->tiene_cargos==0) echo ' checked="checked"'; ?>>
                                No
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="tiene_cargos" value="2" <?php if($cliente->tiene_cargos==2) echo ' checked="checked"'; ?>>
                                ESPORADICAMENTE
                            </label>
                        </div>
                    </div> 
                    
                    <h3>Informaci&oacute;n de acceso</h3>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Email</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="email" name="email" value="<?php echo $cliente->email; ?>" >
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Clave</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="clave" name="clave" value="<?php echo $cliente->clave; ?>" >
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label">Tipo de cuenta</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="tipo_cuenta" value="0" <?php if($cliente->tipo_cuenta=="0") echo ' checked="checked"'; ?>>
                                P&uacute;blico en general
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="tipo_cuenta" value="1" <?php if($cliente->tipo_cuenta=="1") echo ' checked="checked"'; ?>>
                                VIP
                            </label>
                        </div>
                    </div>                    
                    <div class="form-actions">
                        <input type="hidden" name="id_cliente" value="<?php echo $cliente->id; ?>">
                        <?php
                        if($cliente->estado=='Activo'){?>
                            <a class="btn btn-small btn-success" href="javascript:desactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-th-list icon-white"></i>  Desactivar</a>
                            <?php
                        }else if($cliente->estado=='Inactivo'){
                            ?>
                            <a class="btn btn-small btn-success" href="javascript:reactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-th-list icon-white"></i>  Activar</a>
                            <?php
                        }
                        if($cliente->estado=='Anulado'){?>
                            <a class="btn btn-small btn-success" href="javascript:reactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-th-list icon-white"></i>  Reactivar</a>
                            <?php
                        }                        
                        ?>
                        <a class="btn btn-danger" href="javascript:eliminarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-trash icon-white"></i>Marcar como Borrado</a>
                        <a class="btn btn-danger" href="javascript:deleteCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-trash icon-white"></i>Borrar</a>
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->