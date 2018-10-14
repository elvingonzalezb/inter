<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('construyeCarro'))
{
    function construyeCarro($id_reserva, $moneda) {
        $estiloHeader = 'style="padding:5px;text-align: center;color:#007dce;font-weight: bold;height: 31px;border: #EFEFEF solid 1px;background: #EBEBEB;"';
        $estiloCelda = 'style="color: #696767;border: solid 1px #C2C2C2;padding: 5px;"';
        $cuadr=' width: 15px;height: 15px;border: #C2C2C2 solid 1px; ';
        //creamos el carrito
        $car = '';
        $car .='<table width="100%" cellspacing="2">';
        $car .='<tr>';
            $car .='<td '.$estiloHeader.' width="5%">N</td>';
            $car .='<td '.$estiloHeader.' width="10%">C&oacute;digo</td>';
            $car .='<td '.$estiloHeader.' width="25%">Producto</td>';
            $car .='<td '.$estiloHeader.' width="10%">Color</td>';
            $car .='<td '.$estiloHeader.' width="15%">Cod. Color</td>';
            $car .='<td '.$estiloHeader.' width="10%">Cantidad</td>';
            $car .='<td '.$estiloHeader.' width="10%">Precio</td>';
            $car .='<td '.$estiloHeader.' width="15%">Subtotal</td>';
        $car .='</tr>';
        $registros = detallesReserva($id_reserva);
        $j=0;
        $total = 0;
        foreach($registros as $registro)
        {
            $codigo_producto = $registro->codigo_producto;
            $nombre_producto = $registro->nombre_producto;
            $codigo_color = $registro->codigo_color;
            $nombre_color = $registro->nombre_color;
            $cantidad = $registro->cantidad;
            switch($moneda)
            {
                case "d":
                    $simbolo = 'US$';
                    $precio = $registro->precio_dolares;
                break;
            
                case "s":
                    $simbolo = 'S/';
                    $precio = $registro->precio_soles;
                break;
            }
            $subtotal = $cantidad*$precio;
            $subt2show = number_format(redondeado($subtotal, 3), 3, '.', '');
            $car .='<tr>';
                $car .= '<td '.$estiloCelda.' align="center">'.($j+1).'</td>';
                $car .= '<td '.$estiloCelda.'>'.$codigo_producto.'</td>';
                $car .= '<td '.$estiloCelda.' align="left">'.$nombre_producto.'</td>';
                $car .= '<td align="center" style="background:'.$codigo_color.'"></td>';
                $car .= '<td '.$estiloCelda.' align="center">'.$nombre_color.'</td>';
                $car .= '<td '.$estiloCelda.' align="center">'.$cantidad.'</td>';
                $car .= '<td '.$estiloCelda.' align="right">'.$simbolo.' '.$precio.'</td>';
                $car .= '<td '.$estiloCelda.' align="right">'.$simbolo.' '.$subt2show.'</td>';
            $car .= '</tr>'; 
            $total += $subtotal;
            $j++;
        } // foreach
        
        $cargos = cargosReserva($id_reserva);
        if(count($cargos)>0)
        {
            $subt = number_format(redondeado($total, 3), 3, '.', '');
            $car .= '<tr>';
                $car .= '<td colspan="6" '.$estiloHeader.'>';
                $car .= '</td>';
                $car .= '<td '.$estiloHeader.'><strong>SUBTOTAL</strong></td>';
                $car .= '<td '.$estiloHeader.'><strong>'.$simbolo.' '.$subt.'</strong></td>';
            $car .= '</tr>';
            
            $car .= '<tr>';
                $car .= '<td colspan="8"><h3>Cargos Adicionales</h3></td>';
            $car .= '</tr>';
            $j=0;
            foreach($cargos as $cargo)
            {
                $concepto_current = $cargo->concepto;
                $monto_current = $cargo->monto;
                $car .= '<tr>';
                $car .= '<td align="right" '.$estiloCelda.'>'.($j+1).'</td>';
                $car .= '<td align="right" colspan="6" '.$estiloCelda.'>'.$concepto_current.'</td>';
                $car .= '<td align="right" '.$estiloCelda.'>'.$simbolo.' '.$monto_current.'</td>';
                $car .= '</tr>';
                $total = $total + $monto_current;
                $j++;
            }            
        } // if
        //$total = number_format(redondeado($total, 3), 3, '.', '');
        // CAMBIADO PARA Q SE VEAN DOS DECIMALES (17/05/2017) no se cobro lo pidio Edgar
        $total = number_format(redondeado($total, 3), 2, '.', '');

        $car .= '<tr>';
            $car .= '<td colspan="6" '.$estiloHeader.'>';
            $car .= '</td>';
            $car .= '<td '.$estiloHeader.'><strong>TOTAL</strong></td>';
            $car .= '<td '.$estiloHeader.'><strong>'.$simbolo.' '.$total.'</strong></td>';
        $car .= '</tr>';
        $car .= '</table>'; 
        return $car;
    }
}

