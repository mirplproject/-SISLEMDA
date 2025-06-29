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

    public function get_user_role($user_id)
    {
        return $this->db->select('r.id_role, r.nama_role')
            ->from('user_role ur')
            ->join('role r', 'ur.id_role = r.id_role')
            ->where('ur.id_user', $user_id)
            ->get()
            ->row();
    }

    public function get_kaprodi_role_by_dosen($dosen_user_id)
    {
        // Ambil id_prodi dari dosen
        $dosen = $this->db->get_where('Dosen', ['id_user' => $dosen_user_id])->row();
        if (!$dosen) return null;

        $kaprodi = $this->db->select('ur.id_role')
            ->from('kaprodi k')
            ->join('user_role ur', 'ur.id_user = k.id_user')
            ->where('k.id_prodi', $dosen->id_prodi)
            ->get()
            ->row();
        return $kaprodi;
    }

    public function get_dekan_role_by_kaprodi($kaprodi_user_id)
    {
        // Ambil id_fakultas dari prodi -> kaprodi
        $kaprodi = $this->db->get_where('kaprodi', ['id_user' => $kaprodi_user_id])->row();
        if (!$kaprodi) return null;

        $prodi = $this->db->get_where('prodi', ['id_prodi' => $kaprodi->id_prodi])->row();
        if (!$prodi) return null;

        $dekan = $this->db->select('ur.id_role')
            ->from('dekan d')
            ->join('user_role ur', 'ur.id_user = d.id_user')
            ->where('d.id_fakultas', $prodi->id_fakultas)
            ->get()
            ->row();
        return $dekan;
    }

    public function get_role_by_name($role_name)
    {
        return $this->db->get_where('role', ['LOWER(nama_role)' => strtolower($role_name)])->row();
    }

    public function get_roles_by_names($role_names = [])
    {
        return $this->db->select('id_role')
            ->from('role')
            ->where( $role_names)
            ->get()
            ->result_array();
    }

    public function get_roles_except($excluded_names = [])
    {
        return $this->db->select('id_role')
            ->from('role')
            ->where_not_in('LOWER(nama_role)', array_map('strtolower', $excluded_names))
            ->get()
            ->result_array();
    }

    public function getDisposisiMasuk($role_user, $start_date, $end_date)
    {
        $this->db->select('*');
        $this->db->from('pengajuan');
        $this->db->join('disposisi', 'disposisi.id_pengajuan = pengajuan.id_pengajuan');
        $this->db->where('disposisi.tujuan_role', $role_user);
        $this->db->where('pengajuan.tanggal_pengajuan >=', $start_date);
        $this->db->where('pengajuan.tanggal_pengajuan <=', $end_date);
        $this->db->order_by('pengajuan.tanggal_pengajuan', 'DESC');

        return $this->db->get()->result();
    }

}