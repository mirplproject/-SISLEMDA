<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('admin_m');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('active_role') != 'Admin') {
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
        $data['prodis'] = $this->admin_m->get_all_prodis();
        $data['fakultas'] = $this->admin_m->get_all_fakultas();
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
    $this->load->library('pagination');

    // Konfigurasi pagination
    $config['base_url'] = site_url('admin/manage_role_user');
    $config['total_rows'] = $this->admin_m->count_all_users_with_roles(); // Total data user
    $config['per_page'] = 10; // Jumlah data per halaman
    $config['uri_segment'] = 3; // Segment URL untuk nomor halaman
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = 'Pertama';
    $config['last_link'] = 'Terakhir';
    $config['next_link'] = 'Selanjutnya';
    $config['prev_link'] = 'Sebelumnya';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    // Ambil data untuk pencarian
    $search = $this->input->get('search');
    if ($search) {
        $data['users'] = $this->admin_m->search_users_with_roles($search, $config['per_page'], $page);
        $config['total_rows'] = $this->admin_m->count_search_users_with_roles($search);
        $this->pagination->initialize($config);
    } else {
        $data['users'] = $this->admin_m->get_all_users_with_roles_paginated($config['per_page'], $page);
    }

    $data['pagination'] = $this->pagination->create_links();
    $data['title'] = 'Kelola Role User';
    $data['user_name'] = $this->session->userdata('name');
    $data['roles'] = $this->admin_m->get_all_roles();
    foreach ($data['users'] as &$user) {
        $user['role_details'] = $this->admin_m->get_user_roles($user['id_user']);
    }
    $data['search'] = $search;
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

        if ($affected_rows >= 0) {
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
            log_message('debug', 'Data POST: ' . print_r($this->input->post(), true));

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

            $this->db->select('nama_role');
            $this->db->from('role');
            $this->db->where('id_role', $role_id);
            $role = $this->db->get()->row_array();
            $role_name = $role['nama_role'];

            $prodi_id = $this->input->post('prodi_id') ?: null;
            $fakultas_id = $this->input->post('fakultas_id') ?: null;

            log_message('debug', 'Role: ' . $role_name . ', Prodi ID: ' . $prodi_id . ', Fakultas ID: ' . $fakultas_id);

            if ($role_name == 'Dosen' && $fakultas_id) {
                $this->admin_m->assign_dosen($user_id, $fakultas_id);
            } elseif ($role_name == 'Kaprodi' && $prodi_id) {
                $this->admin_m->assign_kaprodi($user_id, $prodi_id);
            } elseif ($role_name == 'Dekan' && $fakultas_id) {
                $this->admin_m->assign_dekan($user_id, $fakultas_id);
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
        $data['user'] = $this->admin_m->get_user_by_id_with_prodi_fakultas($user_id);
        $data['roles'] = $this->admin_m->get_all_roles();
        $data['prodis'] = $this->admin_m->get_all_prodis();
        $data['fakultas'] = $this->admin_m->get_all_fakultas();

        if ($this->input->post()) {
            log_message('debug', 'Data POST (Edit): ' . print_r($this->input->post(), true));

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

            $role_id = $this->input->post('role_id');
            if ($role_id) {
                $existing_roles = array_column($this->admin_m->get_user_roles($user_id), 'id_role');
                if (!in_array($role_id, $existing_roles)) {
                    $this->admin_m->add_role_to_user($user_id, $role_id);
                }
            }

            $this->db->select('nama_role');
            $this->db->from('role');
            $this->db->where('id_role', $role_id);
            $role = $this->db->get()->row_array();
            $role_name = $role['nama_role'];

            $prodi_id = $this->input->post('prodi_id') ?: null;
            $fakultas_id = $this->input->post('fakultas_id') ?: null;

            log_message('debug', 'Role (Edit): ' . $role_name . ', Prodi ID: ' . $prodi_id . ', Fakultas ID: ' . $fakultas_id);

            if ($role_name == 'Dosen' && $fakultas_id) {
                $this->admin_m->assign_dosen($user_id, $fakultas_id);
            } elseif ($role_name == 'Kaprodi' && $prodi_id) {
                $this->admin_m->assign_kaprodi($user_id, $prodi_id);
            } elseif ($role_name == 'Dekan' && $fakultas_id) {
                $this->admin_m->assign_dekan($user_id, $fakultas_id);
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

    // Load library pagination
    $this->load->library('pagination');

    // Konfigurasi pagination
    $config['base_url'] = site_url('admin/manage_klasifikasi_surat');
    $config['total_rows'] = $this->admin_m->count_klasifikasi_surat(); // Total data tanpa filter
    $config['per_page'] = 10; // Jumlah data per halaman
    $config['uri_segment'] = 3; // Segment URI untuk offset
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = 'Pertama';
    $config['last_link'] = 'Terakhir';
    $config['next_link'] = 'Selanjutnya';
    $config['prev_link'] = 'Sebelumnya';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    $this->pagination->initialize($config);

    // Ambil offset untuk pagination
    $offset = $this->uri->segment(3) ? $this->uri->segment(3) : 0;

    // Ambil parameter pencarian
    $search = $this->input->get('search');

    // Simpan search ke data untuk digunakan di view
    $data['search'] = $search;

    // Ambil data klasifikasi surat dengan limit, offset, dan filter pencarian
    $data['klasifikasi_surat'] = $this->admin_m->get_klasifikasi_surat($config['per_page'], $offset, $search);

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

    public function add_role() {
        $data = [];
        $data['title'] = 'Tambah Role Baru';
        $data['user_name'] = $this->session->userdata('name');
        $data['roles'] = $this->admin_m->get_all_roles();

        if ($this->input->post()) {
            $role_name = $this->input->post('nama_role');
            $existing_role = $this->admin_m->get_role_by_name($role_name);

            if (!$existing_role) {
                $data_role = ['nama_role' => $role_name];
                $this->admin_m->add_role($data_role);
                $this->session->set_flashdata('success', 'Role baru berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Role sudah ada');
            }
            redirect('admin/add_role');
        }

        $data['content_view'] = 'admin/add_role';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit_role($id_role) {
        $data = [];
        $data['title'] = 'Edit Role';
        $data['user_name'] = $this->session->userdata('name');
        $data['role'] = $this->admin_m->get_role_by_id($id_role);

        if (!$data['role']) {
            $this->session->set_flashdata('error', 'Role tidak ditemukan');
            redirect('admin/manage_role_user');
        }

        if ($this->input->post()) {
            $role_name = $this->input->post('nama_role');
            $existing_role = $this->admin_m->get_role_by_name($role_name);

            if ($existing_role && $existing_role['id_role'] != $id_role) {
                $this->session->set_flashdata('error', 'Nama role sudah ada');
            } else {
                $data_role = ['nama_role' => $role_name];
                $this->admin_m->update_role($id_role, $data_role);
                $this->session->set_flashdata('success', 'Role berhasil diperbarui');
                redirect('admin/manage_role_user');
            }
        }

        $data['content_view'] = 'admin/edit_role';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/footer', $data);
    }

    public function delete_role($id_role) {
        // Cek apakah role sedang digunakan oleh user
        $this->db->where('id_role', $id_role);
        $this->db->from('user_role');
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->session->set_flashdata('error', 'Role tidak dapat dihapus karena sedang digunakan oleh user');
        } else {
            $this->admin_m->delete_role($id_role);
            $this->session->set_flashdata('success', 'Role berhasil dihapus');
        }
        redirect('admin/manage_role_user');
    }
}