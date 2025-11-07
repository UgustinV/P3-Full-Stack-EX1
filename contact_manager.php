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

    public function create($name, $email, $phone_number) {
        $request = $this->db->prepare("INSERT INTO contacts (name, email, phone_number) VALUES (:name, :email, :phone_number)");
        $success = $request->execute([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number
        ]);
        if ($success) {
            return $this->findById($this->db->lastInsertId());
        } else {
            return null;
        }
    }

    public function delete($id) {
        $request = $this->db->prepare('DELETE FROM contacts WHERE id = :id');
        $success = $request->execute(['id' => $id]);
        return $success;
    }
}