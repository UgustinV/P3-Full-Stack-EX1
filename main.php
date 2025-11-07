<?php
require_once 'db_connect.php';
require_once 'contact_manager.php';

$db = DBConnect::getPDO('localhost', 'p3-ex1', 'root', '');
$contactManager = new ContactManager($db);
$contact_list = $contactManager->findAll();
var_dump($contact_list);
while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === "list") {
        echo "Affichage de la liste";
    }
}