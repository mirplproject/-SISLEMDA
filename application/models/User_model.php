<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_user() {
        $this->db->select('user.*, roles.name as role_name');
        $this->db->from('user');
        $this->db->join('user_roles', 'user_roles.user_id = user.id', 'left');
        $this->db->join('roles', 'user_roles.role_id = roles.id', 'left');
        $this->db->order_by('user.id', 'ASC');
        return $this->db->get()->result();
    }

     // Fungsi untuk mendapatkan semua riwayat pengajuan
    // atau riwayat pengajuan berdasarkan ID user jika ID diberikan
    public function get_riwayat_pengajuan($user_id = null) {
        $this->db->select('pengajuan.id_pengajuan, user.username, klasifikasi_surat.nama_surat, pengajuan.no_surat, pengajuan.perihal, pengajuan.tanggal_pengajuan, pengajuan.status_pengajuan');
        $this->db->from('pengajuan pengajuan');
        $this->db->join('user user', 'user.id_user = pengajuan.id_user');
        $this->db->join('klasifikasi_surat klasifikasi_surat', 'klasifikasi_surat.id_klasifikasi_surat = pengajuan.id_klasifikasi_surat');

        if ($user_id !== null) {
            $this->db->where('pengajuan.id_user', $user_id);
        }

        $this->db->order_by('pengajuan.tanggal_pengajuan', 'DESC'); // Urutkan berdasarkan tanggal pengajuan terbaru
        return $this->db->get()->result_array();
    }

}