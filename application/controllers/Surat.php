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

		// Cek apakah pengaju adalah dosen
		$role = $this->db
		    ->select('r.id_role, r.nama_role')
		    ->from('user_role ur')
		    ->join('role r', 'r.id_role = ur.id_role')
		    ->where('ur.id_user', $dari_user_id)
		    ->get()->row();

		if (!$role) {
		    $this->session->set_flashdata('error', 'Role pengirim tidak ditemukan.');
		    return;
		}

		$data = [
		    'id_pengajuan'      => $pengajuan_id,
		    'dari_user'      => $dari_user_id,
		    'tanggal_disposisi' => $tanggal,
		    'catatan'           => $catatan,
		    'status_disposisi'  => ''
		];

		// Set ke_unit berdasarkan role
		switch ($role->nama_role) {
		    case 'dosen':
		        $kaprodi = $this->User_model->get_kaprodi_by_dosen_user($dari_user_id);
		        if ($kaprodi) {
		            $data['ke_unit'] = $kaprodi->id_user;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Kaprodi tidak ditemukan.');
		            return;
		        }
		        break;
			
		    case 'kaprodi':
		        $dekan = $this->User_model->get_dekan_by_kaprodi_user($dari_user_id);
		        if ($dekan) {
		            $data['ke_unit'] = $dekan->id_user;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Dekan tidak ditemukan.');
		            return;
		        }
		        break;
			
		    case 'dekan':
		        $warek1 = $this->User_model->get_user_by_role_name('warek1');
		        if ($warek1) {
		            $data['ke_unit'] = $warek1->id_user;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Wakil Rektor 1 tidak ditemukan.');
		            return;
		        }
		        break;

			case 'warek1':
		        $rektor = $this->User_model->get_user_by_role_name('rektor');
		        if ($rektor) {
		            $data['ke_unit'] = $rektor->id_user;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Rektor tidak ditemukan.');
		            return;
		        }
		        break;

			case 'warek2':
		        $ketua_bidang_keuangan = $this->User_model->get_user_by_initials('KBDKEU');
		        if ($ketua_bidang_keuangan) {
		            $data['ke_unit'] = $ketua_bidang_keuangan->id_user;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Ketua Bidang Keuangan tidak ditemukan.');
		            return;
		        }
		        break;
			case 'warek3':
		        $warek1 = $this->User_model->get_user_by_role_name('warek1');
		        if ($warek1) {
		            $data['ke_unit'] = $warek1->id_user;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Wakil Rektor 1 tidak ditemukan.');
		            return;
		        }
		        break;
			case 'yayasan':
		        $rektor = $this->User_model->get_role_name('rektor');
		        if ($rektor) {
		            $data['ke_unit'] = $rektor->id_role;
		            $data['urutan'] = 1;
		        } else {
		            $this->session->set_flashdata('error', 'Rektor tidak ditemukan.');
		            return;
		        }
		        break;
				
		    default:
		        $this->session->set_flashdata('error', 'Role pengirim tidak berhak mendisposisi.');
		        return;
		}

		// Insert the data into the disposisi table
		$this->db->insert('disposisi', $data);
		$this->session->set_flashdata('success', 'Disposisi berhasil dikirim.');

		// Redirect ke halaman sukses
		redirect('surat/success');
    }

    public function success() {
		$this->session->set_flashdata('success', 'Pengajuan berhasil dikirim.');
        redirect('user/lembar_pengajuan');
    }

}
?>