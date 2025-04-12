<?php

require_once 'app/models/ShoppingCartModel.php';
require_once 'app/models/CartItemModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/core/Auth.php';

class CartController {
    private $cartModel;
    private $cartItemModel;
    private $productModel;

    public function __construct() {
        $this->cartModel = new ShoppingCartModel();
        $this->cartItemModel = new CartItemModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        Auth::checkUser();
        if (!isset($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xem giỏ hàng!";
            header('Location: ' . BASE_URL . 'user/account/login');
            exit;
        }
        
        $user_id = $_SESSION['user']['user_id'];
        $cart = $this->cartModel->getCartByUserId($user_id);
        if (!$cart) {
            $items = [];
            $total = 0;
            $shipping_fee = 0;
        } else {
            $items = $this->cartItemModel->getItemsByCartId($cart->cart_id);
            $total = 0;
            foreach ($items as $item) {
                $price = $item->discount_price ?: $item->price;
                $total += $price * $item->quantity;
            }
            $shipping_fee = 20000;
            $total += $shipping_fee;
        }
        require_once 'app/views/user/carts/index.php';
    }

    public function add() {
        Auth::checkUser();
        if (!isset($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!";
            header('Location: ' . BASE_URL . 'user/account/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['user_id'];
            $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $variant_id = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

            if ($product_id > 0 && $variant_id > 0 && $quantity > 0) {
                $product = $this->productModel->getById($product_id);
                if ($product && $product->stock_quantity >= $quantity) {
                    $cart = $this->cartModel->getCartByUserId($user_id);
                    $this->cartItemModel->addItem($cart->cart_id, $variant_id, $quantity);
                    $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng!";
                } else {
                    $_SESSION['error'] = "Số lượng trong kho không đủ!";
                }
            } else {
                $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            }
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }
    }

    public function update() {
        Auth::checkUser();
        if (!isset($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để cập nhật giỏ hàng!";
            header('Location: ' . BASE_URL . 'user/account/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

            if ($item_id > 0 && $quantity >= 0) {
                if ($quantity == 0) {
                    $this->cartItemModel->removeItem($item_id);
                    $_SESSION['success'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
                } else {
                    $this->cartItemModel->updateQuantity($item_id, $quantity);
                    $_SESSION['success'] = "Đã cập nhật số lượng!";
                }
            }
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }
    }

    public function remove() {
        Auth::checkUser();
        if (!isset($_SESSION['user']['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xóa sản phẩm khỏi giỏ hàng!";
            header('Location: ' . BASE_URL . 'user/account/login');
            exit;
        }
        
        if (isset($_GET['item_id'])) {
            $item_id = (int)$_GET['item_id'];
            $this->cartItemModel->removeItem($item_id);
            $_SESSION['success'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }
    }
}