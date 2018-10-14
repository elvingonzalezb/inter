<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/catalogo/fotos/<?php echo $fotos->id_prod;?>">Volver lista de Fotos</a> </li>  
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Fotograf&iacute;a</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/actualizar_foto" method="post" enctype="multipart/form-data" onsubmit="return valida_producto()">
                <fieldset>
                    <legend>Modifique los datos deseados</legend>
                    <?php
                        if(isset($resultado) && ($resultado=="success"))
                        {
                            echo '<div class="alert alert-success">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Los datos se actualizaron correctamente';
                            echo '</div>';
                        }
                        if(isset($resultado) && ($resultado=="error"))
                        {
                            echo '<div class="alert alert-error">';
                            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                            echo '<strong>RESULTADO:</strong> Ocurrio un error al actualizar los datos';
                            echo '</div>';
                        }                        
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            
                            <input type="text" class="span8 typeahead" id="nombre" name="nombre" value="<?php echo $fotos->nombre; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Fotograf&iacute;a Principal</label>
                        <div class="controls">
                            <div class="span6">
                            <?php
                            if( (isset($fotos->foto)) && (is_file('files/thumbnails_fotografias/'.$fotos->foto)) )
                            {
                                    $img = getimagesize('files/thumbnails_fotografias/'.$fotos->foto);
                                    $ancho = (int)($img[0]/1);
                                    $alto = (int)($img[1]/1);
                                    echo '<img src="files/thumbnails_fotografias/'.$fotos->foto.'" width="'.$ancho.'" height="'.$alto.'" border="0"/>';
                            }
                            else
                            {
                                    $img = getimagesize('assets/frontend/cki/imagenes/noimg50x50.png');
                                    $ancho = (int)($img[0]/1);
                                    $alto = (int)($img[1]/1);							
                                    echo '<img src="assets/frontend/cki/imagenes/noimg50x50.png" width="'.$ancho.'" height="'.$alto.'" border="0"/>';								
                            }                                
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group error">
                        <div class="controls">                    
                            <span class="help-inline">La imagen debe tener como m&iacute;nimo 600 pixeles de ancho.</span>
                        </div>
                    </div>
                    <div class="control-group">
	                    <label class="control-label">Cambiar Foto Principal</label>
                        <div class="controls">
                          <input type="file" name="foto">
                        </div>
                    </div><!--control-group-->
                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Fotograf&iacute;a Empaque</label>
                        <div class="controls">
                            <div class="span6">
                            <?php
                            if( (isset($fotos->foto_empaque)) && (is_file('files/thumbnails_fotografias/'.$fotos->foto_empaque)) )
                            {
                                    $img = getimagesize('files/thumbnails_fotografias/'.$fotos->foto_empaque);
                                    $ancho = (int)($img[0]/1);
                                    $alto = (int)($img[1]/1);
                                    echo '<img src="files/thumbnails_fotografias/'.$fotos->foto_empaque.'" width="'.$ancho.'" height="'.$alto.'" border="0"/>';
                            }
                            else
                            {
                                    $img = getimagesize('assets/frontend/cki/imagenes/noimg50x50.png');
                                    $ancho = (int)($img[0]/1);
                                    $alto = (int)($img[1]/1);							
                                    echo '<img src="assets/frontend/cki/imagenes/noimg50x50.png" width="'.$ancho.'" height="'.$alto.'" border="0"/>';								
                            }                                
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group error">
                        <div class="controls">                    
                            <span class="help-inline">La imagen debe tener como m&iacute;nimo 600 pixeles de ancho.</span>
                        </div>
                    </div>
                    <div class="control-group">
	                    <label class="control-label">Cambiar Foto Empaque</label>
                        <div class="controls">
                          <input type="file" name="foto2">
                        </div>
                    </div><!--control-group-->
                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span1 typeahead" id="orden" name="orden" value="<?php echo $fotos->orden; ?>">
                        </div>
                    </div>                     
                    <div class="form-actions">
                        <input type="hidden" name="id_fp" id="id_fp" value="<?php echo $fotos->id_fp; ?>">                        
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->