
$(document).ready(function(){ 
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
    
    $("li.hasSubmenu").hover(
        function() {
            $("ul.subMenu", this).stop().show(1200);
        }, 
        function() {
            $("ul.subMenu", this).stop().hide(1400);
        }
    );
    $(function() {
    $('.nyroModal').nyroModal();
    });

	$("input[name='cat_regis']:checkbox").click(function()
	{
		
		/*checkso = $("input[name='cat_regis']");*/
		str='';
		conta=0;
		$("input[name='cat_regis']:checked").each(function()
		{
				if(conta==0)
				{
					str=$(this).val();
				}
				else
				{
					str=str+'#'+$(this).val();
				}
				conta=conta+1;
			
		})
		
		$("#preferencias").val(str);
	})
    
  var default_value = $("#search .nice_search").val(); 

  $("#search .nice_search").focus(function() { 
    if($("#search .nice_search").val() == default_value) $("#search .nice_search").attr("value",""); 
  }); 
  $("#search .nice_search").blur(function() { 
    if($("#search .nice_search").val() == "") $("#search .nice_search").attr("value",default_value); 
  }); 
  
  var default_value2 = $("#newsletter-value").val(); 
  
  $("#newsletter-value").focus(function() { 
    if($("#newsletter-value").val() == default_value2) $("#newsletter-value").attr("value",""); 
  }); 
  $("#newsletter-value").blur(function() { 
    if($("#newsletter-value").val() == "") $("#newsletter-value").attr("value",default_value2); 
  }); 
  
  $('#wrap-categories .expanded').click(function() {
    if($("ul#category-menu").css("display") == 'none'){
      $('#wrap-categories .expanded').css("background", "url(images/cat-expanded-icon.png) no-repeat center center");
      $("ul#category-menu").show();
    }
    else{
      $('#wrap-categories .expanded').css("background", "url(images/cat-collapsed-icon.png) no-repeat center center"); 
      $("ul#category-menu").hide();
    }
  });
  
  $("ul#category-menu li").click(

/*    function () {
      if( $(this).find("ul.subcategory").length > 0){
        var status = $(this).find("ul.subcategory").css("display");
        if(status == "none"){
          $(this).find('a.extends').css("background", "#EEB900 url(images/submenu-arrow.png) no-repeat 210px center"); 
          $(this).find('a.extends').css("color", "#363031"); 
          $(this).find("ul.subcategory").css("display","block");
        }
        else{
          $(this).find('a.extends').css("background", "#2A2A2A url(images/cat-menu-arrow.png) no-repeat 210px center"); 
          $(this).find('a.extends').css("color", "#ffffff"); 
          $(this).find("ul.subcategory").css("display","none");
        }
      }
		return false;
    }*/
  );

  $('.wrap-tabs .tabs a').click(function(){
       $('.wrap-tabs .tabs a').removeClass('active');
       $(this).addClass('active');
       $('.wrap-tabs-content div').css('display','none');
       $('.wrap-tabs-content #'+$(this).attr('id')+'-content').css('display','block');
      return false;
  });
  
  	/*PREVIEW FUNCTION ONLY FOR LINKS *//*
  	$('#block-product-list a, #inline-product-list a').click(function(){
	 	document.location = '4_interior_product_view.html'; 
		return false;
	});
  	$('.add-quantity input, .addcart').click(function(){
	 	document.location = '5_interior_shopping_cart.html'; 
		return false;
	});
  	$('.checkout, .continue, .cart-summarry a').click(function(){
	 	document.location = '7_interior_checkout_step1.html'; 
		return false;
	});*/
  
        /***************** NOVEDAD *******************/  
        $(".prodNove").hide();
        novedades_inicio=$("#novedades_inicio").val();
        numero_paginas=$("#numero_paginas").val();        
        for(e=0;e<novedades_inicio;e++){
            $(".prodNove:eq("+e+")").fadeIn(500);
        } 
        str='Pagina 1 de '+numero_paginas;
        $("#wrap-pages .left").html(str);
        
        // configuracion de las flecha NEXT
        //alert(numero_paginas);
        if(1==numero_paginas){
            strhref='javascript:muestra_novedad(1,'+novedades_inicio+')';
        }else{
            strhref='javascript:muestra_novedad(2,'+novedades_inicio+')';       
        }
        $(".next-button").attr('href',strhref);        
        
        
        /***************** OFERTA *******************/
        $(".prodOfer").hide();
        ofertas_inicio=$("#ofertas_inicio").val();
        numero_paginas_oferta=$("#numero_paginas_oferta").val();        
        for(e=0;e<ofertas_inicio;e++){
            $(".prodOfer:eq("+e+")").fadeIn(500);
        } 
        str='Pagina 1 de '+numero_paginas_oferta;
        $("#wrap-pages .left").html(str);
        
        // configuracion de las flecha NEXT
        if(1==numero_paginas_oferta){
            strhref='javascript:muestra_oferta(1,'+ofertas_inicio+')';
        }else{
            strhref='javascript:muestra_oferta(2,'+ofertas_inicio+')';       
        }
        $(".next-button-oferta").attr('href',strhref);          
});

