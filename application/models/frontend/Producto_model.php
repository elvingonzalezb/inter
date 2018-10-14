<?php
class Producto_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
	 */	
    public function getProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }
	
	function getFotos($id_producto) {
		$sql="select * from foto_prod where id_prod='$id_producto'";
		$query = $this->db->query($sql);
		return $query->result();	
	}
	  
	public function getCategorias() {
		$this->db->where('estado','A');
		$this->db->order_by('orden','rand');
		$query =  $this->db->get('categorias');
		return $query->result();
	}
	
	public function listPrecios($id_producto) {
		$this->db->where('id_producto',$id_producto);            
		$query =  $this->db->get('precios');
		return $query->result();
	}
	
	function getUnidad($id_unidad) {
		$sql="select texto from unidades where id='$id_unidad' and estado='A'";
		$query = $this->db->query($sql);
		return $query->row();	
	}        
        
	public function listProd($pagina_actual,$cantidad) {
		$inicio = $cantidad*($pagina_actual - 1);
		//$sql = "select * from productos where id_producto in (select id_producto from stock_color where stock<>0)limit ".$inicio.", ".$cantidad;
		$sql = "select * from productos where id_producto in (select id_producto from stock_color where stock>0) order by id_categoria_padre limit ".$inicio.", ".$cantidad;
		$query = $this->db->query($sql);
		return $query->result();	
	}
	
	public function listFotos($id_producto) {
		$this->db->where('id_prod',$id_producto);
		$this->db->order_by('orden');
		$query =  $this->db->get('foto_prod');
		return $query->result();
	}        
        
	public function getNumPaginas($productos_x_pagina) {
		//$sql="select * from productos where id_producto in (select id_producto from stock_color where stock<>0)";	
		$sql="select * from productos where id_producto in (select id_producto from stock_color where stock>0)";
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
	
	public function listColores($id_producto) {
		//$sql = "select * from stock_color where id_producto='$id_producto' and stock<>0";
		$sql = "select * from stock_color where id_producto='$id_producto' and stock>0";
		$query = $this->db->query($sql);
		return $query->result();            
	}          
	public function getCol($id_color) {
		$this->db->where('id',$id_color);
		$this->db->where('estado','A');
		$query =  $this->db->get('colores');
		return $query->row();
	}         
	public function getCategoria($id) {
		$this->db->where('id_categoria',$id);
		$this->db->where('estado','A');
		$query =  $this->db->get('categorias');
		return $query->row();
	} 


	public function getsubcategoriasids($id_producto) {
		$this->db->select('GROUP_CONCAT(id_subcategoria) as categorias');
		$this->db->where('id_producto',$id_producto);
		$query =  $this->db->get('productos_x_subcategoria');
		return $query->row()->categorias;
	}

	public function getProductosRelacionados($categorias,$id_producto,$id_categoria) {
		$query =  $this->db
				->select('p.id_producto,p.nombre,p.imagen')
				->from('productos_x_subcategoria s')
				->join('productos p', 's.id_producto = p.id_producto','inner')
				->where_in('s.id_subcategoria',$categorias)
				->where('s.id_subcategoria',$id_categoria)
				->where('p.id_producto !=',$id_producto)
				->order_by('RAND()')
				->group_by('p.id_producto')
				->limit(6)
				->get()
				->result_array();
		return $query;
	}      
}
?>