if ( ! function_exists('detallesReserva'))
{
    function detallesReserva($id_reserva) {
        $ci =& get_instance();
        $sql = "SELECT * FROM reservas_detalle WHERE id_reserva='$id_reserva'";
        $query = $ci->db->query($sql);
        return $query->result();
    }
}

if ( ! function_exists('cargosReserva'))
{
    function cargosReserva($id_reserva) {
        $ci =& get_instance();
        $sql = "SELECT * FROM cargos_adicionales WHERE id_reserva='$id_reserva'";
        $query = $ci->db->query($sql);
        return $query->result();
    }
}

if ( ! function_exists('redondeado'))
{
    function redondeado($numero, $decimales) {
        $factor = pow(10, $decimales);
        $aux = (round($numero*$factor)/$factor);
        return $aux;
    }
}

if ( ! function_exists('numeroPaginas'))
{
    function numeroPaginas($num_reservas, $reservas_x_pagina) {
        if($num_reservas % $reservas_x_pagina==0)
        {
            $num_paginas = $num_reservas / $reservas_x_pagina;
        }
        else
        {
            $num_paginas = (int)($num_reservas/$reservas_x_pagina) + 1;
        }
        return $num_paginas;
    }
}

if ( ! function_exists('tiempoRestante'))
{
	function tiempoRestante($fecha_ingreso, $caducidad) {
            $aux_hi = explode(" ", $fecha_ingreso);
            $aux_hi_2 = explode("-", $aux_hi[0]);
            $aux_hi_3 = explode(":", $aux_hi[1]);
            $time_ingreso = mktime($aux_hi_3[0], $aux_hi_3[1], $aux_hi_3[2], $aux_hi_2[1], $aux_hi_2[2], $aux_hi_2[0]);
            
            $aux_hc = explode(" ", $caducidad);
            $aux_hc_2 = explode("-", $aux_hc[0]);
            $aux_hc_3 = explode(":", $aux_hc[1]);
            $time_caducidad = mktime($aux_hc_3[0], $aux_hc_3[1], $aux_hc_3[2], $aux_hc_2[1], $aux_hc_2[2], $aux_hc_2[0]);
            $ahora = time();
            $diferencia = conversorSegundosHoras($time_caducidad - $ahora);
            return $diferencia;
	}
}

if ( ! function_exists('totalReserva'))
{
	function totalReserva($id_reserva, $moneda) {
            $ci =& get_instance();
            switch($moneda)
            {
                case "d":
                    $sql = "SELECT precio_dolares as precio, cantidad FROM reservas_detalle WHERE id_reserva='$id_reserva'";
                break;

                case "s":
                    $sql = "SELECT precio_soles as precio, cantidad FROM reservas_detalle WHERE id_reserva='$id_reserva'";
                break;
            }
            $query = $ci->db->query($sql);
            $regs = $query->result();
            $total = 0;
            foreach($regs as $reg)
            {
                $total += ($reg->cantidad)*($reg->precio);
            }
            return $total;
	}
}