function goProductos() {
    alert('qui');
}

function modificarReserva(id_reserva) {
    $('#tituloModal').html('Esta a punto de modificar esta reserva!');
    $('#cuerpoModal').html('<p>Recuerde que solo puede modificar la cantidad de unidades de los productos que tiene <br>en su reserva (aumentar o disminuir las cantidades) o quitar items de la misma.</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="reservas/modificar/'+id_reserva+'" class="btn-ventana-modal">MODIFICAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function submitFormulario(operacion) {
    $("#operacion").val(operacion);
    //alert(operacion);
    $("form#formPedido").submit();
}

function eliminaItemReserva(id) {
    resp = confirm('Esta a punto de eliminar este Item de su Reserva. Esta seguro que quiere hacerlo?');
    if(resp)
    {
        quitaItemReserva(id);
    }
}

function quitaItemReserva(id) {
    $("#cant_"+id).val(0);
    $("#fila_"+id).hide();
}

function actualizaItemReserva(id) {
    cantidad = $("#cant_"+id).val();
    stock = $("#stock_"+id).val();
    cantidad_actual = $("#cant_actual_"+id).val();
    if(cantidad>cantidad_actual)
    {
        aux = cantidad - cantidad_actual;
        diferencia = parseInt(aux);
        if(diferencia>stock)
        {
            nombre = $("#nombre_"+id).html();
            color = $("#color_"+id).html();
            alert('La cantidad ingresada de '+nombre+' de color '+color+' excede al stock existente actualmente. Modifique esa cantidad');
            $("#cant_"+id).val(cantidad_actual);
            //return false;
        } // if
    } // if
    else
    {
        alert('Cantidad actualizada');
    }
}

function salta(url) {
    window.location = url;	
    document.location.href = url;
}

function concatena(id)
{
    id_eliminar = $("#elegidos").val();
    if(id_eliminar==="")
    {
        str = id;
    }
    else
    {
        //alert(id_eliminar);
        id=$("#"+id).val();
        if($("#"+id).is(':checked')===false){
                cad=id_eliminar.split("##");
                rt=cad.length;
                cont2=0;
                for(e=0;e<rt;e++){
                        id_1=cad[e];
                        if(id!==id_1){
                                cont2+=1;
                                if(cont2===1){
                                        str=id_1;
                                }else{
                                        str=str+'##'+id_1;
                                }
                        }
                }
                if(cont2===0){str='';}
        }else{
                if(id_eliminar===''){
                        str=id;								
                }else{
                        str=id_eliminar+'##'+id;
                }
        }
    }
    $("#elegidos").val(str);    
}

function validaMultiple() {
    elegidos = $("#elegidos").val();
    if(elegidos=="")
    {
        alert('Debe elegir las reservas que desea comprar');
        return false;
    }
}
 
function showOpcionesCompra(forma_pago) {
    $(".filaOculta").hide();
    switch(forma_pago)
    {
        case "transferencia":
          $(".grp_1").show();  
          $(".grp_2").show();
          $(".grp_3").show();
        break;
        
        case "deposito":
          $(".grp_1").show();  
          $(".grp_2").show();
          $(".grp_3").show();
        break;
    }
}

function valida_anulacion_reserva() {
    observaciones = $("#observaciones").val();
    if(observaciones=="")
    {
        alert('Debe ingresar las razones de la anulacion de su reserva.');
        $("#observaciones").focus();
        return false;
    }
}

function validaFechaDDMMAAAA(fecha){
    var dtCh= "-";
    var minYear=1900;
    var maxYear=2100;
    function isInteger(s){
            var i;
            for (i = 0; i < s.length; i++){
                    var c = s.charAt(i);
                    if (((c < "0") || (c > "9"))) return false;
            }
            return true;
    }
    function stripCharsInBag(s, bag){
        var i;
        var returnString = "";
        for (i = 0; i < s.length; i++){
                var c = s.charAt(i);
                if (bag.indexOf(c) == -1) returnString += c;
        }
        return returnString;
    }
    function daysInFebruary (year){
        return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
    }
    function DaysArray(n) {
        for (var i = 1; i <= n; i++) {
                this[i] = 31
                if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
                if (i==2) {this[i] = 29}
        }
        return this
    }
    function isDate(dtStr){
        var daysInMonth = DaysArray(12)
        var pos1=dtStr.indexOf(dtCh)
        var pos2=dtStr.indexOf(dtCh,pos1+1)
        var strDay=dtStr.substring(0,pos1)
        var strMonth=dtStr.substring(pos1+1,pos2)
        var strYear=dtStr.substring(pos2+1)
        strYr=strYear
        if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
        if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
        for (var i = 1; i <= 3; i++) {
                if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
        }
        month=parseInt(strMonth)
        day=parseInt(strDay)
        year=parseInt(strYr)
        if (pos1==-1 || pos2==-1){
                return false
        }
        if (strMonth.length<1 || month<1 || month>12){
                return false
        }
        if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
                return false
        }
        if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
                return false
        }
        if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
                return false
        }
        return true
    }
    if(isDate(fecha)){
            return true;
    }else{
            return false;
    }
}

