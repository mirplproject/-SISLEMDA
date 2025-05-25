<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('admin_m');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('active_role') != 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data = [];
        $data['title'] = 'Admin Dashboard';
        $data['user_name'] = $this->session->userdata('name');
        $data['users'] = $this->admin_m->get_all_users_with_roles();
        $data['total_users'] = $this->admin_m->get_total_users();
        $data['total_prodis'] = count($this->admin_m->get_all_prodis());
        $data['total_fakultas'] = count($this->admin_m->get_all_fakultas());
        $data['content_view'] = 'admin/index';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function manage_prodi() {
        $data = [];
        $data['title'] = 'Kelola Prodi';
        $data['user_name'] = $this->session->userdata('name');
        $data['prodis'] = $this->admin_m->get_all_prodis();
        $data['fakultas'] = $this->admin_m->get_all_fakultas();
        $data['content_view'] = 'admin/manage_prodi';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function add_prodi() {
        $data = [];
        $data['title'] = 'Tambah Prodi';
        $data['user_name'] = $this->session->userdata('name');
        $data['fakultas'] = $this->admin_m->get_all_fakultas();

        if ($this->input->post()) {
            $data_prodi = [
                'nama_prodi' => $this->input->post('nama_prodi'),
                'id_fakultas' => $this->input->post('id_fakultas')
            ];
            $this->admin_m->add_prodi($data_prodi);
            $this->session->set_flashdata('success', 'Prodi berhasil ditambahkan');
            redirect('admin/manage_prodi');
        }

        $data['content_view'] = 'admin/add_prodi';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit_prodi($id_prodi) {
        $data = [];
        $data['title'] = 'Edit Prodi';
        $data['user_name'] = $this->session->userdata('name');
        $data['prodi'] = $this->admin_m->get_prodi_by_id($id_prodi);
        $data['fakultas'] = $this->admin_m->get_all_fakultas();

        if ($this->input->post()) {
            $data_prodi = [
                'nama_prodi' => $this->input->post('nama_prodi'),
                'id_fakultas' => $this->input->post('id_fakultas')
            ];
            $this->admin_m->update_prodi($id_prodi, $data_prodi);
            $this->session->set_flashdata('success', 'Prodi berhasil diperbarui');
            redirect('admin/manage_prodi');
        }

        $data['content_view'] = 'admin/edit_prodi';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function delete_prodi($id_prodi) {
        $this->admin_m->delete_prodi($id_prodi);
        $this->session->set_flashdata('success', 'Prodi berhasil dihapus');
        redirect('admin/manage_prodi');
    }

    public function manage_role_user() {
        $data = [];
        $data['title'] = 'Kelola Role User';
        $data['user_name'] = $this->session->userdata('name');
        $data['users'] = $this->admin_m->get_all_users_with_roles();
        $data['roles'] = $this->admin_m->get_all_roles();
        foreach ($data['users'] as &$user) {
            $user['role_details'] = $this->admin_m->get_user_roles($user['id_user']);
        }
        $data['content_view'] = 'admin/manage_role_user';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function assign_role($user_id) {
        $data = [];
        $data['title'] = 'Tambah Role';
        $data['user_name'] = $this->session->userdata('name');
        $data['user'] = $this->admin_m->get_user_by_id($user_id);
        $data['roles'] = $this->admin_m->get_all_roles();
        $data['user_roles'] = $this->admin_m->get_user_roles($user_id);

        if ($this->input->post()) {
            $role_id = $this->input->post('role_id');
            // Cek apakah role sudah ada untuk user ini
            $existing_roles = array_column($data['user_roles'], 'id_role');
            if (!in_array($role_id, $existing_roles)) {
                $this->admin_m->add_role_to_user($user_id, $role_id);
                $this->session->set_flashdata('success', 'Role berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Role sudah dimiliki oleh user');
            }
            redirect('admin/manage_role_user');
        }

        $data['content_view'] = 'admin/assign_role';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function remove_role($user_id, $role_id) {
    $this->db->where('id_user', $user_id);
    $this->db->where('id_role', $role_id);
    $this->db->delete('user_role');
    $affected_rows = $this->db->affected_rows();

    if ($affected_rows >= 0) { // Jika 0 berarti data sudah tidak ada, dianggap berhasil
        $this->session->set_flashdata('success', 'Role berhasil dihapus');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus role');
    }
    redirect('admin/manage_role_user');
}

    public function manage_user() {
        $data = [];
        $data['title'] = 'Kelola Pengguna';
        $data['user_name'] = $this->session->userdata('name');
        $data['users'] = $this->admin_m->get_all_users_with_roles();
        $data['roles'] = $this->admin_m->get_all_roles();
        $data['prodis'] = $this->admin_m->get_all_prodis();
        $data['fakultas'] = $this->admin_m->get_all_fakultas();
        $data['content_view'] = 'admin/manage_user';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function add_user() {
        $data = [];
        $data['title'] = 'Tambah Pengguna';
        $data['user_name'] = $this->session->userdata('name');
        $data['roles'] = $this->admin_m->get_all_roles();
        $data['prodis'] = $this->admin_m->get_all_prodis();
        $data['fakultas'] = $this->admin_m->get_all_fakultas();

        if ($this->input->post()) {
            $data_user = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => MD5($this->input->post('password')),
                'inisial' => $this->input->post('inisial'),
                'email' => $this->input->post('email'),
                'nik' => $this->input->post('nik')
            ];
            $user_id = $this->admin_m->add_user($data_user);
            $role_id = $this->input->post('role_id');
            $this->admin_m->add_role_to_user($user_id, $role_id);

            $role_name = $this->input->post('role_name');
            if ($role_name == 'dosen') {
                $this->admin_m->assign_dosen($user_id, $this->input->post('prodi_id'));
            } elseif ($role_name == 'kaprodi') {
                $this->admin_m->assign_kaprodi($user_id, $this->input->post('prodi_id'));
            } elseif ($role_name == 'dekan') {
                $this->admin_m->assign_dekan($user_id, $this->input->post('fakultas_id'));
            }

            $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan');
            redirect('admin/manage_user');
        }

        $data['content_view'] = 'admin/add_user';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit_user($user_id) {
        $data = [];
        $data['title'] = 'Edit Pengguna';
        $data['user_name'] = $this->session->userdata('name');
        $data['user'] = $this->admin_m->get_user_by_id($user_id);
        $data['roles'] = $this->admin_m->get_all_roles();
        $data['prodis'] = $this->admin_m->get_all_prodis();
        $data['fakultas'] = $this->admin_m->get_all_fakultas();

        if ($this->input->post()) {
            $data_user = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'inisial' => $this->input->post('inisial'),
                'email' => $this->input->post('email'),
                'nik' => $this->input->post('nik')
            ];
            if ($this->input->post('password')) {
                $data_user['password'] = MD5($this->input->post('password'));
            }
            $this->admin_m->update_user($user_id, $data_user);

            // Tambahkan role baru jika dipilih
            $role_id = $this->input->post('role_id');
            if ($role_id) {
                $existing_roles = array_column($this->admin_m->get_user_roles($user_id), 'id_role');
                if (!in_array($role_id, $existing_roles)) {
                    $this->admin_m->add_role_to_user($user_id, $role_id);
                } else {
                    $this->session->set_flashdata('warning', 'Role sudah dimiliki oleh user');
                }
            }

            $role_name = $this->input->post('role_name');
            if ($role_name == 'dosen') {
                $this->admin_m->assign_dosen($user_id, $this->input->post('prodi_id'));
            } elseif ($role_name == 'kaprodi') {
                $this->admin_m->assign_kaprodi($user_id, $this->input->post('prodi_id'));
            } elseif ($role_name == 'dekan') {
                $this->load->assign_dekan($user_id, $this->input->post('fakultas_id'));
            }

            $this->session->set_flashdata('success', 'Pengguna berhasil diperbarui');
            redirect('admin/manage_user');
        }

        $data['content_view'] = 'admin/edit_user';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function delete_user($user_id) {
        $this->admin_m->delete_user($user_id);
        $this->session->set_flashdata('success', 'Pengguna berhasil dihapus');
        redirect('admin/manage_user');
    }

    public function manage_klasifikasi_surat() {
        $data = [];
        $data['title'] = 'Kelola Klasifikasi Surat';
        $data['user_name'] = $this->session->userdata('name');
        $data['klasifikasi_surat'] = $this->admin_m->get_all_klasifikasi_surat();
        $data['content_view'] = 'admin/manage_klasifikasi_surat';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function add_klasifikasi_surat() {
        $data = [];
        $data['title'] = 'Tambah Klasifikasi Surat';
        $data['user_name'] = $this->session->userdata('name');

        if ($this->input->post()) {
            $data_klasifikasi = [
                'kode_surat' => $this->input->post('kode_surat'),
                'nama_surat' => $this->input->post('nama_surat')
            ];
            $this->admin_m->add_klasifikasi_surat($data_klasifikasi);
            $this->session->set_flashdata('success', 'Klasifikasi surat berhasil ditambahkan');
            redirect('admin/manage_klasifikasi_surat');
        }

        $data['content_view'] = 'admin/add_klasifikasi_surat';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit_klasifikasi_surat($id_klasifikasi_surat) {
        $data = [];
        $data['title'] = 'Edit Klasifikasi Surat';
        $data['user_name'] = $this->session->userdata('name');
        $data['klasifikasi'] = $this->admin_m->get_klasifikasi_surat_by_id($id_klasifikasi_surat);

        if ($this->input->post()) {
            $data_klasifikasi = [
                'kode_surat' => $this->input->post('kode_surat'),
                'nama_surat' => $this->input->post('nama_surat')
            ];
            $this->admin_m->update_klasifikasi_surat($id_klasifikasi_surat, $data_klasifikasi);
            $this->session->set_flashdata('success', 'Klasifikasi surat berhasil diperbarui');
            redirect('admin/manage_klasifikasi_surat');
        }

        $data['content_view'] = 'admin/edit_klasifikasi_surat';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function delete_klasifikasi_surat($id_klasifikasi_surat) {
        $this->admin_m->delete_klasifikasi_surat($id_klasifikasi_surat);
        $this->session->set_flashdata('success', 'Klasifikasi surat berhasil dihapus');
        redirect('admin/manage_klasifikasi_surat');
    }
}