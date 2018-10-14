<?php
class Inventario_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getNomCategoria($id) {
        $this->db->select('nombre_categoria');
        $this->db->where('id_categoria',$id);
        $query = $this->db->get('categorias');
        return $query->row();
    }
    
    public function getUltAct($id_producto) {
        $this->db->select('fecha');        
        $this->db->where('id_producto',$id_producto);        
        $this->db->order_by('fecha','desc');
        $this->db->limit('1');
        $query = $this->db->get('actualizaciones_producto');
        return $query->row();
    }       
    
    public function getListaColores2() {
        $query =  $this->db->get('colores2');
        return $query->result();
    }
    public function consulta($color) {
        $this->db->where('color',$color);        
        $query =  $this->db->get('colores');
        return $query->row();
    }    
    
//    public function getListaProductos($id_categoria) {
//        $this->db->select('id_producto, nombre, imagen, codigo, tipo, orden,actualizacion');
//	$this->db->where('id_categoria_padre',$id_categoria);
//        $this->db->order_by('orden');
//        $query =  $this->db->get('productos');
//        return $query->result();
//    }	

    
    public function grabaColor($data) {
        $resultado = $this->db->insert('colores', $data);
        return $resultado;
    }
    public function grabaPrecio($data) {
        $resultado = $this->db->insert('precios', $data);
        return $resultado;
    }    
    
    public function grabaColorstock($data) {
        $resultado = $this->db->insert('stock_color', $data);
        return $resultado;
    }     

    public function getListaProductos() {
        $this->db->order_by('orden');
        $query =  $this->db->get('productos');
        return $query->result();
    }
    public function getListaFamColores() {
        $query =  $this->db->get('cat_colores');
        return $query->result();
    }   
    public function getListaColores($id_cat) {
        $this->db->where('id_categoria',$id_cat);
        $query = $this->db->get('colores');
        return $query->result();
    }    
    public function getListaPrecios($id_producto) {
        $this->db->where('id_producto',$id_producto);
        $query = $this->db->get('precios');
        return $query->result();
    } 
    
    public function getUnidad($id_unidad) {
        $this->db->select('texto');        
        $this->db->where('estado','A');        
        $this->db->where('id',$id_unidad);
        $query = $this->db->get('unidades');
        return $query->row();
    }      
    public function getStock($id_col,$id_producto) {
        $this->db->select('stock');        
        $this->db->where('id_color',$id_col);        
        $this->db->where('id_producto',$id_producto);
        $query = $this->db->get('stock_color');
        return $query->row();
    }     
 
            
}
?>
