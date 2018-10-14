<?php
class Inventario extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('Validacion');
        $this->load->model('mainpanel/Inventario_model');
        $this->load->library('My_PHPMailer');                
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    //public function excel() {
//        $aux=$this->Inventario_model->getListaProductos();
//        foreach ($aux as $key) {
//            $id_producto=$key->id_producto;
//            $colores=$key->colores;
//            $cad=explode("@",$colores);
//            for($f=0;$f<count($cad);$f++){
//               $dato=array();
//               $dato['color']=$cad[$f];
//               $dato['id_producto']=$id_producto;
//               $dato['stock']='5';
//               $this->Inventario_model->grabaColor($dato);
//            }
//        }
        
        
//        $aux=$this->Inventario_model->getListaColores2();
//        foreach ($aux as $key) {
//            $id_producto=$key->id_producto;
//            $color=$key->color;            
//            $aux=$this->Inventario_model->consulta($color);
//            $data=array();
//            $data['id_color']=$aux->id;
//            $data['id_producto']=$id_producto;
//            $data['stock']='5';
//            $this->Inventario_model->grabaColorstock($data);                
//        }

//        $aux=$this->Inventario_model->getListaProductos();
//        foreach ($aux as $key) {
//            $id_producto=$key->id_producto;
//            $precio=$key->precio;
//            $data=array();            
//            if($precio<1){
//                $data['precio']='10';
//            }else{
//                $data['precio']=$precio;                
//            }
//            $data['id_producto']=$id_producto;
//            $data['id_unidad']='3';            
//            $data['moneda']='s';
//            $this->Inventario_model->grabaPrecio($data);
//        }
        
//        
//        $aux = $this->Inventario_model->getListaProductos();
//        $productos=array();
//        foreach ($aux as $prod) {
//            $aux2=array();
//            $aux3=$this->Inventario_model->getNomCategoria($prod->id_categoria_padre);
//            if(empty($aux3)){
//                $aux2['categoria']='';
//            }else{
//                $aux2['categoria']=$aux3->nombre_categoria;
//            }
//            $aux2['nombre']=$prod->nombre;
//            $aux2['codigo']=$prod->codigo;            
//            $aux2['stock']=$prod->stock;
//            $aux2['descripcion']=$prod->descripcion;
//            $aux2['material']=$prod->material;
//            $aux2['medidas']=$prod->medidas;
//            $aux2['area_impresion']=$prod->area_impresion;
//            $aux2['metodo_impresion']=$prod->metodo_impresion;
//            $productos[]=$aux2;
//        }
//        $dataPrincipal['productos']=$productos;
//        $this->load->view("mainpanel/inventario/index_view", $dataPrincipal);
//    }
    
    public function inicio() {
        $this->validacion->validacion_login();
        //GENERAL
        $theme = $this->config->item('admin_theme');
        $data['theme'] = $theme;
        $datos2 = array();
        $data['menu'] = $this->load->view('mainpanel/includes/menu', $datos2, true);
        $dataPrincipal['header'] = $this->load->view('mainpanel/includes/header_view', $data, true);
        $data['modal'] = $this->load->view('mainpanel/catalogo/modal_delete', $datos2, true);
        $dataPrincipal['footer'] = $this->load->view('mainpanel/includes/footer_view', $data, true); 
        $dataPrincipal["cuerpo"]="inventario/inventario_index";
        $this->load->view("mainpanel/includes/template", $dataPrincipal);
    }
    
    public function excel() {
        
        $this->validacion->validacion_login_frontend(); 
        $aux = $this->Inventario_model->getListaProductos();
        $aux3= $this->Inventario_model->getListaFamColores();                    
        $productos=array();
        foreach ($aux as $prod) {
            $aux2=array();
            $pantone=array();
            $id_categoria_padre=$prod->id_categoria_padre;
            $catt=$this->Inventario_model->getNomCategoria($id_categoria_padre);
            if(count($catt)>0){
                $aux2['nombre_categoria']=$catt->nombre_categoria;                            
            }else{
                $aux2['nombre_categoria']='Categoria no Definida';
            }              
            $id_producto=$prod->id_producto;
            $ult=$this->Inventario_model->getUltAct($id_producto);
            if(count($ult)>0){
                $aux2['ultima_fecha']=$ult->fecha;                            
            }else{
                $aux2['ultima_fecha']='0000-00-00';
            }             
            $aux2['id_producto']=$id_producto;
            foreach ($aux3 as $fam){
                $auxf=array();
                $id_cat=$fam->id;                
                $auxf['nombre']=$fam->nombre;                
                $colores=$this->Inventario_model->getListaColores($id_cat);
                $stock=array();
                foreach ($colores as $col){
                    $auxco=array();
                    $id_col=$col->id;                
                    $auxco['nombre']=$col->nombre;
                    $auxco['color']=$col->color;
                    $st=$this->Inventario_model->getStock($id_col,$id_producto);
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
            
            $aux8=$this->Inventario_model->getListaPrecios($id_producto);
            $precios=array();
            foreach ($aux8 as $value) {
                $aux4=array();
                $aux4['precio']=$value->precio;
                $aux5=$this->Inventario_model->getUnidad($value->id_unidad);
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
        $this->load->view("mainpanel/inventario/index_view", $dataPrincipal);
    }    

}
?>
