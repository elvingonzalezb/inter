<?php
class Mis_datos_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
              
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	
	public function insertRegistro($datos)
	{
		$resultado = $this->db->insert('inscritos', $datos);
		return $resultado;
	}
        
        public function actualizarRegistro($data,$id) {
            $this->db->where('id',$id);
            $this->db->update('inscritos',$data);
        }   
        public function getCategorias() {
            $this->db->where('estado','A');
            $this->db->order_by('orden','rand');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        public function getCliente($id) {
            $this->db->where('id',$id);
            $query =  $this->db->get('inscritos');
            return $query->row();
        }        
        
        public function ListPaises() {
            $this->db->order_by('nombre');
            $query =  $this->db->get('paises');
            return $query->result();
        }        
}
?>