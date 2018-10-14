<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/correos/listado">Correos a Clientes</a></li>
        <span class="divider">/</span>
        <li><a href="mainpanel/correos/nuevo">Nuevo Correo</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Preview del Correo a Clientes</h2>
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
        </table>                                                                     
       </div><!-- tooltip-demo well--> 
       <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td width="100%"><a class="btn btn-danger" href="mainpanel/correos/listado">VOLVER</a></td>
            </tr>
            </tbody>
        </table>                       
        </div>
    </div><!--/span-->

</div><!--/row-->