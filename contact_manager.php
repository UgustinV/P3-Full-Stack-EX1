<?php
require_once 'contact.php';
class ContactManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $contact_list = [];
        $request = $this->db->prepare("SELECT * FROM contacts");
        $request->execute();
        $contacts = $request->fetchAll();
        foreach ($contacts as $contact) {
            $contact = new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number']);
            $contact_list[] = $contact;
        }
        return $contact_list;
    }
}