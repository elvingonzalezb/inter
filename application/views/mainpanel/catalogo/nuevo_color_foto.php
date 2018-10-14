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
			<h2><i class="icon-edit"></i> Agregar Nuevo Color</h2>
			<div class="box-icon">
				<a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form class="form-horizontal" action="mainpanel/catalogo/nuevo_color_foto/<?= $id_producto ?>" method="post" enctype="multipart/form-data" onsubmit="return valida_color_foto()">
				<fieldset>
					<legend>Nuevo Color</legend>
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
									    echo '<option value="'.$id_familia.'">'.$nombre.'</option>';
									}
									?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div id="cont_colores" class="clearfix"></div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Stock Actual:</label>
						<div class="controls">
							<input type="text" name="stock" id="stock">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Stock Proximamente:</label>
						<div class="controls">
							<input type="text" name="stock_proximamente" id="stock_proximamente">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Stock llegada:</label>
						<div class="controls">
							<input type="text" autocomplete="off" class="input-xlarge datepicker span3" name="fecha_llegada" id="fecha_llegada">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Precio:</label>
						<div class="controls">
							<input type="text" name="precio_proximamente" id="precio_proximamente">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="typeahead">Orden:</label>
						<div class="controls">
							<input type="text" name="orden_proximamente" id="orden_proximamente">
						</div>
					</div>
					<div class="control-group error">
						<div class="controls">                    
							<span class="help-inline">La imagen debe tener como m&iacute;nimo 600 pixeles de ancho.</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>                    
						<div class="controls">
							<input type="file" name="imagen1" id="imagen1" required>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>                    
						<div class="controls">
							<input type="file" name="imagen2" id="imagen2">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>                    
						<div class="controls">
							<input type="file" name="imagen3" id="imagen3">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Subir Foto</label>                    
						<div class="controls">
							<input type="file" name="imagen4" id="imagen4">
						</div>
					</div>
					
					<div class="form-actions">
						<input type="hidden" name="id_producto" id="id_producto" value="<?= $id_producto ?>" />  
						<input type="submit" class="btn btn-primary" value="GRABAR">                       
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	<!--/span-->
</div>
<!--/row-->