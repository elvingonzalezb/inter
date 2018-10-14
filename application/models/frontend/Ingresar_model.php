<?php
class Ingresar_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
              
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	
	public function grabaIngreso($dato)
	{
		$resultado = $this->db->insert('ingresos', $dato);
		return $resultado;
	}
        
        public function usu_y_pass($usuario,$password) {
            $this->db->where('email',$usuario);
            $this->db->where('clave',$password);            
            $query =  $this->db->get('inscritos');
            return $query->row();
        }  
        public function pass($password) {
            $this->db->where('clave',$password);            
            $query =  $this->db->get('inscritos');
            return $query->row();
        }         
        public function consultLogueo($usuario,$password) {
            $this->db->where('email',$usuario);
            $this->db->where('clave',$password);            
            $this->db->where('estado','Activo');
            $query =  $this->db->get('inscritos');
            return $query->row();
        }   
        
        public function getCategorias() {
            $this->db->where('estado','A');
            $this->db->order_by('orden','rand');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        
}
?>