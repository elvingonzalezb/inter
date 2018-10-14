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
            <h2><i class="icon-edit"></i> NUEVO CORREO A CLIENTES - PASO 2: LLENE EL CONTENIDO DEL CORREO</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/correos/grabar" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Ingrese los datos del nuevo correo</legend>
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
                            <input type="text" class="span6 typeahead" id="titulo" name="titulo" value="" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Asunto</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="asunto" name="asunto" value="" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Contenido</label>
                        <div class="controls">
                            <textarea name="contenido" id="contenido" class="span6" rows="6"></textarea>
                            <script type="text/javascript">
                            CKEDITOR.replace( 'contenido', {
                                    // Define the toolbar groups as it is a more accessible solution.
                                    toolbar: [
                                            ['Source'], ['Bold', 'Italic'], ['PasteText'],['Image']
                                    ],
                                    width:700, 
                                    height:400,
                                    enterMode : CKEDITOR.ENTER_BR
                            } );
                            </script>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Emails de Prueba</label>
                        <div class="controls">
                            <input type="text" id="emails_prueba" name="emails_prueba" value="" > (separados por comas)
                        </div>
                    </div>    
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
                    <div class="form-actions">
                        <input type="text" name="destinatarios" id="destinatarios" value="<?php echo $destinatarios; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->