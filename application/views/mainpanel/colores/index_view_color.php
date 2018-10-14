<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/colores/listado">Lista de Familia</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/colores/nuevo_color/<?php echo $id_categoria;?>">Nuevo Color</a> </li>  
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
            <h2><i class="icon-user"></i> Color(es) de la Familia: <?php echo $nombre;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="colores/ajaxListaColores/<?php echo $id_categoria;?>">
                <thead>
                    <tr>
                        <th width="5%">Nro</th>
                        <th width="20%">Color</th>
                        <th width="20%">Nombre</th>                        
                        <th width="20%">Orden</th>
                        <th width="10%">Estado</th>
                        <th width="25%">Acción</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                    /*$orden = 1;
                    //var_dump($categorias);
                    for($i=0; $i<count($colores); $i++)
                    {
                        $current = $colores[$i];
                        $id = $current['id'];
                        $color= $current['color'];						
                        $estado= $current['estado'];                        
                        $orden= $current['orden'];
                        $nombre= $current['nombre'];                        
                        echo '<tr>';
                        echo '<td>'.($i+1).'</td>';												
                        echo '<td class="left"><div style="background:'.$color.'; width:50px;height:50px;border:#000 solid 1px;"</div></td>';
                        echo '<td class="center">'.$nombre.'</td>';                        
                        echo '<td class="center">'.$orden.'</td>';
                        echo '<td class="center">'.$estado.'</td>';
                        echo '<td>';
                        //echo '<input type="checkbox" name="del" value="'.$id.'" id="'.$id.'" onclick="concatena('.$id.')">';
                        echo '<a class="btn btn-mini btn-inverse" href="mainpanel/colores/edit_color/'.$id.'"><i class="icon-edit icon-white"></i>  Editar</a> ';
                        echo '<a class="btn btn-mini btn-danger" href="javascript:deleteColor(\''.$id.'\')"><i class="icon-trash icon-white"></i>Borrar</a> ';
                        echo '</td>';
                        echo '</tr>';
                    }*/
                ?>
                </tbody>
            </table>  
<!--            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="20%">
                            <a class="btn btn-danger" href="javascript:deleteMultiProd()"><i class="icon-trash icon-white"></i>Borrar Seleccionados</a>
                            <input type="text" id="id_eliminar">
                        </td>
                        <td width="80%">
                            <select name="id_categoria" id="id_categoria">
                            <option value="0">ELija...</option>
                            <?php
//                            for($i=0; $i<count($categorias); $i++)
//                            {
//                                $current = $categorias[$i];
//                                $id = $current['id'];
//                                $nombre = $current['nombre'];
//                                if($id_categoria==$id){
//                                    echo '<option value="'.$id.'" selected>'.$nombre.'</option>';
//                                }else {
//                                    echo '<option value="'.$id.'">'.$nombre.'</option>';
//                                }
//
//                            }
                            ?>
                            </select>
                            <a class="btn btn-small btn-success" style="margin:0px;" href="javascript:trasladaProd()"><i class="icon-refresh icon-white"></i> Trasladar Colores</a>
                        </td>
                    </tr>
                </tbody>
            </table>  -->
        </div>
     </div><!--/span-->
</div><!--/row-->