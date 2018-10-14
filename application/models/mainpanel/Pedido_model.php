<?php
class Pedido_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaPedidos() {
        $this->db->select('id_orden,id_cliente,total,estado, fecha_ingreso, pedidos');
        $this->db->order_by('fecha_ingreso','desc');
        $query =  $this->db->get('ordenes');
        return $query->result();
    }
    
    public function getListaPedidosFechas($fecha_inicio, $fecha_fin) {
        /*
        $this->db->select('id_orden,id_cliente,total,estado, fecha_ingreso, pedidos');
        $where = "fecha_ingreso>='$fecha_inicio' AND fecha_ingreso<='$fecha_fin'";
        $this->db->where($where);
        $this->db->order_by('fecha_ingreso','desc');
        $query =  $this->db->get('ordenes');
        */
        $sql = "SELECT id_orden,id_cliente,total,estado, fecha_ingreso, pedidos FROM ordenes WHERE fecha_ingreso>='$fecha_inicio' AND fecha_ingreso<='$fecha_fin' ORDER BY fecha_ingreso DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getListaPedidosPagina($num_regs, $inicial) {
        $this->db->select('id_orden,id_cliente,total,estado, fecha_ingreso, pedidos');
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit($num_regs, $inicial);
        $query =  $this->db->get('ordenes');
        return $query->result();
    }
    
    public function doSearchPedidos($fecha_inicio, $fecha_fin) {
        $sql = "SELECT id_orden,id_cliente,total,estado, fecha_ingreso, pedidos FROM ordenes WHERE id_orden>0 ";        
        if($fecha_inicio<>''){
            $sql.=" and fecha_ingreso >= '".$fecha_inicio."'";
        }
        if($fecha_fin<>''){
            $sql.=" and fecha_ingreso <= '".$fecha_fin."'";
        }		
        $sql.=" ORDER BY fecha_ingreso desc";
        $query = $this->db->query($sql);
        return $query->result();
    }            
    
    public function getNumPedidos() {
        $query =  $this->db->get('ordenes');
        $num_pedidos = $query->num_rows();
        return $num_pedidos;
    }
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }    
    
    public function getOrden($id_orden) {
        $this->db->where('id_orden', $id_orden);
        $query =  $this->db->get('ordenes');
        return $query->row();
    }
	
    public function deletePedido($id_orden) {
        $this->db->where('id_orden', $id_orden);
        $this->db->delete('ordenes');
    } 
	
    public function updateEstadoOrden($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('ordenes', $data);
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
        $this->db->select('stock');
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
}
?>
