<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all_users_with_roles() {
        $this->db->select('u.*, r.name as role_name');
        $this->db->from('users u');
        $this->db->join('user_roles ur', 'u.id = ur.user_id', 'left');
        $this->db->join('roles r', 'ur.role_id = r.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_user_role($user_id) {
        $this->db->select('r.name as role_name');
        $this->db->from('user_roles ur');
        $this->db->join('roles r', 'ur.role_id = r.id');
        $this->db->where('ur.user_id', $user_id);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->row()->role_name : null;
    }

    public function get_all_roles() {
        $query = $this->db->get('roles');
        return $query->result();
    }

    public function get_user_counts() {
        $counts = array(
            'admin' => 0,
            'dosen' => 0,
            'kaprodi' => 0,
            'dekan' => 0,
            'warek1' => 0,
            'warek2' => 0,
            'rektor' => 0
        );

        $users = $this->get_all_users_with_roles();
        foreach ($users as $user) {
            if ($user->role_name == 'admin') {
                $counts['admin']++;
            } elseif ($user->role_name == 'dosen') {
                $counts['dosen']++;
            } elseif ($user->role_name == 'kaprodi') {
                $counts['kaprodi']++;
            } elseif ($user->role_name == 'dekan') {
                $counts['dekan']++;
            } elseif ($user->role_name == 'warek1') {
                $counts['warek1']++;
            } elseif ($user->role_name == 'warek2') {
                $counts['warek2']++;
            } elseif ($user->role_name == 'rektor') {
                $counts['rektor']++;
            }
        }
        return $counts;
    }

    public function add_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function assign_role($user_id, $role_id) {
        $data = array(
            'user_id' => $user_id,
            'role_id' => $role_id
        );
        $this->db->insert('user_roles', $data);
    }

    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    public function update_user_role($user_id, $role_id) {
        $this->db->delete('user_roles', array('user_id' => $user_id));
        $data = array(
            'user_id' => $user_id,
            'role_id' => $role_id
        );
        $this->db->insert('user_roles', $data);
    }

    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        $this->db->where('user_id', $user_id);
        $this->db->delete('user_roles');
    }

    public function get_surat_count($user_id) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('surat_lk');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->row()->count;
    }

    // Method baru untuk menghitung surat berdasarkan status
    public function get_surat_status_count($user_id, $status) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('surat_lk');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', $status);
        $query = $this->db->get();
        return $query->row()->count;
    }
}