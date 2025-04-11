<?php
class OrderItemModel {
    private $db;
    private $table = "order_items";

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Thêm mục vào đơn hàng
    public function addOrderItem($order_id, $variant_id, $product_name, $size_name, $quantity, $price, $discount_price) {
        $query = "INSERT INTO " . $this->table . " 
                  (order_id, variant_id, product_name, size_name, quantity, price, discount_price) 
                  VALUES (:order_id, :variant_id, :product_name, :size_name, :quantity, :price, :discount_price)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':variant_id', $variant_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':size_name', $size_name);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':discount_price', $discount_price);
        
        if (!$stmt->execute()) {
            $errors = $stmt->errorInfo();
            error_log("SQL Error in addOrderItem: " . $errors[2]);
            return false;
        }
        return true;
    }
    // Lấy danh sách mục trong đơn hàng
    public function getItemsByOrderId($order_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>