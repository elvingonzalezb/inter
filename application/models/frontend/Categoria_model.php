<?php
class Categoria_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */
	public function getNombreCategoria($id_categoria)
	{
		$sql = "select nombre from categorias where id_categoria='$id_categoria'";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->nombre;
	}
	
	public function getNumPaginas($id_categoria, $productos_x_pagina) {
		$sql="select * from productos where estado='A' and cat_padre='$id_categoria' and nivel=0";	
		$query = $this->db->query($sql);
		$num_reg = $query->num_rows();
		if ( $num_reg % $productos_x_pagina==0 )
		{
			$numero_paginas = $num_reg/$productos_x_pagina;
		}
		else
		{
			$numero_paginas = (int) ( $num_reg/$productos_x_pagina) + 1;
		}
		return $numero_paginas;
	}
	
	function getProductos($id_categoria, $pagina_actual, $productos_x_pagina) {
		$indice_inicial = $productos_x_pagina*($pagina_actual - 1);
		$sql = "select * from productos where estado='A' and cat_padre='$id_categoria' and nivel=0 ";
		$sql.= "order by orden limit ".$indice_inicial.", ".$productos_x_pagina;
		$query = $this->db->query($sql);
		return $query->result();
	}
	
}
?>