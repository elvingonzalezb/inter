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
            <h2><i class="icon-edit"></i> Editar Boletin de Novedades</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/boletin/actualizar" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Actualice los datos del boletin</legend>
                    <?php
                        if( isset($resultado) )
                        {
                            if($resultado=="success")
                            {
                                echo '<div class="alert alert-success">';
                                echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                                echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                                echo '</div>';
                            }
                            if($resultado=="error")
                            {
                                echo '<div class="alert alert-error">';
                                echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                                echo '<strong>RESULTADO:</strong> '.str_replace("%20", " ", $error);
                                echo '</div>';                                
                            }
                        }
                    ?>                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Título</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="titulo" name="titulo" value="<?php echo $boletin->titulo; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Asunto</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="asunto" name="asunto" value="<?php echo $boletin->asunto; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Contenido</label>
                        <div class="controls">
                            <textarea name="contenido" id="contenido" class="span6" rows="6"><?php echo $boletin->contenido; ?></textarea>
                            <script type="text/javascript">
                            CKEDITOR.replace( 'contenido', {
                                    // Define the toolbar groups as it is a more accessible solution.
                                    toolbar: [
                                            ['Source'], ['Bold', 'Italic'], ['PasteText']
                                    ],
                                    width:500, 
                                    height:200,
                                    enterMode : CKEDITOR.ENTER_BR
                            } );
                            </script>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Emails de Prueba</label>
                        <div class="controls">
                            <input type="text" id="emails_prueba" name="emails_prueba" value="<?php echo $boletin->emails_prueba; ?>" > (separados por comas)
                        </div>
                    </div>  
                    <?php
                        if($boletin->cabecera!="")
                        {
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Imagen</label>
                        <div class="controls">
                            <div class="span6"><img src="files/cabeceras_boletin/<?php echo $boletin->cabecera; ?>"></div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="control-group">
                        <div class="controls">
                            <div class="alert alert-block ">
                            <p>La imagen a subir debe tener dimensiones de 700 x 150 pixeles. Caso contrario la imagen se forzará al tamaño indicado.</p>
                            </div> 
                        </div>
                    </div>                       
                    <div class="control-group">
                    <label class="control-label">Cabecera</label>
                        <div class="controls">
                          <input type="file" name="cabecera" id="cabecera">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Productos</label>
                        <div class="controls">
                            <input type="text" id="codigo" name="codigo" value="" placeholder="Ingrese el codigo" >
                            <input type="button" onclick="agregaProductoBoletin()" value="AGREGAR PRODUCTO">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div id="elejidos_colores" >
                                <h3>PRODUCTOS A ENVIARSE EN EL BOLETIN</h3>
                                <div id="contenedor_elegidos" class="clearfix">
                                <table width="80%" cellpadding="0" border="1" cellspacing="0" id="tablaProds">
                                <thead>
                                    <th width="45%">FOTO</th>
                                    <th width="35%">PRODUCTO</th>
                                    <th width="35%">CODIGO</th>
                                    <th width="20%">ACCION</th>
                                </thead>
                                <tbody>
                                <?php
                                    if($hay_productos==true)
                                    {
                                       for($i=0; $i<count($productos); $i++)
                                       {
                                            echo '<tr id="fila_'.$productos[$i]['id_producto'].'">';
                                            echo '<td height="25" align="center" valign="middle"><img src="files/productos_thumbs/'.$productos[$i]['imagen_producto'].'" /></td>';
                                            echo '<td align="center" valign="middle">'.$productos[$i]['nombre_producto'].'</td>';
                                            echo '<td align="center" valign="middle">'.$productos[$i]['codigo_producto'].'</td>';
                                            echo '<td align="center" valign="middle"><a href="javascript:quitarProdBoletin(\''.$productos[$i]['id_producto'].'\')">ELIMINAR</a></td>';
                                            echo '</tr>';
                                       }
                                    }
                                ?>
                                </tbody>
                                </table>
                                </div>
                                <input type="hidden" id="productos_elegidos" name="productos_elegidos" value="<?php echo $productos_elegidos; ?>">
                                <input type="hidden" id="id_boletin" name="id_boletin" value="<?php echo $id_boletin; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->