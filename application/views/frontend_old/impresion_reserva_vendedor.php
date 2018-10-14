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
<h3>Datos de la Reserva</h3>
<table width="100%" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td width="35%" height="23" align="left" valign="middle" class="etiqueta">Nro de Reserva:</td>
            <td width="65%" align="left" valign="middle" class="dato">
            <?php
                $nro = $orden->id_orden + 10000;
                echo $nro; 
            ?>
            </td>
        </tr>
        <tr>
            <td height="23" align="left" valign="middle" class="etiqueta">Fecha y hora de Ingreso:</td>
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
            <td height="23" align="left" valign="middle" class="etiqueta">Fecha y hora de Caducidad:</td>
            <td align="left" valign="middle" class="dato">
            <?php
                $caducidad = Ymd_2_dmYHora($orden->caducidad);
                echo $caducidad; 
            ?>
            </td>
        </tr>
        <tr>
            <td height="23" align="left" valign="middle" class="etiqueta">Tiempo Restante:</td>
            <td align="left" valign="middle" class="dato">
            <?php
                $aux_hc = explode(" ", $orden->caducidad);
                $aux_hc_2 = explode("-", $aux_hc[0]);
                $aux_hc_3 = explode(":", $aux_hc[1]);
                $time_caducidad = mktime($aux_hc_3[0], $aux_hc_3[1], $aux_hc_3[2], $aux_hc_2[1], $aux_hc_2[2], $aux_hc_2[0]);
                $ahora = time();
                $diferencia = conversorSegundosHoras($time_caducidad - $ahora);
                echo $diferencia; 
            ?>
            </td>
        </tr>
    </tbody>
</table> 
<h3>Datos del Cliente</h3>
<table width="100%" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td width="35%" height="23" align="left" valign="middle" class="etiqueta">Raz&oacute;n Social:</td>
            <td width="65%" align="left" valign="middle" class="dato">
                <?php echo $cliente->razon_social; ?>
            </td>
        </tr>
        <tr>
            <td height="23" align="left" valign="middle" class="etiqueta">RUC:</td>
            <td align="left" valign="middle" class="dato">
                <?php echo $cliente->ruc; ?>
            </td>
        </tr>
        <tr>
            <td height="23" align="left" valign="middle" class="etiqueta">Email:</td>
            <td align="left" valign="middle" class="dato">
                <?php echo $cliente->email; ?>
            </td>
        </tr>
        <tr>
            <td height="23" align="left" valign="middle" class="etiqueta">Comentario del Cliente:</td>
            <td align="left" valign="middle" class="dato">
                <?php echo $orden->mensaje;?>
            </td>
        </tr>                                 
    </tbody>
</table>                    


<h3>Lista de Productos</h3>
<div class="tooltip-demo well">
    <div class="box-content">
        <table width="100%" cellpadding="0" cellspacing="2">
            <thead>
                <tr>
                <?php
                    switch($orden->tipo_reserva)
                    {
                        case "stock":
                    ?>
                    <th width="15%" height="23" align="center" valign="middle" class="cabecera">C&oacute;digo</th>
                    <th width="20%" class="cabecera">Nombre del Producto</th>
                    <th width="10%" class="cabecera">Color</th>
                    <th width="13%" class="cabecera">Nombre Color</th>
                    <th width="13%" class="cabecera">Cantidad</th>
                    <th width="13%" class="cabecera">Precio</th>                                    
                    <th width="13%" class="cabecera">Subtotal</th>                                    
                    <?php
                        break;

                        case "proximamente":
                    ?>
                    <th width="10%" class="cabecera">C&oacute;digo</th>
                    <th width="20%" class="cabecera">Nombre del Producto</th>
                    <th width="10%" class="cabecera">Color</th>
                    <th width="15%" class="cabecera">Nombre Color</th>
                    <th width="12%" class="cabecera">Fecha Llegada</th>
                    <th width="12%" class="cabecera">Cantidad</th>
                    <th width="12%" class="cabecera">Precio</th>                                    
                    <th width="14%" class="cabecera">Subtotal</th>                                    
                    <?php
                        break;
                    }                        
                ?>                    
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
                if($orden->tipo_reserva=="proximamente")
                {
                    $ci =& get_instance();
                    $fecha_llegada = $ci->Reservas_model->getFechaLlegada($detalle->id_producto, $detalle->id_color);
                    echo '<td align="center" class="celdaDato">'.Ymd_2_dmY($fecha_llegada).'</td>';
                }
                echo '<td align="center" class="celdaDato">'.$detalle->cantidad.'</td>';
                echo '<td align="center" class="celdaDato">'.$simbolo.' '.$precio.'</td>';                                
                echo '<td align="center" class="celdaDato">'.$simbolo.' '.$subtotal.'</td>';
                echo '</tr>';
                $total = $total + $st;
            }
            $total = number_format(redondeado($total, 3), 3, '.', '');
            ?>
            <tr>
                <td colspan="<?php if($orden->tipo_reserva=="proximamente") echo '6'; else echo '5'; ?>"></td>
                <td class="cabecera" align="center" style="font-size:12px;">SUBTOTAL</td>
                <td class="cabecera" align="center" style="font-size:12px;"><?php echo $simbolo.' '.$total; ?></td>
            </tr>
            </tbody>
        </table> 
<?php
    if(count($cargos)>0)
    {
?>
<h3>CARGOS ADICIONALES</h3>
<table width="100%" cellpadding="0" cellspacing="2">
    <thead>
        <tr>
            <th width="65%" align="center" valign="middle" class="cabecera">CONCEPTO</th>
            <th width="15%" align="center" valign="middle" class="cabecera"></th>
            <th width="20%" align="center" valign="middle" class="cabecera">MONTO</th>
        </tr>
    </thead>   
    <tbody>
    <?php
        foreach($cargos as $cargo)
        {
            $concepto = $cargo->concepto;
            $monto = $cargo->monto;
            $total += $monto;
            echo '<tr>';
            echo '<td height="23" colspan="2" align="left" class="celdaDato" style="padding-left:20px;">'.$concepto.'</td>';
            echo '<td align="center" class="celdaDato">S/ '.$monto.'</td>';
            echo '<tr>';
        }
    ?>
        <tr>
            <td align="center" valign="middle" class="cabecera"></td>
            <td align="center" valign="middle" class="cabecera"><strong>TOTAL</strong></td>
            <td align="center" valign="middle" class="cabecera"><strong>S/ <?php echo $total; ?></strong></td>
        </tr>
    </tbody>
</table>        
<?php
    }
?>
</div>
</body>
</html>          