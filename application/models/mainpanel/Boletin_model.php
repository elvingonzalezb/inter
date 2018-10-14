<?php
class Boletin_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaBoletines() {
        $this->db->select('id, titulo, fecha_registro, estado, fecha_envio');
        $this->db->order_by('fecha_registro','desc');
        $query =  $this->db->get('boletines');
        return $query->result();
    }
    
    public function getBoletin($id_boletin) {
        $this->db->where('id', $id_boletin);
        $query =  $this->db->get('boletines');
        return $query->row();
    }
    
    public function getProducto($id_producto) {
        $this->db->select('id_producto, nombre, imagen, codigo');
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }
    
    public function getListaClientesActivos() {
        $this->db->order_by('razon_social, email');		
        $this->db->where('estado', 'Activo');        
        $query =  $this->db->get('inscritos');
        //$query =  $this->db->get('clientes_prueba');
        return $query->result();
    }

    public function getListaClientesActivos_prueba() {
        $this->db->order_by('razon_social, email');     
        $this->db->where('estado', 'Activo');        
        $query =  $this->db->get('inscritos_lalo');
        //$query =  $this->db->get('clientes_prueba');
        return $query->result();
    }
	
    public function updateEstadoBoletin($id_boletin,$data) {
        $this->db->where('id', $id_boletin);
        $this->db->update('boletines', $data);
    }
    
    public function grabarBoletin($data) {
        $this->db->insert('boletines', $data);
        $resultado=$this->db->insert_id();
        return $resultado;
    }
    
    public function actualizarBoletin($id_boletin, $data) {
        $this->db->where('id', $id_boletin);
        $this->db->update('boletines', $data);
    }
    
    public function deleteBoletin($id_boletin) {
        $this->db->where('id', $id_boletin);
        $this->db->delete('boletines');
    } 
}
?>
