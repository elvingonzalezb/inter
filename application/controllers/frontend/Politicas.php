<?php
class Politicas extends CI_Controller {
	function __construct()
	{
		parent::__construct();
                $this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Politicas_model');
	}
	function index()
	{
            // GENERAL
            $data2=array();
            $dato3=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = 'acerca-nosotros';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // INFO DE LA SECCION
            //$dato3['banners']= getBanners();
            //$dataPrincipal['banners']= $this->load->view('frontend/includes/banner', $dato3, true);            
            $data2['categorias'] = $this->Politicas_model->getCategorias();
            
            // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
            $categorias = $this->Inicio_model->getCategorias();
            $listaCategorias = array();
            foreach($categorias as $auxCategoria)
            {
                $auxCats = array();
                $auxCats['id_categoria'] = $auxCategoria->id_categoria;
                $auxCats['nombre_categoria'] = $auxCategoria->nombre_categoria;
                $listaSubcategorias = $this->Inicio_model->getListaSubCategorias($auxCategoria->id_categoria);
                $subcategoriasItem = array();
                foreach($listaSubcategorias as $subcategoria)
                {
                    $auxSubCats = array();
                    $auxSubCats['id_subcategoria'] = $subcategoria->id_subcategoria;
                    $auxSubCats['nombre'] = $subcategoria->nombre;
                    $subcategoriasItem[] = $auxSubCats;
                }
                $auxCats['subcategorias'] = $subcategoriasItem;
                $listaCategorias[] = $auxCats;
            }
            $data2['id_cat_current'] = 0;
            $data2['id_subcat_current'] = 0;
            $data2['categorias'] = $listaCategorias;
            $data2['newsletter'] = getInfo("newsletter");
            $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true);  
            
            $dataPrincipal['acerca_nosotros'] = getInfo("politicas_privacidad");            
            $dataPrincipal['cuerpo'] = 'acerca';
            
            $this->load->view("frontend/includes/template", $dataPrincipal);
	}
}
?>