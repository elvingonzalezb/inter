<?php
class Unidad_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaUnidades() {
        $query =  $this->db->get('unidades');
        return $query->result();
    }
    
    
    public function getUnidad($id_unidad) {
        $this->db->where('id', $id_unidad);
        $query =  $this->db->get('unidades');
        return $query->row();
    }
    
    public function updateUnidad($id_unidad, $data) {
        $this->db->where('id', $id_unidad);
        $this->db->update('unidades', $data);
    } 
    
    
    public function deleteUnidad($id_unidad) {
        $this->db->where('id', $id_unidad);
        $this->db->delete('unidades');
    } 
    
     public function grabarUnidad($data) {
        $resultado = $this->db->insert('unidades', $data);
        return $resultado;
    } 
    
}
?>
