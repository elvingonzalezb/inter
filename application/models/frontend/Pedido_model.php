<?php
class Pedido_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }

    public function listColores($id_producto) {
        $this->db->where('id_producto',$id_producto);            
        $query =  $this->db->get('colores');
        return $query->result();
    }

    public function getListaCargos() {
        $this->db->where('estado','A');            
        $query =  $this->db->get('cargos_adicionales');
        return $query->result();
    }

    public function getCategorias() {
        $this->db->where('estado','A');
        $this->db->order_by('orden','rand');
        $query =  $this->db->get('categorias');
        return $query->result();
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

    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }
    
    public function getFechaLlegada($id_producto, $id_color) {
        $this->db->select('fecha_llegada');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_color', $id_color);
        $query =  $this->db->get('stock_color');
        return $query->row('fecha_llegada');
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
        

}
?>