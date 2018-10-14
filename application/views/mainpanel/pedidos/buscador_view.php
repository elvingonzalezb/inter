<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/pedidos/listado/1">Pedidos</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/pedidos/buscador">Buscador de Pedidos</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Buscador de Pedidos</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/pedidos/search_pedidos" method="post" onsubmit="return valida_busqueda_pedidos()">
                <fieldset>
                    <legend>Elija las fechas inicial y final</legend>
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
                        <label class="control-label" for="typeahead">Desde</label>
                        <div class="controls">
                            <input type="text" class="datepicker hasDatepicker" size="10" name="fecha_inicio" id="fecha_inicio" value="<?php echo fecha_hoy_dmY2()?>">
                            <img src="assets/frontend/cki/imagenes/calendar.gif" alt="" name="trigger" align="absmiddle" id="trigger" title="Abrir Calendario" /> 
                        </div>
                    </div>                  
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Hasta</label>
                        <div class="controls">
                            <input type="text" class="datepicker hasDatepicker" size="10" name="fecha_fin" id="fecha_fin" value="<?php echo fecha_hoy_dmY2()?>">
                            <img src="assets/frontend/cki/imagenes/calendar.gif" alt="" name="trigger1" align="absmiddle" id="trigger1" title="Abrir Calendario" />                             
                        </div>
                    </div>                  

                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="BUSCAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/pedidos/listado/1">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->