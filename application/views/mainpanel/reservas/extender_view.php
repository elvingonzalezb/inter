<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Extender Reserva</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/reservas/doExtension" method="post" onsubmit="return valida_extension()">
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
                        <label class="control-label" for="typeahead">Caducidad Actual</label>
                        <div class="controls">
                        <?php
                            $aux = explode(" ", $orden->caducidad);
                            $f = Ymd_2_dmY($aux[0]);
                            $h = $aux[1];
                            echo $f.' '.$h;
                        ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Dias Adicionales</label>
                        <div class="controls">
                            <select id="dias_adicionales" name="dias_adicionales" >
                            <?php
                                for($i=0; $i<=30; $i++)
                                {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Horas Adicionales</label>
                        <div class="controls">
                        <select id="horas_adicionales" name="horas_adicionales" >
                            <?php
                                for($i=1; $i<=23; $i++)
                                {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Mensaje al Cliente</label>
                        <div class="controls">
                            <textarea class="span8" rows="6" name="mensaje" id="mensaje"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="id" id="id" value="<?php echo $orden->id_orden; ?>">
                        <input type="submit" class="btn btn-primary" value="EXTENDER">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/reservas/listadoActivas/1">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->