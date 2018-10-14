<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/boletin/listado">Boletines</a></li>
        <span class="divider">/</span>
        <li><a href="mainpanel/boletin/nuevo">Nuevo Boletin</a></li>
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
            <h2><i class="icon-user"></i> Lista de Boletines de Novedades</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="boletin/ajaxListaBoletines">
                <thead>
                    <tr>
                        <th width="5%">NRO</th>
                        <th width="20%">TITULO</th>
                        <th width="13%">FECHA CREACION</th>
                        <th width="13%">FECHA ENVIO</th>
                        <th width="15%">ESTADO</th>
                        <th width="34%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    //var_dump($categorias);
                    /*for($i=0; $i<count($boletines); $i++)
                    {
                        $current = $boletines[$i];
                        $id_boletin = $current['id'];
                        $titulo = $current['titulo'];
			             $fecha_registro = substr($current['fecha_registro'],0,10);
                        $fecha_envio = substr($current['fecha_envio'],0,10);
                        $estado = $current['estado'];
                                                
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';
			             echo '<td>'.$titulo.'</td>';                        
                        echo '<td class="center">'.$fecha_registro.'</td>';
                        echo '<td>'.$fecha_envio.'</td>';
                        echo '<td class="center">'.$estado.'</td>';
                        echo '<td>';
                        echo '<a class="btn btn-success" href="mainpanel/boletin/probar/'.$id_boletin.'"><i class="icon-edit icon-white"></i> ENVIAR PRUEBA</a> ';
                        echo '<a class="btn btn-success" href="mainpanel/boletin/preview/'.$id_boletin.'"><i class="icon-edit icon-white"></i> PREVIEW</a> ';
                        echo '<a class="btn btn-info" href="mainpanel/boletin/enviar/'.$id_boletin.'"><i class="icon-edit icon-white"></i> ENVIAR</a> ';
                        echo '<br><br>';
                        echo '<a class="btn btn-warning" href="mainpanel/boletin/editar/'.$id_boletin.'"><i class="icon-edit icon-white"></i> EDITAR</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteBoletin(\''.$id_boletin.'\')"><i class="icon-trash icon-white"></i>BORRAR</a> ';                  
			             echo '</td>';
                        echo '</tr>';
                    }*/
                ?>
                </tbody>
            </table>            
        </div>
     </div><!--/span-->
</div><!--/row-->