<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/colores/listado">Lista de Familia <span class="divider">/</span></li>
        <li><a href="mainpanel/colores/nuevo">Agregar Familia</a> </li>  
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
            <h2><i class="icon-user"></i> Familia de Colores</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="colores/ajaxListaCatColores">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="30%">Nombre</th>
                        <th width="15%">Nro. de Colores</th>                        
                        <th width="15%">Estado</th>
                        <th width="15%">Orden</th>                        
                        <th width="20%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    /*$orden = 1;
                    for($i=0; $i<count($categorias); $i++)
                    {
                        $current = $categorias[$i];
                        $id_categoria = $current['id'];
                        $nombre = $current['nombre'];                        
                        $numero_colores = $current['numero_colores'];

                        echo '<tr>';
                        echo '<td>'.($i+1).'</td>';
                        echo '<td>'.$nombre.'</td>';
                        echo '<td>'.$numero_colores.'</td>';
                        if($current['estado']=="A")
                        {
                            echo '<td><span class="label label-success">ACTIVO</span></td>';
                        }
                        else
                        {
                            echo '<td><span class="label label-important">INACTIVO</span></td>';
                        }
                        echo '<td class="center">'.$orden.'</td>';                        
                        echo '<td>';
                        echo '<a class="btn btn-info" href="mainpanel/colores/edit/'.$id_categoria.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteCategoriaColor(\''.$id_categoria.'\', \''.$numero_colores.'\')"><i class="icon-trash icon-white"></i>Borrar</a><br /><br />';
                        echo '<a class="btn btn-small btn-success" href="mainpanel/colores/listado_colores/'.$id_categoria.'"><i class="icon-th-list icon-white"></i>  Colores</a> ';						
                        echo '<a class="btn btn-small btn-success" href="mainpanel/colores/nuevo_color/'.$id_categoria.'"><i class="icon-file icon-white"></i>  Nuevo Color</a><br /><br />';
                        echo '</td>';
                        echo '</tr>';
                        $orden++;
                    }*/
                ?>
                </tbody>
            </table>            
        </div>
     </div><!--/span-->
</div><!--/row-->