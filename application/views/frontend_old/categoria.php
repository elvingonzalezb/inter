<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<base href="<?php echo base_url(); ?>" />
<link rel="stylesheet" type="text/css" href="assets/frontend/<?php echo $theme; ?>/css/layout.css" />
<link rel="stylesheet" href="assets/frontend/<?php echo $theme; ?>/css/nivo-slider/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="assets/frontend/<?php echo $theme; ?>/css/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="assets/frontend/<?php echo $theme; ?>/css/nivo-slider/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/ajax_lib.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/funciones.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/response.js"></script>
<script type="text/javascript" language="javascript" src="assets/frontend/<?php echo $theme; ?>/ajax/generales_js.js"></script>
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/nyro_slider.js"></script>
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
        	<h2><?php echo $nombre_categoria; ?></h2>
            <div id="listaProductos">
                <div id="cont_prod" class="clearfix">
                <?php
					foreach($productos as $producto)
					{
						$nomUrl = formateaCadena($producto->nombre);
						echo '<div class="box_productos">';
							echo '<div class="fotoprod">';
							echo '<img src="files/foto_producto/'.$producto->foto.'" border="0" />'; 
							echo '</div><!--fotoprod-->';
							echo '<h2>'.$producto->nombre.'</h2>';
							echo '<div class="botones_prod">';
							echo '<a href="producto/'.$producto->id_prod.'/'.$nomUrl.'"><img src="assets/frontend/'.$theme.'/imagenes/vermas.png" border="0" /></a>';
							echo '</div>';
						echo '</div><!--box_productos-->';	
					}
				?>
                </div><!-- cont_prod -->
                <div id="p_paginacion">
                <?php
					for($i=1; $i<=$numero_paginas; $i++)
					{
						if($i==$pagina_actual)
						{
							echo '<a class="pagina_activo">'.$i.'</a> ' ;
						}
						else
						{
							echo '<a class="pagina_noactivo" href="categoria/'.$id_categoria.'/'.$url.'/'.$i.'">'.$i.'</a> ';
						}
					}
				?>
                </div><!-- p_paginacion -->
            </div><!-- listaProductos -->
        </div><!-- derecha -->         
    </div><!--cuerpo-->
</div><!--general-->
<div id="footer">
<?php echo $footer; ?>        
</div><!--footer--> 
</body>
</html>