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
    <?php
    if (isset($resultado) && ($resultado == "success")) {
        echo '<div class="alert alert-success">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<strong>RESULTADO:</strong> La operación se realizó con éxito';
        echo '</div>';
    }
    ?>    
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Lista de Clientes <a href="mainpanel/clientes/excel/activos" target="_blank">[DESCARGAR EXCEL]</a></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="clientes/ajaxListaClientes/activos">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="15%">DATOS</th>
                        <th width="8%">TIPO</th>                        
                        <th width="8%">PROVINCIA</th>
                        <th width="8%">CODIGO</th>
                        <th width="8%">REGISTRO</th>
                        <th width="7%">ESTADO</th>
                        <th width="7%">VISITAS</th>
                        <th width="7%">ULT. INGRESO</th>                        
                        <th width="7%">NUM VENDEDORES</th> 
                        <th width="20%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>
                </tbody>
            </table>  
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="20%">
                            <a class="btn btn-danger" href="javascript:deleteMultiCli()"><i class="icon-trash icon-white"></i>Borrar Seleccionados</a>
                            <input type="hidden" id="id_eliminar">
                        </td>
                        <td width="15%">
                            <a class="btn btn-small btn-success" href="javascript:anularCliente2()"><i class="icon-th-list icon-white"></i>  Anular Seleccionados</a>
                        </td>
                        <td width="20%">
                            <a class="btn btn-small btn-success" href="javascript:desactivarCliente2()"><i class="icon-th-list icon-white"></i>  Desactivar Seleccionados</a>
                        </td>
                        <td width="45%"></td>
                    </tr>
                </tbody>
            </table>              
        </div>
     </div><!--/span-->
</div><!--/row-->