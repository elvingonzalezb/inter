<div id="footer">
  <div id="wrap-footer-links">
    <div id="footer-links">
      <div class="wrap-links">
        <h3>MENU</h3>
        <ul>
          <li><a href="./">Inicio</a></li>
<!--          <li><a href="acerca-nosotros">Acerca de nosotros</a></li>
          <li><a href="como-comprar">Como comprar</a></li>-->
          <li><a href="productos/1">Productos</a></li>
          <li><a href="novedades/1">Nuevo Ingreso</a></li>
          <li><a href="ofertas/1">Proximamente</a></li>
          <li><a href="lista-pedidos">Lista de Pedidos</a></li>
          <li><a href="contactenos">Contactenos</a></li>          
          <li><a href="inventario">Ingresar al Inventario</a></li>                    
        </ul>
      </div>

      <div class="wrap-links">
        <h3>TU CUENTA</h3>
        <ul>
          <li><a href="ingresar">Ingresa</a></li>
          <li><a href="registrese">Regístrese</a></li>
        </ul>
      </div>
      <div class="wrap-links">
        <h3>LEGAL</h3>
        <ul>
          <li><a href="condiciones-uso">Condiciones de Uso</a></li>
          <li><a href="politicas-privacidad">Pol&iacute;ticas de Privacidad</a></li>
        </ul>
      </div>

      <div class="wrap-links">
        <h3>DIRECCION</h3>
        <?php echo $direccion;?>
      </div>
    </div>
  </div>
  <div id="wrap-bottom">
    <?php 
    $twitter=getConfig("enlace_twitter");
    $facebook=getConfig("enlace_facebook");    
    ?>
    <div id="bottom">
      <p class="left"><?php echo getConfig("pie_pagina")?></p>
      <div class="right2">
          <!--
          <p>S&iacute;guenos en:</p>
          <p>
              <a href="http://www.twitter.com/<?php echo $twitter;?>" target="_blanck">
                  <img src="assets/frontend/cki/imagenes/twiter-icon.png" alt="" />
              </a>
              <a href="http://www.facebook.com/<?php echo $facebook;?>" target="_blanck">
                  <img src="assets/frontend/cki/imagenes/fb-icon.png" alt="" />
              </a>
          </p>
          -->
          <p>Desarrollado por:</p>
          <p><a href="http://www.ajaxperu.com" target="_blank">AJAXPERU</a></p>
      </div>
      <div class="right">
          <p>S&iacute;guenos en:</p>
          <p>
              <a href="http://www.facebook.com/<?php echo $facebook;?>" target="_blanck">
                  <img src="assets/frontend/cki/imagenes/fb-icon.png" alt="" />
              </a>
          </p>
      </div>
      <div class="acceso_main"><a href="mainpanel" target="_blank"><img src="assets/frontend/cki/imagenes/closed.png" border="0" align="absmiddle"/></a></div>      
    </div>
  </div>
</div>

<div class="modal hide fade modal700" id="myModal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3 id="tituloModal"></h3>
    </div>
    <div class="modal-body" id="cuerpoModal">
    </div>
    <div class="modal-footer" id="botoneraModal">
        
    </div>
</div>


</body>
</html>

  
<!--<script src="assets/frontend/cki/js/jquery.min.js"></script>-->
<script src="assets/admin/charisma/js/jquery-1.7.2.min.js"></script>  
<script src="assets/frontend/cki/js/jquery-ui.js"></script>
<script src="assets/frontend/cki/js/jquery.cycle.all.js"></script>
<script src="assets/frontend/cki/js/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="assets/frontend/cki/js/jquery.nyroModal-1.6.1.js"> </script>
<script type="text/javascript" src="assets/frontend/cki/js/ad-gallery/jquery.ad-gallery.1.2.5.js"> </script>
<script src="assets/frontend/cki/js/functions.js"></script>
<script src="assets/admin/charisma/js/bootstrap-modal.js"></script>
<script src="assets/admin/charisma/js/bootstrap-transition.js"></script>
<script src="assets/frontend/cki/js/funciones_ajax.js"></script>
<script src="assets/frontend/cki/js/jquery.scrollTo.js"></script>
    <script>
	$(document).ready(function(){
	<?php 
		$color=getConfig("color_de_fondo_menu");
	?>
		$("ul#header-menu li a.active").css({background: "<?php echo $color;?>" });
	<?php
		$aux_modal = getConfig("modal_inicio");
		if( ($aux_modal=="Si") && ($seccion=="inicio") )
		{
	?>
			cargaModalInicio();
	<?php
		}
		$aux_modal_2 = getConfig("modal_pedidos_directos");
		if( ($aux_modal_2=="Si") && ($seccion=="productoxcat") )
		{
			if( isset($idCat) && $idCat==26 )
			{
	?>
			cargaModalImportacion();
	<?php				
			}
		}
	?>
	});      
	</script>
        <script>
            $(function() {
                $( "#fecha_pago" ).datepicker();
                $( "#fecha_pago" ).datepicker( "option", "dateFormat", 'dd-mm-yy');
            });
        </script>