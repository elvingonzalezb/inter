<?php
class Contactenos_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
              
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	
	public function sendMensaje($datos)
	{
		$resultado = $this->db->insert('contactenos', $datos);
		return $resultado;
	}
        
        public function getCategorias() {
            $this->db->where('estado','A');
            $this->db->order_by('orden','rand');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        
}
?>