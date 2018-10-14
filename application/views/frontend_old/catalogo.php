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
        	<h2>LISTADO DE CATEGOR&Iacute;AS</h2>
            <div id="listaCategorias">
            <?php
				foreach($listacats as $cat)
				{
					$nombreFor = formateaCadena($cat->nombre);
					$link = 'categoria/'.$cat->id_categoria.'/'.$nombreFor.'/1';
					$picCat = '<img src="files/categorias/'.$cat->foto_cat.'" border="0" />';
					echo '<div class="cat">';
					echo '<div class="fotoCat"><a href="'.$link.'">'.$picCat.'</a></div>';
					echo '<div class="nombreCat"><a href="'.$link.'">'.$cat->nombre.'</a></div>';
					echo '</div>';	
				}
			?>            
            </div><!-- listaCategorias -->
        </div><!-- derecha -->         
    </div><!--cuerpo-->
</div><!--general-->
<div id="footer">
<?php echo $footer; ?>        
</div><!--footer--> 
</body>
</html>