
<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/catalogo/fotos/<?php echo $id_producto;?>">Lista de Fotograf&iacute;as</a> </li>  

    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Agregar Nuevo Fotograf&iacute;a para <?php echo $nombre_producto;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/catalogo/grabar_foto" method="post" enctype="multipart/form-data" onsubmit="return valida_producto()">
                <fieldset>
                    <legend>Nueva Fotograf&iacute;a</legend>
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
                                echo '<strong>RESULTADO:</strong> '.str_replace("%20", " ", str_replace("-", " ", $error));
                                echo '</div>';                                
                            }
                        }
                    
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" id="nombre" name="nombre" value="" >
                        </div>
                    </div>
                    <div class="control-group error">
                        <div class="controls">                    
                            <span class="help-inline">La imagen debe tener como m&iacute;nimo 500 pixeles de ancho.</span>
                        </div>
                    </div>
                    <div class="control-group">
	                    <label class="control-label">Subir Foto</label>                    
                        <div class="controls">
                          <input type="file" name="foto" id="foto">
                        </div>
                    </div><!--control-group-->
                    <div class="control-group">
	                    <label class="control-label">Subir Foto Empaque</label>                    
                        <div class="controls">
                          <input type="file" name="foto2" id="foto2">
                        </div>
                    </div><!--control-group-->
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span1 typeahead" id="orden" name="orden">
                        </div>
                    </div>                                                            
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        <input type="hidden" name="id_producto" value="<?php echo $id_producto;?>" />                        
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->