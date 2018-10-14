<?php
class Ajax_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getNovedad($id_novedad) {
        $this->db->select('titulo, sumilla, foto');
        $this->db->where('id_novedad', $id_novedad);
        $query =  $this->db->get('novedades');
        return $query->row();
    }
    
    public function deleteProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('productos');
    }  
    
    public function eliminaColor($id) {
        $this->db->where('id', $id);
        $this->db->delete('colores');
    }    
    
    public function eliminaPrecio($id) {
        $this->db->where('id', $id);
        $this->db->delete('precios');
    }     
    
    public function getProd($id_producto) {
        $this->db->select('imagen,id_categoria_padre');
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }
    
    public function getDatosProducto($codigo) {
        $this->db->select('id_producto, nombre, imagen, codigo');
        $this->db->where('codigo', $codigo);
        $query =  $this->db->get('productos');
        return $query->row();
    }
    
    public function ordProd($id_producto, $data) {
        $this->db->where('id_producto', $id_producto);
        $this->db->update('productos_x_subcategoria', $data);
    }  
    
    public function limpiaOrdenSubcat($id_subcategoria) {
        $this->db->where('id_subcategoria', $id_subcategoria);
        $this->db->delete('productos_x_subcategoria');
    }
    
    public function grabarOrden($data) {
        $resultado = $this->db->insert('productos_x_subcategoria', $data);
        return $resultado;
    }
    
    public function desactivarCliente($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('inscritos', $data);
    }
    
    public function anulaCliente($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('inscritos', $data);
    }      
    
    public function updateProd($id_producto, $data) {
        $this->db->where('id_producto', $id_producto);
        $this->db->update('productos', $data);
    }
    
    public function revisaPedido($id_pedido, $data) {
        $this->db->where('id_orden', $id_pedido);
        $this->db->update('ordenes', $data);
    }
    
    public function deleteCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $this->db->delete('inscritos');
    } 
    public function muestraColor($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where('estado', 'A');
        $this->db->order_by ('orden');        
        $query =  $this->db->get('colores');
        return $query->result();
    } 
    public function getColor($id_color) {
        $this->db->where('id', $id_color);
        $query =  $this->db->get('colores');
        return $query->row();
    } 
    public function getNombreColor($id_color) {
        $this->db->where('id', $id_color);
        $query =  $this->db->get('colores');
        return $query->row('nombre');
    } 
    
    public function getColores($id) {
        $this->db->where('id_producto', $id);
        $query =  $this->db->get('stock_color');
       return $query->result();
    }
    
    public function getPrecio($id) {
        $this->db->where('id_producto', $id);
        $query =  $this->db->get('precios');
       return $query->result();
    }      
    
    public function getListaProductos($id_categoria) {
        $this->db->select('id_producto');
	$this->db->where('id_categoria_padre',$id_categoria);
        $query =  $this->db->get('productos');
        return $query->result();
    }
    public function updateStock($id_stock, $data) {
        $this->db->where('id', $id_stock);
        $this->db->update('stock_color', $data);
    }      
    
    public function updatePrecio($id_precio, $data) {
        $this->db->where('id', $id_precio);
        $this->db->update('precios', $data);
    }
    
    public function getListaSubCategorias($id_categoria) {
        $this->db->select('id_subcategoria, nombre');
        $this->db->where('id_categoria', $id_categoria);
        $this->db->order_by('orden');
        $query =  $this->db->get('subcategorias');
        return $query->result();
    }
    
    public function getNombreCategoria($id_categoria) {
        $this->db->select('nombre_categoria');
        $this->db->where('id_categoria', $id_categoria);
        $query =  $this->db->get('categorias');
        return $query->row();
    }
    
    public function getNombreSubCategoria($id_subcategoria) {
        $this->db->select('nombre');
        $this->db->where('id_subcategoria', $id_subcategoria);
        $query =  $this->db->get('subcategorias');
        return $query->row();
    }
}
?>