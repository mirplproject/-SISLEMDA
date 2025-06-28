<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disposisi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Disposisi_model');
        $this->load->helper('url');

        if (!class_exists('Dompdf\Dompdf')) {
            $this->load->library('Dompdf_lib');
        }
    }

    public function unduh_disposisi($id_pengajuan) {
        // Ambil data utama
        $data['row'] = $this->Disposisi_model->get_pengajuan_detail($id_pengajuan);

        if (empty($data['row'])) {
            show_404();
            return;
        }

        // Hitung jumlah revisi
        $this->db->from('disposisi');
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->where('status_disposisi', 'revisi');
        $jumlah_revisi = $this->db->count_all_results();

        // Siapkan konfigurasi
        $data['lembar_kendali_config'] = [
            'no_lembar_kendali' => '851',
            'kode_dokumen_internal' => '8.51-15',
            'ditutup_tgl' => '',
            'disimpan_tgl' => '',
            'unit_kerja_penyimpanan' => ''
        ];

        $data['jumlah_revisi'] = $jumlah_revisi;
          // Ambil riwayat disposisi
        $riwayat_disposisi = $this->Disposisi_model->get_riwayat_disposisi($id_pengajuan);
        $data['riwayat_disposisi'] = $riwayat_disposisi;

        // Mendapatkan nama penerima untuk judul file dan PDF
        $nama_penerima_disposisi = 'Tidak Diketahui'; // Default value
        if (!empty($riwayat_disposisi)) {
            // Kita ambil nama penerima dari disposisi pertama (yang paling relevan untuk dokumen utama)
            // Ini akan menjadi nama user yang melakukan disposisi, sesuai dengan diskusi kita.
            $nama_penerima_disposisi = $riwayat_disposisi[0]->dari_nama; // Ambil dari alias 'dari_nama' di model
        }
        // Pass nama penerima ke view agar bisa digunakan di title PDF
        $data['nama_penerima_disposisi'] = $nama_penerima_disposisi;
        // Render view HTML
        $html = $this->load->view('pdf/laporan_disposisi_v', $data, true);

        // Generate PDF
        if (class_exists('Dompdf\Dompdf')) {
            $dompdf = new Dompdf\Dompdf();
            $options = new Dompdf\Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $dompdf->setOptions($options);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream("Lembar_Kendali_Disposisi_{$id_pengajuan}.pdf", ["Attachment" => false]);
        } else {
            $this->dompdf_lib->createPdf(
                $html,
                "Lembar_Kendali_Disposisi_{$id_pengajuan}.pdf",
                'A4',
                'portrait',
                true
            );
        }
        exit();
    }
}