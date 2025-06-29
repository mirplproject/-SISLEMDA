<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    private $user1_roles;
    private $user2_roles;
    private $user3_roles;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('admin_m');
        $this->load->model('User_model');
        $this->load->model('Surat_model');

        // Definisikan kategori role
        $this->user1_roles = [
            'Dosen', 'Pelayanan_Akademik', 'Komputasi_Data', 'Penelitian_Pkm', 'Publikasi_Hki',
            'Inkubator_Bisnis', 'Pendidikan_Pelatihan', 'Pengembangan_Karir', 'Pelayanan', 'Akuntansi',
            'Pajak', 'Kerumahtanggaan', 'Sarpras', 'Upt_Perpustakaan', 'Lab', 'Ppks', 'Data_Analyst',
            'Konten_Editor', 'Monitoring_Evaluasi', 'Pelaporan_Data', 'Spme'
        ];
        $this->user2_roles = [
            'Kaprodi', 'Dekan', 'Bak', 'Lppm', 'Kerjasama', 'Keuangan', 'Umum', 'Si_Infrastruktur_Jaringan',
            'Kemahasiswaan', 'Marketing_Promosi', 'Bina Insani Career', 'Pusat Penjamin Mutu', 'Wakil Rektor 1', 'Wakil Rektor 2', 'Wakil Rektor 3', 'Rektor'
        ];
        $this->user3_roles = ['SDM', 'Yayasan'];

        // Validasi login dan role admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('active_role') == 'admin') {
            redirect('auth/login');
        }

        // Validasi active_role
        $allowed_roles = $this->admin_m->get_user_roles($this->session->userdata('id_user'));
        $active_role = $this->session->userdata('active_role');
        $is_valid = false;
        foreach ($allowed_roles as $role) {
            if ($role['nama_role'] == $active_role) {
                $is_valid = true;
                break;
            }
        }
        if (!$is_valid) {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $data = [];
        $data['title'] = 'Dashboard User';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/dashboard';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function lembar_pengajuan() {
        $data = [];
        $data['all_roles'] = $this->db->get('role')->result_array();
        $data['current_role'] = strtolower($this->User_model->get_user_role($this->session->userdata('id_user'))->nama_role);
        $data['title'] = 'Lembar Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $data['klasifikasis'] = $this->Surat_model->get_all_klasifikasi();
        $data['unitpengajuan'] = $this->Surat_model->get_all_unitpengajuan();
        $data['no_surat'] = $this->Surat_model->generate_nomor_surat(); // Generate nomor surat


        // Ambil role user dari session atau query
        $id_user = $this->session->userdata('id_user');
        $role_obj = $this->User_model->get_user_role($id_user); // Harus return objek role
        $data['nama_role'] = $role_obj ? $role_obj->id_role : '';

        $role = $this->User_model->get_role_by_user($id_user); // Asumsinya fungsi ini mengembalikan objek dengan properti 'nama_role'

        $role_atas = [
            'wakil rektor 1',
            'wakil rektor 2',
            'wakil rektor 3',
            'pusat penjamin mutu',
            // 'rektor',
            'yayasan',
            'dekan',
            'kaprodi',
            'sistem informasi dan infrastruktur jaringan',
            'perencanaan dan pengembangan sistem',
            'badan administrasi dan akademik',
            'bagian penelitian dan pkm',
            'pengembangan dan sdm',
            'keuangan',
            'operasional pembelajaran dan umum',
            'kemahasiswaan dan konseling',
            'pemasaran dan kerjasama',
            'bina insani career',
            'kewirausahaan',
            'subag digital marketing'
        ];

        if ($role && in_array(strtolower(trim($role->nama_role)), $role_atas)) {
            $data['content_view'] = 'user/lembar_pengajuan_atas';
        } else {
            $data['content_view'] = 'user/lembar_pengajuan';
        }

        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function status_pengajuan() {
        $data = [];
        $data['title'] = 'Status Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/status_pengajuan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function surat_masuk() {
        $data = [];
        $data['title'] = 'Surat Masuk';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/surat_masuk';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function riwayat_pengajuan() {
        $data = [];
        $data['title'] = 'Riwayat Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/riwayat_pengajuan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function laporan() {
        // $active_role = $this->session->userdata('active_role');
        // if (!in_array($active_role, $this->user2_roles)) {
        //     redirect('user/dashboard');
        // }
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $role_user = $this->session->userdata('role'); // Ganti sesuai session kamu
        $id_user = $this->session->userdata('id_user'); // Jika perlu filter spesifik ke user

        if ($start_date && $end_date) {
            $riwayat = $this->M_pengajuan->getDisposisiMasuk($role_user, $start_date, $end_date);
        } else {
            $riwayat = [];
        }

        $data = [];
        $data['title'] = 'Laporan';
        $data['riwayat'] = $riwayat;
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/laporan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function arsip() {
        $active_role = $this->session->userdata('active_role');
        if (!in_array($active_role, $this->user3_roles)) {
            redirect('user/dashboard');
        }

        $data = [];
        $data['title'] = 'Arsip';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/arsip';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }
}