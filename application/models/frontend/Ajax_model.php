<?php
class Ajax_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    
    public function getContenidoModal($seccion) {
        $this->db->select('titulo, texto');
        $this->db->where('seccion', $seccion);
        $query =  $this->db->get('textos_web');
        return $query->row();		
    }
    
    public function getEmailGerente($id) {
        $this->db->select('email');
        $this->db->where('id', $id);
        $query =  $this->db->get('inscritos');
        return $query->row('email');	
    }
	
    public function getProducto($id_producto) {
        $this->db->select('nombre,codigo');
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }  

    public function getPrecio($id_unidad,$id_producto) {
        $this->db->select('precio');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_unidad', $id_unidad);        
        $query =  $this->db->get('precios');
        return $query->row();
    }
	
    public function getPorcentajeDescuento($id_producto) {
        $this->db->select('descuento_especial');
        $this->db->where('id_producto', $id_producto);    
        $query =  $this->db->get('productos');
        return $query->row();		
    }
	
    public function grabaPedido($data) {
       $resultado = $this->db->insert('ordenes', $data);
       return $this->db->insert_id();
   }
   
    public function verifEmail($email) {
        $this->db->where('email', $email);
        $query =  $this->db->get('inscritos');
        return $query->num_rows();
    }  
	
    public function getDatosCliente($id_cliente) {
            $this->db->where('id',$id_cliente);           
            $query =  $this->db->get('inscritos');
            return $query->row();
    }
    
    public function nombreColor($id_color) {
        $this->db->select('nombre');
        $this->db->where('id', $id_color);    
        $query =  $this->db->get('colores');
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return 0;
        }
    }
    
    public function stockProducto($id_producto, $id_color) {
        $this->db->select('stock, stock_proximamente');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_color', $id_color);
        $query =  $this->db->get('stock_color');
        return $query->row();
    }
    
    public function actualizaStock($id_producto, $id_color, $data) {
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_color', $id_color);
        $this->db->update('stock_color', $data);
    }
    
    public function getListaCargos() {
        $this->db->where('estado','A');            
        $query =  $this->db->get('cargos_adicionales');
        return $query->result();
    }
    
    public function grabaReserva($data) {
       $resultado = $this->db->insert('reservas', $data);
       return $this->db->insert_id();
   }
   
   public function grabaDetalleReserva($data) {
       $resultado = $this->db->insert('reservas_detalle', $data);
       return $this->db->insert_id();
   }
   
   public function actualizaMonto($id_reserva, $data) {
       $this->db->where('id_orden', $id_reserva);
       $this->db->update('reservas', $data);
   }
	   
    #paginacion categorias
    public function getCategorias($offset, $rowsPerPage) {
        $this->db->where('estado','A');
        $this->db->order_by('orden');
        $this->db->limit($offset,$rowsPerPage);
        $query =  $this->db->get('categorias');
        return $query->result();
    } 
    public function getCategoriasPublicas($offset, $rowsPerPage) {
        $this->db->where('estado','A');
        $this->db->where('tipo','0');
        $this->db->order_by('orden');
        $this->db->limit($offset,$rowsPerPage);
        $query =  $this->db->get('categorias');
        return $query->result();
    }
    public function numCategorias() {
        $this->db->where('estado','A');
        $this->db->from('categorias');
        return $this->db->count_all_results();
    } 
    public function numCategoriasPublicas() {
        $this->db->where('estado','A');
        $this->db->where('tipo','0');
        $this->db->from('categorias');
        return $this->db->count_all_results();
    }

    public function numSubCategorias($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where('estado', 'A');
        $this->db->from('subcategorias');
        return $this->db->count_all_results();
    }

    public function getSubCategorias($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where('estado', 'A');
        $this->db->select('id_subcategoria, nombre, orden, estado');
        $this->db->order_by('orden');
        $query =  $this->db->get('subcategorias');
        return $query->result();
    }
    public function getStockColorByID($id) {
        $sql = "SELECT s.*,IF(p.id_producto IS NULL, ' ', p.nombre)AS nombre ";
        $sql .= " FROM stock_color s LEFT JOIN productos p ON s.id_producto=p.id_producto ";
        $sql .= " WHERE s.id = $id";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
}
?>