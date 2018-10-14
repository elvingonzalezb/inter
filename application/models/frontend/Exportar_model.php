<?php
class Exportar_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    
    public function getCategoriasTodas() {
        $this->db->where('estado','A');
        $this->db->where('incluir_en_inventario','1');
        $this->db->order_by('orden');
        $query =  $this->db->get('categorias');
        return $query->result();
    }

    public function getCategoriasPublicas() {
        $this->db->where('estado','A');
        $this->db->where('tipo','0');
        $this->db->where('incluir_en_inventario','1');
        $this->db->order_by('orden');
        $query =  $this->db->get('categorias');
        return $query->result();
    }
    
    public function getListaSubCategorias($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where('estado', 'A');
        $this->db->select('id_subcategoria, nombre, orden, estado');
        $this->db->order_by('orden');
        $query =  $this->db->get('subcategorias');
        return $query->result();
    }
    
    public function getListaProductos($id_subcategoria) {
        $sql = "SELECT distinct p.id_producto ";
        $sql .= "FROM (productos p INNER JOIN stock_color s ON p.id_producto=s.id_producto) INNER JOIN productos_x_subcategoria pxs ON p.id_producto=pxs.id_producto ";
        $sql .= "WHERE pxs.id_subcategoria='$id_subcategoria' AND s.stock>0 ORDER BY pxs.orden";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }
    
    
    
    
    
    
    public function getListaFamColores() {
        $query =  $this->db->get('cat_colores');
        return $query->result();
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
    
    public function getListaProductosTodas() {
        /*
        $this->db->order_by('id_categoria_padre');
        $this->db->order_by('orden');        
        $query =  $this->db->get('productos');
        */
        $sql = "SELECT productos.* FROM productos INNER JOIN categorias ON productos.id_categoria_padre=categorias.id_categoria ORDER BY categorias.orden";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getListaProductosPublicas() {
        /*
        $this->db->order_by('id_categoria_padre');
        $this->db->order_by('orden');        
        $query =  $this->db->get('productos');
        */
        $sql = "SELECT productos.* FROM productos INNER JOIN categorias ON productos.id_categoria_padre=categorias.id_categoria WHERE categorias.tipo='0' ORDER BY categorias.orden";
        $query = $this->db->query($sql);
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
    public function grabaColor($data) {
        $resultado = $this->db->insert('colores', $data);
        return $resultado;
    }
    
    public function getPorcentajeDescuento($id_producto) {
        $this->db->select('descuento_especial');
        $this->db->where('id_producto', $id_producto);    
        $query =  $this->db->get('productos');
        return $query->row();		
    }
    
        
}
?>
