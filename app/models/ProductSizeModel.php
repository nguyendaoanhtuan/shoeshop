<?php
class ProductSizeModel {
    private $conn;
    private $table = "product_variants";

    public function __construct($db) {
        $this->conn = $db;
    }



    // Lấy tất cả sản phẩm để hiển thị trong form thêm
    public function getAllProducts() {
        $query = "SELECT product_id, name FROM products ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả kích thước từ bảng sizes để hiển thị trong form
    public function getAllSizes() {
        $query = "SELECT size_id, name FROM sizes ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách kích thước của một sản phẩm
    public function getSizesByProduct($product_id) {
        $query = "SELECT pv.variant_id, pv.size_id, s.name AS size_name 
                  FROM " . $this->table . " pv 
                  LEFT JOIN sizes s ON pv.size_id = s.size_id 
                  WHERE pv.product_id = :product_id 
                  ORDER BY s.name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm nhiều kích thước cho sản phẩm
    public function create($product_id, $size_ids) {
        $success = true;
        foreach ($size_ids as $size_id) {
            // Kiểm tra xem kích thước đã tồn tại cho sản phẩm chưa
            $query = "SELECT COUNT(*) FROM " . $this->table . " 
                      WHERE product_id = :product_id AND size_id = :size_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->bindParam(":size_id", $size_id);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                continue; // Bỏ qua nếu kích thước đã tồn tại
            }

            // Thêm kích thước mới
            $query = "INSERT INTO " . $this->table . " 
                      (product_id, size_id) 
                      VALUES (:product_id, :size_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->bindParam(":size_id", $size_id);
            if (!$stmt->execute()) {
                $success = false;
            }
        }
        return $success;
    }

    // Cập nhật kích thước: Xóa tất cả kích thước hiện tại và thêm lại các kích thước mới
    public function update($product_id, $size_ids) {
        // Xóa tất cả kích thước hiện tại của sản phẩm
        $query = "DELETE FROM " . $this->table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        // Thêm lại các kích thước mới
        return $this->create($product_id, $size_ids);
    }

    // Xóa tất cả kích thước của một sản phẩm
    public function deleteByProduct($product_id) {
        $query = "DELETE FROM " . $this->table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        return $stmt->execute();
    }

    // Lấy sản phẩm kèm kích thước với phân trang và tìm kiếm
    public function getPaginatedProductsWithSizes($search = '', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        // Query cơ bản để lấy danh sách sản phẩm
        $query = "SELECT product_id, name FROM products WHERE 1=1";

        // Thêm điều kiện tìm kiếm theo tên sản phẩm
        $params = [];
        if (!empty($search)) {
            $query .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }

        // Đếm tổng số bản ghi
        $countQuery = "SELECT COUNT(*) FROM products WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND name LIKE :search";
        }

        // Sắp xếp theo product_id tăng dần
        $query .= " ORDER BY product_id ASC LIMIT :offset, :perPage";

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
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy danh sách kích thước cho từng sản phẩm
        foreach ($products as &$product) {
            $query = "SELECT pv.variant_id, pv.size_id, s.name AS size_name 
                      FROM " . $this->table . " pv 
                      LEFT JOIN sizes s ON pv.size_id = s.size_id 
                      WHERE pv.product_id = :product_id 
                      ORDER BY s.name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $product['product_id']);
            $stmt->execute();
            $product['sizes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [
            'products' => $products,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ];
    }
}
?>