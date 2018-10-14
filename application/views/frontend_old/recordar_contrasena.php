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
              <h1 class="nice-title">Recordar Contraseña</h1>
            </div>
            <div class="contenido">
              
                <div class="sub_contenido">
                    <?php 
                    if(isset($resultado) && $resultado=='email-incorrecto'){
                       echo '<div class="errormsg">EMAIL INCORRECTO.</div>';
                    }
                    if(isset($resultado) && $resultado=='success'){
                        echo '<div class="succesmsg">Le hemos enviado su contraseña a su Correo Electrónico</div>';
                    } 
                    ?>
                    <div id="formulario" class="clearfix">
                        <form action="recordar-contrasena/buscar" method="post" onSubmit="return valida_recordar()">
                            <table width="100%" border="0">
                                <tr>
                                    <td colspan="3"><h3>Ingrese el Correo Electronico</h3></td>
                                </tr>
                                <tr>
                                    <td width="45%" class="etiqueta"></td>
                                    <td width="10%"></td>
                                    <td width="45%" class="etiqueta"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email" id="email" size="70" class="campo" value="<?php if(isset($dat)){echo $dat['razon_social'];}?>"/></td>
                                    <td></td>
                                    <td><input type="submit" class="boton" value="Enviar" /></td>
                                </tr>
                            </table>
                        </form>
                    </div><!-- formulario --> 
                </div><!--sub_contenido-->
            </div>
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>