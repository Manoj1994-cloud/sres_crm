<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    var $globaldata;
	function __construct()
     {
           parent::__construct();
			$this->load->helper("url");
           $var=$this->session->userdata;
			//print_r($this->session->userdata); die();
           if(isset($var['login_user']))
           {
			  $this->globaldata=array(
				'userdata'=>$var['login_user']
			  );
		   }
     }

    public function index()
    {
        // $data['user'] = $this->globaldata['userdata'];
        $this->load->view('crm/header');
        $this->load->view('crm/pages-index');
        $this->load->view('crm/footer');
    }
}
?>
