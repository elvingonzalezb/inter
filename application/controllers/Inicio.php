<?php
class Inicio extends CI_Controller {
	function __construct()
	{
            parent::__construct();
            $this->load->model('frontend/Inicio_model');
            $this->load->model('frontend/Ajax_model','Ajax');
            $this->load->helper('captcha');
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
		$data['seccion'] = 'inicio';
		/*
		$aux_modal = getConfig("modal_inicio");
		if($aux_modal=="Si")
		{
			$data['modalInicio'] = 'cargaModalInicio()';
		}
		else
		{
			$data['modalInicio'] = '';
		}
		*/
		$data['menu'] = $this->load->view('frontend/includes/menu', $data, true);          
		$this->load->view('frontend/includes/header', $data, true);
		$this->load->view('frontend/includes/footer', $data, true);
		
		// INFO DE LA SECCION
                $estaLogueado = $this->session->userdata('logueadocki');                
                if($estaLogueado==true)
                {
                    $veEspeciales = $this->session->userdata('categorias_especiales');
                    if($veEspeciales=="si")
                    {
                        $categorias = $this->Inicio_model->getCategoriasTodas();
                    }
                    else
                    {
                       $categorias = $this->Inicio_model->getCategoriasPublicas(); 
                    }
                }
                else
                {
                   $categorias = $this->Inicio_model->getCategoriasPublicas();
                }
                // ARMAMOS EL LISTADO DE CATEGORIAS Y SUBCATEGORIA
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
                
                if($estaLogueado==true)
                {
                    // BANNERS DE CLIENTES
                    $dato3['banners']= getBannersClientes();
                    $dataPrincipal['banners']= $this->load->view('frontend/includes/banner_clientes', $dato3, true);
                    $dataPrincipal['tipo_banner'] = 'clientes';
                }
                else
                {
                    // BANNERS DE USUARIOS
                    $dato3['banners']= getBannersUsuarios();
                    $dataPrincipal['banners']= $this->load->view('frontend/includes/banner_usuarios', $dato3, true);
                    $dataPrincipal['tipo_banner'] = 'usuarios';
                }		
		$dataPrincipal['cuerpo'] = 'index'; 
		
		$aux= $this->Inicio_model->listProdNovIni();
		$num_reg=count($aux);
		$dataPrincipal['num_reg'] = $num_reg;
		$productos=array();
		foreach ($aux as $value) {
			$aux2=array();
			$colores=array();
			$aux4=$this->Inicio_model->listColores($value->id_producto);
			foreach ($aux4 as $val) {
				$aux6=array();
				$aux6['stock']=$val->stock;
				$aux5=$this->Inicio_model->getCol($val->id_color);
				if(count($aux5)>0){
					$aux6['nombre']=$aux5->nombre;
					$aux6['color']=$aux5->color;
				}else{
					$aux6['nombre']='';
					$aux6['color']='';                        
				}
				$colores[]=$aux6;
			}
			$aux2['colores']=$colores;
			$aux2['nombre']=$value->nombre;
			$aux2['codigo']=$value->codigo;
			$aux2['stock']=$value->stock;
			$aux2['precio']=$value->precio;
			$aux2['imagen']=$value->imagen;
			$aux2['id_producto']=$value->id_producto;
			$productos[]=$aux2;
		}
		$dataPrincipal['productos'] = $productos;
		$novedades_inicio= getConfig('novedades_inicio');          
		$dataPrincipal['novedades_inicio'] = $novedades_inicio;            
		
		$aux= $this->Inicio_model->listProdOferIni();
		$num_reg2=count($aux);
		$dataPrincipal['num_reg2'] = $num_reg2;
		$ofertas=array();
		foreach ($aux as $value) {
			$aux2=array();
			$colores=array();
			$aux4=$this->Inicio_model->listColores($value->id_producto);
			foreach($aux4 as $val) {
				$aux6=array();
				$aux6['stock']=$val->stock;
				$aux5=$this->Inicio_model->getCol($val->id_color);
				if(count($aux5)>0){
					$aux6['nombre']=$aux5->nombre;
					$aux6['color']=$aux5->color;
				}else{
					$aux6['nombre']='';
					$aux6['color']='';                        
				}
				$colores[]=$aux6;
			}
			$aux2['colores']=$colores;            
			$aux2['nombre']=$value->nombre;
			$aux2['codigo']=$value->codigo;
			$aux2['stock']=$value->stock;
			$aux2['precio']=$value->precio;
			$aux2['imagen']=$value->imagen;
			$aux2['id_producto']=$value->id_producto;                
			$ofertas[]=$aux2;
		}            
		$dataPrincipal['ofertas'] = $ofertas;            
		$ofertas_inicio= getConfig('ofertas_inicio');          
		$dataPrincipal['ofertas_inicio'] = $ofertas_inicio; 
                // Texto home
                $dataPrincipal['contenido'] = getInfo("inicio");

        $proxData = $this->Inicio_model->getProximosIngresos();
		$proximos = array();
        $numeroProximos = 0; 
        foreach($proxData as $proximo)
        {
            $aux8 = array();
            $aux8['id_producto'] = $proximo['id_producto'];
            $aux8['fecha_llegada'] = $proximo['fecha_llegada'];
            $aux_producto = $this->Inicio_model->getProducto($proximo['id_producto']);
            $aux8['nombre'] = $aux_producto->nombre;
            $aux8['imagen'] = $aux_producto->imagen;
            $aux8['codigo'] = $aux_producto->codigo;
            $aux8['orden'] = $aux_producto->orden;
            $aux8['tipo'] = $aux_producto->tipo;
            $aux8['actualizacion'] = $aux_producto->actualizacion;
            $aux8['url_nom'] = formateaCadena($aux_producto->nombre);
            //$proximos[] = implode("##", $aux4);
            $proximos[] = $aux8;
            $numeroProximos++;
        }
        $dataPrincipal['numero_proximos'] = $numeroProximos;
        $dataPrincipal['proximos'] = $proximos;
        #captcha
		$dataPrincipal['recaptcha'] = $this->recaptcha->render();

		$this->load->view("frontend/includes/template", $dataPrincipal);
	}

}
?>