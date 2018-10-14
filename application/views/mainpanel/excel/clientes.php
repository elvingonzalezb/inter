<?php
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition:  filename=\"".$nombre_archivo.".xls\";");
    $str = '<table width="100%" border="1" cellpadding="0" cellspacing="0">';
    $str .= '<thead>';
        $str .= '<tr>';
            $str .= '<th width="5%">Nro</th>';
            $str .= '<th width="15%">Raz&oacute;n Social</th>';
            $str .= '<th width="10%">Contacto</th>';
            $str .= '<th width="10%">Email</th>';
            $str .= '<th width="10%">Telefono</th>';
            $str .= '<th width="10%">Registro</th>';
            $str .= '<th width="10%">Estado</th>';
            $str .= '<th width="10%">Visitas</th>';
            $str .= '<th width="10%">Ultimo Ingreso</th>';
        $str .= '</tr>';
    $str .= '</thead>';
    $str .= '<tbody>';
    for($i=0; $i<count($clientes); $i++)
    {
        $current = $clientes[$i];
        $id_cliente = $current['id'];                        
        $razon_social = $current['razon_social'];
        $fecha_registro= Ymd_2_dmY(substr($current['fecha_registro'],0,10));
        $visitas = $current['visitas'];
        $ultimo_ingreso= $current['ultimo_ingreso'];
        $estado= $current['estado'];                        
        $nombre = $current['nombre'];
        $email = $current['email'];
        $telefono = $current['telefono'];
        $str .= '<tr>';
        $str .= '<td class="center">'.($i+1).'</td>';                        
        $str .= '<td class="center">'.$razon_social.'</td>';
        $str .= '<td class="center">'.$nombre.'</td>';
        $str .= '<td class="center">'.$email.'</td>';
        $str .= '<td class="center">'.$telefono.'</td>';
        $str .= '<td>'.$fecha_registro.'</td>';
        $str .= '<td class="center">'.$estado.'</td>';                        
        $str .= '<td>'.$visitas.'</td>';
        $str .= '<td>'.$ultimo_ingreso.'</td>';
        $str .= '</tr>';
    }
    $str .= '</tbody>';
    $str .= '</table>';
    echo $str;
?>