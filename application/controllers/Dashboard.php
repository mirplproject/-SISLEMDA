<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Surat_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $user_role = $this->session->userdata('role');
        $user_id = $this->session->userdata('id');
        $user_name = $this->session->userdata('nama') ?: 'Pengguna';

        // Ambil role_id dari user_roles
        $this->db->select('role_id');
        $this->db->from('user_roles');
        $this->db->where('user_id', $user_id);
        $role = $this->db->get()->row();
        $role_id = $role ? $role->role_id : 0;

        // Data umum
        $data['total_surat'] = $this->Surat_model->get_total_surat($user_id);
        $data['surat_pending'] = $this->Surat_model->get_pending_by_user($user_id, $role_id);
        $data['surat_approved'] = $this->Surat_model->get_approved_by_user($user_id, $role_id);
        $data['notifications'] = $this->Surat_model->get_notifications($role_id, $user_id);

        // Logika peran
        if ($user_role == 'dosen') {
            $data['surat_history'] = $this->Surat_model->get_surat_history($user_id);
            $data['content_view'] = 'dashboard/dosen';
        } elseif (in_array($user_role, ['kaprodi', 'dekan'])) {
            $data['surat_to_approve'] = $this->Surat_model->get_surat_to_approve($role_id, $user_id);
            $data['surat_masuk'] = $this->Surat_model->get_surat_masuk($role_id, $user_id);
            $data['surat_history'] = $this->Surat_model->get_surat_history($user_id);
            $data['content_view'] = 'dashboard/dosen_menjabat';
        } elseif (in_array($user_role, ['warek1', 'warek2'])) {
            $data['surat_fakultas'] = $this->Surat_model->get_surat_by_fakultas();
            $data['surat_masuk'] = $this->Surat_model->get_surat_masuk($role_id, $user_id);
            $data['surat_history'] = $this->Surat_model->get_surat_history($user_id);
            $data['content_view'] = 'dashboard/warek';
        } elseif ($user_role == 'yayasan') {
            $data['surat_masuk'] = $this->Surat_model->get_surat_masuk($role_id, $user_id);
            $data['kpi_completion'] = $this->Surat_model->get_kpi_completion();
            $data['content_view'] = 'dashboard/yayasan';
        } elseif ($user_role == 'keuangan') {
            $data['pengajuan_dana'] = $this->Surat_model->get_pengajuan_dana();
            $data['content_view'] = 'dashboard/keuangan';
        } elseif ($user_role == 'admin') {
            $this->load->model('User_model');
            // Hitung jumlah pengguna berdasarkan jabatan
            $jabatanList = ['admin', 'dosen', 'kaprodi', 'dekan', 'warek1', 'warek2', 'rektor'];
            $user_counts = [];
            foreach ($jabatanList as $jabatan) {
                $this->db->select('COUNT(*) as total');
                $this->db->from('users');
                $this->db->join('user_roles', 'user_roles.user_id = users.id');
                $this->db->join('roles', 'user_roles.role_id = roles.id');
                $this->db->where('roles.name', $jabatan);
                $result = $this->db->get()->row();
                $user_counts[$jabatan] = $result->total;
            }
            $data['user_counts'] = $user_counts;
            $data['content_view'] = 'admin/admin'; // Gunakan admin.php sebagai dashboard utama
        }
        $data['user_name'] = $user_name;
        $data['user_role'] = $user_role;

        // Muat header, sidebar, dan footer
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function manage() {
        $data['title'] = 'Kelola Pengguna';
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
        $data['content_view'] = 'admin/manage_user';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function add() {
        $data['title'] = 'Tambah Pengguna';
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');
        $this->db->select('id, name');
        $data['roles'] = $this->db->get('roles')->result();
        $data['content_view'] = 'admin/add_user';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);

        if ($this->input->post()) {
            $user_data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('users', $user_data);
            $user_id = $this->db->insert_id();
            $role_id = $this->input->post('role_id');
            $this->db->insert('user_roles', array('user_id' => $user_id, 'role_id' => $role_id));
            redirect('dashboard/manage');
        }
    }
}