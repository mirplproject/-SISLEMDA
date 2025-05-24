<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load any required models, libraries, or helpers here
        $this->load->helper('url');
    }
	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('template/sidebar');		
        $this->load->view('template/content');
		$this->load->view('template/footer');
	}
}
