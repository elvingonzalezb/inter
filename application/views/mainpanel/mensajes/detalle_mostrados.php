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
                                <td width="30%"><h4>T&iacute;tulo:</h4></td>
                                <td width="70%">
                                    <?php echo $messagee->titulo; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Mensaje:</h4></td>
                                <td>
                                    <?php echo $messagee->mensaje; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Descripci&oacute;n:</h4></td>
                                <td>
                                    <?php echo $messagee->explicacion; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Llave:</h4></td>
                                <td>
                                    <?php echo $messagee->llave; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>                                       

<!--                   <a class="btn btn-danger" href="mainpanel/mensajes/listado">VOLVER</a>-->

                </fieldset>


        </div>
    </div><!--/span-->

</div><!--/row-->