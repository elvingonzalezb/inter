<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/novedades/listado">Lista de Novedades</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/novedades/nuevo">Agregar Novedad</a></li>
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
            <h2><i class="icon-user"></i> Novedades</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="20%">Imagen</th>
                        <th width="30%">Título</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Estado</th>
                        <th width="25%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    $orden = 1;
                    foreach($novedades as $novedad)
                    {
                        if(is_file('files/foto_novedades/'.$novedad->foto))
                        {
                            $pic = '<img src="files/foto_novedades/'.$novedad->foto.'" />';
                        }
                        else
                        {
                            $pic = '<img src="assets/frontend/confeccionesrials/imagenes/img300x200.png" />';
                        }
                        echo '<tr>';
                        echo '<td class="center">'.$orden.'</td>';
                        echo '<td>'.$pic.'</td>';
                        echo '<td>'.$novedad->titulo.'</td>';
                        echo '<td>'.Ymd_2_dmY($novedad->fecha).'</td>';
                        if($novedad->estado=="A")
                        {
                            echo '<td><span class="label label-success">ACTIVO</span></td>';
                        }
                        else
                        {
                            echo '<td><span class="label label-important">INACTIVO</span></td>';
                        }
                        echo '<td>';
                        echo '<a class="btn btn-success" href="javascript:showNovedad(\''.$novedad->id_novedad.'\')"><i class="icon-zoom-in icon-white"></i>  Ver</a> ';
                        echo '<a class="btn btn-info" href="mainpanel/novedades/edit/'.$novedad->id_novedad.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteNovedad(\''.$novedad->id_novedad.'\')"><i class="icon-trash icon-white"></i>Borrar</a>';
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