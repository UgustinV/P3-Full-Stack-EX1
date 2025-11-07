<?php
class ContactManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $request = $this->db->prepare("SELECT * FROM contacts");
        $request->execute();
        $contacts = $request->fetchAll();
        return $contacts;
    }
}