<div id="wrap-content">
  <div id="breadcrumb">
    <a href="#" class="breadcrumbHome">Homepage</a><span class="seperator"> &nbsp; </span><a href="#">Computers</a><span class="seperator"> &nbsp; </span><a href="#">Laptops</a><span class="seperator"> &nbsp; </span><span>Dell</span>
  </div>
  <div id="main-content">
    <div id="left-column">
      <?php echo $izquierda;?>
    </div>

    <div id="right-column">

      <div id="content">
        <div class="wrap-featured-products">
            <div class="wrap-title-black">
              <h1 class="nice-title"><?php echo $producto->nombre;?></h1>
            </div>
            <div class="contenido">
                <div class="sub_contenido">
                    <?php echo $novedades->texto; ?>
                </div><!--texto-->

                <div class="prodt-photo"><a href="#"><img src="files/productos_thumbs/<?php echo $imagen;?>" alt="" border="1"/></a></div>
                                
                </div>
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>