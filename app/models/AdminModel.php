<?php
class AdminModel { // Đổi từ Admin thành AdminModel
    private $conn;
    private $table = "admins";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        try {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE username = :username 
                      AND password_hash = :password
                      LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return false;
        } catch (PDOException $e) {
            error_log("Admin login error: " . $e->getMessage());
            return false;
        }
    }

    public function getAdminById($admin_id) {
        $query = "SELECT admin_id, username, full_name, role FROM " . $this->table . " 
                  WHERE admin_id = :admin_id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":admin_id", $admin_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}