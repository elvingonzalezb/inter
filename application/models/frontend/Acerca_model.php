<?php
class Acerca_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
        public function getCategorias() {
            $this->db->where('estado','A');
            $this->db->order_by('orden','rand');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        
        public function listProdNovIni() {
            $this->db->where('novedad','1');            
            $this->db->order_by('orden');
            $query =  $this->db->get('productos');
            return $query->result();
        } 
        
        public function listProdOferIni() {
            $this->db->where('oferta','1');            
            $this->db->order_by('orden');
            $query =  $this->db->get('productos');
            return $query->result();
        }         
        
	public function getNumPagNov($novedades_inicio) {
            $this->db->where('novedad', '1');
            $this->db->order_by('orden');            
            $query =  $this->db->get('productos');
            $num_reg = $query->num_rows();

	}      
}
?>