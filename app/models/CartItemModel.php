<?php
class CartItemModel {
    private $db;
    private $table = "cart_items";

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy tất cả sản phẩm trong giỏ hàng
    public function getItemsByCartId($cart_id) {
        $query = "SELECT ci.*, 
                         pv.product_id, 
                         pv.variant_id,
                         p.name AS product_name, 
                         p.price, 
                         p.discount_price, 
                         (SELECT pi.image_url FROM product_images pi WHERE pi.product_id = p.product_id AND pi.is_primary = 1 LIMIT 1) AS primary_image,
                         s.name AS size_name
                  FROM " . $this->table . " ci
                  JOIN product_variants pv ON ci.variant_id = pv.variant_id
                  JOIN products p ON pv.product_id = p.product_id
                  JOIN sizes s ON pv.size_id = s.size_id
                  WHERE ci.cart_id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addItem($cart_id, $variant_id, $quantity = 1) {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $query = "SELECT * FROM " . $this->table . " WHERE cart_id = :cart_id AND variant_id = :variant_id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->bindParam(':variant_id', $variant_id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_OBJ);

        if ($item) {
            // Nếu đã có, tăng số lượng
            $new_quantity = $item->quantity + $quantity;
            $query = "UPDATE " . $this->table . " SET quantity = :quantity WHERE item_id = :item_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $item->item_id, PDO::PARAM_INT);
            return $stmt->execute();
        } else {
            // Nếu chưa có, thêm mới
            $query = "INSERT INTO " . $this->table . " (cart_id, variant_id, quantity) VALUES (:cart_id, :variant_id, :quantity)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(':variant_id', $variant_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }

    // Cập nhật số lượng sản phẩm
    public function updateQuantity($item_id, $quantity) {
        $query = "UPDATE " . $this->table . " SET quantity = :quantity WHERE item_id = :item_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeItem($item_id) {
        $query = "DELETE FROM " . $this->table . " WHERE item_id = :item_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa tất cả sản phẩm trong giỏ hàng (dùng khi cần thiết, ví dụ sau khi đặt hàng)
    public function clearCart($cart_id) {
        $query = "DELETE FROM " . $this->table . " WHERE cart_id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>