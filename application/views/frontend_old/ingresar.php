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
                    if(isset($resultado) && $resultado=='usuario'){
                       echo '<div class="errormsg">USUARIO INCORRECTO.</div>';
                    }
                    if(isset($resultado) && $resultado=='bienvenido'){
                        if(isset($_SESSION['logueadocki'])){
                            echo '<div class="succesmsg">'.$_SESSION['ses_razon'].' su logueo fue satisfactorio.</div>';
                        }
                    } 
					
                    if($this->session->userdata('msg_cliente_final')){
                       $str=$this->session->userdata('msg_cliente_final');
                       echo '<div class="errormsg">'.$str.'</div>';
                       $this->session->unset_userdata('msg_cliente_final');
                    }                     
                    
                    if(isset($resultado) && $resultado=='password'){
                       echo '<div class="errormsg">PASSWORD INCORRECTO</div>';
                    } 
                    
                    if(isset($resultado) && $resultado=='estado'){
                       echo '<div class="errormsg">USUARIO INACTIVO</div>';
                    }                    
                    ?>
                    <div id="formulario" class="clearfix">
                        <form action="ingresar/logueo" method="post" onSubmit="return valida_inicio()">
                            <table width="100%" border="0">
                                <tr>
                                    <td colspan="3"><h3>Ingrese sus datos</h3></td>
                                </tr>
                                <tr>
                                    <td width="45%" class="etiqueta">Usuario:</td>
                                    <td width="10%"></td>
                                    <td width="45%" class="etiqueta">Password:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="usuario" id="usuario" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['razon_social'];}?>"/></td>
                                    <td></td>
                                    <td><input type="password" name="password" id="password" size="50" class="campo" value="<?php if(isset($dat)){echo $dat['ruc'];}?>" /></td>
                                </tr>
                                <tr>
                                	<td colspan="3" align="left"> <a href="recordar-contrasena">Recordar contrase&ntilde;a</a></td>
                                </tr>
                                <tr>
                                    <td colspan="3" height="20"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><input type="submit" id="btnEnviar" class="boton" value="Ingresar" /></td>
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