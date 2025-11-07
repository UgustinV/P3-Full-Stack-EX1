<?php
require_once 'contact_manager.php';
require_once 'db_connect.php';

class Command {
    private $db;
    private $contactManager;

    public function __construct() {
        $this->db = DBConnect::getPDO('localhost', 'p3-ex1', 'root', '');
        $this->contactManager = new ContactManager($this->db);
    }

    public function list() {
        $contact_list = $this->contactManager->findAll();
        if (empty($contact_list)) {
            echo "No contacts found.\n";
        }
        foreach ($contact_list as $contact) {
            echo $contact->__toString() . "\n";
        }
    }

    public function detail($id) {
        $contact = $this->contactManager->findById($id);
        if ($contact) {
            echo $contact->__toString() . "\n";
        }
        else {
            echo "Contact with ID $id not found.\n";
        }
    }

    public function create($name, $email, $phone) {
        $contact = $this->contactManager->create($name, $email, $phone);
        if ($contact) {
            echo "Contact created: " . $contact->__toString() . "\n";
        }
        else {
            echo "Failed to create contact.\n";
        }
    }

    public function delete($id) {
        $success = $this->contactManager->delete($id);
        if ($success) {
            echo "Contact with ID $id deleted successfully.\n";
        } else {
            echo "Failed to delete contact with ID $id.\n";
        }
    }

    public function update($id, $name, $email, $phone) {
        $contact = $this->contactManager->update($id, $name, $email, $phone);
        if ($contact) {
            echo "Contact with ID $id updated successfully.\n";
        } else {
            echo "Failed to update contact with ID $id.\n";
        }
    }
}