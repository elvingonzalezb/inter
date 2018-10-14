function recibe(action) {
       arreglo=action.split("|");
	    switch (arreglo[0]) {
			
			case "1":
				var resultado = arreglo[1];
				switch(resultado)
				{
					case "0":
						alert('Ocurrio un error. Vuelva a intentarlo despues');
					break;
					
					case "1":
						alert('Gracias por su registro');
						$("#nombre").val('');
						$("#email").val('');
					break;
				}
			break;	
			
			case "2":
				var archivo = arreglo[1];
				var ancho = arreglo[2];
				var alto = arreglo[3];
				var pic = '<a href="javascript:bigpicture(\''+archivo+'\', \''+ancho+'\', \''+alto+'\')"><img src="productos_thumbs/'+ archivo + '" border="0" class="foto_principal" /></a>';
				$('#fotos_prod_main').html(pic);
			break;
			
			case "3":

				alert("Tu suscripcion fue un EXITO, muchas Gracias...");

			break;
			
			case "4":
				var base_url=arreglo[1];
				var archivo='cotizacion';
				salta(base_url+'/'+archivo);
			break;	
			
			case "5":
				var base_url=arreglo[1];
				var archivo='cotizacion';
				salta(base_url+'/'+archivo);
			break;	
			
			case "6":
				var base_url=arreglo[1];
				var archivo='cotizacion';
				salta(base_url+'/'+archivo);
			break;				
		
	   }	   
	   
} 