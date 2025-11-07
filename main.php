<?php
require_once 'db_connect.php';
require_once 'contact_manager.php';

$db = DBConnect::getPDO('localhost', 'p3-ex1', 'root', '');
while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === "list") {
        $contactManager = new ContactManager($db);
        $contact_list = $contactManager->findAll();
        foreach ($contact_list as $contact) {
            echo $contact->__toString() . "\n";
        }
    }
}