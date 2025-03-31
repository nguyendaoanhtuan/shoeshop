<?php
class CategoryModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE category_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục mới
    public function addCategory($data) {
        $query = "INSERT INTO categories (name, slug, parent_id, is_active) 
                  VALUES (:name, :slug, :parent_id, :is_active)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':slug' => $this->createSlug($data['name']),
            ':parent_id' => $data['parent_id'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }

    // Cập nhật danh mục
    public function updateCategory($id, $data) {
        $query = "UPDATE categories SET 
                 name = :name,
                 slug = :slug,
                 parent_id = :parent_id,
                 is_active = :is_active
                 WHERE category_id = :id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':slug' => $this->createSlug($data['name']),
            ':parent_id' => $data['parent_id'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        $query = "DELETE FROM categories WHERE category_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tạo slug từ tên danh mục
    private function createSlug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', "-", $slug);
        return $slug;
    }

    // Lấy danh mục cha (Nam/Nữ)
    public function getParentCategories() {
        return [
            ['category_id' => 1, 'name' => 'Nam'],
            ['category_id' => 2, 'name' => 'Nữ']
        ];
    }
}
?>