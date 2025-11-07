<?php
require_once 'contact_manager.php';
require_once 'db_connect.php';
require_once 'env_variables.php';

/**
 * Classe Command
 * 
 * Gère les commandes en ligne de commande pour la gestion des contacts.
 * Fournit une interface de commande pour effectuer les opérations CRUD
 * (Create, Read, Update, Delete) sur les contacts via le ContactManager.
 */
class Command {
    private PDO $db;
    private ContactManager $contactManager;

    /**
     * Constructeur de la classe Command
     * 
     * Initialise la connexion à la base de données et le gestionnaire de contacts.
     * Configure automatiquement la connexion avec les paramètres par défaut.
     */
    public function __construct() {
        global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASSWORD;
        $this->db = DBConnect::getPDO($DB_HOST, $DB_NAME, $DB_USER, $DB_PASSWORD);
        $this->contactManager = new ContactManager($this->db);
    }

    /**
     * Affiche la liste de tous les contacts
     * 
     * Récupère tous les contacts depuis la base de données et les affiche.
     * Si aucun contact n'est trouvé, affiche un message informatif.
     */
    public function list() {
        $contact_list = $this->contactManager->findAll();
        if (empty($contact_list)) {
            echo "No contacts found.\n";
        }
        foreach ($contact_list as $contact) {
            echo $contact->__toString() . "\n";
        }
    }

    /**
     * Affiche les détails d'un contact spécifique
     * 
     * Recherche et affiche un contact par son identifiant unique.
     * Si le contact n'existe pas, affiche un message d'erreur.
     * 
     * @param int $id L'identifiant unique du contact à afficher
     */
    public function detail(int $id) {
        $contact = $this->contactManager->findById($id);
        if ($contact) {
            echo $contact->__toString() . "\n";
        }
        else {
            echo "Contact with ID $id not found.\n";
        }
    }

    /**
     * Crée un nouveau contact
     * 
     * Ajoute un nouveau contact dans la base de données avec les informations fournies.
     * Affiche un message de confirmation en cas de succès ou d'erreur.
     * 
     * @param string $name Le nom complet du contact
     * @param string $email L'adresse email du contact
     * @param string $phone Le numéro de téléphone du contact
     */
    public function create(string $name, string $email, string $phone) {
        $contact = $this->contactManager->create($name, $email, $phone);
        if ($contact) {
            echo "Contact created: " . $contact->__toString() . "\n";
        }
        else {
            echo "Failed to create contact.\n";
        }
    }

    /**
     * Supprime un contact
     * 
     * Supprime définitivement un contact de la base de données par son identifiant.
     * Affiche un message de confirmation en cas de succès ou d'erreur.
     * 
     * @param int $id L'identifiant unique du contact à supprimer
     */
    public function delete(int $id) {
        $success = $this->contactManager->delete($id);
        if ($success) {
            echo "Contact with ID $id deleted successfully.\n";
        } else {
            echo "Failed to delete contact with ID $id.\n";
        }
    }

    /**
     * Met à jour un contact existant
     * 
     * Modifie les informations d'un contact existant dans la base de données.
     * Affiche un message de confirmation en cas de succès ou d'erreur.
     * 
     * @param int $id L'identifiant unique du contact à modifier
     * @param string $name Le nouveau nom du contact
     * @param string $email La nouvelle adresse email du contact
     * @param string $phone Le nouveau numéro de téléphone du contact
     */
    public function update(int $id, string $name, string $email, string $phone) {
        $contact = $this->contactManager->update($id, $name, $email, $phone);
        if ($contact) {
            echo "Contact with ID $id updated successfully.\n";
        } else {
            echo "Failed to update contact with ID $id.\n";
        }
    }
}