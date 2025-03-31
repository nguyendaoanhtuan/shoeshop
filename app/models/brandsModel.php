<?php
class BrandsModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy tất cả thương hiệu
    public function getAllBrands() {
        $query = "SELECT * FROM brands ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
?>