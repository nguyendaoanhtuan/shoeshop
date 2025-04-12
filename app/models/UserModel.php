<?php
class UserModel {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        try {
            $query = "SELECT user_id, email, password_hash, full_name 
                      FROM " . $this->table . " 
                      WHERE email = :email 
                      AND is_active = 1 
                      LIMIT 1";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password_hash'])) {
                    $this->updateLastLogin($user['user_id']);
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("User login error: " . $e->getMessage());
            return false;
        }
    }

    public function register($data) {
        try {
            // Kiểm tra email đã tồn tại chưa
            $checkEmail = $this->conn->prepare("SELECT email FROM " . $this->table . " WHERE email = :email");
            $checkEmail->bindParam(":email", $data['email']);
            $checkEmail->execute();
            
            if ($checkEmail->rowCount() > 0) {
                $_SESSION['register_errors']['email'] = 'Email đã được sử dụng';
                return false;
            }
    
            // Thêm user mới
            $query = "INSERT INTO " . $this->table . " 
                     (email, password_hash, full_name, dob, created_at, is_active) 
                     VALUES (:email, :password_hash, :full_name, :dob, NOW(), 1)";
    
            $stmt = $this->conn->prepare($query);
            
            $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
            $dob = !empty($data['DOB']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['DOB']))) : null;
            
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":password_hash", $password_hash);
            $stmt->bindParam(":full_name", $data['fullname']);
            $stmt->bindParam(":dob", $dob);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("User registration error: " . $e->getMessage());
            return false;
        }
    }

    private function updateLastLogin($user_id) {
        $query = "UPDATE " . $this->table . " 
                  SET last_login = CURRENT_TIMESTAMP 
                  WHERE user_id = :user_id";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
    }

    public function getUserById($user_id) {
        $query = "SELECT user_id, email, full_name, phone_number, address, avatar_url 
                  FROM " . $this->table . " 
                  WHERE user_id = :user_id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getAllUsers($page = 1, $perPage = 10, $search = '') {
        try {
            $offset = ($page - 1) * $perPage;
            
            $query = "SELECT user_id, email, full_name, phone_number, is_active, created_at 
                     FROM " . $this->table . " 
                     WHERE 1=1";
            
            if (!empty($search)) {
                $query .= " AND (email LIKE :search OR full_name LIKE :search)";
            }
            
            $query .= " ORDER BY created_at DESC LIMIT :offset, :perPage";
            
            $stmt = $this->conn->prepare($query);
            
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam);
            }
            
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get users error: " . $e->getMessage());
            return false;
        }
    }

    // Thêm hàm đếm tổng số users
    public function countUsers($search = '') {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE 1=1";
            
            if (!empty($search)) {
                $query .= " AND (email LIKE :search OR full_name LIKE :search)";
            }
            
            $stmt = $this->conn->prepare($query);
            
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam);
            }
            
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log("Count users error: " . $e->getMessage());
            return 0;
        }
    }

    // Thêm hàm cập nhật user
    public function updateUser($data) {
        try {
            $query = "UPDATE " . $this->table . " 
                     SET full_name = :full_name, 
                         phone_number = :phone_number,
                         is_active = :is_active
                     WHERE user_id = :user_id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':full_name', $data['full_name']);
            $stmt->bindParam(':phone_number', $data['phone_number']);
            $stmt->bindParam(':is_active', $data['is_active'], PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update user error: " . $e->getMessage());
            return false;
        }
    }

    // Thêm hàm xóa user
    public function deleteUser($user_id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }
}