<?php
class Inicio_model extends CI_Model {
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
        
        public function getCategoriasTodas() {
            $this->db->where('estado','A');
            $this->db->order_by('orden');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        
        public function getCategoriasPublicas() {
            $this->db->where('estado','A');
            $this->db->where('tipo','0');
            $this->db->order_by('orden');
            $query =  $this->db->get('categorias');
            return $query->result();
        }
        
        public function listProdNovIni() {
            $sql = "select * from productos where novedad='1' and id_producto in (select id_producto from stock_color where stock>0) order by orden_novedad";
            $query = $this->db->query($sql);
            return $query->result();              
        }          
        
        public function listProdOferIni() {
            $sql = "select * from productos where oferta='1' and id_producto in (select id_producto from stock_color where stock>0) order by orden_proximamente";
            $query = $this->db->query($sql);
            return $query->result();              
        }         
        
	public function getNumPagNov($novedades_inicio) {
            $this->db->where('novedad', '1');
            $this->db->order_by('orden');            
            $query =  $this->db->get('productos');
            $num_reg = $query->num_rows();

	} 
        public function getCol($id_color) {
            $this->db->where('id',$id_color);
            $this->db->where('estado','A');
            $query =  $this->db->get('colores');
            return $query->row();
        }        
        
        public function listColores($id_producto) {
            $sql = "select * from stock_color where id_producto='$id_producto' and stock>0";
            $query = $this->db->query($sql);
            return $query->result();            
        }
        
        public function listColoresProximamente($id_producto) {
            $sql = "select * from stock_color where id_producto='$id_producto' and stock_proximamente>'0'";
            $query = $this->db->query($sql);
            return $query->result();            
        }
        
        // AGREGADAS 9 DE ABRIL
        public function getListaSubCategorias($id_categoria) {
            $this->db->where('id_categoria', $id_categoria);
            $this->db->where('estado', 'A');
            $this->db->select('id_subcategoria, nombre, orden, estado');
            $this->db->order_by('orden');
            $query =  $this->db->get('subcategorias');
            return $query->result();
        }

        //proximos ingresos
        public function getProximosIngresos() {
            $sql = "SELECT DISTINCT id_producto, fecha_llegada FROM stock_color WHERE stock_proximamente>'0' ORDER BY RAND() LIMIT 4";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        public function getProducto($id_producto) {
            $this->db->where('id_producto', $id_producto);
            $query =  $this->db->get('productos');
            return $query->row();
        }
}
?>