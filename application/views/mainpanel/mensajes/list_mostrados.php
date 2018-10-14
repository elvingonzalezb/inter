<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/mensajes/recibidos">Mensajes Recibidos</a>  <span class="divider">/</span></li>
        <li><a href="mainpanel/mensajes/mostrados">Mensajes Mostrados</a> </li>
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
            <h2><i class="icon-user"></i> Mensajes Mostrados</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="mensajes/ajaxListaMostrados">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="25%">T&iacute;tulo</th>
                        <th width="50%">Descripci&oacute;n</th>
                        <th width="20%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    /*for($i=0; $i<count($mensajes); $i++)
                    {
                        $current = $mensajes[$i];
                        $id_mensaje = $current['id_mensaje'];                        
                        $titulo = $current['titulo'];
                        $explicacion= $current['explicacion'];
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';                        
                         echo '<td class="center">'.$titulo.'</td>';
                        echo '<td class="center">'.$explicacion.'</td>';                        
                        echo '<td class="center">';
                        echo '<a class="btn btn-small btn-success" href="mainpanel/mensajes/detalle_mostrado/'.$id_mensaje.'"><i class="icon-file icon-white"></i>  Ver Datos</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteMsgMostrado(\''.$id_mensaje.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
                        echo '</td>';
                        echo '</tr>';
                    }*/
                ?>
                </tbody>
            </table>            
        </div>
     </div><!--/span-->
</div><!--/row-->