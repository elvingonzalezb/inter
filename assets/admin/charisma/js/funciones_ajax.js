function showNovedad(id_novedad) {
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/getnovedad',
        data: { id: id_novedad},
        dataType : 'json',
        success: function(json) {
            $('#tituloModal').html(json.titulo);
            $('#botoneraModal').show();
            cuerpo = '<img src="files/foto_novedades/'+json.foto+'" align="left" hspace="10" />';
            cuerpo += '<p align="justify">'+json.sumilla+'</p>';
            $('#cuerpoModal').html(cuerpo);
            $('#myModal').modal('show'); 
        }
    });
}

function borrarColor(id) {
    var id_producto =  $("#id_producto").val();
    $.ajax({
            type: 'POST',
            url: 'mainpanel/ajax/eliminaColores',
            data: { id: id,id_producto: id_producto},
            dataType : 'json',
            success: function(id_producto) {
                location.href='mainpanel/catalogo/edit_producto/'+id_producto+'/success';
    //            $('#myModal').modal('close'); 
                alert("Color Eliminado !");  
            }
    });		
	
}

function borrarPrecio(id) {
    var id_producto =  $("#id_producto").val();
    $.ajax({
            type: 'POST',
            url: 'mainpanel/ajax/eliminaPrecio',
            data: { id: id,id_producto: id_producto},
            dataType : 'json',
            success: function(id_producto) {
                location.href='mainpanel/catalogo/edit_producto/'+id_producto+'/success';
    //            $('#myModal').modal('close'); 
                alert("Precio Eliminado !");  
            }
    });		
}

function borrarMultProd() {
    var id_eliminar =  $("#id_eliminar").val();
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/eliminaProd',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(id_categoria) {
            location.href='mainpanel/catalogo/listado_productos/'+id_categoria+'/success';
//            $('#myModal').modal('close'); 
            alert("Productos Eliminados !");            
        }
    });
}

function borrarMultiCli() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar los clientes que quiere eliminar");
        return false;
    }    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/eliminaCli',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/clientes/listado/'+data;
//            $('#myModal').modal('close'); 
            alert("Clientes Eliminados !");            
        }
    });
}

function doRevisarMultiPedido() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar los pedidos que quiere dar por revisados");
        return false;
    }    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/revisarMultiPedidos',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/pedidos/listado/'+data;
//            $('#myModal').modal('close'); 
            alert("Pedidos Revisados !");      
        }
    });
}

function borrarMultiCliInactivos() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar los clientes que quiere eliminar");
        return false;
    }    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/eliminaCliInactivos',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/clientes/listado_inactivos/'+data;
//            $('#myModal').modal('close'); 
            alert("Los clientes fueron Eliminados !");            
        }
    });
}

function borrarMultiCliAnulados() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar los clientes que quiere eliminar");
        return false;
    }    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/eliminaCliAnulados',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/clientes/listado_anulados/'+data;
//            $('#myModal').modal('close'); 
            alert("Los clientes fueron Eliminados !");            
        }
    });
}

function borrarMultiCliBorrados() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar los clientes que quiere eliminar");
        return false;
    }    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/eliminaCliBorrados',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/clientes/listado_borrados/'+data;
//            $('#myModal').modal('close'); 
            alert("Los clientes fueron Eliminados !");            
        }
    });
}

function anularCliente2() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar algun Cliente");
        return false;
    }
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/anularCli',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/clientes/listado/'+data;
            alert("Clientes Anulados !");            
        }
    });
}

function desactivarCliente2() {
    var id_eliminar =  $("#id_eliminar").val();
    if(id_eliminar==''){
        alert("Debe seleccionar algun Cliente");
        return false;
    }
    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/desactivaCli',
        data: {id_eliminar: id_eliminar},
        dataType : 'json',
        success: function(data) {
            location.href='mainpanel/clientes/listado/'+data;
            alert("Clientes Desactivados !");            
        }
    });
}

function trasladaProd() {
    var id_eliminar =  $("#id_eliminar").val();
    var id_categoria_padre =  $("#id_categoria_padre").val();    
    if(id_categoria_padre==0){
        alert("Debe seleccionar una categoria");
        return false;
    }
    if(id_eliminar==''){
        alert("Debe seleccionar algun Producto");
        return false;
    }    
    var id_categoria_padre =  $("#id_categoria_padre").val();    
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/trasladaProd',
        data: {id_eliminar: id_eliminar,id_categoria_padre:id_categoria_padre},
        dataType : 'json',
        success: function(id_categoria) {
            location.href='mainpanel/catalogo/listado_productos/'+id_categoria+'/success';
//            $('#myModal').modal('close'); 
            alert("Productos Trasladados !");            
        }
    });
}

