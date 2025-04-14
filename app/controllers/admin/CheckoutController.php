<?php

require_once 'app/models/ShoppingCartModel.php';
require_once 'app/models/CartItemModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/OrderItemModel.php';
require_once 'app/core/Auth.php';

class CheckoutController {
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    // Hiển thị danh sách đơn hàng
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Lấy danh sách đơn hàng từ OrderModel
        $orders = $this->orderModel->getOrders($search, $limit, $offset);
        $totalOrders = $this->orderModel->getTotalOrders($search);
        $totalPages = ceil($totalOrders / $limit);

        // Load view
        require_once 'app/views/admin/checkout/index.php';
    }

    // Hiển thị chi tiết và chỉnh sửa đơn hàng
    public function edit($order_id) {
        $order = $this->orderModel->getOrderById($order_id);
        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại.";
            header("Location: " . BASE_URL . "admin/checkout/index");
            exit;
        }

        $orderItems = $this->orderItemModel->getItemsByOrderId($order_id);

        // Xử lý cập nhật đơn hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            $payment_status = $_POST['payment_status'] ?? 'pending';
            $orderAddress = $_POST['orderAddress'];
            $orderNote = $_POST['orderNote'] ?? "";
            if ($this->orderModel->updateOrderStatus($order_id, $status, $payment_status, $orderAddress, $orderNote)) {
                $_SESSION['success'] = "Cập nhật đơn hàng thành công.";
            } else {
                $_SESSION['error'] = "Cập nhật đơn hàng thất bại.";
            }
            header("Location: " . BASE_URL . "admin/checkout/index");
            exit;
        }

        // Load view
        require_once 'app/views/admin/checkout/edit.php';
    }

    // Xóa đơn hàng
    public function delete($order_id) {
        $order = $this->orderModel->getOrderById($order_id);
        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại.";
        } else {
            if ($this->orderModel->deleteOrder($order_id)) {
                $_SESSION['success'] = "Xóa đơn hàng thành công.";
            } else {
                $_SESSION['error'] = "Xóa đơn hàng thất bại.";
            }
        }
        header("Location: " . BASE_URL . "admin/checkout/index");
        exit;
    }
}