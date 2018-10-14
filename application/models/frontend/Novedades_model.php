<?php
class Novedades_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	public function getNumPaginas($novedades_x_pagina) {
		$sql="select * from novedades where estado='A'";	
		$query = $this->db->query($sql);
		$num_reg = $query->num_rows();
		if ( $num_reg % $novedades_x_pagina==0 )
		{
			$numero_paginas = $num_reg/$novedades_x_pagina;
		}
		else
		{
			$numero_paginas = (int) ( $num_reg/$novedades_x_pagina) + 1;
		}
		return $numero_paginas;
	}
	
	function getNovedades($pagina_actual, $novedades_x_pagina) {
		$indice_inicial = $novedades_x_pagina*($pagina_actual - 1);
		$sql = "select * from novedades where estado='A' ";
		$sql.= "order by fecha desc limit ".$indice_inicial.", ".$novedades_x_pagina;
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getNovedad($id_novedad) {
		$sql="select * from novedades where estado='A' and id_novedad='$id_novedad'";	
		$query = $this->db->query($sql);
		return $query->row();
	}
	
}
?>