<?php
require_once 'app/models/ProductImgModel.php';
require_once 'app/core/Auth.php';

class ProductImgController {
    private $db;
    private $productImgModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productImgModel = new ProductImgModel($db);
    }

    // Hiển thị tất cả hình ảnh kèm sản phẩm
    public function index() {
    // Lấy tham số tìm kiếm và trang
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $perPage = 10; // Số hình ảnh mỗi trang

    // Lấy dữ liệu phân trang
    $data = $this->productImgModel->getPaginatedImagesWithProducts($search, $page, $perPage);

    $images = $data['images'];
    $totalPages = $data['totalPages'];
        require_once 'app/views/admin/product_images/index.php';
    }

    // Hiển thị form thêm hình ảnh với danh sách sản phẩm
    public function create() {
        Auth::checkAdmin();
        $products = $this->productImgModel->getAllProducts();
        require_once 'app/views/admin/product_images/create.php';
    }

    // Xử lý thêm hình ảnh
    public function store() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $is_primary = isset($_POST['is_primary']) ? 1 : 0;
            $display_order = $_POST['display_order'] ?? 0;

            if (!$product_id || empty($_FILES['image']['name'])) {
                $_SESSION['error'] = "Vui lòng cung cấp đầy đủ thông tin";
                header("Location: " . BASE_URL . "admin/ProductImg/create"); // Giữ nguyên đường dẫn ban đầu
                exit();
            }

            // Sửa đường dẫn lưu ảnh
            $uploadDir = 'public/admin/assets/img/product-img/';
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Sửa image_url để lưu đường dẫn tương đối
                $image_url = 'admin/assets/img/product-img/' . $fileName;
                if ($this->productImgModel->create($product_id, $image_url, $is_primary, $display_order)) {
                    $_SESSION['success'] = "Thêm hình ảnh thành công";
                } else {
                    $_SESSION['error'] = "Lỗi khi thêm hình ảnh";
                }
            } else {
                $_SESSION['error'] = "Lỗi khi upload hình ảnh";
            }
            header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
            exit();
        }
    }

    // Hiển thị form sửa hình ảnh
    public function edit() {
        Auth::checkAdmin();
        $image_id = $_GET['image_id'] ?? null;
        if (!$image_id) {
            $_SESSION['error'] = "Vui lòng cung cấp image_id";
            header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
            exit();
        }
        $image = $this->productImgModel->getImageById($image_id);
        if (!$image) {
            $_SESSION['error'] = "Hình ảnh không tồn tại";
            header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
            exit();
        }
        // Sửa tên file view từ ProductImgedit.php thành product_images/edit.php
        require_once 'app/views/admin/product_images/edit.php';
    }

    // Xử lý cập nhật hình ảnh
    public function update() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_id = $_POST['image_id'] ?? null;
            $is_primary = isset($_POST['is_primary']) ? 1 : 0;
            $display_order = $_POST['display_order'] ?? 0;

            $image = $this->productImgModel->getImageById($image_id);
            if (!$image) {
                $_SESSION['error'] = "Hình ảnh không tồn tại";
                header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
                exit();
            }

            $image_url = $image['image_url'];
            if (!empty($_FILES['image']['name'])) {
                // Sửa đường dẫn lưu ảnh
                $uploadDir = 'public/admin/assets/img/product-img/';
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // Sửa image_url để lưu đường dẫn tương đối
                    $image_url = 'admin/assets/img/product-img/' . $fileName;
                    if (file_exists('public/' . $image['image_url'])) {
                        unlink('public/' . $image['image_url']);
                    }
                }
            }

            if ($this->productImgModel->update($image_id, $image_url, $is_primary, $display_order)) {
                $_SESSION['success'] = "Cập nhật hình ảnh thành công";
            } else {
                $_SESSION['error'] = "Lỗi khi cập nhật hình ảnh";
            }
            header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
            exit();
        }
    }

    // Xóa hình ảnh
    public function delete() {
        Auth::checkAdmin();
        $image_id = $_GET['image_id'] ?? null;
        if (!$image_id) {
            $_SESSION['error'] = "Vui lòng cung cấp image_id";
            header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
            exit();
        }
        $image = $this->productImgModel->getImageById($image_id);
        if ($image && $this->productImgModel->delete($image_id)) {
            if (file_exists('public/' . $image['image_url'])) {
                unlink('public/' . $image['image_url']);
            }
            $_SESSION['success'] = "Xóa hình ảnh thành công";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa hình ảnh";
        }
        header("Location: " . BASE_URL . "admin/ProductImg/index"); // Giữ nguyên đường dẫn ban đầu
        exit();
    }
}