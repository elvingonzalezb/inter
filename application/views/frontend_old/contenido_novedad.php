<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Novedades</title>
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
    	<div class="text_info">
        	<div class="volver"><a href="javascript:history.back(-1)">Volver</a></div>
			<div id="conNotDetll">
        	<h2><?php echo $contenidonovedad->titulo; ?></h2>
            <div id="headerNot" class="clearfix">
                <div id="headerNotLeft">
                <?php
                    if( (isset($contenidonovedad->foto)) && ( is_file('files/foto_novedades/'.$contenidonovedad->foto) ) )
                    {
                        echo '<img src="files/foto_novedades/'.$contenidonovedad->foto.'" />';
                    }
                    else
                    {						
                        echo '<img src="assets/frontend/'.$theme.'/imagenes/img300x200.png" />';								
                    }                                
                ?>  
                </div><!--headerNotLeft-->
                <div id="headerNotRight">
                    Publicado: <?php echo Ymd_2_dmY($contenidonovedad->fecha);?>
                    <span><?php echo $contenidonovedad->sumilla; ?></span>
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-like" data-href="<?php echo base_url();?>/novedad/<?php echo $contenidonovedad->id_novedad; ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="true"></div>                                                               
                </div><!--headerNotRight-->
            </div><!--headerNot-->
            <div id="footerNot">
                <p>
				<?php
                	if($contenidonovedad->texto!="")
					{
						echo $contenidonovedad->texto;
					}
					else
					{
						echo 'Sin especificaci&oacute;n';
					}
				?>
                </p>
            </div><!--footerNot-->             
            </div><!-- conNotDetll -->
        </div>    
    </div><!--cuerpo-->
</div><!--general-->
<div id="footer">
<?php echo $footer; ?>        
</div><!--footer--> 
</body>
</html>