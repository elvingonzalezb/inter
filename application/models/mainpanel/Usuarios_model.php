<?php
class Usuarios_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaParametros() {
        $query =  $this->db->get('configuracion');
        return $query->result();
    }
    
    public function updateConfiguracion($id_configuracion, $data) {
        $this->db->where('id', $id_configuracion);
        $this->db->update('configuracion', $data);
    } 
    
    public function getConfiguracion($id_configuracion) {
        $this->db->where('id', $id_configuracion);
        $query =  $this->db->get('configuracion');
        return $query->row();
    }    
    
}
?>