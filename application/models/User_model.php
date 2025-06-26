<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_role_by_user($id_user) {
        return $this->db->select('r.nama_role')
        ->from('user_role ur')
        ->join('role r', 'ur.id_role = r.id_role')
        ->where('ur.id_user', $id_user)
        ->get()
        ->row();
    }

    public function get_all_users() {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('user_roles', 'user_roles.user_id = users.id', 'left');
        $this->db->join('roles', 'user_roles.role_id = roles.id', 'left');
        $this->db->order_by('users.id', 'ASC');
        return $this->db->get()->result();
    }

    public function get_kaprodi_by_dosen_user($dosen_user_id)
    {
        // Ambil id_prodi dari dosen
        $this->db->select('d.id_prodi');
        $this->db->from('dosen d');
        $this->db->where('d.id_user', $dosen_user_id);
        $prodi = $this->db->get()->row();

        if ($prodi) {
            // Cari kaprodi pada prodi tersebut
            $this->db->select('u.id_user');
            $this->db->from('kaprodi k');
            $this->db->join('user u', 'u.id_user = k.id_user');
            $this->db->where('k.id_prodi', $prodi->id_prodi);
            return $this->db->get()->row(); // berisi id_user kaprodi
        }

        return null;
    }
    public function get_dekan_by_kaprodi_user($id_user_kaprodi)
    {
        return $this->db
        ->select('u.id_user')
        ->from('dekan d')
        ->join('fakultas f', 'f.id_fakultas = d.id_fakultas')
        ->join('prodi p', 'p.id_fakultas = f.id_fakultas')
        ->join('kaprodi k', 'k.id_prodi = p.id_prodi')
        ->join('user u', 'u.id_user = d.id_user')
        ->where('k.id_user', $id_user_kaprodi)
        ->get()->row();
    }

    public function get_user_by_role_name($nama_role)
    {
        return $this->db
        ->select('u.id_user')
        ->from('user_role ur')
        ->join('role r', 'r.id_role = ur.id_role')
        ->join('user u', 'u.id_user = ur.id_user')
        ->where('r.nama_role', $nama_role)
        ->get()->row();
    }

    public function get_role_name()
    {
        return $this->db
        ->select('r.*')
        ->from('role r')
        ->where('r.nama_role !=', 'admin')
        ->get()->row();
        
    }

    public function get_user_by_inisial($inisial)
    {
        return $this->db
        ->select('u.id_user')
        ->from('user u')
        ->where('u.inisial', $inisial)
        ->get()->row();
    }
}