<div>
    <ul class="breadcrumb">
        <li><a href="mainpanel/colores/listado_colores/<?php echo $color->id_categoria?>">Listar Colores</a> </li>  
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Editar Color</h2>
            <div class="box-icon">
                <a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="mainpanel/colores/actualizar_color" method="post" enctype="multipart/form-data" onsubmit="return valida_color()">
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
                        <label class="control-label" for="typeahead">Familia de Colores</label>
                        <div class="controls">
                            <select name="id_categoria" id="id_categoria">
                                <option value="0">ELija...</option>
                                <?php
                                for($i=0; $i<count($categorias); $i++)
                                {
                                    $current = $categorias[$i];
                                    $id = $current['id'];
                                    $nombre = $current['nombre'];
                                    if($color->id_categoria==$id){
                                        echo '<option value="'.$id.'" selected>'.$nombre.'</option>';
                                    }else {
                                        echo '<option value="'.$id.'">'.$nombre.'</option>';
                                    }

                                }
                                ?>
                            </select>
                        </div>
                    </div>                   
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span8 typeahead" id="nombre" name="nombre" value="<?php echo $color->nombre; ?>" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Orden</label>
                        <div class="controls">
                            <input type="text" class="span2 typeahead" id="orden" name="orden" value="<?php echo $color->orden;?>" >
                        </div>
                    </div>                                                            


                    <div class="control-group">
                        <label class="control-label" for="typeahead">Color Actual</label>
                        <div class="controls">
                            <div style="background:<?php echo $color->color;?>; width:70px; height:70px;"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Modificar el Color</label>
                        <div class="controls">
                            <input type="text" maxlength="7" name="rgb2" id="rgb2" class="span2 typeahead" value="<?php echo $color->color;?>">
                            <input type="button" value="SELECTOR DE COLORES" class="btn btn-mini btn-primary" onclick="showColorPicker(this,document.forms[0].rgb2)">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Estado</label>
                        <div class="controls">
                        <label class="radio">
                            <input type="radio" name="estado" value="A" <?php if($color->estado=='A'){echo 'checked';};?> />Activo
                         </label>
                         <div style="clear:both"></div>
                         <label class="radio">
                            <input type="radio" name="estado" value="I" <?php if($color->estado=='I'){echo 'checked';};?> />Inactivo
                         </label>
                        </div>
                    </div> 
                    <div class="form-actions">
                        <input type="hidden" name="id_color" id="id_color" value="<?php echo $color->id; ?>">
                        <input type="submit" class="btn btn-primary" value="GRABAR">
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div><!--/row-->