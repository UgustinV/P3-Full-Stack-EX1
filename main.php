<?php
require_once 'command.php';

$command = new Command();
while (true) {
    $line = readline("Entrez votre commande : ");
    if ($line === "list") {
        $command->list();
    }
    $matches = [];
    if(preg_match('/^detail ([0-9]+)$/', $line, $matches)) {
        $id = $matches[1];
        var_dump($id);
    }
}