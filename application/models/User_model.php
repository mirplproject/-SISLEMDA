<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil semua data user beserta nama role mereka.
     * Menggunakan 'roles.nama_role' dan 'roles.id_role' sesuai struktur DB.
     * @return array Array of objects containing user and role data.
     */
    public function get_all_user() {
        $this->db->select('user.*, role.nama_role as role_name'); // Corrected: roles.name -> roles.nama_role
        $this->db->from('user');
        $this->db->join('user_role', 'user_role.user_id = user.id', 'left');
        $this->db->join('role', 'user_role.role_id = role.id_role', 'left'); // Corrected: roles.id -> roles.id_role
        $this->db->order_by('user.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil riwayat pengajuan untuk user tertentu, mengecualikan status 'direvisi' dan 'diproses'.
     * Data diurutkan dari tanggal pengajuan terbaru ke terlama (DESC).
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
        $this->db->where('pengajuan.status_pengajuan !=', 'direvisi');
        $this->db->where('pengajuan.status_pengajuan !=', 'diproses');

        $this->db->order_by('pengajuan.tanggal_pengajuan', 'DESC');
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
        $this->db->where('id_user', $user_id);
        $this->db->order_by('tanggal_pengajuan', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    /**
     * Mengambil detail lengkap satu pengajuan berdasarkan ID-nya,
     * termasuk data lampiran dan riwayat disposisi.
     * Menggunakan 'roles.nama_role' dan 'roles.id_role' sesuai struktur DB.
     * @param int $id_pengajuan ID pengajuan yang akan diambil detailnya.
     * @return object|null Objek detail pengajuan jika ditemukan, atau null.
     */
    public function get_detail_pengajuan($id_pengajuan) {
        // Query untuk detail pengajuan utama
        $this->db->select('p.*, u.nama as nama_user, ks.nama_surat, r.nama_role as nama_role_pengaju'); // Corrected: r.name -> r.nama_role
        $this->db->from('pengajuan p');
        $this->db->join('user u', 'u.id_user = p.id_user');
        $this->db->join('klasifikasi_surat ks', 'ks.id_klasifikasi_surat = p.id_klasifikasi_surat');
        $this->db->join('role r', 'r.id_role = p.role_pengaju', 'left'); // Corrected: r.id -> r.id_role
        $this->db->where('p.id_pengajuan', $id_pengajuan);
        $query = $this->db->get();
        $pengajuan_detail = $query->row();

        if ($pengajuan_detail) {
            // Query untuk lampiran
            $this->db->select('id_lampiran, file');
            $this->db->from('lampiran');
            $this->db->where('id_pengajuan', $id_pengajuan);
            $pengajuan_detail->lampiran = $this->db->get()->result();

            // Query untuk disposisi
            $this->db->select('d.*, u_from.nama as nama_tujuan, u_from.nik');
            $this->db->from('disposisi d');
            $this->db->join('user u_from', 'u_from.id_user = d.dari_user', 'left');

            $this->db->where('d.id_pengajuan', $id_pengajuan);
            $this->db->order_by('d.tanggal_disposisi', 'ASC');
            $pengajuan_detail->disposisi = $this->db->get()->result();
        }

        return $pengajuan_detail;
    }

    // --- FUNGSI BARU UNTUK DASHBOARD ---

    /**
     * Menghitung total pengajuan untuk user tertentu.
     * @param int $user_id ID user.
     * @return int Jumlah total pengajuan.
     */
    public function count_total_pengajuan($user_id) {
        $this->db->where('id_user', $user_id);
        return $this->db->count_all_results('pengajuan');
    }

    /**
     * Menghitung total disposisi masuk untuk pengajuan user tertentu.
     * Asumsi: "Disposisi Masuk" berarti disposisi yang terkait dengan pengajuan yang dibuat user.
     * @param int $user_id ID user.
     * @return int Jumlah total disposisi masuk.
     */
    public function count_total_disposisi_masuk($user_id) {
        $this->db->from('disposisi d');
        $this->db->join('pengajuan p', 'p.id_pengajuan = d.id_pengajuan');
        $this->db->where('p.id_user', $user_id);
        return $this->db->count_all_results();
    }

    /**
     * Menghitung total pengajuan yang berstatus 'disetujui' atau 'ditolak' untuk user tertentu.
     * Ini dianggap sebagai 'laporan' atau status final.
     * @param int $user_id ID user.
     * @return int Jumlah total laporan pengajuan.
     */
    public function count_total_laporan_pengajuan($user_id) {
        $this->db->where('id_user', $user_id);
        $this->db->where_in('status_pengajuan', ['disetujui', 'ditolak']);
        return $this->db->count_all_results('pengajuan');
    }

    /**
     * Menghitung total seluruh pengajuan yang berstatus 'disetujui' atau 'ditolak' (untuk arsip).
     * Ini tidak difilter berdasarkan user.
     * @return int Jumlah total arsip pengajuan.
     */
    public function count_total_arsip() {
        $this->db->where_in('status_pengajuan', ['disetujui', 'ditolak']);
        return $this->db->count_all_results('pengajuan');
    }

    /**
     * Mengambil 5 data pengajuan terbaru untuk tabel di dashboard.
     * @param int $user_id ID user.
     * @return array Array of associative arrays containing latest pengajuan data.
     */
    public function get_dashboard_latest_pengajuan($user_id) {
        $this->db->select('id_pengajuan, no_surat, perihal, tanggal_pengajuan, status_pengajuan');
        $this->db->from('pengajuan');
        $this->db->where('id_user', $user_id);
        $this->db->order_by('tanggal_pengajuan', 'DESC');
        $this->db->limit(5); // Hanya 5 data
        return $this->db->get()->result_array();
    }
}