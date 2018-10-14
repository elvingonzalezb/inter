<?php

	function fecha_hora($datetime) {
		$aux = explode(" ", $datetime);	
		$aux2 = explode(":", $aux[1]);
		$hora = $aux2[0].':'.$aux2[1];
		$aux3 = explode("-", $aux[0]);
		$agno = $aux3[0];
		$mes = $aux3[1];
		$dia = $aux3[2];
		$fecha = $dia."-".$mes."-".$agno;
		$formateada = $hora.' <br /> '.$fecha;
		return $formateada;
	}
	
	function get_meta($seccion) {
		$sql_pr = "select * from metatags where seccion='$seccion'";
		$query_pr = mysql_query($sql_pr);
		$valor = mysql_fetch_array($query_pr);
		return $valor;
	}

	function get_info($seccion) {
		$sql_info = "select nom_tweb,info_tweb from textos_web where seccion='$seccion'";
		$query_info = mysql_query($sql_info);
		$adm_informacion = mysql_fetch_array($query_info);
		return $adm_informacion;
	}
	function get_config($llave) {
		$sql_pr = "select valor from configuracion where llave='$llave'";
		$query_pr = mysql_query($sql_pr);
		$valor = mysql_result($query_pr, 0, 0);
		return $valor;
	}	
	
	function limpia($cadena, $excepciones)
	{
		$banlist = array ( "insert", "select", "update", "delete", "distinct", "having", "truncate", "replace", "handler", "like", "procedure", "limit", "order by", "group by", "drop" );
		// Quita Mysql
		$aux = trim ( str_replace ($banlist, '', $cadena) );
		
		// Quita HTML
		$aux = strip_tags($aux, $excepciones);
		/*
		//Quita tildes y �
		$aux = str_replace("�", "&aacute;", $aux);
		$aux = str_replace("�", "&eacute;", $aux);
		$aux = str_replace("�", "&iacute;", $aux);
		$aux = str_replace("�", "&oacute;", $aux);
		$aux = str_replace("�", "&uacute;", $aux);
		$aux = str_replace("�", "&Aacute;", $aux);
		$aux = str_replace("�", "&Eacute;", $aux);
		$aux = str_replace("�", "&Iacute;", $aux);
		$aux = str_replace("�", "&Oacute;", $aux);
		$aux = str_replace("�", "&Uacute;", $aux);
		$aux = str_replace("�", "&ntilde;", $aux);
		$aux = str_replace("�", "&Ntilde;", $aux);
		$aux = str_replace('�', "", $aux);
		$aux = str_replace("'", "", $aux);		
		*/
		return $aux;
	}
	
	function Ymd_2_dmY($fecha) {
		$aux = explode("-", $fecha);
		$agno = $aux[0];
		$mes = $aux[1];
		$dia = $aux[2];
		$formateada = $dia."-".$mes."-".$agno;
		return $formateada;
	}
	function dmY_2_Ymd($fecha) {
		$aux = explode("-", $fecha);
		$agno = $aux[2];
		$mes = $aux[1];
		$dia = $aux[0];
		$formateada = $agno."-".$mes."-".$dia;
		return $formateada;
	}	
	
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
	function hoy() {
		$fecha = getdate();
		$dia = $fecha['mday'];
		if($dia<10) $dia="0".$dia;
		$mes = $fecha['mon'];
		if($mes<10) $mes="0".$mes;
		$agno = substr($fecha['year'], 2, 2);	
		$hoy = $dia.$mes.$agno;
		return $hoy;
	}
	
	function hoy_2($date) {
		$fecha = explode("-", $date);
		$dia = $fecha[2];
		//if($dia<10) $dia="0".$dia;
		$mes = $fecha[1];
		//if($mes<10) $mes="0".$mes;
		$agno = substr($fecha[0], 2, 2);
		$hoy = $dia.$mes.$agno;
		return $hoy;
	}
	
	function anti_injection($cadena) { 
		$banlist = array ( "insert", "select", "update", "delete", "distinct", "having", "truncate", "replace", "handler", "like", "procedure", "limit", "order by", "group by", "drop" );
		$aux = trim ( str_replace ($banlist, '', $cadena) );
		return $aux;
	}
	
	function formatea_url($cadena) {
		$aux = str_replace("�", "a", $cadena);

		$aux = str_replace("�", "e", $aux);
		$aux = str_replace("�", "i", $aux);
		$aux = str_replace("�", "o", $aux);
		$aux = str_replace("�", "u", $aux);
		$aux = str_replace("�", "A", $aux);
		$aux = str_replace("�", "E", $aux);
		$aux = str_replace("�", "I", $aux);
		$aux = str_replace("�", "O", $aux);
		$aux = str_replace("�", "U", $aux);
		$aux = str_replace("�", "n", $aux);
		$aux = str_replace("�", "N", $aux);	
		$aux = str_replace("'", "", $aux);	
		$aux = str_replace('"', "", $aux);
		$aux = str_replace("@", "", $aux);
		$aux = str_replace("&", "", $aux);
		$aux = str_replace("%", "", $aux);
		$aux = str_replace("#", "", $aux);
		$aux = str_replace("$", "", $aux);
		$aux = str_replace("+", "", $aux);
//		$aux = str_replace("-", "", $aux);
		$aux = str_replace("=", "", $aux);
		$aux = str_replace("*", "", $aux);
		$aux = str_replace("/", "", $aux);
		$aux = str_replace('�', "", $aux);
		$aux = str_replace(" ", "-", $aux);		
		$aux = strtolower($aux);
		return $aux;
	}

	function encuentra_http($cadena) {
	$pos = strrpos($cadena, "http");
		if ($pos===false)
		{
		return $cadena;
		}
		else
		{
		$cadena= strchr ($cadena, "http://");
		return $cadena;
		}
	}
	
	function comprobar_nombre_usuario($nombre_usuario)
	{
		//compruebo que el tama�o del string sea v�lido.
		if (strlen($nombre_usuario)<3 || strlen($nombre_usuario)>20){
		return $false;
		}
		
		//compruebo que los caracteres sean los permitidos
		$nopermitidos = "������������@#&%$+-=*1234567890-_";
		$caracter=0;
		for ($i=0; $i<strlen($nombre_usuario); $i++)
		{
			if (strrpos($nopermitidos, substr($nombre_usuario,$i,1))===false)
			{
			return false;
			}
		}
		return true;
	}

//unset($_SESSION['recien_vistos']);

	if(!isset($_SESSION['recien_vistos']))
	{
		$recien_vistos=array();
		$_SESSION['recien_vistos']=$recien_vistos;
	}
	
	
		
?>