function ordProductos(orden) {
    id_subcategoria = $("#id_subcategoria").val();
    //alert('id_subcategoria: '+id_subcategoria + ' - Orden: '+orden);
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/ordProd',
        data: {orden: orden, id_subcategoria:id_subcategoria},
        dataType : 'json',
        success: function() {
            alert("Se ordeno correctamente!");            
        }
    });
}

function cargaSubcats(id_categoria) {
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/combo_subcategorias',
        data: {id_categoria: id_categoria},
        dataType : 'json',
        success: function(json) {
            envio=json.dato;
            cad=envio.split("@@");
            num=cad[0];
            str='';
            str = '<select name="id_subcategoria" id="id_subcategoria">';
            if(num>0)
            {
               str += '<option value="0">Elija...</option>';
               for(e=1; e<=num; e++)
               {
                   dat=cad[e].split("$$");
                   id_subcategoria = dat[0];
                   subcategoria = dat[1];        
                   str += '<option value="'+id_subcategoria+'">'+subcategoria+'</option>';                   
               }
            }
            else
            {
                str += '<option value="0">-------</option>';
            }
            str += '</select> <input type="button" onclick="agregaSubcategoriaLista()" value="AGREGAR">';
            $("#divSubCategorias").html(str);
        }
    });    
}

function cargaSubcats2(id_categoria) {
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/combo_subcategorias',
        data: {id_categoria: id_categoria},
        dataType : 'json',
        success: function(json) {
            envio=json.dato;
            cad=envio.split("@@");
            num=cad[0];
            str='';
            str = '<select name="id_categoria" id="id_categoria">';
            if(num>0) {
               str += '<option value="0">Elija...</option>';
               for(e=1; e<=num; e++) {
                   dat=cad[e].split("$$");
                   id_subcategoria = dat[0];
                   subcategoria = dat[1];        
                   str += '<option value="'+id_subcategoria+'">'+subcategoria+'</option>';                   
               }
            } else {
                str += '<option value="0">-------</option>';
            }
            str += '</select>';
            $("#divCategoriasPrincipal").html(str);
        }
    });    
}

function agregaProductoBoletin() {
    codigo = $("#codigo").val();
    productos_elegidos = $('#productos_elegidos').val();
    if( (codigo=="") || (codigo=="0") )
    {
        alert('Debe ingresar el codigo del producto que quiere agregar al boletin');
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: 'mainpanel/ajax/agrega_producto_boletin',
            data: { codigo: codigo, elegidos: productos_elegidos },
            dataType : 'json',
            success: function(json) {
                envio = json.dato;
                cad = envio.split("@@");
                id_producto = cad[0];
                nombre_producto = cad[1];
                codigo_producto = cad[2];
                imagen_producto = cad[3];
                se_agrego = cad[4];
                elegidos = cad[5];
                //alert(se_agrego);
                if(se_agrego=="1")
                {
                    str = '<tr id="fila_'+id_producto+'">';
                    str += '<td height="25" align="center" valign="middle"><img src="files/productos_thumbs/'+imagen_producto+'" /></td>';
                    str += '<td align="center" valign="middle">'+nombre_producto+'</td>';
                    str += '<td align="center" valign="middle">'+codigo_producto+'</td>';
                    str += '<td align="center" valign="middle"><a href="javascript:quitarProdBoletin(\''+id_producto+'\')">ELIMINAR</a></td>';
                    str += '</tr>';
                    $("table#tablaProds tbody").append(str);
                }
                //alert(elegidos);
                $("#productos_elegidos").val(elegidos);
                $("#codigo").val('');
            }
        });            
    }
}

function quitarProdBoletin(id_producto) {
    productos_elegidos = $('#productos_elegidos').val();
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/quitar_producto_boletin',
        data: {id_producto: id_producto, elegidos: productos_elegidos},
        dataType : 'json',
        success: function(json) {
            envio = json.dato;
            cad = envio.split("@@");
            idprod = cad[0];
            elegidos = cad[1];
            $("#fila_"+idprod).remove();
            $("#productos_elegidos").val(elegidos);
        }
    });    
}

