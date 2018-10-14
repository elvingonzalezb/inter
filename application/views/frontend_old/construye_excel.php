<?php
    $timestamp = time();
    //$hoy=fecha_hoy_dmY();
    $factor_descto = getConfig("descuento");
    $factor_tc = getConfig("tipo_cambio_dolar");
    $moneda = $this->session->userdata('moneda');
    switch($moneda)
    {
        default:
        case "s":
            $t_c = 1;
            $uni = 'S/.';
            $cabeceraColumna = 'PRECIO UNID./SOLES';
        break;
    
        case "d":
            $t_c = $factor_tc; 
            $uni = 'US$ ';
            $cabeceraColumna = 'PRECIO UNID./DOLARES';
        break;
    }
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition:attachment; filename=\"files/archivos_excel/".$timestamp.".xls\";");
        
    $str = '<table width="1500" cellpadding="0" cellspacing="1" id="tablaReporteGeneral" border="1">';
    $str .= '<thead>';
    $str .= '<tr>';
    $str .= '<td width="50" height="30" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">NRO</td>';
    $str .= '<td width="100" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">CODIGO</td>';
    //$foto_ver=  getConfig("mostrar_imagen");
    $str .= '<td width="150" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">FOTO</td>';                    
    for($i=0; $i<count($familias); $i++)
    {
        $nombreFamilia = $familias[$i]['nombre'];
        $str .= '<td width="100" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">'.$nombreFamilia.'</td>';
    }
    $str .= '<td width="100" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">'.$cabeceraColumna.'</td>';                
    $str .= '<td width="100" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">ULTIMA ACTUALIZACION</td>';    
    $str .= '</tr>';
    $str .= '</thead>';
    
    $str .= '<tbody>';
    for($i=0; $i<count($categorias); $i++)
    {
        $nombreCat = utf8_decode($categorias[$i]['nombre_categoria']);
        $str .= '<tr>';
        $str .= '<td colspan="'.(count($familias) + 5).'"><strong>CATEGORIA : '.$nombreCat.'</strong></td>';
        $str .= '</tr>';
        $num_subcats = $categorias[$i]['num_subcats'];
        if($num_subcats>0)
        {
            $subcategorias = $categorias[$i]['subcategorias'];
            for($j=0; $j<count($subcategorias); $j++)
            {
                $nombreSubCat = utf8_decode($subcategorias[$j]['nombre']);
                $str .= '<tr>';
                $str .= '<td colspan="'.(count($familias) + 5).'"><strong>Sub Categoria : '.$nombreSubCat.'</strong></td>';
                $str .= '</tr>';
                $num_productos = $subcategorias[$j]['numero_productos'];
                if($num_productos>0)
                {
                    $productos = $subcategorias[$j]['productos'];
                    for($g=0; $g<$num_productos; $g++)
                    {
                        $nombreProducto = utf8_decode($productos[$g]['nombre']);
                        $codigo = utf8_decode($productos[$g]['codigo']);
                        $imagen = '<img src="'.$base_url.'files/productos_thumbs/'.$productos[$g]['imagen'].'" width="40" />';
                        //$imagen = $productos[$g]['imagen'];
                        //$imagen = '';
                        $str .= '<tr>';
                        $str .= '<td height="80" align="center">'.($g+1).'</td>';
                        $str .= '<td align="center">'.$codigo.'</td>';
                        $str .= '<td width="150" align="center">'.$imagen.'</td>';
                        
                        $pantone = $productos[$g]['pantone'];
                        for($r=0;$r<count($pantone);$r++)
                        {
                            $str .= '<td align="center" valign="middle" style="border:#000 solid 1px;">';
                            $cur=$pantone[$r];
                            $nombre=$cur['nombre'];
                            $color_stock=$cur['color_stock'];
                            for($t=0;$t<count($color_stock);$t++)
                            {
                                $cur2=$color_stock[$t];
                                $color=$cur2['color'];
                                $nombre=$cur2['nombre'];
                                $stock = $cur2['stock'];
                                if($stock>0)
                                {
                                    $str .= '<table width="100%" border="0" height="30">';
                                    $str .= '<tr>';						
                                    $str .= '<td width="50%" height="20" style="background:'.$color.';"></td>';						
                                    //$str .=$nombre.' - Stock: '.$stock.'<br>';
                                    $str .= '<td width="50%" align="center" valign="middle">'.$stock.'</td>';
                                    $str .= '</tr>';
                                    $str .= '</table>';					
                                }
                            }
                            $str .= '</td>';  
                        }
                        $str .= '<td align="center" valign="top" style="border:#000 solid 1px;">';
                            $str2 ='';
                            $precios = $productos[$g]['precios'];
                            for($r=0;$r<count($precios);$r++)
                            {
                                $cur=$precios[$r];
                                if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='s')
                                {
                                   $dscto = 1;
                                }
                                else if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='d')
                                {                                    
                                    // vemos si tiene descuento
                                    $descuento_cambio_moneda = $this->session->userdata('descuento_cambio_moneda');
                                    if($descuento_cambio_moneda=='si')
                                    {
                                        $dscto = $factor_descto;
                                    }
                                    else
                                    {
                                        $dscto = 1;
                                    }                          
                                }
                                else
                                {
                                    $t_c = 1;
                                    $dscto = 1;
                                }                    
                                $precio = $cur['precio'];
                                $aux_precio = ($precio/$t_c/$dscto);
                                $precio = number_format($aux_precio, 3, '.', ',');
                                $unidad = $cur['unidad'];                    
                                //$str2 .= $uni.''.$precio.' - '.$unidad.'<br>';
                                // QUITAMOS LA UNIDAD Y EL SIMBOLO MONEDA 02/06/2015
                                $str2 .= $precio.'<br>';
                            }
                            $str .= $str2;
                        $str .= '</td>';
                        $str .= '<td align="center" valign="middle" style="border:#000 solid 1px;">'.$productos[$g]['ultima_fecha'].'</td>'; 
                        $str .= '</tr>';
                    }
                }
            }
        }
    }
    $str .= '</tbody>';
    $str .= '</table>';
    echo $str;
?>