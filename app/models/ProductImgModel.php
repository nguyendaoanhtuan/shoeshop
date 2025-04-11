<?php
class ProductImgModel {
    private $conn;
    private $table = "product_images";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả hình ảnh kèm thông tin sản phẩm
    public function getAllImagesWithProducts() {
        $query = "SELECT pi.*, p.name AS product_name 
                  FROM " . $this->table . " pi 
                  LEFT JOIN products p ON pi.product_id = p.product_id 
                  ORDER BY pi.product_id, pi.display_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả sản phẩm để hiển thị trong form thêm
    public function getAllProducts() {
        $query = "SELECT product_id, name FROM products ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy hình ảnh theo image_id
    public function getImageById($image_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE image_id = :image_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":image_id", $image_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm hình ảnh mới
    public function create($product_id, $image_url, $is_primary = false, $display_order = 0) {
        $query = "INSERT INTO " . $this->table . " 
                  (product_id, image_url, is_primary, display_order) 
                  VALUES (:product_id, :image_url, :is_primary, :display_order)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":is_primary", $is_primary, PDO::PARAM_BOOL);
        $stmt->bindParam(":display_order", $display_order);
        return $stmt->execute();
    }

    // Cập nhật hình ảnh
    public function update($image_id, $image_url, $is_primary, $display_order) {
        $query = "UPDATE " . $this->table . " 
                  SET image_url = :image_url, 
                      is_primary = :is_primary, 
                      display_order = :display_order 
                  WHERE image_id = :image_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":is_primary", $is_primary, PDO::PARAM_BOOL);
        $stmt->bindParam(":display_order", $display_order);
        $stmt->bindParam(":image_id", $image_id);
        return $stmt->execute();
    }

    // Xóa hình ảnh
    public function delete($image_id) {
        $query = "DELETE FROM " . $this->table . " WHERE image_id = :image_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":image_id", $image_id);
        return $stmt->execute();
    }

    // Lấy hình ảnh với phân trang và tìm kiếm theo tên sản phẩm
    public function getPaginatedImagesWithProducts($search = '', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        // Query cơ bản
        $query = "SELECT pi.*, p.name AS product_name 
                  FROM " . $this->table . " pi 
                  LEFT JOIN products p ON pi.product_id = p.product_id 
                  WHERE 1=1";

        // Thêm điều kiện tìm kiếm theo tên sản phẩm
        $params = [];
        if (!empty($search)) {
            $query .= " AND p.name LIKE :search";
            $params[':search'] = "%$search%";
        }

        // Đếm tổng số bản ghi
        $countQuery = "SELECT COUNT(*) 
                       FROM " . $this->table . " pi 
                       LEFT JOIN products p ON pi.product_id = p.product_id 
                       WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND p.name LIKE :search";
        }

        // Sắp xếp theo image_id tăng dần
        $query .= " ORDER BY pi.image_id ASC LIMIT :offset, :perPage";

        // Chuẩn bị câu lệnh đếm
        $countStmt = $this->conn->prepare($countQuery);
        if (!empty($search)) {
            $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();

        // Chuẩn bị câu lệnh chính
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);

        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'images' => $images,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ];
    }
}