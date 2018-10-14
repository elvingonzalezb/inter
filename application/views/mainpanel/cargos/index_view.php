<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/cargos/listado">Listado de Cargos</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/cargos/nuevo">Nuevo Cargo Adicional</a> </li>        
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
            <h2><i class="icon-user"></i> Lista de Cargos Adicionales</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th width="10%">Nro</th>
                        <th width="50%">CONCEPTO</th>
                        <th width="10%">MONTO</th>
                        <th width="10%">ESTADO</th>                        
                        <th width="20%">ACCION</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    for($i=0; $i<count($cargos); $i++)
                    {
                        $current = $cargos[$i];
                        $id = $current['id'];                        
                        $concepto = $current['concepto'];
                        $monto = $current['monto'];
                        $estado = $current['estado'];
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';                        
                        echo '<td class="center">'.$concepto.'</td>';
                        echo '<td class="center">S/ '.$monto.'</td>';
                        echo '<td class="center">'.$estado.'</td>';                        
                        echo '<td class="center">';
                        echo '<a class="btn btn-info" href="mainpanel/cargos/edit/'.$id.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteCargo(\''.$id.'\', \''.$concepto.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>  

        </div>
     </div><!--/span-->
</div><!--/row-->