<?php
	//header("Content-Type: text/html; charset=utf-8");
	include("../includes/aplication_top.php");
	require("../includes/class.phpmailer.php");
	include("generales_php.php");
	
	session_start();
	function getIpValue($ip){
		$ipArr = explode(".", $ip);
		$valor = $ipArr[3] + ( $ipArr[2] * 256 ) + ( $ipArr[1] * 256 * 256 ) + ( $ipArr[0] * 256 * 256 * 256 );
		return $valor;
	}	

switch ($_POST['sw']) {	

	case "1":	
		$id_prod= $_POST['parametros'];
		$sql="select nombre,foto from productos where id_prod='$id_prod'";
		$query=mysql_query($sql);
		$nombre= mysql_result($query,0,0);
		$foto= mysql_result($query,0,1);		

		$recien_vistos=$_SESSION['recien_vistos'];
		$num=count($recien_vistos);
		$valor=false;
		if($num>0){
			for($g=0;$g<$num;$g++){
				$re=$num-$g;
				if($recien_vistos[$g]['id_prod']==$id_prod && ($re<7)){
					$valor=true;
				}
			}
		}
		if($valor==false)		
		{
			$recien_vistos[]= array('id_prod' => $id_prod,'nombre' => $nombre,'foto' => $foto);				
		}
		$_SESSION['recien_vistos']=$recien_vistos;

	break;	
	
	case "2":
		
		unset($_SESSION['envio_correcto']);
		
	break;	
	
	case "3":	
		$suscribete= $_POST['parametros'];
		
		$sql="insert into suscritos (email,fecha_registro) values('$suscribete',now())";
		$query=mysql_query($sql);
//		$sql = "insert into suscritos (id, nombre, email, ip, pais, fecha_registro) ";
//		$sql .= "values ('', '$nombre', '$email', '$ip', '$pais', now());";
		$query = mysql_query($sql);
		if($query)
		{
			$correo_notificaciones = get_config('correo_notificaciones');
			$email_atencion = get_config('email_atencion');			
			//$para = 'l14307@hotmail.com';
			// ENVIO  DE MAIL DE VERIFICACION CON EL PHP MAILER
			$mail = new PHPMailer();
			$mail->From = $email_atencion; // direccion de quien envia
			$mail->FromName = 'Suscripcion en Lobos de Canoas'; // nombre de quien envia
			$mail->AddAddress($suscribete);
			$mail->AddAddress($correo_notificaciones);			
			$mail->Subject = "Suscripcion en Lobos de Canoas"; 
			$msg = "Se ha realizado la siguiente suscripcion al boletin desde el web site de Lobos de Canoas.<br>\n";
			$msg .= "===============================================================<br>\n";
			$msg .= " DATOS DEL SUSCRITO <br>\n";
			$msg .= "===============================================================<br>\n";
			//$msg .= "<b>NOMBRE : </b>".$nombre."<br />\n";
			$msg .= "<b>EMAIL : </b>".$suscribete."<br />\n";
			//$msg .= "<b>IP : </b>".$ip."<br />\n";
			//$msg .= "<b>PAIS : </b>".$pais."<br />\n";
			$msg .= "===============================================================<br />\n";		
			$mail->Body = $msg;
			$mail->IsHTML(true);
			@$mail->Send();
			// FIN DE ENVIO CON EL PHP MAILER
			echo "3";
		}

		
	break;	
	
	case "4":	
		$parametros = explode("|", $_POST['parametros']);
		$id_prod = $parametros[0];
		$cantidad = $parametros[1];
		
		if(isset($_SESSION['carrito']))
		{
			$carrito=$_SESSION['carrito'];
			if(isset($carrito[$id_prod]))
			{
			$cantidad_1=$carrito[$id_prod]['cantidad'];
			$carrito[$id_prod]['cantidad']=$cantidad_1 + $cantidad;
			}
			else
			{
			$carrito[$id_prod]= array('id_prod' => $id_prod,'cantidad' => $cantidad);
			}
		}
		else
		{
		$carrito=array();
		$carrito[$id_prod]= array('id_prod' => $id_prod,'cantidad' => $cantidad);
		}
		$_SESSION['carrito']=$carrito;
		echo "4|".BASE_URL;
	break;	
	
	case "5":	
		$parametros = explode("|", $_POST['parametros']);
		$id_prod = $parametros[0];
		$cantidad = $parametros[1];
		
		if(isset($_SESSION['carrito']))
		{
			$carrito=$_SESSION['carrito'];
			$carrito[$id_prod]['cantidad']=$cantidad;
			$_SESSION['carrito']=$carrito;
		}
		echo "5|".BASE_URL;
	break;

	case "6":	
		$id_prod = $_POST['parametros'];
		if(isset($_SESSION['carrito']))
		{
			$carrito=$_SESSION['carrito'];
			unset($carrito[$id_prod]);
			if(count($carrito)<1)
			{
			unset($_SESSION['carrito']);
			unset($_SESSION['monto']);			
			}
			else
			{
			$_SESSION['carrito']=$carrito;
			}
		}
		echo "6|".BASE_URL;
	break;	

}



?>