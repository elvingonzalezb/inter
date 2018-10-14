<?php
class Informativa_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	public function getContenido($seccion)
	{
		$sql = "select nom_tweb, info_tweb from textos_web where seccion='$seccion'";
		$query = $this->db->query($sql);
		return $query->row();
	}
}
?>