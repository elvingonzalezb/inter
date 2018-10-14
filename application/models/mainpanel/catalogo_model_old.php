<?php
class Catalogo_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaCategorias() {
        $this->db->select('id_categoria, nombre_categoria, imagen, orden, estado, tipo');
        $this->db->order_by('orden');
        $query =  $this->db->get('categorias');
        return $query->result();
    }
    
    public function numeroProductos($id_categoria) {
        $this->db->where('id_categoria_padre', $id_categoria);
        $query =  $this->db->get('productos');
        return $query->num_rows();
    }
    
    public function getCategoria($id_registro) {
        $this->db->where('id_categoria', $id_registro);
        $query =  $this->db->get('categorias');
        return $query->row();
    }
	
    public function deleteCategoria($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->delete('categorias');
    }
	
    public function deleteProductos($id_categoria) {
        $this->db->where('id_categoria_padre', $id_categoria);
        $this->db->delete('productos');
    }	
    

    public function getFotosProductos($id_producto) {
        $this->db->where('id_prod', $id_producto);
        $this->db->order_by('orden');		
        $query = $this->db->get('foto_prod');
        return $query->result();
    }
	
    public function deleteFotosProd($id_categoria) {
        $this->db->join('productos', 'id_categoria_padre='.$id_categoria, 'inner');
        $this->db->delete('foto_prod');
    }	
	
    public function updateCategoria($id_categoria, $data) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->update('categorias', $data);
    }
	
    public function grabarCategoria($data) {
        $resultado = $this->db->insert('categorias', $data);
        return $resultado;
    }
    public function grabarFechaActua($dd) {
        $resultado = $this->db->insert('actualizaciones_producto', $dd);
        return $resultado;
    }    

	
    public function getListaProductos($id_categoria) {
        $this->db->select('id_producto, nombre, imagen, codigo, tipo, orden,actualizacion');
	$this->db->where('id_categoria_padre',$id_categoria);
        $this->db->order_by('orden');
        $query =  $this->db->get('productos');
        return $query->result();
    }	
	
    public function getProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }	
    
    public function updateProducto($id_producto, $data) {
        $this->db->where('id_producto', $id_producto);
        $this->db->update('productos', $data);
    }    
    
    public function grabarProducto($data) {
        $this->db->insert('productos', $data);
        $resultado=$this->db->insert_id();
        return $resultado;
    }	    
    
    public function deleteProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('productos');
    }    
    
    public function grabarFoto($data) {
        $resultado = $this->db->insert('foto_prod', $data);
        return $resultado;
    }   
 
    public function getfoto($id_foto) {
        $this->db->where('id_fp', $id_foto);
        $query =  $this->db->get('foto_prod');
        return $query->row();
    }    
    
    public function updateFoto($id_fp, $data) {
        $this->db->where('id_fp', $id_fp);
        $this->db->update('foto_prod', $data);
    } 
    public function deleteFoto($id_fp) {
        $this->db->where('id_fp', $id_fp);
        $this->db->delete('foto_prod');
    }      
    
    public function getListaUnidades() {
	$this->db->where('estado','A');
        $query =  $this->db->get('unidades');
        return $query->result();
    }  
    public function getPrecio($id) {
        $this->db->where('id_producto', $id);
        $query =  $this->db->get('precios');
       return $query->result();
    }    
    public function getUnidad($id) {
        $this->db->where('id', $id);
        $query =  $this->db->get('unidades');
       return $query->row();
    }     
    public function getColores($id) {
        $this->db->where('id_producto', $id);
        $query =  $this->db->get('stock_color');
       return $query->result();
    } 
    public function getCol($id) {
        $this->db->where('id', $id);
        $query =  $this->db->get('colores');
       return $query->row();
    }     
    
    public function getListaFamilia() {
        $query =  $this->db->get('cat_colores');
       return $query->result();
    }
    public function listColores() {
        $query =  $this->db->get('colores');
       return $query->result();
    }     
    
    public function grabarPrecio($data) {
        $resultado = $this->db->insert('precios', $data);
        return $resultado;
    }	
    
    public function updatePrecio($id_precio, $data) {
        $this->db->where('id', $id_precio);
        $this->db->update('precios', $data);
    }
    public function updateColor($id_color, $data) {
        $this->db->where('id', $id_color);
        $this->db->update('colores', $data);
    }    
    
    public function grabarColor($data) {
        $resultado = $this->db->insert('stock_color', $data);
        return $resultado;
    }
    public function deleteColor($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('stock_color');
    }      
    public function deletePrecio($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('precios');
    }         
    
}
?>
