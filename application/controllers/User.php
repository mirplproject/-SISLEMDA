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
            'dosen', 'pelayanan_akademik', 'komputasi_data', 'penelitian_pkm', 'publikasi_hki',
            'inkubator_bisnis', 'pendidikan_pelatihan', 'pengembangan_karir', 'pelayanan', 'akuntansi',
            'pajak', 'kerumahtanggaan', 'sarpras', 'upt_perpustakaan', 'lab', 'ppks', 'data_analyst',
            'konten_editor', 'monitoring_evaluasi', 'pelaporan_data', 'spme'
        ];
        $this->user2_roles = [
            'kaprodi', 'dekan', 'bak', 'lppm', 'kerjasama', 'keuangan', 'umum', 'si_infrastruktur_jaringan',
            'kemahasiswaan', 'marketing_promosi', 'bic', 'ppm', 'warek1', 'warek2', 'warek3', 'rektor'
        ];
        $this->user3_roles = ['sdm', 'yayasan'];

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
        $data['title'] = 'Lembar Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $data['klasifikasis'] = $this->Surat_model->get_all_klasifikasi();
        $data['users'] = $this->User_model->getUserWithRoles();
        $data['content_view'] = 'user/lembar_pengajuan';
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
        $active_role = $this->session->userdata('active_role');
        if (!in_array($active_role, $this->user2_roles)) {
            redirect('user/dashboard');
        }

        $data = [];
        $data['title'] = 'Laporan';
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