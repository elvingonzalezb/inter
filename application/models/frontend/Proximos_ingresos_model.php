<?php
class Proximos_ingresos_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    /*
     * @Function que extrae la informacion de los cuadros que se muestran debajo del banner
     */
    public function listaFechasProximamente() {
        $sql = "SELECT DISTINCT fecha_llegada FROM stock_color WHERE stock_proximamente>0 ORDER BY fecha_llegada";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function primeraFechaProximamente() {
        $sql = "SELECT DISTINCT fecha_llegada FROM stock_color WHERE stock_proximamente>0 ORDER BY fecha_llegada LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row();
    }
    
    public function getCategorias() {
        $this->db->where('estado','A');
        $this->db->order_by('orden','rand');
        $query =  $this->db->get('categorias');
        return $query->result();
    }

    public function getCategoria($id) {
            $this->db->where('id_categoria',$id);
            $this->db->where('estado','A');
            $query =  $this->db->get('categorias');
            return $query->row();
    }
        
    public function getSubCategoria($id) {
            $this->db->where('id_subcategoria',$id);
            $query =  $this->db->get('subcategorias');
            return $query->row();
    }

    public function listProd($pagina_actual,$cantidad,$id_categoria) {
        $inicio = $cantidad*($pagina_actual - 1);
        $sub_sql1="select id_producto from productos where id_categoria_padre=$id_categoria";	            
        $sub_sql2="select id_producto from stock_color where stock > 0 and id_producto in ($sub_sql1)";
        $sql="select * from productos where id_producto in ($sub_sql2) order by orden limit ".$inicio.", ".$cantidad;
        $query = $this->db->query($sql);
        return $query->result();	
    } 

    public function listFotos($id_producto) {
        $this->db->where('id_prod',$id_producto);
        $this->db->order_by('orden');
        $query =  $this->db->get('foto_prod');
        return $query->result();
    }      
        
    public function listColores($id_producto) {
        $sql = "select * from stock_color where id_producto='$id_producto' and stock<>0";
        $query = $this->db->query($sql);
        return $query->result();            
    }

    // AGREGADAS 2 DE ABRIL
    public function getListaSubCategorias($id_categoria) {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where('estado', 'A');
        $this->db->select('id_subcategoria, nombre, orden, estado');
        $this->db->order_by('orden');
        $query =  $this->db->get('subcategorias');
        return $query->result();
    }

    public function numeroProductos($id_subcategoria) {
        $this->db->where('id_subcategoria', $id_subcategoria);
        $query =  $this->db->get('productos_x_subcategoria');
        return $query->num_rows();
    }
        
    public function getListaProductos($inicio, $limite) {
        $sql = "SELECT DISTINCT id_producto, fecha_llegada FROM stock_color WHERE stock_proximamente>'0' ORDER BY fecha_llegada, orden_proximamente LIMIT ".$inicio.", ".$limite;
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getListaProductos_x_fecha($inicio, $limite, $fecha) {
        $sql = "SELECT DISTINCT id_producto FROM stock_color WHERE stock_proximamente>'0' AND fecha_llegada='$fecha' LIMIT ".$inicio.", ".$limite;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getNumPaginas($productos_x_pagina) {
        $sql = "SELECT DISTINCT id_producto FROM stock_color WHERE stock_proximamente>'0'";
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
    
    public function getNumPaginas_x_fecha($productos_x_pagina, $fecha) {
        $sql = "SELECT DISTINCT id_producto FROM stock_color WHERE stock_proximamente>'0' AND fecha_llegada='$fecha'";
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
        
    public function getProducto($id_producto) {
        $this->db->where('id_producto', $id_producto);
        $query =  $this->db->get('productos');
        return $query->row();
    }
}
?>