function valida_compra() {
    forma_pago = $("#forma_pago").val();
    if(forma_pago=="0")
    {
        alert('Debe elegir la forma de pago');
        $("#forma_pago").focus();
        return false;
    }
    switch(forma_pago)
    {
        case "transferencia":
        case "deposito":
            banco = $("#banco").val();
            if(banco=="0")
            {
                alert('Debe elegir el Banco donde realizo el pago');
                $("#banco").focus();
                return false;
            }  
            numero_operacion = $("#numero_operacion").val();
            /*
            if(numero_operacion=="")
            {
                alert('Debe ingresar el numero de operacion o de transferencia');
                $("#numero_operacion").focus();
                return false;
            }
            */
                      
        break;
    } // switch
    fecha_pago = $("#fecha_pago").val();
    if(fecha_pago=="")
    {
        alert('Debe ingresar la fecha de pago');
        $("#fecha_pago").focus();
        return false;
    }  
    if(isValidDate(fecha_pago)==false)
    {
        alert('Debe ingresar una fecha de pago correcto');
        $("#fecha_pago").focus();
        return false;
    }
} 

function isValidDate(dateString)
{
    // First check for the pattern
    //var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;
    var regex_date = /^\d{1,2}\-\d{1,2}\-\d{4}$/;

    if(!regex_date.test(dateString))
    {
        return false;
    }

    // Parse the date parts to integers
    var parts   = dateString.split("-");
    var day     = parseInt(parts[0], 10);
    var month   = parseInt(parts[1], 10);
    var year    = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
    {
        return false;
    }

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    {
        monthLength[1] = 29;
    }

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
}

