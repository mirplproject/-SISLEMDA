<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disposisi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil detail utama satu pengajuan berdasarkan ID-nya.
     * @param int $id_pengajuan ID pengajuan.
     * @return object|null Objek detail pengajuan jika ditemukan.
     */
    public function get_pengajuan_detail($id_pengajuan) {
        $this->db->select('p.*, u.nama as nama_user, ks.nama_surat');
        $this->db->from('pengajuan p');
        $this->db->join('user u', 'u.id_user = p.id_user', 'left'); // Menggunakan u.nama untuk nama user
        $this->db->join('klasifikasi_surat ks', 'ks.id_klasifikasi_surat = p.id_klasifikasi_surat', 'left');
        $this->db->where('p.id_pengajuan', $id_pengajuan);
        return $this->db->get()->row();
    }

    /**
     * Mengambil riwayat disposisi untuk pengajuan tertentu.
     * Ini harus sesuai dengan kolom yang Anda butuhkan di laporan PDF.
     *
     * PENTING: Periksa dan sesuaikan SELECT dan JOIN ini berdasarkan kebutuhan tampilan PDF Anda
     * untuk kolom 'Kepada YTH', 'N/K', 'Tanggal', 'Disposisi'.
     *
     * @param int $id_pengajuan ID pengajuan.
     * @return array Array of objects containing disposisi history data.
     */
    public function get_riwayat_disposisi($id_pengajuan) {
        $this->db->select('d.*, u_from.nama as dari_nama, u_from.nik as dari_nik, un.nama_unit as nama_tujuan_unit'); // PENTING: Gunakan 'un.nama_unit' untuk tujuan jika ingin nama unit
        $this->db->from('disposisi d');
        // JOIN ke tabel user untuk user yang melakukan disposisi ('dari_user')
        $this->db->join('user u_from', 'u_from.id_user = d.dari_user', 'left'); // Kolom 'dari_user' di tabel 'disposisi'
        // JOIN ke tabel unit untuk unit yang dituju disposisi ('ke_unit')
        $this->db->join('unit_pengajuan un', 'un.id_unit = d.ke_unit', 'left');
        $this->db->where('d.id_pengajuan', $id_pengajuan);
        $this->db->order_by('d.tanggal_disposisi', 'ASC'); // Urutkan kronologis
        return $this->db->get()->result();
    }
}