if ( ! function_exists('totalCompra'))
{
	function totalCompra($id_compra, $moneda) {
            $ci =& get_instance();
            switch($moneda)
            {
                case "d":
                    $sql = "SELECT precio_dolares as precio, cantidad FROM compras_detalle WHERE id_compra='$id_compra'";
                break;

                case "s":
                    $sql = "SELECT precio_soles as precio, cantidad FROM compras_detalle WHERE id_compra='$id_compra'";
                break;
            }
            $query = $ci->db->query($sql);
            $regs = $query->result();
            $total = 0;
            foreach($regs as $reg)
            {
                $total += ($reg->cantidad)*($reg->precio);
            }
            return $total;
	}
}

if ( ! function_exists('codigosProductosCompras'))
{
	function codigosProductosCompras($id_compra) {
            $ci =& get_instance();
            $sql = "SELECT distinct codigo_producto FROM compras_detalle WHERE id_compra='$id_compra'";
            $query = $ci->db->query($sql);
            $regs = $query->result();
            $lista = array();
            foreach($regs as $reg)
            {
                $lista[] = $reg->codigo_producto;
            }
            return implode("<br>", $lista);
	}
}

if ( ! function_exists('datosCliente'))
{
	function datosCliente($id_cliente) {
            $ci =& get_instance();
            $sql = "SELECT razon_social, nombre FROM inscritos WHERE id='$id_cliente'";
            $query = $ci->db->query($sql);
            $reg = $query->row();
            $h = $query->num_rows();
            if($h>0)
            {
               $str = $reg->razon_social;
                $str.= '<br>Persona Contacto:';
                $str .= $reg->nombre;
                return $str; 
            }
            else
            {
                return 'Cliente eliminado';
            }            
	}
}

if ( ! function_exists('codigosProductosReserva'))
{
	function codigosProductosReserva($id_reserva) {
            $ci =& get_instance();
            $sql = "SELECT distinct codigo_producto FROM reservas_detalle WHERE id_reserva='$id_reserva'";
            $query = $ci->db->query($sql);
            $regs = $query->result();
            $lista = array();
            foreach($regs as $reg)
            {
                $lista[] = $reg->codigo_producto;
            }
            return implode("<br>", $lista);
	}
}

if ( ! function_exists('totalCargos'))
{
	function totalCargos($id_reserva) {
            $ci =& get_instance();
            $sql = "SELECT monto FROM cargos_adicionales WHERE id_reserva='$id_reserva'";
            $query = $ci->db->query($sql);
            $regs = $query->result();
            $total = 0;
            foreach($regs as $reg)
            {
                $total += $reg->monto;
            }
            return $total;
	}
}

if ( ! function_exists('fechasProximamente'))
{
	function fechasProximamente() {
            $ci =& get_instance();
            $sql = "SELECT DISTINCT fecha_llegada FROM stock_color WHERE stock_proximamente>0 ORDER BY fecha_llegada";
            $query = $ci->db->query($sql);
            return $query->result();
	}
}

if ( ! function_exists('formatoFechaProximamente'))
{
	function formatoFechaProximamente($fecha) {
            $aux_fecha = explode("-", $fecha);
            $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            $agno = $aux_fecha[0];
            $mes = $aux_fecha[1];
            $dia = $aux_fecha[2];
            $fecha = $dia.' de '.$meses[(int)($mes)].' del '.$agno;
            return $fecha;
	}
}

if ( ! function_exists('formatoFechaProximamente2'))
{
	function formatoFechaProximamente2($fecha) {
            $aux_fecha = explode("-", $fecha);
            $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            $agno = $aux_fecha[2];
            $mes = $aux_fecha[1];
            $dia = $aux_fecha[0];
            $fecha = $dia.' de '.$meses[(int)($mes)].' del '.$agno;
            return $fecha;
	}
}

