<?php
class Ofertas_model extends CI_Model {
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
        
        public function listProdOfer($pagina_actual,$cantidad) {
            $inicio = $cantidad*($pagina_actual - 1);
            $sql = "select * from productos where oferta='1' order by orden_proximamente limit ".$inicio.", ".$cantidad;
            $query = $this->db->query($sql);
            return $query->result();	
        }        

        public function getProducto($id_producto) {
            $this->db->where('id_producto', $id_producto);
            $query =  $this->db->get('productos');
            return $query->row();
        } 
        
	public function getNumPaginas($novedades_x_pagina) {
		$sql="select * from productos where oferta='1'";	
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
        public function listColores($id_producto) {
            $sql = "select * from stock_color where id_producto='$id_producto' and stock<>0";
            $query = $this->db->query($sql);
            return $query->result();            
        }         
}
?>