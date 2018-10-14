// JavaScript Document
// JavaScript Document
function CreateObjetoAjax() {
	var Objeto;
		var browser = navigator.appName;
		if(browser == "Microsoft Internet Explorer"){
			Objeto = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
			Objeto = new XMLHttpRequest();
		}
			return Objeto
 }
 /* function transaccion(action) {
	var HTTP = CreateObjetoAjax();
	 HTTP.open("get", "server.php?action="+action);
     HTTP.onreadystatechange=function() { 
   				if (HTTP.readyState==4) { 
   						recibe(HTTP.responseText); 
   				} 
  		} 
       HTTP.send(null);
}*/
 function transaccion(sw,parametros) {
	var HTTP = CreateObjetoAjax();
	 HTTP.open("POST", "ajax/server.php",true);//aparte de mandar con el Post
	                                                   //tambien mandamos en la url una 
													   //variable que puede ser tratada como get 
	 HTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded')
	 //HTTP.send('variable='+action);//asi se menda una sola variable
	 HTTP.send('sw=' + sw + '&parametros=' + parametros);//asi se manda varias variables
	 HTTP.onreadystatechange=function() { 
	            
   				if (HTTP.readyState==4) { 
   						recibe(HTTP.responseText); //aqui recibo el mensaje
						
				}
  		} 
       
}