<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database
    }

    // Fetch all contacts
    public function get_all_contacts() {
        $query = $this->db->get('contacts');
        return $query->result();
    }

    // Fetch a single contact by ID
    public function get_contact($id) {
        $query = $this->db->get_where('contacts', array('id' => $id));
        return $query->row();
    }

    // Insert a new contact
    public function insert_contact($data) {
        return $this->db->insert('contacts', $data);
    }

    // Delete a contact by ID
    public function delete_contact($id) {
        $this->db->where('id', $id);
        return $this->db->delete('contacts');
    }

    // Update an existing contact
    public function update_contact($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('contacts', $data);
    }
}
