<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth_m extends CI_Model {
    public function login($username, $password) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->where('password', MD5($password));
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_user_roles($user_id) {
        $this->db->select('r.nama_role');
        $this->db->from('user_role ur');
        $this->db->join('role r', 'r.id_role = ur.id_role');
        $this->db->where('ur.id_user', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}