function validaAgregado() {
    lista_ids = $("#lista_ids").val();
    aux = lista_ids.split("#");
    hay = false;
    for(i=0; i<aux.length; i++)
    {
        id_c = aux[i];
        aux_stock_current = $("#stock_"+id_c).val();
        stock_current = parseInt(aux_stock_current);
        aux_cantidad_ingresada = $("#cant_"+id_c).val();
        cantidad_ingresada = parseInt(aux_cantidad_ingresada);
        if(cantidad_ingresada>0)
        {
            hay = true;
        }
        if(cantidad_ingresada > stock_current)
        {
            nombre_color = $("#nombre_color_"+id_c).val();
            alert('La cantidad ingresada de ' + nombre_color + ' es superior al stock existente');
            return false;
        }
    }
    if(hay==false)
    {
        alert('Debe agregar al menos una cantidad');
        return false;
    }
}

function validaAgregadoProx() {
    lista_ids = $("#lista_ids_prox").val();
    aux = lista_ids.split("#");
    hay = false;
    for(i=0; i<aux.length; i++)
    {
        id_c = aux[i];
        aux_stock_current = $("#stock_p_"+id_c).val();
        stock_current = parseInt(aux_stock_current);
        aux_cantidad_ingresada = $("#cant_p_"+id_c).val();
        cantidad_ingresada = parseInt(aux_cantidad_ingresada);
        if(cantidad_ingresada>0)
        {
            hay = true;
        }
        if(cantidad_ingresada > stock_current)
        {
            nombre_color = $("#nombre_color_p_"+id_c).val();
            alert('La cantidad ingresada de ' + nombre_color + ' es superior al stock existente');
            return false;
        }
    }
    if(hay==false)
    {
        alert('Debe agregar al menos una cantidad');
        return false;
    }
}

function checkIt(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "This field accepts numbers only.";
        return false;
    }
    status = "";
    return true;
}

function muestra_novedad(pagina,elementos){
     $(".prodNove").hide();
     pagina=parseInt(pagina);
     elementos=parseInt(elementos);
     indice_inicial = elementos * ( pagina - 1 );
     limite=indice_inicial+elementos;
     for(e=indice_inicial;e<limite;e++){
         $(".prodNove:eq("+e+")").fadeIn(500);
     }
     
    numero_paginas=$("#numero_paginas").val();  
    novedades_inicio=$("#novedades_inicio").val();
        
    str='Pagina '+pagina+' de '+numero_paginas;
    $(".wrap-pages .left").html(str);
    
    for(x=1;x<=numero_paginas;x++){
        $("#pagi_"+x).removeClass('active');
    }        
    $("#pagi_"+pagina).addClass('active');
    
    // configuracion de las flecha PREV
    
    if(pagina===1){
        strhref='javascript:muestra_novedad(1,'+novedades_inicio+')';
    }else{
        strhref='javascript:muestra_novedad('+(pagina-1)+','+novedades_inicio+')';       
    }
    $(".previous-button").attr('href',strhref);
    
    
    // configuracion de las flecha NEXT

    if(pagina==numero_paginas){
        strhref='javascript:muestra_novedad('+pagina+','+novedades_inicio+')';
    }else{
        strhref='javascript:muestra_novedad('+(pagina+1)+','+novedades_inicio+')';       
    }
    $(".next-button").attr('href',strhref);
    
}

function muestra_oferta(pagina,elementos){
     $(".prodOfer").hide();
     pagina=parseInt(pagina);
     elementos=parseInt(elementos);
     indice_inicial = elementos * ( pagina - 1 );
     limite=indice_inicial+elementos;
     for(e=indice_inicial;e<limite;e++){
         $(".prodOfer:eq("+e+")").fadeIn(500);
     }
     
    numero_paginas_oferta=$("#numero_paginas_oferta").val();  
    ofertas_inicio=$("#ofertas_inicio").val();
        
    str='Pagina '+pagina+' de '+numero_paginas_oferta;
    $(".wrap-pages-oferta .left").html(str);
    
    for(x=1;x<=numero_paginas_oferta;x++){
        $("#pagi_ofer_"+x).removeClass('active');
    }        
    $("#pagi_ofer_"+pagina).addClass('active');
    
    // configuracion de las flecha PREV
    if(pagina==1){
        strhref='javascript:muestra_oferta(1,'+ofertas_inicio+')';
    }else{
        strhref='javascript:muestra_oferta('+(pagina-1)+','+ofertas_inicio+')';       
    }
    $(".previous-button-oferta").attr('href',strhref);
    
    
    // configuracion de las flecha NEXT
    if(pagina==numero_paginas_oferta){
        strhref='javascript:muestra_oferta('+pagina+','+ofertas_inicio+')';
    }else{
        strhref='javascript:muestra_oferta('+(pagina+1)+','+ofertas_inicio+')';       
    }
    $(".next-button-oferta").attr('href',strhref);
    
}

