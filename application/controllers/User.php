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
            if ($role['nama_role'] == $active_role) {
                $is_valid = true;
                break;
            }
        }
        if (!$is_valid) {
            redirect('auth/login');
        }
    }

    // Helper untuk memuat data notifikasi ke $data array
    private function _load_notification_data(&$data) {
        $user_id = $this->session->userdata('id_user');
        $data['notifications'] = [];
        $data['is_new_notification'] = false; // Flag untuk ikon merah

        if ($user_id) {
            $latest_pengajuan = $this->User_model->get_latest_pengajuan($user_id, 3);
            $data['notifications'] = $latest_pengajuan;

            // Dapatkan ID pengajuan terakhir yang dilihat dari sesi
            $last_seen_id = $this->session->userdata('last_seen_pengajuan_id');

            // Cek apakah ada notifikasi baru
            if (!empty($latest_pengajuan)) {
                $most_recent_id = $latest_pengajuan[0]['id_pengajuan']; // ID pengajuan paling baru dari 3 data
                if ($last_seen_id === null || $most_recent_id > $last_seen_id) {
                    $data['is_new_notification'] = true;
                }
            }
            // Untuk badge count, kita bisa tampilkan 3+ jika lebih dari 3 data
            // Atau jika ingin badge menunjukkan 'new' atau 'baru', bisa disesuaikan
            // Untuk permintaan ini, kita hanya butuh flag is_new_notification untuk warna ikon bel.
            $data['notification_count_display'] = !empty($latest_pengajuan) ? count($latest_pengajuan) : 0;
        }
    }

    // --- FUNGSI BARU: Untuk menandai notifikasi sudah dilihat ---
    public function mark_notifications_as_read() {
        // Pastikan ini adalah request AJAX
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('id_user');
            if ($user_id) {
                // Dapatkan ID pengajuan terbaru dari database
                $latest_pengajuan = $this->User_model->get_latest_pengajuan($user_id, 1); // Ambil 1 yang paling baru saja

                if (!empty($latest_pengajuan)) {
                    $most_recent_id = $latest_pengajuan[0]['id_pengajuan'];
                    // Simpan ID pengajuan terbaru ke sesi user
                    $this->session->set_userdata('last_seen_pengajuan_id', $most_recent_id);
                }
            }
            echo json_encode(['status' => 'success']); // Beri respons ke AJAX
        } else {
            show_404(); // Jika bukan request AJAX, tampilkan 404
        }
    }

    // --- Fungsi-fungsi lain tetap sama, hanya memanggil _load_notification_data ---
    public function dashboard() {
        $data = [];
        $data['title'] = 'Dashboard User';
        $data['user_name'] = $this->session->userdata('name');
        $data['content_view'] = 'user/dashboard';
        $this->_load_notification_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

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

    // Helper untuk warna badge status (biarkan tetap di helper 'notification_helper.php')
    // private function _get_status_badge_color($status) { ... } // Hapus ini karena sudah di helper

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