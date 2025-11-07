<?php
require_once 'contact.php';

/**
 * Classe ContactManager
 * 
 * Gestionnaire pour les opérations CRUD sur les contacts.
 * Permet de gérer les contacts dans une base de données en utilisant PDO
 * pour effectuer les opérations de création, lecture, mise à jour et suppression.
 */
class ContactManager {
    private PDO $db;

    /**
     * Constructeur de la classe ContactManager
     * 
     * Initialise le gestionnaire avec une connexion à la base de données.
     * 
     * @param PDO $db L'instance PDO pour la connexion à la base de données
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère tous les contacts de la base de données
     * 
     * Exécute une requête pour récupérer tous les contacts et les convertit
     * en objets Contact.
     * 
     * @return array Un tableau d'objets Contact
     */
    public function findAll(): array {
        $contact_list = [];
        $request = $this->db->prepare("SELECT * FROM contacts");
        $request->execute();
        $contacts = $request->fetchAll();
        foreach ($contacts as $contact) {
            $contact = new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number']);
            $contact_list[] = $contact;
        }
        return $contact_list;
    }

    /**
     * Récupère un contact par son identifiant
     * 
     * Recherche un contact spécifique dans la base de données en utilisant son ID.
     * 
     * @param int $id L'identifiant du contact à rechercher
     * @return Contact|null L'objet Contact trouvé ou null si aucun contact trouvé
     */
    public function findById(int $id): ?Contact {
        $request = $this->db->prepare("SELECT * FROM contacts WHERE id = :id");
        $request->bindValue(':id', htmlspecialchars($id), PDO::PARAM_INT);
        $request->execute();
        $contact = $request->fetch();
        if ($contact) {
            $contact = new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number']);
        }
        return $contact;
    }

    /**
     * Crée un nouveau contact dans la base de données
     * 
     * Insère un nouveau contact avec les informations fournies et retourne
     * l'objet Contact créé avec son ID généré.
     * 
     * @param string $name Le nom du contact
     * @param string $email L'adresse email du contact
     * @param string $phone_number Le numéro de téléphone du contact
     * @return Contact|null L'objet Contact créé ou null en cas d'échec
     */
    public function create(string $name, string $email, string $phone_number): ?Contact {
        $request = $this->db->prepare("INSERT INTO contacts (name, email, phone_number) VALUES (:name, :email, :phone_number)");
        $success = $request->execute([
            'name' => htmlspecialchars($name),
            'email' => htmlspecialchars($email),
            'phone_number' => htmlspecialchars($phone_number)
        ]);
        if ($success) {
            return $this->findById($this->db->lastInsertId());
        } else {
            return null;
        }
    }

    /**
     * Supprime un contact de la base de données
     * 
     * Supprime définitivement un contact en utilisant son identifiant.
     * 
     * @param int $id L'identifiant du contact à supprimer
     * @return bool True si la suppression a réussi, false sinon
     */
    public function delete(int $id): bool {
        $request = $this->db->prepare('DELETE FROM contacts WHERE id = :id');
        $success = $request->execute(['id' => htmlspecialchars($id)]);
        return $success;
    }

    /**
     * Met à jour un contact existant
     * 
     * Met à jour les informations d'un contact. Seuls les champs non vides
     * sont mis à jour, permettant une mise à jour partielle.
     * 
     * @param int $id L'identifiant du contact à mettre à jour
     * @param string $name Le nouveau nom (vide pour ne pas modifier)
     * @param string $email Le nouvel email (vide pour ne pas modifier)
     * @param string $phone_number Le nouveau numéro (vide pour ne pas modifier)
     * @return Contact|null L'objet Contact mis à jour ou null en cas d'échec
     */
    public function update(int $id, string $name, string $email, string $phone_number): ?Contact {
        $id = htmlspecialchars($id);
        $setParts = [];
        $params = ['id' => $id];
        
        if ($name !== '') {
            $setParts[] = "name = :name";
            $params['name'] = htmlspecialchars($name);
        }
        
        if ($email !== '') {
            $setParts[] = "email = :email";
            $params['email'] = htmlspecialchars($email);
        }

        if ($phone_number !== '') {
            $setParts[] = "phone_number = :phone_number";
            $params['phone_number'] = htmlspecialchars($phone_number);
        }

        if (empty($setParts)) {
            return $this->findById($id);
        }
        
        $sql = "UPDATE contacts SET " . implode(', ', $setParts) . " WHERE id = :id";
        $request = $this->db->prepare($sql);
        $success = $request->execute($params);
        
        if ($success) {
            return $this->findById($id);
        } else {
            return null;
        }
    }
}