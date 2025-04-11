<?php
class Router {
    private $db;
    private $publicRoutes = [
        '/' => ['controller' => 'Home', 'action' => 'index'],
        '/home' => ['controller' => 'Home', 'action' => 'index'],
        '/user/account/login' => ['controller' => 'Account', 'action' => 'login'],
        '/user/account/register' => ['controller' => 'Account', 'action' => 'register'],
        '/user/product/index' => ['controller' => 'Product', 'action' => 'index'],
        '/admin/login' => ['controller' => 'Auth', 'action' => 'login'],
        '/admin/logout' => ['controller' => 'Auth', 'action' => 'logout'],
    ];

    public function __construct($db) {
        $this->db = $db;
    }

    public function dispatch($requestUri, $requestMethod) {
        // Xóa BASE_URL khỏi requestUri nếu có
        $requestUri = str_replace(BASE_URL, '', $requestUri);
        $requestUri = trim($requestUri, '/');

        // Kiểm tra các route công khai
        if (array_key_exists('/' . $requestUri, $this->publicRoutes)) {
            $route = $this->publicRoutes['/' . $requestUri];
            $controllerPath = $route['controller'] === 'Auth' ? 'admin/' : 'user/';
            $controllerFile = "app/controllers/" . $controllerPath . ucfirst($route['controller']) . "Controller.php";
            return $this->loadController($controllerFile, $route['controller'], $route['action'], []);
        }

        // Xử lý route admin
        if (strpos($requestUri, 'admin/') === 0) {
            if ($requestUri !== 'admin/login') Auth::checkAdmin();
            $adminPath = substr($requestUri, 5); // Bỏ "admin/"
            $pathParts = explode('/', trim($adminPath, '/'));
            $controllerName = $pathParts[0] ?? 'index';
            $action = $pathParts[1] ?? 'index';
            $params = array_slice($pathParts, 2); // Lấy các tham số sau controller và action
            $controllerFile = "app/controllers/admin/" . ucfirst($controllerName) . "Controller.php";
            return $this->loadController($controllerFile, $controllerName, $action, $params);
        }

        // Xử lý route user
        if (strpos($requestUri, 'user/') === 0) {
            if ($requestUri !== 'user/login' && $requestUri !== 'user/register') {
                Auth::checkUser();
            }
            $userPath = substr($requestUri, 4); // Bỏ "user/"
            $pathParts = explode('/', trim($userPath, '/'));
            $controllerName = $pathParts[0] ?? 'index';
            $action = $pathParts[1] ?? 'index';
            $params = array_slice($pathParts, 2); // Lấy các tham số sau controller và action
            $controllerFile = "app/controllers/user/" . ucfirst($controllerName) . "Controller.php";
            return $this->loadController($controllerFile, $controllerName, $action, $params);
        }

        // Nếu không tìm thấy route, trả về 404
        header("HTTP/1.0 404 Not Found");
        require_once 'app/views/404.php';
        exit();
    }

    private function loadController($file, $controllerName, $action, $params = []) {
        if (file_exists($file) && (require_once $file) && class_exists($controllerClass = ucfirst($controllerName) . "Controller") && method_exists($controller = new $controllerClass($this->db), $action)) {
            // Gọi action với các tham số
            call_user_func_array([$controller, $action], $params);
            exit();
        }
        header("HTTP/1.0 404 Not Found");
        require_once 'app/views/404.php';
        exit();
    }
}