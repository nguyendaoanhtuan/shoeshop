<?php
class OrderModel {
    private $db;
    private $table = "orders";

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy danh sách đơn hàng với tìm kiếm và phân trang
    public function getOrders($search, $limit, $offset) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE order_number LIKE :search OR shipping_address LIKE :search 
                  ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        return [];
    }

    // Lấy tổng số đơn hàng
    public function getTotalOrders($search) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE order_number LIKE :search OR shipping_address LIKE :search";
        $stmt = $this->db->prepare($query);
        
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
        }
        return 0;
    }

    // Tạo đơn hàng mới
    public function createOrder($user_id, $total_amount, $shipping_fee, $shipping_address, $billing_address, $customer_note, $payment_method) {
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

    // Cập nhật đơn hàng
    public function updateOrder($order_id, $status, $payment_status, $order_address, $order_note) {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status, payment_status = :payment_status,shipping_address = :order_address, customer_note = :order_note, updated_at = CURRENT_TIMESTAMP 
                  WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':order_address', $order_address);
        $stmt->bindParam(':order_note', $order_note);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        
        return $stmt->execute();
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

    // Hủy đơn hàng
    public function cancelOrder($order_id) {
        $query = "UPDATE " . $this->table . " 
                  SET status = 'cancelled', updated_at = CURRENT_TIMESTAMP 
                  WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        
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

    public function deleteOrder($order_id) {
        try {
            $this->db->beginTransaction();

            // Xóa các mục trong order_items
            $queryItems = "DELETE FROM order_items WHERE order_id = :order_id";
            $stmtItems = $this->db->prepare($queryItems);
            $stmtItems->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmtItems->execute();

            // Xóa đơn hàng
            $queryOrder = "DELETE FROM " . $this->table . " WHERE order_id = :order_id";
            $stmtOrder = $this->db->prepare($queryOrder);
            $stmtOrder->bindParam(':order_id', $order_id, PDO::PARAM_INT);

            if ($stmtOrder->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }
}