<?php
class CategoryModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }


    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE category_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getParentName($parent_id) {
        if ($parent_id == 1) return 'nam';
        if ($parent_id == 2) return 'nu';
        return '';
    }
    

    // Thêm danh mục mới
    public function addCategory($data) {
        $slug = $this->createSlug($data['name'], $data['parent_id']);
        $query = "INSERT INTO categories (name, slug, parent_id, is_active) 
                  VALUES (:name, :slug, :parent_id, :is_active)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':slug' => $slug,
            ':parent_id' => $data['parent_id'] ?? null,
            ':is_active' => $data['is_active'] ?? 1
        ]);
    }
    


    // Cập nhật danh mục
    public function updateCategory($id, $data) {
        $slug = $this->createSlug($data['name'], $data['parent_id']);
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
            ':slug' => $slug,
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
    private function createSlug($name, $parent_id = null) {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        $parentSlug = $this->getParentName($parent_id);
        return $parentSlug ? $parentSlug . '-' . $slug : $slug;
    }


    // Lấy danh mục cha (Nam/Nữ)
    public function getParentCategories() {
        return [
            ['category_id' => 1, 'name' => 'Nam'],
            ['category_id' => 2, 'name' => 'Nữ']
        ];
    }


    // Lấy danh mục với phân trang và tìm kiếm
    public function getPaginatedCategories($search = '', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        // Query cơ bản
        $query = "SELECT * FROM categories WHERE 1=1";

        // Thêm điều kiện tìm kiếm
        $params = [];
        if (!empty($search)) {
            $query .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }

        // Đếm tổng số bản ghi
        $countQuery = "SELECT COUNT(*) FROM categories WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND name LIKE :search";
        }

        // Sắp xếp theo category_id tăng dần
        $query .= " ORDER BY category_id ASC LIMIT :offset, :perPage";

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
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'categories' => $categories,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ];
    }
}
?>