if ( ! function_exists('getInfo'))
{
	function getInfo($seccion) {
		$ci =& get_instance();
		$ci->db->select('titulo,texto');
		$ci->db->where('seccion', $seccion);
		$query = $ci->db->get('textos_web');
		if ($query->num_rows() > 0){
			$row = $query->row();
			return $row;
		}
		return 0;
	}
}

if ( ! function_exists('formatoFechaHora'))
{
	function formatoFechaHora($fecha) {
            $aux_0 = explode(" ", $fecha);
            $aux = explode("-", $aux_0[0]);
            $agno = $aux[2];
            $mes = $aux[1];
            $dia = $aux[0];
            $fechaFormat = $agno."-".$mes."-".$dia;
            
            $aux2 = explode(":", $aux_0[1]);
            if($aux2[0]>12)
            {
                $hora = $aux2[0] - 12;
                $horaFormat = $hora.":".$aux2[1]." p.m.";
            }
            else
            {
                $horaFormat = $aux2[0].":".$aux2[1]." a.m.";
            }
            $formateada = $fechaFormat." ".$horaFormat;
            return $formateada;
	}
}

if ( ! function_exists('getConfig'))
{
	function getConfig($llave) {
		$ci =& get_instance();
		$ci->db->select('valor');
		$ci->db->where('llave', $llave);
		$query = $ci->db->get('configuracion');
		if ($query->num_rows() > 0){
			$row = $query->row();
			return $row->valor;
		}
		return 0;
	}
}

if ( ! function_exists('getColorName'))
{
	function getColorName($id_color) {
		$ci =& get_instance();
		$ci->db->select('nombre');
		$ci->db->where('id', $id_color);
		$query = $ci->db->get('colores');
		if ($query->num_rows() > 0){
			$row = $query->row();
			return $row->nombre;
		}
		return 0;
	}
}

if ( ! function_exists('getBannersClientes'))
{
	function getBannersClientes() {
		$ci =& get_instance();
		$sql = "select titulo, imagen from banner_clientes where estado='A' order by orden";
		$query = $ci->db->query($sql);
		return $query->result();
	}
}

if ( ! function_exists('getBannersUsuarios'))
{
	function getBannersUsuarios() {
		$ci =& get_instance();
		$sql = "select titulo, imagen from banner_usuarios where estado='A' order by orden";
		$query = $ci->db->query($sql);
		return $query->result();
	}
}

if ( ! function_exists('formateaCadena'))
{
	function formateaCadena($cadena) {
		$cadena = str_replace("á", "a", $cadena);
		$cadena = str_replace("é", "e", $cadena);
		$cadena = str_replace("í", "i", $cadena);
		$cadena = str_replace("ó", "o", $cadena);
		$cadena = str_replace("ú", "u", $cadena);
		$cadena = str_replace("Á", "A", $cadena);
		$cadena = str_replace("É", "E", $cadena);
		$cadena = str_replace("Í", "I", $cadena);
		$cadena = str_replace("Ó", "O", $cadena);
		$cadena = str_replace("Ú", "U", $cadena);
		$cadena = str_replace("ñ", "n", $cadena);
		$cadena = str_replace("Ñ", "N", $cadena);	
		$cadena = str_replace('"', "", $cadena);
		$cadena = str_replace("-", "", $cadena);
		$cadena = str_replace("¿", "", $cadena);
		$cadena = str_replace(",", "", $cadena);
		$cadena = str_replace("?", "", $cadena);
		$cadena = str_replace(" ", "-", $cadena);
		$cadena = str_replace("/", "-", $cadena);
		$cadena = str_replace(":", "-", $cadena);
		$cadena = str_replace("#", "N", $cadena);
		$cadena = str_replace("%", "", $cadena);
		$cadena = str_replace("'", "", $cadena);
		$cadena = str_replace("&", "", $cadena);				
		$cadena = str_replace("(", "", $cadena);
		$cadena = str_replace(")", "", $cadena);				
		$cadena = str_replace(",", "", $cadena);
		$cadena = str_replace(";", "", $cadena);                
		$cadena = strtolower($cadena);
		return $cadena;
	}
}

