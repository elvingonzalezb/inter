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
              <h1 class="nice-title">DATOS VENDEDOR</h1>
            </div>
            <div class="contenido">
                <div id="formularioCompra">
                <h2>Detalle Vendedor </h2>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Nombre</td>
                            <td><?php echo $vendedor['nombre']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Cargo</td>
                            <td><?php echo $vendedor['cargo']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Teléfono</td>
                            <td><?php echo $vendedor['telefono']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Email</td>
                            <td><?php echo $vendedor['email']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Clave</td>
                            <td><?php echo $vendedor['clave']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Puede ver precios?</td>
                            <td><?php echo strtoupper($vendedor['ver_precio']); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Estado</td>
                            <td><?php echo $vendedor['estado']; ?></td>
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