$(window).load(function() {
    $('#slider').nivoSlider();
});

function bigpicture(archivo) {
    
        $.nyroModalSettings({
                bgColor: '#000',
                width: null,
                height: null,
                type: 'img',
                forceType: 'img',
                addImageDivTitle: true
        });
        
        $.nyroModalManual({
                url: 'files/modal/'+archivo
        });

}

$(function() {
  /*
  $('img.image0').data('ad-desc', '<strong>Disfrute !</strong> de la <strong>Galería</strong> de Fotos por Producto');
  var galleries = $('.ad-gallery').adGallery();
  $('#switch-effect').change(
    function() {
      galleries[0].settings.effect = fade;
      return false;
    }
  );
  $('#toggle-slideshow').click(
    function() {
      galleries[0].slideshow.toggle();
      return false;
    }
  );
  $('#toggle-description').click(
    function() {
      if(!galleries[0].settings.description_wrapper) {
        galleries[0].settings.description_wrapper = $('#descriptions');
      } else {
        galleries[0].settings.description_wrapper = false;
      }
      return false;
    }
  );
    */
});

function validacorreo(){
	nombre = $("#nombre").val();
	if(nombre==""){
		alert('Debe ingresar su nombre y apellido');
		$("#nombre").focus();
		return false;
	}
	
	email = $("#email").val();
	result=chequea_email(email);
	if(email==""){
            alert('Debe ingresar su Email');
            $("#email").focus();
            return false;
	}else{
            if(result==false){
            alert('Ingrese un Email valido');
            $("#email").focus();
            return false;
            }
	}

	telefono = $("#telefono").val();
	if(telefono==""){
		alert('Debe ingresar el telefono');
		$("#telefono").focus();
		return false;
	}	
	
	ciudad = $("#ciudad").val();
	if(ciudad==""){
		alert('Debe ingresar su Ciudad');
		$("#ciudad").focus();
		return false;
	}
	empresa = $("#empresa").val();
	if(empresa==""){
		alert('Debe ingresar la empresa');
		$("#empresa").focus();
		return false;
	}	
	rubro= $("#rubro").val();
	if(rubro==""){
		alert('Debe ingresar su rubro');
		$("#rubro").focus();
		return false;
	}
	mensaje = $("#mensaje").val();
	if(mensaje==""){
		alert('Debe ingresar el mensaje');
		$("#mensaje").focus();
		return false;
	}				
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

function valida_registro(){
	razon_social = $("#razon_social").val();
	if(razon_social==""){
		alert('Debe ingresar la Razon Social');
		$("#razon_social").focus();
		return false;
	}
	
	ruc= $("#ruc").val();
	if(ruc==""){
		alert('Debe ingresar la Razon Social');
		$("#ruc").focus();
		return false;
	}else if(ruc.length!=11){
            alert('El RUC debe tener solo 11 digitos');
            $("#ruc").focus();
            return false;            
        }
	
	nombre = $("#nombre").val();
	if(nombre==""){
		alert('Debe ingresar el nombre');
		$("#nombre").focus();
		return false;
	}
	
	cargo = $("#cargo").val();
	if(cargo==""){
		alert('Debe ingresar el cargo');
		$("#cargo").focus();
		return false;
	}
	
	domicilio = $("#domicilio").val();
	if(domicilio==""){
		alert('Debe ingresar el domicilio');
		$("#domicilio").focus();
		return false;
	}
	

	
	
	pais = $("#pais").val();
	if(pais==0){
		alert('Debe seleccionar un pais');
		$("#pais").focus();
		return false;
	}
        
	if(pais=='PE'){
            provincia = $("#provincia").val();
            departamento = $("#departamento").val();        
            ciudad = $("#ciudad").val();            
            distrito = $("#distrito").val();
            ruc = $("#ruc").val();
            if(provincia=="" || departamento=="" || ciudad=="" || distrito=="" || ruc==""){
                    alert('Debe complete los datos basicos para Peru (Ruc, Provincia, Departamento, Ciudad, Distrito)');
                    $("#ruc").focus();
                    return false;
            }
        }
        
	zip = $("#zip").val();
	if(zip==""){
		alert('Debe ingresar el codigo postal');
		$("#zip").focus();
		return false;
	}
	
	telefono = $("#telefono").val();
	if(telefono==""){
		alert('Debe ingresar el telefono');
		$("#telefono").focus();
		return false;
	}
	
	tipo_cliente = $("#tipo_cliente").val();
	if(tipo_cliente==""){
		alert('Debe seleccionar el tipo de cliente');
		$("#tipo_cliente").focus();
		return false;
	}	
	
	email = $("#email").val();
	result=chequea_email(email);
	if(email==""){
            alert('Debe ingresar su Email');
            $("#email").focus();
            return false;
	}else{
            if(result==false){
            alert('Ingrese un Email valido');
            $("#email").focus();
            return false;
            }
	}
	
	password = $("#password").val();
	if(password==""){
		alert('Debe ingresar el password');
		$("#password").focus();
		return false;
	}	
	
	email_rep = $("#email_rep").val();
	if(email_rep != email){
		alert('El email no coincide !');
		$("#email_rep").focus();
		return false;
	}
	
	password_rep = $("#password_rep").val();
	if(password_rep != password){
		alert('El password no coincide !');
		$("#passwrod_rep").focus();
		return false;
	}		
	
	codigo= $("#codigo").val();
	if(codigo==""){
            alert('Debe ingresar el codigo que visualiza en la imagen !');
            $("#codigo").focus();
            return false;
	}	
			
}

function valida_actualizacion(){
    
	razon_social = $("#razon_social").val();
	if(razon_social==""){
		alert('Debe ingresar la Razon Social');
		$("#razon_social").focus();
		return false;
	}
	
	ruc = $("#ruc").val();
	if(ruc==""){
		alert('Debe ingresar el ruc');
		$("#ruc").focus();
		return false;
	}
	
	nombre = $("#nombre").val();
	if(nombre==""){
		alert('Debe ingresar el nombre');
		$("#nombre").focus();
		return false;
	}
	
	cargo = $("#cargo").val();
	if(cargo==""){
		alert('Debe ingresar el cargo');
		$("#cargo").focus();
		return false;
	}
	
	domicilio = $("#domicilio").val();
	if(domicilio==""){
		alert('Debe ingresar el domicilio');
		$("#domicilio").focus();
		return false;
	}
	
	ciudad = $("#ciudad").val();
	if(ciudad==""){
		alert('Debe ingresar la ciudad');
		$("#ciudad").focus();
		return false;
	}
	
	provincia = $("#provincia").val();
	if(provincia==""){
		alert('Debe ingresar la provincia');
		$("#provincia").focus();
		return false;
	}
	
	departamento = $("#departamento").val();
	if(departamento==""){
		alert('Debe ingresar el departamento');
		$("#departamento").focus();
		return false;
	}	
	
	pais = $("#pais").val();
	if(pais==0){
		alert('Debe seleccionar un pais');
		$("#pais").focus();
		return false;
	}
	
	zip = $("#zip").val();
	if(zip==""){
		alert('Debe ingresar el codigo postal');
		$("#zip").focus();
		return false;
	}
	
	telefono = $("#telefono").val();
	if(telefono==""){
		alert('Debe ingresar el telefono');
		$("#telefono").focus();
		return false;
	}
	
	tipo_cliente = $("#tipo_cliente").val();
	if(tipo_cliente==""){
		alert('Debe seleccionar el tipo de cliente');
		$("#tipo_cliente").focus();
		return false;
	}	
	
//    	password = $("#password").val();
//    	new_pass = $("#new_pass").val();
//    	rep_new_pass = $("#rep_new_pass").val();        
//	
//	
//	if(rep_new_pass != new_pass){
//            if(password==""){
//                    alert('Debe ingresar el password');
//                    $("#password").focus();
//                    return false;
//            }            
//            alert('El password no coincide !');
//            $("#new_pass").focus();
//            return false;
//	}		
			
}

function valida_recordar(){

    email = $("#email").val();
    result=chequea_email(email);
    if(email==""){
        alert('Debe ingresar su Correo Electronico');
        $("#email").focus();
        return false;
    }else{
        if(result==false){
        alert('Ingrese un Correo Electronico valido');
        $("#email").focus();
        return false;
        }
    }
    
}

function valida_log() {
    email = $("#usuario_ini").val();
    result=chequea_email(email);
    password = $("#password_ini").val();
    if(email==="")
    {
        alert('Debe ingresar su Usuario');
        $("#email").focus();
        return false;
    }
    else if(result===false)
    {
        alert('Ingrese un Email valido');
        $("#email").focus();
        return false;
    }
    else if(password==="")
    {
        alert('Debe ingresar su password');
        $("#password").focus();
        return false;
    }
    else
    {
        $('input[type="submit"]').attr('disabled','disabled');  
        $("#btnEnviar").hide();
    }
}

function valida_inicio() {
    email = $("#usuario").val();
    result=chequea_email(email);
    password = $("#password").val();
    if(email==="")
    {
        alert('Debe ingresar su Usuario');
        $("#email").focus();
        return false;
    }
    else if(result===false)
    {
        alert('Ingrese un Email valido');
        $("#email").focus();
        return false;
    }
    else if(password==="")
    {
        alert('Debe ingresar su password');
        $("#password").focus();
        return false;
    }
    else
    {
        $('input[type="submit"]').attr('disabled','disabled');
        $("#btnEnviar").hide();
    }
}

function pedido_modal(id){
		$.nyroModalSettings({
			bgColor: '#000',
			width: null,
			height: null,
			type: 'iframe',
			forceType: 'iframe',
			addImageDivTitle: true
		});
		
		$.nyroModalManual({
			url: 'pedido/'+id
		});	
}

function valida_envio_pedido(){
	num_colores=$("#num_colores").val();

	indi=0;
	for(r=0;r<num_colores;r++){
		cant=$("#cant_"+r).val();
		if(cant!=''){
			indi=1;
		}
	}
	if(indi==0){
		alert("Ingrese la cantidad por color");
		return false;
	}
}

function pregunta() {
    input_box=confirm("¿Desea enviar el pedido?");
    if (input_box===true)
    {
        $('input[type="submit"]').attr('disabled','disabled'); 
    }
    else
    {
        return false;
    }
}

function showReserva() {
    //$("#formCompra").hide();
    $("#formReserva").show();
    $.scrollTo('#tituloFormReserva', 500);
}

function showCompra() {
    $("#formCompra").show();
    $("#formReserva").hide();
}

function preguntaReserva(horas) {
    input_box=confirm("Esta seguro que desea reservar los productos elegidos?\nRecuerde que tiene "+horas+" horas para concretar su compra o su reserva se eliminara");
    if (input_box===true)
    {
        $('input[type="submit"]').attr('disabled','disabled'); 
    }
    else
    {
        return false;
    }    
}

function ver_foto_grande(archivo,nombre) {
	$('#tituloModal').html(nombre);
	img = '<img src="files/fotografias/'+archivo+'" />';
	$('#cuerpoModal').html(img);
	$('#botoneraModal').hide();
	$('#myModal').modal('show'); 
}


function ver_foto_principal(archivo,empaque,nombre) {
	$('#tituloModal').html(nombre);
	
        str = '<img src="files/thumbnails_fotografias/'+archivo+'" class="picChica" onclick="cambiaPic(\''+archivo+'\')" />';
        if(empaque!="")
        {
            str += '<img src="files/thumbnails_fotografias/'+empaque+'" class="picChica" onclick="cambiaPic(\''+empaque+'\')" />';
        }        
        str += '<div id="picGrandeModal"><img src="files/fotografias/'+archivo+'" class="picGrande" /></div>';
	$('#cuerpoModal').html(str);
	$('#botoneraModal').hide();
	$('#myModal').modal('show'); 
}

function ver_foto_empaque(archivo,empaque,nombre) {
	$('#tituloModal').html(nombre);
	
        str = '<img src="files/thumbnails_fotografias/'+archivo+'" class="picChica" onclick="cambiaPic(\''+archivo+'\')" />';
        if(empaque!="")
        {
            str += '<img src="files/thumbnails_fotografias/'+empaque+'" class="picChica" onclick="cambiaPic(\''+empaque+'\')" />';
        }
        str += '<div id="picGrandeModal"><img src="files/fotografias/'+empaque+'" class="picGrande" /></div>';
	$('#cuerpoModal').html(str);
	$('#botoneraModal').hide();
	$('#myModal').modal('show'); 
}

function cambiaPic(archivo) {
    str = '<img src="files/fotografias/'+archivo+'" class="picGrande" />';
    $("#picGrandeModal").html(str);
}

function cargaModalInicio_old() {
	$('#tituloModal').html('Modal Inicio');
	$('#cuerpoModal').html('Cuerpo inicio');
	$('#botoneraModal').hide();
	$('#myModal').modal('show'); 
}

function valida_vendedor() {
    nombre = $("#nombre").val();
    if(nombre=="")
    {
        alert('Debe ingresar el nombre del vendedor');
        $("#nombre").focus();
        return false;
    }
    cargo = $("#cargo").val();
    if(cargo=="")
    {
        alert('Debe ingresar el cargo');
        $("#cargo").focus();
        return false;
    }
    email = $("#email").val();
    if(email=="")
    {
        alert('Debe ingresar el email del vendedor');
        $("#email").focus();
        return false;
    }
    clave = $("#clave").val();
    if(clave=="")
    {
        alert('Debe ingresar la clave del vendedor');
        $("#clave").focus();
        return false;
    }
}

function eliminarVendedor(id) {
    $('#tituloModal').html('Esta a punto de eliminar este vendedor!');
    $('#cuerpoModal').html('<p>Recuerde que una vez que lo elimine no podra recuperarlo<br>Esta seguro que quiere hacerlo?.</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="vendedores/eliminar/'+id+'" class="btn-ventana-modal">ELIMINAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function printReserva(id)
{
    width = 800;
    height = 500;
    var winl = (screen.width-width)/2;
    var wint = (screen.height-height)/2;
    eval('window.open(\'reservas/impresion/'+id+'\', \'ImgPopUpWin\', \'scrollbars=yes, menubar=yes, toolbar=yes, status=yes, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}

function printReservaVendedor(id, id_vendedor)
{
    width = 800;
    height = 500;
    var winl = (screen.width-width)/2;
    var wint = (screen.height-height)/2;
    eval('window.open(\'vendedores/impresion/'+id_vendedor+'/'+id+'\', \'ImgPopUpWin\', \'scrollbars=yes, menubar=yes, toolbar=yes, status=yes, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}

function printCompra(id)
{
    width = 800;
    height = 500;
    var winl = (screen.width-width)/2;
    var wint = (screen.height-height)/2;
    eval('window.open(\'compras/impresion/'+id+'\', \'ImgPopUpWin\', \'scrollbars=yes, menubar=yes, toolbar=yes, status=yes, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}

function printCompraVendedor(id, id_vendedor)
{
    width = 800;
    height = 500;
    var winl = (screen.width-width)/2;
    var wint = (screen.height-height)/2;
    eval('window.open(\'vendedores/impresionCompra/'+id_vendedor+'/'+id+'\', \'ImgPopUpWin\', \'scrollbars=yes, menubar=yes, toolbar=yes, status=yes, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}