if ( ! function_exists('Ymd_2_dmY'))
{
	function Ymd_2_dmY($fecha) {
		$aux = explode("-", $fecha);
		$agno = $aux[0];
		$mes = $aux[1];
		$dia = $aux[2];
		$formateada = $dia."-".$mes."-".$agno;
		return $formateada;
	}
}

if ( ! function_exists('dmYHora_2_Ymd'))
{
    function dmYHora_2_Ymd($fecha) {
        $aux_0 = explode(" ", $fecha);
        $aux = explode("-", $aux_0[0]);
        $agno = $aux[2];
        $mes = $aux[1];
        $dia = $aux[0];
        $formateada = $agno."-".$mes."-".$dia;
        return $formateada;
    }
}

if ( ! function_exists('Ymd_2_dmYHora'))
{
    function Ymd_2_dmYHora($fecha) {
        $aux_0 = explode(" ", $fecha);
        $aux = explode("-", $aux_0[0]);
        $agno = $aux[0];
        $mes = $aux[1];
        $dia = $aux[2];
        $formateada = $agno."-".$mes."-".$dia;
        return $formateada;
    }
}

if ( ! function_exists('YmdHora_2_dmY'))
{
	function YmdHora_2_dmY($fecha) {
            $aux_0 = explode(" ", $fecha);
            $aux = explode("-", $aux_0[0]);
            $agno = $aux[0];
            $mes = $aux[1];
            $dia = $aux[2];
            $formateada = $dia."-".$mes."-".$agno." ".$aux_0[1];
            return $formateada;
	}
}

if ( ! function_exists('YmdHora_2_dmYHora'))
{
    function YmdHora_2_dmYHora($fecha) {
        $aux_0 = explode(" ", $fecha);
        $aux = explode("-", $aux_0[0]);
        $agno = $aux[0];
        $mes = $aux[1];
        $dia = $aux[2];
        $formateada = $dia."-".$mes."-".$agno." ".$aux_0[1];
        return $formateada;
    }
}

if ( ! function_exists('conversorSegundosHoras'))
{
    function conversorSegundosHoras($tiempo_en_segundos) {
        $horas = floor($tiempo_en_segundos / 3600);
        $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
        $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
        //return $horas . ':' . $minutos . ":" . $segundos;
        if($horas>48)
        {
            return '<span class="btn btn-success btn-xs">'.$horas . ' h y ' . $minutos.' min.</span>';
        }
        else if( ($horas<48) && ($horas>24) )
        {
            return '<span class="btn btn-warning btn-xs">'.$horas . ' h y ' . $minutos.' min.</span>';
        }
        else
        {
            return '<span class="btn btn-danger btn-xs">'.$horas . ' h y ' . $minutos.' min.</span>';
        }
    }
}

if ( ! function_exists('dmY_2_Ymd'))
{
	function dmY_2_Ymd($fecha) {
            $aux = explode("-", $fecha);
            $agno = $aux[2];
            $mes = $aux[1];
            $dia = $aux[0];
            $formateada = $agno."-".$mes."-".$dia;
            return $formateada;
	}
}

if ( ! function_exists('fecha_hoy_dmY'))
{
    function fecha_hoy_dmY() {
        $fecha = getdate();
        $dia = $fecha['mday'];
        if($dia<10) $dia="0".$dia;
        $mes = $fecha['mon'];
        if($mes<10) $mes="0".$mes;
        $agno = $fecha['year'];	
        $hoy = $dia."-".$mes."-".$agno;
        return $hoy;
    }
}

