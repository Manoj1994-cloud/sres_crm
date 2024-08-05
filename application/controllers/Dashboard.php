<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    var $globaldata;
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper("url");
           $var=$this->session->userdata;
			//print_r($this->session->userdata); die();
           if(isset($var['login']))
           {
			  $this->globaldata=array(
				'userdata'=>$var['login']
			  );
		   }
    }
	public function home()
	{
		$this->load->view('crm/header');
        $this->load->view('crm/pages-index');
        $this->load->view('crm/footer');
	}
}
