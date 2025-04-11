<?php
class HomeController {
    public function index() {
        // Không cần kiểm tra đăng nhập
        require_once 'app/views/user/index.php';
    }
}