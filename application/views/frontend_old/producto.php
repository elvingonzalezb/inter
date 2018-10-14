<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $producto->nombre; ?></title>
<base href="<?php echo base_url(); ?>" />
<link rel="stylesheet" type="text/css" href="assets/frontend/<?php echo $theme; ?>/css/layout.css" />
<link rel="stylesheet" href="assets/frontend/<?php echo $theme; ?>/css/jquery.jqzoom.css" type="text/css">
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/ajax_lib.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/funciones.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/response.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/generales_js.js"></script>
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/nyro_slider.js"></script>
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/jquery.jqzoom-core.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.jqzoom').jqzoom({
				zoomType: 'reverse',
				lens:true,
				preloadImages: false,
				alwaysOn:false
		});
	});
</script>
</head>

<body>
<div id="general">
    <div id="header">
    <?php echo $header; ?>
    </div><!--header-->
    <div id="menu">
    <?php echo $menu; ?>     
    </div><!--menu-->
    <div id="cuerpo" class="clearfix">
    	<div id="izquierda">
			<h2>CATEGOR&Iacute;AS</h2>
    		<div id="listaCatIzq">
            <ul>
            <?php
				foreach($listacats as $cat)
				{
					$nombreFor = formateaCadena($cat->nombre);
					echo '<li><a href="categoria/'.$cat->id_categoria.'/'.$nombreFor.'/1" >'.$cat->nombre.'</a></li>';	
				}
			?>
            </ul>
            </div> <!--listaCatIzq--> 
        </div><!--izquierda--> 
        <div id="derecha"> 
        	<div class="volver"><a href="javascript:history.back(-1)">Volver</a></div>
        	<h1 class="nombreProducto"><?php echo $producto->nombre; ?></h1>
            <div id="datosProducto">
            	<div id="productoIzq">
                	<div id="foto_detll">
                    <a href="files/modal/<?php echo $producto->foto?>" class="jqzoom" rel='gal1' title="<?php echo $producto->nombre; ?>">
                    <img src="files/fotografias/<?php echo $producto->foto; ?>"  title="triumph" />
                    </a>   
                    </div><!-- foto_detll -->
                	<div id="picsChicas">
                    <ul id="thumblist" class="clearfix" >
                    <?php
                    foreach ($fotos as $foto) {
                        //$rel = '{gallery: \'gal1\', smallimage: \'fotografias/'.$foto->foto.',largeimage: \'modal/'.$foto->foto;
                        echo '<li><a href="javascript:void(0);"><img src="files/thumbnails_fotografias/' . $foto->foto . '" /></a></li>';
                    }
                    ?>
                    </ul>
                    </div>
                </div><!-- productoIzq -->
                <div id="productoDerecha">
                    <div class="seggg">                            
                        <?php echo $producto->detalle; ?>
                    </div><!--seggg-->
                    
                    <div class="seggg">
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                        
                        <div class="fb-like" data-href="<?php echo base_url();?>/producto/<?php echo $producto->id_prod.'/'.$nombre_producto;?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="true"></div>  
                    </div><!--seggg-->
                    
                    <div class="seggg">
                        Cantidad:
                        <input type="text" id="cantidad" name="cantidad" size="5" class="campo_orden" />
                        <a href="javascript:void(0)" onclick="agrega_orden('<?php echo $producto->id_prod;?>')" title="Coloque la cantidad y luego Cotizar"><img src="assets/frontend/<?php echo $theme; ?>/imagenes/cotizar.png" border="0" align="absmiddle"/></a>
                    </div><!--seggg-->                
                </div><!-- productoDerecha -->
            </div><!-- datosProducto -->
        </div><!-- derecha -->         
    </div><!--cuerpo-->
</div><!--general-->
<div id="footer">
<?php echo $footer; ?>        
</div><!--footer--> 
</body>
</html>