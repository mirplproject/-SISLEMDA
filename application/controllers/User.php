<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $active_role = $this->session->userdata('active_role');
        if ($active_role == 'admin') {
            redirect('admin');
        } else {
            $data['title'] = ucfirst($active_role) . ' Dashboard';
            $data['user_name'] = $this->session->userdata('name');
            $data['content_view'] = 'user/index';
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/footer', $data);
        }
    }
}