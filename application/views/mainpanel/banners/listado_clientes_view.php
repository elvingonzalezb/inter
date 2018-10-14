<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/banners/listado">Lista de Banners de Usuarios</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/banners/nuevo">Nuevo Banner de Usuario</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/banners/listadoc">Lista de Banners de Clientes</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/banners/nuevoc">Nuevo Banner de Cliente</a></li>
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
            <h2><i class="icon-user"></i> Banners de Clientes</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="banners/ajaxListaBannersClientes">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="25%">Imagen</th>
                        <th width="25%">Título</th>
                        <th width="10%">Orden</th>
                        <th width="10%">Estado</th>
                        <th width="25%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    /*$orden = 1;
                    foreach($banners as $banner)
                    {
                        $pic = '<img src="files/banner_clientes/'.$banner->imagen.'" />';
                        echo '<tr>';
                        echo '<td class="center">'.$orden.'</td>';
                        echo '<td class="miniatura">'.$pic.'</td>';
                        echo '<td>'.$banner->titulo.'</td>';
                        echo '<td>'.$banner->orden.'</td>';
                        if($banner->estado=="A")
                        {
                            echo '<td><span class="label label-success">ACTIVO</span></td>';
                        }
                        else
                        {
                            echo '<td><span class="label label-important">INACTIVO</span></td>';
                        }
                        echo '<td>';
                        echo '<a class="btn btn-success" href="javascript:showBannerCliente(\''.$banner->imagen.'\', \''.$banner->titulo.'\')"><i class="icon-zoom-in icon-white"></i>  Ver</a> ';
                        echo '<a class="btn btn-info" href="mainpanel/banners/editc/'.$banner->id_banner.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-danger" href="javascript:deleteBannerCliente(\''.$banner->id_banner.'\')"><i class="icon-trash icon-white"></i>Borrar</a>';
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