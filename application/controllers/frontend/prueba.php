<?php
class Prueba extends CI_Controller {
	function __construct()
	{
            parent::__construct();
            $this->load->model('frontend/Reservas_model');
	}
	function index()
	{
            $id = $this->uri->segment(2);
            /*
            $aux_stock_actual = $this->Reservas_model->stockXId($id_current);
            $stock_actual = $aux_stock_actual->stock;
            echo $stock_actual;
            */
            
	}
}
?>
