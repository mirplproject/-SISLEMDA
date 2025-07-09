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
        $this->load->helper('notification'); // Pastikan helper ini dimuat
        $this->load->model('admin_m');
        $this->load->model('User_model');

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
            if (isset($role['nama_role']) && $role['nama_role'] == $active_role) {
                $is_valid = true;
                break;
            }
        }
        if (!$is_valid) {
            redirect('auth/login');
        }
    }

    // Helper untuk memuat data notifikasi ke $data array (tidak berubah)
    private function _load_notification_data(&$data) {
        $user_id = $this->session->userdata('id_user');
        $data['notifications'] = [];
        $data['is_new_notification'] = false; // Flag untuk ikon merah

        if ($user_id) {
            $latest_pengajuan = $this->User_model->get_latest_pengajuan($user_id, 3);
            $data['notifications'] = $latest_pengajuan;

            $last_seen_id = $this->session->userdata('last_seen_pengajuan_id');

            if (!empty($latest_pengajuan)) {
                $most_recent_id = $latest_pengajuan[0]['id_pengajuan'];
                if ($last_seen_id === null || $most_recent_id > $last_seen_id) {
                    $data['is_new_notification'] = true;
                }
            }
            $data['notification_count_display'] = !empty($latest_pengajuan) ? count($latest_pengajuan) : 0;
        }
    }

    // Fungsi untuk menandai notifikasi sudah dilihat (tidak berubah)
    public function mark_notifications_as_read() {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('id_user');
            if ($user_id) {
                $latest_pengajuan = $this->User_model->get_latest_pengajuan($user_id, 1);
                if (!empty($latest_pengajuan)) {
                    $most_recent_id = $latest_pengajuan[0]['id_pengajuan'];
                    $this->session->set_userdata('last_seen_pengajuan_id', $most_recent_id);
                }
            }
            echo json_encode(['status' => 'success']);
        } else {
            show_404();
        }
    }

    // --- MODIFIKASI FUNGSI DASHBOARD (ditambahkan data baru) ---
    public function dashboard() {
        $data = [];
        $data['title'] = 'Dashboard User';
        $data['user_name'] = $this->session->userdata('name');
        $user_id = $this->session->userdata('id_user'); // Ambil ID user yang sedang login
        $active_role = $this->session->userdata('active_role'); // Ambil active_role

        // 1. Data untuk Card "Total Pengajuan"
        $data['total_pengajuan'] = $this->User_model->count_total_pengajuan($user_id);

        // 2. Data untuk Card "Total Disposisi Masuk"
        // Asumsi 'disposisi masuk' berarti disposisi terkait pengajuan user yang login
        $data['total_disposisi_masuk'] = $this->User_model->count_total_disposisi_masuk($user_id);

        // 3. Data untuk Card "Total Laporan Pengajuan" (Conditional)
        $data['show_laporan_card'] = false;
        if (in_array($active_role, $this->user2_roles)) {
            $data['show_laporan_card'] = true;
            $data['total_laporan_pengajuan'] = $this->User_model->count_total_laporan_pengajuan($user_id);
        }

        // 4. Data untuk Card "Total Arsip" (Conditional)
        $data['show_arsip_card'] = false;
        if (in_array($active_role, $this->user3_roles)) {
            $data['show_arsip_card'] = true;
            $data['total_arsip'] = $this->User_model->count_total_arsip(); // Ini menghitung total arsip SEMUA user
        }

        // 5. Data untuk Tabel "Status Pengajuan Terbaru" (5 data)
        $data['latest_pengajuan_dashboard'] = $this->User_model->get_dashboard_latest_pengajuan($user_id);

        $this->_load_notification_data($data); // Muat data notifikasi untuk header

        $data['content_view'] = 'user/dashboard';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    // Fungsi-fungsi lain di controller ini tidak perlu diubah
    public function lembar_pengajuan() {
        $data = [];
        $data['title'] = 'Lembar Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/lembar_pengajuan';
        $this->_load_notification_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function status_pengajuan() {
        $data = [];
        $data['title'] = 'Status Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/status_pengajuan';
        $this->_load_notification_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function surat_masuk() {
        $data = [];
        $data['title'] = 'Surat Masuk';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/surat_masuk';
        $this->_load_notification_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function riwayat_pengajuan() {
        $data = [];
        $data['title'] = 'Riwayat Pengajuan';
        $data['user_name'] = $this->session->userdata('name');
        $user_id = $this->session->userdata('id_user');
        $data['riwayat_data'] = $this->User_model->get_riwayat_pengajuan($user_id);
        $this->_load_notification_data($data);
        $data['content_view'] = 'user/riwayat_pengajuan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function detail_pengajuan($id_pengajuan = null) {
        if ($id_pengajuan === null) {
            $this->session->set_flashdata('error', 'ID Pengajuan tidak ditemukan.');
            redirect('user/riwayat_pengajuan');
        }

        $data = [];
        $data['title'] = 'Detail Pengajuan';
        $data['user_name'] = $this->session->userdata('name');

        $pengajuan_detail = $this->User_model->get_detail_pengajuan($id_pengajuan);

        $current_user_id = $this->session->userdata('id_user');
        if (!$pengajuan_detail || $pengajuan_detail->id_user != $current_user_id) {
            $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan atau Anda tidak memiliki akses.');
            redirect('user/riwayat_pengajuan');
        }

        $data['row'] = $pengajuan_detail;

        $this->_load_notification_data($data);

        $data['content_view'] = 'user/detail_pengajuan';
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
        $this->_load_notification_data($data);
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
        $this->_load_notification_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }
}