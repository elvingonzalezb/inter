<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/reservas/listadoActivas/1">Reservas Activa</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/reservas/listadoAnuladas/1">Reservas Anuladas</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <?php
    if (isset($resultado) && ($resultado == "success")) {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La operación se realizó con éxito';
        echo '</div>';
    }
    else if (isset($resultado) && ($resultado == "extension-success"))
    {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La reserva se extendio correctamente';
        echo '</div>';        
    }
    else if (isset($resultado) && ($resultado == "cargos-guardados"))
    {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> Los cargos adicionales se guardaron correctamente.';
        echo '</div>';        
    }
    ?>    
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Lista de Reservas Activas</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="reservas/ajaxListaReservasActivas">
                <thead>
                    <tr>
                        <th width="5%">NRO</th>
                        <th width="8%">COD. RESERVA</th>
                        <th width="15%">CLIENTE</th>
                        <th width="10%">CODS PRODS</th>
                        <th width="8%">MONTO</th>
                        <th width="8%">ESTADO</th>
                        <th width="18%">VIGENCIA</th>
                        <th width="7%">LLEVA CARGOS</th>
                        <th width="7%">TIENE CARGOS</th>
                        <th width="17%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>

                </tbody>
            </table>
        </div>
     </div><!--/span-->
</div><!--/row-->