<?php
class Reservas_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    
    public function getNumReservas($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('estado', 'Activa');
        $query =  $this->db->get('reservas');
        $num_pedidos = $query->num_rows();
        return $num_pedidos;
    }
    
    public function getListaReservasPagina($num_regs, $inicial, $id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('estado', 'Activa');
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit($num_regs, $inicial);
        $query =  $this->db->get('reservas');
        return $query->result();
    }
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }
    
    public function getReserva($id_reserva) {
        $this->db->where('id_orden', $id_reserva);
        $query =  $this->db->get('reservas');
        return $query->row();
    }
    
    public function guardarCompra($data) {
        $resultado = $this->db->insert('compras', $data);
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
    
    public function updateEstadoOrden($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('reservas', $data);
    }
    
    public function updateEstadoReserva($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('reservas', $data);
    }
    
    public function stockProducto($id_producto, $id_color) {
        $this->db->select('stock, id, stock_proximamente');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_color', $id_color);
        $query =  $this->db->get('stock_color');
        return $query->row();
    }
    
    public function stockXId($id) {
        $this->db->select('stock');
        $this->db->where('id', $id);
        $query =  $this->db->get('stock_color');
        return $query->row('stock');
    }
    
    public function stockXId_prox($id) {
        $this->db->select('stock_proximamente');
        $this->db->where('id', $id);
        $query =  $this->db->get('stock_color');
        return $query->row('stock_proximamente');
    }
    
    public function actualizaStock($id_producto, $id_color, $data) {
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_color', $id_color);
        $this->db->update('stock_color', $data);
    }
    
    public function guardarAnulacion($data) {
        $resultado = $this->db->insert('anulaciones_reservas', $data);
        return $resultado;
    }
    
    public function getListaCargos($id_reserva) {
        $this->db->where('id_reserva',$id_reserva);            
        $query =  $this->db->get('cargos_adicionales');
        return $query->result();
    }
    
    public function getListaDetalles($id_reserva) {
        $this->db->where('id_reserva',$id_reserva);            
        $query =  $this->db->get('reservas_detalle');
        return $query->result();
    }
    
    public function actualizarReserva($id_reserva, $data) {
        $this->db->where('id_orden', $id_reserva);
        $this->db->update('reservas', $data);
    }
    
    public function borrarDatosReservas($id_reserva) {
        $this->db->where('id_orden', $id_orden);
        $this->db->delete('reservas', $data);        
        $this->db->empty_table('mytable'); 
    }
    
    public function getEmailGerente($id) {
        $this->db->select('email');
        $this->db->where('id', $id);
        $query =  $this->db->get('inscritos');
        return $query->row('email');	
    }
    
    public function updateDetalleReserva($id_detalle, $datos) {
        $this->db->where('id', $id_detalle);
        $this->db->update('reservas_detalle',$datos);
    }
    
    public function eliminaDetalleReserva($id_detalle) {
        $this->db->where('id', $id_detalle);
        $this->db->delete('reservas_detalle');  
    }
    
    public function grabaDetalleCompra($data) {
        $resultado = $this->db->insert('compras_detalle', $data);
        return $resultado;
    }
    
    public function limpiaTablas() {      
        $this->db->empty_table('reservas'); 
        $this->db->empty_table('reservas_detalle'); 
        $this->db->empty_table('compras'); 
        $this->db->empty_table('compras_detalle'); 
    }
    
    public function getFechaLlegada($id_producto, $id_color) {
        $this->db->select('fecha_llegada');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_color', $id_color);
        $query =  $this->db->get('stock_color');
        return $query->row('fecha_llegada');
    }
    
}
?>
