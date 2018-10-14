<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/banners/listado">Lista de Banners de Usuarios</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/banners/nuevo">Nuevo Banner de Usuario</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/banners/listadoc">Lista de Banners de Clientes</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/banners/nuevoc">Nuevo Banner de Cliente</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Banner de Usuario</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/banners/actualizar" method="post" enctype="multipart/form-data">
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
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Título</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="titulo" name="titulo" value="<?php echo $banner->titulo; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span1 typeahead" id="orden" name="orden" value="<?php echo $banner->orden; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Imagen</label>
                        <div class="controls">
                            <div class="span6"><img src="files/banner/<?php echo $banner->imagen; ?>" /></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="estado" id="estado1" value="A"<?php if($banner->estado=="A") echo ' checked="checked"'; ?>>
                                Activo
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="estado" id="estado2" value="I"<?php if($banner->estado=="I") echo ' checked="checked"'; ?>>
                                Inactivo
                            </label>
                        </div>
                    </div>  
                    <div class="control-group">
                        <div class="controls">
                            <div class="alert alert-block ">
                            <p>La imagen a subir debe tener dimensiones de 720 x 300 pixeles. Caso contrario la imagen se forzará al tamaño indicado.</p>
                            </div> 
                        </div>
                    </div>                    
                    <div class="control-group">
                    <label class="control-label">Nuevo Banner</label>
                        <div class="controls">
                          <input type="file" name="banner" id="banner">
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="id_banner" id="id_banner" value="<?php echo $banner->id_banner; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->