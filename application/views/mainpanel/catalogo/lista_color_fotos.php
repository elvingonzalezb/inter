<div>
	<ul class="breadcrumb">
		<!--        <li><a href="javascript:history.back(-1)/<?php //echo $id_categoria_padre;?>"><< Volver</a>  <span class="divider">/</span> </li>-->
		<li><a href="mainpanel/catalogo/nuevo_color_foto/<?php echo $id_producto;?>">Nuevo color</a> </li>
	</ul>
</div>
<div class="row-fluid sortable">
	<?=$this->session->flashdata('message');?>   
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-user"></i> Colores del producto: <?php echo $nombre_producto;?></h2>
			<div class="box-icon">
				<a href="javascript:history.back(-1)" class="btn btn-round" title="VOLVER"><i class="icon-arrow-left"></i></a>                                
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable" data-url="catalogo/ajaxListaColores/<?= $id_producto ?>">
				<thead>
					<tr>
						<th width="5%">Nro</th>
						<th width="25%">Color</th>
						<th width="20%">Acción</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!--/span-->
</div><!--/row-->
<style type="text/css">
table.datatable tr td:nth-child(2){
	display: flex;
	align-items: center;
}
</style>