<?php
class OrderModel {
    private $db;
    private $table = "orders";

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Tạo đơn hàng mới
    public function createOrder($user_id, $total_amount, $shipping_fee, $shipping_address, $billing_address, $customer_note, $payment_method) {
        // Tạo order_number duy nhất
        $order_number = 'ORD-' . time();
        
        $query = "INSERT INTO " . $this->table . " 
                  (user_id, order_number, total_amount, shipping_fee, shipping_address, billing_address, customer_note, payment_method, payment_status) 
                  VALUES (:user_id, :order_number, :total_amount, :shipping_fee, :shipping_address, :billing_address, :customer_note, :payment_method, 'pending')";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':order_number', $order_number);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':shipping_fee', $shipping_fee);
        $stmt->bindParam(':shipping_address', $shipping_address);
        $stmt->bindParam(':billing_address', $billing_address);
        $stmt->bindParam(':customer_note', $customer_note);
        $stmt->bindParam(':payment_method', $payment_method);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Cập nhật trạng thái đơn hàng và trạng thái thanh toán
    public function updateOrderStatus($order_id, $status, $payment_status) {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status, payment_status = :payment_status, updated_at = CURRENT_TIMESTAMP 
                  WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Lấy đơn hàng theo order_id
    public function getOrderById($order_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE order_id = :order_id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lấy đơn hàng theo order_number
    public function getOrderByNumber($order_number) {
        $query = "SELECT * FROM " . $this->table . " WHERE order_number = :order_number LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_number', $order_number);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}