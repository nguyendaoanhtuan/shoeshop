<?php
class BrandsModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy thương hiệu theo ID
    public function getBrandById($id) {
        $query = "SELECT * FROM brands WHERE brand_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm thương hiệu mới
    public function addBrand($data) {
        $query = "INSERT INTO brands (name, slug, description, logo_url, is_active) 
                  VALUES (:name, :slug, :description, :logo_url, :is_active)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':slug' => $this->createSlug($data['name']),
            ':description' => $data['description'] ?? null,
            ':logo_url' => $data['logo_url'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }

    // Cập nhật thương hiệu
    public function updateBrand($id, $data) {
        $query = "UPDATE brands SET 
                 name = :name,
                 slug = :slug,
                 description = :description,
                 logo_url = :logo_url,
                 is_active = :is_active
                 WHERE brand_id = :id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':slug' => $this->createSlug($data['name']),
            ':description' => $data['description'] ?? null,
            ':logo_url' => $data['logo_url'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }

    // Xóa thương hiệu
    public function deleteBrand($id) {
        $query = "DELETE FROM brands WHERE brand_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tạo slug từ tên thương hiệu
    private function createSlug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', "-", $slug);
        return $slug;
    }

    // Lấy thương hiệu với phân trang và tìm kiếm
    public function getPaginatedBrands($search = '', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        // Query cơ bản
        $query = "SELECT * FROM brands WHERE 1=1";

        // Thêm điều kiện tìm kiếm
        $params = [];
        if (!empty($search)) {
            $query .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }

        // Đếm tổng số bản ghi
        $countQuery = "SELECT COUNT(*) FROM brands WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND name LIKE :search";
        }

        // Sắp xếp theo brand_id tăng dần
        $query .= " ORDER BY brand_id ASC LIMIT :offset, :perPage";

        // Chuẩn bị câu lệnh đếm
        $countStmt = $this->db->prepare($countQuery);
        if (!empty($search)) {
            $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();

        // Chuẩn bị câu lệnh chính
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);

        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'brands' => $brands,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ];
    }
}
?>