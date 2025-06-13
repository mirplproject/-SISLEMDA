<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Surat_model');
		$this->load->model('User_model');
		$this->load->helper('url', 'form', 'file');
	}

	public function index()
	{
		$data['klasifikasis'] = $this->Surat_model->get_all_klasifikasi();
		$data['users'] = $this->User_model->getUserWithRoles(); // Ambil data user dengan role
		$data['title'] = 'Klasifikasi Surat';
		$data['content_view'] = 'surat/index';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/footer', $data);
	}

	public function insert() {
        $this->load->model('Surat_model');

        // Ambil data form
        $data = [
			'id_user'				=> $this->input->post('user_id'),
			'id_klasifikasi_surat'	=> $this->input->post('kode'),
            'no_surat'				=> $this->input->post('no'),
			'perihal'				=> $this->input->post('perihal'),
            'tanggal_pengajuan'		=> $this->input->post('tanggal'),
			'status_pengajuan'		=> ''
        ];

        // Simpan pengajuan dan ambil ID-nya
        $pengajuan_id = $this->Surat_model->insert_pengajuan($data);

		// Simpan dokumen
		$lampiran = [
			'id_pengajuan' => $pengajuan_id,
			'file' => $_FILES['dokumen']['name'] // Ganti dengan nama file yang diupload
		];
		$this->Surat_model->insert_lampiran($lampiran);

		// Simpan disposisi
		$disposisi = [
			'id_pengajuan' => $pengajuan_id,
			'dari_user_id' => $this->input->post('user_id'),
			'ke_user_id' => $this->input->post('user_id'), // Ganti dengan ID user yang dituju jika ada
			'urutan' => '', // Ganti dengan urutan disposisi jika ada
			'tanggal_disposisi' => $this->input->post('tanggal'),
			'catatan' => $this->input->post('disposisi'),
			'status_disposisi' => '' // Ganti dengan status disposisi jika ada
		];
		$this->Surat_model->insert_disposisi($disposisi);

		// Redirect ke halaman sukses
		
        redirect('surat/success');
    }

    public function success() {
		$this->session->set_flashdata('success', 'Pengajuan berhasil dikirim.');
        redirect('user/lembar_pengajuan');
    }

}
?>