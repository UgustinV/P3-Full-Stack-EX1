<?php
/**
 * Classe DBConnect
 * 
 * Classe utilitaire pour gérer la connexion à la base de données MySQL.
 * Fournit une méthode statique pour créer une instance PDO configurée
 * avec gestion d'erreurs intégrée.
 */
class DBConnect {
    /**
     * Crée et retourne une connexion PDO à la base de données MySQL
     * 
     * Établit une connexion à la base de données en utilisant les paramètres fournis.
     * En cas d'erreur de connexion, affiche le message d'erreur et retourne null.
     * 
     * @param string $host L'adresse du serveur de base de données
     * @param string $db_name Le nom de la base de données à laquelle se connecter
     * @param string $user Le nom d'utilisateur pour la connexion
     * @param string $password Le mot de passe pour la connexion
     * @return PDO|null L'instance PDO en cas de succès, null en cas d'échec
     */
    public static function getPDO(string $host, string $db_name, string $user, string $password): ?PDO {
        try {
            return new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $user, $password);
        }
        catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
            return null;
        }
    }
}