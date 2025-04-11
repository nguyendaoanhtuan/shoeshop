<?php
class ShoppingCartModel {
    private $db;
    private $table = "shopping_cart";

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy giỏ hàng của user, nếu chưa có thì tạo mới
    public function getCartByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$cart) {
            // Nếu chưa có giỏ hàng, tạo mới
            $query = "INSERT INTO " . $this->table . " (user_id) VALUES (:user_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $cart_id = $this->db->lastInsertId();

            // Lấy lại giỏ hàng vừa tạo
            $query = "SELECT * FROM " . $this->table . " WHERE cart_id = :cart_id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->execute();
            $cart = $stmt->fetch(PDO::FETCH_OBJ);
        }

        return $cart;
    }

    // Xóa giỏ hàng (dùng khi cần thiết, ví dụ sau khi đặt hàng thành công)
    public function deleteCart($cart_id) {
        $query = "DELETE FROM " . $this->table . " WHERE cart_id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>