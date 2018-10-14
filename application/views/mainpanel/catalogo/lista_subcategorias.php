<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/catalogo/listado">Lista de Categorias</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevo">Agregar Categoria</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevasubcat">Agregar Sub Categoria</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevo_producto">Nuevo Producto</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/listaProximos">Proximos Ingresos</a> </li>
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
            <h2><i class="icon-user"></i> Sub Categorías de: <?php echo $nombre_categoria; ?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="catalogo/ajaxListaSubcat/<?=$idCategoria?>">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="30%">Nombre</th>
                        <th width="15%">Num. Productos</th>
                        <th width="10%">Orden</th>
                        <th width="10%">Estado</th>
                        <th width="30%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                </tbody>
            </table>            
        </div>
     </div><!--/span-->
</div><!--/row-->