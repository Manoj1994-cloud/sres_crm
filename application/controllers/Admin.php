<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	var $globaldata;
    function __construct()
    {
        parent::__construct();         
        $var=$this->session->userdata;
        if(isset($var['login_user']))
        {
			$this->globaldata=array(
				'userdata'=>$var['login_user']
			);
		}
    }

    public function index()
    {
        $session_data = $this->session->userdata('msg');
		$data1['message']=$session_data;
		$this->session->unset_userdata('msg');
        // $data['user'] = $this->globaldata['userdata'];
        $this->load->view('crm/header');
        $this->load->view('crm/pages-index');
        $this->load->view('crm/footer');
    }
}
?>
