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
              <h1 class="nice-title"><?php echo $contenido->titulo;?></h1>
            </div>
            <div class="contenido">
                <div class="sub_contenido">
                    <?php echo $contenido->texto; ?>
                </div>
              
                <div class="sub_contenido">
                    <?php 
                    if(isset($resultado))
                    {
                        switch($resultado)
                        {
                            case "success":
                                echo '<div class="succesmsg">Su mensaje fue enviado correctamente, nos estaremos comunicando a la brevedad.</div>';
                            break;
                        
                            case "error":
                                echo '<div class="errormsg">Ocurrió un error al enviar el mensaje, inténtelo de nuevo.</div>';
                            break;
                        
                            case "codigo":
                                echo '<div class="errormsg">El codigo de la imagen es erroneo.</div>';
                            break;
                            /*
                            default:
                                echo '<div class="errormsg">Resultado:'.$resultado.'.</div>';
                            break;
                            */
                        }                    
                    }                   
                    ?>
                    <div id="formulario" class="clearfix">
                        <form action="contactenos/enviar-mensaje" method="post" onSubmit="return validacorreo()">
                        <fieldset>
                            <legend>(*) Campos Obligatorios</legend>
                            <ul>
                                <li>
                                    <label>Nombre *:</label>
                                    <input type="text" name="nombre" id="nombre" size="70" class="campo" />
                                </li>
                                <li>
                                	<?php
									if($this->session->userdata("email")){
										$em=$this->session->userdata("email");
									}else{
										$em='';
									}?>
                                    <label>Email*:</label>
                                    <input type="text" name="email" id="email" size="70" class="campo" value="<?php echo $em;?>"/>
                                </li>
                                <li>
                                    <label>Tel&eacute;fono *:</label>
                                    <input type="text" name="telefono" id="telefono" size="70" class="campo" />
                                </li>
                                <li>
                                	<?php
									if($this->session->userdata("ses_razon")){
										$rz=$this->session->userdata("ses_razon");
									}else{
										$rz='';
									}?>                                
                                    <label>Empresa *:</label>
                                    <input type="text" name="empresa" id="empresa" size="70" class="campo" value="<?php echo $rz;?>" />
                                </li>                    
                                <li>
                                    <label>Mensaje *:</label>
                                    <textarea name="mensaje" id="mensaje" cols="50" rows="10" class="campo_textarea"></textarea>
                                </li>
                                <li>
                                    <label>Código</label>
                                    <input type="text" name="codigo" id="codigo" size="20" class="campo" /><?php echo $cap_img; ?>
                                </li>
                                <li>
                                    <label></label>
                                    <input type="submit" name="enviar" value="Enviar" class="boton" />
                                </li>
                            </ul>
                        </fieldset>
                        </form>
                    </div><!-- formulario --> 
                </div><!--sub_contenido-->
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>