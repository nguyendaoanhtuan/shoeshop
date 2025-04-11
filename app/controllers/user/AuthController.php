<?php
session_start();

require_once 'app/config/database.php';
require_once 'app/core/Auth.php';

$database = new Database();
$db = $database->getConnection();

$auth = new Auth($db);

// Xác định route
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// ==================== PUBLIC ROUTES ====================
$publicRoutes = [
    '/',
    '/home',
    '/auth/login',
    '/auth/logout',
    '/user/dangnhap',
    '/user/dangky'
];

// Route đăng nhập (POST)
if ($requestUri === '/auth/login' && $requestMethod === 'POST') {
    require_once 'app/controllers/AuthController.php';
    $authController = new AuthController($db);
    $authController->login();
    exit();
}

// Route đăng nhập (GET)
if ($requestUri === '/user/dangnhap') {
    require_once 'app/views/user/dangnhap.php';
    exit();
}

// Route đăng ký (GET)
if ($requestUri === '/user/dangky') {
    require_once 'app/views/user/dangky.php';
    exit();
}

// Route đăng xuất
if ($requestUri === '/auth/logout') {
    require_once 'app/controllers/AuthController.php';
    $authController = new AuthController($db);
    $authController->logout();
    exit();
}

// ==================== KIỂM TRA ĐĂNG NHẬP ====================
if (!in_array($requestUri, $publicRoutes) && !$auth->isLoggedIn()) {
    header("Location: /user/dangnhap");
    exit();
}

// ==================== ADMIN ROUTES ====================
if (strpos($requestUri, '/admin/') === 0) {
    if (!$auth->isAdmin()) {
        header("HTTP/1.0 403 Forbidden");
        die("Access denied");
    }

    $adminPath = substr($requestUri, 7); // Bỏ '/admin/'
    $pathParts = explode('/', trim($adminPath, '/'));
    
    $controller = $pathParts[0] ?? 'dashboard';
    $action = $pathParts[1] ?? 'index';
    
    $controllerFile = "app/controllers/admin/" . ucfirst($controller) . "Controller.php";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerClassName = ucfirst($controller) . "Controller";
        
        if (class_exists($controllerClassName)) {
            $controllerInstance = new $controllerClassName($db);
            
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
                exit();
            }
        }
    }
    
    header("HTTP/1.0 404 Not Found");
    die("Admin page not found");
}

// ==================== USER ROUTES ====================
$pathParts = explode('/', trim($requestUri, '/'));
$controller = $pathParts[0] ?? 'home';
$action = $pathParts[1] ?? 'index';

$controllerFile = "app/controllers/" . ucfirst($controller) . "Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClassName = ucfirst($controller) . "Controller";
    
    if (class_exists($controllerClassName)) {
        $controllerInstance = new $controllerClassName($db);
        
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
            exit();
        }
    }
}

// 404 Not Found
header("HTTP/1.0 404 Not Found");
die("Page not found");