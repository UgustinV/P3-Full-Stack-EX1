<?php
require_once 'command.php';

$command = new Command();
while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === "list") {
        $command->list();
    }
}