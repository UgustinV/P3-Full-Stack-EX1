<?php
class DBConnect {
    private $host = "";
    private $db_name = "";

    public function __construct($host, $db_name) {
        $this->host = $host;
        $this->db_name = $db_name;
    }

    public function getPDO() {
        try {
            return new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, 'root', '');
        }
        catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }
}