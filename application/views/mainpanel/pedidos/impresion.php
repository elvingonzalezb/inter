<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	<meta charset="utf-8">
	<title>Paginas2Go - Zona de Administración</title>
    <base href="<?php echo base_url(); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Gestor de Contenidos Páginas2Go">
	<meta name="author" content="Eduardo Rosadio">

	<!-- The styles -->
	<link id="bs-css" href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding: 10px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
          #popupImpresion { max-width: 98%; padding: 1%; }
	</style>
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/charisma-app.css" rel="stylesheet">
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/fullcalendar.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/chosen.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/uniform.default.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/colorbox.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery.noty.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/noty_theme_default.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/elfinder.min.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/elfinder.theme.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/opa-icons.css' rel='stylesheet'>
	<link href='<?php echo 'assets/admin/'.$theme.'/'; ?>css/uploadify.css' rel='stylesheet'>
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/js_color_picker_v2.css" rel="stylesheet">    
	<link href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/julio_css.css" rel="stylesheet">   
        <link rel="stylesheet" type="text/css" href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/JSCal2/jscal2.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo 'assets/admin/'.$theme.'/'; ?>css/JSCal2/border-radius.css" />       

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?php echo 'assets/admin/'.$theme.'/'; ?>img/favicon.ico">
    <!--<script type="text/javascript" src="assets/fckeditor/fckeditor.js"></script>-->
    <script src="assets/ckeditor/ckeditor.js"></script>
        <!-- jQuery -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery-1.7.2.min.js"></script>
</head>

<body>
    <div id="popupImpresion">
<h3>FECHA DEL PEDIDO</h3>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <td><h4>Fecha y hora:</h4></td>
            <td>
            <?php
                $aux_f = explode(" ", $orden->fecha_ingreso);
                $aux_f2 = explode("-", $aux_f[0]);
                $fecha_1 = $aux_f2[2]."/".$aux_f2[1]."/".$aux_f2[0];
                $fecha_orden = $fecha_1." ".$aux_f[1];
                echo $fecha_orden; 
            ?>
            </td>
        </tr>
    </tbody>
</table> 
<h3>Datos del Cliente</h3>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <td><h4>Raz&oacute;n Social:</h4></td>
            <td>
                <?php echo $cliente->razon_social; ?>
            </td>
        </tr>
        <tr>
            <td><h4>Nombre:</h4></td>
            <td>
                <?php echo $cliente->nombre; ?>
            </td>
        </tr>
        <tr>
            <td><h4>RUC:</h4></td>
            <td>
                <?php echo $cliente->ruc; ?>
            </td>
        </tr>
        <tr>
            <td><h4>Domicilio:</h4></td>
            <td>
                <?php echo $cliente->domicilio; ?>
            </td>
        </tr>
        <tr>
            <td><h4>Ubicaci&oacute;n:</h4></td>
            <td>
                <?php echo $cliente->ciudad.'-'.$cliente->provincia.'-'.$cliente->departamento; ?>
            </td>
        </tr>
        <tr>
            <td><h4>C&oacute;digo Postal:</h4></td>
            <td>
                <?php echo $cliente->zip; ?>
            </td>
        </tr>
        <tr>
            <td><h4>Tel&eacute;fono:</h4></td>
            <td>
                <?php echo $cliente->telefono; ?>
            </td>
        </tr> 
        <tr>
            <td><h4>Fax:</h4></td>
            <td>
                <?php echo $cliente->fax; ?>
            </td>
        </tr>
        <tr>
            <td><h4>Tipo de Cliente:</h4></td>
            <td>
                <?php echo $cliente->tipo_cliente;?>
            </td>
        </tr>
        <tr>
            <td><h4>Email:</h4></td>
            <td>
                <?php echo $cliente->email; ?>
            </td>
        </tr>
        <tr>
            <td><h4>Comentario del Cliente:</h4></td>
            <td>
                <?php echo $orden->mensaje;?>
            </td>
        </tr>                                 
    </tbody>
</table>                    


<h3>Lista de Productos</h3>
<div class="tooltip-demo well">
    <div class="box-content">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="15%">C&oacute;digo</th>
                    <th width="23%">Nombre del Producto</th>
                    <th width="10%">Color</th>
                    <th width="13%">Nombre Color</th>
                    <th width="13%">Precio</th>
                    <th width="13%">Cantidad</th>
                    <th width="13%">Subtotal</th>
                </tr>
            </thead>   
            <tbody>
            <?php
                //var_dump($categorias);
            $da=explode("~",$orden->pedidos);
            $num_ped=$da[0];
            $total='';
            for($i=1; $i<=$num_ped; $i++)
            {
                $da1=$da[$i];
                $da2=explode("@",$da1);
                $cantidad= $da2[1];
                $codigo= $da2[4];
                $nombre= $da2[5];
                $color= $da2[2];
                $precio= $da2[3];
                $subtotal= $da2[6];                                    
                $unid= $da2[7];
                if(!empty($da2[8]))
                {
                    $id_color = $da2[8];
                    $ci = &get_instance();
                    $ci->load->model("mainpanel/Pedido_model");
                    $aux_nombre_color = $ci->Pedido_model->nombreColor($id_color);
                    $nombre_color = $aux_nombre_color->nombre;
                }
                else
                {
                    $nombre_color = '--------';
                }
                //$nombre_color = $da2[8]; 
                echo '<tr>';
                echo '<td class="center">'.$codigo.'</td>';                        
                echo '<td class="center">'.$nombre.'</td>';
                echo '<td class="center"><div style="background:'.$color.';margen:15px;width:50px;height:50px;border:#000 solid 1px;"></td>';
                echo '<td class="center">'.$nombre_color.'</td>';
                echo '<td class="center">'.$precio.'</td>';
                echo '<td class="center">'.$cantidad.' ('.$unid.') </td>';
                echo '<td class="center">'.$subtotal.'</td>';
                echo '</tr>';
                $total=$total + $subtotal;
            }

            ?>
            </tbody>
        </table> 
    </div>
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery-1.7.2.min.js"></script>                

	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/index_ordenar.js"></script>  	
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery-ui-1.8.12.custom.min.js"></script>          
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery-ui-1.8.21.custom.min.js"></script>                  
	<!-- transition / effect library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='<?php echo 'assets/admin/'.$theme.'/'; ?>js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/excanvas.js"></script>
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.flot.min.js"></script>
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.flot.pie.min.js"></script>
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.flot.stack.js"></script>
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/charisma.js"></script>

  
	<script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/js_color_picker/color_functions.js"></script>		
    <script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/js_color_picker/js_color_picker_v2.js"></script>
    
    <script type="text/javascript" src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/JSCal2/js/jscal2.js"></script>
    <script type="text/javascript" src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/JSCal2/js/lang/es.js"></script>        
    <script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/generales_js.js"></script>  		
    <script src="<?php echo 'assets/admin/'.$theme.'/'; ?>js/funciones_ajax.js"></script>    
</body>
</html>         