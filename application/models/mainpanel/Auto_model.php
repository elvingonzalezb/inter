<?php
class Auto_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function lista_clientes_dias($fecha) {
        $sql = "select email from ingresos where fecha_ingreso <'$fecha'";
        $query = $this->db->query($sql);
        return $query->result();        
    }
    
    public function updateCli30Dias($email,$data) {
        $this->db->where('email', $email);
        $this->db->update('inscritos', $data);
    }
}
?>
