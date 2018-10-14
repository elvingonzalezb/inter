<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/pedidos/listado">Pedidos</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Buscar Cliente</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/pedidos/dolistado" method="post" enctype="multipart/form-data" onsubmit="return valida_busqueda()">
                <fieldset>
                    <legend>Elija el periodo de fechas para ver el listado de pedidos</legend>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Fecha Inicio</label>
                        <div class="controls">
                            <input type="text" autocomplete="OFF" class="input-xlarge datepicker" id="fecha_inicio" name="fecha_inicio" value="" >
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Fecha Fin</label>
                        <div class="controls">
                            <input type="text" autocomplete="OFF" class="input-xlarge datepicker" id="fecha_fin" name="fecha_fin" value="" >
                        </div>
                    </div>              
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="BUSCAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->