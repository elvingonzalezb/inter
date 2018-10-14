<?php
class Pedido extends CI_Controller {
	function __construct()
	{
		parent::__construct();
                $this->load->model('frontend/Inicio_model');
		$this->load->model('frontend/Pedido_model');
                $this->load->library('Validacion');
                $this->load->library('session');
	}
	function index()
	{
            // RECIBE DATOS
            $this->validacion->validacion_login_frontend();
            // GENERAL
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
            
            $data2=array();
            $data['twitter'] = getConfig('enlace_twitter');
            $data['facebook'] = getConfig('enlace_facebook');
            $data['telefono'] = getConfig("telefono");
            $data['horario'] = getConfig("horario");
            $data['direccion'] = getConfig("direccion");            
            $data['seccion'] = '';            
            $data['menu'] = $this->load->view('frontend/includes/menu', $data, true);            
            $this->load->view('frontend/includes/header', $data, true);
            $this->load->view('frontend/includes/footer', $data, true);
            
            // INFO DE LA SECCION
            $resultado = $this->uri->segment(2);
            //echo $resultado; die();
            $dataPrincipal["resultado"] = $resultado; 
            $resultado2 = $this->uri->segment(3);
            $dataPrincipal["resultado2"] = $resultado2; 
            // CARGOS ADICIONALES
            $id_cliente = $this->session->userdata('id_cliente_logueado');
            $cliente = $this->Pedido_model->getCliente($id_cliente); 
            $tiene_cargos = $cliente->tiene_cargos;
            
            $dataPrincipal['cuerpo']='carrito';
            $dataPrincipal['tiene_cargos'] = $tiene_cargos;
            $this->load->view("frontend/includes/template", $dataPrincipal);
	} 
        
    function prueba() {
        $dataPrincipal['resultado'] = 'hola mundo';
        $this->load->view("frontend/vista_prueba", $dataPrincipal);
    }
    
    function agregar() {
        $id_producto = $this->input->post('id_producto');
        $id_categoria = $this->input->post('id_categoria');
        $nombre_producto = $this->input->post('nombre');
        if( $this->session->userdata('tipoReserva') )
        {
            $tipoReserva = $this->session->userdata('tipoReserva');
            if($tipoReserva=="proximamente")
            {
                if( ($id_categoria=="") || ($id_categoria==0) )
                {
                   redirect('detalle-producto/'.$id_producto.'/'.$nombre_producto.'/errorTipo'); 
                }
                else
                {
                    redirect('detalle-producto/'.$id_producto.'/'.$id_categoria.'/'.$nombre_producto.'/errorTipo'); 
                }                    
            }
        }
        else
        {
            $tipoReserva = 'stock';
            $this->session->set_userdata('tipoReserva', $tipoReserva);
        } // else
        
        $aux_ids = $this->input->post('lista_ids');
        $lista_ids = explode("#", $aux_ids);
        $limite_items_carrito = getConfig("limite_items_carrito");

        for($j=0; $j<count($lista_ids); $j++)
        {
            $current_id = $lista_ids[$j];
            $color = $this->input->post('color_'.$current_id);
            
            $aux_unidad = $this->input->post('uni_'.$current_id);
            $unid = explode("()", $aux_unidad);
            $unidad = $unid[0];    
            $id_unidad = $unid[1];
            $precio_soles = $unid[2];
            
            $codigo = $this->input->post('codigo');
            $nombre = $this->input->post('nombre');
            $id_producto = $this->input->post('id_producto');
            $dscto = $this->input->post('dscto');
            $idColor = $this->input->post('idColor_'.$current_id); 
            $aux_cant = $this->input->post('cant_'.$current_id);
            $cant = (int)($aux_cant);
            $stock = $this->input->post('stock_'.$current_id);
            if($cant>0)
            {
                if($this->session->userdata('carrito'))
                {
                    // El carro ya existe
                    $carrito = $this->session->userdata('carrito');
                    $numItem = count($carrito);                    
                    if(isset($carrito[$current_id]))
                    {
                        // El producto ya esta, solo modificamos la cantidad
                        $cantidad_1 = $carrito[$current_id]['cantidad'];
                        $nueva_cantidad = $cantidad_1 + $cant;
                        if($nueva_cantidad<=$stock)
                        {
                            $carrito[$current_id]['cantidad'] = $nueva_cantidad;
                        }
                    }
                    else
                    {
                        // El producto no esta, vemos si no estamos sobrepasando el limite de productos
                        if($numItem<$limite_items_carrito)
                        {
                            //$carrito[$id]= array('id' => $id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $uni,'precio' => $precio,'uu' => $id_unidad,'ee' => $id_producto);
                            $carrito[$current_id]= array('id' => $current_id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $unidad,'precio' => $precio_soles,'id_producto' => $id_producto,'dscto' => $dscto, 'id_color' => $idColor, 'stock'=>$stock);
                        } // if
                        else
                        {
                            // Pasamos el limite de productos permitidos, redirigimos al carro con msg de error
                            $this->session->set_userdata('carrito',$carrito);
                            redirect('pedido/carro/limite'); 
                        }
                    } // else
                } // if
                else
                {
                    // Carro no existe, primer producto que le metemos
                    if($cant<=$stock)
                    {
                        $carrito=array();
                        $carrito[$current_id]= array('id' => $current_id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $unidad,'precio' => $precio_soles,'id_producto' => $id_producto,'dscto' => $dscto, 'id_color' => $idColor, 'stock'=>$stock);
                    }
                } // else
                $this->session->set_userdata('carrito',$carrito);
            } // if $cant>0
        } // for
        //
        redirect('pedido/carro');   
    }
    
