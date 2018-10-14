<?php
class Ubiquenos_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	public function getUbicaciones() {
		$sql = "select * from sede";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function getContenido($seccion)
	{
		$sql = "select nom_tweb, info_tweb from textos_web where seccion='$seccion'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	public function getCentro() {
		$sql = "select latitud_centro, longitud_centro from sede limit 1";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
}
?>