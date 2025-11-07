<?php
/**
 * Gestionnaire de contacts en ligne de commande
 * 
 * Ce script principal fournit une interface en ligne de commande interactive
 * pour gérer une liste de contacts. Il permet aux utilisateurs d'effectuer
 * des opérations CRUD (Create, Read, Update, Delete) sur les contacts.
 * 
 * Fonctionnalités disponibles :
 * - list : Affiche tous les contacts existants
 * - detail <id> : Affiche les détails d'un contact spécifique par son ID
 * - create <nom>, <email>, <telephone> : Crée un nouveau contact avec validation des données
 * - delete <id> : Supprime un contact par son ID
 * - update <id> : Met à jour un contact existant avec validation interactive des champs
 * - help : Affiche la liste complète des commandes disponibles
 * 
 * Validation des données :
 * - Nom : Lettres uniquement (a-zA-Z)
 * - Email : Format email valide avec domaine
 * - Téléphone : Exactement 10 chiffres
 * 
 * Le script utilise des expressions régulières pour parser et valider
 * les commandes utilisateur. Pour la commande update, une validation
 * interactive permet de laisser des champs vides pour ne pas les modifier.
 * 
 * Dépendances :
 * - Fichier 'command.php' contenant la classe Command
 * - Fonction readline() pour l'interaction utilisateur
 */
require_once 'command.php';

$command = new Command();
echo "Bienvenue dans le gestionnaire de contacts ! Tapez \"help\" pour voir la liste des commandes disponibles.\n\n";
while (true) {
    $line = readline("Entrez votre commande : ");
    $matches = [];
    if ($line === "list") {
        $command->list();
    }
    else if(preg_match('/^detail ([0-9]+)$/', $line, $matches)) {
        $id = $matches[1];
        $command->detail($id);
    }
    else if(preg_match('/^create ([a-zA-Z]+),\s*([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}),\s*([0-9]{10})$/', $line, $matches)) {
        $name = $matches[1];
        $email = $matches[2];
        $phone = $matches[3];
        $command->create($name, $email, $phone);
    }
    else if(preg_match('/^delete ([0-9]+)$/', $line, $matches)) {
        $id = $matches[1];
        $command->delete($id);
    }
    else if(preg_match('/^update ([0-9]+)$/', $line, $matches)) {
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
    else if($line === 'help') {
        echo "Liste des commandes disponibles :\n\n";
        echo "- list : Lister tous les contacts\n";
        echo "- detail <id> : Afficher les détails d'un contact\n";
        echo "- create <nom>, <email>, <telephone> : Créer un nouveau contact\n";
        echo "- delete <id> : Supprimer un contact\n";
        echo "- update <id> : Mettre à jour un contact (laisser vide pour ne pas modifier un champ)\n";
    }
    else if($line !== "") {
        echo "Commande non reconnue, tapez \"help\" pour voir la liste des commandes disponibles.\n";
    }
}