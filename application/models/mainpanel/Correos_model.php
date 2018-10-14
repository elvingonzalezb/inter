<?php
class Correos_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaCorreos() {
        $this->db->select('id, titulo, fecha_registro, estado, fecha_envio');
        $this->db->order_by('fecha_registro','desc');
        $query =  $this->db->get('correos_clientes');
        return $query->result();
    }
    
    public function getListaClientes() {
        $this->db->order_by('razon_social');		
        $this->db->where('estado', 'Activo');        
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
    
    public function getNumVisitas($email) {
        $this->db->where('email', $email);
        $query =  $this->db->get('ingresos');
        return $query->num_rows();
    }
    
    public function ultimoIngreso($email) {
        $this->db->where('email', $email);
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit('1');        
        $query =  $this->db->get('ingresos');
        return $query->row();
    }
    
    public function grabarCorreo($data) {
        $this->db->insert('correos_clientes', $data);
        $resultado=$this->db->insert_id();
        return $resultado;
    }
    
    public function getCorreo($id_boletin) {
        $this->db->where('id', $id_boletin);
        $query =  $this->db->get('correos_clientes');
        return $query->row();
    }
    
    public function actualizarCorreo($id_boletin, $data) {
        $this->db->where('id', $id_boletin);
        $this->db->update('correos_clientes', $data);
    }
    
    public function deleteCorreo($id_boletin) {
        $this->db->where('id', $id_boletin);
        $this->db->delete('correos_clientes');
    } 
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }
    
    public function updateEstadoCorreo($id_boletin,$data) {
        $this->db->where('id', $id_boletin);
        $this->db->update('correos_clientes', $data);
    }
    
    
}
?>