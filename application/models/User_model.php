<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil semua data user beserta nama role mereka.
     * @return array Array of objects containing user and role data.
     */
    public function get_all_user() {
        $this->db->select('user.*, roles.name as role_name');
        $this->db->from('user');
        $this->db->join('user_roles', 'user_roles.user_id = user.id', 'left');
        $this->db->join('roles', 'user_roles.role_id = roles.id', 'left');
        $this->db->order_by('user.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil riwayat pengajuan untuk user tertentu, mengecualikan status 'direvisi' dan 'diproses'.
     * Data diurutkan dari tanggal pengajuan terlama ke terbaru (ASC).
     * @param int|null $user_id ID user. Jika null, tidak ada filter user spesifik.
     * @return array Array of associative arrays containing pengajuan history data.
     */
    public function get_riwayat_pengajuan($user_id = null) {
        $this->db->select('pengajuan.id_pengajuan, user.username, klasifikasi_surat.nama_surat, pengajuan.no_surat, pengajuan.perihal, pengajuan.tanggal_pengajuan, pengajuan.status_pengajuan');
        $this->db->from('pengajuan');
        $this->db->join('user', 'user.id_user = pengajuan.id_user');
        $this->db->join('klasifikasi_surat', 'klasifikasi_surat.id_klasifikasi_surat = pengajuan.id_klasifikasi_surat');

        if ($user_id !== null) {
            $this->db->where('pengajuan.id_user', $user_id);
        }
        // Mengecualikan status 'direvisi' dan 'diproses' dari daftar riwayat
        $this->db->where('pengajuan.status_pengajuan !=', 'direvisi');
        $this->db->where('pengajuan.status_pengajuan !=', 'diproses');

        $this->db->order_by('pengajuan.tanggal_pengajuan', 'DESC'); // Mengembalikan ke DESC sesuai riwayat terakhir
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil N data pengajuan terbaru untuk user tertentu, diurutkan DESC (terbaru duluan).
     * Digunakan untuk notifikasi di header.
     * @param int $user_id ID user.
     * @param int $limit Jumlah data yang ingin diambil.
     * @return array Array of associative arrays containing latest pengajuan data.
     */
    public function get_latest_pengajuan($user_id, $limit = 3) {
        $this->db->select('id_pengajuan, perihal, tanggal_pengajuan, status_pengajuan');
        $this->db->from('pengajuan');
        $this->db->where('id_user', $user_id); // Filter berdasarkan user yang login
        $this->db->order_by('tanggal_pengajuan', 'DESC'); // Urutkan berdasarkan tanggal pengajuan terbaru
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    /**
     * Mengambil detail lengkap satu pengajuan berdasarkan ID-nya,
     * termasuk data lampiran dan riwayat disposisi.
     *
     * @param int $id_pengajuan ID pengajuan yang akan diambil detailnya.
     * @return object|null Objek detail pengajuan jika ditemukan, atau null.
     */
    public function get_detail_pengajuan($id_pengajuan) {
        // Query untuk detail pengajuan utama
        // Menggunakan 'u.nama' dari tabel user untuk nama_user (Pengaju)
        $this->db->select('p.*, u.nama as nama_user, ks.nama_surat');
        $this->db->from('pengajuan p');
        $this->db->join('user u', 'u.id_user = p.id_user');
        $this->db->join('klasifikasi_surat ks', 'ks.id_klasifikasi_surat = p.id_klasifikasi_surat');
        $this->db->where('p.id_pengajuan', $id_pengajuan);
        $query = $this->db->get();
        $pengajuan_detail = $query->row();

        if ($pengajuan_detail) {
            // Query untuk lampiran
            // Menggunakan kolom 'file' dari tabel 'lampiran'
            $this->db->select('id_lampiran, file');
            $this->db->from('lampiran');
            $this->db->where('id_pengajuan', $id_pengajuan);
            $pengajuan_detail->lampiran = $this->db->get()->result();

            // Query untuk disposisi
            // Mengambil nama dan NIK dari user yang MENDISPOSISI (dari_user)
            $this->db->select('d.*, u_from.nama as nama_tujuan, u_from.nik');
            $this->db->from('disposisi d');
            // Join ke tabel user untuk 'dari_user' (siapa yang mendisposisi)
            $this->db->join('user u_from', 'u_from.id_user = d.dari_user', 'left');

            $this->db->where('d.id_pengajuan', $id_pengajuan);
            $this->db->order_by('d.tanggal_disposisi', 'ASC');
            $pengajuan_detail->disposisi = $this->db->get()->result();
        }

        return $pengajuan_detail;
    }
}