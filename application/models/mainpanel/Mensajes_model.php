<?php
class Mensajes_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaRecibidos() {
        $this->db->order_by('fecha_ingreso','desc');        
        $query =  $this->db->get('contactenos');
        return $query->result();
    }
    
    public function getListaMostrados() {
        $this->db->order_by('titulo');        
        $query =  $this->db->get('mensajes');
        return $query->result();
    }    
    
    public function getMsgRecibido($id_mensaje) {
        $this->db->where('id', $id_mensaje);
        $query =  $this->db->get('contactenos');
        return $query->row();
    }     
    
    public function getMsgMostrado($id_mensaje) {
        $this->db->where('id_mensaje', $id_mensaje);
        $query =  $this->db->get('mensajes');
        return $query->row();
    }      
    
    public function leidoMensaje($id_mensaje, $data) {
        $this->db->where('id', $id_mensaje);
        $this->db->update('contactenos', $data);
    }   
    
    public function deleteMensaje($id_mensaje) {
        // Eliminamos esta mensajes
        $this->db->where('id', $id_mensaje);
        $this->db->delete('contactenos');
    }   

    public function deleteMensajeMostrado($id_mensaje) {
        // Eliminamos esta mensajes
        $this->db->where('id_mensaje', $id_mensaje);
        $this->db->delete('mensajes');
    }   
    
}
?>
