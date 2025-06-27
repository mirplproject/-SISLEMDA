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

    public function get_riwayat_pengajuan($user_id = null) {
        $this->db->select('pengajuan.id_pengajuan, user.username, klasifikasi_surat.nama_surat, pengajuan.no_surat, pengajuan.perihal, pengajuan.tanggal_pengajuan, pengajuan.status_pengajuan');
        $this->db->from('pengajuan'); // Hapus alias 'pengajuan pengajuan' di sini jika tidak diperlukan lagi
        $this->db->join('user', 'user.id_user = pengajuan.id_user');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id_klasifikasi_surat = pengajuan.id_klasifikasi_surat');

        if ($user_id !== null) {
            $this->db->where('pengajuan.id_user', $user_id);
        }
        // --- TAMBAHKAN BARIS INI UNTUK FILTER STATUS ---
        // Mengecualikan status 'direvisi' dari daftar riwayat
        $this->db->where('pengajuan.status_pengajuan !=', 'direvisi');
        $this->db->where('pengajuan.status_pengajuan !=', 'diproses');

        $this->db->order_by('pengajuan.tanggal_pengajuan', 'DESC');
        return $this->db->get()->result_array();
    }

    // --- FUNGSI BARU/MODIFIKASI UNTUK NOTIFIKASI ---
    // Mengambil N data pengajuan terbaru untuk user tertentu
    public function get_latest_pengajuan($user_id, $limit = 3) {
        $this->db->select('id_pengajuan, perihal, tanggal_pengajuan, status_pengajuan');
        $this->db->from('pengajuan');
        $this->db->where('id_user', $user_id); // Filter berdasarkan user yang login
        $this->db->order_by('id_pengajuan', 'DESC'); // Urutkan berdasarkan ID terbaru (paling baru)
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }
    /**
     * Menampilkan halaman detail pengajuan spesifik.
     * Hanya user pemilik pengajuan yang bisa melihat detailnya.
     * @param int $id_pengajuan ID pengajuan yang akan ditampilkan detailnya.
     */
    public function get_detail_pengajuan($id_pengajuan = null) {
        // Pastikan ID pengajuan diberikan
        if ($id_pengajuan === null) {
            $this->session->set_flashdata('error', 'ID Pengajuan tidak ditemukan.');
            redirect('user/riwayat_pengajuan');
        }

        $data = [];
        $data['title'] = 'Detail Pengajuan';
        $data['user_name'] = $this->session->userdata('name');

        // Ambil data detail pengajuan dari model
        $pengajuan_detail = $this->User_model->get_detail_pengajuan($id_pengajuan);

        // Cek apakah data ditemukan dan apakah pengajuan ini milik user yang sedang login
        $current_user_id = $this->session->userdata('id_user');
        if (!$pengajuan_detail || $pengajuan_detail->id_user != $current_user_id) {
            $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan atau Anda tidak memiliki akses.');
            redirect('user/riwayat_pengajuan');
        }

        $data['row'] = $pengajuan_detail; // Variabel $row akan dilewatkan ke view detail_pengajuan.php

        $data['content_view'] = 'user/detail_pengajuan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

}