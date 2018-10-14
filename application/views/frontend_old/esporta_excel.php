<?php
	$timestamp = time();
        //$hoy=fecha_hoy_dmY();
        $factor_descto=getConfig("descuento");
        $factor_tc= getConfig("tipo_cambio_dolar");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:attachment; filename=\"files/archivos_excel/".$timestamp.".xls\";");
	

	echo '<table width="100%" cellpadding="0" cellspacing="1" id="tablaReporteGeneral" border="1">';
	echo '<thead>';
	echo '<tr>';
		echo '<td height="30" align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">NRO</td>';
		echo '<td align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">CODIGO</td>';
		$foto_ver=  getConfig("mostrar_imagen");
		echo '<td align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">FOTO</td>';                    
	        $cont=0;
			foreach($familias as $fam)
			{
				$currentFam = $fam->nombre;
				echo '<td align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">'.$currentFam.'</td>';
				$cont +=1;
			}		
		echo '<td align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">PRECIOS</td>';                
		echo '<td align="center" valign="middle" style="background-color:#8AC5FF;color:#F00;">ULTIMA ACTUALIZACION</td>';    
	echo '</tr>';
	echo '</thead>';
        
	echo '<tbody>';
        $nom_cat_ant='';
       for($d=0;$d<count($productos);$d++) {
 //      for($d=0;$d<20;$d++) {			
            $current=$productos[$d];
            $colum=5+$cont;
            if($current['nombre_categoria']!=$nom_cat_ant){
                echo '<tr height="25">';
                echo '<td align="left" valign="middle" colspan="'.$colum.'" style="border:#000 solid 1px;"><strong>Categoria: '.$current['nombre_categoria'].'</strong></td>';
                echo '</tr>';
            }
            echo '<tr height="80">';
            echo '<td align="center" valign="middle" style="border:#000 solid 1px;">'.($d+1).'</td>';    
            echo '<td align="center" valign="middle" style="border:#000 solid 1px;">'.$current['codigo'].'</td>';
            if($foto_ver=='si'){
                echo '<td align="center" valign="middle" style="border:#000 solid 1px;"><img src="'.$current['base_url'].'files/productos_thumbs/'.$current['imagen'].'" width="40" border="0"/></td>';                
            }else{
                echo '<td align="center" valign="middle" style="border:#000 solid 1px;">NO</td>';                
				
			}

            $pantone=$current['pantone'];
            for($r=0;$r<count($pantone);$r++)
            {
                echo '<td align="center" valign="middle" style="border:#000 solid 1px;">';
				
                $cur=$pantone[$r];
                $nombre=$cur['nombre'];
                $color_stock=$cur['color_stock'];
                $str = 0;
                for($t=0;$t<count($color_stock);$t++){
                    $cur2=$color_stock[$t];
                    $color=$cur2['color'];
                    $nombre=$cur2['nombre'];
                    $stock = $cur2['stock'];

						
                    if($stock>0)
                    {
						echo '<table border="0" height="30">';
						echo '<tr height="20">';						
						echo '<td width="20" height="20" style="background:'.$color.';"></td>';						
                        //$str .=$nombre.' - Stock: '.$stock.'<br>';
						echo '<td><p> '.$stock.'</p></td>';
						echo '</tr>';
						echo '</table>';					
                    }
                }
                
                echo '</td>';  
            }
            
            echo '<td align="center" valign="top" style="border:#000 solid 1px;">';
                $str='';
                $precios=$current['precios'];
                for($r=0;$r<count($precios);$r++){
                    $cur=$precios[$r];
                    if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='s'){
                       $t_c=1;$uni='S/.';$dscto=1;
                    }else if($this->session->userdata('moneda') && $this->session->userdata('moneda')=='d'){
                        $t_c= $factor_tc; $uni='US$ ';
                        // vemos si tiene descuento
                        if($current['descuento']=='si'){
                            $dscto=$factor_descto;
                        }else{$dscto=1;}                          
                    }else{
                        $t_c=1;$dscto=1;
                    }                    
                    $precio=$cur['precio'];
                    $precio=number_format(($precio/$t_c/$dscto), 3, '.', ',');
                    $unidad=$cur['unidad'];                    
                    $str .= $uni.''.$precio.' - '.$unidad.'<br>';
                }
                echo $str;
            echo '</td>';
            echo '<td align="center" valign="middle" style="border:#000 solid 1px;">'.$current['ultima_fecha'].'</td>';  
            echo '</tr>';
            $nom_cat_ant=$current['nombre_categoria'];
        }
	echo '</tbody>';        

?>