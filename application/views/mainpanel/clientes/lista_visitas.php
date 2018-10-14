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
   
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Visitas de: <?php echo $razon_social;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable2">
                <thead>
                    <tr>
                        <th width="10%">Nro</th>
                        <th width="50%">Email</th>
                        <th width="40%">Fecha de Ingreso</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                //echo $clientes;
                    for($i=0; $i<count($clientes); $i++)
                    {
                        $current = $clientes[$i];
                        //$id_cliente = $current['id'];                        
                        $email = $current['email'];                        
                        $fecha_ingreso= Ymd_2_dmY($current['fecha_ingreso']);
                        echo '<tr>';
                        echo '<td class="center">'.($i+1).'</td>';                        
                         echo '<td class="center">'.$email.'</td>';
                        echo '<td class="center">'.$fecha_ingreso.'</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>            
        </div>
     </div><!--/span-->
</div><!--/row-->