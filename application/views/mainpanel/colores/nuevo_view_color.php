
<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/colores/listado_colores/<?php echo $id;?>">Lista de Colores</a> </li>  

    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Nuevo color para la familia: <?php echo $nombre_categoria;?></h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/colores/grabar_color" method="post" enctype="multipart/form-data" onsubmit="return valida_color()">
                <fieldset>
                    <legend>Nuevo Color</legend>
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
                            <input type="text" name="nombre" id="nombre" class="span5 typeahead">
                        </div>
                    </div>                    

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Color</label>
                        <div class="controls">
                            <input type="text" maxlength="7" name="rgb2" id="rgb2" class="span2 typeahead">
                            <input type="button" value="SELECTOR DE COLORES" class="btn btn-mini btn-primary" onclick="showColorPicker(this,document.forms[0].rgb2)">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden" name="orden">
                        </div>
                    </div>                     
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Estado</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="estado" value="A" checked/>Activo
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="estado" value="0" />Inactivo
                         </label>
                        </div>
                    </div> 

                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                        <input type="hidden" name="id_categoria" value="<?php echo $id;?>" />
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->