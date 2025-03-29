
<?php
session_start();

require_once 'app/config/database.php';

// Xác định controller và action
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($controller) {
    case 'auth':
        if ($action === 'login') {
            include 'app/views/user/dangnhap.php';
            exit();
        } elseif ($action === 'register') {
            include 'app/views/user/dangky.php';
            exit();
        }
        break;
    default:
        header("Location: ?controller=auth&action=login");
        exit();
}

