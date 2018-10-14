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
              <h1 class="nice-title">EDITAR VENDEDOR</h1>
            </div>
            <div class="contenido">
                <div id="formularioCompra">
                <h2>Datos Vendedor </h2>
                <?php
                    if(isset($resultado))
                    {
                        switch($resultado)
                        {
                            case "actualizado":
                                echo '<div class="msgCarrito msgAzul">Se actualizaron correctamente los datos del vendedor</div>';
                            break;
                        }
                    }
                ?>                 
                <form method="post" action="vendedores/actualizar" onsubmit="return valida_vendedor()">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Nombre</td>
                            <td><input type="text" name="nombre" id="nombre" size="60" value="<?php echo $vendedor['nombre']; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Cargo</td>
                            <td><input type="text" name="cargo" id="cargo" size="60" value="<?php echo $vendedor['cargo']; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Teléfono</td>
                            <td><input type="text" name="telefono" id="telefono" value="<?php echo $vendedor['telefono']; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Email</td>
                            <td><input type="text" name="email" id="email" size="60" value="<?php echo $vendedor['email']; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Clave</td>
                            <td><input type="text" name="clave" id="clave" value="<?php echo $vendedor['clave']; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Permitir ver precios?</td>
                            <td>
                                <input type="radio" name="ver_precio" value="si"<?php if($vendedor['ver_precio']=="si") echo ' checked'; ?>> SI
                                <br>
                                <input type="radio" name="ver_precio" value="no"<?php if($vendedor['ver_precio']=="no") echo ' checked'; ?>> NO
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Estado</td>
                            <td>
                                <input type="radio" name="estado" value="Activo"<?php if($vendedor['estado']=="Activo") echo ' checked'; ?>> ACTIVO
                                <br>
                                <input type="radio" name="estado" value="Inactivo"<?php if($vendedor['estado']=="Inactivo") echo ' checked'; ?>> INACTIVO
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato"></td>
                            <td>
                                <a href="vendedores/listado" class="btnComprar">VOLVER AL LISTADO</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="hidden" name="id" id="id" value="<?php echo $vendedor['id']; ?>">
                                <input type="submit" value="ACTUALIZAR" class="boton_compra"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                    </table>
                </form>
                </div>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>
