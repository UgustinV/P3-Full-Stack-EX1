<?php
/**
 * Classe Contact
 * 
 * Représente un contact avec ses informations personnelles.
 * Permet de gérer les données d'un contact incluant son identifiant,
 * son nom, son email et son numéro de téléphone.
 */
class Contact {
    private int $id;
    private string $name;
    private string $email;
    private string $phone_number;

    /**
     * Constructeur de la classe Contact
     * 
     * Initialise un nouveau contact avec toutes ses informations.
     * 
     * @param int $id L'identifiant unique du contact
     * @param string $name Le nom complet du contact
     * @param string $email L'adresse email du contact
     * @param string $phone_number Le numéro de téléphone du contact
     */
    public function __construct(int $id, string $name, string $email, string $phone_number) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    /**
     * Récupère l'identifiant du contact
     * 
     * @return int L'identifiant unique du contact
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Récupère le nom du contact
     * 
     * @return string Le nom complet du contact
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Récupère l'email du contact
     * 
     * @return string L'adresse email du contact
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Récupère le numéro de téléphone du contact
     * 
     * @return string Le numéro de téléphone du contact
     */
    public function getPhoneNumber(): string {
        return $this->phone_number;
    }

    /**
     * Modifie le nom du contact
     * 
     * @param string $name Le nouveau nom du contact
     */
    public function setName(string $name) {
        $this->name = $name;
    }

    /**
     * Modifie l'email du contact
     * 
     * @param string $email La nouvelle adresse email du contact
     */
    public function setEmail(string $email) {
        $this->email = $email;
    }

    /**
     * Modifie le numéro de téléphone du contact
     * 
     * @param string $phone_number Le nouveau numéro de téléphone du contact
     */
    public function setPhoneNumber(string $phone_number) {
        $this->phone_number = $phone_number;
    }

    /**
     * Convertit l'objet Contact en chaîne de caractères
     * 
     * Retourne une représentation textuelle du contact avec toutes ses informations
     * séparées par des virgules.
     * 
     * @return string Une chaîne contenant l'id, le nom, l'email et le téléphone
     */
    public function __toString() {
        return "{$this->id}, {$this->name}, {$this->email}, {$this->phone_number}";
    }
}