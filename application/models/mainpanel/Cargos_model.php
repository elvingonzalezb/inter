<?php
class Cargos_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaCargos() {
        $query =  $this->db->get('cargos_adicionales');
        return $query->result();
    }
    
    
    public function getCargo($id) {
        $this->db->where('id', $id);
        $query =  $this->db->get('cargos_adicionales');
        return $query->row();
    }
    
    public function updateCargo($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('cargos_adicionales', $data);
    } 
    
    
    public function deleteCargo($id) {
        $this->db->where('id', $id);
        $this->db->delete('cargos_adicionales');
    } 
    
     public function grabarCargo($data) {
        $resultado = $this->db->insert('cargos_adicionales', $data);
        return $resultado;
    } 
    
}
?>
