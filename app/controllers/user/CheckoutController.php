<?php
require_once 'app/models/ShoppingCartModel.php';
require_once 'app/models/CartItemModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/OrderItemModel.php';
require_once 'app/core/Auth.php';

class CheckoutController {
    private $cartModel;
    private $cartItemModel;
    private $productModel;
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->cartModel = new ShoppingCartModel();
        $this->cartItemModel = new CartItemModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index() {
        Auth::checkUser();
        // Lấy thông tin giỏ hàng
        $user_id = $_SESSION['user']['user_id'];
        $cart = $this->cartModel->getCartByUserId($user_id);

        if (!$cart) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }

        $items = $this->cartItemModel->getItemsByCartId($cart->cart_id);
        if (empty($items)) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }

        // Kiểm tra tồn kho
        foreach ($items as $item) {
            $stock = $this->productModel->getStockByVariantId($item->variant_id);
            if ($stock < $item->quantity) {
                $_SESSION['error'] = "Sản phẩm {$item->product_name} (Size: {$item->size_name}) không đủ hàng. Còn lại: $stock.";
                header('Location: ' . BASE_URL . 'user/cart/index');
                exit;
            }
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $price = $item->discount_price ?: $item->price;
            $subtotal += $price * $item->quantity;
        }
        $shipping_fee = 20000;
        $total = $subtotal + $shipping_fee;

        // Hiển thị trang thanh toán
        require_once 'app/views/user/checkout/index.php';
    }

    public function process() {
        Auth::checkUser();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'user/index/checkout');
            exit;
        }

        // Lấy thông tin từ form
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $customer_note = trim($_POST['customer_note'] ?? '');
        $payment_method = trim($_POST['payment_method'] ?? 'vnpay');

        // Kiểm tra dữ liệu đầu vào
        if (empty($first_name) || empty($last_name) || empty($phone) || empty($email) || empty($address)) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
            header('Location: ' . BASE_URL . 'user/checkout/index');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ!";
            header('Location: ' . BASE_URL . 'user/checkout/index');
            exit;
        }

        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            $_SESSION['error'] = "Số điện thoại không hợp lệ! Phải có 10-11 chữ số.";
            header('Location: ' . BASE_URL . 'user/checkout/index');
            exit;
        }

        // Lấy thông tin giỏ hàng
        $user_id = $_SESSION['user']['user_id'];
        $cart = $this->cartModel->getCartByUserId($user_id);
        
        if (!$cart) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }

        $items = $this->cartItemModel->getItemsByCartId($cart->cart_id);
        if (empty($items)) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }

        // Kiểm tra tồn kho theo variant_id
        foreach ($items as $item) {
            $stock = $this->productModel->getStockByVariantId($item->variant_id);
            if ($stock < $item->quantity) {
                $_SESSION['error'] = "Sản phẩm {$item->product_name} (Size: {$item->size_name}) không đủ hàng. Còn lại: $stock.";
                header('Location: ' . BASE_URL . 'user/cart/index');
                exit;
            }
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $price = $item->discount_price ?: $item->price;
            $subtotal += $price * $item->quantity;
        }
        $shipping_fee = 20000;
        $total = $subtotal + $shipping_fee;

        // Tạo đơn hàng
        $shipping_address = $first_name . ' ' . $last_name . ' | ' . $address . ' | ' . $phone . ' | ' . $email;
        $billing_address = $shipping_address;

        try {
            $order_id = $this->orderModel->createOrder($user_id, $total, $shipping_fee, $shipping_address, $billing_address, $customer_note, $payment_method);
            if (!$order_id) {
                throw new Exception("Không thể tạo đơn hàng!");
            }

            // Thêm các mục vào đơn hàng
            foreach ($items as $item) {
                $price = $item->price;
                $success = $this->orderItemModel->addOrderItem(
                    $order_id,
                    $item->variant_id,
                    $item->product_name,
                    $item->size_name,
                    $item->quantity,
                    $price,
                    $item->discount_price
                );
                if (!$success) {
                    throw new Exception("Không thể thêm mục vào đơn hàng!");
                }

                // Cập nhật tồn kho
                $this->productModel->updateStockByVariantId($item->variant_id, $item->quantity);
            }

            // Nếu phương thức thanh toán là VNPay, chuyển hướng đến VNPay
            if ($payment_method === 'vnpay') {
                $this->processVNPayPayment($order_id, $total);
            } else {
                // Thanh toán bằng tiền mặt (COD)
                $this->orderModel->updateOrderStatus($order_id, 'processing', 'pending');
                $this->cartItemModel->clearCart($cart->cart_id);
                $_SESSION['success'] = "Đặt hàng thành công! Chúng tôi sẽ giao hàng sớm nhất có thể.";
                header('Location: ' . BASE_URL . 'user/checkout/detail/'.$order_id);
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . BASE_URL . 'user/checkout/index');
            exit;
        }
    }

    private function processVNPayPayment($order_id, $total) {
        $vnp_TmnCode = "HV07X94M";
        $vnp_HashSecret = "OYDMVL1XCPNOO3VQWUXTLHAWP49V8F7N";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_ReturnUrl = "http://localhost/shoeshop/user/checkout/paymentReturn";

        $order = $this->orderModel->getOrderById($order_id);
        $vnp_TxnRef = $order->order_number;
        $vnp_Amount = $total * 100;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_CreateDate = date('YmdHis');
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toan don hang $vnp_TxnRef",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        exit;
    }

    public function paymentReturn() {
        Auth::checkUser();
        $vnp_HashSecret = "OYDMVL1XCPNOO3VQWUXTLHAWP49V8F7N";

        $inputData = [];
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'vnp_') === 0) {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashDataArr = [];
        foreach ($inputData as $key => $value) {
            $hashDataArr[] = urlencode($key) . '=' . urlencode($value);
        }
        $hashData = implode('&', $hashDataArr);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            $order = $this->orderModel->getOrderByNumber($inputData['vnp_TxnRef']);
            if ($order && $inputData['vnp_ResponseCode'] === '00') {
                $this->orderModel->updateOrderStatus($order->order_id, 'processing', 'paid');
                $this->cartItemModel->clearCart($order->user_id);
                $_SESSION['success'] = "Thanh toán thành công!";
            } else {
                $_SESSION['error'] = "Thanh toán không thành công!";
            }
        } else {
            $_SESSION['error'] = "Sai chữ ký!";
        }
        header('Location: ' . BASE_URL . 'user/checkout/detail');
        exit;
    }

    public function result() {
        require_once 'app/views/user/checkout/result.php';
    }
    public function detail($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $orderItems = $this->orderItemModel->getItemsByOrderId($orderId);
        if (!$order) {
            header("Location: " . BASE_URL . "user/account/index");
            exit();
        }
        require_once 'app/views/user/checkout/detail.php';
    }
}
