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
            <h2><i class="icon-edit"></i> Detalle de Cliente</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
                <?php
                    if(isset($resultado) && ($resultado=="success"))
                    {
                        echo '<div class="alert alert-success">';
                        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                        echo '<strong>RESULTADO:</strong> Su correo electrónico se envió correctamente';
                        echo '</div>';
                    }
                ?>            
                <fieldset>
                    <h3>Informaci&oacute;n del Cliente</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td width="30%"><h4>CODIGO CLIENTE:</h4></td>
                                <td width="70%">
                                    <strong><?php echo $cliente->codigo_cliente; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%"><h4>Razón Social:</h4></td>
                                <td width="70%">
                                    <?php echo $cliente->razon_social; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Nombre:</h4></td>
                                <td>
                                    <?php echo $cliente->nombre; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>RUC:</h4></td>
                                <td>
                                    <?php echo $cliente->ruc; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Domicilio:</h4></td>
                                <td>
                                    <?php echo $cliente->domicilio; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Cargo:</h4></td>
                                <td>
                                    <?php echo $cliente->cargo; ?>
                                </td>
                            </tr>                            
                            <tr>
                                <td><h4>Ciudad:</h4></td>
                                <td>
                                    <?php echo $cliente->ciudad; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Provincia:</h4></td>
                                <td>
                                    <?php echo $cliente->provincia; ?>
                                </td>
                            </tr>                            
                            <tr>
                                <td><h4>Departamento:</h4></td>
                                <td>
                                    <?php echo $cliente->departamento; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>País:</h4></td>
                                <td>
                                    <?php echo $cliente->pais; ?>
                                </td>
                            </tr> 
                            <tr>
                                <td><h4>Procedencia:</h4></td>
                                <td>
                                    <?php echo $cliente->procedencia; ?>
                                </td>
                            </tr> 
                            <tr>
                                <td><h4>Código Postal:</h4></td>
                                <td>
                                    <?php echo $cliente->zip; ?>
                                </td>
                            </tr>                            
                            <tr>
                                <td><h4>Teléfono:</h4></td>
                                <td>
                                    <?php echo $cliente->telefono; ?>
                                </td>
                            </tr> 
                            <tr>
                                <td><h4>Teléfono 2:</h4></td>
                                <td>
                                    <?php echo $cliente->telefono2; ?>
                                </td>
                            </tr>                             
                            <tr>
                                <td><h4>Facebook Empresarial:</h4></td>
                                <td>
                                    <?php echo $cliente->fax; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Web:</h4></td>
                                <td>
                                    <?php echo $cliente->web; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Tipo de Cliente:</h4></td>
                                <td>
                                    <?php echo $cliente->tipo_cliente;?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Estado:</h4></td>
                                <td>
                                    <?php echo $cliente->estado;?>
                                </td>
                            </tr>                            
                            <tr>
                                <td><h4>Fecha de Registro:</h4></td>
                                <td>
                                    <?php echo $cliente->fecha_registro;?>
                                </td>
                            </tr>                             
                        </tbody>
                    </table>                    
                    
                    <h3>Informaci&oacute;n de acceso</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td width="30%"><h4>Email:</h4></td>
                                <td width="70%">
                                    <?php echo $cliente->email; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Clave:</h4></td>
                                <td>
                                    <?php echo $cliente->clave; ?>
                                </td>
                            </tr>                             
                            
                        </tbody>
                    </table>                      

                    <h3>Productos de Interes</h3>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo str_replace("#",", ",$cliente->preferencias);?>
                                </td>
                            </tr>                                 
                        </tbody>
                    </table>  
                    
                    <h3>Envie un Correo Electr&oacute;nico al Cliente desde aqui</h3>
                    <form action="mainpanel/clientes/envio_correo" method="post" onSubmit="return valida_correo_cli()">
                    <table class="table table-bordered table-striped" border="0">
                        <tbody>
                            <tr>
                                <td>
                                    <textarea name="msgCli" id="msgCli" cols="100" rows="5"></textarea>
                                </td>
                            </tr>                                 
                        </tbody>
                            <tr>
                                <td><input type="submit" class="btn btn-large btn-primary" value="Enviar Mensaje" ></td>
                                <input type="hidden" name="email" value="<?php echo $cliente->email;?>" />
                                <input type="hidden" name="razon_social" value="<?php echo $cliente->razon_social;?>" />                                
                                <input type="hidden" name="id_cliente" value="<?php echo $cliente->id;?>" />                                                                
                            </tr>
                    </table>                      
                    </form>
                    <div class="form-actions">
                        <input type="hidden" name="id_cliente" value="<?php echo $cliente->id; ?>">
                        <?php
                        if($cliente->estado=='Activo'){?>
                            <a class="btn btn-small btn-success" href="javascript:desactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-remove-circle icon-white"></i>  Inactivar</a>
                            <a class="btn btn-small btn-inverse" href="javascript:anularCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-headphones icon-white"></i>  Anular</a>                            
                            <?php
                        }else if($cliente->estado=='Inactivo'){
                            ?>
                            <a class="btn btn-small btn-success" href="javascript:reactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-refresh icon-white"></i>  Reactivar</a>
                            <a class="btn btn-small btn-inverse" href="javascript:anularCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-headphones icon-white"></i>  Anular</a>
                            <?php
                        }
                        if($cliente->estado=='Anulado'){?>
                            <a class="btn btn-small btn-success" href="javascript:reactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-refresh icon-white"></i>  Reactivar</a>
                            <a class="btn btn-small btn-success" href="javascript:desactivarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-remove-circle icon-white"></i>  Inactivar</a>                            
                            <?php
                        }                        
                        ?>
                        <a class="btn btn-danger" href="javascript:deleteCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->razon_social;?>')"><i class="icon-trash icon-white"></i>Borrar</a>
                    </div>                    
<!--                   <a class="btn btn-danger" href="mainpanel/clientes/listado">VOLVER</a>-->

                </fieldset>


        </div>
    </div><!--/span-->

</div><!--/row-->