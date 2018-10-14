<div id="wrap-content">
  <div id="breadcrumb">
<!--    <a href="#" class="breadcrumbHome">Homepage</a><span class="seperator"> &nbsp; </span><a href="#">Computers</a><span class="seperator"> &nbsp; </span><a href="#">Laptops</a><span class="seperator"> &nbsp; </span><span>Dell</span>-->
  </div>
  <div id="main-content">
    <div id="left-column">
      <?php echo $izquierda;?>
    </div> 
    <div id="right-column">
      <div id="content">
        <div class="wrap-featured-products">
            <div class="wrap-title-black">
              <h1 class="nice-title">Inventario</h1>
            </div>
            <div class="contenido">
              	<?php
				if($this->session->userdata('ver_inventario')){
					if($this->session->userdata('ver_inventario')=='si'){
						?>
                        <div class="sub_contenido">
                            <h3>Descargar Inventario</h3>
                            Desde aqui usted podra realizar la descarga de nuestro Inventario.
                            <a href='exportar/excel' title='Descargar Inventario'><img style='margin-left:20px;' src='assets/frontend/cki/imagenes/download.png' align='absmiddle'border='0'/></a>
                        </div><!--sub_contenido-->
                        <?php
					}else{
						echo 'Usted no tiene Acceso a la descarga del Inventario, comuniquese con nuestro administrador, click <a href="'.base_url().'contactenos">Aqui</a>';
					}
				}
				?>
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>