<div>
    <ul class="breadcrumb">
<!--        <li><a href="javascript:history.back(-1)/<?php //echo $id_categoria_padre;?>"><< Volver</a>  <span class="divider">/</span> </li>-->
        <li><a href="mainpanel/catalogo/nueva_foto/<?php echo $id_producto;?>">Nueva Foto</a> </li>  
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
            <h2><i class="icon-user"></i> Fotograf&iacute;as del producto: <?php echo $nombre_producto;?></h2>
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
                        <th width="20%">Foto</th>
                        <th width="25%">Nombre</th>
                        <th width="10%">Orden</th>                        
                        <th width="20%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    $orden = 1;
                    for($i=0; $i<count($fotos); $i++)
                    {
                        $current = $fotos[$i];
                        $id_fp = $current['id_fp'];                        
                        $foto = $current['foto'];
                        $foto_empaque = $current['foto_empaque'];
                        $nombre= $current['nombre'];						
                        $orden= $current['orden'];
                        $pic = 'Foto principal: &nbsp;&nbsp;';
                        if(is_file('files/thumbnails_fotografias/'.$foto))
                        {
                            $img = getimagesize('files/thumbnails_fotografias/'.$foto);
                            $ancho = (int)($img[0]/1);
                            $alto = (int)($img[1]/1);                            
                            $pic .= '<img src="files/thumbnails_fotografias/'.$foto.'" width="'.$ancho.'" height="'.$alto.'" />';
                        }
                        else
                        {
                            $img = getimagesize('assets/frontend/cki/imagenes/noimg50x50.png');
                            $ancho = (int)($img[0]/1);
                            $alto = (int)($img[1]/1);                              
                            $pic .= '<img src="assets/frontend/cki/imagenes/noimg50x50.png" width="'.$ancho.'" height="'.$alto.'" />';
                        }
                        $pic .= '<br>Foto Empaque: &nbsp;';
                        if(is_file('files/thumbnails_fotografias/'.$foto_empaque))
                        {
                            $img = getimagesize('files/thumbnails_fotografias/'.$foto_empaque);
                            $ancho = (int)($img[0]/1);
                            $alto = (int)($img[1]/1);                            
                            $pic .= '<img src="files/thumbnails_fotografias/'.$foto_empaque.'" width="'.$ancho.'" height="'.$alto.'" />';
                        }
                        else
                        {
                            $img = getimagesize('assets/frontend/cki/imagenes/noimg50x50.png');
                            $ancho = (int)($img[0]/1);
                            $alto = (int)($img[1]/1);                              
                            $pic .= '<img src="assets/frontend/cki/imagenes/noimg50x50.png" width="'.$ancho.'" height="'.$alto.'" />';
                        }
                        echo '<tr>';
                        echo '<td>'.($i+1).'</td>';												
                        echo '<td>'.$pic.'</td>';						
                        echo '<td class="left">'.$nombre.'</td>';						
                        echo '<td class="center">'.$orden.'</td>';   
                        echo '<td>';
                        echo '<a class="btn btn-mini btn-inverse" href="mainpanel/catalogo/editar_foto/'.$id_fp.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-mini btn-danger" href="javascript:deleteFoto(\''.$id_fp.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
                  

                </tbody>
            </table>  
            </div>              
        </div>
     </div><!--/span-->
</div><!--/row-->