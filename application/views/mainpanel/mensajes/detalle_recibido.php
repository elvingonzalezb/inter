<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/mensajes/recibidos">Mensajes Recibidos</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/mensajes/mostrados">Mensajes Mostrados</a> </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Detalle de Mensaje</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
                <fieldset>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td width="30%"><h4>Empresa:</h4></td>
                                <td width="70%">
                                    <?php echo $messagee->empresa; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Nombre:</h4></td>
                                <td>
                                    <?php echo $messagee->nombre; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Tel&eacute;fono:</h4></td>
                                <td>
                                    <?php echo $messagee->telefono; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Email:</h4></td>
                                <td>
                                    <?php echo $messagee->email; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Mensaje:</h4></td>
                                <td>
                                    <?php echo $messagee->mensaje; ?>
                                </td>
                            </tr>                            
                            <tr>
                                <td><h4>Fecha de Ingreso:</h4></td>
                                <td>
                                    <?php echo $messagee->fecha_ingreso; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Estatus:</h4></td>
                                <td>
                                    <?php echo $messagee->estatus; ?>
                                </td>
                            </tr>                            
                        </tbody>
                    </table>                                       

<!--                   <a class="btn btn-danger" href="mainpanel/mensajes/listado">VOLVER</a>-->

                </fieldset>


        </div>
    </div><!--/span-->

</div><!--/row-->