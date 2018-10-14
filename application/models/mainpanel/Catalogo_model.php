<?php
class Catalogo_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaCategorias() {
        $this->db->select('id_categoria, nombre_categoria, imagen, orden, estado, tipo, incluir_en_inventario');
        $this->db->order_by('orden');
        $query =  $this->db->get('categorias');
        return $query->result();
    }
    
    public function getListaSubCategorias($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->select('id_subcategoria, nombre, orden, estado');
        $this->db->order_by('orden');
        $query =  $this->db->get('subcategorias');
        return $query->result();
    }

    public function numeroProductos($id_subcategoria) {
        $this->db->where('id_subcategoria', $id_subcategoria);
        $query =  $this->db->get('productos_x_subcategoria');
        return $query->num_rows();
    }
    
    public function numeroSubcategorias($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $query =  $this->db->get('subcategorias');
        return $query->num_rows();
    }
    
    public function getCategoria($id_registro) {
        $this->db->where('id_categoria', $id_registro);
        $query =  $this->db->get('categorias');
        return $query->row();
    }
    
    public function getSubCategoria($id_registro) {
        $this->db->where('id_subcategoria', $id_registro);
        $query =  $this->db->get('subcategorias');
        return $query->row();
    }
	
    public function deleteCategoria($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->delete('categorias');
    }
    
    public function deleteSubCategoria($id_subcategoria) {
        $this->db->where('id_subcategoria', $id_subcategoria);
        $this->db->delete('subcategorias');
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
    
    public function getNombreCategoria($id_categoria) {
        $this->db->select('nombre_categoria');
        $this->db->where('id_categoria', $id_categoria);
        $query =  $this->db->get('categorias');
        return $query->row();
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
    
    public function grabarSubCategoria($data) {
       $resultado = $this->db->insert('subcategorias', $data);
       return $resultado; 
    }
    
    public function actualizarSubCategoria($id_subcategoria, $data) {
        $this->db->where('id_subcategoria', $id_subcategoria);
        $this->db->update('subcategorias', $data);
    }

    public function grabarFechaActua($dd) {
        $resultado = $this->db->insert('actualizaciones_producto', $dd);
        return $resultado;
    }    

    public function getListaProductos($id_subcategoria) {
        $sql = "SELECT p.id_producto, p.nombre, p.imagen, p.codigo, p.tipo, p.orden, p.actualizacion ";
        $sql .= "FROM productos p INNER JOIN productos_x_subcategoria pxs ON p.id_producto=pxs.id_producto ";
        $sql .= "WHERE pxs.id_subcategoria='$id_subcategoria' ORDER BY pxs.orden";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getListaSubCategorias_x_Prod($id_producto) {
        $this->db->select('id_subcategoria');
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos_x_subcategoria');
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
    
    public function grabarSubCatsElegidas($id_producto, $subcats_elegidas) {
        $aux = explode("#", $subcats_elegidas);
        for($i=0; $i<count($aux); $i++)
        {
            $current = $aux[$i];
            $data = array();
            $data['id_subcategoria'] = $current;        
            $data['id_producto'] = $id_producto;
            $data['orden'] = 1;
            $resultado = $this->db->insert('productos_x_subcategoria', $data);
        }
    }
    
    public function actualizarSubCatsElegidas($id_producto, $subcats_elegidas) {
        // Primero limpiamos los registros de este producto
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('productos_x_subcategoria');
        // Ahora volvemos a grabar con los datos actualizados
        $aux = explode("#", $subcats_elegidas);
        for($i=0; $i<count($aux); $i++)
        {
            $current = $aux[$i];
            $data = array();
            $data['id_subcategoria'] = $current;        
            $data['id_producto'] = $id_producto;
            $data['orden'] = 1;
            $this->db->insert('productos_x_subcategoria', $data);
        }
    }
    
    public function deleteProductoxSubCats($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $this->db->delete('productos_x_subcategoria');
    }

    public function deleteProductoxSubCats2($id_subcategoria) {
        $this->db->where('id_subcategoria', $id_subcategoria);
        $this->db->delete('productos_x_subcategoria');
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
    
    public function getListaProximos() {
        $this->db->where('stock_proximamente >', 0);
        $this->db->order_by('orden_proximamente');
        $this->db->order_by('id_producto');
        $this->db->order_by('id_color');
        $query =  $this->db->get('stock_color');
        return $query->result();
    }
    
    public function updateStockColor($id, $data) {
        $query = $this->db
                ->where('id', $id)
                ->update('stock_color', $data);
        return $query;
    }   
    public function getColorById($id) {
        $sql = "SELECT s.*,IF(c.id IS NULL, ' ', c.id_categoria)AS id_cat ";
        $sql .= " FROM stock_color s LEFT JOIN colores c ON s.id_color=c.id ";
        $sql .= " WHERE s.id = $id";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function muestraColor($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where('estado', 'A');
        $this->db->order_by ('orden');        
        $query =  $this->db->get('colores');
        return $query->result_array();
    }

    public function deleteColorFoto($id_color) {
        $this->db->where('id', $id_color);
        $this->db->delete('stock_color');
    }

}
?>