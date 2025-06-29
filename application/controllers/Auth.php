<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('admin_m');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('active_role');
            if ($role == 'Admin') {
                redirect('admin');
            } else {
                redirect('user/dashboard');
            }
        }

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->db->where('username', $username);
            $query = $this->db->get('user');
            $user = $query->row_array();

            if ($user) {
                $hashed_password = md5($password);
                if ($hashed_password == $user['password']) {
                    $this->session->set_userdata([
                        'logged_in' => true,
                        'id_user' => $user['id_user'],
                        'username' => $user['username'],
                        'name' => $user['nama'],
                    ]);

                    $roles = $this->admin_m->get_user_roles($user['id_user']);
                    if (empty($roles)) {
                        $this->session->set_flashdata('error', 'User tidak memiliki role!');
                        redirect('auth/login');
                    } elseif (count($roles) > 1) {
                        $data['roles'] = $roles;
                        $this->load->view('auth/choose_role', $data);
                    } else {
                        $this->session->set_userdata('active_role', $roles[0]['nama_role']);
                        if ($roles[0]['nama_role'] == 'Admin') {
                            redirect('admin');
                        } else {
                            redirect('user/dashboard');
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', 'Username atau password salah!');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Username tidak ditemukan!');
                redirect('auth/login');
            }
        } else {
            $this->load->view('auth/login');
        }
    }

    public function choose_role() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $role = $this->input->post('role');
        if ($role) {
            $user_id = $this->session->userdata('id_user');
            $roles = $this->admin_m->get_user_roles($user_id);
            $role_exists = false;
            foreach ($roles as $r) {
                if ($r['nama_role'] == $role) {
                    $role_exists = true;
                    break;
                }
            }

            if ($role_exists) {
                $this->session->set_userdata('active_role', $role);
                if ($role == 'Admin') {
                    redirect('admin');
                } else {
                    redirect('user/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Role tidak valid untuk user ini!');
                $data['roles'] = $roles;
                $this->load->view('auth/choose_role', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Silakan pilih role terlebih dahulu!');
            $user_id = $this->session->userdata('id_user');
            $data['roles'] = $this->admin_m->get_user_roles($user_id);
            $this->load->view('auth/choose_role', $data);
        }
    }

    public function logout() {
        $this->session->unset_userdata(['logged_in', 'id_user', 'username', 'name', 'active_role']);
        $this->session->set_flashdata('success', 'Anda telah logout.');
        redirect('auth/login');
    }
}