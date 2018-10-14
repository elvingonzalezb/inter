<?php
class Busqueda_model extends CI_Model {
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
        
        public function listProd($nombre,$codigo,$categoria,$pagina_actual,$cantidad) {
            $inicio = $cantidad*($pagina_actual - 1);
            $sql = "select * from productos where id_producto in ";
			$sql.= "(select id_producto from stock_color where stock<>0) ";
					 
			if($categoria!=0){
				$sql.= " and id_categoria_padre='$categoria'";
			}
			if($codigo!=""){
				$sql.= " and codigo like '%$codigo%'";
			}
			if($nombre!=""){
				$sql.= " and nombre like '%$nombre%'";
			}
			
			$sql.= " limit ".$inicio.", ".$cantidad;
            $query = $this->db->query($sql);
            return $query->result();	
        } 
        public function listFotos($id_producto) {
            $this->db->where('id_prod',$id_producto);
            $this->db->order_by('orden');
            $query =  $this->db->get('foto_prod');
            return $query->result();
        }         
        
	public function getNumPaginas($nombre,$codigo,$categoria,$productos_x_pagina) {
		$sql = "select * from productos where id_producto in ";
		$sql.= "(select id_producto from stock_color where stock<>0) ";
				 
		if($categoria!=0){
			$sql.= " and id_categoria_padre='$categoria'";
		}
		if($codigo!=""){
			$sql.= " and codigo like '%$codigo%'";
		}
		if($nombre!=""){
			$sql.= " and nombre like '%$nombre%'";
		}
		
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
            $sql = "select * from stock_color where id_producto='$id_producto' and stock<>0";
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
}
?>