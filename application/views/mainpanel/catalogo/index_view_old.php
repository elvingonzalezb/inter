<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/catalogo/listado">Lista de Categorias</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevo">Agregar Categoria</a> </li>
        <li><a href="mainpanel/catalogo/listadosubcats">Lista de Sub Categorias</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/catalogo/nuevasubcat">Agregar Sub Categoria</a> </li>
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
            <h2><i class="icon-user"></i> Categorías del Catálogo</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="15%">Imagen</th>
                        <th width="20%">Nombre</th>
                        <th width="10%">Num. Productos</th>
                        <th width="10%">Orden</th>
                        <th width="10%">Tipo</th>
                        <th width="7%">Estado</th>
                        <th width="25%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    $orden = 1;
                    //var_dump($categorias);
                    for($i=0; $i<count($categorias); $i++)
                    {
                        $current = $categorias[$i];
                        $foto = $current['imagen'];
                        $id_categoria = $current['id_categoria'];
                        $numero_productos = $current['numero_productos'];
                        if(is_file('files/categorias/'.$foto))
                        {
                            $pic = '<img src="files/categorias/'.$foto.'" />';
                        }
                        else
                        {
                            $pic = '<img src="assets/frontend/confeccionesrials/imagenes/img300x200.png" />';
                        }
                        $tipo = ($current['tipo']==0)?'Publica':'Privada';
                        echo '<tr>';
                        echo '<td class="center">'.$orden.'</td>';
                        echo '<td>'.$pic.'</td>';
                        echo '<td>'.$current['nombre_categoria'].'</td>';
                        echo '<td class="center">'.$numero_productos.'</td>';
                        echo '<td class="center">'.$current['orden'].'</td>';
                        echo '<td class="center">'.$tipo.'</td>';
                        if($current['estado']=="A")
                        {
                            echo '<td><span class="label label-success">ACTIVO</span></td>';
                        }
                        else
                        {
                            echo '<td><span class="label label-important">INACTIVO</span></td>';
                        }
                        echo '<td>';
                        echo '<a class="btn btn-info" href="mainpanel/catalogo/edit/'.$id_categoria.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteCategoria(\''.$id_categoria.'\', \''.$numero_productos.'\')"><i class="icon-trash icon-white"></i>Borrar</a><br /><br />';
                        echo '<a class="btn btn-small btn-success" href="mainpanel/catalogo/listado_productos/'.$id_categoria.'"><i class="icon-th-list icon-white"></i>  Productos</a> ';						
                        echo '<a class="btn btn-small btn-success" href="mainpanel/catalogo/nuevo_producto/'.$id_categoria.'"><i class="icon-file icon-white"></i>  Nuevo Producto</a><br /><br />';
                        echo '<a class="btn btn-small btn-success" href="mainpanel/catalogo/ordenar_producto/'.$id_categoria.'"><i class="icon-th icon-white"></i>  Ordenar Producto</a><br /><br />';
                        echo '<a class="btn btn-small btn-success" href="mainpanel/catalogo/mantto/'.$id_categoria.'"><i class="icon-th icon-white"></i>  Actualizar</a>';
                        echo '</td>';
                        echo '</tr>';
                        $orden++;
                    }
                ?>
                </tbody>
            </table>            
        </div>
     </div><!--/span-->
</div><!--/row-->