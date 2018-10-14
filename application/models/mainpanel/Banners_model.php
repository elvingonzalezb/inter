<?php
class Banners_model extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    public function getListaBanners() {
        $this->db->order_by('orden');
        $query =  $this->db->get('banner_usuarios');
        return $query->result();
    }
    
    public function getBanner($id_banner) {
        $this->db->where('id_banner', $id_banner);
        $query =  $this->db->get('banner_usuarios');
        return $query->row();
    }
    
    public function updateBanner($id_banner, $data) {
        $this->db->where('id_banner', $id_banner);
        $this->db->update('banner_usuarios', $data);
    }
    
    public function deleteBanner($id_banner) {
        $this->db->where('id_banner', $id_banner);
        $this->db->delete('banner_usuarios');
    }
    
    public function grabarBanner($data) {
        $resultado = $this->db->insert('banner_usuarios', $data);
        return $resultado;
    }
    
    public function getListaBannersClientes() {
        $this->db->order_by('orden');
        $query =  $this->db->get('banner_clientes');
        return $query->result();
    }
    
    public function getBannerClientes($id_banner) {
        $this->db->where('id_banner', $id_banner);
        $query =  $this->db->get('banner_clientes');
        return $query->row();
    }
    
    public function updateBannerClientes($id_banner, $data) {
        $this->db->where('id_banner', $id_banner);
        $this->db->update('banner_clientes', $data);
    }
    
    public function deleteBannerClientes($id_banner) {
        $this->db->where('id_banner', $id_banner);
        $this->db->delete('banner_clientes');
    }
    
    public function grabarBannerClientes($data) {
        $resultado = $this->db->insert('banner_clientes', $data);
        return $resultado;
    }
}
?>
