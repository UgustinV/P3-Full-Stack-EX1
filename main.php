<?php
require_once 'db_connect.php';

$db = DBConnect::getPDO('localhost', 'p3-ex1', 'root', '');

while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === "list") {
        echo "Affichage de la liste";
    }
}