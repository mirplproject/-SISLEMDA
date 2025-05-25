<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_m extends CI_Model {
    public function get_total_users() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function get_all_users_with_roles() {
        $this->db->select('u.*, GROUP_CONCAT(r.nama_role) as roles, p.nama_prodi, f.nama_fakultas');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.id_user = u.id_user', 'left');
        $this->db->join('role r', 'r.id_role = ur.id_role', 'left');
        $this->db->join('dosen d', 'd.id_user = u.id_user', 'left');
        $this->db->join('prodi p', 'p.id_prodi = d.id_prodi', 'left');
        $this->db->join('kaprodi k', 'k.id_user = u.id_user', 'left');
        $this->db->join('prodi p2', 'p2.id_prodi = k.id_prodi', 'left');
        $this->db->join('dekan dk', 'dk.id_user = u.id_user', 'left');
        $this->db->join('fakultas f', 'f.id_fakultas = dk.id_fakultas', 'left');
        $this->db->group_by('u.id_user');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_id($user_id) {
        // Ambil data user
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.id_user', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();

        // Ambil semua role yang dimiliki user
        if ($result) {
            $roles = $this->db->select('r.id_role, r.nama_role')
                             ->from('user_role ur')
                             ->join('role r', 'r.id_role = ur.id_role')
                             ->where('ur.id_user', $user_id)
                             ->get()
                             ->result_array();
            $result['roles'] = $roles;
        }
        return $result;
    }

    public function get_user_roles($user_id) {
        $this->db->select('r.*');
        $this->db->from('user_role ur');
        $this->db->join('role r', 'r.id_role = ur.id_role');
        $this->db->where('ur.id_user', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_roles() {
        $this->db->select('*');
        $this->db->from('role');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_prodis() {
        $this->db->select('p.*, f.nama_fakultas');
        $this->db->from('prodi p');
        $this->db->join('fakultas f', 'f.id_fakultas = p.id_fakultas', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_prodi_by_id($id_prodi) {
        $this->db->select('p.*, f.nama_fakultas');
        $this->db->from('prodi p');
        $this->db->join('fakultas f', 'f.id_fakultas = p.id_fakultas', 'left');
        $this->db->where('p.id_prodi', $id_prodi);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_all_fakultas() {
        $this->db->select('*');
        $this->db->from('fakultas');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_user($data_user) {
        $this->db->insert('user', $data_user);
        return $this->db->insert_id();
    }

    public function add_prodi($data_prodi) {
        $this->db->insert('prodi', $data_prodi);
    }

    public function update_prodi($id_prodi, $data_prodi) {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->update('prodi', $data_prodi);
    }

    public function delete_prodi($id_prodi) {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->delete('prodi');
    }

    public function add_role_to_user($user_id, $role_id) {
        $data = array('id_user' => $user_id, 'id_role' => $role_id);
        $this->db->insert('user_role', $data);
    }

    public function remove_role_from_user($user_id, $role_id) {
        $this->db->where('id_user', $user_id);
        $this->db->where('id_role', $role_id);
        $this->db->delete('user_role');
    }

    public function assign_dosen($user_id, $prodi_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('dosen');
        $data = array('id_user' => $user_id, 'id_prodi' => $prodi_id);
        $this->db->insert('dosen', $data);
    }

    public function assign_kaprodi($user_id, $prodi_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('kaprodi');
        $data = array('id_user' => $user_id, 'id_prodi' => $prodi_id);
        $this->db->insert('kaprodi', $data);
    }

    public function assign_dekan($user_id, $fakultas_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('dekan');
        $data = array('id_user' => $user_id, 'id_fakultas' => $fakultas_id);
        $this->db->insert('dekan', $data);
    }

    public function update_user($user_id, $data_user) {
        $this->db->where('id_user', $user_id);
        $this->db->update('user', $data_user);
    }

    public function delete_user($user_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('user');
        $this->db->where('id_user', $user_id);
        $this->db->delete('user_role');
        $this->db->where('id_user', $user_id);
        $this->db->delete('dosen');
        $this->db->where('id_user', $user_id);
        $this->db->delete('kaprodi');
        $this->db->where('id_user', $user_id);
        $this->db->delete('dekan');
    }

    public function get_all_klasifikasi_surat() {
        $this->db->select('*');
        $this->db->from('klasifikasi_surat');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_klasifikasi_surat_by_id($id_klasifikasi_surat) {
        $this->db->select('*');
        $this->db->from('klasifikasi_surat');
        $this->db->where('id_klasifikasi_surat', $id_klasifikasi_surat);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add_klasifikasi_surat($data_klasifikasi) {
        $this->db->insert('klasifikasi_surat', $data_klasifikasi);
    }

    public function update_klasifikasi_surat($id_klasifikasi_surat, $data_klasifikasi) {
        $this->db->where('id_klasifikasi_surat', $id_klasifikasi_surat);
        $this->db->update('klasifikasi_surat', $data_klasifikasi);
    }

    public function delete_klasifikasi_surat($id_klasifikasi_surat) {
        $this->db->where('id_klasifikasi_surat', $id_klasifikasi_surat);
        $this->db->delete('klasifikasi_surat');
    }
}