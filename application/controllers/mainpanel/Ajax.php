<?php
class Ajax extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    
        $this->load->model('mainpanel/Ajax_model');
    }

    public function index()	{

    }

    public function getNovedad() {
        $id_novedad = $_POST['id'];
        $data = $this->Ajax_model->getNovedad($id_novedad);
        $json['titulo'] = $data->titulo;
        $json['sumilla'] = $data->sumilla;
        $json['foto'] = $data->foto;
        echo json_encode($json);
    }
    
    public function graba_pre_stock() {
        $id_subcategoria = $_POST['id_subcategoria'];
        $cad_pre = $_POST['cad_pre'];
        $cad_stock = $_POST['cad_stock'];        
        
        $cad1=explode("##",$cad_pre );
        for($q=0;$q<count($cad1);$q++){
           $current=explode("()",$cad1[$q]);
           $envio=array();
           $envio['precio']=$current[0];
           $id=$current[1];           
           $this->Ajax_model->updatePrecio($id,$envio);                           
        }
        
        $cad1=explode("##",$cad_stock );
        for($q=0;$q<count($cad1);$q++){
           $current=explode("()",$cad1[$q]);
           $envio=array();
           $envio['stock']=$current[0];
           $id=$current[1];           
           $this->Ajax_model->updateStock($id,$envio);                           
        }
        
        $json=array();
        $json['id_subcategoria'] = $id_subcategoria;
        echo json_encode($json);
    }    
        
    public function eliminaColores(){
            $id = $_POST['id'];
            $id_producto= $_POST['id_producto'];
            $this->Ajax_model->eliminaColor($id);		
            echo json_encode($id_producto);
	} 
        
    public function eliminaPrecio(){
            $id = $_POST['id'];
            $id_producto= $_POST['id_producto'];
            $this->Ajax_model->eliminaPrecio($id);		
            echo json_encode($id_producto);
	}        
        
    public function trasladaProd() {
        $id_eliminar = $_POST['id_eliminar'];
        $id_categoria_padre= $_POST['id_categoria_padre'];        
        $data=array();
        $data['id_categoria_padre']=$id_categoria_padre;
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $this->Ajax_model->updateProd($id,$data);
        }
        echo json_encode($id_categoria_padre);
    } 

    public function eliminaProd() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $dato= $this->Ajax_model->getProd($id);
            $foto=$dato->imagen;
            $id_categoria_padre=$dato->id_categoria_padre;            
            @unlink('files/productos_thumbs/'.$foto);
            @unlink('files/productos_thumbs_m/'.$foto);
            @unlink('files/productos/'.$foto);
            $this->Ajax_model->deleteProducto($id);
        }
        //$this->load->view('mainpanel/catalogo/listado_productos/57/success');
        //redirect('mainpanel/catalogo/listado_productos/57/success');
        echo json_encode($id_categoria_padre);
    } 
    
    public function eliminaCli() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $this->Ajax_model->deleteCliente($id);
        }
        $data='success';
        echo json_encode($data);
    }
    
    public function revisarMultiPedidos() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++)
        {
            $id=$cad_id[$x];
            $dato = array("estado"=>"Revisado");
            $this->Ajax_model->revisaPedido($id, $dato);
        }
        $data='success';
        echo json_encode($data);
    }
    
    public function eliminaCliInactivos() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $this->Ajax_model->deleteCliente($id);
        }
        $data='success';
        echo json_encode($data);
    }
    
    public function eliminaCliAnulados() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $this->Ajax_model->deleteCliente($id);
        }
        $data='success';
        echo json_encode($data);
    }
    
    public function eliminaCliBorrados() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $this->Ajax_model->deleteCliente($id);
        }
        $data='success';
        echo json_encode($data);
    }
    
    public function anularCli() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $datt=array();
            $datt['estado']='Anulado';
            $this->Ajax_model->anulaCliente($id,$datt);
        }
        $data='success';
        echo json_encode($data);
    }  
    
    public function desactivaCli() {
        $id_eliminar = $_POST['id_eliminar'];
        $cad_id=explode("##",$id_eliminar);
        $num_id=count($cad_id);
        for($x=0;$x<$num_id;$x++){
            $id=$cad_id[$x];
            $datt=array();
            $datt['estado']='Inactivo';
            $this->Ajax_model->desactivarCliente($id,$datt);
        }
        $data='success';
        echo json_encode($data);
    }     

    public function combo_subcategorias() {
        $id_categoria = $_POST['id_categoria'];
        $aux= $this->Ajax_model->getListaSubCategorias($id_categoria);
        $dato=array();
        $cont=0;
        foreach ($aux as $value){
            $id_subcategoria = $value->id_subcategoria;
            $subcategoria = $value->nombre;
            $dato[] = $id_subcategoria.'$$'.$subcategoria;
            $cont +=1;
        }
        $envio=$cont.'@@'.implode("@@",$dato);
        $json['dato'] = $envio;
        echo json_encode($json);
    }
    
    public function agrega_producto_boletin() {
        $codigo = $_POST['codigo'];
        $aux = $this->Ajax_model->getDatosProducto($codigo);
        $id_producto = $aux->id_producto;
        $nombre_producto = $aux->nombre;
        $codigo_producto = $aux->codigo;
        $imagen_producto = $aux->imagen;
        
        $elegidos = explode("#", $_POST['elegidos']);
        if($_POST['elegidos']=="")
        {
            // Esta vacio, lo agregamos
            $final = $id_producto;
            $se_agrego = 1;
        }
        else if(in_array($id_producto, $elegidos))
        {
            // Ya esta, no hacemos nada
            $final = $_POST['elegidos'];
            $se_agrego = 0;
        }
        else
        {
            // No esta, lo agregamos
            $elegidos[] = $id_producto;
            $final = implode("#",$elegidos);
            $se_agrego = 1;
        }
        $envio = $id_producto.'@@'.$nombre_producto.'@@'.$codigo_producto.'@@'.$imagen_producto.'@@'.$se_agrego.'@@'.$final;
        $json['dato'] = $envio;
        echo json_encode($json);
    }
    
    public function quitar_producto_boletin() {
        $id_producto = $_POST['id_producto'];
        $elegidos = explode("#", $_POST['elegidos']);
        $aux2 = array();
        for($i=0; $i<count($elegidos); $i++)
        {
            if($elegidos[$i]!=$id_producto)
            {
                $aux2[] = $elegidos[$i];
            }
        }
        $json['dato'] = $id_producto.'@@'.implode("#",$aux2);
        echo json_encode($json);
    }
    
    public function agrega_subcat_lista() {
        $id_categoria = $_POST['id_categoria'];
        $aux = $this->Ajax_model->getNombreCategoria($id_categoria);
        $categoria = $aux->nombre_categoria;
        
        $id_subcategoria = $_POST['id_subcategoria'];
        $aux2 = $this->Ajax_model->getNombreSubCategoria($id_subcategoria);
        $subcategoria = $aux2->nombre;
        
        $elegidos = explode("#", $_POST['elegidos']);
        if($_POST['elegidos']=="")
        {
            // Esta vacio, lo agregamos
            $final = $id_subcategoria;
            $se_agrego = 1;
        }
        else if(in_array($id_subcategoria, $elegidos))
        {
            // Ya esta, no hacemos nada
            $final = $_POST['elegidos'];
            $se_agrego = 0;
        }
        else
        {
            // No esta, lo agregamos
            $elegidos[] = $id_subcategoria;
            $final = implode("#",$elegidos);
            $se_agrego = 1;
        }
        $envio = $categoria.'@@'.$subcategoria.'@@'.$id_subcategoria.'@@'.$se_agrego.'@@'.$final;
        $json['dato'] = $envio;
        echo json_encode($json);
    }
    
    public function quitar_subcat_lista() {
        $id_subcategoria = $_POST['id_subcategoria'];
        $elegidos = explode("#", $_POST['elegidos']);
        $aux2 = array();
        for($i=0; $i<count($elegidos); $i++)
        {
            if($elegidos[$i]!=$id_subcategoria)
            {
                $aux2[] = $elegidos[$i];
            }
        }
        $json['dato'] = $id_subcategoria.'@@'.implode("#",$aux2);
        echo json_encode($json);
    }
    
    public function muestra_color() {
        $id_categoria = $_POST['id_categoria'];
        $aux= $this->Ajax_model->muestraColor($id_categoria);
        $dato=array();
        $cont=0;
        foreach ($aux as $value){
            $color=$value->color;
            $nombre=$value->nombre;
            $id=$value->id;            
            $dato[]=$color.'$$'.$nombre.'$$'.$id;
            $cont +=1;
        }
        $envio=$cont.'@@'.implode("@@",$dato);
        $json['dato'] = $envio;
        echo json_encode($json);
    }
    
    public function elejido_color() {
        $id_color = $_POST['id_color'];
        $aux= $this->Ajax_model->getColor($id_color);
        $json['id'] = $aux->id;
        $json['color'] = $aux->color;
        $json['nombre'] = $aux->nombre;        
        echo json_encode($json);
    }     
    
    public function ordProd() {
        $ordenes = $_POST['orden'];
        $id_subcategoria = $_POST['id_subcategoria'];
        $cad1 = explode("&",$ordenes);
        $num = count($cad1);
        $orden = 0;
        $nuevoOrden = array();
	for($o=1; $o<=$num; $o++)
        {
            $str = explode("=",$cad1[$o]);
            $id = $str[1];
            $orden += 1;
            $data = array();
            $nuevoOrden[$orden] = array('id'=>$id, 'orden'=>$orden);	
        }
        $this->Ajax_model->limpiaOrdenSubcat($id_subcategoria);
        for($i=1; $i<count($nuevoOrden); $i++)
        {
            $current = $nuevoOrden[$i];
            $currentId = $current["id"];
            $currentOrden = $current["orden"];
            $data = array('id_producto'=>$currentId, 'id_subcategoria'=>$id_subcategoria, 'orden'=>$currentOrden);
            $resultado = $this->Ajax_model->grabarOrden($data);
        }
        echo json_decode();
    } 
    
    public function ordProd_old() {
        $ordenes = $_POST['orden'];
        $cad1 = explode("&",$ordenes);
        $num = count($cad1);
        $orden = 0;
	for($o=1; $o<=$num; $o++)
        {
            $str = explode("=",$cad1[$o]);
            $id = $str[1];
            $orden += 1;
            $data = array();
            $data['orden'] = $orden;
            $this->Ajax_model->ordProd($id,$data);        
            //$aux = "update productos set orden='$pos' where id_producto='$id'";
            //$sql[] = $aux;
            //$query = mysql_query($aux);	
        }
        echo json_decode();
    }  
    
    public function muestra_color_nuevo() {
        $id_categoria = $_POST['id_categoria'];
        $aux= $this->Ajax_model->muestraColor($id_categoria);
        $dato=array();
        $cont=0;
        foreach ($aux as $value){
            $color=$value->color;
            $nombre=$value->nombre;
            $id=$value->id;            
            $dato[]=$color.'$$'.$nombre.'$$'.$id;
            $cont +=1;
        }
        $envio=$cont.'@@'.implode("@@",$dato);
        $json['dato'] = $envio;
        echo json_encode($json);
    }
    
    public function agregaColor() {
        $id_color = $_POST['id_color'];
        $color = $this->Ajax_model->getColor($id_color);
        $nombreColor = $color->nombre;
        $codigoColor = $color->color;
        $stock = $_POST['stock'];
        $stock_prox = $_POST['stock_prox'];
        $fecha_llegada = $_POST['fecha_llegada'];
        $precio_prox = $_POST['precio_prox'];
        $orden_prox = $_POST['orden_prox'];
        if($_POST['elegidos']=="")
        {
            $retorno = $id_color."#".$stock."#".$stock_prox."#".$fecha_llegada."#".$precio_prox."#".$orden_prox."#".$nombreColor."#".$codigoColor;
        }
        else
        {
            $ids = explode("@", $_POST['elegidos']);
            $lista = array();
            $esta = false;
            for($i=0; $i<count($ids); $i++)
            {
                $current = explode("#", $ids[$i]);
                $id_color_current = $current[0];
                if($id_color==$id_color_current)
                {
                    // Ya esta, lo reemplazamos
                    
                    $lista[] = $id_color."#".$stock."#".$stock_prox."#".$fecha_llegada."#".$precio_prox."#".$orden_prox."#".$nombreColor."#".$codigoColor;
                    $esta = true;                    
                }
                else
                {
                    $lista[] = $ids[$i];
                }
            }
            if($esta==false)
            {
                $lista[] = $id_color."#".$stock."#".$stock_prox."#".$fecha_llegada."#".$precio_prox."#".$orden_prox."#".$nombreColor."#".$codigoColor;
            }
            $retorno = implode("@", $lista);  
        }
        echo $retorno;
    }
    
    public function eliminarColor() {
        $id_color = $_POST['id_color'];
        $elegidos = explode("@", $_POST['elegidos']);
        $lista = array();
        for($i=0; $i<count($elegidos); $i++)
        {
            $current = explode("#", $elegidos[$i]);
            $id_color_current = $current[0];
            if($id_color==$id_color_current)
            {
                // Ya esta, no lo ponemos                
            }
            else
            {
                $lista[] = $elegidos[$i];
            }
        }
        $retorno = implode("@", $lista);  
        echo $retorno;
    }
    
}
?>