function agregaSubcategoriaLista() {
    id_categoria = $('#id_categoria_padre').val();
    id_subcategoria = $('#id_subcategoria').val();
    subcats_elegidas = $('#subcats_elegidas').val();
    if(id_categoria=="0")
    {
        alert('Debe elegir primero la Categoria')
    }
    else if(id_subcategoria=="0")
    {
        alert('Debe elegir la subcategoria')
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: 'mainpanel/ajax/agrega_subcat_lista',
            data: {id_categoria: id_categoria, id_subcategoria: id_subcategoria, elegidos: subcats_elegidas},
            dataType : 'json',
            success: function(json) {
                envio = json.dato;
                cad = envio.split("@@");
                categoria = cad[0];
                subcategoria = cad[1];
                id_subcategoria = cad[2];
                se_agrego = cad[3];
                elegidos = cad[4];
                //alert(se_agrego);
                if(se_agrego=="1")
                {
                    str = '<tr id="fila_'+id_subcategoria+'">';
                    str += '<td height="25" align="center" valign="middle">'+categoria+'</td>';
                    str += '<td align="center" valign="middle">'+subcategoria+'</td>';
                    str += '<td align="center" valign="middle"><a href="javascript:quitarSubCatLista(\''+id_subcategoria+'\')">ELIMINAR</a></td>';
                    str += '</tr>';
                    $("table#tablaSubcats tbody").append(str);
                }
                //alert(elegidos);
                $("#subcats_elegidas").val(elegidos);
            }
        });
    }
}

function quitarSubCatLista(id_subcategoria) {
    subcats_elegidas = $('#subcats_elegidas').val();
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/quitar_subcat_lista',
        data: {id_subcategoria: id_subcategoria, elegidos: subcats_elegidas},
        dataType : 'json',
        success: function(json) {
            envio = json.dato;
            cad = envio.split("@@");
            id_subcategoria = cad[0];
            elegidos = cad[1];
            $("#fila_"+id_subcategoria).remove();
            $("#subcats_elegidas").val(elegidos);
        }
    });
}

function muestra_color(id_categoria) {
    //alert(id_categoria);

    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/muestra_color',
        data: {id_categoria: id_categoria},
        dataType : 'json',
        success: function(json) {
            
            
            envio=json.dato;
            
            cad=envio.split("@@");
            num=cad[0];
            str='';
            if(num>0){
               for(e=1;e<=num;e++){
                   dat=cad[e].split("$$");
                   color=dat[0];
                   nombre=dat[1];
                   id=dat[2];                   
                   str+='<div class="div_color">';
                   str+='<div class="tit_col"><h6>'+nombre+'</h6></div>';
                   str+='<div class="caja_color" style="background:'+color+';" title="'+color+'"></div>';
                   str+='Stock: <input type="text" class="span12 typeahead" id="cant_'+id+'">';
                   str+='Stock Prox.: <input type="text" class="span12 typeahead" id="cant_prox_'+id+'">';
                   str+='Fecha Llegada: <input type="text" class="span12 input-xlarge datepicker" id="fecha_prox_'+id+'" placeholder="dd-mm-aaaa">';
                   str+='Precio Prox.: <input type="text" class="span12 typeahead" id="precio_prox_'+id+'">';
                   str+='Orden: <input type="text" class="span12 typeahead" id="orden_prox_'+id+'">';
                    str+='<div class="aBtn"><a href="javascript:agrega_color('+id+')">Agregar</a></div>';
                   str+='</div>';                   
               }
            }
            $("#cont_colores").html(str);
        }
    });
}

function grabarModfTodo(id_subcategoria) {
    //alert(id_categoria);
	str='<span><img src="assets/admin/charisma/img/ajax-loaders/ajax-loader-6.gif" border="0" /></span>';
	$("#loadjulio").html(str);

    cad_id_precios=$("#cad_id_precios").val();
	cad_id_precios=cad_id_precios.split("&&");
	num=cad_id_precios.length;
    for(r=0;r<num;r++){
		id=cad_id_precios[r];			
		var $mySelection = $("#precio_"+id);		
		if ($mySelection.length){		
			precio=$("#precio_"+id).val();
			if(r==0){cad_pre=precio+'()'+id;}else{cad_pre=cad_pre+'##'+precio+'()'+id}
		}
    }
	
    cad_id_stocks=$("#cad_id_stocks").val();	
	cad_id_stocks=cad_id_stocks.split("&&");
	num=cad_id_stocks.length;
    for(r=0;r<num;r++){
		id=cad_id_stocks[r];				
		var $mySelection = $("#stock_"+id);
		if ($mySelection.length){			
			stock=$("#stock_"+id).val();
			if(r==0){cad_stock=stock+'()'+id;}else{cad_stock=cad_stock+'##'+stock+'()'+id}
		}
    }    

    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/graba_pre_stock',
        data: {id_subcategoria: id_subcategoria, cad_pre: cad_pre, cad_stock: cad_stock},
        dataType : 'json',
        success: function(json) {
                id_subcategoria = json.id_subcategoria;
                location.href='mainpanel/catalogo/mantto/'+id_subcategoria;
				$("#loadjulio").html('');
                alert("Se actualizaron los productos !");
        }
    });
}

