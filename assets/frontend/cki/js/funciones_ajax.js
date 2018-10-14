function cargaModalInicio() {
    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/modalInicio',
            data: { },
            dataType : 'json',
            success: function(resultado) {
                tituloModal = resultado.titulo;
                contenidoModal = '<div style="width:700px;">'+resultado.texto+'</div>';  
                
				$('#tituloModal').html(tituloModal);
				$('#cuerpoModal').html(contenidoModal);
				$('#botoneraModal').hide();
				$('#myModal').modal('show');
            }
    });	
}

function cargaModalImportacion() {
    $.ajax({
        type: 'POST',
        url: 'frontend/ajax/modalImportacion',
        data: { },
        dataType : 'json',
        success: function(resultado) {
            //alert(resultado.mostrar);
            if(resultado.mostrar==="si")
            {
                tituloModal = resultado.titulo;
                contenidoModal = '<div style="width:700px;">'+resultado.texto+'</div>';
                $('#tituloModal').html(tituloModal);
                $('#cuerpoModal').html(contenidoModal);
                $('#botoneraModal').hide();
                $('#myModal').modal('show');
            }
        }
    });	
}

function goProductos() {
    $.ajax({
        type: 'POST',
        url: 'frontend/ajax/seguirAgregando',
        data: { },
        dataType : 'json',
        success: function(resultado) {
            rpt=resultado.dato;
            if(rpt=='ok')
            {
                location.href='productos/1';
            }
        }
    }); 
}

function agregar_carrito(id) {
    lista_ids = $("#lista_ids").val();
    aux = lista_ids.split("#");
    pasa = false;
    lista_datos = new Array();
    indice = 0;
    for(i=0; i<aux.length; i++)
    {
        id_c = aux[i];
        aux_stock_current = $("#stock_"+id_c).val();
        stock_current = parseInt(aux_stock_current);
        aux_cantidad_ingresada = $("#cant_"+id_c).val();
        cantidad_ingresada = parseInt(aux_cantidad_ingresada);
        if(cantidad_ingresada>0)
        {
            pasa = true;
            if(cantidad_ingresada > stock_current)
            {
                pasa = false;
                //alert('No puede ingresar cantidades mayores al stock de cada color. ID Producto: '+id_c+' / Cantidad:'+cantidad_ingresada+' / Stock: '+stock_current);
                alert('No puede ingresar cantidades mayores al stock de cada color');
            }
            else
            {
                //alert('ID Producto: '+id_c+' / Cantidad:'+cantidad_ingresada);
                color =  $("#color_"+id_c).val();
                datoUni =  ($("#uni_"+id_c).val()).split("()");
                unidad= datoUni[0];    
                id_unidad= datoUni[1];
                codigo=  $("#codigo").val();
                nombre=  $("#nombre").val();    
                id_producto=  $("#id_producto").val();        
                dscto=  $("#dscto").val();
                idColor = $("#idColor_"+id_c).val();
                $.ajax({
                    type: 'POST',
                    url: 'frontend/ajax/agregaCarro',
                    data: { codigo: codigo,color: color,cant: cantidad_ingresada,unidad: unidad,id_unidad: id_unidad,nombre: nombre,id: id_c,id_producto: id_producto,dscto: dscto, id_color: idColor},
                    dataType : 'json',
                    success: function(resultado) {
                        rpt=resultado.dato;
                        num=resultado.num;  

                        if(rpt=='ok')
                        {
                            $("#a_de_carrito").html(num+' Items'); 
                            alert("Se agrego en Carrito de Pedido!");  
                            //alert(num);
                        }
                        else if(rpt==='error')
                        {
                            alert("Solo se pueden agregar "+num+" productos a su Orden");     
                        }
                        else
                        {
                            alert("Ocurrio un error al agregar el producto al Carro de Pedido, intentelo ed nuevo...");                      
                        }
                    }
                });
            } // else
        } // if
    } // for
    
    
}

