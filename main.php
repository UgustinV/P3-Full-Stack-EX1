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
    if(preg_match('/^create ([a-zA-Z]+),\s*([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}),\s*([0-9]{10})$/', $line, $matches)) {
        $name = $matches[1];
        $email = $matches[2];
        $phone = $matches[3];
        $command->create($name, $email, $phone);
    }
}