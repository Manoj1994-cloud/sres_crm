<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ContactModel'); // Load the Contact model
        $this->load->helper('url'); // Load URL helper for base_url
    }

    // Load the contact page view
    public function index() {
        $this->load->view('crm/header');
        $this->load->view('crm/pages-contact');
        $this->load->view('crm/footer');
    }

    // Method to fetch all contacts
    public function getContacts() {
        $contacts = $this->ContactModel->get_all_contacts();
        echo json_encode($contacts);
    }

    // Method to get a specific contact
    public function getContact($id) {
        $contact = $this->ContactModel->get_contact($id);
        if ($contact) {
            echo json_encode(['success' => true, 'contact' => $contact]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contact not found']);
        }
    }

    // Method to add a new contact
    public function addContact() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors()) // Clean up validation errors
            ]);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message')
            );

            $insert = $this->ContactModel->insert_contact($data);
            if ($insert) {
                echo json_encode(['success' => true, 'message' => 'Contact added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add contact. Please try again later.']);
            }
        }
    }

    // Method to delete a contact
    public function deleteContact($id) {
        if ($this->ContactModel->get_contact($id)) {
            $delete = $this->ContactModel->delete_contact($id);
            if ($delete) {
                echo json_encode(['success' => true, 'message' => 'Contact deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete contact. Please try again later.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Contact not found.']);
        }
    }

    // Method to update a contact
    public function updateContact() {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'message' => strip_tags(validation_errors()) // Clean up validation errors
            ]);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message')
            );

            $update = $this->ContactModel->update_contact($id, $data);
            if ($update) {
                echo json_encode(['success' => true, 'message' => 'Contact updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update contact. Please try again later.']);
            }
        }
    }
}
