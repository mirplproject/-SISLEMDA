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
		$data['userkapro'] = $this->User_model->getUserKaprodi(); // Ambil data user dengan role kaprodi
		$data['no_surat'] = $this->Surat_model->generate_nomor_surat(); // Generate nomor surat
		$data['title'] = 'Klasifikasi Surat';
		$data['content_view'] = 'surat/index';
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/footer', $data);
	}

	public function insert() {
        $this->load->model('Surat_model');
		// Ambil nomor yang baru di-generate
		$no_surat = $this->Surat_model->generate_nomor_surat();

		// Cek apakah nomor ini sudah digunakan
		$cek = $this->db->get_where('pengajuan', ['no_surat' => $no_surat])->num_rows();

		if ($cek > 0) {
		// Kembalikan pesan error atau regenerate ulang
		$no_surat = $this->Surat_model->generate_nomor_surat(); // Bisa diganti strategi loop jika perlu
		}

        // Ambil data form
        $data = [
			'id_user'				=> $this->input->post('user_id'),
			'role'					=> $this->input->post('nama_role'),
			'id_klasifikasi_surat'	=> $this->input->post('kode'),
            'no_surat'				=> $this->input->post('no'),
			'perihal'				=> $this->input->post('perihal'),
            'tanggal_pengajuan'		=> $this->input->post('tanggal'),
			'status_pengajuan'		=> 'Diproses'
        ];

        // Simpan pengajuan dan ambil ID-nya
        $pengajuan_id = $this->Surat_model->insert_pengajuan($data);

		// Simpan dokumen
		$this->load->library('upload');
		$files = $_FILES['dokumen'];
		$file_count = count($files['name']);
		
		for ($i = 0; $i < $file_count; $i++) {
			if (!empty($files['name'][$i])) {
				$_FILES['single_dokumen']['name']     = $files['name'][$i];
				$_FILES['single_dokumen']['type']     = $files['type'][$i];
				$_FILES['single_dokumen']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['single_dokumen']['error']    = $files['error'][$i];
				$_FILES['single_dokumen']['size']     = $files['size'][$i];

				$config['upload_path']   = './assets/template/uploads/';
				$config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
				$config['encrypt_name']  = true;

				$this->upload->initialize($config);

				if ($this->upload->do_upload('single_dokumen')) {
					$data_upload = $this->upload->data();
					$lampiran = [
						'id_pengajuan' => $pengajuan_id,
						'file'    => $data_upload['client_name'],
					];
					$this->Surat_model->insert_lampiran($lampiran);
				}
			}
		}


		$catatan = $this->input->post('disposisi');
		$dari_user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$role_tujuan = $this->input->post('tujuan');
		

		// Ambil role pengirim
		$user_role = $this->User_model->get_user_role($dari_user_id); // return object { id_role, nama_role }
		$role_name = strtolower($user_role->nama_role);
		$tujuan_roles = [];

		// Tentukan tujuan berdasarkan role
		switch ($role_name) {
			case 'dosen':
				$kaprodi = $this->User_model->get_kaprodi_role_by_dosen($dari_user_id);
				if ($kaprodi) $tujuan_roles[] = $kaprodi->id_role;
				break;
			// case 'kaprodi':
			// 	$dekan = $this->User_model->get_dekan_role_by_kaprodi($dari_user_id);
			// 	if ($dekan) $tujuan_roles[] = $dekan->id_role;
			// 	break;

			// case 'dekan':
			// 	$warek1 = $this->User_model->get_role_by_name('Wakil Rektor 1');
			// 	if ($warek1) $tujuan_roles[] = $warek1->id_role;
			// 	break;

			case 'perpustakaan dan inovasi':
				$warek1 = $this->User_model->get_role_by_name('Wakil Rektor 1');
				if ($warek1) $tujuan_roles[] = $warek1->id_role;
				break;

			case 'pengembangan bahasa':
				$warek1 = $this->User_model->get_role_by_name('Wakil Rektor 1');
				if ($warek1) $tujuan_roles[] = $warek1->id_role;
				break;

			case 'monitoring dan evaluasi':
				$ppm = $this->User_model->get_role_by_name('Pusat Penjamin Mutu');
				if ($ppm) $tujuan_roles[] = $ppm->id_role;
				break;

			case 'dokumen pelaporan':
				$ppm = $this->User_model->get_role_by_name('Pusat Penjamin Mutu');
				if ($ppm) $tujuan_roles[] = $ppm->id_role;
				break;

			case 'spme':
				$ppm = $this->User_model->get_role_by_name('Pusat Penjamin Mutu');
				if ($ppm) $tujuan_roles[] = $ppm->id_role;
				break;

			case 'lab':
				$siij = $this->User_model->get_role_by_name('Sistem Informasi dan Infrastruktur Jaringan');
				if ($siij) $tujuan_roles[] = $siij->id_role;
				break;

			case 'subag perencanaan sistem':
				$pps = $this->User_model->get_role_by_name('Perencanaan dan Pengembangan Sistem');
				if ($pps) $tujuan_roles[] = $pps->id_role;
				break;

			case 'subag pengembangan sistem':
				$pps = $this->User_model->get_role_by_name('Perencanaan dan Pengembangan Sistem');
				if ($pps) $tujuan_roles[] = $pps->id_role;
				break;

			case 'subag pddikti dan beasiswa':
				$baa = $this->User_model->get_role_by_name('Bagian Administrasi dan Akademik');
				if ($baa) $tujuan_roles[] = $baa->id_role;
				break;

			case 'subag administrasi perkuliahan':
				$baa = $this->User_model->get_role_by_name('Bagian Administrasi dan Akademik');
				if ($baa) $tujuan_roles[] = $baa->id_role;
				break;

			case 'subag penelitian dan luaran':
				$bpp = $this->User_model->get_role_by_name('Bagian Penelitian dan PKM');
				if ($bpp) $tujuan_roles[] = $bpp->id_role;
				break;

			case 'subag pkm dan luaran':
				$bpp = $this->User_model->get_role_by_name('Bagian Penelitian dan PKM');
				if ($bpp) $tujuan_roles[] = $bpp->id_role;
				break;

			case 'subag ketenagaan':
				$pds = $this->User_model->get_role_by_name('Pengembangan dan SDM');
				if ($pds) $tujuan_roles[] = $pds->id_role;
				break;

			case 'pengembangan karir dosen dan tendik':
				$pds = $this->User_model->get_role_by_name('Pengembangan dan SDM');
				if ($pds) $tujuan_roles[] = $pds->id_role;
				break;

			case 'subag penerimaan keuangan':
				$keuangan = $this->User_model->get_role_by_name('Keuangan');
				if ($keuangan) $tujuan_roles[] = $keuangan->id_role;
				break;

			case 'subag anggaran dan pengeluaran':
				$keuangan = $this->User_model->get_role_by_name('Keuangan');
				if ($keuangan) $tujuan_roles[] = $keuangan->id_role;
				break;

			case 'subag akuntansi':
				$keuangan = $this->User_model->get_role_by_name('Keuangan');
				if ($keuangan) $tujuan_roles[] = $keuangan->id_role;
				break;

			case 'subag operasional':
				$opu = $this->User_model->get_role_by_name('Operasional Pembelajaran dan Umum');
				if ($opu) $tujuan_roles[] = $opu->id_role;
				break;

			case 'subag umum':
				$opu = $this->User_model->get_role_by_name('Operasional Pembelajaran dan Umum');
				if ($opu) $tujuan_roles[] = $opu->id_role;
				break;

			case 'subag kemahasiswaan':
				$kk = $this->User_model->get_role_by_name('Kemahasiswaan dan Konseling');
				if ($kk) $tujuan_roles[] = $kk->id_role;
				break;

			case 'subag konseling':
				$kk = $this->User_model->get_role_by_name('Kemahasiswaan dan Konseling');
				if ($kk) $tujuan_roles[] = $kk->id_role;
				break;

			case 'subag admisi pmb':
				$pk = $this->User_model->get_role_by_name('Pemasaran dan Kerjasama');
				if ($pk) $tujuan_roles[] = $pk->id_role;
				break;

			case 'subag kerjasama marketing dan humas':
				$pk = $this->User_model->get_role_by_name('Pemasaran dan Kerjasama');
				if ($pk) $tujuan_roles[] = $pk->id_role;
				break;

			case 'data analyst':
				$digitalmarketing = $this->User_model->get_role_by_name('Subag Digital Marketing');
				if ($digitalmarketing) $tujuan_roles[] = $digitalmarketing->id_role;
				break;

			case 'konten editor':
				$digitalmarketing = $this->User_model->get_role_by_name('Subag Digital Marketing');
				if ($digitalmarketing) $tujuan_roles[] = $digitalmarketing->id_role;
				break;

			case 'konten kreator':
				$digitalmarketing = $this->User_model->get_role_by_name('Subag Digital Marketing');
				if ($digitalmarketing) $tujuan_roles[] = $digitalmarketing->id_role;
				break;

			case 'subag pemagangan dan penempatan kerja':
				$bic = $this->User_model->get_role_by_name('Bina Insani Career');
				if ($bic) $tujuan_roles[] = $bic->id_role;
				break;

			case 'subag tracer study':
				$bic = $this->User_model->get_role_by_name('Bina Insani Career');
				if ($bic) $tujuan_roles[] = $bic->id_role;
				break;

			case 'subag inkubasi bisnis':
				$wirausaha = $this->User_model->get_role_by_name('Kewirausahaan');
				if ($wirausaha) $tujuan_roles[] = $wirausaha->id_role;
				break;

			case 'subag pengembangan starup':
				$wirausaha = $this->User_model->get_role_by_name('Kewirausahaan');
				if ($wirausaha) $tujuan_roles[] = $wirausaha->id_role;
				break;

			case 'wakil rektor 1':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'wakil rektor 2':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'wakil rektor 3':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'pusat penjamin mutu':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'rektor':
				$yayasan = $this->User_model->get_role_by_name('Yayasan');
				if ($yayasan) $tujuan_roles[] = $yayasan->id_role;
				break;

			case 'yayasan':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'dekan':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'kaprodi':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'sistem informasi dan infrastruktur jaringan':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;
				
			case 'perencanaan dan pengembangan sistem':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'badan administrasi dan akademik':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'bagian penelitian dan pkm':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'pengembangan dan sdm':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'keuangan':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'operasional pembelajaran dan umum':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'kemahasiswaan dan konseling':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'pemasaran dan kerjasama':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'subag digital marketing':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'bina insani career':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			case 'kewirausahaan':
				if (!empty($role_tujuan)) {
					$tujuan_roles[] = (int)$role_tujuan;
				}
				break;

			default:
				$this->session->set_flashdata('error', 'Role tidak diizinkan melakukan disposisi.');
				redirect('user/lembar_pengajuan');
				return;
		}

		// Simpan disposisi berdasarkan role tujuan
		if (!empty($tujuan_roles)) {
			foreach ($tujuan_roles as $role_id) {
				$data = [
					'id_pengajuan'      => $pengajuan_id,
					'dari_user'         => $dari_user_id,
					'ke_unit'           => is_object($role_id) ? $role_id->id_role : $role_id,
					'urutan'            => 1,
					'tanggal_disposisi' => $tanggal,
					'catatan'           => $catatan,
					'status_disposisi'  => ''
				];
				$this->db->insert('disposisi', $data);
			}
			$this->session->set_flashdata('success', 'Disposisi berhasil dikirim.');
		} else {
			$this->session->set_flashdata('error', 'Tujuan disposisi tidak ditemukan.');
		}

		// Redirect ke halaman sukses
		redirect('surat/success');
    }

    public function success() {
		$this->session->set_flashdata('success', 'Pengajuan berhasil dikirim.');
        redirect('user/lembar_pengajuan');
    }

}
?>