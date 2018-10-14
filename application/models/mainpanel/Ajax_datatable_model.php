<?php
class Ajax_datatable_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    #CATEGORIAS
    public function searchCategorias($where){
        $sql = "SELECT id_categoria, nombre_categoria, imagen, orden, estado, tipo, incluir_en_inventario";
        $sql .= " FROM categorias ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numCategorias(){
        $query = $this->db
                ->select('*')
                ->from('categorias')
                ->get();
        return $query->num_rows();
    }
    #SUBCATEGORIAS
    public function searchSubCategorias($id_categoria, $where){
        $sql = "SELECT id_subcategoria, nombre, orden, estado ";
        $sql .= " FROM subcategorias ";
        $sql .= " WHERE id_categoria='$id_categoria' and $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numSubCategorias($id_categoria){
        $query = $this->db
                ->select('*')
                ->from('subcategorias')
                ->where('id_categoria',$id_categoria)
                ->get();
        return $query->num_rows();
    }
    #PRODUCTOS
    public function searchProducto($id_subcategoria, $where){
        $sql = "SELECT p.id_producto, p.nombre, p.imagen, p.codigo, p.tipo, p.orden, p.actualizacion";
        $sql .= " FROM productos p INNER JOIN productos_x_subcategoria pxs ON p.id_producto=pxs.id_producto ";
        $sql .= " WHERE pxs.id_subcategoria='$id_subcategoria' and $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numProductos($id_subcategoria){
        $query = $this->db
                ->select(['p.id_producto', 'p.nombre', 'p.imagen', 'p.codigo', 'p.tipo', 'p.orden','p.actualizacion'])
                ->from('productos p')
                ->join('productos_x_subcategoria pxs', 'p.id_producto=pxs.id_producto','inner')
                ->where('pxs.id_subcategoria',$id_subcategoria)
                ->get();
        return $query->num_rows();
    }
    public function SearchFotosColores($id_producto, $where) {
        $sql = "SELECT s.id,s.id_producto, IF(c.id IS NULL, ' ', c.nombre)AS nombre,IF(c.id IS NULL, ' ', c.color)AS color";
        $sql .= " FROM stock_color s LEFT JOIN colores c ON s.id_color = c.id ";
        $sql .= " WHERE s.id_producto='$id_producto' and $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numFotosColores($id_producto){
        $query = $this->db
                ->select('*')
                ->from('stock_color')
                ->where('id_producto',$id_producto)
                ->get();
        return $query->num_rows();
    }
    #Clientes
    public function searchClientes($where){
        $sql = "SELECT * ";
        $sql .= " FROM inscritos ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numClientes($where){
        $query = $this->db
                ->select('*')
                ->from('inscritos')
                ->where('estado',$where)
                ->get();
        return $query->num_rows();
    }
    #Unidades
    public function searchUnidades($where){
        $sql = "SELECT * ";
        $sql .= " FROM unidades ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numUnidades(){
        $query = $this->db
                ->select('*')
                ->from('unidades')
                ->get();
        return $query->num_rows();
    }
    #mensajes
    public function searchMostrados($where){
        $sql = "SELECT * ";
        $sql .= " FROM mensajes ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numMostrados(){
        $query = $this->db
                ->select('*')
                ->from('mensajes')
                ->get();
        return $query->num_rows();
    }
    public function searchRecibidos($where){
        $sql = "SELECT * ";
        $sql .= " FROM contactenos ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numRecibidos(){
        $query = $this->db
                ->select('*')
                ->from('contactenos')
                ->get();
        return $query->num_rows();
    }
    #Colores
    public function searchCatColores($where){
        $sql = "SELECT * ";
        $sql .= " FROM cat_colores ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numCatColores(){
        $query = $this->db
                ->select('*')
                ->from('cat_colores')
                ->get();
        return $query->num_rows();
    }
    public function searchColores($categoria_id, $where){
        $sql = "SELECT * ";
        $sql .= " FROM colores ";
        $sql .= " WHERE id_categoria='$categoria_id' and $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numColores($categoria_id){
        $query = $this->db
                ->select('*')
                ->from('colores')
                ->where('id_categoria',$categoria_id)
                ->get();
        return $query->num_rows();
    }
    #Boletines
    public function searchBoletines($where){
        $sql = "SELECT id, titulo, fecha_registro, estado, fecha_envio ";
        $sql .= " FROM boletines ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numBoletines(){
        $query = $this->db
                ->select('*')
                ->from('boletines')
                ->get();
        return $query->num_rows();
    }
    #Configuraciones
    public function searchConfiguraciones($where){
        $sql = "SELECT * ";
        $sql .= " FROM configuracion ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numConfiguraciones(){
        $query = $this->db
                ->select('*')
                ->from('configuracion')
                ->get();
        return $query->num_rows();
    }
    #Reservas
    public function searchReservas($estado, $where){
        $sql = "SELECT i.nombre AS nombrecliente,i.razon_social AS razonsocial,r.* ";
        $sql .= " FROM reservas r ";
        $sql .= " INNER JOIN inscritos i ON r.id_cliente = i.id ";
        $sql .= " WHERE r.estado='$estado' AND $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numReservas($estado){
        $query = $this->db
                ->select('*')
                ->from('reservas')
                ->where('estado',$estado)
                ->get();
        return $query->num_rows();
    }
    #Banners
    public function searchBanners($where){
        $sql = "SELECT * ";
        $sql .= " FROM banner_usuarios ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numBanners(){
        $query = $this->db
                ->select('*')
                ->from('banner_usuarios')
                ->get();
        return $query->num_rows();
    }

    public function numBannerscliente(){
        $query = $this->db
                ->select('*')
                ->from('banner_clientes')
                ->get();
        return $query->num_rows();
    }
    public function searchBannersCliente($where) {
        $sql = "SELECT * ";
        $sql .= " FROM banner_clientes ";
        $sql .= " WHERE $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    #Compras
    public function searchCompras($fecha, $where, $where2){
        $sql = "SELECT c.*,  GROUP_CONCAT( DISTINCT CONCAT(d.codigo_producto,'<br>')) AS codigo_producto , IF(i.id IS NULL, 'Cliente eliminado', CONCAT(i.razon_social, '<br>Persona Contacto:',i.nombre))AS cliente";
        $sql .= " FROM compras c ";
        $sql .= " LEFT JOIN inscritos i ON i.id = c.id_cliente ";
        $sql .= " LEFT JOIN compras_detalle d ON d.id_compra = c.id_orden ";
        $sql .= " WHERE c.fecha_ingreso > '$fecha' AND $where  GROUP BY c.id_orden $where2";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function numCompras($where){
        $this->db->where('fecha_ingreso >', $where);
        $this->db->from('compras');
        return $this->db->count_all_results();
    }
}
?>