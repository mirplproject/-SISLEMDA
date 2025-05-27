<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class surat_model extends CI_Model {

    public function get_all() {
        return $this->db->get('surat')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('surat', ['id_surat' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('surat', $data);
    }

    public function update($id, $data) {
        return $this->db->update('surat', $data, ['id_surat' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('surat', ['id_surat' => $id]);
    }
}
