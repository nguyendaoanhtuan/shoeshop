<?php

class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password, $full_name) {
        try {
            // Kiểm tra email đã tồn tại chưa
            $check_query = "SELECT id FROM " . $this->table . " WHERE email = :email OR username = :username LIMIT 1";
            $check_stmt = $this->conn->prepare($check_query);
            $check_stmt->bindParam(":email", $email);
            $check_stmt->bindParam(":username", $username);
            $check_stmt->execute();

            if ($check_stmt->rowCount() > 0) {
                return "Email hoặc tên đăng nhập đã tồn tại";
            }

            // Thêm user mới
            $query = "INSERT INTO " . $this->table . " 
                    (username, email, password_hash, full_name, created_at) 
                    VALUES (:username, :email, :password_hash, :full_name, NOW())";

            $stmt = $this->conn->prepare($query);

            // Mã hóa mật khẩu
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Bind các giá trị
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password_hash", $password_hash);
            $stmt->bindParam(":full_name", $full_name);

            if($stmt->execute()) {
                return true;
            }
            return "Có lỗi xảy ra khi đăng ký";

        } catch(PDOException $e) {
            return "Lỗi: " . $e->getMessage();
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($row['password_hash']) && password_verify($password, $row['password_hash'])) {
                    return $row;
                }
            }
            return false;
        } catch(PDOException $e) {
            echo "Login error: " . $e->getMessage();
            return false;
        }
    }

    private function updateLastLogin($user_id) {
        $sql = "UPDATE " . $this->table . " 
                SET last_login = :last_login 
                WHERE id = :user_id";
        
        $stmt = $this->conn->prepare($sql);
        $now = date('Y-m-d H:i:s');
        
        $stmt->bindParam(":last_login", $now);
        $stmt->bindParam(":user_id", $user_id);
        
        return $stmt->execute();
    }

    private function checkExists($username, $email) {
        $sql = "SELECT id FROM " . $this->table . " 
                WHERE username = :username OR email = :email";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    public function logout() {
        session_unset();
        session_destroy();
        return true;
    }
}