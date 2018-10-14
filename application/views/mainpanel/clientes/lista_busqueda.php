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
            <h2><i class="icon-user"></i> Resultado de B&uacute;squeda</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable2">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="15%">DATOS</th>
                        <th width="9%">TIPO</th>                        
                        <th width="9%">CODIGO</th>
                        <th width="9%">REGISTRO</th>
                        <th width="9%">ESTADO</th>
                        <th width="7%">VISITAS</th>
                        <th width="10%">ULT. INGRESO</th>                        
                        <th width="7%">NUM VENDEDORES</th> 
                        <th width="20%">ACCION</th>
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
                        $fecha_registro= substr($current['fecha_registro'],0,10);
                        $visitas = $current['visitas'];
                        $estado= $current['estado']; 
                        $nombre= $current['nombre'];
                        $ultima_visita = $current['ultima_visita'];
                        $datosCliente = '<strong>'.$razon_social.'</strong><br>Persona contacto:<br>'.$nombre;
                        $tipo = ($current['nivel']=="administrador")?'ADMINISTRADOR':'VENDEDOR';
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';                        
                        echo '<td class="center">'.$datosCliente.'</td>';
                        echo '<td class="center">'.$tipo.'</td>';
                        echo '<td class="center">'.$codigo.'</td>';
                        echo '<td>'.$fecha_registro.'</td>';
                        echo '<td class="center">'.$estado.'</td>';                        
                        echo '<td>'.$visitas.'</td>';
                        echo '<td>'.$ultima_visita.'</td>';
                        echo '<td>'.$current['num_vendedores'].'</td>';
                        echo '<td class="center">';
                        echo '<a class="btn btn-small btn-success" href="mainpanel/clientes/detalle/'.$id_cliente.'"><i class="icon-file icon-white"></i>  Ver Datos</a> ';
                        echo '<a class="btn btn-info" href="mainpanel/clientes/edit/'.$id_cliente.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteCliente(\''.$id_cliente.'\', \''.$razon_social.'\', \''.$estado.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
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
                        <td width="20%">
                            <a class="btn btn-danger" href="javascript:deleteMultiCli()"><i class="icon-trash icon-white"></i>Borrar Seleccionados</a>
                            <input type="hidden" id="id_eliminar">
                        </td>
                        <td width="80%">
                        </td>
                    </tr>
                </tbody>
            </table>              
        </div>
     </div><!--/span-->
</div><!--/row-->