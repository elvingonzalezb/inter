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
              <h1 class="nice-title">ANULACION DE RESERVA</h1>
            </div>
            <div class="contenido">
            <?php
                if($resultado==0)
                {
                    echo '<div class="msgAlerta">';
                    echo '<p>No puede realizar la compra de esa reserva porque le pertenece a otro cliente.</p>';
                    echo '<a href="javascript:history.back(-1)">VOLVER</a>';
                    echo '</div>';
                }
                else 
                {
            ?>
                <div id="formularioCompra">
                <h2>Anulación de Reserva </h2>
                <form method="post" action="reservas/doAnulacion" onsubmit="return valida_anulacion_reserva()">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">CODIGO RESERVA</td>
                            <td align="left" valign="middle" class="dato"><?php echo (10000+$id_reserva); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">MOTIVO DE LA ANULACION</td>
                            <td><textarea name="observaciones" rows="4" cols="50" id="observaciones"></textarea></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato"></td>
                            <td>
                                <input type="hidden" name="id_reserva" id="id_reserva" value="<?php echo $id_reserva; ?>">
                                <input type="submit" value="ANULAR RESERVA" class="boton_compra"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                    </table>
                </form>
                </div>
            <?php
                }     
            ?>
            </div><!-- contenido -->
        </div><!--wrap-featured-products-->
        
        
      </div>
    </div>
  </div>
</div>
