<?php
require_once 'app/core/Auth.php';

class IndexController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        Auth::checkAdmin();
        require_once 'app/views/user/index.php';
    }
}