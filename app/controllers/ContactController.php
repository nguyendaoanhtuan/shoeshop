<?php
class ContactController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        require_once 'app/views/user/contact.php';
    }

    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            $query = "INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Tin nhắn của bạn đã được gửi thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
            }
            header('Location: /shoeshop/contact');
            exit();
        }
    }
} 