<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/novedades/listado">Lista de Novedades</a> <span class="divider">/</span></li>
        <li><a href="mainpanel/novedades/nuevo">Agregar Novedad</a></li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Agregar Novedad</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/novedades/grabar" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Ingrese los datos de la novedad</legend>
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
                        <label class="control-label" for="typeahead">Fecha</label>
                        <div class="controls">
                            <input type="text" class="span2 datepicker" id="fecha" name="fecha" value="<?php echo fecha_hoy_dmY(); ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="estado" id="estado1" value="A" checked="checked">
                                Activo
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="estado" id="estado2" value="I">
                                Inactivo
                            </label>
                        </div>
                    </div>                    
                    <div class="control-group error">
                    <label class="control-label">Imagen</label>
                        <div class="controls">
                          <input type="file" name="foto" id="foto">
                          <span class="help-inline">La imagen que suba será reducida a 300px de ancho por 200px de alto.</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="textarea2">Sumilla</label>
                        <div class="controls">
                            <textarea id="sumilla" name="sumilla" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="textarea2">Texto</label>
                        <div class="controls">
                            <textarea id="texto" name="texto" rows="3"></textarea>
                            <script type="text/javascript">
                                window.onload = function()
                                {
                                    var oFCKeditor2 = new FCKeditor( 'sumilla' ) ;
                                    oFCKeditor2.BasePath = "<?php echo base_url();?>assets/fckeditor/";
                                    oFCKeditor2.Width  = '700' ;
                                    oFCKeditor2.Height = '200' ;
                                    oFCKeditor2.ToolbarSet = 'Basic' ;
                                    oFCKeditor2.ReplaceTextarea(); 
                                    
                                    var oFCKeditor = new FCKeditor( 'texto' ) ;
                                    oFCKeditor.BasePath = "<?php echo base_url();?>assets/fckeditor/";
                                    oFCKeditor.Width  = '700' ;
                                    oFCKeditor.Height = '350' ;
                                    oFCKeditor.ToolbarSet = 'Custom' ;
                                    oFCKeditor.ReplaceTextarea();
                                }
                            </script>
                        </div>
                    </div>                       
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        &nbsp;&nbsp;
                        <a class="btn btn-danger" href="mainpanel/novedades/listado">VOLVER AL LISTADO</a>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->