    function agregarProximamente() {
        $id_producto = $this->input->post('id_producto_p');
        $id_categoria = $this->input->post('id_categoria_p');
        $nombre_producto = $this->input->post('nombre_p');
        if( $this->session->userdata('tipoReserva') )
        {
            $tipoReserva = $this->session->userdata('tipoReserva');
            if($tipoReserva=="stock")
            {
                if( ($id_categoria=="") || ($id_categoria==0) )
                {
                   redirect('detalle-producto/'.$id_producto.'/'.$nombre_producto.'/errorTipo'); 
                }
                else
                {
                    redirect('detalle-producto/'.$id_producto.'/'.$id_categoria.'/'.$nombre_producto.'/errorTipo'); 
                }                    
            }
        }
        else
        {
            $tipoReserva = 'proximamente';
            $this->session->set_userdata('tipoReserva', $tipoReserva);
        } // else
        
        $aux_ids = $this->input->post('lista_ids_prox');
        $lista_ids = explode("#", $aux_ids);
        $limite_items_carrito = getConfig("limite_items_carrito");

        for($j=0; $j<count($lista_ids); $j++)
        {
            $current_id = $lista_ids[$j];
            $color = $this->input->post('color_p_'.$current_id);
            $aux_unidad = $this->input->post('uni_p_'.$current_id);
            $unid = explode("()", $aux_unidad);
            $unidad = $unid[0];    
            $id_unidad = $unid[1];
            $codigo = $this->input->post('codigo_p');
            $nombre = $this->input->post('nombre_p');
            $id_producto = $this->input->post('id_producto_p');
            $dscto = $this->input->post('dscto_p');
            $idColor = $this->input->post('idColor_p_'.$current_id); 
            $aux_cant = $this->input->post('cant_p_'.$current_id);
            $cant = (int)($aux_cant);
            $stock = $this->input->post('stock_p_'.$current_id);
            $precio_proximamente = $this->input->post('precio_p_'.$current_id);
            if($cant>0)
            {
                // Esta porcion de codigo la comentamos el 31-Agosto-2107 porque Edgar dice que a los productos
                // proximamente no se les aplica descuento
                /*
                if($this->session->userdata('descuento_especial')=="si")
                {
                    // A este cliente aplica descuento especial
                    $aux_porc = $this->Pedido_model->getPorcentajeDescuento($id_producto);
                    $porcentaje_descuento = $aux_porc->descuento_especial;
                    if($porcentaje_descuento>0)
                    {
                        $porc_con_descuento = 100 - $porcentaje_descuento;
                        $precio_uax = ($porc_con_descuento/100)*($precio_proximamente);
                        $precio = $precio_uax;
                    }
                    else
                    {
                        $precio = $precio_proximamente;
                    }
                }
                else
                {
                    $precio = $precio_proximamente;
                }
                */

                // ASI QUEDA EL PRECIO, SIN DESCUENTO, DEFRENTE SU PRECIO PROXIMAMENTE
                $precio = $precio_proximamente;

                if($this->session->userdata('carrito'))
                {
                    $carrito = $this->session->userdata('carrito');
                    $numItem = count($carrito);                    
                    if(isset($carrito[$current_id]))
                    {
                        $cantidad_1 = $carrito[$current_id]['cantidad'];
                        $nueva_cantidad = $cantidad_1 + $cant;
                        if($nueva_cantidad<=$stock)
                        {
                            $carrito[$current_id]['cantidad'] = $nueva_cantidad;
                        }
                    }
                    else
                    {
                        if($numItem<$limite_items_carrito)
                        {
                            //$carrito[$id]= array('id' => $id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $uni,'precio' => $precio,'uu' => $id_unidad,'ee' => $id_producto);
                            $carrito[$current_id]= array('id' => $current_id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $unidad,'precio' => $precio,'id_producto' => $id_producto,'dscto' => $dscto, 'id_color' => $idColor, 'stock'=>$stock);
                        } // if
                    } // else
                } // if
                else
                {
                    if($cant<=$stock)
                    {
                        $carrito=array();
                        $carrito[$current_id]= array('id' => $current_id,'cantidad' => $cant,'color' => $color,'codigo' => $codigo,'nombre' => $nombre,'uni' => $unidad,'precio' => $precio,'id_producto' => $id_producto,'dscto' => $dscto, 'id_color' => $idColor, 'stock'=>$stock);
                    }
                } // else
                $this->session->set_userdata('carrito',$carrito);
            } // if $cant>0
        } // for
        //
        redirect('pedido/carro');   
    }
        
 

}
?>