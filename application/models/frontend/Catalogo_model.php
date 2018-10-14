<?php
class Catalogo_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	public function getListaCategorias()
	{
		$sql = "select * from categorias where estado='A' order by orden";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
?>