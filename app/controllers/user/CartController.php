<?php
require_once 'app/models/ShoppingCartModel.php';
require_once 'app/models/CartItemModel.php';
require_once 'app/models/ProductModel.php'; // Thêm để kiểm tra tồn kho
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

    // Hiển thị giỏ hàng
    public function index() {
        Auth::checkUser();
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Lấy từ session
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
            $shipping_fee = 20000; // Phí giao hàng cố định
            $total += $shipping_fee;
        }
        require_once 'app/views/user/carts/index.php';
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add() {
        Auth::checkUser();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Lấy từ session
            $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $variant_id = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

            if ($product_id > 0 && $variant_id > 0 && $quantity > 0) {
                // Lấy thông tin sản phẩm để kiểm tra tồn kho
                $product = $this->productModel->getById($product_id);
                if ($product && $product->stock_quantity >= $quantity) {
                    $cart = $this->cartModel->getCartByUserId($user_id);
                    $this->cartItemModel->addItem($cart->cart_id, $variant_id, $quantity);
                    // Cập nhật tồn kho (tạm thời trừ đi số lượng)
                    $new_stock = $product->stock_quantity - $quantity;
                    $this->productModel->updateStockByVariantId($product_id, $new_stock);
                } else {
                    // Thông báo lỗi nếu không đủ hàng
                    $_SESSION['error'] = "Số lượng trong kho không đủ!";
                }
            } else {
                $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            }
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }
    }

    // Cập nhật số lượng sản phẩm
    public function update() {
        Auth::checkUser();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

            if ($item_id > 0 && $quantity >= 0) {
                if ($quantity == 0) {
                    $this->cartItemModel->removeItem($item_id);
                } else {
                    $this->cartItemModel->updateQuantity($item_id, $quantity);
                }
            }
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove() {
        Auth::checkUser();
        if (isset($_GET['item_id'])) {
            $item_id = (int)$_GET['item_id'];
            $this->cartItemModel->removeItem($item_id);
            header('Location: ' . BASE_URL . 'user/cart/index');
            exit;
        }
    }
}
?>