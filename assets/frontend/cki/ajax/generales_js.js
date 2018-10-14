	$(document).ready(function() {
							   
		$('#menu ul li').hover(
			   function () {
					 $(this).find('a').addClass("hover");
					 $(this).find('div a').removeClass("hover");
					 $(this).find('div').fadeIn();
				}, 
				function () 
				{
					$(this).find('a').removeClass("hover");
					$(this).find('div').fadeOut();	 
				}
		);

	});



function valida_search() {
	frase = $("#frase").val();	
	if(frase=="")
	{
		alert('Debe ingresar una frase de busqueda');	
		$("#frase").focus();
		return false;
	}
}

function toglea() {
	frase = $("#frase").val();
	if(frase=="Ingrese su frase de busqueda")
	{
		$("#frase").val('');
	}
	else
	{
		
	}
}

function vacia() {
	frase = $("#frase").val();
	if(frase=="")
	{
		$("#frase").val('Ingrese su frase de busqueda');
	}
}

function avisa(indice) {
	alert(indice)	
}

function scroll_a(indice) {
	//alert(indice);
	$('.SlideTab').tabSwitch('moveTo',{index : indice}, DoSomething());
}

function DoSomething() {

}

function ImgPopUp(string, width, height)
{
	var winl = (screen.width-width)/2;
  	var wint = (screen.height-height)/2;
	eval('window.open(\'popup.php?file='+string+'\', \'ImgPopUpWin\', \'scrollbars=no, status=no, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}

function posicion(fila, columna) {
	var result = 4*(fila - 1) + columna;
	return result;
}

function gana_foco(objeto) {
	objeto.className = "campo_contacto_focus";
}

function pierde_foco(objeto) {
	objeto.className = "campo_contacto";
}

function ilumina(objeto) {
	var clase = objeto.className;
	switch(clase)
	{
		case "ficha_cliente":
			objeto.className = "ficha_cliente_over";
		break;

		case "ficha_cliente_over":
			objeto.className = "ficha_cliente";
		break;
	}
}

function salta(url) {
	window.location = url;	
	document.location.href = url;
}

function show_video(id) {
	$.nyroModalSettings({
		bgColor: '#333',
		width: 644,
		height: 364,
		type: 'iframe',
		forceType: 'iframe'
	});
	$.nyroModalManual({
		url: 'mostrar_video.php?id='+id
	});
}

function show_asamblea(id) {
	$.nyroModalSettings({
		bgColor: '#333',
		width: 644,
		height: 364,
		type: 'iframe',
		forceType: 'iframe'
	});
	$.nyroModalManual({
		url: 'mostrar_asamblea.php?id='+id
	});
}

function cambia_pic(foto) {
	str = '<img src="prods/'+foto+'" />';
	document.getElementById("fotos_izq").innerHTML = str;
}

function cambia_pic_oferta(foto) {
	str = '<img src="ofertaspics/'+foto+'" />';
	document.getElementById("fotos_izq").innerHTML = str;
}



var muestra;
function makeArray(n){this.length = n;
for (i=1;i<=n;i++){this[i]=0;}
return this;}

function Muestrafecha() {
//arreglo de los meses
var meses = new makeArray(12);
meses[0]  = "Enero";
meses[1]  = "Febrero";
meses[2]  = "Marzo";
meses[3]  = "Abril";
meses[4]  = "Mayo";
meses[5]  = "Junio";
meses[6]  = "Julio";
meses[7]  = "Agosto";
meses[8]  = "Septiembre";
meses[9]  = "Octubre";
meses[10] = "Noviembre";
meses[11] = "Diciembre";

//arreglo de los dias
var dias_de_la_semana = new makeArray(7);
dias_de_la_semana[0]  = "Domingo";
dias_de_la_semana[1]  = "Lunes";
dias_de_la_semana[2]  = "Martes";
dias_de_la_semana[3]  = "Mi&eacute;rcoles";
dias_de_la_semana[4]  = "Jueves";
dias_de_la_semana[5]  = "Viernes";
dias_de_la_semana[6]  = "S&aacute;bado";

var today = new Date();
var day   = today.getDate();
var month = today.getMonth();
var year  = today.getYear();
var dia = today.getDay();
if (year < 1000) {year += 1900; }

// mostrar la fecha
return( "Hoy es " + dias_de_la_semana[dia] + ", " + day + " de " + meses[month] + " del " + year);
}

function bigpicture(archivo, ancho, alto) {
	
	$.nyroModalSettings({
		bgColor: '#000',
		width: ancho,
		height: alto,
		type: 'image',
		forceType: 'image',
		addImageDivTitle: true
	});
	$.nyroModalManual({
		url: 'foto_clasificado/'+archivo
	});
}


function vacioMsg()
{
	$("#msgAlerta").fadeOut(1000);
	
}

function chequea_email(emailStr) {
	if(emailStr=="")
	{
		return false;
	}	
	/* Verificar si el email tiene el formato user@dominio. */
	var emailPat=/^(.+)@(.+)$/ 
	/* Verificar la existencia de caracteres. ( ) < > @ , ; : \ " . [ ] */
	var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]" 
	/* Verifica los caracteres que son válidos en una dirección de email */
	var validChars="\[^\\s" + specialChars + "\]" 
	var quotedUser="(\"[^\"]*\")" 
	/* Verifica si la dirección de email está representada con una dirección IP Válida */ 
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
	/* Verificar caracteres inválidos */ 
	var atom=validChars + '+'
	var word="(" + atom + "|" + quotedUser + ")"
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
	//domain, as opposed to ipDomainPat, shown above. */
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
	var matchArray=emailStr.match(emailPat)
	if (matchArray==null)
	{
		return false
	}
	var user=matchArray[1]
	var domain=matchArray[2]
	// Si el user "user" es valido 
	if (user.match(userPat)==null)
	{
		// Si no
		return false
	}
	/* Si la dirección IP es válida */
	var IPArray=domain.match(ipDomainPat)
	if (IPArray!=null)
	{
		for (var i=1;i<=4;i++)
		{
			if (IPArray[i]>255)
			{
			return false
			}
		}
		//return true
	}
	var domainArray=domain.match(domainPat)
	if (domainArray==null)
	{
		return false
	}
	var atomPat=new RegExp(atom,"g")
	var domArr=domain.match(atomPat)
	var len=domArr.length
	if (domArr[domArr.length-1].length<2 || domArr[domArr.length-1].length>3) 
	{
		return false
	}
	if (len<2)
	{
		return false
	}
	return true;
}// JavaScript Document