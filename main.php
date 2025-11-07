<?php
require_once 'db_connect.php';

$db = new DBConnect('localhost', 'p3-ex1');
var_dump($db);

while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === "list") {
        echo "Affichage de la liste";
    }
}