<div>
	<ul class="breadcrumb">
		<li><a href="mainpanel/catalogo/listado">Lista de Categorias</a> <span class="divider">/</span></li>
		<li><a href="mainpanel/catalogo/nuevo">Agregar Categoria</a> <span class="divider">/</span></li>
		<li><a href="mainpanel/catalogo/nuevasubcat">Agregar Sub Categoria</a> <span class="divider">/</span></li>
		<li><a href="mainpanel/catalogo/nuevo_producto">Nuevo Producto</a> <span class="divider">/</span></li>
		<li><a href="mainpanel/catalogo/listaProximos">Proximos Ingresos</a> </li>
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
			<form class="form-horizontal" action="mainpanel/catalogo/edit_color_foto/<?=$id_color?>" method="post" enctype="multipart/form-data" onsubmit="return valida_color_foto()">
				<fieldset>
					<legend>Editar Color</legend>
					<?=$this->session->flashdata('message');?>
					<div class="control-group">
						<label class="control-label" for="typeahead">Color</label>
						<div class="controls">
							<select onChange="muestra_color_nuevo(this.value)" name="cat_color" id="cat_color">
								<option value='0'>:: Elija ::</option>
								<?php
									foreach ($familias as $value) {
									    $nombre=$value->nombre;
									    $id_familia=$value->id;
									    $selected = ($data['id_cat']==$id_familia)? 'selected': '';
									    echo '<option value="'.$id_familia.'" '.$selected.'>'.$nombre.'</option>';
									}
									?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div id="cont_colores" class="clearfix" style="display: block">
								<?php foreach ($colores as $key => $value): ?>
								<?php $checked = ($data['id_color']==$value['id'])? 'checked': ''; ?>
								<div class="div_color">
									<div class="tit_col"><?= $value['nombre'] ?></div>
									<div class="caja_color" style="background:<?=$value['color']?>" title="<?=$value['color']?>"></div>
									<div class="btnradio"><input type="radio" name="id_color" <?=$checked?> value="<?=$value['id']?>"></div>
								</div>	
								<?php endforeach ?>
								
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Stock Actual:</label>
						<div class="controls">
							<input type="text" name="stock" id="stock" value="<?=$data['stock']?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Stock Proximamente:</label>
						<div class="controls">
							<input type="text" name="stock_proximamente" id="stock_proximamente" value="<?=$data['stock_proximamente']?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Stock llegada:</label>
						<div class="controls">
							<input type="text" autocomplete="off" class="input-xlarge datepicker span3" name="fecha_llegada" id="fecha_llegada" value="<?= (($data['fecha_llegada']=='0000-00-00')? '0000-00-00':date("d-m-Y", strtotime($data['fecha_llegada']))) ?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Precio:</label>
						<div class="controls">
							<input type="text" name="precio_proximamente" id="precio_proximamente" value="<?=$data['precio_proximamente']?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Orden:</label>
						<div class="controls">
							<input type="text" name="orden_proximamente" id="orden_proximamente" value="<?=$data['orden_proximamente']?>">
						</div>
					</div>
					<div class="control-group error">
						<div class="controls">
							<span class="help-inline">La imagen debe tener como m&iacute;nimo 600 pixeles de ancho.</span>
						</div>
					</div>
					<div class="control-group">
                        <label class="control-label" for="typeahead">Imagen 1</label>
                        <div class="controls">
                            <div class="span6">
                                <?php showImagenColor($data['imagen1'])?>
                            </div>
                        </div>
                    </div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>
						<div class="controls">
							<input type="file" name="imagen1" id="imagen1" required>
							<input type="hidden" name="img1" id="img1" value="<?=$data['imagen1']?>">
						</div>
					</div>
					<div class="control-group">
                        <label class="control-label" for="typeahead">Imagen 2</label>
                        <div class="controls">
                            <div class="span6">
                                <?php showImagenColor($data['imagen2'])?>
                            </div>
                        </div>
                    </div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>
						<div class="controls">
							<input type="file" name="imagen2" id="imagen2">
							<input type="hidden" name="img2" id="img2" value="<?=$data['imagen2']?>">
						</div>
					</div>
					<div class="control-group">
                        <label class="control-label" for="typeahead">Imagen 3</label>
                        <div class="controls">
                            <div class="span6">
                                <?php showImagenColor($data['imagen3'])?>
                            </div>
                        </div>
                    </div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>
						<div class="controls">
							<input type="file" name="imagen3" id="imagen3">
							<input type="hidden" name="img3" id="img3" value="<?=$data['imagen3']?>">
						</div>
					</div>
					<div class="control-group">
                        <label class="control-label" for="typeahead">Imagen 4</label>
                        <div class="controls">
                            <div class="span6">
                                <?php showImagenColor($data['imagen4'])?>
                            </div>
                        </div>
                    </div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>
						<div class="controls">
							<input type="file" name="imagen4" id="imagen4">
							<input type="hidden" name="img4" id="img4" value="<?=$data['imagen4']?>">
						</div>
					</div>
					
					<div class="form-actions"> 
						<input type="submit" class="btn btn-primary" value="GRABAR">                       
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	<!--/span-->
</div>
<!--/row-->
<?php 
function showImagenColor($imagen) {
	if(is_file('files/thumbnails_fotografias/'.$imagen)){
		$img = getimagesize('files/thumbnails_fotografias/'.$imagen);
		$ancho = (int)($img[0]/1);
		$alto = (int)($img[1]/1);
		$pic = '<img src="files/thumbnails_fotografias/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'" border="0"/>';
	} else {
		$img = getimagesize('assets/frontend/cki/imagenes/noimg125x125.png');
		$ancho = (int)($img[0]/1);
		$alto = (int)($img[1]/1);
		$pic = '<img src="assets/frontend/cki/imagenes/noimg125x125.png" width="'.$ancho.'" height="'.$alto.'" border="0"/>';
	} 
	echo $pic;
}
 ?>