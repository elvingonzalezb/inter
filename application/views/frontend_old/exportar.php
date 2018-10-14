<?php
class Exportar extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('validacion');
        $this->load->model('frontend/Exportar_model');
        $this->load->library('validacion');
    }
    
    public function index() {
        $this->validacion->validacion_login();
    }
    
    public function excel() {
        
        $this->validacion->validacion_login_frontend(); 
        $aux = $this->Exportar_model->getListaProductos();
        $aux3= $this->Exportar_model->getListaFamColores();                    
        $productos=array();
        foreach ($aux as $prod) {
            $aux2=array();
            $pantone=array();
            $id_producto=$prod->id_producto;
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
                $aux4['precio']=$value->precio;
                $aux5=$this->Exportar_model->getUnidad($value->id_unidad);
                $aux4['unidad']=$aux5->texto;
                $precios[]=$aux4;
            }
            $aux2['precios']=$precios;            
            $aux2['nombre']=$prod->nombre;
            $aux2['codigo']=$prod->codigo;            
            $aux2['imagen']=$prod->imagen;
            $aux2['base_url']=  base_url();            
            $productos[]=$aux2;
        }
        $dataPrincipal['productos']=$productos;
        $this->load->view("frontend/esporta_excel", $dataPrincipal);
    }
    

}
?>
