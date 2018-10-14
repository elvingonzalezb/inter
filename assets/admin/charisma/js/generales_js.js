function printPedido(id, width, height)
{
	var winl = (screen.width-width)/2;
  	var wint = (screen.height-height)/2;
	eval('window.open(\'mainpanel/pedidos/impresion/'+id+'\', \'ImgPopUpWin\', \'scrollbars=yes, menubar=yes, toolbar=yes, status=no, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}

function printReserva(id, width, height)
{
	var winl = (screen.width-width)/2;
  	var wint = (screen.height-height)/2;
	eval('window.open(\'mainpanel/reservas/impresion/'+id+'\', \'ImgPopUpWin\', \'scrollbars=yes, menubar=yes, toolbar=yes, status=no, width='+width+', height='+height+',top= '+ wint+', left=' + winl+', resizable=no\')');
}

function deleteBanner(id_banner) {
    $('#tituloModal').html('Esta a punto de borrar este banner!');
    $('#cuerpoModal').html('<p>Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/banners/delete/'+id_banner+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function deleteBannerCliente(id_banner) {
    $('#tituloModal').html('Esta a punto de borrar este banner!');
    $('#cuerpoModal').html('<p>Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/banners/deletec/'+id_banner+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function deletePedido(id_pedido) {
    $('#tituloModal').html('Esta a punto de borrar este pedido!');
    $('#cuerpoModal').html('<p>Al hacerlo se repondra el stock de cada producto en esta orden. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/pedidos/delete/'+id_pedido+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function anularReserva(id) {
    $('#tituloModal').html('Esta a punto de Anular esta reserva!');
    $('#cuerpoModal').html('<p>Al hacerlo se repondra el stock de cada producto en esta reserva y el cliente no podra efectuar la compra. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/reservas/anular/'+id+'" class="btn btn-primary">ANULAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function anularCompra(id) {
    $('#tituloModal').html('Esta a punto de Anular esta Compra !');
    $('#cuerpoModal').html('<p>Al hacerlo la compra se borrara y se reactivara la reserva. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/compras/anular/'+id+'" class="btn btn-primary">ANULAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function borrarReserva(id) {
    $('#tituloModal').html('Esta a punto de Borrar esta reserva!');
    $('#cuerpoModal').html('<p>Al hacerlo la reserva se eliminara definitivamente de la base de datos y no podra recuperarse. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/reservas/borrar/'+id+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function motivoAnulacion(motivo) {
    $('#tituloModal').html('Motivo de la Anulacion');
    $('#cuerpoModal').html('<p>'+motivo+'</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CERRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function reactivarReserva(id) {
    $('#tituloModal').html('Esta a punto de Reactivar esta reserva!');
    $('#cuerpoModal').html('<p>Al hacerlo debera ingresar la nueva fecha de caducidad de la reserva y los productos volveran a descontarse del stock. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/reservas/reactivar/'+id+'" class="btn btn-primary">REACTIVAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function extenderReserva(id) {
    $('#tituloModal').html('Esta a punto de Extender esta reserva!');
    $('#cuerpoModal').html('<p>Al hacerlo la reserva se mantendra activa durante el tiempo que indique en la siguiente pantalla. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/reservas/extender/'+id+'" class="btn btn-primary">EXTENDER</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function valida_anulacion() {
    mensaje = $("#mensaje").val();
    if(mensaje=="")
    {
        alert('Debe ingresar un mensaje para el cliente');
        $("#mensaje").focus();
        return false;
    }
}

function valida_paso1() {
    id_eliminar = $("#id_eliminar").val();
    if(id_eliminar=="")
    {
        alert('Debe elegir los destinatarios');
        return false;
    }
}

function valida_reactivacion() {
    fecha_inicio = $("#fecha_inicio").val();
    if(fecha_inicio=="")
    {
        alert('Debe elegir la nueva fecha de caducidad de la reserva.');
        return false;
    }
    hora = $("#hora").val();
    if(hora=="0")
    {
        alert('Debe elegir la nueva hora de caducidad de la reserva');
        $("#hora").focus();
        return false;
    }
    mensaje = $("#mensaje").val();
    if(mensaje=="")
    {
        alert('Debe ingresar un mensaje para el cliente');
        $("#mensaje").focus();
        return false;
    }
}

function valida_cargos_extra() {
    concepto_cargo_1 = $("#concepto_cargo_1").val();
    monto_cargo_1 = $("#monto_cargo_1").val();
    concepto_cargo_2 = $("#concepto_cargo_2").val();
    monto_cargo_2 = $("#monto_cargo_2").val();
    concepto_cargo_3 = $("#concepto_cargo_3").val();
    monto_cargo_3 = $("#monto_cargo_3").val();
    if( (concepto_cargo_1==="") && (monto_cargo_1==="") && (concepto_cargo_2==="") && (monto_cargo_2==="") && (concepto_cargo_3==="") && (monto_cargo_3==="") )
    {
        alert('Debe ingresar al menos un cargo extra (concepto y monto)');
        $("#concepto_cargo_1").focus();
        return false;
    }
}

function valida_extension() {
    horas_adicionales = $("#horas_adicionales").val();
    aux = parseInt(horas_adicionales);
    mensaje = $("#mensaje").val();
    if(horas_adicionales=="")
    {
        alert('Debe ingresar el numero de horas adicionales para la reserva');
        $("#horas_adicionales").focus();
        return false;
    }
    if(!(aux>0))
    {
        alert('Debe ingresar un numero de horas entero');
        $("#horas_adicionales").val('');
        $("#horas_adicionales").focus();
        return false;
    }
    if(mensaje=="")
    {
        alert('Debe ingresar un mensaje para el cliente');
        $("#mensaje").focus();
        return false;
    }
}

function deleteBoletin(id_boletin) {
    $('#tituloModal').html('Esta a punto de borrar este boletin!');
    $('#cuerpoModal').html('<p>Esta operacion no puede revertirse. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/boletin/delete/'+id_boletin+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function deleteCorreo(id_boletin) {
    $('#tituloModal').html('Esta a punto de borrar este correo a clientes!');
    $('#cuerpoModal').html('<p>Esta operacion no puede revertirse. Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/correos/delete/'+id_boletin+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');   
}

function showBanner(banner, titulo) {
    $('#tituloModal').html(titulo);
    img = '<img src="files/banner/'+banner+'" />';
    $('#cuerpoModal').html(img);
    $('#botoneraModal').hide();
    $('#myModal').modal('show'); 
}

function showBannerCliente(banner, titulo) {
    $('#tituloModal').html(titulo);
    img = '<img src="files/banner_clientes/'+banner+'" />';
    $('#cuerpoModal').html(img);
    $('#botoneraModal').hide();
    $('#myModal').modal('show'); 
}

function deleteNovedad(id_novedad) {
    $('#tituloModal').html('Esta a punto de borrar esta novedad!');
    $('#cuerpoModal').html('<p>Esta seguro que quiere hacerlo?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/novedades/delete/'+id_novedad+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');
}

function deleteCategoria(id_categoria, num_productos) {
    $('#tituloModal').html('Esta a punto de borrar esta categoría!');
    $('#cuerpoModal').html('<p>Esta categoria tiene: <strong>'+num_productos+' producto(s)</strong>.</p><p>Al borrar la categoría estos productos dejeran de pertenecer a dichas subcategorias.</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/catalogo/delete/'+id_categoria+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteSubCategoria(id_subcategoria, num_productos) {
    $('#tituloModal').html('Esta a punto de borrar esta subcategoría!');
    $('#cuerpoModal').html('<p>Esta categoria tiene: <strong>'+num_productos+' producto(s)</strong>.</p><p>Al borrar la subcategoría esos productos dejeran de pertenecer a esta.</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/catalogo/deleteSubCat/'+id_subcategoria+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteProducto(id_producto, id_subcategoria) {
    $('#tituloModal').html('Esta a punto de borrar este Producto!');
    $('#cuerpoModal').html('<p>Al borrar el producto se eliminaran tambien sus fotos</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/catalogo/delete_producto/'+id_producto+'/'+id_subcategoria+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteColorFoto(id_color) {
    $('#tituloModal').html('Esta a punto de borrar este Color!');
    $('#cuerpoModal').html('<p>Al borrar el color se eliminaran tambien sus fotos</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/catalogo/delete_color_foto/'+id_color+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteCliente(id_cliente,razon_social,tipo) {
    $('#tituloModal').html('Esta a punto de borrar al Cliente!');
    $('#cuerpoModal').html('<p>Esta seguro de aliminar a "'+razon_social+'" ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/clientes/delete_cliente/'+id_cliente+'/'+tipo+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function eliminarCliente(id_cliente,razon_social) {
    $('#tituloModal').html('Esta a punto de marcar como borrado al Cliente!');
    $('#cuerpoModal').html('<p>Esta seguro de aliminar a "'+razon_social+'" ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/clientes/borrado_cliente/'+id_cliente+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function anularCliente(id_cliente,razon_social) {
    $('#tituloModal').html('Esta a punto de anular al Cliente!');
    $('#cuerpoModal').html('<p>Una vez que el registro "'+razon_social+'" sea anulado</p><p>este cliente no podra hacer uso del sitio</p><p>Desea Anularlo ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/clientes/anular_cliente/'+id_cliente+'" class="btn btn-primary">ANULAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function reactivarCliente(id_cliente,razon_social) {
    $('#tituloModal').html('Esta a punto de reactivar al Cliente!');
    $('#cuerpoModal').html('<p>El registro "'+razon_social+'" sera reactivado</p><p>Desea Reactivarlo ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/clientes/reactivar_cliente/'+id_cliente+'" class="btn btn-primary">REACTIVAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function recuperarCliente(id_cliente,razon_social) {
    $('#tituloModal').html('Esta a punto de reactivar al Cliente!');
    $('#cuerpoModal').html('<p>El registro "'+razon_social+'" sera reactivado</p><p>Desea Reactivarlo ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/clientes/recuperar_cliente/'+id_cliente+'" class="btn btn-primary">REACTIVAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function desactivarCliente(id_cliente,razon_social) {
    $('#tituloModal').html('Esta a punto de Desactivar al Cliente!');
    $('#cuerpoModal').html('<p>El registro "'+razon_social+'" pasará al estado Inactivo</p><p>Desea Desactivarlo ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/clientes/desactivar_cliente/'+id_cliente+'" class="btn btn-primary">DESACTIVAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function deleteMsgRecibido(id_mensaje) {
    $('#tituloModal').html('Esta a punto de borrar este mensaje!');
    $('#cuerpoModal').html('<p>Esta seguro de borrar este mensjae ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/mensajes/delete_mensaje/'+id_mensaje+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function deleteMsgMostrado(id_mensaje) {
    $('#tituloModal').html('Esta a punto de borrar este mensaje!');
    $('#cuerpoModal').html('<p>Esta seguro de borrar este mensjae ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/mensajes/delete_mensaje_mostrado/'+id_mensaje+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function valida_correo_cli() {
    msgCli=$("#msgCli").val();
    if(msgCli===""){
        alert("Debe ingresar el mensaje que va a enviar");
        $("#msgCli").focus();        
        return false;
    }
}
function valida_categoria() {
    nombre=$("#nombre").val();
    if(nombre===""){
        alert("Debe ingresar el nombre de la Cateogria");
        $("#nombre").focus();        
        return false;
    }
    
    orden=$("#orden").val();
    if(orden===""){
        alert("Debe ingresar un orden para la Categoria");
        $("#orden").focus();
        return false;
    }     
    
    foto=$("#foto").val();
    if(foto===""){
        alert("Debe subir una imagen para la Categoria");
        return false;
    }    
}

function valida_producto() {
    id_categoria_padre=$("#id_categoria_padre").val();
    if(id_categoria_padre===0){
        alert("Debe elejir una Cateogria");
        $("#id_categoria_padre").focus();        
        return false;
    }
    
    nombre=$("#nombre").val();
    if(nombre===""){
        alert("Debe ingresar el nombre");
        $("#nombre").focus();        
        return false;
    }
    
    foto=$("#foto").val();
    if(foto===""){
        alert("Debe subir una imagen para el producto");
        return false;
    }      
    
    orden=$("#orden").val();
    if(orden===""){
        alert("Debe ingresar un orden para el producto");
        $("#orden").focus();
        return false;
    }     
    precio=$("#precio").val();
    if(precio===""){
        alert("Debe ingresar el precio del producto");
        $("#precio").focus();
        return false;
    }
}

function valida_producto2() {
    subcats_elegidas = $("#subcats_elegidas").val();
    if(subcats_elegidas===""){
        alert("Debe elejir al menos una Sub Categoria. De no hacerlo el producto no estara visible");
        return false;
    }
    
    nombre=$("#nombre").val();
    if(nombre===""){
        alert("Debe ingresar el nombre");
        $("#nombre").focus();        
        return false;
    }
    
    foto=$("#foto").val();
    if(foto===""){
        alert("Debe subir una imagen para el producto");
        return false;
    }   
    
    codigo = $("#codigo").val();
    if(codigo===""){
        alert("Debe ingresar el codigo del producto");
        $("#codigo").focus();        
        return false;
    }
    
    orden=$("#orden").val();
    if(orden===""){
        alert("Debe ingresar un orden para el producto");
        $("#orden").focus();
        return false;
    }
}

function valida_producto3() {
    subcats_elegidas = $("#subcats_elegidas").val();
    if(subcats_elegidas===""){
        alert("Debe elejir al menos una Sub Categoria. De no hacerlo el producto no estara visible");
        return false;
    }
    
    nombre=$("#nombre").val();
    if(nombre===""){
        alert("Debe ingresar el nombre");
        $("#nombre").focus();        
        return false;
    }
    
    foto=$("#foto").val();
    if(foto===""){
        alert("Debe subir una imagen para el producto");
        return false;
    }   
    
    codigo = $("#codigo").val();
    if(codigo===""){
        alert("Debe ingresar el codigo del producto");
        $("#codigo").focus();        
        return false;
    }
    
    orden=$("#orden").val();
    if(orden===""){
        alert("Debe ingresar un orden para el producto");
        $("#orden").focus();
        return false;
    }
    /*
    precio = $("#precio_0").val();
    if(precio==="")
    {
        alert('Debe ingresar el precio del producto');
        $("#precio_0").focus();
        return false;
    }
    */
    
    id_concatenados = $("#id_concatenados").val();
    if(id_concatenados==="")
    {
        alert('Debe elegir al menos una variedad de color');
        return false;
    }
}

function valida_producto4() {
    subcats_elegidas = $("#subcats_elegidas").val();
    if(subcats_elegidas===""){
        alert("Debe elejir al menos una Sub Categoria. De no hacerlo el producto no estara visible");
        return false;
    }
    
    nombre=$("#nombre").val();
    if(nombre===""){
        alert("Debe ingresar el nombre");
        $("#nombre").focus();        
        return false;
    }
        
    codigo = $("#codigo").val();
    if(codigo===""){
        alert("Debe ingresar el codigo del producto");
        $("#codigo").focus();        
        return false;
    }
    
    orden=$("#orden").val();
    if(orden===""){
        alert("Debe ingresar un orden para el producto");
        $("#orden").focus();
        return false;
    }
    /*
    precio = $("#precio_0").val();
    if(precio==="")
    {
        alert('Debe ingresar el precio del producto');
        $("#precio_0").focus();
        return false;
    }
    */
    
    id_concatenados = $("#id_concatenados").val();
    if(id_concatenados==="")
    {
        alert('Debe elegir al menos una variedad de color');
        return false;
    }
}

function valida_unidad() {
    texto=$("#texto").val();
    if(texto===""){
        alert("Debe ingresar el nombre de la Unidad");
        $("#texto").focus();        
        return false;
    }
}

function valida_clientes() {
    razon_social=$("#razon_social").val();
    if(razon_social===""){
        alert("Debe ingresar la razon social");
        $("#razon_social").focus();        
        return false;
    }
    
    nombre=$("#nombre").val();
    if(nombre===""){
        alert("Debe ingresar el nombre");
        $("#nombre").focus();        
        return false;
    }
    
    ruc=$("#ruc").val();
    if(ruc===""){
        alert("Debe ingresar el numero de RUC");
         $("#ruc").focus();  
        return false;
    }      
    
    cargo=$("#cargo").val();
    if(cargo===""){
        alert("Debe ingresar su cargo");
        $("#cargo").focus();
        return false;
    }     
    
    ciudad=$("#ciudad").val();
    if(ciudad===""){
        alert("Debe ingresar la ciudad");
        $("#ciudad").focus();
        return false;
    }      
  
    provincia=$("#provincia").val();
    if(provincia===""){
        alert("Debe ingresar la provincia");
        $("#provincia").focus();
        return false;
    }      
    
    departamento=$("#departamento").val();
    if(departamento===""){
        alert("Debe ingresar el departamento");
        $("#departamento").focus();
        return false;
    }          
    
    pais=$("#pais").val();
    if(pais===""){
        alert("Debe ingresar su pais");
        $("#pais").focus();
        return false;
    }      
}
function valida_color_foto() {
    color=$("#cat_color").val();
    if(color==="0"){
        alert("Debe elegir el color");
        $("#cat_color").focus();        
        return false;
    }
    stock=$("#stock").val();
    if(stock===""){
        alert("Debe ingresar el stock");
        $("#stock").focus();        
        return false;
    }
    
    /*foto=$("#stock_prox").val();
    if(foto===""){
        alert("Debe subir una imagen para el producto");
        return false;
    }*/   
    
    stock_prox = $("#stock_prox").val();
    if(stock_prox===""){
        alert("Debe ingresar el stock proximo del producto");
        $("#stock_prox").focus();        
        return false;
    }
    
    /*fecha_llegada=$("#fecha_llegada").val();
    if(fecha_llegada===""){
        alert("Debe ingresar un fecha de llegada para el producto");
        $("#orden").focus();
        return false;
    }*/
}

function concatena(id)
{
    id_eliminar=$("#id_eliminar").val();
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

    $("#id_eliminar").val(str);    
}

function revisarMultiPedidos() {
    $('#tituloModal').html('Esta a punto de dar por revisados los pedidos seleccionados!');
    $('#cuerpoModal').html('<p>Esta seguro que quiere hacerlo ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:doRevisarMultiPedido()" class="btn btn-primary">REVISAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
	
function deleteMultiProd() {
    $('#tituloModal').html('Esta a punto de borrar los productos seleccionados!');
    $('#cuerpoModal').html('<p>Esta seguro de borrarlos ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarMultProd()" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteMultiCli() {
    $('#tituloModal').html('Esta a punto de borrar los clientes seleccionados!');
    $('#cuerpoModal').html('<p>Esta seguro de borrarlos ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarMultiCli()" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteMultiCliInactivos() {
    $('#tituloModal').html('Esta a punto de eliminar definitivamente los clientes inactivos seleccionados!');
    $('#cuerpoModal').html('<p>Esta seguro que desea borrarlos ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarMultiCliInactivos()" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteMultiCliAnulados() {
    $('#tituloModal').html('Esta a punto de eliminar definitivamente los clientes anulados seleccionados!');
    $('#cuerpoModal').html('<p>Esta seguro que desea borrarlos ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarMultiCliAnulados()" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteMultiCliBorrados() {
    $('#tituloModal').html('Esta a punto de eliminar definitivamente los clientes borrados seleccionados!');
    $('#cuerpoModal').html('<p>Esta seguro que desea borrarlos ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarMultiCliBorrados()" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

  $(document).ready(function() {
    
    //$(".dropdown-menu").hide();
      Calendar.setup({
        inputField : "fecha_inicio",
        trigger    : "trigger",
        dateFormat : "%d/%m/%Y",
        onSelect   : function() { this.hide() }
      });    
      
      Calendar.setup({
        inputField : "fecha_fin",
        trigger    : "trigger1",
        dateFormat : "%d/%m/%Y",
        onSelect   : function() { this.hide() }
      });     
      
    $("#capa_ordenamiento_productos").sortable({
      handle : '.handle',
      update : function () {
        var order = $(this).sortable('serialize');
        alert(order);
        ordProductos(order);  
        //$("#capa_ordenamiento_productos").load("mainpanel/catalogo/ordenar_productos/"+order);
      }
    });
    
    $(".fila_precio").hide();
    $(".fila_precio:eq(0)").show();
    
    num_precios=$("#num_precios").val();    
    for(e=0;e<num_precios;e++){
        $(".fila_precio:eq("+e+")").show();
    }

});
function muestra_precio(num){
    $(".fila_precio:eq("+num+")").show(); 
}
function deleteFoto(id_fp) {
    $('#tituloModal').html('Esta a punto de borrar la foto!');
    $('#cuerpoModal').html('<p>Esta seguro de borrar la foto?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/catalogo/delete_foto/'+id_fp+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function eliminarColor(id) {
    $('#tituloModal').html('Esta a punto de borrar el color de este producto!');
    $('#cuerpoModal').html('<p>Esta seguro de borrar el Color?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarColor(\''+id+'\')" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}
function eliminarPrecio(id) {
    $('#tituloModal').html('Esta a punto de borrar el precio de este producto!');
    $('#cuerpoModal').html('<p>Esta seguro de borrar el Precio?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="javascript:borrarPrecio(\''+id+'\')" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteUnidad(id_unidad,texto) {
    $('#tituloModal').html('Esta a punto de borrar la unidad '+texto+'!');
    $('#cuerpoModal').html('<p>Esta seguro de borrar la Unidad ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/unidades/delete_unidad/'+id_unidad+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteCargo(id,concepto) {
    $('#tituloModal').html('Esta a punto de borrar el cargo adicional: '+concepto+'!');
    $('#cuerpoModal').html('<p>Esta seguro que quiere hacerlo ?</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/cargos/delete_cargo/'+id+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function valida_cargo() {
    concepto = $("#concepto").val();
    if(concepto=="")
    {
        alert('Debe ingresar el concepto del cargo');
        return false;
    }
    monto = $("#monto").val();
    if(monto=="")
    {
        alert('Debe ingresar el monto del cargo');
        return false;
    }
}

function agrega_color() {
	var rgb2 = $("#rgb2").val();
       
	if(rgb2=="")
	{
		alert('Ingrese el color');
		$("#rgb2").focus();
		return false;
	}
	else
	{
            num=$('#capa_colores .div_colores').size();
            str='';
            str+='<div class="div_colores" style="float:left;margin: 5px;width: 47px;min-height: 30px">';
            str+='<div title="'+rgb2+'" style="width: 47px;height: 30px;border:#000 solid 1px;background:'+rgb2+';"></div>';
            str+='<div>Stock:<input type="text" class="span10 typeahead" id="stock_color_'+num+'" name="stock_color_'+num+'"/><input type="hidden" id="color_'+num+'" name="color_'+num+'" value="'+rgb2+'" /></div>';
            str+='<div><a href="javascript:eliminarColorNew(\''+num+'\')">Eliminar</a></div>';
            str+='</div>';
            $('#capa_colores').append(str);
            $('#num_colores').val(num+1);
	}
}

function eliminarColorNew(num){
   $(".div_colores:eq("+num+")").remove();
}
function eliminaPrecioNew(num){
   $(".fila_precio:eq("+num+")").remove();
}

function deleteCategoriaColor(id_categoria, num_colores) {
    $('#tituloModal').html('Esta a punto de borrar esta Familia!');
    $('#cuerpoModal').html('<p>Esta Familia tiene: <strong>'+num_colores+' colore(s)</strong>.</p><p>Al borrar la familia se eliminaran todos sus colores</p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/colores/delete/'+id_categoria+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function deleteColor(id_color) {
    $('#tituloModal').html('Esta a punto de borrar este Color!');
    $('#cuerpoModal').html('<p></p>');
    str = '<a href="#" class="btn" data-dismiss="modal">CANCELAR</a>';
    str += '<a href="mainpanel/colores/delete_color/'+id_color+'" class="btn btn-primary">BORRAR</a>';
    $('#botoneraModal').html(str);
    $('#botoneraModal').show();
    $('#myModal').modal('show');    
}

function valida_busqueda_visita(){
    id_cliente=$("#id_cliente").val();
    fecha_inicio=$("#fecha_inicio").val();
    fecha_fin=$("#fecha_fin").val();
    if(id_cliente==0 && fecha_inicio=="" && fecha_fin==""){
        alert("Debe ingresar algun criterio de busqueda");
        return false;
    }    
}

function valida_busqueda_pedidos(){
    fecha_inicio=$("#fecha_inicio").val();
    fecha_fin=$("#fecha_fin").val();
    if(id_cliente==0 && fecha_inicio=="" && fecha_fin==""){
        alert("Debe ingresar algun criterio de busqueda");
        return false;
    }    
}

function valida_busqueda(){
    razon_social=$("#razon_social").val();
	nombre = $("#nombre").val();
    ruc=$("#ruc").val();
    telefono=$("#telefono").val();
    email=$("#email").val();    
    if(ruc=="" && razon_social=="" && nombre=="" && telefono=="" && email=="")
	{
        alert("Debe ingresar algun criterio de busqueda");
        $("#razon_social").focus();        
        return false;
    }    
}
function valida_color() {
    id_categoria=$("#id_categoria").val();
    if(id_categoria==0){
        alert("Debe elejir una Familia");
        $("#id_categoria").focus();        
        return false;
    }
    nombre=$("#nombre").val();
    if(nombre==""){
        alert("Debe ingresar el nombre");
        $("#nombre").focus();        
        return false;
    }    
    rgb2=$("#rgb2").val();
    if(rgb2==""){
        alert("Debe ingresar el color");
        $("#rgb2").focus();        
        return false;
    }     
    orden=$("#orden").val();
    if(orden==""){
        alert("Debe ingresar el orden");
        $("#orden").focus();        
        return false;
    }     
}
function eliminando_color(id){
   $("#div_color_ind_"+id).remove();
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