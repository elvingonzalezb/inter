<?php
class Exportar extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('frontend/Exportar_model');
        //$this->load->library('Validacion');
        $this->load->library('My_PHPMailer');          
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function excel() {
        $aux3 = $this->Exportar_model->getListaFamColores();
        $listaFamilia = array();
        foreach ($aux3 as $fam) {
            $auxFamilia = array();
            $auxFamilia['id'] = $fam->id;
            $auxFamilia['nombre'] = $fam->nombre;
            $listaFamilia[] = $auxFamilia;            
        }
        $estaLogueado = $this->session->userdata('logueadocki');                
        if($estaLogueado==true)
        {
            $veEspeciales = $this->session->userdata('categorias_especiales');
            if($veEspeciales=="si")
            {
                $categorias = $this->Exportar_model->getCategoriasTodas();
            }
            else
            {
               $categorias = $this->Exportar_model->getCategoriasPublicas(); 
            }
        }
        else
        {
           $categorias = $this->Exportar_model->getCategoriasPublicas();
        }
        $listaCategorias = array();
        foreach($categorias as $categoria)
        {
            $auxCats = array();
            $auxCats['id_categoria'] = $categoria->id_categoria;
            if($categoria->id_categoria!=26)
            {
                $auxCats['nombre_categoria'] = $categoria->nombre_categoria;
                $subcategorias = $this->Exportar_model->getListaSubCategorias($categoria->id_categoria);
                $subcategoriasItem = array();
                $num_subcats = 0;
                foreach($subcategorias as $subcategoria)
                {
                    $auxSubCats = array();
                    $auxSubCats['id_subcategoria'] = $subcategoria->id_subcategoria;
                    $auxSubCats['nombre'] = $subcategoria->nombre;

                    $productos = $this->Exportar_model->getListaProductos($subcategoria->id_subcategoria);
                    $arrayProductos = array();
                    $numeroProductos = 0; 
                    foreach($productos as $producto)
                    {
                        $aux4 = array();
                        $aux4['id_producto'] = $producto->id_producto;                    
                        $aux_producto = $this->Exportar_model->getProducto($producto->id_producto);
                        $aux4['nombre'] = $aux_producto->nombre;
                        $aux4['imagen'] = $aux_producto->imagen;
                        $aux4['codigo'] = $aux_producto->codigo;
                        $aux4['tiene_descuento'] = $aux_producto->descuento;
                        $descuento_especial = $aux_producto->descuento_especial;
                        $aux4['porcentaje_descuento'] = $descuento_especial;

                        $ult=$this->Exportar_model->getUltAct($producto->id_producto);
                        if(count($ult)>0){
                            $aux4['ultima_fecha']=$ult->fecha;                            
                        }else{
                            $aux4['ultima_fecha']='0000-00-00';
                        } 
                        $pantone=array();
                        foreach ($aux3 as $fam){
                            $auxf=array();
                            $id_cat=$fam->id;                
                            $auxf['nombre']=$fam->nombre;                
                            $colores=$this->Exportar_model->getListaColores($id_cat);
                            $stock=array();
                            foreach ($colores as $col){
                                $auxco=array();
                                $id_col=$col->id;                
                                $auxco['nombre']=$col->nombre;
                                $auxco['color']=$col->color;
                                $st=$this->Exportar_model->getStock($id_col,$producto->id_producto);
                                if(count($st)>0){
                                    $auxco['stock']=$st->stock;
                                }else{
                                    $auxco['stock']='0';                        
                                }
                                $stock[]=$auxco;
                            }
                            $auxf['color_stock']=$stock;
                            $pantone[]=$auxf;
                        }
                        $aux4['pantone']=$pantone;

                        $aux8=$this->Exportar_model->getListaPrecios($producto->id_producto);
                        $precios=array();
                        foreach ($aux8 as $value) {
                            $aux9=array();
                            $id_unidad_current = $value->id_unidad;
                            $precio_current = $value->precio;
                            if($this->session->userdata('descuento_especial')=="si")
                            {
                                // A este cliente aplica descuento especial
                                $aux_porc = $this->Exportar_model->getPorcentajeDescuento($producto->id_producto);
                                $porcentaje_descuento = $aux_porc->descuento_especial;
                                if($porcentaje_descuento>0)
                                {
                                    /*
                                    // ESTO CORREGIDO EL 19 AGO 2015 PORQUE NO COINCIDIAN
                                    // LO QUE SE MOSTRABA EN LA WEB Y LO Q SALE EN EL EXCEL
                                    $porc_con_descuento = 100 - $porcentaje_descuento;
                                    $precio_uax = ($porc_con_descuento/100)*($precio_current);
                                    $el_precio = round($precio_uax, 3, PHP_ROUND_HALF_UP) + 0.001;
                                    */
                                    $ratio_de = (100 - $porcentaje_descuento)/100;
                                    $ratio_de = redondeado($ratio_de, 3);
                                    $el_precio = ($value->precio)*$ratio_de;
                                }
                                else
                                {
                                    $el_precio = $precio_current;
                                }
                            }
                            else
                            {
                                    $el_precio = $precio_current;
                            }
                            $aux9['precio']=$el_precio;
                            $aux5=$this->Exportar_model->getUnidad($value->id_unidad);
                            $aux9['unidad']=$aux5->texto;
                            $precios[]=$aux9;
                        }
                        $aux4['precios']=$precios;

                        $arrayProductos[] = $aux4;
                        $numeroProductos++;
                    } // foreach
                    //$aux2["productos"] = implode("@@", $productos);
                    $auxSubCats['numero_productos'] = $numeroProductos;
                    $auxSubCats["productos"] = $arrayProductos;

                    $subcategoriasItem[] = $auxSubCats;
                    $num_subcats++;
                }// foreach
                $auxCats['subcategorias'] = $subcategoriasItem;
                $auxCats['num_subcats'] = $num_subcats;
                $listaCategorias[] = $auxCats;
            }
        } // foreach
        
        $dataPrincipal['familias'] = $listaFamilia;
        $dataPrincipal['categorias']=$listaCategorias;
        $dataPrincipal['base_url']=  base_url(); 
        $this->load->view("frontend/construye_excel", $dataPrincipal);
        
    }
    
    public function excel_old() {
        
        $this->validacion->validacion_login_frontend();
        $veEspeciales = $this->session->userdata('categorias_especiales');
        if($veEspeciales=="si")
        {
            $aux = $this->Exportar_model->getListaProductosTodas();
        }
        else
        {
           $aux = $this->Exportar_model->getListaProductosPublicas(); 
        }
        $aux3= $this->Exportar_model->getListaFamColores();                    
        $productos=array();
        foreach ($aux as $prod) {
            $aux2=array();
            $pantone=array();
            $id_producto=$prod->id_producto;
            $ult=$this->Exportar_model->getUltAct($id_producto);
            if(count($ult)>0){
                $aux2['ultima_fecha']=$ult->fecha;                            
            }else{
                $aux2['ultima_fecha']='0000-00-00';
            }                        
            $id_categoria_padre=$prod->id_categoria_padre;
            $catt=$this->Exportar_model->getNomCategoria($id_categoria_padre);
            if(count($catt)>0){
                $aux2['nombre_categoria']=$catt->nombre_categoria;                            
            }else{
                $aux2['nombre_categoria']='Categoria no Definida';
            }            
            $aux2['id_producto']=$id_producto;
            foreach ($aux3 as $fam){
                $auxf=array();
                $id_cat=$fam->id;                
                $auxf['nombre']=$fam->nombre;                
                $colores=$this->Exportar_model->getListaColores($id_cat);
                $stock=array();
                foreach ($colores as $col){
                    $auxco=array();
                    $id_col=$col->id;                
                    $auxco['nombre']=$col->nombre;
                    $auxco['color']=$col->color;
                    $st=$this->Exportar_model->getStock($id_col,$id_producto);
                    if(count($st)>0){
                        $auxco['stock']=$st->stock;
                    }else{
                        $auxco['stock']='0';                        
                    }
                    $stock[]=$auxco;
                }
                $auxf['color_stock']=$stock;
                $pantone[]=$auxf;
            }
            $aux2['pantone']=$pantone;
            
            $aux8=$this->Exportar_model->getListaPrecios($id_producto);
            $precios=array();
            foreach ($aux8 as $value) {
                $aux4=array();
                $id_unidad_current = $value->id_unidad;
                $precio_current = $value->precio;
                if($this->session->userdata('descuento_especial')=="si")
                {
                    // A este cliente aplica descuento especial
                    $aux_porc = $this->Exportar_model->getPorcentajeDescuento($id_producto);
                    $porcentaje_descuento = $aux_porc->descuento_especial;
                    if($porcentaje_descuento>0)
                    {
                        $porc_con_descuento = 100 - $porcentaje_descuento;
                        $precio_uax = ($porc_con_descuento/100)*($precio_current);
                        $el_precio = round($precio_uax, 3, PHP_ROUND_HALF_UP) + 0.001;
                    }
                    else
                    {
                        $el_precio = $precio_current;
                    }
                }
                else
                {
                        $el_precio = $precio_current;
                }
                $aux4['precio']=$el_precio;
                $aux5=$this->Exportar_model->getUnidad($value->id_unidad);
                $aux4['unidad']=$aux5->texto;
                $precios[]=$aux4;
            }
            $aux2['precios']=$precios;            
            $aux2['nombre']=$prod->nombre;
            $aux2['codigo']=$prod->codigo;            
            $aux2['imagen']=$prod->imagen;
            $aux2['descuento']=$prod->descuento;            
            $aux2['base_url']=  base_url();            
            $productos[]=$aux2;
        }
        $dataPrincipal['familias'] = $aux3;
        $dataPrincipal['productos']=$productos;
        
//        $correo_notificaciones = getConfig('correo_notificaciones');
//        $razonCliente = $this->session->userdata('ses_razon');
//        // ENVIO  DE MAIL DE VERIFICACION CON EL PHP MAILER
//        $mail = new PHPMailer();
//        $mail->From = $correo_notificaciones; // direccion de quien envi
//        $mail->FromName = "Exportaron en Excel"; // nombre de quien envia
//        $mail->AddAddress($correo_notificaciones);
//        $mail->Subject = $razonCliente." acaba de generar un inventario en Excel desde el Portal CKI"; 
//        
//        $msg = "<h1>Se ha generado un archivo de inventario</h1>";
//        $msg .= "===============================================================<br>\n";
//        $msg .= $razonCliente." acaba de generar un inventario en Excel desde el Portal de CKI"; 
//        $msg .= "===============================================================<br />\n";        
//        $msg .= "Atte. <br>\n";
//        $msg .= "La Administracion de CKI INTERNACIONAL<br>\n";
//        
//        $mail->Body = $msg;
//        $mail->IsHTML(true);
//        @$mail->Send();
        
        $this->load->view("frontend/esporta_excel", $dataPrincipal);
    }
    

}
?>
