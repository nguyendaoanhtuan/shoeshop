<?php
session_start();

// Load các file cần thiết
require_once 'app/config/database.php';
require_once 'app/controllers/ProductController.php';
require_once 'app/controllers/CategoryController.php'; 
require_once 'app/controllers/BrandsController.php';

// Xác định controller và action với giá trị mặc định
$controller = $_GET['controller'] ?? 'product';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;


// Chuyển đổi tên controller sang dạng chuẩn (ProductController thay vì productController)
$controllerClassName = ucfirst(strtolower($controller)) . 'Controller';

// Kiểm tra xem controller có tồn tại không
if (!class_exists($controllerClassName)) {
    header("HTTP/1.0 404 Not Found");
    die("Controller không tồn tại");
}

// Khởi tạo controller
$controllerInstance = new $controllerClassName();

// Kiểm tra action có tồn tại trong controller không
if (!method_exists($controllerInstance, $action)) {
    header("HTTP/1.0 404 Not Found");
    die("Action không tồn tại");
}

// Gọi action tương ứng với tham số id nếu có
if ($id !== null) {
    $controllerInstance->$action($id);
} else {
    $controllerInstance->$action();

}