function agrega_color(id_color) {
    stock = $("#cant_"+id_color).val();
    cant_prox = $("#cant_prox_"+id_color).val();
    fecha_prox = $("#fecha_prox_"+id_color).val();
    precio_prox = $("#precio_prox_"+id_color).val();
    orden_prox = $("#orden_prox_"+id_color).val();
//alert(stock);
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/elejido_color',
        data: {id_color: id_color},
        dataType : 'json',
        success: function(json) {
			
            nombre=json.nombre;
            color=json.color;            
            id=json.id;
            
            str='';
            str+='<div class="div_color2" id="div_color_ind_'+id+'">';
            str+='<div class="tit_col"><h6>'+nombre+'</h6></div>';
            str+='<div class="caja_color2" style="background:'+color+';" title="'+color+'"></div>';
            str+='<span><strong>Stock:</strong> '+stock+'</span><br>';
            str+='<span><strong>Stock Prox.:</strong> '+cant_prox+'</span><br>';
            str+='<span><strong>Fecha:</strong> '+fecha_prox+'</span><br>';
            str+='<span><strong>Precio Prox.:</strong> '+precio_prox+'</span><br>';
            str+='<span><strong>Orden:</strong> '+orden_prox+'</span><br>';
            str+='<input type="hidden" name="stock_c_'+id+'" value="'+stock+'"/>';
            str+='<input type="hidden" name="cant_c_'+id+'" value="'+cant_prox+'"/>';
            str+='<input type="hidden" name="fecha_c_'+id+'" value="'+fecha_prox+'"/>';
            str+='<input type="hidden" name="precio_c_'+id+'" value="'+precio_prox+'"/>';
            str+='<input type="hidden" name="orden_c_'+id+'" value="'+orden_prox+'"/>';
            str+='<input type="hidden" name="idcolor_'+id+'" value="'+id+'" class="idcolor"/>';            
            str+='<div class="aBtn"><a href="javascript:eliminando_color('+id+')">Eliminar</a></div>';
            str+='</div>';
            //alert(str);
            $("#cont_elejidos").append(str);
            
            conta=0;
            $(".idcolor").each(function()
            {
                if(conta==0)
                {
                    st=$(this).val();
                }
                else
                {
                    st =st+'##'+$(this).val();
                }
                conta=conta+1;
            })            
            if(conta==0){$("#id_concatenados").val(""); }else{$("#id_concatenados").val(st);}        
        }
    });
}

function muestra_color_nuevo(id_categoria) {
    if(id_categoria=="0")
    {
        $("#cont_colores").hide('fast');
        $("#opcionesColores").hide('fast');
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: 'mainpanel/ajax/muestra_color_nuevo',
            data: {id_categoria: id_categoria},
            dataType : 'json',
            success: function(json) {
                envio=json.dato;
                cad=envio.split("@@");
                num=cad[0];
                str = '';
                if(num>0) {
                   for(e=1;e<=num;e++){
                       dat=cad[e].split("$$");
                       color=dat[0];
                       nombre=dat[1];
                       id=dat[2];                   
                       str += '<div class="div_color">';
                       str += '<div class="tit_col">'+nombre+'</div>';
                       str += '<div class="caja_color" style="background:'+color+';" title="'+color+'"></div>';
                       //str += '<div class="btnradio"><input type="radio" name="selectorColor" value="'+id+'"></div>';
                       str += '<div class="btnradio"><input type="radio" name="id_color" value="'+id+'"></div>';
                       str += '</div>';
                   }
                }
                $("#cont_colores").html(str);
                $("#cont_colores").show('fast');
                $("#opcionesColores").show('fast');
            }
        });        
    }
}

