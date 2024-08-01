<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->view('crm/header');
        $this->load->view('crm/index');
        $this->load->view('crm/footer');
	}
}
