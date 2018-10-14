<?php
class Registrese_model extends CI_Model {
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
                $afectadas = $this->db->affected_rows();
		return $afectadas;
	}
        
        public function getIdCliente($email) {
            $this->db->where('email',$email);
            $query =  $this->db->get('inscritos');
            return $query->row();
        }
        
        public function actualizaCodCliente($id_cliente, $data) {
            $this->db->where('id', $id_cliente);
            $this->db->update('inscritos', $data);
            $afectadas = $this->db->affected_rows();
            return $afectadas;
        }
        
        public function getCategorias() {
            $this->db->where('estado','A');
            $this->db->order_by('orden','rand');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        
        public function ListPaises() {
            $this->db->order_by('nombre');
            $query =  $this->db->get('paises');
            return $query->result();
        } 
        
        public function verfCorreo($email) {
            $this->db->where('email',$email);
            $query =  $this->db->get('inscritos');
            return $query->num_rows();
        }        
        public function verfRuc($ruc) {
            $this->db->where('ruc',$ruc);
            $query =  $this->db->get('inscritos');
            return $query->num_rows();
        }  
        public function verfNombre($nombre) {
            $this->db->where('nombre',$nombre);
            $query =  $this->db->get('inscritos');
            return $query->num_rows();
        } 		
        
}
?>