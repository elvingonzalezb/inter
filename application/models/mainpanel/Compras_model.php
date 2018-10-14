<?php
class Compras_model extends CI_Model {
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
    
    public function getNumCompras($estado) {
        $query =  $this->db->get('compras');
        //$this->db->where('estado', $estado);
        $num_pedidos = $query->num_rows();
        return $num_pedidos;
    }
    
    public function getListaComprasPagina($num_regs, $inicial) {
        //$this->db->select('id_orden,id_cliente,total,estado, fecha_ingreso, pedidos, forma_pago, banco, numero_operacion, fecha_pago, observaciones, numero_cargos, monto_cargos, lista_cargos, estado_pago');
        //$this->db->where('estado', 'Activa');
        //$this->db->order_by('fecha_ingreso','desc');
        //$this->db->limit($num_regs, $inicial);
        //$query =  $this->db->get('compras');
        $sql = "SELECT * FROM compras ORDER BY fecha_ingreso desc LIMIT ".$inicial.", ".$num_regs;        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getListaCompras() {
        $this->db->order_by('fecha_ingreso','desc');
        $query =  $this->db->get('compras');
        return $query->result();
    }

    public function getListaComprasUlt6meses($hace_6_meses) {
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->where('fecha_ingreso >', $hace_6_meses);
        $query =  $this->db->get('compras');
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
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }    
    
    public function getCompra($id_orden) {
        $this->db->where('id_orden', $id_orden);
        $query =  $this->db->get('compras');
        return $query->row();
    }
    
    public function getReserva($id_reserva) {
        $this->db->where('id_orden', $id_reserva);
        $query =  $this->db->get('reservas');
        return $query->row();
    }
    
    public function anularCompra($id_orden, $data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('compras', $data);
    } 
	
    public function deletePedido($id_orden) {
        $this->db->where('id_orden', $id_orden);
        $this->db->delete('ordenes');
    } 
    
    public function deleteCompra($id_orden) {
        $this->db->where('id_orden', $id_orden);
        $this->db->delete('compras');
    } 
    
    public function deleteDetallesCompra($id_orden) {
        $this->db->where('id_compra', $id_orden);
        $this->db->delete('compras_detalle');
    } 
	
    public function updateEstadoOrden($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('ordenes', $data);
    }
    
    public function updateReserva($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('reservas', $data);
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
    
    public function updatePago($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('compras', $data);
    }
    
    public function getListaDetalles($id_reserva) {
        $this->db->where('id_compra',$id_reserva);            
        $query =  $this->db->get('compras_detalle');
        return $query->result();
    }
    
}
?>
