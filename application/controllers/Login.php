<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {  

	public function USerLogin()
	{
		$data=array();
		$this->load->Model('Login_mod');
		$data = $this->Login_mod->CheckLogin($_POST);
        print_r($data);
        die;
		if($data!=null)
		{
			$this->session->set_userdata('login_user',$data[0]);
			$data1['message']="Success";
			print_r(json_encode($data1));
		}
		else
		{
			$data1['message']="Error";
			print_r(json_encode($data1));
		}
	}

    public function register()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
            
            if ($this->form_validation->run() === FALSE) {
                $response = [
                    'success' => FALSE,
                    'message' => validation_errors()
                ];
            } else {
                $data = [
                    'name' => $this->input->post('name'),
                    'username' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'email' => $this->input->post('email')
                ];

                if ($this->Login_mod->create_user($data)) {
                    $response = [
                        'success' => TRUE,
                        'message' => 'User registered successfully.'
                    ];
                } else {
                    $response = [
                        'success' => FALSE,
                        'message' => 'There was a problem registering the user.'
                    ];
                    log_message('error', 'Error registering user: ' . $this->db->error()['message']);
                }
            }

            if ($this->input->is_ajax_request()) {
                echo json_encode($response);
            } else {
                $this->session->set_flashdata('error', $response['message']);
                redirect('Login/register');
            }
        } else {
            $this->load->view('crm/pages-register');
        }
    }

    public function Logout()
	{
		$this->session->unset_userdata('login_user');	
		redirect('Login');
	}
}
?>
