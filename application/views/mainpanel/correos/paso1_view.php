<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/correos/listado">Correos a Clientes</a></li>
        <span class="divider">/</span>
        <li><a href="mainpanel/correos/nuevo">Nuevo Correo</a></li>
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
            <h2><i class="icon-user"></i> NUEVO CORREO A CLIENTES - PASO 1: ELIJA LOS DESTINATARIOS</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form method="post" action="mainpanel/correos/paso2" onsubmit="return valida_paso1()">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="35%">Raz&oacute;n Social</th>
                        <th width="20%">Contacto</th>                        
                        <th width="10%">Código</th>
                        <th width="20%">Email</th>                      
                        <th width="10%">ELEGIR</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    for($i=0; $i<count($clientes); $i++)
                    {
                        $current = $clientes[$i];
                        $id_cliente = $current['id'];                        
                        $razon_social = $current['razon_social'];
                        $codigo = $current['codigo']; 
                        $fecha_registro= Ymd_2_dmY(substr($current['fecha_registro'],0,10));
                        $estado= $current['estado'];                        
                        $nombre= $current['nombre'];
                        $email = $current['email'];
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';                        
                        echo '<td class="center">'.$razon_social.'</td>';
                        echo '<td class="center">'.$nombre.'</td>';
                        echo '<td class="center">'.$codigo.'</td>';
                        echo '<td>'.$email.'</td>';                       
                        echo '<td class="center">';
                        echo ' <input type="checkbox" name="del" value="'.$id_cliente.'" id="'.$id_cliente.'" onclick="concatena('.$id_cliente.')">';                        
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>  
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="100%" align="center" class="center">
                            <input type="text" id="id_eliminar" name="id_eliminar">
                            <input type="submit" class="btn btn-danger" value="CONTINUAR CON EL PASO 2">                            
                        </td>
                    </tr>
                </tbody>
            </table> 
            </form>
        </div>
     </div><!--/span-->
</div><!--/row-->