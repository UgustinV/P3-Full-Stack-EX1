<?php
require_once 'command.php';

$command = new Command();
echo "Bienvenue dans le gestionnaire de contacts ! Tapez \"help\" pour voir la liste des commandes disponibles.\n\n";
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
    if(preg_match('/^delete ([0-9]+)$/', $line, $matches)) {
        $id = $matches[1];
        $command->delete($id);
    }
    if(preg_match('/^update ([0-9]+)$/', $line, $matches)) {
        $id = $matches[1];
        $is_valid = false;
        while(!$is_valid){
            $name = readline("Entrez le nouveau nom : ");
            if($name === '' || preg_match('/^([a-zA-Z]+)$/', $name)) {
                $is_valid = true;
            }
        }
        $is_valid = false;
        while(!$is_valid){
            $email = readline("Entrez le nouvel email : ");
            if($email === '' || preg_match('/^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/', $email)) {
                $is_valid = true;
            }
        }
        $is_valid = false;
        while(!$is_valid){
            $phone = readline("Entrez le nouveau numéro de téléphone : ");
            if($phone === '' || preg_match('/^([0-9]{10})$/', $phone)) {
                $is_valid = true;
            }
        }
        $command->update($id, $name, $email, $phone);
    }
    if($line === 'help') {
        echo "Liste des commandes disponibles :\n\n";
        echo "- list : Lister tous les contacts\n";
        echo "- detail <id> : Afficher les détails d'un contact\n";
        echo "- create <nom>, <email>, <telephone> : Créer un nouveau contact\n";
        echo "- delete <id> : Supprimer un contact\n";
        echo "- update <id> : Mettre à jour un contact (laisser vide pour ne pas modifier un champ)\n";
    }
}