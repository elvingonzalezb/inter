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
            <h2><i class="icon-user"></i> CLIENTES BORRADOS <a href="mainpanel/clientes/excel/borrados" target="_blank">[DESCARGAR EXCEL]</a></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="clientes/ajaxListaClientes/borrados">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="15%">Raz&oacute;n Social</th>
                        <th width="9%">Tipo</th>                        
                        <th width="9%">Código</th>
                        <th width="9%">Registro</th>
                        <th width="9%">Estado</th>
                        <th width="7%">Visitas</th>
                        <th width="9%">Fecha Borrado</th>     
                        <th width="9%">Num Vendedores</th> 
                        <th width="20%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                </tbody>
            </table>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="30%"></td>
                        <td width="40%">
                            <a class="btn btn-danger" href="javascript:deleteMultiCliBorrados()"><i class="icon-trash icon-white"></i>Eliminar Definitivamente los Seleccionados</a>
                            <input type="hidden" id="id_eliminar">
                        </td>
                        <td width="30%"></td>
                    </tr>
                </tbody>
            </table>             
        </div>
     </div><!--/span-->
</div><!--/row-->