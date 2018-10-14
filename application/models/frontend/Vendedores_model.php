<?php
class Vendedores_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    
    public function getListaVendedores($id_cliente) {
        $this->db->select('id, nombre, cargo, telefono, email, clave, last_login, estado, ver_precio');
        $this->db->where('id_padre', $id_cliente);
        $this->db->where('nivel', 'vendedor');
        $this->db->where('estado <>', 'Borrado');
        $this->db->where('estado <>', 'Anulado');
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }
    
    public function grabaVendedor($data) {
        $resultado = $this->db->insert('inscritos', $data);
        return $this->db->insert_id();
    }
    
    public function getVendedor($id) {
        $this->db->where('id', $id);
        $query =  $this->db->get('inscritos');
        return $query->row_array();
    }
    
    public function actualizarVendedor($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('inscritos', $data);
    }
    
    public function getOwner($id_vendedor) {
        $this->db->select('id_padre');
        $this->db->where('id', $id_vendedor);
        $query =  $this->db->get('inscritos');
        return $query->row('id_padre');
    }
    
    public function verfCorreo($email) {
        $this->db->where('email',$email);
        $query =  $this->db->get('inscritos');
        return $query->num_rows();
    } 
    
}
?>