<?php
class DBConnect {
    public static function getPDO($host, $db_name, $user, $password) {
        try {
            return new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $user, $password);
        }
        catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }
}