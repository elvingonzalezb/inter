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
<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>
<script type="text/javascript" src="assets/frontend/<?php echo $theme; ?>/js/jquery.carouFredSel-5.5.0.js"> </script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#mycarousel").carouFredSel({
			auto	: {
				items 			: 5,
				duration		: 8000,
				easing			: "linear",
				pauseDuration	: 1000,
				pauseOnHover	: "immediate",
				width           : 500,
				height          : 150
			}
		});		
		
	});
</script>
<?php echo $map['js']; ?>
</head>

<body>
<div id="general">
    <div id="header">
    <?php echo $header; ?>
    </div><!--header-->
    <div id="menu">
    <?php echo $menu; ?>     
    </div><!--menu-->
    <div id="cuerpo">
    	<h1><?php echo $contenido->nom_tweb; ?></h1>
        <div class="text_info">
        <?php echo $contenido->info_tweb; ?>
        </div>
        <div id="mapa"><?php echo $map['html']; ?></div>   
        <?php //echo '<h1>'.$centro.'</h1>'; ?>      
    </div><!--cuerpo-->
</div><!--general-->
<div id="footer">
<?php echo $footer; ?>        
</div><!--footer--> 
</body>
</html>