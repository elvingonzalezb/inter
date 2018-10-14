<?php
class Inicio extends CI_Controller {
	function __construct() {
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
                /*if($estaLogueado==true) {
                    $veEspeciales = $this->session->userdata('categorias_especiales');
                    if($veEspeciales=="si") {
                        $categorias = $this->Inicio_model->getCategoriasTodas();
                    } else {
                       $categorias = $this->Inicio_model->getCategoriasPublicas(); 
                    }
                } else {
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
                $dataPrincipal['izquierda'] = $this->load->view('frontend/includes/izquierda', $data2, true); */

                if($estaLogueado==true) {
                    // BANNERS DE CLIENTES
                    $dato3['banners']= getBannersClientes();
                    $dataPrincipal['banners']= $this->load->view('frontend/includes/banner_clientes', $dato3, true);
                    $dataPrincipal['tipo_banner'] = 'clientes';
                } else {
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

		$dataPrincipal['proximos'] = $this->Inicio_model->getProximosIngresos();
        // Texto home
        $dataPrincipal['contenido'] = getInfo("inicio");
        #captcha
		$data['recaptcha'] = $this->recaptcha->render();

		$this->load->view("frontend/includes/template", $dataPrincipal);
	}

	public function ajax_categorias()
	{
		$estaLogueado = $this->session->userdata('logueadocki');
		$veEspeciales = $this->session->userdata('categorias_especiales');              
		if($estaLogueado==true) {
			$num_total_registros =  ($veEspeciales=="si")? $this->Ajax->numCategorias() : $this->Ajax->numCategoriasPublicas(); 
		} else {
			$num_total_registros = $this->Ajax->numCategoriasPublicas();
		}

		$json = array();
		$html = '';
		if ($num_total_registros > 0) {
			$rowsPerPage = 8;

			$pageNum = 1;
			if(isset($_GET['page'])) {
				sleep(1);
				$pageNum = $_GET['page'];
			}

			$offset = ($pageNum - 1) * $rowsPerPage;
			$total_paginas = ceil($num_total_registros / $rowsPerPage);

			if($estaLogueado==true) {
				$categorias =  ($veEspeciales=="si")? $this->Ajax->getCategorias($rowsPerPage, $offset) : $this->Ajax->getCategoriasPublicas($rowsPerPage, $offset); 
			} else {
				$categorias = $this->Ajax->getCategoriasPublicas($rowsPerPage, $offset);
			}
			$html .= '<div class="row isotope-grid">';
			foreach ($categorias as $key => $value) {
				$url = 'categoria/'.$value->id_categoria.'/'.formateaCadena($value->nombre_categoria).'/1';
				$html .= '<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">';
				$html .= '	<div class="block2">';
				$html .= '		<div class="block2-pic hov-img0"><a class="" href="'.$url.'"><img src="files/categorias/'.$value->imagen.'" alt="'.$value->nombre_categoria.'"></a></div>';
				$html .= '		<div class="block2-txt flex-w flex-t p-t-14"><a href="'.$url.'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">'.$value->nombre_categoria.'</a></div>';
				$html .= '	</div>';
				$html .= '</div>';
			}
			$html .= '</div>';

			if ($total_paginas > 1) {
				$html .= '<nav aria-label="pagination example" class="paginationCat" style="float:right;">';
				$html .= '<ul class="pagination pg-blue">';
				//if ($pageNum != 1){
					$html .= '<li class="page-item disabled"><a href="javascript:void();" class="paginateCat page-link" data="'.($pageNum-1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
					for ($i=1;$i<=$total_paginas;$i++) {
						if ($pageNum == $i){
							$html .= '<li class="active page-item"><a class="page-link">'.$i.'<span class="sr-only">(current)</span></a></li>';
						}else{
							$html .= '<li class="page-item"><a class="paginateCat page-link" data="'.$i.'" href="javascript:void();">'.$i.'</a></li>';
						}
					}
					if ($pageNum != $total_paginas){
						$html .= '<li class="page-item"><a class="paginateCat page-link" href="javascript:void();" data="'.($pageNum+1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
					}
				//}
				$html .= '</ul>';
				$html .= '</nav>';
			}
			$json['html'] = $html;
		}
		if (isset($_GET['page'])) {
			echo $json['html'];
		} else {
			echo (isset($json['html']))? $json['html']: '';
		}
	}


}
?>