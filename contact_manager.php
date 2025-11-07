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

    public function findById($id) {
        $request = $this->db->prepare("SELECT * FROM contacts WHERE id = :id");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        $contact = $request->fetch();
        if ($contact) {
            $contact = new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number']);
        }
        return $contact;
    }
}