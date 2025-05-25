<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('auth_m');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('user');
        }

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->auth_m->login($username, $password);
            
            if ($user) {
                $roles = $this->auth_m->get_user_roles($user['id_user']);
                
                $session_data = [
                    'user_id' => $user['id_user'],
                    'username' => $user['username'],
                    'name' => $user['nama'],
                    'roles' => array_column($roles, 'nama_role'),
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);

                if (count($roles) > 1) {
                    redirect('auth/choose_role');
                } else {
                    $this->session->set_userdata('active_role', $roles[0]['nama_role']);
                    if ($roles[0]['nama_role'] == 'admin') {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('auth/login');
            }
        }
        $this->load->view('auth/login');
    }

    public function choose_role() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $roles = $this->session->userdata('roles');
        if (count($roles) <= 1) {
            redirect('user');
        }

        if ($this->input->post('role')) {
            $selected_role = $this->input->post('role');
            if (in_array($selected_role, $roles)) {
                $this->session->set_userdata('active_role', $selected_role);
                if ($selected_role == 'admin') {
                    redirect('admin');
                } else {
                    redirect('user');
                }
            } else {
                $this->session->set_flashdata('error', 'Role tidak valid');
            }
        }

        $data = [];
        $data['title'] = 'Pilih Role';
        $data['roles'] = $roles;
        $this->load->view('auth/choose_role', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}