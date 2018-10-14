<?php
class Colores_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaCategorias() {
        $this->db->order_by('orden');
        $query =  $this->db->get('cat_colores');
        return $query->result();
    }
    
    public function numeroColores($id) {
        $this->db->where('id_categoria', $id);
        $query =  $this->db->get('colores');
        return $query->num_rows();
    }
    
    public function getCategoria($id_registro) {
        $this->db->where('id', $id_registro);
        $query =  $this->db->get('cat_colores');
        return $query->row();
    }
	
    public function deleteCategoria($id) {
        $this->db->where('id', $id);
        $this->db->delete('cat_colores');
    }
	
    public function deleteColores($id) {
        $this->db->where('id_categoria', $id);
        $this->db->delete('colores');
    }	
    

    public function updateCategoria($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('cat_colores', $data);
    }
	
    public function grabarCategoria($data) {
        $resultado = $this->db->insert('cat_colores', $data);
        return $resultado;
    }	
	
    public function getListaColores($id) {
        $this->db->select('id, color, estado,orden,nombre');
	$this->db->where('id_categoria',$id);
        $this->db->order_by('orden');
        $query =  $this->db->get('colores');
        return $query->result();
    }	
	
    public function getColor($id) {
        $this->db->where('id', $id);
        $query =  $this->db->get('colores');
        return $query->row();
    }	
    
    public function updateColor($id_color, $data) {
        $this->db->where('id', $id_color);
        $this->db->update('colores', $data);
    }    
    
    public function grabarColor($data) {
        $resultado = $this->db->insert('colores', $data);
        return $resultado;
    }	    
    
    public function deleteColor($id) {
        $this->db->where('id', $id);
        $this->db->delete('colores');
    }    
    

}
?>