if ( ! function_exists('fecha_hoy_dmY2'))
{
    function fecha_hoy_dmY2() {
        $fecha = getdate();
        $dia = $fecha['mday'];
        if($dia<10) $dia="0".$dia;
        $mes = $fecha['mon'];
        if($mes<10) $mes="0".$mes;
        $agno = $fecha['year'];	
        $hoy = $dia."/".$mes."/".$agno;
        return $hoy;
    }
}

if ( ! function_exists('fecha_hoy_Ymd'))
{
    function fecha_hoy_Ymd() {
        $fecha = getdate();
        $dia = $fecha['mday'];
        if($dia<10) $dia="0".$dia;
        $mes = $fecha['mon'];
        if($mes<10) $mes="0".$mes;
        $agno = $fecha['year'];	
        $hoy = $agno."-".$mes."-".$dia;
        return $hoy;
    }
}

if ( ! function_exists('valRuc'))
{
    function ValidRucPeru($ruc){
        $factor= "5432765432";
        $ruc= trim($ruc);

        if ( (!is_numeric($ruc)) || (strlen($ruc) != 11) ){
            return false;
        }
        
        // verificar digitos iniciales
        $dig_valid= array("10", "20" ,"17", "15");
        $dig=substr($ruc, 0, 2);
        if (!in_array($dig, $dig_valid, true)) {
        return false;
        }
        
        $dig_verif= substr($ruc, 10, 1);
        
        for ($i=0; $i < 10; $i++){
        $arr[]= substr($ruc, $i, 1) * substr($factor, $i, 1);
        }

        $suma=0;
        foreach($arr as $a){
        $suma= $suma + $a;
        }

        //Calculamos el residuo
        $residuo= round(($suma/11),1);
        $residuo= substr($residuo, -1);
        $resta= 11 - $residuo;
        $dig_verif_aux= substr($resta, -1);

        if ($dig_verif == $dig_verif_aux){
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists('uploadImagen'))
{
    function uploadImagen($imagen) {
        if ($imagen !== '') {
            $CI =& get_instance();
            $CI->my_upload->upload($imagen);
            if ( $CI->my_upload->uploaded == true  ) {
                $CI->my_upload->allowed          = array('image/*');
                $CI->my_upload->image_resize     = true;
                $CI->my_upload->image_ratio_crop = true;
                $CI->my_upload->image_x          = 50;
                $CI->my_upload->image_y          = 50;
                $CI->my_upload->process('./files/thumbnails_fotografias/');
                
                $CI->my_upload->allowed= array('image/*');
                $CI->my_upload->image_resize     = true;
                $CI->my_upload->image_x          = 600;
                $CI->my_upload->image_ratio_y    = true;
                $CI->my_upload->process('./files/fotografias/');
                
                $CI->my_upload->allowed          = array('image/*');
                $CI->my_upload->image_resize     = true;
                $CI->my_upload->image_ratio_crop = true;
                $CI->my_upload->image_x          = 260;
                $CI->my_upload->image_y          = 260;
                $CI->my_upload->process('./files/fotografias_medianas/');        
                
                if ( $CI->my_upload->processed == true ) {
                    $nombre_imagen = $CI->my_upload->file_dst_name;
                    $CI->my_upload->clean();
                    //$result = array('nombre'=>$nombre_imagen,'msg'=>'Se subió exitosamente.');
                    $result = $nombre_imagen;
                } else {
                    //$result = array('nombre'=>'','msg'=>formateaCadena($CI->my_upload->error));
                }
            } else {
                //$result = array('nombre'=>'','msg'=>formateaCadena($CI->my_upload->error));
                $result = '';
            }
        } else {
            //$result = array('nombre'=>'','msg'=>'No se encuentra imagen.');
            $result = '';
        }
        return $result;
    }
}
?>