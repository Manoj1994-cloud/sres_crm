<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        //phpinfo();
        //die;
        // Load the login view
        $this->load->view('crm/pages-login');
    }

    public function register()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            // Set validation rules
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
            
            if ($this->form_validation->run() === FALSE) {
                $response = array(
                    'success' => FALSE,
                    'message' => validation_errors()
                );
            } else {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

                $data = array(
                    'name' => $name,
                    'username' => $username,
                    'password' => $password,
                    'email' => $email
                );

                if ($this->User_model->create_user($data)) {
                    $response = array(
                        'success' => TRUE,
                        'message' => 'User registered successfully.'
                    );
                } else {
                    $response = array(
                        'success' => FALSE,
                        'message' => 'There was a problem registering the user.'
                    );
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

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'success' => FALSE,
                'message' => validation_errors()
            );
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->check_user($username, $password);

            if ($user) {
                $this->session->set_userdata('id', $user->id);
                $this->session->set_userdata('username', $user->username);
                
                if ($this->input->is_ajax_request()) {
                    $response = array(
                        'success' => TRUE,
                        'message' => 'Login successful.'
                    );
                    echo json_encode($response);
                } else {
                    redirect('Dashboard/home');
                }
            } else {
                $response = array(
                    'success' => FALSE,
                    'message' => 'Invalid username or password.'
                );

                if ($this->input->is_ajax_request()) {
                    echo json_encode($response);
                } else {
                    $this->session->set_flashdata('error', $response['message']);
                    redirect('login');
                }
            }
        }

        if (!$this->input->is_ajax_request()) {
            echo json_encode($response);
        }
    }
}
?>
