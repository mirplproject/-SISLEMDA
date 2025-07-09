<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disposisi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil detail utama satu pengajuan berdasarkan ID-nya.
     * Termasuk nama role pengaju dan daftar lampiran.
     * @param int $id_pengajuan ID pengajuan.
     * @return object|null Objek detail pengajuan jika ditemukan.
     */
    public function get_pengajuan_detail($id_pengajuan) {
        // Query untuk detail pengajuan utama
        $this->db->select('p.*, u.nama as nama_user, ks.nama_surat, r.nama_role as nama_role_pengaju');
        $this->db->from('pengajuan p');
        $this->db->join('user u', 'u.id_user = p.id_user', 'left');
        $this->db->join('klasifikasi_surat ks', 'ks.id_klasifikasi_surat = p.id_klasifikasi_surat', 'left');
        $this->db->join('role r', 'r.id_role = p.role_pengaju', 'left');
        $this->db->where('p.id_pengajuan', $id_pengajuan);
        $query = $this->db->get();
        $pengajuan_detail = $query->row(); // Menggunakan row() karena kita hanya mengambil 1 data

        if ($pengajuan_detail) {
            // Query untuk lampiran
            // Menggunakan kolom 'file' dari tabel 'lampiran'
            $this->db->select('id_lampiran, file'); // Kolom 'file' adalah nama file lampiran
            $this->db->from('lampiran'); // Nama tabel lampiran sudah dikonfirmasi
            $this->db->where('id_pengajuan', $id_pengajuan);
            $pengajuan_detail->lampiran = $this->db->get()->result(); // Menyimpan hasil ke properti 'lampiran'
        }

        return $pengajuan_detail;
    }

    /**
     * Mengambil riwayat disposisi untuk pengajuan tertentu.
     * @param int $id_pengajuan ID pengajuan.
     * @return array Array of objects containing disposisi history data.
     */
    public function get_riwayat_disposisi($id_pengajuan) {
        $this->db->select('d.*, u_from.nama as dari_nama, u_from.nik as dari_nik, un.nama_unit as nama_tujuan_unit');
        $this->db->from('disposisi d');
        $this->db->join('user u_from', 'u_from.id_user = d.dari_user', 'left');
        $this->db->join('unit_pengajuan un', 'un.id_unit = d.ke_unit', 'left');
        $this->db->where('d.id_pengajuan', $id_pengajuan);
        $this->db->order_by('d.tanggal_disposisi', 'ASC');
        return $this->db->get()->result();
    }
}