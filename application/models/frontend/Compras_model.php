<?php
class Compras_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    
    public function getNumCompras($id_cliente) {        
        $this->db->where('id_cliente', $id_cliente);
        //$query =  $this->db->get('ordenes');
        // SE SACA DE TABLA DE COMPRAS, YA NO DE ORDENES
        $query =  $this->db->get('compras');
        $num_pedidos = $query->num_rows();
        return $num_pedidos;
    }
    
    public function getListaComprasPagina($num_regs, $inicial, $id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit($num_regs, $inicial);
        //$query =  $this->db->get('ordenes');
        // SE SACA DE TABLA DE COMPRAS, YA NO DE ORDENES
        $query =  $this->db->get('compras');
        //$query = $this->db->query("SELECT id_orden,id_cliente,total,estado, fecha_ingreso, pedidos FROM ordenes WHERE id_cliente='".$id_cliente."' LIMIT ".$inicial.", ".$num_regs);
        return $query->result();
    }
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }
    
    public function getCompra($id) {
        $this->db->where('id_orden', $id);
        //$query =  $this->db->get('ordenes');
        // SE SACA DE TABLA DE COMPRAS, YA NO DE ORDENES
        $query =  $this->db->get('compras');
        return $query->row();
    }
    
    public function guardarCompra($data) {
        $resultado = $this->db->insert('ordenes', $data);
        return $this->db->insert_id();
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
    
    public function getListaDetalles($id_reserva) {
        $this->db->where('id_compra',$id_reserva);            
        $query =  $this->db->get('compras_detalle');
        return $query->result();
    }
    
    
}
?>