function agregar_carrito_old(id) {
    var color =  $("#color_"+id).val();  
    cantidad_ingresada = $("#cant_"+id).val();
    cant =  parseInt(cantidad_ingresada);      
    var datoUni =  ($("#uni_"+id).val()).split("()");
    var unidad= datoUni[0];    
    var id_unidad= datoUni[1];
    var codigo=  $("#codigo").val();
    var nombre=  $("#nombre").val();    
    var id_producto=  $("#id_producto").val();        
    var dscto=  $("#dscto").val();
    var idColor = $("#idColor_"+id).val();
    stock = parseInt($("#stock_"+id).val());
    if( (cant===0) || (cant<0) || (cant==="") || (cantidad_ingresada===""))
    {
         alert('Debe agregar la cantidad que desea');   
    }
    else if(cant>stock)
    {
          alert('No puede ordenar una cantidad mayor al stock indicado');
          $("#cant_"+id).val('');
          $("#cant_"+id).focus();
    }
    else
    {
        $.ajax({
                type: 'POST',
                url: 'frontend/ajax/agregaCarro',
                data: { codigo: codigo,color: color,cant: cant,unidad: unidad,id_unidad: id_unidad,nombre: nombre,id: id,id_producto: id_producto,dscto: dscto, id_color: idColor},
                dataType : 'json',
                success: function(resultado) {
                    rpt=resultado.dato;
                    num=resultado.num;  

                    if(rpt=='ok')
                    {
                        $("#a_de_carrito").html(num+' Items'); 
                        alert("Se agrego en Carrito de Pedido!");  
                        //alert(num);
                    }
                    else if(rpt==='error')
                    {
                        alert("Solo se pueden agregar "+num+" productos a su Orden");     
                    }
                    else
                    {
                        alert("Ocurrio un error al agregar el producto al Carro de Pedido, intentelo ed nuevo...");                      
                    }
                }
        });
    }
	
}


function actualiza_carrito(id) {
    aux_cant =  $("#cant_"+id).val();
    cant = parseInt(aux_cant);
    aux_stock = $("#stock_"+id).val();
    stock = parseInt(aux_stock);
    if( (cant=="") || (cant==0) || (cant=="0") )
    {
        alert("Ingrese una Cantidad");
        $("#cant_"+id).focus();
        return false;
    }
    else if(cant>stock)
    {
        alert('No puede ingresar una cantidad mayor al stock para este color: '+stock);
        $("#cant_"+id).focus();
        return false;
    }
    else
    {
        $.ajax({
                type: 'POST',
                url: 'frontend/ajax/actualizaCarro',
                data: { id: id,cant: cant},
                dataType : 'json',
                success: function(resultado) {
                    rpt=resultado.dato;
                    if(rpt=='ok'){
                        alert("Item Actualizado !");
                        location.href='pedido/carro';
                         
                    }
                }
        });		
    }
}

function elimina_item_carrito(id) {
    input_box=confirm("Esta seguro de eliminar el Item ?");
    if (input_box==false)
    { 
        return false;
    }
    
    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/eliminaItemCarro',
            data: { id: id},
            dataType : 'json',
            success: function(resultado) {
                rpt=resultado.dato;
                num=resultado.num;  
                if(rpt=='ok'){
                    $("#a_de_carrito").html(num+' Items');
                    location.href='pedido/carro';
                    alert("Item Eliminado !"); 
                }
            }
    });		
	
}

function elimina_todo_carrito() {

    input_box=confirm("Esta seguro de eliminar TODO su carrito de Pedido ?");
    if (input_box==false)
    { 
        return false;
    }
    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/eliminaCarro',
            data: { },
            dataType : 'json',
            success: function(resultado) {
                rpt=resultado.dato;
                if(rpt=='ok'){
                    $("#a_de_carrito").html('0 Items');
                    location.href='pedido/carro';
                    alert("Su carrito fue eliminado !"); 
                }
            }
    });		
	
}

function enviar_pedido() {
    input_box=confirm("Esta seguro de Enviar el Pedido?");
    if (input_box==false)
    { 
        return false;
    }
    mensaje_carro=$("#mensaje_carro").val();
    
    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/enviarPedido',
            data: {mensaje_carro: mensaje_carro},
            dataType : 'json',
            success: function(json) {
                result=json.dato;
                location.href='pedido/'+result;
            }
    });		
	
}

function doReserva() {
    input_box=confirm("Esta seguro de colocar la reserva?");
    if (input_box==false)
    { 
        return false;
    }
    mensaje_carro=$("#mensaje_carro").val();
    
    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/enviarPedido',
            data: {mensaje_carro: mensaje_carro},
            dataType : 'json',
            success: function(json) {
                result=json.dato;
                location.href='pedido/'+result;
            }
    });	
}

function verifica_existe_correo(email){

    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/verif_exist_email',
            data: { email: email},
            dataType : 'json',
            success: function(resultado) {
                rpt=resultado.result;
                email=resultado.email;				
                if(rpt=='si'){
                    alert("El email: "+email+" ya existe en nuestra Base de Datos"); 
					$("#email").val('');
					$("#email").focus();					
                }
            }
    });		
}

function galeria_x_color(id_stock_color){
    $.ajax({
            type: 'POST',
            url: 'frontend/ajax/galeria_x_color',
            data: { id: id_stock_color},
            dataType : 'json',
            success: function(resultado) {
                $("#galeriaxColor").html('<img src="assets/frontend/cki/imagenes/loader.gif">');
                rpt=resultado.result; 
                html=resultado.html;            
                if(rpt=='si'){
                    $("#galeriaxColor").html(html);
                    galeriaDetalleProducto();
                    galeriaLB();          
                }
            }
    });     
}