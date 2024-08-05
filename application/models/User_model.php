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
    public function check_user($username, $password) {
        // Fetch the user record based on the provided username
        $this->db->where('username', $username);
        $query = $this->db->get('users'); // Replace 'users' with your actual users table name
        
        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Verify the password using the password_verify function
            if (password_verify($password, $user->password)) { // Assumes passwords are hashed
                return $user; // Return the user object on success
            }
        }

        return false; // Return false if authentication fails
    }
}
?>
