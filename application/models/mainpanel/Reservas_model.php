<?php
class Reservas_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaReservasPagina($num_regs, $inicial, $estado) {
        //$this->db->select('id_orden,id_cliente,total,estado, fecha_ingreso, pedidos, caducidad, lleva_cargos, tiene_cargos');
        $this->db->where('estado', $estado);
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit($num_regs, $inicial);
        $query =  $this->db->get('reservas');
        return $query->result();
    }    
    
    public function listaProductosReserva($id_reserva) {
        $this->db->where('id_reserva', $id_reserva);
        $query =  $this->db->get('reservas_detalle');
        return $query->result();
    }
    
    public function getNumReservas($estado) {
        $query =  $this->db->get('reservas');
        $this->db->where('estado', $estado);
        $num_pedidos = $query->num_rows();
        return $num_pedidos;
    }
    
    public function getCargos($id_orden) {
        $this->db->select('id, concepto, monto');
        $this->db->where('id_reserva', $id_orden);
        $query =  $this->db->get('cargos_adicionales');
        return $query->result();
    }
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }  
    
    public function fechaAnulacion($id_orden) {
        $this->db->select('fecha_anulacion');
        $this->db->where('id_reserva', $id_orden);
        $query =  $this->db->get('anulaciones_reservas');
        return $query->row();
    }
    
    public function getDatosAnulacion($id_orden) {
        $this->db->where('id_reserva', $id_orden);
        $query =  $this->db->get('anulaciones_reservas');
        return $query->row();
    }
    
    public function getOrden($id_orden) {
        $this->db->where('id_orden', $id_orden);
        $query =  $this->db->get('reservas');
        return $query->row();
    }
	
    public function deletePedido($id_orden, $data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('reservas', $data);
    } 
	
    public function updateEstadoOrden($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('reservas', $data);
    }
    
    public function updateReserva($id_orden,$data) {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('reservas', $data);
    }
    
    public function guardarExtension($data) {
        $resultado = $this->db->insert('extensiones_reservas', $data);
        return $resultado;
    }
    
    public function guardarCargoAdicional($data) {
        $resultado = $this->db->insert('cargos_adicionales', $data);
        return $resultado;
    }
    
    public function updateCargoAdicional($id_cargo,$data) {
        $this->db->where('id', $id_cargo);
        $this->db->update('cargos_adicionales', $data);
    }
    
    public function deleteCargoAdicional($id_cargo) {
        $this->db->where('id', $id_cargo);
        $this->db->delete('cargos_adicionales');
    } 
    
    public function guardarAnulacion($data) {
        $resultado = $this->db->insert('anulaciones_reservas', $data);
        return $resultado;
    }
    
    public function guardarBorrado($data) {
        $resultado = $this->db->insert('borrado_reservas', $data);
        return $resultado;
    }
    
    public function guardarReactivacion($data) {
        $resultado = $this->db->insert('reactivaciones_reservas', $data);
        return $resultado;
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
    
    public function updatePreciosReserva($id_registro,$data) {
        $this->db->where('id', $id_registro);
        $this->db->update('reservas_detalle', $data);
    }
    
}
?>
