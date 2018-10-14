<?php
class Informativa_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getContenido($seccion) {
        $this->db->select('titulo, texto');
        $this->db->where('seccion', $seccion);
        $query =  $this->db->get('textos_web');
        return $query->row();
    }
    
    public function updateSeccion($seccion, $data) {
        $this->db->where('seccion', $seccion);
        $this->db->update('textos_web', $data);
    }
}
?>
