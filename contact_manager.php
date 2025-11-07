<?php
require_once 'contact.php';
class ContactManager {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

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

    public function findById(int $id): ?Contact {
        $request = $this->db->prepare("SELECT * FROM contacts WHERE id = :id");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        $contact = $request->fetch();
        if ($contact) {
            $contact = new Contact($contact['id'], $contact['name'], $contact['email'], $contact['phone_number']);
        }
        return $contact;
    }

    public function create(string $name, string $email, string $phone_number): ?Contact {
        $request = $this->db->prepare("INSERT INTO contacts (name, email, phone_number) VALUES (:name, :email, :phone_number)");
        $success = $request->execute([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number
        ]);
        if ($success) {
            return $this->findById($this->db->lastInsertId());
        } else {
            return null;
        }
    }

    public function delete(int $id): bool {
        $request = $this->db->prepare('DELETE FROM contacts WHERE id = :id');
        $success = $request->execute(['id' => $id]);
        return $success;
    }

    public function update(int $id, string $name, string $email, string $phone_number): ?Contact {
        $setParts = [];
        $params = ['id' => $id];
        
        if ($name !== '') {
            $setParts[] = "name = :name";
            $params['name'] = $name;
        }
        
        if ($email !== '') {
            $setParts[] = "email = :email";
            $params['email'] = $email;
        }

        if ($phone_number !== '') {
            $setParts[] = "phone_number = :phone_number";
            $params['phone_number'] = $phone_number;
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