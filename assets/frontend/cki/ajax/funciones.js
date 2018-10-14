function agregaVisita() {
	id_prod=$("#id_prod").val();
	parametros =id_prod;
	sw="1";	
	transaccion(sw,parametros);
}

function eliminaSesion(){
	sw="2";
	parametros = "";
	transaccion(sw,parametros);		
}

function envia_suscri(){
	suscribete=$("#suscribete").val();
	if(suscribete==''){
		alert("Debe de ingresar su Correo Electronico");
		return false;
	}else{
		result=chequea_email(suscribete);
		if(result==false){
			alert('Ingrese un Correo Electronico valido');
			$("#suscribete").focus();
			return false;
		}else{
			sw="3";
			parametros =suscribete;
/*			alert(parametros);*/
			transaccion(sw,parametros);				
		}
	}
}

function agrega_orden(id) {
	var cantidad = $("#cantidad").val();
	if(cantidad=="")
	{	
		alert('Debe ingresar la Cantidad');
		$("#cantidad").focus();
		return false;
	}
	parametros = id + '|' + cantidad;
	sw="4";	
	transaccion(sw,parametros);
}

function edita_carrito(id_prod) {
	var cantidad = $("#cantidad"+id_prod).val();
	if(cantidad=="")
	{	
		alert('Debe ingresar la Cantidad');
		$("#cantidad"+id_prod).focus();
		return false;
	}
	parametros = id_prod + '|' + cantidad;
	sw="5";	
	transaccion(sw,parametros);
}
function del_item_carrito(id_prod) {
	
	input_box=confirm("Desea eliminar este Item?");
	if (input_box==true)
	{ 
	parametros = id_prod;
	sw="6";	
	transaccion(sw,parametros);
	}
	else
	{
	return false;
	}	
}