function agregaColor() {
    color = $("input[name='selectorColor']");
    elegido = false;
    for(i=0; i<color.length; i++)
    {
        if(color[i].checked)
        {
            elegido = true
        }
    }
    stock = $("#stock").val();    
    if(elegido==false)
    {
        alert('Debe elegir el color que desea');
    }
    else if(stock=="")
    {
        alert('Debe ingresar el stock del color deseado');
        $("#stock").focus();
    }
    else
    {
        id_color = $("input[name='selectorColor']:checked").val();
        stock_prox = $("#stock_prox").val();
        fecha_llegada = $("#fecha_llegada").val();
        precio_prox = $("#precio_prox").val();
        orden_prox = $("#orden_prox").val();
        elegidos = $("#id_concatenados").val();
        //alert('Elegidos: '+elegidos);
        $.ajax({
            type: 'POST',
            url: 'mainpanel/ajax/agregaColor',
            data: {id_color: id_color, stock: stock, stock_prox: stock_prox, fecha_llegada: fecha_llegada, precio_prox: precio_prox, orden_prox: orden_prox, elegidos: elegidos},
            success: function(retorno) {
                //alert('Retorno: '+retorno);
                str = '';
                aux = retorno.split("@");
                for(i=0; i<aux.length; i++)
                {
                    current = aux[i].split("#");
                    id_color = current[0];
                    nombre = current[6];
                    color = current[8];
                    str += '<div class="div_color3" id="capaColor_'+id_color+'">';
                        str += '<div class="tit_col">'+nombre+'</div>';
                        str += '<div class="caja_color2" style="background:#'+color+';" title="'+color+'"></div>';
                        str += '<div class="datoProx"><strong>Stock:</strong> '+current[1]+'</div>';
                        str += '<div class="datoProx"><strong>Stock Prox.:</strong> '+current[2]+'</div>';
                        str += '<div class="datoProx"><strong>Fecha:</strong> '+current[3]+'</div>';
                        str += '<div class="datoProx"><strong>Precio prox.:</strong> '+current[4]+'</div>';
                        str += '<div class="datoProx"><strong>Orden prox.:</strong> '+current[5]+'</div>';
                        str += '<div class="aBtn"><a href="javascript:eliminaColor('+id_color+')">Eliminar</a></div>';
                    str += '</div>';
                }
                $("#id_concatenados").val(retorno);
                $("input[name='selectorColor']").attr("checked", false);
                $("#stock").val('');
                $("#stock_prox").val('');
                $("#fecha_llegada").val('');
                $("#precio_prox").val('');
                $("#orden_prox").val('');
                $("#cont_elejidos").html(str);
            }
        });          
    }
}

function eliminaColor(id_color) {
    elegidos = $("#id_concatenados").val();
    //alert(elegidos);
    $.ajax({
        type: 'POST',
        url: 'mainpanel/ajax/eliminarColor',
        data: {id_color: id_color, elegidos: elegidos},
        success: function(retorno) {
            //alert('Retorno: '+retorno);
            str = '';
            aux = retorno.split("@");
            for(i=0; i<aux.length; i++)
            {
                current = aux[i].split("#");
                id_color = current[0];
                nombre = current[6];
                color = current[8];
                str += '<div class="div_color3" id="capaColor_'+id_color+'">';
                    str += '<div class="tit_col">'+nombre+'</div>';
                    str += '<div class="caja_color2" style="background:#'+color+';" title="'+color+'"></div>';
                    str += '<div class="datoProx"><strong>Stock:</strong> '+current[1]+'</div>';
                    str += '<div class="datoProx"><strong>Stock Prox.:</strong> '+current[2]+'</div>';
                    str += '<div class="datoProx"><strong>Fecha:</strong> '+current[3]+'</div>';
                    str += '<div class="datoProx"><strong>Precio prox.:</strong> '+current[4]+'</div>';
                    str += '<div class="datoProx"><strong>Orden prox.:</strong> '+current[5]+'</div>';
                    str += '<div class="aBtn"><a href="javascript:eliminaColor('+id_color+')">Eliminar</a></div>';
                str += '</div>';
            }
            $("#id_concatenados").val(retorno);
            $("#stock").val('');
            $("#stock_prox").val('');
            $("#fecha_llegada").val('');
            $("#precio_prox").val('');
            $("#orden_prox").val('');
            $("#cont_elejidos").html(str);
        }
    }); 
}