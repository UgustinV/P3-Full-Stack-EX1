<?php
require_once 'contact_manager.php';
require_once 'db_connect.php';

class Command {
    private $db;

    public function __construct() {
        $this->db = DBConnect::getPDO('localhost', 'p3-ex1', 'root', '');
    }

    public function list() {
        $contactManager = new ContactManager($this->db);
        $contact_list = $contactManager->findAll();
        foreach ($contact_list as $contact) {
            echo $contact->__toString() . "\n";
        }
    }
}