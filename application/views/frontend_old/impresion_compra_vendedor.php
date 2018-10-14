<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Paginas2Go - Zona de Administración</title>
    <base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Contenidos Páginas2Go">
    <meta name="author" content="Eduardo Rosadio">

    <!-- The styles -->
    <link id="bs-css" href="assets/frontend/cki/css/impresion.css" rel="stylesheet">
</head>

<body>
<div id="popupImpresion">
    <h3 class="h3Reserv">DATOS DE LA COMPRA</h3>
    <table width="100%" cellpadding="0" cellspacing="1">
    <tbody>
        <tr>
            <td width="25%" align="left" valign="middle" class="etiqueta">Nro de Compra:</td>
            <td width="75%" align="left" valign="middle" class="dato"><?php echo ($orden->id_orden + 10000); ?></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="etiqueta">Nro de Reserva:</td>
            <td align="left" valign="middle" class="dato"><?php echo $orden->codigo_reserva; ?></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="etiqueta">Fecha y hora de Ingreso:</td>
            <td align="left" valign="middle" class="dato">
            <?php
                $aux_f = explode(" ", $orden->fecha_ingreso);
                $aux_f2 = explode("-", $aux_f[0]);
                $fecha_1 = $aux_f2[2]."-".$aux_f2[1]."-".$aux_f2[0];
                $fecha_orden = $fecha_1." ".$aux_f[1];
                echo $fecha_orden; 
            ?>
            </td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="etiqueta">Forma de Pago:</td>
            <td align="left" valign="middle" class="dato"><?php echo $orden->forma_pago; ?></td>
        </tr>
        <?php
            if($orden->forma_pago=="transferencia")
            {
        ?>
        <tr>
            <td align="left" valign="middle" class="etiqueta">Banco:</td>
            <td align="left" valign="middle" class="dato"><?php echo $orden->banco; ?></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="etiqueta">Nro Operacion:</td>
            <td align="left" valign="middle" class="dato"><?php echo $orden->numero_operacion; ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
    </table>
    <h3 class="h3Reserv">PRODUCTOS</h3>
    <div class="tooltip-demo well">
        <div class="box-content">
            <table width="100%" cellspacing="1">
                <thead>
                    <tr>
                        <th width="5%" class="cabecera">C&oacute;digo</th>
                        <th width="20%" class="cabecera">Nombre del Producto</th>
                        <th width="10%" class="cabecera">Color</th>
                        <th width="15%" class="cabecera">Nombre Color</th>
                        <th width="15%" class="cabecera">Precio</th>
                        <th width="15%" class="cabecera">Cantidad</th>
                        <th width="20%" class="cabecera">Subtotal</th>
                    </tr>
                </thead>   
                <tbody>
                <?php
                $total = '';
                foreach($detalles as $detalle)
                {
                    switch($orden->moneda)
                    {
                        case "s":
                            $precio = $detalle->precio_soles;
                            $simbolo = 'S/';
                        break;

                        case "d":
                            $precio = $detalle->precio_dolares;
                            $simbolo = 'US$';
                        break;
                    }
                    $st = $precio*($detalle->cantidad);
                    $subtotal = redondeado($st, 3);
                    $subtotal = number_format($subtotal, 3, '.', '');
                    echo '<tr>';
                    echo '<td align="center" class="celdaDato">'.$detalle->codigo_producto.'</td>';                        
                    echo '<td align="center" class="celdaDato">'.$detalle->nombre_producto.'</td>';
                    echo '<td align="center" class="celdaDato"><div style="background:'.$detalle->codigo_color.';margen:15px;width:30px;height:30px;border:#000 solid 1px;"></td>';
                    echo '<td align="center" class="celdaDato">'.$detalle->nombre_color.'</td>';
                    echo '<td align="center" class="celdaDato">'.$simbolo.' '.$precio.'</td>';
                    echo '<td align="center" class="celdaDato">'.$detalle->cantidad.'</td>';
                    echo '<td align="center" class="celdaDato">'.$simbolo.' '.$subtotal.'</td>';
                    echo '</tr>';
                    $total=$total + $subtotal;
                }

                ?>
                    <tr>
                        <td class="cabecera" colspan="5"></td>
                        <td class="cabecera" align="center" style="font-size:14px;">SUBTOTAL</td>
                        <td class="cabecera" align="center" style="font-size:14px;">S/ <?php echo $total; ?></td>
                    </tr>
                </tbody>
            </table> 
            <?php
                if($orden->numero_cargos>0)
                {
            ?>
    <h3 class="h3Reserv">CARGOS ADICIONALES</h3>
    <table width="100%" cellspacing="1">
        <thead>
            <tr>
                <th width="10%" class="cabecera">N</th>
                <th width="70%" class="cabecera">CONCEPTO</th>
                <th width="20%" class="cabecera">MONTO</th>
            </tr>
        </thead>   
        <tbody>
        <?php
            $aux_ca = $orden->lista_cargos;
            $aux_ca_2 = explode("@", $aux_ca);
            for($i=0; $i<count($aux_ca_2); $i++)
            {
                $aux_ca_3 = explode("#", $aux_ca_2[$i]);
                $total += $aux_ca_3[1];
                echo '<tr>';
                echo '<td align="center" class="celdaDato">'.($i+1).'</td>';
                echo '<td align="center" class="celdaDato">'.$aux_ca_3[0].'</td>';
                echo '<td align="center" class="celdaDato">'.$aux_ca_3[1].'</td>';
                echo '<tr>';
            }
        ?>
            <tr>
                <td class="cabecera"></td>
                <td class="cabecera" style="font-size:16px;">TOTAL</td>
                <td class="cabecera" style="font-size:16px;">S/ <?php echo number_format($total, 3, '.', ''); ?></td>
            </tr>
        </tbody>
    </table>
    <?php
        }
    ?>
</div>
</body>
</html>         