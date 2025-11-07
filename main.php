<?php
require_once 'command.php';

$command = new Command();
while (true) {
    $line = readline("Entrez votre commande : ");
    $matches = [];
    if ($line === "list") {
        $command->list();
    }
    if(preg_match('/^detail ([0-9]+)$/', $line, $matches)) {
        $id = $matches[1];
        $command->detail($id);
    }
}