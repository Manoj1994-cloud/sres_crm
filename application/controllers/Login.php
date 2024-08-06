<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->model('Login_mod');
    }

    public function index()
    {
        /*$this->load->library('encryption');
        $key = $this->encryption->create_key(16);
        $key = bin2hex($this->encryption->create_key(16));
        echo $key; die();*/
        $this->load->view('crm/pages-login');
    }

    public function admin_login()
    {
        $response = array('success' => FALSE, 'message' => 'Invalid request');
    
        // Remove AJAX request check
        $this->load->model('Login_mod');
        $postData = $this->input->post();
        $data = $this->Login_mod->login_admin($postData);
    
        if ($data !== FALSE) {
            $response['success'] = TRUE;
            $response['message'] = 'Login successful!';
            $this->session->set_userdata('login_user', $data);
            // Redirect to a different page or set a success message
            redirect('Admin'); // Adjust the redirect path as needed
        } else {
            $response['message'] = 'Username and password are incorrect';
            // You can set the response to be rendered in a view
            $this->load->view('crm/pages-login', $response); // Adjust the view path as needed
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

    public function logout()
    {
        $this->session->unset_userdata('login_user');	
        redirect('Login');
    }
}
?>
