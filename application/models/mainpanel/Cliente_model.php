<?php
class Cliente_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    
    public function getListaClientesTotal() {
        $this->db->order_by('razon_social');
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
    
    public function getListaClientes() {
        $this->db->order_by('razon_social');		
        $this->db->where('estado', 'Activo');        
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
    public function getListaVisitas($email) {
        $this->db->where('email', $email);        
        $this->db->order_by('fecha_ingreso','desc');        
        $query =  $this->db->get('ingresos');
        return $query->result();
    } 
    public function getListaVisitas2($email,$fecha_inicio,$fecha_fin) {
        $sql = "select * from ingresos where id>0 ";        
        if($email<>''){
            $sql.=" and email = '".$email."'";
        }
        if($fecha_inicio<>''){
            $sql.=" and fecha_ingreso >= '".$fecha_inicio."'";
        }
        if($fecha_fin<>''){
            $sql.=" and fecha_ingreso <= '".$fecha_fin."'";
        }
		
        $sql.=" order by fecha_ingreso desc";
        $query = $this->db->query($sql);
        return $query->result();
    }      
    
    public function getListaClientesBusqueda($email,$razon_social,$telefono,$ruc,$nombre) {
        if($email<>""){
            $this->db->like('email',$email);
        }
        if($razon_social<>""){
            $this->db->like('razon_social',$razon_social);
        }
        if($ruc<>""){
            $this->db->like('ruc',$ruc);
        }
        if($telefono<>""){
            $this->db->like('telefono',$telefono);
        }  
        if($nombre<>""){
            $this->db->like('nombre',$nombre);
        }  		
        $this->db->order_by('razon_social');		
        $query =  $this->db->get('inscritos');
        return $query->result();
    }    
    
    public function getListaClientesAnulados() {
        $this->db->order_by('razon_social');		
        $this->db->where('estado', 'Anulado');
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
	
	public function getFechaAnulacion($id_cliente) {
		$this->db->select('fecha');        
        $this->db->where('id_cliente',$id_cliente);        
        $this->db->order_by('fecha','desc');
        $this->db->limit('1');
        $query = $this->db->get('anulaciones_clientes');
        return $query->row();        
	}
	
	public function getListaClientesBorrados() {
        $this->db->order_by('razon_social');		
        $this->db->where('estado', 'Borrado');
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
	
	public function getFechaBorrado($id_cliente) {
		$this->db->order_by('fecha','desc');
		$this->db->limit('1');
		$this->db->where('id_cliente', $id_cliente);
        $query =  $this->db->get('borrado_clientes');
        return $query->row();
	}
    
    public function getListaClientesInactivo() {
        $this->db->order_by('razon_social');		
        $this->db->where('estado', 'Inactivo');
        $query =  $this->db->get('inscritos');
        return $query->result();
    }
	
    public function getFechaDesactivacion($id_cliente) {
		$this->db->order_by('fecha','desc');
		$this->db->limit('1');
		$this->db->where('id_cliente', $id_cliente);
        $query =  $this->db->get('desactivaciones_clientes');
        return $query->row();
	}
    
    public function getNumVisitas($email) {
        $this->db->where('email', $email);
        $query =  $this->db->get('ingresos');
        return $query->num_rows();
    }
    
    public function ultimoIngreso($email) {
        $this->db->where('email', $email);
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit('1');        
        $query =  $this->db->get('ingresos');
        return $query->row();
    }
    
    public function ultimaVisita($email) {
        $this->db->where('email', $email);
        $this->db->order_by('fecha_ingreso','desc');
        $this->db->limit('1');        
        $query =  $this->db->get('ingresos');
        return $query->row('fecha_ingreso');
    }
    
    public function getCliente($id_cliente) {
        $this->db->where('id', $id_cliente);
        $query =  $this->db->get('inscritos');
        return $query->row();
    }
    
    public function updateCliente($id_cliente, $data) {
        $this->db->where('id', $id_cliente);
        $this->db->update('inscritos', $data);
    } 
    
    public function anularCliente($id_cliente, $data) {
        $this->db->where('id', $id_cliente);
        $this->db->update('inscritos', $data);
    } 
    
    public function deleteCliente($id_cliente) {
        // Eliminamos esta productos
        $this->db->where('id', $id_cliente);
        $this->db->delete('inscritos');
    } 
	
	public function borrarCliente($id_cliente, $data) {
        $this->db->where('id', $id_cliente);
        $this->db->update('inscritos', $data);
    }
    
    public function reactivarCliente($id_cliente, $data) {
        $this->db->where('id', $id_cliente);
        $this->db->update('inscritos', $data);
    }
	
    public function recuperarCliente($id_cliente, $data) {
        $this->db->where('id', $id_cliente);
        $this->db->update('inscritos', $data);
    }
	
    public function registrarBorradoCliente($data) {
        $resultado = $this->db->insert('borrado_clientes', $data);
        return $resultado;	
    }
    
    public function numVendedores($id_cliente) {
        $this->db->where('id_padre', $id_cliente);
        $query =  $this->db->get('inscritos');
        $num_vendedores = $query->num_rows();
        return $num_vendedores;
    }
    
}
?>
