<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo getConfig("titulo_web")?></title>
    <base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Contenidos AJAXPERU">
    <meta name="author" content="Eduardo Rosadio">

    <link rel="stylesheet" href="assets/frontend/cki/css/style.css">
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="assets/frontend/cki/css/ie8-and-down.css" />
    <![endif]-->    
    <link rel="stylesheet" href="assets/frontend/cki/css/nivo-slider.css" type="text/css" media="screen" />  
    <link rel="stylesheet" href="assets/frontend/cki/css/nyroModal.full.css" type="text/css" media="screen" />    
    <link rel="stylesheet" href="assets/frontend/cki/css/jquery.ad-gallery.1.2.5.css" type="text/css" media="screen" /> 
<!--	<link href="assets/admin/charisma/css/bootstrap-responsive.css" rel="stylesheet">          -->
    <script src="assets/frontend/cki/js/modernizr.custom.95473.js"></script> 
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="assets/frontend/cki/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/frontend/cki/css/jquery-ui.theme.css">
    

</head>

<body style="background:<?php echo getConfig("color_de_fondo_cuerpo");?>">
<div id="top">
    <div id="header" class="clearfix">
    <div id="header-top">
      <div id="wrap-logo">
        <a href="./"><img src="assets/frontend/cki/imagenes/logo_cki.png" alt="" /></a>
      </div><!--wrap-logo-->
      <div id="wrap-header-info">
        <div id="cart">
          <div id="cart-title">SU PEDIDO</div><!--cart-->
          <div id="cart-summarry">Total: <?php
          if($this->session->userdata('carrito')){
              ?>
              <a href="pedido/carro" class="items" id="a_de_carrito"><?php 
              $carrito=$this->session->userdata('carrito');
              echo count($carrito);?> items</a> 
              <?php
          }else{
              ?>
              <a href="pedido/carro" class="items" id="a_de_carrito">0 items</a>               
              <?php
          }
          
//                  Amout: <span class="price">$356</span>
          ?>
          </div><!--cart-summarry-->
        </div><!--cart-->
        <div id="work-hours">
          <div class="white-line">Llámenos al <strong><?php echo $telefono;?></strong></div><!--whie-line-->
          <div class="pink-line">Horario: <?php echo $horario;?></div><!--pink-line-->
        </div><!--work-hours-->
      </div><!--wrap-header-info-->
      
      <div id="direccion_header">
          <?php
          echo getConfig("direccion");
          ?>
      </div><!--direccion_header-->
    </div><!--header-top-->
    <?php echo $menu;?>
  </div><!--header-->
</div>
<?php
    if($this->session->userdata('logueadocki')) 
    {
        echo '<div id="menuUsuario">';
        echo '<ul id="menuCliente">';
            echo '<li class="titulo">Bienvenido: '.$this->session->userdata('ses_razon').'</li>';            
            echo '<li><a href="reservas/listado/1">RESERVAS</a></li>';
            echo '<li><a href="compras/listado/1">HISTORIAL</a></li>';
            if($this->session->userdata('nivel')=="administrador") 
            {
                echo '<li><a href="vendedores/listado">VENDEDORES</a></li>'; 
            }
            echo '<li><a href="mis-datos/actualizacion" class="boton_descarga">MIS DATOS</a></li>';
            echo '<li><a href="ingresar/logout">SALIR</a></li>';
        echo '</ul>';
        echo '</div><!-- menuUsuario -->';
    }
    else
    {
        echo '<div id="espaciadorTop"></div>';
    }
?>