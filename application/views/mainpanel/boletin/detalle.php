<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/boletin/listado">Boletines</a></li>
        <span class="divider">/</span>
        <li><a href="mainpanel/boletin/nuevo">Nuevo Boletin</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Preview del Boletin</h2>
            <div class="box-icon">
                <a href="mainpanel/pedidos/listado" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
        <table id="tablaPreviewBoletin" width="700" cellspacing="0" cellpadding="0" style="border:1px solid #000;">
        <tr>
            <td width="5%"></td>
            <td width="90%"></td>
            <td width="5%"></td>
        </tr>
        <?php
            if($boletin->cabecera!="")
            {
                echo '<tr>';
                echo '<td colspan="3"><img src="files/cabeceras_boletin/'.$boletin->cabecera.'"></td>';
                echo '</tr>';
            }
        ?>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
        <tr>
            <td></td>
            <td><h1><?php echo $boletin->titulo; ?></h1></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $boletin->contenido; ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
        <?php
            if($hay_productos==true)
            {
                echo '<tr>';
                echo '<td></td>';
                echo '<td>';
                $num_productos  = count($productos);
                if($num_productos%3==0)
                {
                    $num_filas = $num_productos/3;
                }
                else
                {
                    $num_filas = (int)($num_productos/3) + 1;
                }
                $indice = 0;
                echo '<table width="100%" cellspacing="10" cellpadding="2">';
                for($i=0; $i<$num_filas; $i++)
                {
                    echo '<tr>';
                    for($j=0; $j<3; $j++)
                    {
                        $indice_current = 3*($i) + $j;
                        if($indice_current<$num_productos)
                        {
                            $current = $productos[$indice_current];
                            $foto = $current['imagen'];
                            $id_producto = $current['id_producto'];
                            $nombre= $current['nombre'];						
                            $codigo= $current['codigo'];
                            $pic = '<img src="files/productos_thumbs_m/'.$foto.'" width="200" height="200" style="border:1px solid #000;" />';
                            echo '<td width="200">';
                            echo '<table width="100%" style="display:inline; margin:10px 10px;">';
                            echo '<tr>';												
                                echo '<td align="center" valign="middle">'.$pic.'</td>';
                            echo '</tr>';

                            echo '<tr>';
                                echo '<td height="23" align="center" valign="middle">'.$nombre.'</td>';
                            echo '</tr>';

                            echo '<tr>';
                                echo '<td height="23" align="center" valign="middle">'.$codigo.'</td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</td>';
                        }
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '</td>';
                echo '<td></td>';
                echo '</tr>';
                
                echo '<tr>';
                echo '<td colspan="3" height="10"></td>';
                echo '</tr>';
            }
         ?>
        </table>                                                                     
       </div><!-- tooltip-demo well-->  
       <a class="btn btn-danger" href="mainpanel/boletin/listado">VOLVER</a>
        </div>
    </div><!--/span-->

</div><!--/row-->