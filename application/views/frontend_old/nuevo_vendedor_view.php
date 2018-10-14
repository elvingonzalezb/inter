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
              <h1 class="nice-title">AGREGAR VENDEDOR</h1>
            </div>
            <div class="contenido">
                <div id="formularioCompra">
                <h2>Nuevo Vendedor </h2>
                <?php
                    if( $this->session->flashdata('errorRegistro') )
                    {
                        $msg = $this->session->flashdata('errorRegistro');
                        echo '<div class="msgAlerta">'.$msg.'</div>';
                    }
                ?>
                <form method="post" action="vendedores/grabar" onsubmit="return valida_vendedor()">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Nombre</td>
                            <td><input type="text" name="nombre" id="nombre" size="60"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Cargo</td>
                            <td><input type="text" name="cargo" id="cargo" size="60"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Teléfono</td>
                            <td><input type="text" name="telefono" id="telefono"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Email</td>
                            <td><input type="text" name="email" id="email" size="60"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Clave</td>
                            <td><input type="text" name="clave" id="clave"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">Permitir ver precios?</td>
                            <td>
                                <input type="radio" name="ver_precio" value="si" checked> SI
                                <br>
                                <input type="radio" name="ver_precio" value="no"> NO
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
                                <input type="submit" value="GRABAR" class="boton_compra"></td>
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
