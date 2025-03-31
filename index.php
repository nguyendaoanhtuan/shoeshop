<?php
session_start();
require_once 'app/config/database.php';
require_once 'app/models/Category.php';
require_once 'app/models/Product.php';
require_once 'app/controllers/ProductController.php';
require_once 'app/controllers/loginController.php';
require_once 'app/controllers/ContactController.php';
require_once 'app/controllers/AccountController.php';

$database = new Database();
$db = $database->getConnection();

$loginController = new LoginController($db);
$productController = new ProductController($db);
$contactController = new ContactController($db);
$accountController = new AccountController($db);

// Lấy URL hiện tại
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/shoeshop';

// Loại bỏ base path khỏi URL để có route
$route = str_replace($base_path, '', $request_uri);

// Nếu route trống, set thành '/'
if (empty($route)) {
    $route = '/';
}

// Loại bỏ query string nếu có
if (($pos = strpos($route, '?')) !== false) {
    $route = substr($route, 0, $pos);
}

// Loại bỏ dấu / ở cuối nếu có
$route = rtrim($route, '/');
if (empty($route)) {
    $route = '/';
}

try {
    switch ($route) {
        case '/':
            require_once 'app/views/user/index.php';
            break;
        case '/login':
            $loginController->login();
            break;
        case '/register':
            $loginController->register();
            break;
        case '/logout':
            $loginController->logout();
            break;
        case '/products':
            $productController->index();
            break;
        case '/contact':
            $contactController->index();
            break;
        case '/contact/send':
            $contactController->send();
            break;
        case '/account':
            $accountController->index();
            break;
        case '/account/update':
            $accountController->updateProfile();
            break;
        case '/account/change-password':
            $accountController->changePassword();
            break;
        default:
            if (preg_match('/^\/product\/(\d+)$/', $route, $matches)) {
                $productController->detail($matches[1]);
            } else {
                header("HTTP/1.0 404 Not Found");
                require_once 'app/views/404.php';
            }
            break;
    }
} catch (Exception $e) {
    // Log lỗi và hiển thị trang lỗi
    error_log($e->getMessage());
    require_once 'app/views/error.php';
}

?>