<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function login() {
        $this->load->view('template/head');
        $this->load->view('Login/login');
        $this->load->view('template/footer');
    }

    public function loading() {
        $this->load->view('template/head');
        $this->load->view('Login/loading');
        $this->load->view('template/footer');
    }

    public function pilih_role() {
        $this->load->view('template/head');
        $this->load->view('Login/Pilih_role');
        $this->load->view('template/footer');
    }
    public function lupa_pw() {
        $this->load->view('template/head');
        $this->load->view('Login/lupa_pw');
        $this->load->view('template/footer');
    }
}
