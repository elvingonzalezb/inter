<?php
    switch($moneda)
    {
        case "s":
            $simbolo = 'S/';
        break;
    
        case "d":
            $simbolo = 'US$';
        break;
    }
    $totalReserva = $total_reserva + $monto_cargos;
    $totalReserva = number_format($totalReserva, 3, '.', '');
    $procedencia = $this->session->userdata('procedencia');
?>
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
              <h1 class="nice-title">FORMULARIO DE COMPRA</h1>
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
                <h2>Formulario de Compra </h2>
                <form method="post" action="reservas/doCompra" onsubmit="return valida_compra()">
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
                            <td align="left" valign="middle" class="dato">MONTO A PAGAR</td>
                            <td align="left" valign="middle" class="dato">
                            <?php 
                                $total = $orden->total + $monto_cargos;
                                echo '<strong>'.$simbolo.' '.$totalReserva.'</strong>';
                            ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td width="5%" height="10"></td>
                            <td width="25%" class="dato">FORMA DE PAGO</td>
                            <td width="65%">
                                <select name="forma_pago" id="forma_pago" onchange="showOpcionesCompra(this.value)">
                                    <option value="0">Elija...</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                    <option value="deposito">Deposito Bancario</option>
                                    <?php
                                        if($datosCliente->tiene_credito=="Si")
                                        {
                                            echo '<option value="credito">Credito ('.$datosCliente->plazo_credito.' dias)</option>';
                                        }
                                        if($orden->total<=300)
                                        {
                                            echo '<option value="efectivo">Pago en Efectivo</option>';
                                        }
                                    ?>
                                    <?php
                                        if($procedencia=="Extranjero")
                                        {
                                            echo '<option value="JETPERU">JETPERU</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                            <td width="5%"></td>
                        </tr>
                        <tr class="filaOculta grp_1">
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr class="filaOculta grp_1">
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">BANCO</td>
                            <td>
                                <select name="banco" id="banco">
                                    <option value="0">Elija...</option>
                                    <option value="BCP">Banco BCP  del Peru (Cuenta en Soles 193-1611195096)</option>
                                    <option value="BANBIF">Banco BANBIF (Cuenta en Soles 7000469684)</option>
                                    <option value="BBVA">Banco Continental  del Peru (Cuenta en Soles 0140-0100029016)</option>                                
                                </select>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="filaOculta grp_2">
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr class="filaOculta grp_2">
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">NUM. OPERACION</td>
                            <td><input type="text" name="numero_operacion" id="numero_operacion"></td>
                            <td></td>
                        </tr>
                        <!--  class="filaOculta grp_3" -->
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">FECHA DE PAGO</td>
                            <td><input type="text" name="fecha_pago" onkeypress="return false;" size="10" placeholder="dd/mm/aaaa" id="fecha_pago"></td>
                            <td></td>
                        </tr>                        
                        <tr>
                            <td colspan="4" height="10"></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                            <td align="left" valign="middle" class="dato">OBSERVACIONES</td>
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
                                <!--<a href="reservas/listado/1" class="btnComprar">VOLVER AL LISTADO</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
                                <!-- // EDITADO PARA DESACTIVAR OPERACIONES EN AÑO NUEVO -->
                                <input type="submit" value="COMPRAR" class="boton_compra"></td>
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
