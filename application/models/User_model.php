<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Function to create a new user
    public function create_user($data)
    {
        // Check if the data array contains the required fields
        if (isset($data['username']) && isset($data['password']) && isset($data['email'])) {
            return $this->db->insert('users', $data);
        }
        return FALSE;
    }
    public function check_user($username, $password)
    {
        // Fetch user data from the database
        $this->db->where('username', $username);
        $query = $this->db->get('users'); // Change this to your actual table name

        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Verify password
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        
        return FALSE; // Return FALSE if credentials are invalid
    }
}
?>
