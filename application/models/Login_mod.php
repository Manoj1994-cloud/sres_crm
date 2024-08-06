<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_mod extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login_admin($str)
    {    
        print_r($str);
        die;
        // Ensure credentials array has the required keys
        if (!isset($str['username']) || !isset($str['password'])) {
            return FALSE;
        }
    
        $this->db->where('username', $str['username']);
        $query = $this->db->get('users');
    
        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Check if the password matches
            if (password_verify($str['password'], $user->password)) {
                return $user;
            }
        }
        return FALSE;
    }
    
    public function create_user($data)
    {
        if (isset($data['username']) && isset($data['password']) && isset($data['email'])) {
            return $this->db->insert('users', $data);
        }
        return FALSE;
    }
}
?>
