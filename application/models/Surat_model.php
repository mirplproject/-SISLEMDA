<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_klasifikasi()
    {
        $query = $this->db->get('klasifikasi_surat');
        return $query->result_array();
    }

    public function insert_pengajuan($data)
    {
        $this->db->insert('pengajuan', $data);
        return $this->db->insert_id();
    }

    public function insert_disposisi($data)
    {
        $this->db->insert('disposisi', $data);
        return $this->db->insert_id();
    }

    public function insert_lampiran($data)
    {
        $this->db->insert('lampiran', $data);
        return $this->db->insert_id();
    }
    
}
?>