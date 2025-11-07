<?php
class DBConnect {
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