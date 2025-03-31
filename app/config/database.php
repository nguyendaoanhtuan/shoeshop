<?php
class Database {
    private $host = "localhost";
    private $database = "shoeshop";
    private $username = "root";
    private $password = "";
    
    public function getConnection() {
        try {
            $conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->database,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}
?>
